<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode([
        'success' => false,
        'message' => 'No hay sesión iniciada'
    ]);
    exit;
}

$idUsuario = $_SESSION['id_usuario'];

try {
    $sql = "SELECT nombre, apellidos, telefono, foto_perfil, correo, direccion
            FROM usuarios
            WHERE id_usuario = :id_usuario";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        echo json_encode([
            'success' => true,
            'usuario' => [
                'nombre' => $usuario['nombre'] ?? '',
                'apellidos' => $usuario['apellidos'] ?? '',
                'telefono' => $usuario['telefono'] ?? '',
                'foto_perfil' => $usuario['foto_perfil'] ?? '',
                'correo' => $usuario['correo'] ?? '',
                'direccion' => $usuario['direccion'] ?? ''
            ]
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Usuario no encontrado'
        ]);
    }

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener el perfil'
    ]);
}
?>