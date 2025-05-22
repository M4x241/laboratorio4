<?php session_start();
include("conexion.php");
$correo = $_POST['correo'];
$password = sha1($_POST['password']);
$stmt = $con->prepare('SELECT correo,nombre,rol FROM usuarios WHERE correo=? AND password=?');
$stmt->bind_param("ss", $correo, $password);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo "Usuario encontrado";
    $_SESSION['correo'] = $correo;
    $_SESSION['rol'] = $result->fetch_assoc()['rol'];
    header("Location:pagina.php");
} else {
    echo "Error datos de autenticación incorrectos";
}
