<?php
   session_start();
?>

<!-- primero se carga el topbar -->
<?php require('topbar.php'); ?>
<!-- luego se carga el sidebar -->
<?php require('sidebar.php'); ?>

<!-- inicio del contenido principal -->
<div class="page-content">

    <h4 class="text-center text-secondary" >Asistencia Empleados</h4>

    <?php
    include '../modelo/conexion.php';

    $conexion = new Conexion();
    $conn = $conexion->conectar();

        $sql = "SELECT e.id, e.id_empleado, e.emple_nombre, e.emple_apellido, u.tipo_empleado, a.hora_entrada, a.Hora_salida 
        FROM empleados e
        JOIN usuarios u ON e.id_empleado = u.id_empleado
        LEFT JOIN asistencias a ON e.id_empleado = a.id_empleado";

$result = mysqli_query($conn, $sql);
    ?>

<table class="table" id="example" class="table-bordered table-hover col-12">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Empleado</th>
                <th scope="col">Cédula</th>
                <th scope="col">Cargo</th>
                <th scope="col">Entrada</th>
                <th scope="col">Salida</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['emple_nombre']) . ' ' . htmlspecialchars($row['emple_apellido']); ?></td>
                    <td><?php echo htmlspecialchars($row['id_empleado']); ?></td>
                    <td><?php echo htmlspecialchars($row['tipo_empleado']); ?></td>
                    <td><?php echo htmlspecialchars($row['hora_entrada']); ?></td>
                    <td><?php echo htmlspecialchars($row['Hora_salida']); ?></td>
                    <td>
                        <!-- Botones o enlaces para acciones como editar o eliminar podrían ir aquí -->
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
</div>
</div>
<!-- fin del contenido principal -->


<!-- por ultimo se carga el footer -->
<?php require('footer.php'); ?>