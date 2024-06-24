<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, user-scalable=no" name="viewport">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <title>Plantilla-php</title>


    <!-- datatables -->
    <link rel="stylesheet" href="../public/app/publico/css/lib/datatables-net/datatables.min.css">
    <link rel="stylesheet" href="../public/app/publico/css/separate/vendor/datatables-net.min.css">




    <style>
        .marca {
            width: 100%;
            background: rgb(13, 39, 48);
            position: fixed;
            bottom: 0;
            z-index: 999;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }

        .marca__parrafo {
            margin: 0 !important;
            color: white;
        }

        .marca__texto {
            color: rgb(0, 162, 255);
            text-decoration: underline;
        }

        .marca__parrafo span {
            color: red;
        }

        .page-content {
            margin-top: 70px;
        }

        @media screen and (max-width:1056px) {
            .page-content {
                padding: 15px !important;
            }
        }
    </style>

</head>
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
            ";

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
<script src="../public/bootstrap5/js/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous">
    </script>


    <script src="../public/app/publico/js/lib/jquery/jquery.min.js">
    </script>
    <script src="../public/app/publico/js/lib/tether/tether.min.js">
    </script>
    <script src="../public/app/publico/js/lib/bootstrap/bootstrap.min.js">
    </script>
    <script src="../public/app/publico/js/plugins.js">
    </script>

    <!-- datatables -->
    <script src="../public/app/publico/js/lib/datatables-net/datatables.min.js"></script>



    <!-- sweet alert -->
    <script src="../public/sweet/js/sweetalert2.js"></script>
    <script src="../public/sweet/js/sweet.js"></script>


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


    <script type="text/javascript" src="../public/app/publico/js/lib/jqueryui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../public/app/publico/js/lib/lobipanel/lobipanel.min.js"></script>
    <script type="text/javascript" src="../public/app/publico/js/lib/match-height/jquery.matchHeight.min.js">
    </script>
    <script type="text/javascript" src="../public/loader/loader.js"></script>

    <script>
        $(document).ready(function() {

            $('.panel').lobiPanel({
                sortable: true
            });
            $('.panel').on('dragged.lobiPanel', function(ev, lobiPanel) {
                $('.dahsboard-column').matchHeight();
            });

            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('string', 'Day');
                dataTable.addColumn('number', 'Values');
                // A column for custom tooltip content
                dataTable.addColumn({
                    type: 'string',
                    role: 'tooltip',
                    'p': {
                        'html': true
                    }
                });
                dataTable.addRows([
                    ['MON', 130, ' '],
                    ['TUE', 130, '130'],
                    ['WED', 180, '180'],
                    ['THU', 175, '175'],
                    ['FRI', 200, '200'],
                    ['SAT', 170, '170'],
                    ['SUN', 250, '250'],
                    ['MON', 220, '220'],
                    ['TUE', 220, ' ']
                ]);

                var options = {
                    height: 314,
                    legend: 'none',
                    areaOpacity: 0.18,
                    axisTitlesPosition: 'out',
                    hAxis: {
                        title: '',
                        textStyle: {
                            color: '#fff',
                            fontName: 'Proxima Nova',
                            fontSize: 11,
                            bold: true,
                            italic: false
                        },
                        textPosition: 'out'
                    },
                    vAxis: {
                        minValue: 0,
                        textPosition: 'out',
                        textStyle: {
                            color: '#fff',
                            fontName: 'Proxima Nova',
                            fontSize: 11,
                            bold: true,
                            italic: false
                        },
                        baselineColor: '#16b4fc',
                        ticks: [0, 25, 50, 75, 100, 125, 150, 175, 200, 225, 250, 275, 300, 325, 350],
                        gridlines: {
                            color: '#1ba0fc',
                            count: 15
                        }
                    },
                    lineWidth: 2,
                    colors: ['#fff'],
                    curveType: 'function',
                    pointSize: 5,
                    pointShapeType: 'circle',
                    pointFillColor: '#f00',
                    backgroundColor: {
                        fill: '#008ffb',
                        strokeWidth: 0,
                    },
                    chartArea: {
                        left: 0,
                        top: 0,
                        width: '100%',
                        height: '100%'
                    },
                    fontSize: 11,
                    fontName: 'Proxima Nova',
                    tooltip: {
                        trigger: 'selection',
                        isHtml: true
                    }
                };

                var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                chart.draw(dataTable, options);
            }
            $(window).resize(function() {
                drawChart();
                setTimeout(function() {}, 1000);
            });
        });
    </script>
    <script src="../public/app/publico/js/app.js">
    </script>

    <script src="../public/app/publico/js/lib/jquery-flex-label/jquery.flex.label.js"></script>

    <script type="application/javascript">
        (function($) {
            $(document).ready(function() {
                $('.fl-flex-label').flexLabel();
            });
        })(jQuery);
    </script>




