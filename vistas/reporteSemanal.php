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

//obtenemos el nombre de quien inicio session
$usuario_id = $_SESSION['usuario_id'];
$sql_usuario = "SELECT emple_nombre, emple_apellido FROM empleados WHERE id_empleado = (SELECT id_empleado FROM usuarios WHERE id = '$usuario_id')";
$result_usuario = mysqli_query($conn, $sql_usuario);
$usuario = mysqli_fetch_assoc($result_usuario);

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
    <script>
        function setEndDate() {
            var startDate = document.getElementById('fechaInicio').value;
            var endDateInput = document.getElementById('fechaFin');
            if (startDate) {
                var startDateObj = new Date(startDate);
                var endDate = new Date(startDateObj.getFullYear(), startDateObj.getMonth(), startDateObj.getDate() + 7);

                endDateInput.min = startDate;
                endDateInput.value = endDate.toISOString().split('T')[0];  
                endDateInput.max = endDate.toISOString().split('T')[0];
            }
        }

        function submitForm(event) {
            event.preventDefault();
            var form = document.getElementById('reporteForm');
            var action = form.action;
            var method = form.method;
            var formData = new FormData(form);

            var params = new URLSearchParams();
            for (var pair of formData.entries()) {
                params.append(pair[0], pair[1]);
            }

            var url = action + '?' + params.toString();
            window.open(url, '_blank');
        }
    </script>
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

        .submenu {
            display: none;
            list-style: none;
            padding-left: 20px;
        }

        .submenu a {
            color: white;
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
                        <li><a href="reporteCedula.php" >Reporte por cédula</a></li>
                    <?php endif; ?>
                    <li><a href="reporteMensual.php" >Reporte Mensual</a></li>
                    <li><a href="reporteSemanal.php" >Reporte Semanal</a></li>
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
                    <h1>Reportes</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Reporte Semanal</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Data -->
            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Seleccion de Fecha:</h3>
                        <i class='bx bx-filter'></i>
                    </div>
                    <form id="reporteForm" action="../reportes/reporteSemanal.php" method="post" onsubmit="submitForm(event)" class="w-100">
                        <div class="mb-3">
                            <label for="fechaInicio" class="form-label">Fecha de inicio:</label>
                            <input type="date" id="fechaInicio" name="fechaInicio" class="form-control" required onchange="setEndDate()">
                        </div>
                        <div class="mb-3">
                            <label for="fechaFin" class="form-label">Fecha de fin:</label>
                            <input type="date" id="fechaFin" name="fechaFin" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-lg btn-primary w-100 fs-6" style="background: #7F0E16;">Generar Informe</button>
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
