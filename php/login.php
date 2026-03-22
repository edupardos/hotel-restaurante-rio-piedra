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

$correo = trim($_POST['correo'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($correo) || empty($password)) {
    echo json_encode([
        'success' => false,
        'message' => 'Debes rellenar todos los campos'
    ]);
    exit;
}

try {
    $sql = "SELECT id_usuario, nombre, apellidos, correo, password, rol, foto_perfil
            FROM usuarios
            WHERE correo = :correo";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo json_encode([
            'success' => false,
            'message' => 'Correo o contraseña incorrectos'
        ]);
        exit;
    }

    if (!password_verify($password, $usuario['password'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Correo o contraseña incorrectos'
        ]);
        exit;
    }

    $_SESSION['id_usuario'] = $usuario['id_usuario'];
    $_SESSION['nombre'] = $usuario['nombre'];
    $_SESSION['apellidos'] = $usuario['apellidos'];
    $_SESSION['correo'] = $usuario['correo'];
    $_SESSION['rol'] = $usuario['rol'];
    $_SESSION['foto_perfil'] = $usuario['foto_perfil'] ?? '';

    echo json_encode([
        'success' => true,
        'message' => 'Login correcto'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al iniciar sesión'
    ]);
}
?>