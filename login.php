<?php 
session_start();

$_SESSION["intentos_sesion"] = 1;

require_once "config/SERVER.php";
require_once "./model/mainModel.php"; // se incluye el model principal

?>
<!DOCTYPE html>
<html lang="es">

<head>
    
    <?php require_once "./view/inc/meta_include.php"; ?>


    <!-- Favicons -->
    <link href="./view/img/<?= LOGO ?>" rel="shortcut icon" type="image/x-icon">

    <!-- sweet-alert 2 -->
    <link href="./view/css/sweetalert2.min.css" rel="stylesheet">
    <link href="./view/css/toastify.css" rel="stylesheet">

    <link href="./view/css/bootstrap.min.css" rel="stylesheet">
    <link href="./view/css/bootstrap-icons.css" rel="stylesheet">
    <link href="./view/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <link href="./view/css/animate.min.css" rel="stylesheet">

    <link href="./view/css/nice_admin_styles/styles.css" rel="stylesheet">
    <style>
        body{
            background: url('./view/img/banner.webp') no-repeat center center fixed;
            background-size: 100vw 100vh;
            overflow-x: hidden;
        }
    </style>

</head>

<body class="toggle-sidebar">
    <header id="header" class="gap-3 align-items-center d-flex fixed-top header justify-content-between px-3">

        <div class="d-flex align-items-center justify-content-between d-non d-lg-block">
            <a href="./" class="logo d-flex align-items-center">
                <img src="./view/img/<?= LOGO ?>" alt="Logo de <?= COMPANY ?>">
                <span class=""><?= COMPANY ?></span>
            </a>
        </div>

        <div class="d-flex align-items-center">
            <a href="./" class="nav-link d-flex align-items-center">
                <i class="bi bi-house fs-3"></i>
                <span class="ms-2">Catálogo</span>
            </a>
        </div>
    </header>
    <div class="msjFormSend"></div>

    <div>
    
        <main id="main" class="main">
    
            <div class="row align-items-center justify-content-center p-4">
                <form id="login" method="POST" action="./controller/login.php" data-type-form="load" autocomplete="off" class="card SendFormAjax text-start p-2 rounded-4 col-12 col-md-4">
                    
                    <div class="text-center mb-2">
                        <img src="./view/img/<?= LOGO ?>" class="w-100 h-100 rounded-bottom-0 rounded-4" alt="Imagen del producto">
                        <h2 class="text-lg fw-bold text-center mt-2">Acceso Administrativo</h2>

                    </div>
        
                    <div class="p-2">

                        <div class="text-start mb-3">
                            <label for="user" class="form-label fw-bold">Cédula / RIF &nbsp;<span style="color:#f00; font-size: 1.5rem;">*</span></label>
                            <div class="input-group shadow-md">
                                <span class="input-group-text"> <i class="bi bi-person-circle"></i> </span>
                                <input id="user" name="user" type="text" placeholder="Cédula / RIF" 
                                    required class="form-control">
                            </div>
                        </div>
    
                        <div class="text-start mb-2">
                            <label for="pass" class="form-label fw-bold">Contraseña &nbsp;<span style="color:#f00; font-size: 1.5rem;">*</span></label>
                            <div class="input-group shadow-md">
                                <span class="input-group-text"> <i class="bi bi-lock"></i> </span>
                                <input id="pass" name="pass" type="password" placeholder="Contraseña" required class="form-control">
                                <button id="btnEyeIcon" type="button" class="btn btn-secondary input-group-text" title="Mostrar contraseña" 
                                    onclick="show_password('eyeIcon', 'pass')">
                                        <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>
    
                        
                        <div class="text-start mb-4">
                            <p class="w-100 text-muted mt-4 small">Los campos con  <span style="color:#f00; font-size: 1.5rem;">*</span> son obligatorios.</p>
                        </div>
    
                        <div class="text-center mb-2">
                            <button type="submit" class="mb-4 w-100 btn btn-primary p-2 rounded-5 fw-bold">Entrar</button>
                        </div>
                        
                        <div class="text-center mb-2">
                            <a href="./" class="mb-4 w-100 btn btn-outline-primary p-2 rounded-5 fw-bold">Volver al catálogo</a>
                        </div>
                    </div>
                    
                </form>
            </div>
    
        </main>
    </div>

    <!-- modal recuperar contraseña -->
    <div class="modal fade p-5" id="recuperar_contraseña" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="SendFormAjax" method="post" action="./api/recuperar_contraseña">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3 text-white" id="exampleModalLabel"><i class="text-white bi bi-key"></i>&nbsp; Recuperar Contraseña</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-start">
                            <label class="mb-3 text-white text-start" for="selecciona_metodo_de_recuperacion">Selecciona el Método de Recuperación<span style="color:#f00;">*</span></label>
                            <select required name="selecciona_metodo_de_recuperacion" id="selecciona_metodo_de_recuperacion" class="form-select">
                                <option disabled>Selecciona una opción</option>
                                <option value="correo">Recibir un Código por Correo </option>
                                <option value="preguntas">Responder las Preguntas de Seguridad</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="aceptar">Aceptar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="msjFormSend"></div>
    
    <script src="view/js/index.js"></script>
    <script type="text/javascript" src="view/js/jquery-3.6.0.min.js"></script>
    <script src="view/js/bootstrap.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="view/js/sweetalert2.min.js"></script>
    <script src="view/js/DanikatAlert.js"></script>
    <script src="view/js/hiddenInput.js"></script>
    <script src="view/js/SendForm.js"></script>
    <script> SendFormAjax(); </script>
    <script src="view/js/validator.js"></script>
</body>

</html>