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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../Estilos/estilologin.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100" data-aos="fade-up" data-aos-delay="200">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div data-aos="fade-down" data-aos-delay="250" class="col-md-12 right-box">
                <div class="row align-items-center">
                    <div class="mb-3">
                        <a href="javascript:history.back()" class="btn btn-outline-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l5.147 5.146a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
                            </svg>
                            Volver
                        </a>
                    </div>
                    <div class="header-text mb-4">
                        <h2>Generar Reporte</h2>
                    </div>
                    <h2>Seleccione el tipo de reporte</h2>
                    <?php if ($rol_usuario == 'admin'): ?>
                        <form action="../reportes/reporteGlobal.php" method="post" target="_blank" class="mb-3">
                            <button type="submit" class="btn btn-lg btn-primary w-100 fs-6" style="background: #7F0E16;">Generar Reporte Global</button>
                        </form>
                    <?php endif; ?>

                    <form action="../reportes/seleccionarFechasM.php" method="post" class="mb-3">
                        <button type="submit" class="btn btn-lg btn-primary w-100 fs-6" style="background: #7F0E16;">Generar Reporte Mensual</button>
                    </form>
                    
                    <form action="../reportes/seleccionarFechas.php" method="post" class="mb-3">
                        <button type="submit" class="btn btn-lg btn-primary w-100 fs-6" style="background: #7F0E16;">Generar Reporte Semanal</button>
                    </form>

                    <?php if ($rol_usuario == 'admin'): ?>
                        <form id="reporteForm" action="../reportes/reporteEmpleado.php" method="post" style="display:none;" target="_blank">
                            <input type="hidden" id="cedulaInput" name="cedula">
                        </form>
                        <button id="generarReporteBtn" class="btn btn-lg btn-primary w-100 fs-6 mb-3" style="background: #7F0E16;">Generar Reporte Empleado</button>
                        <input type="hidden" id="error" value="<?php echo isset($error) ? $error : ''; ?>">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div id="dialog" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Ingresar número de cédula</h2>
            <input type="text" id="cedula" class="form-control" placeholder="Número de cédula">
            <button class="btn btn-primary w-100 fs-6 mt-2" id="aceptarBtn" style="background: #7F0E16;">Aceptar</button>
        </div>
    </div>

    <footer class="text-center mt-4">
        &copy; 2024 Grupo 5. Computación Visual.
    </footer>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 120,
            delay: 0,
            duration: 400,
            easing: 'ease',
            once: false,
            mirror: false,
            anchorPlacement: 'top-bottom',
        });

        document.addEventListener('DOMContentLoaded', function() {
            var dialog = document.getElementById('dialog');
            var cedulaInput = document.getElementById('cedula');
            var aceptarBtn = document.getElementById('aceptarBtn');
            var reporteForm = document.getElementById('reporteForm');
            var errorInput = document.getElementById('error');

            if (errorInput.value) {
                alert(errorInput.value);
            }

            var generarReporteBtn = document.getElementById('generarReporteBtn');
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
    </script>
</body>
</html>
