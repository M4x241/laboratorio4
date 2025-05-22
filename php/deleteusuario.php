<?php session_start();
include("conexion.php");
require("verificarsesion.php");
require("verificarnivel.php");
require("verificarestado.php");

$id=$_GET['id'];


$stmt=$con->prepare('DELETE FROM usuarios WHERE id=?');
$stmt->bind_param("i",$id);
// Ejecutar la consulta
if ($stmt->execute()) {
    echo "usuario Eliminado";
} else {
    echo "Error: " . $stmt->error;
}

$con->close();
?>
