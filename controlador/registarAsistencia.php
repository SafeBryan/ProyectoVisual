<?php
include_once "modelo/conexion.php";

// Establecer la zona horaria
date_default_timezone_set('America/Guayaquil'); // Esta es la zona horaria del server

if (isset($_POST["btnEntrada"])) {
    if (!empty($_POST["txtCedula"])) {
        $conexion = new Conexion();
        $conn = $conexion->conectar();

        if ($conn) {
            $cedula = $_POST["txtCedula"];
            
            // Consulta para verificar si la cédula existe
            $consulta = $conn->query("SELECT id_empleado FROM empleados WHERE id_empleado = '$cedula'");

            if ($consulta && $consulta->num_rows > 0) {
                $id_empleado = $consulta->fetch_object()->id_empleado;
                $fecha = date("Y-m-d");
                $hora_actual = date("H:i:s");

                // Determinar la jornada basándose en la hora actual con un margen de 15 minutos antes del inicio de la jornada
                $jornada_query = $conn->query("SELECT id_jornada, inicio_jornada FROM trabajo_jornadas WHERE ('$hora_actual' BETWEEN DATE_SUB(inicio_jornada, INTERVAL 15 MINUTE) AND fin_jornada)");

                if ($jornada_query && $jornada_query->num_rows > 0) {
                    $jornada = $jornada_query->fetch_object();
                    $id_jornada = $jornada->id_jornada;
                    $inicio_jornada = $jornada->inicio_jornada;

                    // Verificar si ya existe un registro de entrada para este empleado en esta jornada y fecha
                    $verificar_query = $conn->query("SELECT * FROM asistencias WHERE id_empleado = '$id_empleado' AND id_jornada = '$id_jornada' AND fecha_asistencia = '$fecha'");

                    if ($verificar_query->num_rows == 0) {
                        // Determinar la hora de entrada a registrar
                        $hora_entrada_registrar = $hora_actual <= $inicio_jornada ? $inicio_jornada : $hora_actual;

                        // Insertar la asistencia en la tabla asistencias
                        $sql = $conn->query("INSERT INTO asistencias (id_empleado, id_jornada, fecha_asistencia, hora_entrada) VALUES ('$id_empleado', '$id_jornada', '$fecha', '$hora_entrada_registrar')");

                        if ($sql) {
                            echo "<script>
                                $(document).ready(function() {
                                    new PNotify({
                                        title: 'Entrada registrada',
                                        text: 'Entrada registrada para el empleado ID: $id_empleado a las $hora_entrada_registrar',
                                        type: 'success',
                                        styling: 'bootstrap3'
                                    });
                                });
                            </script>";
                        } else {
                            echo "<script>
                                $(document).ready(function() {
                                    new PNotify({
                                        title: 'Entrada no registrada',
                                        text: 'Entrada no registrada para el empleado ID: $id_empleado',
                                        type: 'error',
                                        styling: 'bootstrap3'
                                    });
                                });
                            </script>";
                        }
                    } else {
                        echo "<script>
                            $(document).ready(function() {
                                new PNotify({
                                    title: 'Entrada ya registrada',
                                    text: 'Ya se ha registrado una entrada para este empleado en esta jornada',
                                    type: 'error',
                                    styling: 'bootstrap3'
                                });
                            });
                        </script>";
                    }
                } else {
                    echo "<script>
                        $(document).ready(function() {
                            new PNotify({
                                title: 'Jornada no encontrada',
                                text: 'No se encontró una jornada correspondiente para la hora actual',
                                type: 'error',
                                styling: 'bootstrap3'
                            });
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    $(document).ready(function() {
                        new PNotify({
                            title: 'INCORRECTO',
                            text: 'La cédula no existe',
                            type: 'error',
                            styling: 'bootstrap3'
                        });
                    });
                </script>";
            }
        } else {
            echo "<script>
                $(document).ready(function() {
                    new PNotify({
                        title: 'Error',
                        text: 'No se pudo conectar a la base de datos',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
                });
            </script>";
        }
    } else {
        echo "<script>
            $(document).ready(function() {
                new PNotify({
                    title: 'INCORRECTO',
                    text: 'Debe ingresar la cédula',
                    type: 'error',
                    styling: 'bootstrap3'
                });
            });
        </script>";
    }
}
?>
