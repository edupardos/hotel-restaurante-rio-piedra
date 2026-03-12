const pages = document.querySelectorAll(".page");
const btnIrHotel = document.getElementById("btn-ir-hotel");
const btnIrRestaurante = document.getElementById("btn-ir-restaurante");
const btnVolverInicioHotel = document.getElementById("btn-volver-inicio-hotel");
const btnVolverInicioRestaurante = document.getElementById("btn-volver-inicio-restaurante");
const btnIrRegistro = document.getElementById("btn-ir-registro");
const btnIrLogin = document.getElementById("btn-ir-login");

const params = new URLSearchParams(window.location.search);
const tipoReserva = params.get("tipo");

function mostrarPage(id) {
    pages.forEach(page => page.classList.remove("active"));
    document.getElementById(id).classList.add("active");
}

if (tipoReserva === "hotel") {
    mostrarPage("page-hotel");
} else if (tipoReserva === "restaurante") {
    mostrarPage("page-restaurante");
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