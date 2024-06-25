<?php
session_start();

// Asegurarse de que el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Incluir archivos necesarios
require_once '../modelo/conexion.php';

// Crear conexión a la base de datos
$conexion = new Conexion();
$conn = $conexion->conectar();

// Obtener la información del usuario autenticado
$usuario_id = $_SESSION['usuario_id'];
$sql_usuario = "SELECT e.id_empleado, e.emple_nombre, e.emple_apellido, e.emple_direccion, e.emple_telefono
                FROM empleados e
                JOIN usuarios u ON e.id_empleado = u.id_empleado
                WHERE u.id = '$usuario_id'";
$result_usuario = mysqli_query($conn, $sql_usuario);
$usuario = mysqli_fetch_assoc($result_usuario);

$update_success = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emple_nombre = mysqli_real_escape_string($conn, $_POST['emple_nombre']);
    $emple_apellido = mysqli_real_escape_string($conn, $_POST['emple_apellido']);
    $emple_direccion = mysqli_real_escape_string($conn, $_POST['emple_direccion']);
    $emple_telefono = mysqli_real_escape_string($conn, $_POST['emple_telefono']);

    // Validar que el teléfono tenga exactamente 10 dígitos
    if (preg_match('/^\d{10}$/', $emple_telefono)) {
        $sql_update = "UPDATE empleados SET emple_nombre = '$emple_nombre', emple_apellido = '$emple_apellido', 
                       emple_direccion = '$emple_direccion', emple_telefono = '$emple_telefono' 
                       WHERE id_empleado = '{$usuario['id_empleado']}'";
        
        if (mysqli_query($conn, $sql_update)) {
            $update_success = true;
            // Actualizar los datos del usuario en la sesión
            $usuario['emple_nombre'] = $emple_nombre;
            $usuario['emple_apellido'] = $emple_apellido;
            $usuario['emple_direccion'] = $emple_direccion;
            $usuario['emple_telefono'] = $emple_telefono;
        }
    } else {
        $error_message = "El número de teléfono debe contener exactamente 10 dígitos.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../Estilos/estilologin.css">
    <title>Actualizar Información Personal</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-5 bg-white shadow">
            <div class="col-md-12">
                <div class="mb-3">
                    <a href="users.php" class="btn btn-outline-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l5.147 5.146a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
                        </svg>
                        Volver
                    </a>
                </div>
                <h2 class="text-center mb-4">Actualizar Información Personal</h2>
                <?php if (!empty($error_message)) : ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <?php if ($update_success) : ?>
                    <div class="alert alert-success">Información actualizada con éxito.</div>
                <?php endif; ?>
                <form action="updateInfo.php" method="post">
                    <div class="mb-3">
                        <label for="id_empleado" class="form-label">ID Empleado</label>
                        <input type="text" class="form-control" id="id_empleado" name="id_empleado" value="<?php echo htmlspecialchars($usuario['id_empleado']); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="emple_nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="emple_nombre" name="emple_nombre" value="<?php echo htmlspecialchars($usuario['emple_nombre']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="emple_apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="emple_apellido" name="emple_apellido" value="<?php echo htmlspecialchars($usuario['emple_apellido']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="emple_direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="emple_direccion" name="emple_direccion" value="<?php echo htmlspecialchars($usuario['emple_direccion']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="emple_telefono" class="form-label">Teléfono</label>
                        <input type="number" class="form-control" id="emple_telefono" name="emple_telefono" value="<?php echo htmlspecialchars($usuario['emple_telefono']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" style="background: #7F0E16;">Actualizar Información</button>
                </form>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
