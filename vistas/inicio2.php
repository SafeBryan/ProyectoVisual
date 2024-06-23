<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="../Estilos/estiloinicio.css">
    <title>Responsive Dashboard Design #2 | AsmrProg</title>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo">
        <i class='bx bxs-id-card' ></i>
            <div class="logo-name"><span>Asmr</span>Prog</div>
        </a>
        <ul class="side-menu">
            <li><a href="#"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
            <li><a href="#"><i class='bx bx-group'></i>Users</a></li>
            <li><a href="#"><i class='bx bx-receipt'></i>Reportess</a></li>

        </ul>
        <ul class="side-menu">
            <li>

                <a href="../controlador/cerrarSecion.php" class="logout">
                    <i class='bx bx-log-out-circle'></i>
                    Salir
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
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <a href="#" class="profile">
                <img src="../img/user.png">
            </a>
        </nav>

        <!-- End of Navbar -->

        <main>

            <?php
            include '../modelo/conexion.php';
            include '../controlador/eliminarAsistencia.php';
            $conexion = new Conexion();
            $conn = $conexion->conectar();

            // Filtrar registros de asistencia basados en la fecha actual del servidor
            $sql = "SELECT a.id_asistencia, e.id_empleado, e.emple_nombre, e.emple_apellido, u.tipo_empleado, a.fecha_asistencia, a.hora_entrada, a.hora_salida 
            FROM empleados e
            JOIN usuarios u ON e.id_empleado = u.id_empleado
            LEFT JOIN asistencias a ON e.id_empleado = a.id_empleado
            ";

            $result = mysqli_query($conn, $sql);
            ?>
            <div class="header">
                <div class="left">
                    <h1>Asistencia Empleados</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Analiticas
                            </a></li>
                    </ul>
                </div>

            </div>

            <!-- Insights -->
            <ul class="insights">
                <li>
                    <i class='bx bx-calendar-check'></i>
                    <span class="info">
                        <h3>
                            1,074
                        </h3>
                        <p>Asistencias Diarias</p>
                    </span>
                </li>
                <li>
                    <i class='bx bx-calendar-check'></i>
                    <span class="info">
                        <h3>
                            1,074
                        </h3>
                        <p>Paid Order</p>
                    </span>
                </li>
                <li>
                    <i class='bx bx-calendar-check'></i>
                    <span class="info">
                        <h3>
                            1,074
                        </h3>
                        <p>Paid Order</p>
                    </span>
                </li>
                
            </ul>
            <!-- End of Insights -->

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Asistencias</h3>
                        <i class='bx bx-filter'></i>
                    </div>

                    <table class="">
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
                                        <a href="inicio.php?id_asistencia=<?php echo $row['id_asistencia']; ?>" onclick="advertencia(event)" > <i class='bx bxs-message-square-x'></i></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

               
            </div>

        </main>

    </div>

    <script src="/jsinicio.js"></script>
</body>

</html>