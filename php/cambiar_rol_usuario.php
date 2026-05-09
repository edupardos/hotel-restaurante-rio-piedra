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

try {

    // OBTENER ROL ACTUAL
    $sql = "SELECT rol FROM usuarios WHERE id_usuario = :id_usuario";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(':id_usuario', $idUsuario);

    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {

        echo json_encode([
            'success' => false,
            'message' => 'Usuario no encontrado'
        ]);

        exit;
    }

    $nuevoRol = $usuario['rol'] === 'admin'
        ? 'usuario'
        : 'admin';

    // ACTUALIZAR
    $sqlUpdate = "
        UPDATE usuarios
        SET rol = :rol
        WHERE id_usuario = :id_usuario
    ";

    $stmtUpdate = $conexion->prepare($sqlUpdate);

    $stmtUpdate->bindParam(':rol', $nuevoRol);
    $stmtUpdate->bindParam(':id_usuario', $idUsuario);

    $stmtUpdate->execute();

    echo json_encode([
        'success' => true,
        'message' => 'Rol actualizado correctamente'
    ]);

} catch (PDOException $e) {

    echo json_encode([
        'success' => false,
        'message' => 'Error al actualizar rol'
    ]);
}