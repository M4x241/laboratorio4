<?php
session_start();
include("conexion.php");

$correo = $_POST['correo'];
$password = sha1($_POST['password']);

$stmt = $conexion->prepare('SELECT correo, nombre, rol, estado FROM usuarios WHERE correo=? AND password=?'); // <-- AÑADIDO estado
$stmt->bind_param("ss", $correo, $password);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); 
    echo "Usuario encontrado";
    $_SESSION['correo'] = $correo;
    $_SESSION['rol'] = $row['rol'];
    $_SESSION['estado'] = $row['estado']; 
    header("Location:../admin/Example2/example2.html");
} else {
    echo "Error datos de autenticación incorrectos";
    
}
