document.addEventListener("DOMContentLoaded", function () {

    const formRegistro = document.getElementById("form-registro");
    const formLogin = document.getElementById("form-login");

    const inputLoginCorreo = document.getElementById("login-correo");
    const inputLoginPassword = document.getElementById("login-password");

    const alerta = Swal.mixin({
        confirmButtonColor: "#79480C",
        cancelButtonColor: "#6c757d",
        buttonsStyling: true
    });

    function crearBotonLogout() {

        if (document.getElementById("btn-logout")) return;

        const contenedor = document.createElement("div");
        contenedor.className = "text-center mt-4";

        contenedor.innerHTML = `
            <p class="mb-0">Sesión iniciada</p>
            <a href="#" id="btn-logout" class="text-decoration-none">
                Cerrar sesión
            </a>
        `;

        if (formLogin) {
            formLogin.appendChild(contenedor);
        }

        document.getElementById("btn-logout").addEventListener("click", async function (e) {
            e.preventDefault();

            const confirmacion = await alerta.fire({
                icon: "question",
                title: "Cerrar sesión",
                text: "¿Quieres cerrar la sesión actual?",
                showCancelButton: true,
                confirmButtonText: "Sí, cerrar sesión",
                cancelButtonText: "Cancelar"
            });

            if (!confirmacion.isConfirmed) return;

            try {

                const respuesta = await fetch("php/logout.php", {
                    method: "POST"
                });

                const resultado = await respuesta.json();

                if (resultado.success) {

                    await alerta.fire({
                        icon: "success",
                        title: "Sesión cerrada",
                        text: "Has cerrado sesión correctamente"
                    });

                    window.location.href = "loginregistro.html";

                }

            } catch (error) {

                alerta.fire({
                    icon: "error",
                    title: "Error",
                    text: "No se pudo cerrar la sesión"
                });

            }

        });

    }

    async function comprobarSesion() {

        try {

            const respuesta = await fetch("php/sesion_usuario.php");
            const resultado = await respuesta.json();

            if (resultado.success && resultado.usuario) {

                if (inputLoginCorreo) {
                    inputLoginCorreo.value = resultado.usuario.correo;
                }

                if (inputLoginPassword) {
                    inputLoginPassword.placeholder = "********";
                }

                crearBotonLogout();

            }

        } catch (error) {
            console.log("No se pudo comprobar la sesión");
        }

    }

    if (formRegistro) {

        formRegistro.addEventListener("submit", async function (e) {

            e.preventDefault();

            const datos = new FormData(formRegistro);

            try {

                const respuesta = await fetch("php/registro.php", {
                    method: "POST",
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.success) {

                    await alerta.fire({
                        icon: "success",
                        title: "Registro completado",
                        text: "Usuario registrado correctamente"
                    });

                    window.location.href = "index.html";

                } else {

                    alerta.fire({
                        icon: "error",
                        title: "Error en el registro",
                        text: resultado.message
                    });

                }

            } catch (error) {

                alerta.fire({
                    icon: "error",
                    title: "Error de conexión",
                    text: "No se ha podido conectar con el servidor"
                });

            }

        });

    }

    if (formLogin) {

        formLogin.addEventListener("submit", async function (e) {

            e.preventDefault();

            const datos = new FormData(formLogin);

            try {

                const respuesta = await fetch("php/login.php", {
                    method: "POST",
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.success) {

                    await alerta.fire({
                        icon: "success",
                        title: "Inicio de sesión correcto",
                        text: "Redirigiendo al inicio..."
                    });

                    window.location.href = "index.html";

                } else {

                    alerta.fire({
                        icon: "error",
                        title: "Error de inicio de sesión",
                        text: resultado.message
                    });

                }

            } catch (error) {

                alerta.fire({
                    icon: "error",
                    title: "Error de conexión",
                    text: "No se ha podido conectar con el servidor"
                });

            }

        });

        comprobarSesion();

    }

});