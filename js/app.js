document.addEventListener("DOMContentLoaded", function () {

    const Toast = Swal.mixin({
        confirmButtonColor: "#79480C",
        cancelButtonColor: "#6c757d",
        buttonsStyling: true
    });

    const pages = document.querySelectorAll(".page");
    const btnIrHotel = document.getElementById("btn-ir-hotel");
    const btnIrRestaurante = document.getElementById("btn-ir-restaurante");
    const btnVolverInicioHotel = document.getElementById("btn-volver-inicio-hotel");
    const btnVolverInicioRestaurante = document.getElementById("btn-volver-inicio-restaurante");
    const btnVolverInicioCelebraciones = document.getElementById("btn-volver-inicio-celebraciones");
    const btnIrRegistro = document.getElementById("btn-ir-registro");
    const btnIrLogin = document.getElementById("btn-ir-login");
    const btnIrCelebraciones = document.getElementById("btn-ir-celebraciones");
    const btnAdminUsuarios = document.getElementById("btn-admin-usuarios");
    const btnAdminReservas = document.getElementById("btn-admin-reservas");
    const btnVolverAdminInicioUsuarios = document.getElementById("btn-volver-admin-inicio-usuarios");
    const btnVolverAdminInicioReservas = document.getElementById("btn-volver-admin-inicio-reservas");
    const btnPerfilNav = document.getElementById("btn-perfil-nav");

    const formReservaRestaurante = document.getElementById("form-reserva-restaurante");
    const fechaHoraRest = document.getElementById("fechaHoraRest");

    const formReservaHotel = document.getElementById("form-reserva-hotel");
    const fechaEntrada = document.getElementById("fechaEntrada");
    const fechaSalida = document.getElementById("fechaSalida");
    const tipoHabitacion = document.getElementById("tipoHabitacion");
    const precioTotalHotel = document.getElementById("precio-total-hotel");

    const params = new URLSearchParams(window.location.search);
    const tipoReserva = params.get("tipo");

    function mostrarPage(id) {
        pages.forEach(page => page.classList.remove("active"));
        const page = document.getElementById(id);
        if (page) {
            page.classList.add("active");
        }
    }

    function obtenerFechaHoraLocalActual() {
        const ahora = new Date();
        const year = ahora.getFullYear();
        const month = String(ahora.getMonth() + 1).padStart(2, "0");
        const day = String(ahora.getDate()).padStart(2, "0");
        const hours = String(ahora.getHours()).padStart(2, "0");
        const minutes = String(ahora.getMinutes()).padStart(2, "0");

        return `${year}-${month}-${day}T${hours}:${minutes}`;
    }

    function obtenerFechaActual() {
        const hoy = new Date();
        const year = hoy.getFullYear();
        const month = String(hoy.getMonth() + 1).padStart(2, "0");
        const day = String(hoy.getDate()).padStart(2, "0");

        return `${year}-${month}-${day}`;
    }

    function calcularNoches(entrada, salida) {
        if (!entrada || !salida) return 0;

        const fecha1 = new Date(entrada);
        const fecha2 = new Date(salida);

        const diferenciaMs = fecha2 - fecha1;
        const noches = diferenciaMs / (1000 * 60 * 60 * 24);

        return noches > 0 ? noches : 0;
    }

    function obtenerPrecioPorNoche(tipo) {
        switch (tipo) {
            case "individual":
                return 60;
            case "doble":
                return 90;
            case "doble_superior":
                return 120;
            case "suite":
                return 180;
            default:
                return 0;
        }
    }

    function actualizarPrecioHotel() {
        if (!precioTotalHotel) return;

        const entrada = fechaEntrada ? fechaEntrada.value : "";
        const salida = fechaSalida ? fechaSalida.value : "";
        const tipo = tipoHabitacion ? tipoHabitacion.value : "";

        const noches = calcularNoches(entrada, salida);
        const precioNoche = obtenerPrecioPorNoche(tipo);
        const total = noches * precioNoche;

        if (noches > 0 && precioNoche > 0) {
            precioTotalHotel.textContent = `${total.toFixed(2)} €`;
        } else {
            precioTotalHotel.textContent = "Pendiente de cálculo";
        }
    }

    if (tipoReserva === "hotel") {
        mostrarPage("page-hotel");
    } else if (tipoReserva === "restaurante") {
        mostrarPage("page-restaurante");
    } else if (tipoReserva === "celebracion") {
        mostrarPage("page-celebraciones");
    }

    if (btnIrHotel) {
        btnIrHotel.addEventListener("click", function (e) {
            e.preventDefault();
            mostrarPage("page-hotel");
        });
    }

    if (btnIrRestaurante) {
        btnIrRestaurante.addEventListener("click", function (e) {
            e.preventDefault();
            mostrarPage("page-restaurante");
        });
    }

    if (btnIrCelebraciones) {
        btnIrCelebraciones.addEventListener("click", function (e) {
            e.preventDefault();
            mostrarPage("page-celebraciones");
        });
    }

    if (btnVolverInicioHotel) {
        btnVolverInicioHotel.addEventListener("click", function () {
            mostrarPage("page-inicio");
        });
    }

    if (btnVolverInicioRestaurante) {
        btnVolverInicioRestaurante.addEventListener("click", function () {
            mostrarPage("page-inicio");
        });
    }

    if (btnVolverInicioCelebraciones) {
        btnVolverInicioCelebraciones.addEventListener("click", function () {
            mostrarPage("page-inicio");
        });
    }

    if (btnIrRegistro) {
        btnIrRegistro.addEventListener("click", function (e) {
            e.preventDefault();
            mostrarPage("page-registro");
        });
    }

    if (btnIrLogin) {
        btnIrLogin.addEventListener("click", function (e) {
            e.preventDefault();
            mostrarPage("page-login");
        });
    }

    if (btnAdminUsuarios) {
        btnAdminUsuarios.addEventListener("click", function () {
            mostrarPage("page-admin-usuarios");
        });
    }

    if (btnAdminReservas) {
        btnAdminReservas.addEventListener("click", function () {
            mostrarPage("page-admin-reservas");
        });
    }

    if (btnVolverAdminInicioUsuarios) {
        btnVolverAdminInicioUsuarios.addEventListener("click", function () {
            mostrarPage("page-admin-inicio");
        });
    }

    if (btnVolverAdminInicioReservas) {
        btnVolverAdminInicioReservas.addEventListener("click", function () {
            mostrarPage("page-admin-inicio");
        });
    }

    async function comprobarEnlacePerfil() {
        if (!btnPerfilNav) return;

        try {
            const respuesta = await fetch("php/sesion_usuario.php");
            const resultado = await respuesta.json();

            if (resultado.success && resultado.usuario) {
                btnPerfilNav.setAttribute("href", "perfil.php");
            } else {
                btnPerfilNav.setAttribute("href", "loginregistro.php");
            }
        } catch (error) {
            btnPerfilNav.setAttribute("href", "loginregistro.php");
        }
    }

    comprobarEnlacePerfil();

    // Restringir fecha/hora mínima en restaurante
    if (fechaHoraRest) {
        fechaHoraRest.min = obtenerFechaHoraLocalActual();

        fechaHoraRest.addEventListener("focus", function () {
            fechaHoraRest.min = obtenerFechaHoraLocalActual();
        });
    }

    // Restringir fechas mínimas en hotel
    if (fechaEntrada && fechaSalida) {
        const hoy = obtenerFechaActual();

        fechaEntrada.min = hoy;
        fechaSalida.min = hoy;

        fechaEntrada.addEventListener("change", function () {
            if (fechaEntrada.value) {
                fechaSalida.min = fechaEntrada.value;
            } else {
                fechaSalida.min = obtenerFechaActual();
            }

            if (fechaSalida.value && fechaSalida.value <= fechaEntrada.value) {
                fechaSalida.value = "";
            }

            actualizarPrecioHotel();
        });

        fechaSalida.addEventListener("change", function () {
            actualizarPrecioHotel();
        });
    }

    if (tipoHabitacion) {
        tipoHabitacion.addEventListener("change", function () {
            actualizarPrecioHotel();
        });
    }

    // Reservas hotel
    if (formReservaHotel) {
        formReservaHotel.addEventListener("submit", async function (e) {
            e.preventDefault();

            if (!fechaEntrada.value || !fechaSalida.value) {
                Swal.fire({
                    icon: "error",
                    title: "Fechas no válidas",
                    text: "Debes indicar la fecha de entrada y la fecha de salida",
                    confirmButtonColor: "#79480C"
                });
                return;
            }

            const entrada = new Date(fechaEntrada.value);
            const salida = new Date(fechaSalida.value);
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);

            if (entrada < hoy) {
                Swal.fire({
                    icon: "error",
                    title: "Fecha no válida",
                    text: "La fecha de entrada no puede ser anterior a la actual",
                    confirmButtonColor: "#79480C"
                });
                return;
            }

            if (salida <= entrada) {
                Swal.fire({
                    icon: "error",
                    title: "Fecha no válida",
                    text: "La fecha de salida debe ser posterior a la fecha de entrada",
                    confirmButtonColor: "#79480C"
                });
                return;
            }

            const formData = new FormData(formReservaHotel);

            try {
                const response = await fetch("php/reservar_hotel.php", {
                    method: "POST",
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    await Swal.fire({
                        icon: "success",
                        title: "Reserva realizada",
                        text: data.message,
                        confirmButtonColor: "#79480C"
                    });

                    formReservaHotel.reset();

                    if (precioTotalHotel) {
                        precioTotalHotel.textContent = "Pendiente de cálculo";
                    }

                    if (fechaEntrada && fechaSalida) {
                        const hoy = obtenerFechaActual();
                        fechaEntrada.min = hoy;
                        fechaSalida.min = hoy;
                    }

                    mostrarPage("page-inicio");
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: data.message,
                        confirmButtonColor: "#79480C"
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No se pudo procesar la reserva del hotel",
                    confirmButtonColor: "#79480C"
                });
            }
        });
    }

    // Reservas restaurante
    if (formReservaRestaurante) {
        formReservaRestaurante.addEventListener("submit", async function (e) {
            e.preventDefault();

            if (fechaHoraRest && fechaHoraRest.value) {
                const fechaSeleccionada = new Date(fechaHoraRest.value);
                const ahora = new Date();

                if (fechaSeleccionada < ahora) {
                    Swal.fire({
                        icon: "error",
                        title: "Fecha no válida",
                        text: "No puedes realizar una reserva en una fecha y hora anteriores a la actual",
                        confirmButtonColor: "#79480C"
                    });
                    return;
                }
            }

            const formData = new FormData(formReservaRestaurante);

            try {
                const response = await fetch("php/reservar_restaurante.php", {
                    method: "POST",
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    await Swal.fire({
                        icon: "success",
                        title: "Reserva realizada",
                        text: data.message,
                        confirmButtonColor: "#79480C"
                    });

                    formReservaRestaurante.reset();

                    if (fechaHoraRest) {
                        fechaHoraRest.min = obtenerFechaHoraLocalActual();
                    }

                    mostrarPage("page-inicio");
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: data.message,
                        confirmButtonColor: "#79480C"
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No se pudo procesar la reserva",
                    confirmButtonColor: "#79480C"
                });
            }
        });
    }
});