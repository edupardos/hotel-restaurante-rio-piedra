<?php
session_start();
header('Content-Type: application/json');

require_once 'conexion.php';
require_once 'enviar_correo.php';

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Debes iniciar sesión'
    ]);
    exit;
}

$idUsuario = $_SESSION['id_usuario'];

$idReserva = $_POST['id_reserva'] ?? null;
$tipo = $_POST['tipo'] ?? '';

if (!$idReserva || !$tipo) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos inválidos'
    ]);
    exit;
}

try {
    switch ($tipo) {
        case 'hotel':
            $sqlDatos = "
                SELECT 
                    u.nombre,
                    u.apellidos,
                    u.correo,
                    rh.fecha_entrada,
                    rh.fecha_salida,
                    h.tipo AS tipo_habitacion
                FROM reservas_hotel rh
                INNER JOIN usuarios u ON rh.id_usuario = u.id_usuario
                INNER JOIN habitaciones h ON rh.id_habitacion = h.id_habitacion
                WHERE rh.id_reserva_hotel = :id
                AND rh.id_usuario = :id_usuario
            ";

            $sqlUpdate = "
                UPDATE reservas_hotel
                SET estado = 'anulada'
                WHERE id_reserva_hotel = :id
                AND id_usuario = :id_usuario
            ";
            break;

        case 'restaurante':
            $sqlDatos = "
                SELECT 
                    u.nombre,
                    u.apellidos,
                    u.correo,
                    rr.fecha_hora,
                    rr.num_personas
                FROM reservas_restaurante rr
                INNER JOIN usuarios u ON rr.id_usuario = u.id_usuario
                WHERE rr.id_reserva_restaurante = :id
                AND rr.id_usuario = :id_usuario
            ";

            $sqlUpdate = "
                UPDATE reservas_restaurante
                SET estado = 'anulada'
                WHERE id_reserva_restaurante = :id
                AND id_usuario = :id_usuario
            ";
            break;

        case 'celebraciones':
            $sqlDatos = "
                SELECT 
                    u.nombre,
                    u.apellidos,
                    u.correo,
                    rc.tipo_celebracion,
                    rc.fecha_celebracion,
                    rc.num_personas
                FROM reservas_celebraciones rc
                INNER JOIN usuarios u ON rc.id_usuario = u.id_usuario
                WHERE rc.id_reserva_celebracion = :id
                AND rc.id_usuario = :id_usuario
            ";

            $sqlUpdate = "
                UPDATE reservas_celebraciones
                SET estado = 'anulada'
                WHERE id_reserva_celebracion = :id
                AND id_usuario = :id_usuario
            ";
            break;

        default:
            echo json_encode([
                'success' => false,
                'message' => 'Tipo de reserva inválido'
            ]);
            exit;
    }

    $stmtDatos = $conexion->prepare($sqlDatos);
    $stmtDatos->bindParam(':id', $idReserva, PDO::PARAM_INT);
    $stmtDatos->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
    $stmtDatos->execute();

    $reserva = $stmtDatos->fetch(PDO::FETCH_ASSOC);

    if (!$reserva) {
        echo json_encode([
            'success' => false,
            'message' => 'Reserva no encontrada o no pertenece a tu usuario'
        ]);
        exit;
    }

    $stmtUpdate = $conexion->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':id', $idReserva, PDO::PARAM_INT);
    $stmtUpdate->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
    $stmtUpdate->execute();

    $nombreCompleto = $reserva['nombre'] . ' ' . $reserva['apellidos'];
    $asunto = "Reserva anulada - Hotel Restaurante Rio Piedra";

    if ($tipo === 'hotel') {
        $detalleReserva = "
            <p><strong>Tipo de reserva:</strong> Hotel</p>
            <p><strong>Habitación:</strong> {$reserva['tipo_habitacion']}</p>
            <p><strong>Fecha de entrada:</strong> {$reserva['fecha_entrada']}</p>
            <p><strong>Fecha de salida:</strong> {$reserva['fecha_salida']}</p>
        ";
    } elseif ($tipo === 'restaurante') {
        $detalleReserva = "
            <p><strong>Tipo de reserva:</strong> Restaurante</p>
            <p><strong>Fecha y hora:</strong> {$reserva['fecha_hora']}</p>
            <p><strong>Número de personas:</strong> {$reserva['num_personas']}</p>
        ";
    } else {
        $detalleReserva = "
            <p><strong>Tipo de reserva:</strong> Celebración</p>
            <p><strong>Celebración:</strong> {$reserva['tipo_celebracion']}</p>
            <p><strong>Fecha:</strong> {$reserva['fecha_celebracion']}</p>
            <p><strong>Número de personas:</strong> {$reserva['num_personas']}</p>
        ";
    }

    $mensaje = "
        <h2>Reserva anulada</h2>

        <p>Hola {$nombreCompleto},</p>

        <p>Te informamos de que tu reserva ha sido <strong>anulada</strong>.</p>

        {$detalleReserva}

        <p><strong>Estado actual:</strong> Anulada</p>

        <p>Gracias por confiar en Hotel Restaurante Río Piedra.</p>
    ";

    enviarCorreoReserva($reserva['correo'], $nombreCompleto, $asunto, $mensaje);

    echo json_encode([
        'success' => true,
        'message' => 'Reserva cancelada correctamente'
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al cancelar la reserva'
    ]);
}
?>