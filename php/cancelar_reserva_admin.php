<?php
session_start();
header('Content-Type: application/json');

require_once 'conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {

    echo json_encode([
        'success' => false,
        'message' => 'No autorizado'
    ]);

    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$idReserva = $data['id_reserva'] ?? null;
$tipo = $data['tipo'] ?? '';

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

            $sql = "
                UPDATE reservas_hotel
                SET estado = 'anulada'
                WHERE id_reserva_hotel = :id
            ";

            break;

        case 'restaurante':

            $sql = "
                UPDATE reservas_restaurante
                SET estado = 'anulada'
                WHERE id_reserva_restaurante = :id
            ";

            break;

        case 'celebracion':

            $sql = "
                UPDATE reservas_celebraciones
                SET estado = 'anulada'
                WHERE id_reserva_celebracion = :id
            ";

            break;

        default:

            echo json_encode([
                'success' => false,
                'message' => 'Tipo inválido'
            ]);

            exit;
    }

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(':id', $idReserva);

    $stmt->execute();

    echo json_encode([
        'success' => true,
        'message' => 'Reserva cancelada correctamente'
    ]);

} catch (PDOException $e) {

    echo json_encode([
        'success' => false,
        'message' => 'Error al cancelar reserva'
    ]);
}