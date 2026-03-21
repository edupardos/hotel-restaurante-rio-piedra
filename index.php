<?php
$paginaActual = 'inicio';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="img/logo.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>
    
    <!-- Carrusel -->
    <section class="carousel-section">
        <div class="container">
            <div id="carouselHotel" class="carousel slide" data-bs-ride="carousel">

            <!-- Indicadores -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselHotel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselHotel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselHotel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <!-- Slides -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/restaurantesalongrande.jfif" class="d-block w-100 imagen-carrusel" alt="Restaurante Salón Grande">
                    <div class="carousel-caption-custom">
                        <div class="titulo-blanco">
                            RESTAURANTE
                        </div>
                        <div class="titulo-negro">
                            Cocina de temporada
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="img/habitacioncarrusel.jfif" class="d-block w-100 imagen-carrusel" alt="Hotel Habitación">
                    <div class="carousel-caption-custom">
                        <div class="titulo-blanco">
                            HOTEL
                        </div>
                        <div class="titulo-negro">
                            Jardín, piscina y terrazas
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="img/celebraciones.jpeg" class="d-block w-100 imagen-carrusel" alt="Celebraciones boda">
                    <div class="carousel-caption-custom">
                        <div class="titulo-blanco">
                            CELEBRACIONES
                        </div>
                        <div class="titulo-negro">
                            Bodas, comuniones, bautizos, eventos de empresa
                        </div>
                    </div>
                </div>
            </div>

            <!-- Controles -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselHotel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#carouselHotel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
        </div>
    </section>

    <!-- Cards -->
    <section class="cards-servicios py-5">
    <div class="container">
        <div class="row justify-content-center g-4">

            <!-- Card 1 -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card card-servicio h-100">
                    <div class="card-body">
                        <img src="img/habitaciondos.jpg" class="imagen-card" alt="Card Habitación">
                        <h3 class="card-title">El Hotel</h3>
                        <hr class="linea-card">
                        <p class="card-text">
                            El hotel con 2 estrellas, dispone de 30 habitaciones. 
                            Unas estilo rústico ubicadas en el antiguo Caserón del siglo XVIII. 
                            Todas con suelos de parquet y duchas estilo vintage...
                        </p>
                        <br>
                        <a href="hotel.php" class="btn-mas-info">Más información</a>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card card-servicio h-100">
                    <div class="card-body">
                        <img src="img/restaurante.jpg" class="imagen-card" alt="Card Restaurante">
                        <h3 class="card-title">El Restaurante</h3>
                        <hr class="linea-card">
                        <p class="card-text">
                            Cocina tradicional con producto de calidad y cercanía,
                            fusionado con nuevas tendencias gastronómicas.
                            Reconocido en varias ocasiones como mejor restaurante de Zaragoza...
                        </p>
                        <br>
                        <a href="restaurante.php" class="btn-mas-info">Más información</a>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card card-servicio h-100">
                    <div class="card-body">
                        <img src="img/celebracionesdos.jpg" class="imagen-card" alt="Card Celebraciones">
                        <h3 class="card-title">Celebraciones</h3>
                        <hr class="linea-card">
                        <p class="card-text">
                            Celebramos bodas, comuniones, bautizos y eventos de empresa.
                            Disponemos de una amplia oferta de menús, salones privados,
                            jardín, terraza y piscina...
                        </p>
                        <br>
                        <a href="celebraciones.php" class="btn-mas-info">Más información</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </section>

    <!-- Separador -->
    <div class="separador-linea">
        <div class="container">
            <div class="linea-marron"></div>
        </div>
    </div>

    <!-- Bienvenida -->
    <section class="seccion-info py-5">
        <div class="container">
            <div class="row align-items-center mt-4">
                <div class="col-lg-6 text-center">
                    <h4 class="titulo-seccion">Bienvenidos al Hotel Río Piedra</h4>
                    <hr class="linea-card">
                    <p class="texto-seccion fw-semibold">
                        Hotel con encanto, a las faldas del Monasterio de Piedra, en el centro de Nuévalos en un caserón del siglo XVIII
                    </p>
                    <p class="texto-seccion">
                        En 2019 se nos otorga la 3ª estrella como reconocimiento al esfuerzo realizado durante años para conseguir fusionar
                        el estado de bienestar con este privilegiado entorno natural del <span class="fw-semibold fst-italic">Monasterio de Piedra</span>. El hotel dispone de 30
                        habitaciones.
                    </p>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="img/recepcion.jpg" class="imagen-seccion" alt="Recepción">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-5 bg-dark">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-5 mb-4">
                    <h5 class="footer-titulo">REDES SOCIALES</h5>
                    <div class="footer-item">
                        <img src="img/instagram.png" class="footer-icono" alt="Instagram">
                        <span>@hotelrestauranteriopiedra</span>
                    </div>
                    <div class="footer-item">
                        <img src="img/facebook.png" class="footer-icono" alt="Facebook">
                        <span>Hotel Río Piedra</span>
                    </div>
                    <div class="footer-item">
                        <img src="img/twitter.png" class="footer-icono" alt="Twitter">
                        <span>@hotelrestauranteriopiedra</span>
                    </div>
                    <div class="footer-item">
                        <img src="img/youtube.png" class="footer-icono" alt="Youtube">
                        <span>Hotel Río Piedra</span>
                    </div>
                </div>

                <div class="col-md-5 mb-4">
                    <h5 class="footer-titulo">INFORMACIÓN</h5>
                    <div class="footer-item">
                        <img src="img/ubicacion.png" class="footer-icono" alt="Ubicación">
                        <span>Crta Monasterio de Piedra S/N 50210 Nuévalos (Zaragoza)</span>
                    </div>
                    <div class="footer-item">
                        <img src="img/llamar.png" class="footer-icono" alt="Móvil">
                        <span>+34 976 849 007</span>
                    </div>
                    <div class="footer-item">
                        <img src="img/impresion.png" class="footer-icono" alt="Fijo">
                        <span>+34 976 849 007</span>
                    </div>
                    <div class="footer-item">
                        <img src="img/mail.png" class="footer-icono" alt="Email">
                        <span>informa@hotelriopiedra.com</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/app.js"></script>
</body>
</html>