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

$nombre = trim($_POST['nombre'] ?? '');
$apellidos = trim($_POST['apellidos'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');

if (empty($nombre) || empty($apellidos) || empty($correo)) {
    echo json_encode([
        'success' => false,
        'message' => 'Nombre, apellidos y correo son obligatorios'
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
    $sqlCorreo = "SELECT id_usuario 
                  FROM usuarios 
                  WHERE correo = :correo 
                  AND id_usuario != :id_usuario";

    $stmtCorreo = $conexion->prepare($sqlCorreo);
    $stmtCorreo->bindParam(':correo', $correo);
    $stmtCorreo->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
    $stmtCorreo->execute();

    if ($stmtCorreo->fetch()) {
        echo json_encode([
            'success' => false,
            'message' => 'Ese correo ya está siendo usado por otro usuario'
        ]);
        exit;
    }

    $fotoPerfil = null;

    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === 0) {
        $carpetaDestino = "../img/perfil/";

        if (!is_dir($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }

        $extension = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
        $nombreArchivo = "perfil_" . $idUsuario . "_" . time() . "." . strtolower($extension);
        $rutaFinal = $carpetaDestino . $nombreArchivo;

        if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaFinal)) {
            $fotoPerfil = $nombreArchivo;
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No se pudo guardar la imagen'
            ]);
            exit;
        }
    }

    if ($fotoPerfil !== null) {
        $sql = "UPDATE usuarios
                SET nombre = :nombre,
                    apellidos = :apellidos,
                    telefono = :telefono,
                    correo = :correo,
                    direccion = :direccion,
                    foto_perfil = :foto_perfil
                WHERE id_usuario = :id_usuario";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':foto_perfil', $fotoPerfil);
    } else {
        $sql = "UPDATE usuarios
                SET nombre = :nombre,
                    apellidos = :apellidos,
                    telefono = :telefono,
                    correo = :correo,
                    direccion = :direccion
                WHERE id_usuario = :id_usuario";

        $stmt = $conexion->prepare($sql);
    }

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellidos', $apellidos);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute();

    $_SESSION['nombre'] = $nombre;
    $_SESSION['apellidos'] = $apellidos;
    $_SESSION['correo'] = $correo;

    if ($fotoPerfil !== null) {
        $_SESSION['foto_perfil'] = $fotoPerfil;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Perfil actualizado correctamente',
        'foto_perfil' => $fotoPerfil
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al actualizar el perfil'
    ]);
}
?>