<?php
session_start();

// Asegurarse de que el usuario está autenticado y es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include '../modelo/conexion.php';
$conexion = new Conexion();
$conn = $conexion->conectar();

// Recibir el id del usuario a editar desde la URL
$editar_usuario_id = $_GET['id'] ?? '';

// Si no se proporciona un id, redirigir al listado de usuarios
if (empty($editar_usuario_id)) {
    header("Location: users.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$sql_usuario = "SELECT emple_nombre, emple_apellido FROM empleados WHERE id_empleado = (SELECT id_empleado FROM usuarios WHERE id = '$usuario_id')";
$result_usuario = mysqli_query($conn, $sql_usuario);
$usuario = mysqli_fetch_assoc($result_usuario);

// Consultar la información del usuario a editar
$sql_usuario = "SELECT id_empleado, usuario, tipo_empleado FROM usuarios WHERE id = '$editar_usuario_id'";
$result_usuario = mysqli_query($conn, $sql_usuario);
if ($usuario = mysqli_fetch_assoc($result_usuario)) {
    $update_success = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
        $tipo_empleado = mysqli_real_escape_string($conn, $_POST['tipo_empleado']);

        $sql_update = "UPDATE usuarios SET usuario = '$usuario', tipo_empleado = '$tipo_empleado' 
                       WHERE id = '$editar_usuario_id'";

        if (mysqli_query($conn, $sql_update)) {
            $update_success = true;
        }
    }
} else {
    echo "Usuario no encontrado.";
    exit();
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
    <title>Actualizar Información Personal</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100" data-aos="fade-up" data-aos-delay="200">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div data-aos="fade-down" data-aos-delay="250" class="col-md-12 right-box">
                <div class="row align-items-center">
                    <div class="mb-3">
                        <a href="users.php" class="btn btn-outline-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l5.147 5.146a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
                            </svg>
                            Volver
                        </a>
                    </div>
                    <form action="updateUser.php?id=<?php echo $editar_usuario_id; ?>" method="post">
                        <div class="header-text mb-4">
                            <h2>Actualizar Usuario</h2>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" id="id_empleado" name="id_empleado" class="form-control form-control-lg bg-light fs-6" value="<?php echo htmlspecialchars($usuario['id_empleado']); ?>" readonly>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" id="usuario" name="usuario" class="form-control form-control-lg bg-light fs-6" value="<?php echo htmlspecialchars($usuario['usuario']); ?>" required>
                        </div>
                        <div class="input-group mb-3">
                            <select id="tipo_empleado" name="tipo_empleado" class="form-control form-control-lg bg-light fs-6" required>
                                <option value="">Seleccione uno...</option>
                                <?php
                                $tipos = ['docente', 'limpieza', 'administrativo']; // Estos son los valores del enum en la base de datos
                                foreach ($tipos as $tipo) {
                                    echo "<option value='$tipo'" . ($tipo == $usuario['tipo_empleado'] ? " selected" : "") . ">$tipo</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" class="btn btn-lg btn-primary w-100 fs-6" style="background: #7F0E16;">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 120,
            delay: 0,
            duration: 400,
            easing: 'ease',
            once: false,
            mirror: false,
            anchorPlacement: 'top-bottom',
        });
    </script>
</body>

</html>
