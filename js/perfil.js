document.addEventListener("DOMContentLoaded", function () {
    const formPerfil = document.getElementById("form-perfil");

    const inputNombre = document.getElementById("perfil-nombre");
    const inputApellidos = document.getElementById("perfil-apellidos");
    const inputTelefono = document.getElementById("perfil-telefono");
    const inputFoto = document.getElementById("perfil-foto");
    const inputCorreo = document.getElementById("perfil-correo");
    const inputDireccion = document.getElementById("perfil-direccion");
    const previewFoto = document.getElementById("preview-foto-perfil");

    const alerta = Swal.mixin({
        confirmButtonColor: "#79480C",
        cancelButtonColor: "#6c757d",
        buttonsStyling: true
    });

    async function cargarPerfil() {
        try {
            const respuesta = await fetch("php/obtener_perfil.php");
            const resultado = await respuesta.json();

            if (!resultado.success) {
                await alerta.fire({
                    icon: "warning",
                    title: "Sesión requerida",
                    text: "Debes iniciar sesión para acceder a tu perfil"
                });

                window.location.href = "loginregistro.php";
                return;
            }

            const usuario = resultado.usuario;

            if (inputNombre) inputNombre.value = usuario.nombre || "";
            if (inputApellidos) inputApellidos.value = usuario.apellidos || "";
            if (inputTelefono) inputTelefono.value = usuario.telefono || "";
            if (inputCorreo) inputCorreo.value = usuario.correo || "";
            if (inputDireccion) inputDireccion.value = usuario.direccion || "";

            if (previewFoto) {
                if (usuario.foto_perfil && usuario.foto_perfil.trim() !== "") {
                    previewFoto.src = "img/perfil/" + usuario.foto_perfil + "?t=" + new Date().getTime();
                } else {
                    previewFoto.src = "img/perfil/default.png";
                }
            }

        } catch (error) {
            await alerta.fire({
                icon: "error",
                title: "Error",
                text: "No se pudo cargar el perfil"
            });
        }
    }

    if (inputFoto) {
        inputFoto.addEventListener("change", function () {
            if (inputFoto.files && inputFoto.files[0]) {
                const lector = new FileReader();

                lector.onload = function (e) {
                    if (previewFoto) {
                        previewFoto.src = e.target.result;
                    }
                };

                lector.readAsDataURL(inputFoto.files[0]);
            }
        });
    }

    if (formPerfil) {
        formPerfil.addEventListener("submit", async function (e) {
            e.preventDefault();

            const datos = new FormData();
            datos.append("nombre", inputNombre.value.trim());
            datos.append("apellidos", inputApellidos.value.trim());
            datos.append("telefono", inputTelefono.value.trim());
            datos.append("correo", inputCorreo.value.trim());
            datos.append("direccion", inputDireccion.value.trim());

            if (inputFoto.files.length > 0) {
                datos.append("foto_perfil", inputFoto.files[0]);
            }

            try {
                const respuesta = await fetch("php/actualizar_perfil.php", {
                    method: "POST",
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.success) {
                    if (previewFoto && resultado.foto_perfil) {
                        previewFoto.src = "img/perfil/" + resultado.foto_perfil + "?t=" + new Date().getTime();
                    }

                    await alerta.fire({
                        icon: "success",
                        title: "Perfil actualizado",
                        text: "Tus datos se han guardado correctamente"
                    });
                } else {
                    await alerta.fire({
                        icon: "error",
                        title: "Error al guardar",
                        text: resultado.message
                    });
                }
            } catch (error) {
                await alerta.fire({
                    icon: "error",
                    title: "Error de conexión",
                    text: "No se ha podido conectar con el servidor"
                });
            }
        });

        cargarPerfil();
    }
});