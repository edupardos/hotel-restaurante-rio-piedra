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

$idUsuario = $data['id_usuario'] ?? null;

if (!$idUsuario) {

    echo json_encode([
        'success' => false,
        'message' => 'ID inválido'
    ]);

    exit;
}

// EVITAR BORRARSE A SÍ MISMO
if ($idUsuario == $_SESSION['id_usuario']) {

    echo json_encode([
        'success' => false,
        'message' => 'No puedes eliminarte a ti mismo'
    ]);

    exit;
}

try {

    $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(':id_usuario', $idUsuario);

    $stmt->execute();

    echo json_encode([
        'success' => true,
        'message' => 'Usuario eliminado correctamente'
    ]);

} catch (PDOException $e) {

    echo json_encode([
        'success' => false,
        'message' => 'Error al eliminar usuario'
    ]);
}