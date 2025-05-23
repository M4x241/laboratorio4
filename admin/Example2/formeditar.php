<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php session_start();
    require '../../php/conexion.php';
    require("../../php/verificarsession.php");
    require("../../php/verificarrol.php");
    require("../../php/verificarestado.php");


    $id = $_GET['id'];
    $sql = "SELECT id,nombre,correo,password,rol,estado FROM usuarios WHERE id=$id";
    // echo $sql;
    $resultado = $conexion->query($sql);
    $row = $resultado->fetch_assoc();

    ?>
    <form action="javascript:guardarEditar()" id="form-edit" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="nombre">Nombres:</label>
        <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>">
        <br>
        <label for="correo">Correo:</label>
        <input type="email" name="correo" value="<?php echo $row['correo']; ?>">
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" value="<?php echo $row['password']; ?>">
        <br>
        <label for="rol">Rol:</label>
        <select name="rol">
            <option value="admin" <?php if ($row['rol'] == 'admin') echo 'selected'; ?>>admin</option>
            <option value="usuario" <?php if ($row['rol'] == 'usuario') echo 'selected'; ?>>usuario</option>
        </select>

        <br>
        <label for="estado">Estado:</label>
        <select name="estado">
            <option value="activo" <?php if ($row['estado'] == 'activo') echo 'selected'; ?>>activo</option>
            <option value="suspendido" <?php if ($row['estado'] == 'suspendido') echo 'selected'; ?>>suspendido</option>
        </select>

        <br>
        <input type="submit" value="Guardar">

    </form>

</body>

</html>