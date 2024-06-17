<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paguina de Inicio</title>
    <link rel="stylesheet" href="Estilos/estilos.css">
</head>
<body>
    <h1> Bienvenido Registre Su Asistencia</h1>
    <h2 id="fecha"></h2>
    <div class="container">
        <a class:"acceso" href="vistas/login.php">Ingresar al Sistema</a>
        <p class="cedula">Ingrese su cedula</p>
        <form action="">
            <input type="number" placeholder="Cedula Empleado" name="txtCedula">
            <div class="botones">
            <a href="entrada" class="entrada" >Entrada</a>
            <a href="salida" class="salida" >Salida</a>
            </div>
        </form>
    </div>


    <script>
        setInterval(() => {
            let fecha = new Date();
            let fechaHora = fecha.toLocaleString();
            document.getElementById("fecha").textContent = fechaHora;
        }, 1000);
    </script>
</body>
</html>