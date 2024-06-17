<?php
session_start();


if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");  
    exit();
}


$rol_usuario = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" type="text/css" href="JQUERY/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="JQUERY/themes/black/easyui.css">
    <link rel="stylesheet" type="text/css" href="JQUERY/easyui/themes/color.css">
    <link rel="stylesheet" type="text/css" href="JQUERY/easyui/demo/demo.css">
    <script type="text/javascript" src="JQUERY/jquery.min.js"></script>
    <script type="text/javascript" src="JQUERY/jquery.easyui.min.js"></script>
</head>
<body>
    <header>
        <h1>Reportes</h1>
    </header>
    <div class="container">
        <h2>Seleccione el tipo de reporte</h2>

        <?php if ($rol_usuario == 'admin'): ?>
            <form action="../reportes/reporteGlobal.php" method="post" target="_blank">
                <button type="submit">Generar Reporte Global</button>
            </form>
        <?php endif; ?>

        <form action="../reportes/seleccionarFechasM.php" method="post">
            <button type="submit">Generar Reporte Mensual</button>
        </form>
        
        <form action="../reportes/seleccionarFechas.php" method="post">
            <button type="submit">Generar Reporte Semanal</button>
        </form>

        <?php if ($rol_usuario == 'admin'): ?>
            <form id="reporteForm" action="../reportes/reporteEmpleado.php" method="post" style="display:none;" target="_blank">
                <input type="hidden" id="cedulaInput" name="cedula">
            </form>
            <button id="generarReporteBtn">Generar Reporte Empleado</button>
            <input type="hidden" id="error" value="<?php echo isset($error) ? $error : ''; ?>">

        <?php endif; ?>

        <button id="btnVolver">Volver</buttom>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var dialog = document.getElementById('dialog');
                var cedulaInput = document.getElementById('cedula');
                var aceptarBtn = document.getElementById('aceptarBtn');
                var reporteForm = document.getElementById('reporteForm');
                var errorInput = document.getElementById('error');
                /*var errorDiv = document.getElementById('error');

                if (errorDiv) {
                    alert(errorDiv.innerText);
                    window.history.back(); // Volver a la página anterior
                }*/

                if (errorInput.value) {
                    alert(errorInput.value);
                }

                generarReporteBtn.addEventListener('click', function() {
                    dialog.style.display = 'block';
                });

                aceptarBtn.addEventListener('click', function() {
                    var cedula = cedulaInput.value.trim();
                    if (cedula) {
                        document.getElementById('cedulaInput').value = cedula;
                        reporteForm.submit();
                    } else {
                        alert('Por favor, ingresa un número de cédula.');
                    }
                });
                document.querySelector('.close').addEventListener('click', function() {
                    dialog.style.display = 'none';
                });
                
            });
            

            function goBackToReportes() {
                window.location.href = "http://localhost/PruebaVisual/login.php";
            }

            document.getElementById('btnVolver').onclick = goBackToReportes;
        </script>

    </div>
    <div id="dialog" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Ingresar número de cédula</h2>
            <input type="text" id="cedula" placeholder="Número de cédula">
            <button class="boton-cedula" id="aceptarBtn" disable>Aceptar</button>
            <button class="boton-cedula" id="cancelarBtn">Cancelar</button>
        </div>
    </div>
    <footer>
        &copy; 2024 Grupo 5. Computación Visual.
    </footer>
    <script src="script.js"></script>
</body>
</html>
