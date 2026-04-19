document.addEventListener("DOMContentLoaded", function () {
    const formPerfil = document.getElementById("form-perfil");

    const inputNombre = document.getElementById("perfil-nombre");
    const inputApellidos = document.getElementById("perfil-apellidos");
    const inputTelefono = document.getElementById("perfil-telefono");
    const inputFoto = document.getElementById("perfil-foto");
    const inputCorreo = document.getElementById("perfil-correo");
    const inputDireccion = document.getElementById("perfil-direccion");
    const previewFoto = document.getElementById("preview-foto-perfil");

    const btnReservasHotel = document.getElementById("btn-reservas-hotel");
    const btnReservasRestaurante = document.getElementById("btn-reservas-restaurante");
    const btnReservasCelebraciones = document.getElementById("btn-reservas-celebraciones");

    const btnVolverPerfilHotel = document.getElementById("btn-volver-perfil-hotel");
    const btnVolverPerfilRestaurante = document.getElementById("btn-volver-perfil-restaurante");
    const btnVolverPerfilCelebraciones = document.getElementById("btn-volver-perfil-celebraciones");

    const tablaReservasHotelBody = document.getElementById("tabla-reservas-hotel-body");
    const tablaReservasRestauranteBody = document.getElementById("tabla-reservas-restaurante-body");
    const tablaReservasCelebracionesBody = document.getElementById("tabla-reservas-celebraciones-body");

    const alerta = Swal.mixin({
        confirmButtonColor: "#79480C",
        cancelButtonColor: "#6c757d",
        buttonsStyling: true
    });

    function mostrarPage(idPage) {
        const pages = document.querySelectorAll(".page");

        pages.forEach(page => {
            page.classList.remove("active");
        });

        const pageActiva = document.getElementById(idPage);
        if (pageActiva) {
            pageActiva.classList.add("active");
        }
    }

    function formatearFecha(fecha) {
        if (!fecha) return "-";

        const fechaObj = new Date(fecha + "T00:00:00");

        return fechaObj.toLocaleDateString("es-ES", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric"
        });
    }

    function formatearFechaHora(fechaHora) {
        if (!fechaHora) return "-";

        const fechaObj = new Date(fechaHora.replace(" ", "T"));

        return fechaObj.toLocaleString("es-ES", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit"
        });
    }

    function obtenerBadgeEstado(estado) {
        if (estado === "pendiente") {
            return `<span class="badge bg-warning text-dark">Pendiente</span>`;
        }

        if (estado === "confirmada") {
            return `<span class="badge bg-success">Confirmada</span>`;
        }

        if (estado === "anulada") {
            return `<span class="badge bg-danger">Anulada</span>`;
        }

        return `<span class="badge bg-secondary">${estado}</span>`;
    }

    function obtenerTextoCheckIn(checkIn) {
        return Number(checkIn) === 1 ? "Realizado" : "Pendiente";
    }

    function obtenerBotonCancelar(tipo, idReserva, estado, fechaReferencia) {

    // Si ya está anulada
    if (estado === "anulada") {
        return `<button class="btn btn-secondary btn-sm" disabled>Anulada</button>`;
    }

    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0);

    const fechaReserva = new Date(fechaReferencia);

    // Si la reserva ya ha pasado
    if (fechaReserva < hoy) {
        return `<button class="btn btn-secondary btn-sm" disabled>Finalizada</button>`;
    }

    // Si sigue activa
    return `
        <button 
            class="btn btn-danger btn-sm btn-cancelar-reserva" 
            data-tipo="${tipo}" 
            data-id="${idReserva}">
            Cancelar
        </button>
    `;
    }

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

    async function cargarReservasHotel() {
        if (!tablaReservasHotelBody) return;

        tablaReservasHotelBody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center">Cargando reservas...</td>
            </tr>
        `;

        try {
            const respuesta = await fetch("php/obtener_reservas_hotel_usuario.php");
            const resultado = await respuesta.json();

            if (!resultado.success) {
                tablaReservasHotelBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center text-danger">${resultado.message}</td>
                    </tr>
                `;
                return;
            }

            if (!resultado.reservas || resultado.reservas.length === 0) {
                tablaReservasHotelBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center">No tienes reservas de hotel.</td>
                    </tr>
                `;
                return;
            }

            tablaReservasHotelBody.innerHTML = "";

            resultado.reservas.forEach(reserva => {
                const fila = `
                    <tr>
                        <td>${reserva.tipo_habitacion || "-"}</td>
                        <td>${formatearFecha(reserva.fecha_entrada)} - ${formatearFecha(reserva.fecha_salida)}</td>
                        <td>${reserva.precio_total !== null ? reserva.precio_total + " €" : "-"}</td>
                        <td>${obtenerBadgeEstado(reserva.estado)}</td>
                        <td>${obtenerTextoCheckIn(reserva.check_in)}</td>
                        <td>${reserva.observaciones ? reserva.observaciones : "-"}</td>
                        <td class="text-center">
                            ${obtenerBotonCancelar("hotel", reserva.id_reserva_hotel, reserva.estado, reserva.fecha_salida)}
                        </td>
                    </tr>
                `;

                tablaReservasHotelBody.insertAdjacentHTML("beforeend", fila);
            });

        } catch (error) {
            tablaReservasHotelBody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center text-danger">No se pudieron cargar las reservas de hotel.</td>
                </tr>
            `;
        }
    }

    async function cargarReservasRestaurante() {
        if (!tablaReservasRestauranteBody) return;

        tablaReservasRestauranteBody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center">Cargando reservas...</td>
            </tr>
        `;

        try {
            const respuesta = await fetch("php/obtener_reservas_restaurante_usuario.php");
            const resultado = await respuesta.json();

            if (!resultado.success) {
                tablaReservasRestauranteBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center text-danger">${resultado.message}</td>
                    </tr>
                `;
                return;
            }

            if (!resultado.reservas || resultado.reservas.length === 0) {
                tablaReservasRestauranteBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center">No tienes reservas de restaurante.</td>
                    </tr>
                `;
                return;
            }

            tablaReservasRestauranteBody.innerHTML = "";

            resultado.reservas.forEach(reserva => {
                const fila = `
                    <tr>
                        <td>${formatearFechaHora(reserva.fecha_hora)}</td>
                        <td>${reserva.num_personas}</td>
                        <td>${obtenerBadgeEstado(reserva.estado)}</td>
                        <td>${reserva.observaciones ? reserva.observaciones : "-"}</td>
                        <td class="text-center">
                            ${obtenerBotonCancelar("restaurante", reserva.id_reserva_restaurante, reserva.estado, reserva.fecha_hora)}
                        </td>
                    </tr>
                `;

                tablaReservasRestauranteBody.insertAdjacentHTML("beforeend", fila);
            });

        } catch (error) {
            tablaReservasRestauranteBody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-danger">No se pudieron cargar las reservas de restaurante.</td>
                </tr>
            `;
        }
    }

    async function cargarReservasCelebraciones() {
        if (!tablaReservasCelebracionesBody) return;

        tablaReservasCelebracionesBody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center">Cargando reservas...</td>
            </tr>
        `;

        try {
            const respuesta = await fetch("php/obtener_reservas_celebraciones_usuario.php");
            const resultado = await respuesta.json();

            if (!resultado.success) {
                tablaReservasCelebracionesBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center text-danger">${resultado.message}</td>
                    </tr>
                `;
                return;
            }

            if (!resultado.reservas || resultado.reservas.length === 0) {
                tablaReservasCelebracionesBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center">No tienes reservas de celebraciones.</td>
                    </tr>
                `;
                return;
            }

            tablaReservasCelebracionesBody.innerHTML = "";

            resultado.reservas.forEach(reserva => {
                const fila = `
                    <tr>
                        <td>${reserva.tipo_celebracion || "-"}</td>
                        <td>${formatearFecha(reserva.fecha_celebracion)}</td>
                        <td>${reserva.num_personas}</td>
                        <td>${reserva.precio_estimado !== null ? reserva.precio_estimado + " €" : "-"}</td>
                        <td>${obtenerBadgeEstado(reserva.estado)}</td>
                        <td>${reserva.observaciones ? reserva.observaciones : "-"}</td>
                        <td class="text-center">
                            ${obtenerBotonCancelar("celebraciones", reserva.id_reserva_celebracion, reserva.estado, reserva.fecha_celebracion)}
                        </td>
                    </tr>
                `;

                tablaReservasCelebracionesBody.insertAdjacentHTML("beforeend", fila);
            });

        } catch (error) {
            tablaReservasCelebracionesBody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center text-danger">No se pudieron cargar las reservas de celebraciones.</td>
                </tr>
            `;
        }
    }

    async function cancelarReserva(tipo, idReserva) {
        const confirmacion = await alerta.fire({
            icon: "warning",
            title: "¿Cancelar reserva?",
            text: "Esta acción cambiará el estado de la reserva a anulada.",
            showCancelButton: true,
            confirmButtonText: "Sí, cancelar",
            cancelButtonText: "No"
        });

        if (!confirmacion.isConfirmed) return;

        const datos = new FormData();
        datos.append("tipo", tipo);
        datos.append("id_reserva", idReserva);

        try {
            const respuesta = await fetch("php/cancelar_reserva_usuario.php", {
                method: "POST",
                body: datos
            });

            const resultado = await respuesta.json();

            if (!resultado.success) {
                await alerta.fire({
                    icon: "error",
                    title: "Error",
                    text: resultado.message
                });
                return;
            }

            await alerta.fire({
                icon: "success",
                title: "Reserva cancelada",
                text: resultado.message
            });

            if (tipo === "hotel") {
                cargarReservasHotel();
            } else if (tipo === "restaurante") {
                cargarReservasRestaurante();
            } else if (tipo === "celebraciones") {
                cargarReservasCelebraciones();
            }

        } catch (error) {
            await alerta.fire({
                icon: "error",
                title: "Error de conexión",
                text: "No se ha podido conectar con el servidor"
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
    }

    if (btnReservasHotel) {
        btnReservasHotel.addEventListener("click", async function () {
            mostrarPage("page-reservas-hotel");
            await cargarReservasHotel();
        });
    }

    if (btnReservasRestaurante) {
        btnReservasRestaurante.addEventListener("click", async function () {
            mostrarPage("page-reservas-restaurante");
            await cargarReservasRestaurante();
        });
    }

    if (btnReservasCelebraciones) {
        btnReservasCelebraciones.addEventListener("click", async function () {
            mostrarPage("page-reservas-celebraciones");
            await cargarReservasCelebraciones();
        });
    }

    if (btnVolverPerfilHotel) {
        btnVolverPerfilHotel.addEventListener("click", function () {
            mostrarPage("page-perfil-inicio");
        });
    }

    if (btnVolverPerfilRestaurante) {
        btnVolverPerfilRestaurante.addEventListener("click", function () {
            mostrarPage("page-perfil-inicio");
        });
    }

    if (btnVolverPerfilCelebraciones) {
        btnVolverPerfilCelebraciones.addEventListener("click", function () {
            mostrarPage("page-perfil-inicio");
        });
    }

    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-cancelar-reserva")) {
            const tipo = e.target.dataset.tipo;
            const idReserva = e.target.dataset.id;

            cancelarReserva(tipo, idReserva);
        }
    });

    mostrarPage("page-perfil-inicio");
    cargarPerfil();
});