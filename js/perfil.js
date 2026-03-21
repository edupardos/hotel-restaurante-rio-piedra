document.addEventListener("DOMContentLoaded", function () {
const formPerfil = document.getElementById("form-perfil");

const inputNombre = document.getElementById("perfil-nombre");
const inputApellidos = document.getElementById("perfil-apellidos");
const inputTelefono = document.getElementById("perfil-telefono");
const inputFoto = document.getElementById("perfil-foto");
const inputCorreo = document.getElementById("perfil-correo");
const inputDireccion = document.getElementById("perfil-direccion");

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

        } catch (error) {
            await alerta.fire({
                icon: "error",
                title: "Error",
                text: "No se pudo cargar el perfil"
            });
        }
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
                    await alerta.fire({
                        icon: "success",
                        title: "Perfil actualizado",
                        text: "Tus datos se han guardado correctamente"
                    });
                } else {
                    alerta.fire({
                        icon: "error",
                        title: "Error al guardar",
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

        cargarPerfil();
    }
});