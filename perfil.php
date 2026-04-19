<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>

    <link rel="icon" type="image/png" href="img/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="py-3">
        <div class="container d-flex align-items-center justify-content-between">

            <a href="index.php" class="btn-reservar">
                Atrás
            </a>

            <div class="mx-auto">
                <img src="img/logo.png" alt="Logo Hotel Río Piedra" class="logo-navbar">
            </div>

            <div style="width:80px;"></div>

        </div>
    </div>

    <div class="separador-linea">
        <div class="container">
            <div class="linea-marron"></div>
        </div>
    </div>

    <section class="py-2">
        <div class="container">

            <div class="form-reserva p-4 p-md-5 shadow-sm bg-white">

                <!-- PAGE DATOS PERSONALES -->
                <div class="page active" id="page-perfil-inicio">
                    <h4 class="text-center mb-4">Datos personales</h4>

                    <form id="form-perfil" enctype="multipart/form-data">

                        <div class="col-12 text-center mb-4">
                            <img id="preview-foto-perfil" src="img/perfil/default.png" alt="Foto de perfil"
                                style="width: 140px; height: 140px; object-fit: cover; border-radius: 50%; border: 2px solid #ccc;">
                        </div>

                        <div class="row g-4">

                            <div class="col-12 col-lg-6">
                                <label for="perfil-nombre" class="form-label text-center w-100">Nombre</label>
                                <input type="text" class="form-control" id="perfil-nombre" name="nombre">
                            </div>

                            <div class="col-12 col-lg-6">
                                <label for="perfil-apellidos" class="form-label text-center w-100">Apellidos</label>
                                <input type="text" class="form-control" id="perfil-apellidos" name="apellidos">
                            </div>

                            <div class="col-12 col-lg-6">
                                <label for="perfil-telefono" class="form-label text-center w-100">Teléfono</label>
                                <input type="tel" class="form-control" id="perfil-telefono" name="telefono">
                            </div>

                            <div class="col-12 col-lg-6">
                                <label for="perfil-foto" class="form-label text-center w-100">Foto de perfil</label>
                                <input type="file" class="form-control" id="perfil-foto" name="foto" accept="image/*">
                            </div>

                            <div class="col-12">
                                <label for="perfil-correo" class="form-label text-center w-100">Correo electrónico</label>
                                <input type="email" class="form-control" id="perfil-correo" name="correo">

                                <p class="text-center mt-2 mb-0">
                                    ¿Quieres acceder con otra cuenta?
                                    <a href="loginregistro.php" class="text-decoration-none">Iniciar sesión</a>
                                </p>
                            </div>

                            <div class="col-12">
                                <label for="perfil-direccion" class="form-label text-center w-100">Dirección</label>
                                <input type="text" class="form-control" id="perfil-direccion" name="direccion">
                            </div>

                            <div class="col-12 text-center pt-3">
                                <button type="submit" class="btn-reservar px-5 py-3" id="btn-guardar-perfil">
                                    Guardar
                                </button>
                            </div>

                            <div class="col-12 pt-4">
                                <h4 class="text-center mb-3">Ver mis reservas</h4>
                                <div class="d-flex flex-wrap justify-content-center gap-3">

                                    <button type="button" class="btn-reservas-perfil" id="btn-reservas-hotel">
                                        Reservas Hotel
                                    </button>

                                    <button type="button" class="btn-reservas-perfil" id="btn-reservas-restaurante">
                                        Reservas Restaurante
                                    </button>

                                    <button type="button" class="btn-reservas-perfil" id="btn-reservas-celebraciones">
                                        Reservas Celebraciones
                                    </button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- PAGE RESERVAS HOTEL -->
                <div class="page" id="page-reservas-hotel">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <button class="btn-reservar px-3 py-2" id="btn-volver-perfil-hotel">
                            Atrás
                        </button>

                        <h5 class="mb-0 text-center flex-grow-1">
                            Mis Reservas Hotel
                        </h5>

                        <div style="width:90px;"></div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Habitación</th>
                                    <th>Fechas</th>
                                    <th>Precio total</th>
                                    <th>Estado</th>
                                    <th>Check-in</th>
                                    <th>Observaciones</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-reservas-hotel-body"></tbody>
                        </table>
                    </div>
                </div>

                <!-- PAGE RESERVAS RESTAURANTE -->
                <div class="page" id="page-reservas-restaurante">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <button class="btn-reservar px-3 py-2" id="btn-volver-perfil-restaurante">
                            Atrás
                        </button>

                        <h5 class="mb-0 text-center flex-grow-1">
                            Mis Reservas Restaurante
                        </h5>

                        <div style="width:90px;"></div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Fecha y hora</th>
                                    <th>Nº personas</th>
                                    <th>Estado</th>
                                    <th>Observaciones</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-reservas-restaurante-body"></tbody>
                        </table>
                    </div>
                </div>

                <!-- PAGE RESERVAS CELEBRACIONES -->
                <div class="page" id="page-reservas-celebraciones">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <button class="btn-reservar px-3 py-2" id="btn-volver-perfil-celebraciones">
                            Atrás
                        </button>

                        <h5 class="mb-0 text-center flex-grow-1">
                            Mis Reservas Celebraciones
                        </h5>

                        <div style="width:90px;"></div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Tipo</th>
                                    <th>Fecha</th>
                                    <th>Nº personas</th>
                                    <th>Precio estimado</th>
                                    <th>Estado</th>
                                    <th>Observaciones</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-reservas-celebraciones-body"></tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/perfil.js"></script>
</body>
</html>