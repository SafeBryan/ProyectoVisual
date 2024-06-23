
<?php
session_start();

// primero se carga el topbar
require('topbar.php');
// luego se carga el sidebar
require('sidebar.php');

// inicio del contenido principal
?>
<div class="page-content">
    <h4 class="text-center text-secondary">Asistencia Empleados</h4>

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
            WHERE a.fecha_asistencia = CURDATE()";

    $result = mysqli_query($conn, $sql);
    ?>

    <table class="table table-bordered table-hover col-12" id="example">
        <thead> 
            <tr>
                <th scope="col">ID</th>
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
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id_asistencia']); ?></td>
                    <td><?php echo htmlspecialchars($row['emple_nombre']) . ' ' . htmlspecialchars($row['emple_apellido']); ?></td>
                    <td><?php echo htmlspecialchars($row['id_empleado']); ?></td>
                    <td><?php echo htmlspecialchars($row['tipo_empleado']); ?></td>
                    <td><?php echo htmlspecialchars($row['fecha_asistencia']); ?></td>
                    <td><?php echo htmlspecialchars($row['hora_entrada']); ?></td>
                    <td><?php echo htmlspecialchars($row['hora_salida']); ?></td>
                    <td>
                        <a href="inicio.php?id_asistencia=<?php echo $row['id_asistencia']; ?>" onclick="advertencia(event)" class="btn btn-danger btn-sm"><i class="fa-solid fa-eraser"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<!-- fin del contenido principal -->

<!-- por último se carga el footer -->
<?php require('footer.php'); ?>
