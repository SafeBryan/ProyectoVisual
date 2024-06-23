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

// Consultar todos los usuarios y sus cargos
$sql = "SELECT u.id, u.usuario, u.rol, e.emple_nombre, e.emple_apellido, u.tipo_empleado
        FROM usuarios u
        JOIN empleados e ON u.id_empleado = e.id_empleado";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../Estilos/estiloinicio.css">
    <title>Users | AsmrProg</title>
    <style>
        body {
            color: white;
        }
        .table th, .table td {
            color: white;
        }
        .sidebar, .sidebar a {
            color: white;
        }
        .btn, .search-btn {
            background: #7F0E16;
            color: white;
        }
        .search-btn {
            border: none;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo">
            <i class='bx bxs-id-card'></i>
            <div class="logo-name"><span>Asmr</span>Prog</div>
        </a>
        <ul class="side-menu">
            <li><a href="inicio.php"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
            <li><a href="users.php"><i class='bx bx-group'></i>Users</a></li>
            <li><a href="reportes.php"><i class='bx bx-receipt'></i>Reportes</a></li>
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
            <a href="#" class="profile">
                <img src="../img/user.png">
            </a>
        </nav>
        <!-- End of Navbar -->

        <main>
            <div class="header">
                <div class="left">
                    <h1>Usuarios</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Usuarios</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Data -->
            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-group'></i>
                        <h3>Lista de Usuarios</h3>
                        <i class='bx bx-filter'></i>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"># ID</th>
                                <th scope="col">Usuario</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Cargo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($row['emple_nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($row['emple_apellido']); ?></td>
                                    <td><?php echo htmlspecialchars($row['rol']); ?></td>
                                    <td><?php echo htmlspecialchars($row['tipo_empleado']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="../jsinicio.js"></script>
</body>

</html>
