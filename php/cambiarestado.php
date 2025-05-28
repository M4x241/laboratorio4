<?php
header('Content-Type: application/json');
include('conexion.php'); // Ajusta si tu conexión tiene otro nombre

// Leer los datos JSON recibidos
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$nuevo_estado = $data['nuevo_estado'];

// Validar datos
if (!$id || !$nuevo_estado) {
    echo json_encode(["message" => "Datos incompletos"]);
    exit;
}

// Ejecutar actualización
$sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $nuevo_estado, $id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Estado actualizado correctamente"]);
} else {
    echo json_encode(["message" => "Error al actualizar estado"]);
}

$stmt->close();
$conn->close();
?>
