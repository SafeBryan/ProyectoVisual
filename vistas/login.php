<?php 
include '../modelo/conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enviar'])) {
    $usuario = $_POST['usuario'];
    $contrasenia = $_POST['contrasenia'];

    // Crear conexión a la base de datos
    $conexion = new Conexion();
    $conn = $conexion->conectar();

    // Escapar las entradas para evitar inyección SQL
    $usuario = mysqli_real_escape_string($conn, $usuario);
    $contrasenia = mysqli_real_escape_string($conn, $contrasenia);

    // Consultar el usuario en la base de datos
    $sql = "SELECT u.usuario, u.id, u.rol, u.id_empleado, u.contrasenia, e.emple_nombre, e.emple_apellido 
            FROM usuarios u
            JOIN empleados e ON u.id_empleado = e.id_empleado
            WHERE u.usuario='$usuario'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Usuario encontrado
        $row = mysqli_fetch_assoc($result);
        
        // Verificar la contraseña
        $contraseniaHashed = $row['contrasenia'];
        if (password_verify($contrasenia, $contraseniaHashed) || $contrasenia === $contraseniaHashed) {
            // La contraseña coincide
            $_SESSION['usuario'] = $usuario;
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['rol'] = $row['rol'];
            $_SESSION['id_empleado'] = $row['id_empleado'];
            $_SESSION['nombre'] = $row['emple_nombre']; 
            $_SESSION['apellido'] = $row['emple_apellido']; 

            // Redirigir según el rol del usuario
            header("Location: inicio.php");
            exit(); // Asegurar que no se ejecute más código después de la redirección
        } else {
            echo "Usuario o contraseña incorrectos.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../Estilos/estilologin.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <title>Inicio de Sesion</title>
</head>

<body>
    <!----------------------- Main Container -------------------------->
    <div class="container d-flex justify-content-center align-items-center min-vh-100" data-aos="fade-up" data-aos-delay="200">
        <!----------------------- Login Container -------------------------->
        <div class="row border rounded-5 p-3 bg-white shadow box-area">

            <!-------------------- ------ Right Box ---------------------------->

            <div data-aos="fade-down" data-aos-delay="250" class="col-md-12 right-box">
                <div class="row align-items-center">
                    <!-- Botón de retroceso -->
                    <div class="mb-3">
                        <a href="../index.php" class="btn btn-outline-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l5.147 5.146a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
                            </svg>
                            Volver
                        </a>
                    </div>
                    <form method="post">
                        <div class="header-text mb-4">
                            <h2>Iniciar Sesion</h2>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" id="usuario" name="usuario" class="form-control form-control-lg bg-light fs-6" placeholder="Ingrese su correo" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" id="contrasenia" name="contrasenia" class="form-control form-control-lg bg-light fs-6" placeholder="Ingrese su contraseña" required>
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" name="enviar" class="btn btn-lg btn-primary w-100 fs-6" style="background: #7F0E16;">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
            offset: 120, // offset (in px) from the original trigger point
            delay: 0, // values from 0 to 3000, with step 50ms
            duration: 400, // values from 0 to 3000, with step 50ms
            easing: 'ease', // default easing for AOS animations
            once: false, // whether animation should happen only once - while scrolling down
            mirror: false, // whether elements should animate out while scrolling past them
            anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation
        });
    </script>
</body>

</html>
