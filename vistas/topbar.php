<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, user-scalable=no" name="viewport">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <title>Plantilla-php</title>

    <link href="https://tresplazas.com/web/img/big_punto_de_venta.png" rel="shortcut icon">
    <link href="../public/app/publico/css/lib/font-awesome/font-awesome.min.css" rel="stylesheet">
    <link href="../public/bootstrap5/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <link rel="stylesheet" href="../public/app/publico/css/lib/lobipanel/lobipanel.min.css">
    <link rel="stylesheet" href="../public/app/publico/css/separate/vendor/lobipanel.min.css">
    <link rel="stylesheet" href="../public/app/publico/css/lib/jqueryui/jquery-ui.min.css">
    <link rel="stylesheet" href="../public/app/publico/css/separate/pages/widgets.min.css">

    <!-- font awesome -->
    <link rel="stylesheet" href="../public/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../public/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- datatables -->
    <link rel="stylesheet" href="../public/app/publico/css/lib/datatables-net/datatables.min.css">
    <link rel="stylesheet" href="../public/app/publico/css/separate/vendor/datatables-net.min.css">

    <link href="../public/app/publico/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../public/app/publico/css/main.css" rel="stylesheet">
    <link href="../public/app/publico/css/mis_estilos/estilos.css" rel="stylesheet">

    <!-- form -->
    <link rel="stylesheet" type="text/css" href="../public/app/publico/css/lib/jquery-flex-label/jquery.flex.label.css"> <!-- Original -->

    <!-- mis estilos -->
    <link href="../public/principal/css/estilos.css" rel="stylesheet">

    <!-- pNotify -->
    <link href="../public/pnotify/css/pnotify.css" rel="stylesheet" />
    <link href="../public/pnotify/css/pnotify.buttons.css" rel="stylesheet" />
    <link href="../public/pnotify/css/custom.min.css" rel="stylesheet" />

    <!-- google fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery (si no está ya incluido) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- pnotify -->
    <script src="../public/pnotify/js/jquery.min.js"></script>
    <script src="../public/pnotify/js/pnotify.js"></script>
    <script src="../public/pnotify/js/pnotify.buttons.js"></script>

    <!-- alpine js -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    <!-- chart js -->
    <script src="../public/chart/chart.js"></script>

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

<body class="with-side-menu">
    <div id="app">
        <header class="site-header">
            <div class="container-fluid" style="padding-left: 40px;">
                <a href="#" class="site-logo"></a>
                <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
                    <span>toggle menu</span>
                </button>
                <button class="hamburger hamburger--htla">
                    <span>toggle menu</span>
                </button>
                <div class="site-header-content">
                    <div class="site-header-content-in">
                        <div class="site-header-shown">
                            <div class="dropdown dropdown-notification">
                                <h6 class="text-light mt-2">
                                    Administrador
                                </h6>
                            </div>
                            <div class="dropdown user-menu">
                                <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="../public/app/publico/img/user.svg" alt="">
                                </button>
                                <div class="dropdown-menu dropdown-menu-right pt-0" aria-labelledby="dd-user-menu">
                                    <!-- Aquí mostramos el nombre y apellido del usuario desde la sesión PHP -->
                                    <h5 class="p-2 text-center bg-primary">
                                        <?php
                                        if (isset($_SESSION['nombre']) && isset($_SESSION['apellido'])) {
                                            echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];
                                        } else {
                                            echo "Usuario Desconocido";
                                        }
                                        ?>
                                    </h5>
                                    <a class="dropdown-item" href=""><span class="font-icon glyphicon glyphicon-user"></span>Perfil</a>
                                    <a class="dropdown-item" href=""><span class="font-icon glyphicon glyphicon-lock"></span>Cambiar contraseña</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../controlador/cerrarSecion.php">
                                        <span class="font-icon glyphicon glyphicon-log-out"></span>Salir
                                    </a>
                                </div>
                            </div>
                            <div class="mobile-menu-right-overlay"></div>
                            <div class="site-header-collapsed"></div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="mobile-menu-left-overlay"></div>
    </div>
</body>

</html>
