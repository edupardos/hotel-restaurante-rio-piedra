<?php
session_start();
header('Content-Type: application/json');

require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
    exit;
}

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Usuario no autenticado'
    ]);
    exit;
}

$id_usuario = (int) $_SESSION['id_usuario'];
$tipo = trim($_POST['tipo'] ?? '');
$id_reserva = isset($_POST['id_reserva']) ? (int) $_POST['id_reserva'] : 0;

if ($tipo === '' || $id_reserva <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos'
    ]);
    exit;
}

try {
    switch ($tipo) {
        case 'hotel':
            $tabla = 'reservas_hotel';
            $campoId = 'id_reserva_hotel';
            break;

        case 'restaurante':
            $tabla = 'reservas_restaurante';
            $campoId = 'id_reserva_restaurante';
            break;

        case 'celebraciones':
            $tabla = 'reservas_celebraciones';
            $campoId = 'id_reserva_celebracion';
            break;

        default:
            echo json_encode([
                'success' => false,
                'message' => 'Tipo de reserva no válido'
            ]);
            exit;
    }

    $sqlComprobar = "SELECT estado 
                     FROM $tabla
                     WHERE $campoId = :id_reserva
                     AND id_usuario = :id_usuario";

    $stmtComprobar = $conexion->prepare($sqlComprobar);
    $stmtComprobar->bindParam(':id_reserva', $id_reserva, PDO::PARAM_INT);
    $stmtComprobar->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmtComprobar->execute();

    $reserva = $stmtComprobar->fetch(PDO::FETCH_ASSOC);

    if (!$reserva) {
        echo json_encode([
            'success' => false,
            'message' => 'La reserva no existe o no pertenece al usuario'
        ]);
        exit;
    }

    if ($reserva['estado'] === 'anulada') {
        echo json_encode([
            'success' => false,
            'message' => 'La reserva ya está anulada'
        ]);
        exit;
    }

    $sqlActualizar = "UPDATE $tabla
                      SET estado = 'anulada'
                      WHERE $campoId = :id_reserva
                      AND id_usuario = :id_usuario";

    $stmtActualizar = $conexion->prepare($sqlActualizar);
    $stmtActualizar->bindParam(':id_reserva', $id_reserva, PDO::PARAM_INT);
    $stmtActualizar->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmtActualizar->execute();

    echo json_encode([
        'success' => true,
        'message' => 'Reserva cancelada correctamente'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al cancelar la reserva: ' . $e->getMessage()
    ]);
}