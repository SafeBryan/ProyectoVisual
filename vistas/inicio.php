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

// Consultar asistencias según el rol del usuario
if ($_SESSION['rol'] == 'admin') {
    $sql = "SELECT a.id_asistencia, e.id_empleado, e.emple_nombre, e.emple_apellido, u.tipo_empleado, a.fecha_asistencia, a.hora_entrada, a.hora_salida 
            FROM empleados e
            JOIN usuarios u ON e.id_empleado = u.id_empleado
            LEFT JOIN asistencias a ON e.id_empleado = a.id_empleado
            WHERE a.fecha_asistencia = CURDATE()";
} else {
    $id_empleado = $_SESSION['id_empleado'];
    $sql = "SELECT a.id_asistencia, e.id_empleado, e.emple_nombre, e.emple_apellido, u.tipo_empleado, a.fecha_asistencia, a.hora_entrada, a.hora_salida 
            FROM empleados e
            JOIN usuarios u ON e.id_empleado = u.id_empleado
            LEFT JOIN asistencias a ON e.id_empleado = a.id_empleado
            WHERE e.id_empleado = '$id_empleado' AND a.fecha_asistencia = CURDATE()";
}

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conn));
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
    <title>Asistencias</title>
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
            <?php if ($_SESSION['rol'] == 'admin') : ?>
                <li><a href="users.php"><i class='bx bx-group'></i>Users</a></li>
            <?php endif; ?>
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
            <form action="" method="get">
                <div class="form-input">
                </div>
            </form>
            <a href="#" class="profile">
                <img src="../img/user.png">
            </a>
        </nav>
        <!-- End of Navbar -->

        <main>
            <div class="header">
                <div class="left">
                    <h1>Asistencia Empleados</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Asistencia</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Data -->
            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Asistencias</h3>
                        <i class='bx bx-filter'></i>
                    </div>

                    <table class="table table-bordered table-hover col-12" id="example">
                        <thead>
                            <tr>
                                <th scope="col"># Asistencia</th>
                                <th scope="col">Empleado</th>
                                <th scope="col">Cédula</th>
                                <th scope="col">Cargo</th>
                                <th scope="col">Fecha Asistencia</th>
                                <th scope="col">Entrada</th>
                                <th scope="col">Salida</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id_asistencia']); ?></td>
                                    <td><?php echo htmlspecialchars($row['emple_nombre']) . ' ' . htmlspecialchars($row['emple_apellido']); ?></td>
                                    <td><?php echo htmlspecialchars($row['id_empleado']); ?></td>
                                    <td><?php echo htmlspecialchars($row['tipo_empleado']); ?></td>
                                    <td><?php echo htmlspecialchars($row['fecha_asistencia']); ?></td>
                                    <td><?php echo htmlspecialchars($row['hora_entrada']); ?></td>
                                    <td><?php echo htmlspecialchars($row['hora_salida']); ?></td>
                                    <td>
                                        <?php if ($_SESSION['rol'] == 'admin') : ?>
                                            <a href="inicio.php?id_asistencia=<?php echo $row['id_asistencia']; ?>" onclick="advertencia(event)"><i class='bx bxs-trash'></i></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
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
        $(function() {
            $('#example').DataTable({
                select: {
                    //style: 'multi'
                },
                responsive: true,
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                    "sInfo": "Registros del _START_ al _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Registros del 0 al 0 de 0 registros",
                    "sInfoFiltered": "-",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                }
            });
        });
    </script>
</body>

</html>
