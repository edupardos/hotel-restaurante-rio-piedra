<?php
session_start();
header('Content-Type: application/json');

require_once 'conexion.php';
require_once 'enviar_correo.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
    exit;
}

if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Debes iniciar sesión para poder solicitar una celebración'
    ]);
    exit;
}

$id_usuario = (int) $_SESSION['id_usuario'];

$nombre = trim($_POST['nombre'] ?? '');
$apellidos = trim($_POST['apellidos'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$tipo_celebracion = trim($_POST['tipo_celebracion'] ?? '');
$fecha_celebracion = trim($_POST['fecha_celebracion'] ?? '');
$num_personas = (int) ($_POST['num_personas'] ?? 0);
$correo = trim($_POST['correo'] ?? '');
$observaciones = trim($_POST['observaciones'] ?? '');

if (
    empty($nombre) ||
    empty($apellidos) ||
    empty($telefono) ||
    empty($tipo_celebracion) ||
    empty($fecha_celebracion) ||
    empty($correo) ||
    $num_personas <= 0
) {
    echo json_encode([
        'success' => false,
        'message' => 'Debes rellenar todos los campos obligatorios'
    ]);
    exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'El correo electrónico no es válido'
    ]);
    exit;
}

$fechaCelebracionObj = DateTime::createFromFormat('Y-m-d', $fecha_celebracion);
$hoy = new DateTime('today');

if (!$fechaCelebracionObj) {
    echo json_encode([
        'success' => false,
        'message' => 'La fecha de la celebración no tiene un formato válido'
    ]);
    exit;
}

if ($fechaCelebracionObj < $hoy) {
    echo json_encode([
        'success' => false,
        'message' => 'No puedes solicitar una celebración en una fecha anterior a la actual'
    ]);
    exit;
}

$precio_por_persona = 0;

switch ($tipo_celebracion) {
    case 'boda':
        $precio_por_persona = 120;
        break;
    case 'bautizo':
        $precio_por_persona = 70;
        break;
    case 'comunion':
        $precio_por_persona = 85;
        break;
    default:
        echo json_encode([
            'success' => false,
            'message' => 'El tipo de celebración no es válido'
        ]);
        exit;
}

$precio_estimado = $precio_por_persona * $num_personas;

try {
    $sql = "INSERT INTO reservas_celebraciones
            (id_usuario, tipo_celebracion, fecha_celebracion, num_personas, observaciones, precio_estimado, estado)
            VALUES
            (:id_usuario, :tipo_celebracion, :fecha_celebracion, :num_personas, :observaciones, :precio_estimado, 'pendiente')";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->bindParam(':tipo_celebracion', $tipo_celebracion, PDO::PARAM_STR);
    $stmt->bindParam(':fecha_celebracion', $fecha_celebracion, PDO::PARAM_STR);
    $stmt->bindParam(':num_personas', $num_personas, PDO::PARAM_INT);
    $stmt->bindParam(':observaciones', $observaciones, PDO::PARAM_STR);
    $stmt->bindParam(':precio_estimado', $precio_estimado);

    $stmt->execute();

    $tipoCelebracionMostrar = match ($tipo_celebracion) {
        'boda' => 'Boda',
        'bautizo' => 'Bautizo',
        'comunion' => 'Comunión',
        default => $tipo_celebracion
    };

    $asunto = "Solicitud de celebracion recibida";

    $mensaje = "
        <h2>Solicitud de celebración recibida correctamente</h2>
        <p>Hola <strong>$nombre</strong>,</p>
        <p>Hemos recibido tu solicitud de celebración en el <strong>Hotel Río Piedra</strong>.</p>
        <ul>
            <li><strong>Tipo de celebración:</strong> $tipoCelebracionMostrar</li>
            <li><strong>Fecha:</strong> $fecha_celebracion</li>
            <li><strong>Número de personas:</strong> $num_personas</li>
            <li><strong>Precio estimado:</strong> " . number_format($precio_estimado, 2, ',', '.') . " €</li>
        </ul>
        <p>En breve nos pondremos en contacto contigo para concretar todos los detalles.</p>
        <p>Esto es un correo automático, por favor, no contestes a este mensaje.</p>
        <p>Gracias por confiar en nosotros.</p>
    ";

    enviarCorreoReserva($correo, $nombre, $asunto, $mensaje);

    echo json_encode([
        'success' => true,
        'message' => 'Solicitud de celebración realizada correctamente'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al guardar la solicitud de celebración',
        'error' => $e->getMessage()
    ]);
}