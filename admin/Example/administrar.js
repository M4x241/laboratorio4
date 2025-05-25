let correos = document.getElementById("correos");
let correosData = {
  "correos": [
    {
      "cuenta": "1@gmail.com",
      "propietario": "1",
      "opciones": "Eliminar"
    },
    {
      "correo": "2@gmail.com",
      "propietario": "2",
      "asunto": "Como estas",
      "opciones": "Eliminar"
    }
  ]
};
fetch("../../php/readusuario.php")
  .then((response) => response.json())
  .then((data) => {
    correosData = data;
    console.log(correosData);
    let correosHTML = "";
    for (let i = 0; i < correosData.correos.length; i++) {
      correosHTML += "<tr>";
      correosHTML += "<td>" + correosData.correos[i].cuenta + "</td>";
      correosHTML += "<td>" + correosData.correos[i].propietario + "</td>";
      correosHTML += "<td><button class='btn btn-primary btn-sm me-2'>Ver</button><button class='btn btn-danger btn-sm'>Borrar</button></td>";
      correosHTML += "</tr>";
    }
    correosHTML += "<br>";
    correosHTML += "<button class='btn btn-primary btn-sm me-2'>Agregar nuevo</button>";
    correos.innerHTML = correosHTML;
  })
  .catch((error) => {
    console.error("Error:", error);
  });

// let correosHTML = "";
// for (let i = 0; i < correosData.correos.length; i++) {
//   correosHTML += "<tr>";
//   correosHTML += "<td>" + correosData.correos[i].cuenta + "</td>";
//   correosHTML += "<td>" + correosData.correos[i].propietario + "</td>";
//   correosHTML += "<td><button class='btn btn-primary btn-sm me-2'>Ver</button><button class='btn btn-danger btn-sm'>Borrar</button></td>";
//   correosHTML += "</tr>";

// }
// correosHTML += "<br>";
// correosHTML += "<button class='btn btn-primary btn-sm me-2'>Agregar nuevo</button>";
// correos.innerHTML = correosHTML;
