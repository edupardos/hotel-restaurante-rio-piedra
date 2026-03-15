<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['id_usuario'])) {
    echo json_encode([
        'success' => true,
        'usuario' => [
            'id_usuario' => $_SESSION['id_usuario'],
            'nombre' => $_SESSION['nombre'],
            'apellidos' => $_SESSION['apellidos'],
            'correo' => $_SESSION['correo'],
            'rol' => $_SESSION['rol']
        ]
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No hay sesión iniciada'
    ]);
}
?>