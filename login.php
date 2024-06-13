<?php
include 'conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasenia = $_POST['contrasenia'];

    $conexion = new Conexion();
    $conn = $conexion->conectar();

    $usuario = mysqli_real_escape_string($conn, $usuario);
    $contrasenia = mysqli_real_escape_string($conn, $contrasenia);

    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND contrasenia='$contrasenia'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['usuario'] = $usuario;
        $_SESSION['usuario_id'] = $row['id'];
        $_SESSION['rol'] = $row['rol'];
        $_SESSION['id_empleado'] = $row['id_empleado']; // Asegurarse de que el id_empleado se establezca aquí
        header("Location: reportes.php");
    } else {
        echo "Usuario o contraseña incorrectos.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" type="text/css" href="JQUERY/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="JQUERY/themes/black/easyui.css">
    <link rel="stylesheet" type="text/css" href="JQUERY/easyui/themes/color.css">
    <link rel="stylesheet" type="text/css" href="JQUERY/easyui/demo/demo.css">
    <script type="text/javascript" src="JQUERY/jquery.min.js"></script>
    <script type="text/javascript" src="JQUERY/jquery.easyui.min.js"></script>

</head>
<body>
    <h2>Login</h2>
    <form method="post" action="login.php">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <br>
        <label for="contrasenia">Contraseña:</label>
        <input type="password" id="contrasenia" name="contrasenia" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
