document.addEventListener("DOMContentLoaded", () => {
  const btnBuscarUsuario = document.getElementById("btn-buscar-usuario");
  const filtroTipoUsuario = document.getElementById("filtro-tipo-usuario");

  // CARGAR USUARIOS
  async function cargarUsuarios() {
    const busqueda = document.getElementById("busqueda-usuario").value;
    const filtro = document.getElementById("filtro-tipo-usuario").value;

    try {
      const response = await fetch("php/obtener_usuarios_admin.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          busqueda: busqueda,
          filtro: filtro,
        }),
      });

      const data = await response.json();

      const tbody = document.getElementById("tabla-usuarios-body");

      tbody.innerHTML = "";

      if (!data.success) {
        tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center">
                            Error al cargar usuarios
                        </td>
                    </tr>
                `;

        return;
      }

      if (data.usuarios.length === 0) {
        tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center">
                            No se encontraron usuarios
                        </td>
                    </tr>
                `;

        return;
      }

      data.usuarios.forEach((usuario) => {
        tbody.innerHTML += `
                    <tr>

                        <td>${usuario.nombre}</td>

                        <td>${usuario.apellidos}</td>

                        <td>${usuario.correo}</td>

                        <td>
                            ${usuario.rol}
                        </td>

                        <td class="text-center">

                            <button
                                class="btn btn-danger btn-sm btn-eliminar-usuario"
                                data-id="${usuario.id_usuario}">
                                Eliminar
                            </button>

                            <button
                                class="btn btn-warning btn-sm btn-cambiar-rol"
                                data-id="${usuario.id_usuario}"
                                data-rol="${usuario.rol}">
                                
                                ${
                                  usuario.rol === "admin"
                                    ? "Quitar admin"
                                    : "Hacer admin"
                                }
                            </button>

                        </td>

                    </tr>
                `;
      });

      agregarEventos();
    } catch (error) {
      console.error(error);
    }
  }

  // EVENTOS BOTONES
  function agregarEventos() {
    // ELIMINAR USUARIO
    document.querySelectorAll(".btn-eliminar-usuario").forEach((boton) => {
      boton.addEventListener("click", async () => {
        const idUsuario = boton.dataset.id;

        const confirmacion = await Swal.fire({
          title: "¿Eliminar usuario?",
          text: "Esta acción no se puede deshacer",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#79480C",
          cancelButtonColor: "#6c757d",
          confirmButtonText: "Sí, eliminar",
          cancelButtonText: "Cancelar",
        });

        if (!confirmacion.isConfirmed) return;

        const response = await fetch("php/eliminar_usuario.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            id_usuario: idUsuario,
          }),
        });

        const data = await response.json();

        Swal.fire({
          icon: data.success ? "success" : "error",
          title: data.message,
          confirmButtonColor: "#79480C",
        });

        cargarUsuarios();
      });
    });

    // CAMBIAR ROL
    document.querySelectorAll(".btn-cambiar-rol").forEach((boton) => {
      boton.addEventListener("click", async () => {
        const idUsuario = boton.dataset.id;

        const response = await fetch("php/cambiar_rol_usuario.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            id_usuario: idUsuario,
          }),
        });

        const data = await response.json();

        Swal.fire({
          icon: data.success ? "success" : "error",
          title: data.message,
          confirmButtonColor: "#79480C",
        });

        cargarUsuarios();
      });
    });
  }

  // EVENTOS FILTROS
  btnBuscarUsuario.addEventListener("click", cargarUsuarios);

  filtroTipoUsuario.addEventListener("change", cargarUsuarios);

  // CARGA INICIAL
  cargarUsuarios();

  // CARGAR RESERVAS
  async function cargarReservas() {
    const busqueda = document.getElementById("busqueda-reserva").value;
    const filtro = document.getElementById("filtro-tipo-reserva").value;

    try {
      const response = await fetch("php/obtener_reservas_admin.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          busqueda: busqueda,
          filtro: filtro,
        }),
      });

      const data = await response.json();

      const tbody = document.getElementById("tabla-reservas-body");

      tbody.innerHTML = "";

      if (!data.success) {
        tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center">
                        Error al cargar reservas
                    </td>
                </tr>
            `;

        return;
      }

      if (data.reservas.length === 0) {
        tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center">
                        No se encontraron reservas
                    </td>
                </tr>
            `;

        return;
      }

      data.reservas.forEach((reserva) => {
        tbody.innerHTML += `
                <tr>

                    <td>
                        ${reserva.nombre} ${reserva.apellidos}
                    </td>

                    <td>
                        ${reserva.correo}
                    </td>

                    <td>
                        ${reserva.tipo_reserva}
                    </td>

                    <td>
                        ${reserva.fechas}
                    </td>

                    <td>
                        ${reserva.estado}
                    </td>

                    <td class="text-center">

                      ${reserva.estado !== "confirmada" && reserva.estado !== "anulada"
                        ? `
                        <button
                          class="btn btn-success btn-sm btn-confirmar-reserva"
                          data-id="${reserva.id_reserva}"
                          data-tipo="${reserva.tipo}">
                          ${reserva.tipo === "hotel"
                            ? "Check in"
                            : "Confirmar"}
                        </button>
                        `
                        : ""
                        }

                        ${reserva.estado !== "anulada"
                          ? `
                          <button
                            class="btn btn-danger btn-sm btn-cancelar-reserva"
                            data-id="${reserva.id_reserva}"
                            data-tipo="${reserva.tipo}">
                            Cancelar
                          </button>
                          `
                          : ""
                        }
                    </td>

                </tr>
            `;
      });

      agregarEventosReservas();
    } catch (error) {
      console.error(error);
    }
  }

  // EVENTOS RESERVAS
  function agregarEventosReservas() {

    // CONFIRMAR RESERVA
    document.querySelectorAll(".btn-confirmar-reserva").forEach((boton) => {
      boton.addEventListener("click", async () => {

        const idReserva = boton.dataset.id;
        const tipo = boton.dataset.tipo;

        const confirmacion = await Swal.fire({
          title: "¿Confirmar reserva?",
          text: "La reserva pasará a confirmada",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#79480C",
          cancelButtonColor: "#6c757d",
          confirmButtonText: "Sí, confirmar",
          cancelButtonText: "Cancelar",
        });

        if (!confirmacion.isConfirmed) return;

        const response = await fetch("php/confirmar_reserva_admin.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            id_reserva: idReserva,
            tipo: tipo,
          }),
        });

        const data = await response.json();

        Swal.fire({
          icon: data.success ? "success" : "error",
          title: data.message,
          confirmButtonColor: "#79480C",
        });

        cargarReservas();
      });
    });

    // CANCELAR RESERVA
    document.querySelectorAll(".btn-cancelar-reserva").forEach((boton) => {
      boton.addEventListener("click", async () => {
        const idReserva = boton.dataset.id;
        const tipo = boton.dataset.tipo;

        const confirmacion = await Swal.fire({
          title: "¿Cancelar reserva?",
          text: "La reserva pasará a anulada",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#79480C",
          cancelButtonColor: "#6c757d",
          confirmButtonText: "Sí, cancelar",
          cancelButtonText: "Volver",
        });

        if (!confirmacion.isConfirmed) return;

        const response = await fetch("php/cancelar_reserva_admin.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            id_reserva: idReserva,
            tipo: tipo,
          }),
        });

        const data = await response.json();

        Swal.fire({
          icon: data.success ? "success" : "error",
          title: data.message,
          confirmButtonColor: "#79480C",
        });

        cargarReservas();
      });
    });
  }

  // EVENTOS FILTROS RESERVAS
  document
    .getElementById("btn-buscar-reserva")
    .addEventListener("click", cargarReservas);

  document
    .getElementById("filtro-tipo-reserva")
    .addEventListener("change", cargarReservas);
});