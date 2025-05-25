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
