<?php
session_start();
header('Content-Type: application/json');

require_once 'conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {

    echo json_encode([
        'success' => false
    ]);

    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$busqueda = trim($data['busqueda'] ?? '');
$filtro = trim($data['filtro'] ?? 'todos');

try {

    $reservas = [];

    // HOTEL
    if ($filtro === 'todos' || $filtro === 'hotel') {

        $sqlHotel = "
            SELECT
                rh.id_reserva_hotel AS id_reserva,
                u.nombre,
                u.apellidos,
                u.correo,
                'Hotel' AS tipo_reserva,
                CONCAT(rh.fecha_entrada, ' → ', rh.fecha_salida) AS fechas,
                rh.estado,
                'hotel' AS tipo
            FROM reservas_hotel rh
            INNER JOIN usuarios u
                ON rh.id_usuario = u.id_usuario
            WHERE
                u.nombre LIKE :busqueda
                OR u.apellidos LIKE :busqueda
                OR u.correo LIKE :busqueda
        ";

        $stmtHotel = $conexion->prepare($sqlHotel);

        $stmtHotel->execute([
            ':busqueda' => "%$busqueda%"
        ]);

        $reservas = array_merge(
            $reservas,
            $stmtHotel->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    // RESTAURANTE
    if ($filtro === 'todos' || $filtro === 'restaurante') {

        $sqlRestaurante = "
            SELECT
                rr.id_reserva_restaurante AS id_reserva,
                u.nombre,
                u.apellidos,
                u.correo,
                'Restaurante' AS tipo_reserva,
                rr.fecha_hora AS fechas,
                rr.estado,
                'restaurante' AS tipo
            FROM reservas_restaurante rr
            INNER JOIN usuarios u
                ON rr.id_usuario = u.id_usuario
            WHERE
                u.nombre LIKE :busqueda
                OR u.apellidos LIKE :busqueda
                OR u.correo LIKE :busqueda
        ";

        $stmtRestaurante = $conexion->prepare($sqlRestaurante);

        $stmtRestaurante->execute([
            ':busqueda' => "%$busqueda%"
        ]);

        $reservas = array_merge(
            $reservas,
            $stmtRestaurante->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    // CELEBRACIONES
    if ($filtro === 'todos' || $filtro === 'celebracion') {

        $sqlCelebraciones = "
            SELECT
                rc.id_reserva_celebracion AS id_reserva,
                u.nombre,
                u.apellidos,
                u.correo,
                'Celebración' AS tipo_reserva,
                rc.fecha_celebracion AS fechas,
                rc.estado,
                'celebracion' AS tipo
            FROM reservas_celebraciones rc
            INNER JOIN usuarios u
                ON rc.id_usuario = u.id_usuario
            WHERE
                u.nombre LIKE :busqueda
                OR u.apellidos LIKE :busqueda
                OR u.correo LIKE :busqueda
        ";

        $stmtCelebraciones = $conexion->prepare($sqlCelebraciones);

        $stmtCelebraciones->execute([
            ':busqueda' => "%$busqueda%"
        ]);

        $reservas = array_merge(
            $reservas,
            $stmtCelebraciones->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    echo json_encode([
        'success' => true,
        'reservas' => $reservas
    ]);

} catch (PDOException $e) {

    echo json_encode([
        'success' => false
    ]);
}