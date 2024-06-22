<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Fechas para el Informe Semanal</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" type="text/css" href="../JQUERY/themes/black/easyui.css">
    <link rel="stylesheet" type="text/css" href="../JQUERY/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="../JQUERY/easyui/themes/color.css">
    <link rel="stylesheet" type="text/css" href="../JQUERY/easyui/demo/demo.css">
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
    <header>
        <h1>Seleccione las Fechas para el Informe Semanal</h1>
    </header>
    <div class="container">
        <form id="reporteForm" action="reporteSemanal.php" method="post" onsubmit="submitForm(event)">
            <label for="fechaInicio">Fecha de inicio:</label>
            <input type="date" id="fechaInicio" name="fechaInicio" required onchange="setEndDate()">
            <label for="fechaFin">Fecha de fin:</label>
            <input type="date" id="fechaFin" name="fechaFin" required>
            <button type="submit">Generar Informe</button>
        </form>
        <button id="btnVolver">Volver</button>
<script>
    document.getElementById('btnVolver').addEventListener('click', function() {
        window.history.back();
    });
</script>
    </div>
    <footer>
        &copy; 2024 Grupo 5. Computación Visual.
    </footer>
</body>
</html>
