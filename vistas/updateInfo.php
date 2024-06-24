<?php
session_start();

// Asegurarse de que el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Incluir archivos necesarios
include '../modelo/conexion.php';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Actualizar información del usuario
    $emple_nombre = mysqli_real_escape_string($conn, $_POST['emple_nombre']);
    $emple_apellido = mysqli_real_escape_string($conn, $_POST['emple_apellido']);
    $emple_direccion = mysqli_real_escape_string($conn, $_POST['emple_direccion']);
    $emple_telefono = mysqli_real_escape_string($conn, $_POST['emple_telefono']);

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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../Estilos/estiloinicio.css">
    <link rel="stylesheet" href="../public/app/publico/css/lib/datatables-net/datatables.min.css">
    <link rel="stylesheet" href="../public/app/publico/css/separate/vendor/datatables-net.min.css">
    <title>Actualizar Información Personal</title>
    <style>
        body {
            color: white;
        }

        .table th,
        .table td {
            color: white;
        }

        .sidebar,
        .sidebar a {
            color: white;
        }

        .btn,
        .search-btn {
            background: #7F0E16;
            color: white;
        }

        .search-btn {
            border: none;
        }

        .submenu {
            display: none;
            list-style: none;
            padding-left: 20px;
        }

        .submenu a {
            color: white;
        }

        .navbar-profile {
            display: flex;
            align-items: center;
        }

        .navbar-profile img {
            margin-right: 10px;
        }

        .navbar-profile .username {
            color: white;
        }

        .alert {
            padding: 20px;
            background-color: green;
            color: white;
            margin-bottom: 15px;
        }

        .alert.success {
            background-color: #4CAF50;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="inicio.php" class="logo">
            <i class='bx bxs-id-card'></i>
            <div class="logo-name"><span>Visual</span>APP</div>
        </a>
        <ul class="side-menu">
            <li><a href="inicio.php"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
            <?php if ($_SESSION['rol'] == 'admin') : ?>
                <li><a href="users.php"><i class='bx bx-group'></i>Users</a></li>
            <?php endif; ?>
            <li>
                <a href="#" class="submenu-toggle"><i class='bx bx-receipt'></i>Reportes</a>
                <ul class="submenu">
                    <?php if ($_SESSION['rol'] == 'admin') : ?>
                        <li><a href="../reportes/reporteGlobal.php" target="_blank">Reporte Global</a></li>
                        <li><a href="reporteCedula.php">Reporte por cédula</a></li>
                    <?php endif; ?>
                    <li><a href="reporteMensual.php">Reporte Mensual</a></li>
                    <li><a href="reporteSemanal.php">Reporte Semanal</a></li>
                </ul>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="../controlador/cerrarSecion.php" class="logout">
                    <i class='bx bx-log-out-circle'></i>Salir
                </a>
            </li>
        </ul>
    </div>
    <!-- End of Sidebar -->

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav>
            <i class='bx bx-menu'></i>
            <form action="" method="get">
                <div class="form-input">
                </div>
            </form>
            <a href="updateInfo.php" class="profile">
                <span class="username"><?php echo htmlspecialchars($usuario['emple_nombre']) . ' ' . htmlspecialchars($usuario['emple_apellido']); ?></span>
                <img src="../img/user.png">
            </a>
        </nav>
        <!-- End of Navbar -->

        <main>
            <div class="header">
                <div class="left">
                    <h1>Informacion Personal</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Editar Información</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Data -->
            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Datos Personales</h3>
                        <i class='bx bx-filter'></i>
                    </div>
                    <?php if ($update_success) : ?>
                        <div class="alert success">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                            Información actualizada con éxito.
                        </div>
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
                        <button type="submit" class="btn btn-primary">Actualizar Información</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="../jsinicio.js"></script>
    <script src="../public/bootstrap5/js/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    <script src="../public/app/publico/js/lib/jquery/jquery.min.js"></script>
    <script src="../public/app/publico/js/lib/tether/tether.min.js"></script>
    <script src="../public/app/publico/js/lib/bootstrap/bootstrap.min.js"></script>
    <script src="../public/app/publico/js/plugins.js"></script>
    <script src="../public/app/publico/js/lib/datatables-net/datatables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.submenu-toggle').click(function(e) {
                e.preventDefault();
                $(this).next('.submenu').slideToggle();
            });

            $('#example').DataTable({
                responsive: true,
                language: {
                    sProcessing: "Procesando...",
                    sLengthMenu: "Mostrar _MENU_ registros",
                    sZeroRecords: "No se encontraron resultados",
                    sEmptyTable: "Ningún dato disponible en esta tabla =(",
                    sInfo: "Registros del _START_ al _END_ de _TOTAL_ registros",
                    sInfoEmpty: "Registros del 0 al 0 de 0 registros",
                    sSearch: "Buscar:",
                    oPaginate: {
                        sFirst: "Primero",
                        sLast: "Último",
                        sNext: "Siguiente",
                        sPrevious: "Anterior"
                    },
                    buttons: {
                        copy: "Copiar",
                        colvis: "Visibilidad"
                    }
                }
            });
        });
    </script>
</body>

</html>
