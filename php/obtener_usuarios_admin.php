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

$busqueda = trim($data['busqueda'] ?? '');
$filtro = trim($data['filtro'] ?? 'todos');

try {

    $sql = "
        SELECT 
            id_usuario,
            nombre,
            apellidos,
            correo,
            rol
        FROM usuarios
        WHERE 1=1
    ";

    $params = [];

    // FILTRO ROL
    if ($filtro !== 'todos') {

        $sql .= " AND rol = :rol";
        $params[':rol'] = $filtro;
    }

    // BÚSQUEDA
    if (!empty($busqueda)) {

        $sql .= "
            AND (
                nombre LIKE :busqueda
                OR apellidos LIKE :busqueda
                OR correo LIKE :busqueda
            )
        ";

        $params[':busqueda'] = "%$busqueda%";
    }

    $sql .= " ORDER BY nombre ASC";

    $stmt = $conexion->prepare($sql);

    $stmt->execute($params);

    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'usuarios' => $usuarios
    ]);

} catch (PDOException $e) {

    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener usuarios'
    ]);
}