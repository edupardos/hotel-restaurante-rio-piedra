<?php
$paginaActual = 'reservar';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar</title>

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

    <!-- Page Principal -->
    <div class="page active" id="page-inicio">
        <!-- Sección Reservar Hotel -->
        <section class="py-5">
            <div class="container">
                <div class="row align-items-center py-5 g-5">
                    <div class="col-lg-6 text-center">
                        <h4 class="mb-4">Reservar en el Hotel</h4>
                        <p class="texto-seccion mb-4">
                            ¡Pulsa aquí para reservar unos días de escapada y desconexión en nuestro hotel!
                        </p>
                        <a class="btn-reservar btn-lg px-5 py-3" href="#" id="btn-ir-hotel">Reservar Hotel</a>
                    </div>
                    <div class="col-lg-6">
                        <img src="img/piscina.jfif" alt="Piscina del hotel" class="imagen-seccion mx-auto d-block">
                    </div>
                </div>
            </div>
        </section>
    
        <div class="separador-linea">
            <div class="container">
                <div class="linea-marron"></div>
            </div>
        </div>
    
        <!-- Sección Reservar Restaurante -->
        <section class="py-5">
            <div class="container">
                <div class="row align-items-center py-5 g-5">
                    <div class="col-lg-6">
                        <img src="img/tablaaperitivos.jpg" alt="Aperitivos del restaurante" class="imagen-seccion mx-auto d-block">
                    </div>
                    <div class="col-lg-6 text-center">
                        <h4 class="mb-4">Reservar en el Restaurante</h4>
                        <p class="texto-seccion mb-4">
                            ¡Pulsa aquí para disfrutar de una experiencia gastronómica tradicional e inolvidable!
                        </p>
                        <a class="btn-reservar btn-lg px-5 py-3" href="#" id="btn-ir-restaurante">Reservar Restaurante</a>
                    </div>
                </div>
            </div>
        </section>

        <div class="separador-linea">
            <div class="container">
                <div class="linea-marron"></div>
            </div>
        </div>

        <!-- Sección Reservar Celebración -->
        <section class="py-5">
            <div class="container">
                <div class="row align-items-center py-5 g-5">
                    <div class="col-lg-6 text-center">
                        <h4 class="mb-4">Reservar Celebración</h4>
                        <p class="texto-seccion mb-4">
                            ¡Pulsa aquí para reservar una celebración inolvidable, acompañado de todos tus seres queridos!
                        </p>
                        <a class="btn-reservar btn-lg px-5 py-3" href="#" id="btn-ir-celebraciones">Reservar Celebración</a>
                    </div>
                    <div class="col-lg-6">
                        <img src="img/bodas.png" alt="Celebración de boda" class="imagen-seccion mx-auto d-block">
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Page Reservar Hotel -->
    <div class="page" id="page-hotel">
        <section class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-10 col-xl-8">

                        <h2 class="text-center mb-4">Reservar en el Hotel</h2>
                        <p class="text-center mb-5">
                            Completa el siguiente formulario para solicitar tu reserva.
                        </p>
                        <div class="form-reserva p-4 p-md-5 shadow-sm bg-white">
                            <div class="d-flex justify-content-start mb-3">
                                <button type="button" class="btn btn-reservar" id="btn-volver-inicio-hotel">
                                    Atrás
                                </button>
                            </div>

                            <form id="form-reserva-hotel">
                                <div class="row g-4">
                                    <div class="col-12 col-lg-6">
                                        <label for="nombreHotel" class="form-label text-center w-100">Nombre</label>
                                        <input type="text" class="form-control" id="nombreHotel" name="nombre" placeholder="Introduce tu nombre">
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <label for="apellidosHotel" class="form-label text-center w-100">Apellidos</label>
                                        <input type="text" class="form-control" id="apellidosHotel" name="apellidos" placeholder="Introduce tus apellidos">
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <label for="telefonoHotel" class="form-label text-center w-100">Teléfono</label>
                                        <input type="tel" class="form-control" id="telefonoHotel" name="telefono" placeholder="Introduce tu teléfono">
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <label for="tipoHabitacion" class="form-label text-center w-100">Tipo de habitación</label>
                                        <select class="form-select" id="tipoHabitacion" name="tipo_habitacion">
                                            <option value="" selected disabled>Selecciona una opción</option>
                                            <option value="individual">Habitación individual</option>
                                            <option value="doble">Habitación doble</option>
                                            <option value="doble_superior">Habitación doble superior</option>
                                            <option value="suite">Suite</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label for="correoHotel" class="form-label text-center w-100">Correo electrónico</label>
                                        <input type="email" class="form-control" id="correoHotel" name="correo" placeholder="Introduce tu correo electrónico">
                                    </div>

                                    <div class="col-12">
                                        <label for="direccionHotel" class="form-label text-center w-100">Dirección</label>
                                        <input type="text" class="form-control" id="direccionHotel" name="direccion" placeholder="Introduce tu dirección">
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <label for="fechaEntrada" class="form-label text-center w-100">Fecha de entrada</label>
                                        <input type="date" class="form-control" id="fechaEntrada" name="fecha_entrada">
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <label for="fechaSalida" class="form-label text-center w-100">Fecha de salida</label>
                                        <input type="date" class="form-control" id="fechaSalida" name="fecha_salida">
                                    </div>

                                    <div class="col-12">
                                        <label for="observacionesHotel" class="form-label text-center w-100">Observaciones (opcional)</label>
                                        <textarea class="form-control" id="observacionesHotel" name="observaciones" rows="4" placeholder="Escribe aquí cualquier observación adicional"></textarea>
                                    </div>

                                    <div class="col-12">
                                        <p class="fs-5 mb-0">
                                            <strong>Precio total:</strong> <span id="precio-total-hotel">Pendiente de cálculo</span>
                                        </p>
                                    </div>

                                    <div class="col-12 d-flex flex-column flex-md-row justify-content-center gap-3 pt-3">
                                        <button type="submit" class="btn-reservar px-5 py-3 fs-5">
                                            Confirmar Reserva
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Page Reservar Restaurante -->
    <div class="page" id="page-restaurante">
        <section class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-10 col-xl-8">
                        <h2 class="text-center mb-4">Reservar en el Restaurante</h2>
                        <p class="text-center mb-5">
                            Completa el siguiente formulario para solicitar tu reserva.
                        </p>
                        <div class="form-reserva p-4 p-md-5 shadow-sm bg-white">
                            <div class="d-flex justify-content-start mb-3">
                                <button type="button" class="btn btn-reservar" id="btn-volver-inicio-restaurante">
                                    Atrás
                                </button>
                            </div>

                            <form id="form-reserva-restaurante">
                                <div class="row g-4">
                                    <!-- Nombre y apellidos -->
                                    <div class="col-12 col-lg-6">
                                        <label for="nombreRest" class="form-label text-center w-100">Nombre</label>
                                        <input type="text" class="form-control" placeholder="Introduce tu nombre" id="nombreRest" name="nombre">
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <label for="apellidosRest" class="form-label text-center w-100">Apellidos</label>
                                        <input type="text" class="form-control" placeholder="Introduce tus apellidos" id="apellidosRest" name="apellidos">
                                    </div>

                                    <!-- Teléfono y fecha -->
                                    <div class="col-12 col-lg-6">
                                        <label for="telefonoRest" class="form-label text-center w-100">Teléfono</label>
                                        <input type="tel" class="form-control" placeholder="Introduce tu teléfono" id="telefonoRest" name="telefono">
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <label for="fechaHoraRest" class="form-label text-center w-100">Fecha y hora de la reserva</label>
                                        <input type="datetime-local" class="form-control" id="fechaHoraRest" name="fecha_hora">
                                    </div>

                                    <!-- Número de personas -->
                                    <div class="col-12 col-lg-6">
                                        <label for="numPersonasRest" class="form-label text-center w-100">Número de personas</label>
                                        <input type="number" class="form-control" placeholder="Introduce el número de personas" id="numPersonasRest" name="num_personas" min="1">
                                    </div>

                                    <!-- Correo electrónico -->
                                    <div class="col-12 col-lg-6">
                                        <label for="correoRest" class="form-label text-center w-100">Correo electrónico</label>
                                        <input type="email" class="form-control" placeholder="Introduce tu correo electrónico" id="correoRest" name="correo">
                                    </div>

                                    <!-- Observaciones -->
                                    <div class="col-12">
                                        <label for="observacionesRest" class="form-label text-center w-100">Observaciones (opcional)</label>
                                        <textarea class="form-control" placeholder="Escribe aquí cualquier observación adicional" id="observacionesRest" name="observaciones" rows="4"></textarea>
                                    </div>

                                    <!-- Botón confirmar -->
                                    <div class="col-12 text-center pt-3">
                                        <button type="submit" class="btn-reservar px-5 py-3">
                                            Confirmar reserva
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Page Reservar Celebraciones -->
    <div class="page" id="page-celebraciones">
        <section class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-10 col-xl-8">
                        <h2 class="text-center mb-4">Solicitar celebración</h2>
                        <p class="text-center mb-5">
                            Completa el siguiente formulario para solicitar información sobre tu celebración.
                        </p>
                        <div class="form-reserva p-4 p-md-5 shadow-sm bg-white">
                            <div class="d-flex justify-content-start mb-3">
                                <button type="button" class="btn btn-reservar" id="btn-volver-inicio-celebraciones">
                                    Atrás
                                </button>
                            </div>
                            <form id="form-reserva-celebracion">
                                <div class="row g-4">
                                    <!-- Nombre -->
                                    <div class="col-12 col-lg-6">
                                        <label for="nombreCelebracion" class="form-label text-center w-100">Nombre</label>
                                        <input type="text" class="form-control" id="nombreCelebracion" name="nombre" placeholder="Introduce tu nombre">
                                    </div>

                                    <!-- Apellidos -->
                                    <div class="col-12 col-lg-6">
                                        <label for="apellidosCelebracion" class="form-label text-center w-100">Apellidos</label>
                                        <input type="text" class="form-control" id="apellidosCelebracion" name="apellidos" placeholder="Introduce tus apellidos">
                                    </div>

                                    <!-- Teléfono -->
                                    <div class="col-12 col-lg-6">
                                        <label for="telefonoCelebracion" class="form-label text-center w-100">Teléfono</label>
                                        <input type="tel" class="form-control" id="telefonoCelebracion" name="telefono" placeholder="Introduce tu teléfono">
                                    </div>

                                    <!-- Tipo celebración -->
                                    <div class="col-12 col-lg-6">
                                        <label for="tipoCelebracion" class="form-label text-center w-100">Tipo de celebración</label>
                                        <select class="form-select" id="tipoCelebracion" name="tipo_celebracion">
                                            <option value="" selected disabled>Selecciona una opción</option>
                                            <option value="boda">Boda</option>
                                            <option value="bautizo">Bautizo</option>
                                            <option value="comunion">Comunión</option>
                                        </select>
                                    </div>

                                    <!-- Fecha celebración -->
                                    <div class="col-12 col-lg-6">
                                        <label for="fechaCelebracion" class="form-label text-center w-100">Fecha de la celebración</label>
                                        <input type="date" class="form-control" id="fechaCelebracion" name="fecha_celebracion">
                                    </div>

                                    <!-- Número personas -->
                                    <div class="col-12 col-lg-6">
                                        <label for="numPersonasCelebracion" class="form-label text-center w-100">Número de personas</label>
                                        <input type="number" class="form-control" id="numPersonasCelebracion" name="num_personas" placeholder="Número aproximado de asistentes" min="1">
                                    </div>

                                    <!-- Correo -->
                                    <div class="col-12">
                                        <label for="correoCelebracion" class="form-label text-center w-100">Correo electrónico</label>
                                        <input type="email" class="form-control" id="correoCelebracion" name="correo" placeholder="Introduce tu correo">
                                    </div>

                                    <!-- Observaciones -->
                                    <div class="col-12">
                                        <label for="observacionesCelebracion" class="form-label text-center w-100">Observaciones</label>
                                        <textarea class="form-control" id="observacionesCelebracion" name="observaciones" rows="4" placeholder="Indica cualquier detalle que quieras comentar"></textarea>
                                    </div>

                                    <!-- Precio -->
                                    <div class="col-12 pt-3">
                                        <p class="fs-5 mb-2">
                                            Precio total estimado: <span id="precio-total-celebracion">Pendiente de cálculo</span>
                                        </p>
                                    </div>

                                    <!-- Texto -->
                                    <div class="col-12 text-center">
                                        <p class="fw-semibold fst-italic">
                                            Si estás interesado en celebrar tu evento con nosotros, pulsa en el botón
                                            “Solicitar Reserva”. Recibirás un correo con información para concertar
                                            una reunión con el equipo del hotel, donde podremos hablar con calma sobre
                                            los detalles de la celebración y preparar juntos un evento a tu medida.
                                        </p>
                                    </div>

                                    <!-- Botón -->
                                    <div class="col-12 text-center pt-2">
                                        <button type="submit" class="btn-reservar px-5 py-3">
                                            Solicitar Reserva
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

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