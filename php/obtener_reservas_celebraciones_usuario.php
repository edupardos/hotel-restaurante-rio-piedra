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
                id_reserva_celebracion,
                tipo_celebracion,
                fecha_celebracion,
                num_personas,
                observaciones,
                precio_estimado,
                estado
            FROM reservas_celebraciones
            WHERE id_usuario = :id_usuario
            ORDER BY fecha_reserva DESC";

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
        'message' => 'Error al obtener las reservas de celebraciones: ' . $e->getMessage()
    ]);
}