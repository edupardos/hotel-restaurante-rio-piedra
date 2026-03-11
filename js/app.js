const pages = document.querySelectorAll(".page");
const btnIrHotel = document.getElementById("btn-ir-hotel");
const btnIrRestaurante = document.getElementById("btn-ir-restaurante");
const btnVolverInicioHotel = document.getElementById("btn-volver-inicio-hotel");
const btnVolverInicioRestaurante = document.getElementById("btn-volver-inicio-restaurante");
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

btnIrHotel.addEventListener("click", function (e) {
    e.preventDefault();
    mostrarPage("page-hotel");
});

btnIrRestaurante.addEventListener("click", function (e) {
    e.preventDefault();
    mostrarPage("page-restaurante");
});

btnVolverInicioHotel.addEventListener("click", function () {
    mostrarPage("page-inicio");
});

btnVolverInicioRestaurante.addEventListener("click", function () {
    mostrarPage("page-inicio");
});