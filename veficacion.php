<?php
session_start();
require('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = (new conexion())->conectar();
    $usuario = $_POST['usuario'];
    $contrasenia = $_POST['contrasenia'];

    $stmt = $conn->prepare("SELECT id, contrasenia, rol, id_empleado FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado && $resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();
        
        if (password_verify($contrasenia, $fila['contrasenia'])) {
            $_SESSION['usuario_id'] = $fila['id'];
            $_SESSION['rol'] = $fila['rol'];
            $_SESSION['id_empleado'] = $fila['id_empleado'];

            header("Location: reportes.php");
            exit();
        } else {
            header("Location: index.php?error=incorrect_password");
        }
    } else {
        header("Location: index.php?error=user_not_found");
    }
    $stmt->close();
    $conn->close();
}
?>
