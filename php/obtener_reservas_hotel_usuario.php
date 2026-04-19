<?php
session_start();
header('Content-Type: application/json');

require_once 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Usuario no autenticado'
    ]);
    exit;
}

$id_usuario = (int) $_SESSION['id_usuario'];

try {
    $sql = "SELECT 
                rh.id_reserva_hotel,
                rh.fecha_entrada,
                rh.fecha_salida,
                rh.observaciones,
                rh.precio_total,
                rh.estado,
                rh.check_in,
                h.tipo AS tipo_habitacion
            FROM reservas_hotel rh
            INNER JOIN habitaciones h ON rh.id_habitacion = h.id_habitacion
            WHERE rh.id_usuario = :id_usuario
            ORDER BY rh.fecha_reserva DESC";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();

    $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'reservas' => $reservas
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener las reservas de hotel: ' . $e->getMessage()
    ]);
}