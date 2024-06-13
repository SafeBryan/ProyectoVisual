<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte Mensual</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" type="text/css" href="../JQUERY/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="../JQUERY/themes/black/easyui.css">
    <script type="text/javascript" src="../JQUERY/jquery.min.js"></script>
    <script type="text/javascript" src="../JQUERY/jquery.easyui.min.js"></script>
    <script>
        function setMonthDates() {
            var selectedMonth = document.getElementById('monthInput').value;
            var dateParts = selectedMonth.split('-');
            var year = parseInt(dateParts[0]);
            var month = parseInt(dateParts[1]);
            var endDate = new Date(year, month, 0); 

            var startDate = `${year}-${month.toString().padStart(2, '0')}-01`;
            var endDateFormatted = `${year}-${month.toString().padStart(2, '0')}-${endDate.getDate()}`;

            document.getElementById('fechaInicio').value = startDate;
            document.getElementById('fechaFin').value = endDateFormatted;
        }
    </script>
</head>
<body>
    <header>
        <h1>Reportes Mensuales</h1>
    </header>
    <div class="container">
        <form action="reporteMensual.php" method="post" target="_blank">
            <label for="monthInput">Seleccione el mes:</label>
            <input type="month" id="monthInput" onchange="setMonthDates()" required>
            <input type="hidden" id="fechaInicio" name="fechaInicio">
            <input type="hidden" id="fechaFin" name="fechaFin">
            <button type="submit">Generar Reporte</button>
        </form>
        <button id="btnVolver">Volver</button>
        <script>
        function goBackToReportes() {
            window.location.href = "http://localhost/PruebaVisual/reportes.php";
        }

        document.getElementById('btnVolver').onclick = goBackToReportes;
        </script>
    </div>
    <footer>
        &copy; 2024 Grupo 5. Computación Visual.
    </footer>
</body>
</html>
