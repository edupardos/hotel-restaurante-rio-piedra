document.addEventListener("DOMContentLoaded", function () {

    const btnIrHotel = document.getElementById("btn-ir-hotel");
    const btnIrRestaurante = document.getElementById("btn-ir-restaurante");
    const btnIrCelebraciones = document.getElementById("btn-ir-celebraciones");

    const btnVolverInicioHotel = document.getElementById("btn-volver-inicio-hotel");
    const btnVolverInicioRestaurante = document.getElementById("btn-volver-inicio-restaurante");
    const btnVolverInicioCelebraciones = document.getElementById("btn-volver-inicio-celebraciones");

    const btnIrRegistro = document.getElementById("btn-ir-registro");
    const btnIrLogin = document.getElementById("btn-ir-login");

    const btnAdminUsuarios = document.getElementById("btn-admin-usuarios");
    const btnAdminReservas = document.getElementById("btn-admin-reservas");
    const btnVolverAdminInicioUsuarios = document.getElementById("btn-volver-admin-inicio-usuarios");
    const btnVolverAdminInicioReservas = document.getElementById("btn-volver-admin-inicio-reservas");

    const btnPerfilNav = document.getElementById("btn-perfil-nav");

    const params = new URLSearchParams(window.location.search);
    const tipoReserva = params.get("tipo");

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
});