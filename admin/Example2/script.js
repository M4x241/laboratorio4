var modal = document.getElementById("myModal");
var openModalBtn = document.getElementById("openModalBtn");
var closeBtn = document.getElementsByClassName("close")[0];

//me muestra el modal
mostrar = function () {
  modal.style.display = "block";
};

//cierra el modal
closeBtn.onclick = function () {
  modal.style.display = "none";
};
//cierra el modal cuando hay click fuera del modal
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

//crear un usuario
function formCrear() {
  var url = `forminsertar.php`;
  var contenedor = document.getElementById("panel");
  fetch(url)
    .then((response) => response.text())
    .then((data) => {
      document.querySelector("#titulo-modal").innerHTML = "crear";
      document.querySelector("#contenido-modal").innerHTML = data;
      document.getElementById("myModal").style.display = "block";
    });
}

function crearUsuario() {
  var datos = new FormData(document.querySelector("#form-crear"));

  fetch("../../php/createusuario.php", { method: "POST", body: datos })
    .then((response) => response.text())
    .then((data) => (document.querySelector("#panel").innerHTML = data));
}


//editar un usuario

function editar(id) {
  var url = `formeditar.php?id=${id}`;
  var contenedor = document.getElementById("panel");
  fetch(url)
    .then((response) => response.text())
    .then((data) => {
      document.querySelector("#titulo-modal").innerHTML = "Editar";
      document.querySelector("#contenido-modal").innerHTML = data;
      document.getElementById("myModal").style.display = "block";
    });
}

function guardarEditar() {
  var datos = new FormData(document.querySelector("#form-edit"));

  fetch("../../php/editusuario.php", { method: "POST", body: datos })
    .then((response) => response.text())
    .then((data) => {
      document.querySelector("#titulo-modal").innerHTML = "Mensaje";
      document.querySelector("#contenido-modal").innerHTML = data;
      mostrar();
    });
}




function listar() {
  const contenedor = document.getElementById("panel");

  fetch("../../php/readusuario.php")
    .then((response) => response.text())
    .then((data) => {
      objeto = JSON.parse(data);
      contenedor.innerHTML = renderizarTablaRead(objeto);
    });
}

function renderizarTablaRead(objeto) {
  let lista = objeto.datos;
  let html = `<h4>Administrar Cuentas</h4>
  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Rol</th>
        <th>Estado</th>
        <th>operaciones</th>
      </tr>
    </thead>
    <tbody>`;

  for (var i = 0; i < lista.length; i++) {
    html += `<tr>
      <td>${lista[i].id}</td>
      <td>${lista[i].nombre}</td>
      <td>${lista[i].correo}</td>
      <td>${lista[i].rol}</td>
      <td>${lista[i].estado}</td>
        <td><a href="javascript:editar('${lista[i].id}')">Editar</a>  <a href="javascript:eliminar('${lista[i].id}')">Eliminar</a>  <a href="javascript:ver('${lista[i].correo}')">ver</a> </td>    </tr>`;
  }

  html += `</tbody></table>
  <div><a href="javascript:formCrear()">insertar</a></div>
  `;
  return html;
}

//elimina un usuario
function eliminar(id) {
  var url = `../../php/deleteusuario.php?id=${id}`;
  var contenedor = document.getElementById("panel");
  fetch(url)
    .then((response) => response.text())
    .then((data) => {
      contenedor.innerHTML = data;
      listar();
    });
}

//edita un usuario



//destruye la sesion y no nos deja las listas deusuarios
function cerrarsession() {
  fetch("../../php/cerrar.php")
    .then(() => {
      document.getElementById("panel").innerHTML = "<p>Cerrando sesión...</p>";
      setTimeout(() => {
        window.location.href = "../../auten/login.html";
      }, 1000);
    });
}