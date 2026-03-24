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
$fecha_hora = trim($_POST['fecha_hora'] ?? '');
$num_personas = (int) ($_POST['num_personas'] ?? 0);
$correo = trim($_POST['correo'] ?? '');
$observaciones = trim($_POST['observaciones'] ?? '');

if (
    empty($nombre) ||
    empty($apellidos) ||
    empty($telefono) ||
    empty($fecha_hora) ||
    empty($correo) ||
    $num_personas <= 0
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

$fechaReserva = DateTime::createFromFormat('Y-m-d\TH:i', $fecha_hora);

if (!$fechaReserva) {
    echo json_encode([
        'success' => false,
        'message' => 'La fecha y hora no tienen un formato válido'
    ]);
    exit;
}

$ahora = new DateTime();

if ($fechaReserva < $ahora) {
    echo json_encode([
        'success' => false,
        'message' => 'No puedes realizar una reserva en una fecha y hora anteriores a la actual'
    ]);
    exit;
}

$fechaHoraSQL = $fechaReserva->format('Y-m-d H:i:s');

try {
    $sql = "INSERT INTO reservas_restaurante 
            (id_usuario, fecha_hora, num_personas, observaciones, estado)
            VALUES
            (:id_usuario, :fecha_hora, :num_personas, :observaciones, 'pendiente')";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->bindParam(':fecha_hora', $fechaHoraSQL, PDO::PARAM_STR);
    $stmt->bindParam(':num_personas', $num_personas, PDO::PARAM_INT);
    $stmt->bindParam(':observaciones', $observaciones, PDO::PARAM_STR);

    $stmt->execute();

    $asunto = "Solicitud de reserva recibida - Restaurante";

    $mensaje = "
        <h2>Reserva recibida correctamente</h2>
        <p>Hola <strong>$nombre</strong>,</p>
        <p>Hemos recibido tu reserva en el restaurante del <strong>Hotel Rio Piedra</strong>.</p>
        <ul>
            <li><strong>Fecha y hora:</strong> $fechaHoraSQL</li>
            <li><strong>Número de personas:</strong> $num_personas</li>
        </ul>
        <p>Esto es un correo de confirmación, por favor, no contestes a este correo.</p>
        <p>Gracias por confiar en nosotros.</p>
    ";

    enviarCorreoReserva($correo, $nombre, $asunto, $mensaje);

    echo json_encode([
        'success' => true,
        'message' => 'Reserva de restaurante realizada correctamente'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al guardar la reserva',
        'error' => $e->getMessage()
    ]);
}