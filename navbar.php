<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$iconoPerfil = 'img/sinusuario.png';
$linkPerfil = 'loginregistro.php';
$mostrarAdmin = false;

if (isset($_SESSION['id_usuario'])) {
    $iconoPerfil = 'img/usuario.png';
    $linkPerfil = 'perfil.php';

    if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
        $iconoPerfil = 'img/admin.png';
        $linkPerfil = 'admin.php';
        $mostrarAdmin = true;
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white navbar-linea sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="img/logo.png" alt="logo" class="logo-navbar">
        </a>

        <button class="navbar-toggler boton-menu" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuNavbar">
            <ul class="navbar-nav ms-auto align-items-center gap-3">

                <li class="nav-item">
                    <a class="nav-link <?php echo ($paginaActual === 'inicio') ? 'active' : ''; ?>" href="index.php"></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo ($paginaActual === 'hotel') ? 'active' : ''; ?>" href="hotel.php">Hotel</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo ($paginaActual === 'restaurante') ? 'active' : ''; ?>" href="restaurante.php">Restaurante</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo ($paginaActual === 'celebraciones') ? 'active' : ''; ?>" href="celebraciones.php">Celebraciones</a>
                </li>

                <?php if ($mostrarAdmin): ?>
                    <li class="nav-item" id="admin-nav-item">
                        <a href="admin.php" class="nav-link <?php echo ($paginaActual === 'admin') ? 'active' : ''; ?>" id="btn-ir-admin">Panel Administrador</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a href="reservar.php" class="btn-reservar">Reservar</a>
                </li>

                <li>
                    <a class="nav-link" href="<?php echo $linkPerfil; ?>" id="btn-perfil-nav">
                        <img src="<?php echo $iconoPerfil; ?>" alt="perfil" class="icono-perfil">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>