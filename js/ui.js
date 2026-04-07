function mostrarPage(id) {
    const pages = document.querySelectorAll(".page");
    pages.forEach(page => page.classList.remove("active"));

    const page = document.getElementById(id);
    if (page) {
        page.classList.add("active");
    }
}

function mostrarLoader() {
    const loader = document.getElementById("loader-overlay");
    if (loader) {
        loader.classList.remove("d-none");
    }
}

function ocultarLoader() {
    const loader = document.getElementById("loader-overlay");
    if (loader) {
        loader.classList.add("d-none");
    }
}