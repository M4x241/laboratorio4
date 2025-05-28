function toggleMenu() {
  const sidebar = document.getElementById("sidebar");
  sidebar.classList.toggle("d-none");
}
function mostrar(pagina) {
  const contenido = document.getElementById("panel");

  // Remover la clase activa de todos los enlaces
  document.querySelectorAll(".sidebar a").forEach((link) => {
    link.classList.remove("active");
  });

  // Añadir clase activa al enlace clicado
  const linkActivo = Array.from(document.querySelectorAll(".sidebar a")).find(
    (a) => a.textContent.toLowerCase().includes(pagina)
  );
  if (linkActivo) linkActivo.classList.add("active");

  fetch(pagina + ".html")
    .then((res) => {
      if (!res.ok) throw new Error("Página no encontrada");
      return res.text();
    })
    .then((data) => {
      contenido.innerHTML = data;

      if (pagina === "borradoresSection") {
        mostrarborradores();
      } else if (pagina === "salidaSection") {
        mostrarsalida();
      } else if (pagina === "entradaSection") {
        mostrarentrada();
      }
    })
    .catch((error) => {
      contenido.innerHTML =
        '<div class="alert alert-danger">No se pudo cargar la sección: ' +
        pagina +
        "</div>";
      console.error(error);
    });
}
function mostrarborradores() {
  let correosData;
  fetch("../php/readcorreosPendiente.php")
    .then((response) => response.json())
    .then((data) => {
      correosData = data.datos;
      console.log(correosData);
      console.log(correosData.length);
      let correosHTML = "";
      for (let i = 0; i < correosData.length; i++) {
        correosHTML += `<tr style="cursor: pointer;" onclick="leercorreo(${correosData[i].id})">`;
        correosHTML += "<td>" + correosData[i].correo + "</td>";
        correosHTML += "<td>" + correosData[i].asunto + "</td>";
        correosHTML += "<td>" + correosData[i].fecha + "</td>";
        correosHTML += "<td>" + correosData[i].estado + "</td>";
        correosHTML += `<td>
                  <button class='btn btn-primary btn-sm' onclick="event.stopPropagation(); editarCorreo(${correosData[i].id})">Enviar</button>
                  <button class='btn btn-danger btn-sm' onclick="event.stopPropagation(); borrarCorreo(${correosData[i].id})">Borrar</button>
                </td>`;
        correosHTML += "</tr>";
      }
      correos.innerHTML = correosHTML;
    })
    .catch((error) => {
      console.error("Error al cargar los correos:", error);
    });
}
function mostrarentrada() {
  let correosData;
  fetch("../php/readcorreosEntrada.php")
    .then((response) => response.json())
    .then((data) => {
      correosData = data.datos;
      console.log(correosData);
      console.log(correosData.length);
      let correosHTML = "";
      for (let i = 0; i < correosData.length; i++) {
        correosHTML += `<tr onclick="leercorreo(${correosData[i].id})"  style="cursor: pointer;">`;
        correosHTML += "<td>" + correosData[i].correo + "</td>";
        correosHTML += "<td>" + correosData[i].asunto + "</td>";
        correosHTML += "<td>" + correosData[i].fecha + "</td>";
        correosHTML += "<td>" + correosData[i].estado + "</td>";
        correosHTML += `<td>
                  <button class='btn btn-primary btn-sm' onclick="event.stopPropagation(); editarCorreo(${correosData[i].id})">Enviar</button>
                  <button class='btn btn-danger btn-sm' onclick="event.stopPropagation(); borrarCorreo(${correosData[i].id})">Borrar</button>
                </td>`;
        correosHTML += "</tr>";
      }
      correos.innerHTML = correosHTML;
    })
    .catch((error) => {
      console.error("Error al cargar los correos:", error);
    });
}
function mostrarsalida() {
  let correosData;
  fetch("../php/readcorreosSalida.php")
    .then((response) => response.json())
    .then((data) => {
      correosData = data.datos;
      console.log(correosData);
      console.log(correosData.length);
      let correosHTML = "";
      for (let i = 0; i < correosData.length; i++) {
        correosHTML += `<tr style="cursor: pointer;" onclick="leercorreo(${correosData[i].id})">`;
        correosHTML += "<td>" + correosData[i].correo + "</td>";
        correosHTML += "<td>" + correosData[i].asunto + "</td>";
        correosHTML += "<td>" + correosData[i].fecha + "</td>";
        correosHTML += "<td>" + correosData[i].estado + "</td>";
        correosHTML += `<td>
                  <button class='btn btn-danger btn-sm' onclick="event.stopPropagation(); borrarCorreo(${correosData[i].id})">Borrar</button>
                </td>`;
        correosHTML += "</tr>";
      }
      correos.innerHTML = correosHTML;
    })
    .catch((error) => {
      console.error("Error al cargar los correos:", error);
    });
}
function borrarCorreo(id) {
  fetch(`../php/deletecorreo.php?id=${id}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Correo borrado exitosamente");
        mostrarborradores();
      } else {
        alert("Error al borrar el correo");
      }
    })
    .catch((error) => {
      console.error("Error al borrar el correo:", error);
    });
}
//modal
function redactar() {
  const modal = document.getElementById("myModal");
  const span = document.getElementsByClassName("close")[0];
  const contenidoModal = document.getElementById("contenido-modal");
  const tituloModal = document.getElementById("titulo-modal");

  modal.style.display = "block";
  fetch("modalEmail.html")
    .then((res) => {
      if (!res.ok) throw new Error("Página no encontrada");
      return res.text();
    })
    .then((data) => {
      contenidoModal.innerHTML = data;
    })
    .catch((error) => {
      contenidoModal.innerHTML =
        '<div class="alert alert-danger">No se pudo cargar la sección: ' +
        pagina +
        "</div>";
      console.error(error);
    });

  span.onclick = function () {
    modal.style.display = "none";
  };
}
function guardarCorreo(estado) {
  const para = document.getElementById("para").value;
  const asunto = document.getElementById("asunto").value;
  const contenido = document.getElementById("contenido").value;
  console.log(para, asunto, contenido, estado);

  fetch("../php/createcorreo.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      para: para,
      asunto: asunto,
      mensaje: contenido,
      estado: estado,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data) {
        alert("Correo guardado exitosamente");
        const modal = document.getElementById("myModal");
        modal.style.display = "none";
      } else {
        alert("Error al guardar el correo");
      }
    })
    .catch((error) => {
      console.error("Error al guardar el correo:", error);
    });
}
function editarCorreo(id) {
  fetch(`../php/editcorreo.php?id=${id}`)
    .then((response) => response.json())
    .then((data) => {
      alert("Correo Enviado exitosamente");
    })
    .catch((error) => {
      console.error("Error al enviar el correo:", error);
    });
}
function leercorreo(id) {
  const modal = document.getElementById("myModal");
  const span = document.getElementsByClassName("close")[0];
  const contenidoModal = document.getElementById("contenido-modal");

  modal.style.display = "block";
  console.log("ID del correo clicado:", id);
  fetch(`../php/readcorreo.php?id=${id}`)
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      let correoData = data;
      contenidoModal.innerHTML = `
          <div class="d-flex justify-content-center align-items-center h-100">
            <div class="card" style="width: 80%; max-width: 500px;">
              <div class="card-header bg-primary text-white">
            <h1 class="h5">${correoData.asunto}</h1>
              </div>
              <div class="card-body">
            <p><strong>Correo:</strong> ${correoData.destinatario_correo}</p>
            <p><strong>Mensaje:</strong> ${correoData.mensaje}</p>
              </div>
              <div class="card-footer text-end">
            <small class="text-muted">${correoData.fecha}</small>
              </div>
            </div>
          </div>
          `;
    })
    .catch((error) => {
      console.error("Error al leer el correo:", error);
    });

  span.onclick = function () {
    modal.style.display = "none";
  };
}
