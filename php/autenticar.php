<?php
session_start();
include("conexion.php");

$correo = $_POST['correo'];
$password = sha1($_POST['password']);

$stmt = $conexion->prepare('SELECT correo, nombre, rol, estado FROM usuarios WHERE correo=? AND password=?');
$stmt->bind_param("ss", $correo, $password);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['correo'] = $correo;
    $_SESSION['rol'] = $row['rol'];
    $_SESSION['estado'] = $row['estado'];
    $_SESSION['id'] = $row['id'];

    if ($row['rol'] === 'admin') {
        header("Location:../admin/Example/example2.html");
    } else {
        header("Location:../user/userPage.html");
    }
    exit();
} else {
    echo "Error datos de autenticación incorrectos";
}
