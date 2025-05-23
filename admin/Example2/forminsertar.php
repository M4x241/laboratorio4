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


    $sql = "SELECT id,nombre,correo,password,rol,estado from usuarios order by nombre";
    $result = mysqli_query($conexion, $sql);

    ?>
    <form action="javascript:crearUsuario()" method="post" enctype="multipart/form-data" id="form-crear">

        <label for="nombre">nombre:</label>
        <input type="text" name="nombre">
        <br>
        <label for="correo">Correo:</label>
        <input type="email" name="correo">
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password">
        <br>
        <label for="rol">Rol:</label>
        <select name="rol">
            <option value="admin">admin</option>
            <option value="usuario">user</option>

        </select>
        <br>
        <label for="estado">Estado:</label>
        <select name="estado">
            <option value="activo">activo</option>
            <option value="suspendido">suspendido</option>

        </select>
        <br>
        <input type="submit" value="Guardar">

    </form>

</body>

</html>