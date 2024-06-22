<?php
include_once "modelo/conexion.php";

// Establecer la zona horaria
date_default_timezone_set('America/Guayaquil'); // Esta es la zona horaria del servidor

if (isset($_POST["btnSalida"])) {
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

                // Determinar la jornada basándose en la hora actual con un margen de 10 minutos después del fin de la jornada
                $jornada_query = $conn->query("SELECT id_jornada, fin_jornada FROM trabajo_jornadas WHERE ('$hora_actual' BETWEEN inicio_jornada AND DATE_ADD(fin_jornada, INTERVAL 10 MINUTE))");

                if ($jornada_query && $jornada_query->num_rows > 0) {
                    $jornada = $jornada_query->fetch_object();
                    $id_jornada = $jornada->id_jornada;
                    $fin_jornada = $jornada->fin_jornada;

                    // Verificar si ya existe un registro de entrada para este empleado en esta jornada y fecha
                    $verificar_query = $conn->query("SELECT * FROM asistencias WHERE id_empleado = '$id_empleado' AND id_jornada = '$id_jornada' AND fecha_asistencia = '$fecha' AND hora_salida IS NULL");

                    if ($verificar_query->num_rows > 0) {
                        // Actualizar la asistencia en la tabla asistencias, registrando la hora de salida
                        if ($hora_actual > $fin_jornada) {
                            $hora_salida_registro = $fin_jornada;
                        } else {
                            $hora_salida_registro = $hora_actual;
                        }

                        $sql = $conn->query("UPDATE asistencias SET hora_salida = '$hora_salida_registro' WHERE id_empleado = '$id_empleado' AND id_jornada = '$id_jornada' AND fecha_asistencia = '$fecha'");

                        if ($sql) {
                            echo "<script>
                                $(document).ready(function() {
                                    new PNotify({
                                        title: 'Salida registrada',
                                        text: 'Salida registrada para el empleado ID: $id_empleado a las $hora_salida_registro',
                                        type: 'success',
                                        styling: 'bootstrap3'
                                    });
                                });
                            </script>";
                        } else {
                            echo "<script>
                                $(document).ready(function() {
                                    new PNotify({
                                        title: 'Salida no registrada',
                                        text: 'Salida no registrada para el empleado ID: $id_empleado',
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
                                    title: 'Salida ya registrada o entrada no encontrada',
                                    text: 'Ya se ha registrado una salida para este empleado en esta jornada o no se encontró una entrada previa',
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
