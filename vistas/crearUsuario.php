<?php
session_start();

// Asegurarse de que el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../vistas/login.php");
    exit();
}

// Incluir archivos necesarios
include '../modelo/conexion.php';

// Crear conexión a la base de datos
$conexion = new Conexion();
$conn = $conexion->conectar();

$update_success = false;
$error_message = '';
$form_data = [
    'id_empleado' => '',
    'emple_nombre' => '',
    'emple_apellido' => '',
    'emple_direccion' => '',
    'emple_telefono' => '',
    'usuario' => '',
    'contrasenia' => '',
    'tipo_empleado' => '',
    'rol' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener y sanitizar los datos del formulario
    $form_data['id_empleado'] = mysqli_real_escape_string($conn, $_POST['id_empleado']);
    $form_data['emple_telefono'] = mysqli_real_escape_string($conn, $_POST['emple_telefono']);

    // Validar que id_empleado y emple_telefono tengan exactamente 10 dígitos
    if (!preg_match('/^\d{10}$/', $form_data['id_empleado'])) {
        $error_message = "Error: ID Empleado debe ser un número de 10 dígitos.";
    } elseif (!preg_match('/^\d{10}$/', $form_data['emple_telefono'])) {
        $error_message = "Error: Teléfono debe ser un número de 10 dígitos.";
    } else {
        // Verificar si el id_empleado ya existe
        $sql_check_id = "SELECT id_empleado FROM empleados WHERE id_empleado = '{$form_data['id_empleado']}'";
        $result_check_id = mysqli_query($conn, $sql_check_id);

        if (mysqli_num_rows($result_check_id) > 0) {
            $error_message = "Error: Cédula existente.";
        } else {
            $form_data['emple_nombre'] = mysqli_real_escape_string($conn, $_POST['emple_nombre']);
            $form_data['emple_apellido'] = mysqli_real_escape_string($conn, $_POST['emple_apellido']);
            $form_data['emple_direccion'] = mysqli_real_escape_string($conn, $_POST['emple_direccion']);
            $form_data['usuario'] = mysqli_real_escape_string($conn, $_POST['usuario']);
            $form_data['contrasenia'] = password_hash(mysqli_real_escape_string($conn, $_POST['contrasenia']), PASSWORD_BCRYPT);
            $form_data['tipo_empleado'] = mysqli_real_escape_string($conn, $_POST['tipo_empleado']);
            $form_data['rol'] = mysqli_real_escape_string($conn, $_POST['rol']);

            // Insertar datos en la tabla de empleados
            $sql_insert_empleado = "INSERT INTO empleados (id_empleado, emple_nombre, emple_apellido, emple_direccion, emple_telefono) 
                                    VALUES ('{$form_data['id_empleado']}', '{$form_data['emple_nombre']}', '{$form_data['emple_apellido']}', '{$form_data['emple_direccion']}', '{$form_data['emple_telefono']}')";

            if (mysqli_query($conn, $sql_insert_empleado)) {
                // Insertar datos en la tabla de usuarios
                $sql_insert_usuario = "INSERT INTO usuarios (usuario, contrasenia, rol, tipo_empleado, id_empleado) 
                                       VALUES ('{$form_data['usuario']}', '{$form_data['contrasenia']}', '{$form_data['rol']}', '{$form_data['tipo_empleado']}', '{$form_data['id_empleado']}')";

                if (mysqli_query($conn, $sql_insert_usuario)) {
                    $update_success = true;
                    // Limpiar datos del formulario
                    $form_data = [
                        'id_empleado' => '',
                        'emple_nombre' => '',
                        'emple_apellido' => '',
                        'emple_direccion' => '',
                        'emple_telefono' => '',
                        'usuario' => '',
                        'contrasenia' => '',
                        'tipo_empleado' => '',
                        'rol' => ''
                    ];
                } else {
                    $error_message = "Error al crear el usuario: " . mysqli_error($conn);
                }
            } else {
                $error_message = "Error al crear el empleado: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Estilos/estilologin.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <title>Crear Usuario</title>
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
                    <?php if ($update_success) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Usuario creado con éxito.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php elseif (!empty($error_message)) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($error_message); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <form action="crearUsuario.php" method="post">
                        <div class="mb-3">
                            <label for="id_empleado" class="form-label">ID Empleado</label>
                            <input type="number" class="form-control form-control-lg bg-light fs-6" id="id_empleado" name="id_empleado" value="<?php echo htmlspecialchars($form_data['id_empleado']); ?>" required pattern="\d{10}" title="Debe ser un número de 10 dígitos" maxlength="10">
                        </div>
                        <div class="mb-3">
                            <label for="emple_nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control form-control-lg bg-light fs-6" id="emple_nombre" name="emple_nombre" value="<?php echo htmlspecialchars($form_data['emple_nombre']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="emple_apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control form-control-lg bg-light fs-6" id="emple_apellido" name="emple_apellido" value="<?php echo htmlspecialchars($form_data['emple_apellido']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="emple_direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control form-control-lg bg-light fs-6" id="emple_direccion" name="emple_direccion" value="<?php echo htmlspecialchars($form_data['emple_direccion']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="emple_telefono" class="form-label">Teléfono</label>
                            <input type="number" class="form-control form-control-lg bg-light fs-6" id="emple_telefono" name="emple_telefono" value="<?php echo htmlspecialchars($form_data['emple_telefono']); ?>" required pattern="\d{10}" title="Debe ser un número de 10 dígitos" maxlength="10">
                        </div>
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control form-control-lg bg-light fs-6" id="usuario" name="usuario" value="<?php echo htmlspecialchars($form_data['usuario']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="contrasenia" class="form-label">Contraseña</label>
                            <input type="password" class="form-control form-control-lg bg-light fs-6" id="contrasenia" name="contrasenia" value="<?php echo htmlspecialchars($form_data['contrasenia']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipo_empleado" class="form-label">Tipo de Empleado</label>
                            <select class="form-control form-control-lg bg-light fs-6" id="tipo_empleado" name="tipo_empleado" required>
                                <option value="docente" <?php echo $form_data['tipo_empleado'] == 'docente' ? 'selected' : ''; ?>>Docente</option>
                                <option value="limpieza" <?php echo $form_data['tipo_empleado'] == 'limpieza' ? 'selected' : ''; ?>>Limpieza</option>
                                <option value="administrativo" <?php echo $form_data['tipo_empleado'] == 'administrativo' ? 'selected' : ''; ?>>Administrativo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <select class="form-control form-control-lg bg-light fs-6" id="rol" name="rol" required>
                                <option value="admin" <?php echo $form_data['rol'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="empleado" <?php echo $form_data['rol'] == 'empleado' ? 'selected' : ''; ?>>Empleado</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 fs-6" style="background: #7F0E16;">Crear Usuario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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
