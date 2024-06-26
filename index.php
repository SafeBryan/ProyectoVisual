<!-- <!DOCTYPE html>
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
--include_once "modelo/conexion.php";
--include "controlador/registarAsistencia.php";
</html> -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link href="public/pnotify/css/pnotify.css" rel="stylesheet" />
    <link href="public/pnotify/css/pnotify.buttons.css" rel="stylesheet" />
    <link href="public/pnotify/css/custom.min.css" rel="stylesheet" />
    <script src="public/pnotify/js/jquery.min.js"></script>
    <script src="public/pnotify/js/pnotify.js"></script>
    <script src="public/pnotify/js/pnotify.buttons.js"></script>
    <link href="Estilos\estiloindex.css" rel="stylesheet" />

    <title>Registro Asistencia</title>
</head>
<body>
    <!----------------------- Main Container -------------------------->
    <div class="container d-flex justify-content-center align-items-center min-vh-100" data-aos="fade-up" data-aos-delay="200">
        <!----------------------- Login Container -------------------------->
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <!--------------------------- Left Box ----------------------------->
            <div data-aos="fade-down" data-aos-delay="150" class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #7F0E16;">
                <div class="featured-image mb-3">
                    <img src="img/1.png" class="img-fluid" style="width: 250px;">
                </div>
                <p class="text-white fs-3" style="font-family: 'Courier New', Courier, monospace; font-weight: 600; padding-top: 50px;">Registre Su Asistencia</p>
            </div>
            <!-------------------- ------ Right Box ---------------------------->
            <div data-aos="fade-down" data-aos-delay="250" class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2>Cedula Empleado</h2>
                        <?php
                        include_once "modelo/conexion.php";
                        include "controlador/registarAsistencia.php";
                        include "controlador/registrarSalida.php";
                        ?>
                        <p id="fecha" style="font-size: 1.8rem;"></p>
                    </div>
                    <div class="input-group mb-3">
                        <form method="POST" class="w-100">
                            <input type="number" class="form-control form-control-lg bg-light fs-6" placeholder="Ingrese su cedula" name="txtCedula">
                            <div class="botones">
                                <button class="btn btn-lg btn-primary w-100 fs-6 mt-2" type="submit" name="btnEntrada" style="background: #7F0E16;" value="ok">Entrada</button>
                                <button class="btn btn-lg btn-primary w-100 fs-6 mt-2" type="submit" name="btnSalida" style="background: #7F0E16;" value="ok">Salida</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!----------------- Center the button ---------------->
                <div class="d-flex justify-content-center" style="padding-top: 20px;">
                    <div class="input-group mb-3" style="max-width: 50%;">
                        <a href="vistas/login.php" class="btn btn-lg btn-primary w-100 fs-6" style="background: #7F0E16;">Ingresar al Sistema</a>
                    </div>
                </div>
                <!----------------- End of button centering ---------------->
            </div>
        </div>
    </div>
    <script>
        setInterval(() => {
            let fecha = new Date();
            let fechaHora = fecha.toLocaleString();
            document.getElementById("fecha").textContent = fechaHora;
        }, 100);
    </script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 120, // offset (in px) from the original trigger point
            delay: 0, // values from 0 to 3000, with step 50ms
            duration: 400, // values from 0 to 3000, with step 50ms
            easing: 'ease', // default easing for AOS animations
            once: false, // whether animation should happen only once - while scrolling down
            mirror: false, // whether elements should animate out while scrolling past them
            anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation
        });
    </script>
</body>
</html>