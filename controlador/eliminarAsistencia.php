<?php
include_once '../modelo/conexion.php';

if (isset($_GET['id_asistencia'])) {
    $id_asistencia = $_GET['id_asistencia'];

    $conexion = new Conexion();
    $conn = $conexion->conectar();

    $sql = "DELETE FROM asistencias WHERE id_asistencia = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_asistencia);

    if ($stmt->execute()) { ?>
        <script>
            $(function notification() {
                new PNotify({
                    title: 'Correcto',
                    text: 'Asistencia eliminada correctamente',
                    type: 'success',
                    styling: 'bootstrap3'
                });
            });
        </script>
    <?php } else { ?>
        <script>
            $(function notification() {
                new PNotify({
                    title: 'Error',
                    text: 'No se pudo eliminar la asistencia',
                    type: 'error',
                    styling: 'bootstrap3'
                });
            });
        </script>
    <?php }
    $stmt->close();
    $conn->close();
} ?>

<script>
    setTimeout(() => {
        window.history.replaceState(null, null, window.location.pathname);
    }, 0);
</script>
