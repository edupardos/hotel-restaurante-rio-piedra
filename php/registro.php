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

$nombre = trim($_POST['nombre'] ?? '');
$apellidos = trim($_POST['apellidos'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($nombre) || empty($apellidos) || empty($correo) || empty($password)) {
    echo json_encode([
        'success' => false,
        'message' => 'Todos los campos son obligatorios'
    ]);
    exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'El correo no es válido'
    ]);
    exit;
}

try {
    $sqlComprobar = "SELECT id_usuario FROM usuarios WHERE correo = :correo";
    $stmtComprobar = $conexion->prepare($sqlComprobar);
    $stmtComprobar->bindParam(':correo', $correo);
    $stmtComprobar->execute();

    if ($stmtComprobar->fetch()) {
        echo json_encode([
            'success' => false,
            'message' => 'Ya existe un usuario con ese correo'
        ]);
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sqlInsertar = "INSERT INTO usuarios (nombre, apellidos, correo, password, rol)
                    VALUES (:nombre, :apellidos, :correo, :password, 'usuario')";

    $stmtInsertar = $conexion->prepare($sqlInsertar);
    $stmtInsertar->bindParam(':nombre', $nombre);
    $stmtInsertar->bindParam(':apellidos', $apellidos);
    $stmtInsertar->bindParam(':correo', $correo);
    $stmtInsertar->bindParam(':password', $passwordHash);
    $stmtInsertar->execute();

    $idUsuario = $conexion->lastInsertId();

    $_SESSION['id_usuario'] = $idUsuario;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['apellidos'] = $apellidos;
    $_SESSION['correo'] = $correo;
    $_SESSION['rol'] = 'usuario';

    echo json_encode([
        'success' => true,
        'message' => 'Usuario registrado correctamente'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al registrar el usuario'
    ]);
}
?>