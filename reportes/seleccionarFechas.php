<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Fechas para el Informe Semanal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../Estilos/estilologin.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script type="text/javascript" src="../JQUERY/jquery.min.js"></script>
    <script type="text/javascript" src="../JQUERY/jquery.easyui.min.js"></script>
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
                        <h2>Seleccione las Fechas para el Informe Semanal</h2>
                    </div>
                    <form id="reporteForm" action="reporteSemanal.php" method="post" onsubmit="submitForm(event)" class="w-100">
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
    </script>
</body>
</html>
