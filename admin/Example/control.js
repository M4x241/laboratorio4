let correos = document.getElementById("correos");
let correosData = {
  "correos": [
    {
      "correo": "1@gmail.com",
      "titulo": "Hola",
      "asunto": "Como estas",
      "opciones": "Eliminar",
      "fecha": "2023-10-01"
    },
    {
      "correo": "2@gmail.com",
      "titulo": "Hola",
      "asunto": "Como estas",
      "opciones": "Eliminar",
      "fecha": "2023-10-01"
    }
  ]
};

let correosHTML = "";
for (let i = 0; i < correosData.correos.length; i++) {
  correosHTML += "<tr>";
  correosHTML += "<td>" + correosData.correos[i].cuenta + "</td>";
  correosHTML += "<td>" + correosData.correos[i].estado + "</td>";
  correosHTML += "<td><button class='btn btn-primary btn-sm me-2'>Ver</button><button class='btn btn-danger btn-sm'>Borrar</button></td>";
  correosHTML += "<td>" + correosData.correos[i].cambiarEstado + "</td>";
  correosHTML += "</tr>";
}
correos.innerHTML = correosHTML;