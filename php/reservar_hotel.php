<?php
session_start();
header('Content-Type: application/json');

require_once 'conexion.php';
require_once 'enviar_correo.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
    exit;
}

if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Debes iniciar sesión para poder reservar'
    ]);
    exit;
}

$id_usuario = (int) $_SESSION['id_usuario'];

$nombre = trim($_POST['nombre'] ?? '');
$apellidos = trim($_POST['apellidos'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$tipo_habitacion = trim($_POST['tipo_habitacion'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$fecha_entrada = trim($_POST['fecha_entrada'] ?? '');
$fecha_salida = trim($_POST['fecha_salida'] ?? '');
$observaciones = trim($_POST['observaciones'] ?? '');

if (
    empty($nombre) ||
    empty($apellidos) ||
    empty($telefono) ||
    empty($tipo_habitacion) ||
    empty($correo) ||
    empty($direccion) ||
    empty($fecha_entrada) ||
    empty($fecha_salida)
) {
    echo json_encode([
        'success' => false,
        'message' => 'Debes rellenar todos los campos obligatorios'
    ]);
    exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'El correo electrónico no es válido'
    ]);
    exit;
}

$entrada = DateTime::createFromFormat('Y-m-d', $fecha_entrada);
$salida = DateTime::createFromFormat('Y-m-d', $fecha_salida);
$hoy = new DateTime('today');

if (!$entrada || !$salida) {
    echo json_encode([
        'success' => false,
        'message' => 'Las fechas no tienen un formato válido'
    ]);
    exit;
}

if ($entrada < $hoy) {
    echo json_encode([
        'success' => false,
        'message' => 'La fecha de entrada no puede ser anterior a la actual'
    ]);
    exit;
}

if ($salida <= $entrada) {
    echo json_encode([
        'success' => false,
        'message' => 'La fecha de salida debe ser posterior a la fecha de entrada'
    ]);
    exit;
}

$intervalo = $entrada->diff($salida);
$num_noches = (int) $intervalo->days;

if ($num_noches <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'El número de noches no es válido'
    ]);
    exit;
}

try {
    $sqlHabitacionDisponible = "
        SELECT h.id_habitacion, h.precio_noche
        FROM habitaciones h
        WHERE h.tipo = :tipo
          AND h.id_habitacion NOT IN (
              SELECT rh.id_habitacion
              FROM reservas_hotel rh
              WHERE rh.estado != 'anulada'
                AND rh.fecha_entrada < :fecha_salida
                AND rh.fecha_salida > :fecha_entrada
          )
        ORDER BY h.id_habitacion ASC
        LIMIT 1
    ";

    $stmtHabitacion = $conexion->prepare($sqlHabitacionDisponible);
    $stmtHabitacion->bindParam(':tipo', $tipo_habitacion, PDO::PARAM_STR);
    $stmtHabitacion->bindParam(':fecha_entrada', $fecha_entrada, PDO::PARAM_STR);
    $stmtHabitacion->bindParam(':fecha_salida', $fecha_salida, PDO::PARAM_STR);
    $stmtHabitacion->execute();

    $habitacion = $stmtHabitacion->fetch(PDO::FETCH_ASSOC);

    if (!$habitacion) {
        echo json_encode([
            'success' => false,
            'message' => 'No hay habitaciones disponibles del tipo seleccionado para las fechas indicadas'
        ]);
        exit;
    }

    $id_habitacion = (int) $habitacion['id_habitacion'];
    $precio_noche = (float) $habitacion['precio_noche'];
    $precio_total = $precio_noche * $num_noches;

    $sqlReserva = "INSERT INTO reservas_hotel
                   (id_usuario, id_habitacion, fecha_entrada, fecha_salida, observaciones, precio_total, estado, check_in)
                   VALUES
                   (:id_usuario, :id_habitacion, :fecha_entrada, :fecha_salida, :observaciones, :precio_total, 'pendiente', 0)";

    $stmtReserva = $conexion->prepare($sqlReserva);
    $stmtReserva->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmtReserva->bindParam(':id_habitacion', $id_habitacion, PDO::PARAM_INT);
    $stmtReserva->bindParam(':fecha_entrada', $fecha_entrada, PDO::PARAM_STR);
    $stmtReserva->bindParam(':fecha_salida', $fecha_salida, PDO::PARAM_STR);
    $stmtReserva->bindParam(':observaciones', $observaciones, PDO::PARAM_STR);
    $stmtReserva->bindParam(':precio_total', $precio_total);

    $stmtReserva->execute();

    $tipo_habitacion_mostrar = match ($tipo_habitacion) {
        'individual' => 'Habitación individual',
        'doble' => 'Habitación doble',
        'doble_superior' => 'Habitación doble superior',
        'suite' => 'Suite',
        default => $tipo_habitacion
    };

    $asunto = "Solicitud de reserva recibida - Hotel";

    $mensaje = "
        <h2>Reserva recibida correctamente</h2>
        <p>Hola <strong>$nombre</strong>,</p>
        <p>Hemos recibido tu reserva en el <strong>Hotel Río Piedra</strong>.</p>
        <ul>
            <li><strong>Tipo de habitación:</strong> $tipo_habitacion_mostrar</li>
            <li><strong>Habitación asignada:</strong> $id_habitacion</li>
            <li><strong>Fecha de entrada:</strong> $fecha_entrada</li>
            <li><strong>Fecha de salida:</strong> $fecha_salida</li>
            <li><strong>Número de noches:</strong> $num_noches</li>
            <li><strong>Precio total:</strong> " . number_format($precio_total, 2, ',', '.') . " €</li>
        </ul>
        <p>Esto es un correo de confirmación, por favor, no contestes a este correo.</p>
        <p>Gracias por confiar en nosotros.</p>
    ";

    enviarCorreoReserva($correo, $nombre, $asunto, $mensaje);

    echo json_encode([
        'success' => true,
        'message' => 'Reserva de hotel realizada correctamente'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al guardar la reserva',
        'error' => $e->getMessage()
    ]);
}