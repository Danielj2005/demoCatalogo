<?php
session_start();

require_once "../config/APP.php";
require_once "../config/SERVER.php";
require_once "../model/mainModel.php"; // se incluye el model principal
require_once "../model/productModel.php"; // se incluye el model producto
require_once "../model/categoryModel.php"; // se incluye el model de categorias


$estado = (!isset($_POST['estado_rol'])) ? '1' : $_POST['estado_rol'];
$catalogo = modeloPrincipal::consultar("SELECT id FROM productos WHERE estado = 1");


$titleCards = [
    "Usuarios",
    "Inventario",
    "Ventas",
    "Bitácora",
    "Configuración"
];
$iconCards = [
    "bi-people",
    "bi-box-seam-fill ",
    "bi-currency-dollar",
    "bi-clock-history",
    "bi-gear"
];


$cantRegCards = [
    "1",   
    "46",   
    "44",  
    "100",
    "1"
];

$footerCard = [
    "Usuarios registrados",
    "Productos registrados",
    "Ventas registradas",
    "Movimientos del sistema.",
    "Configuración del sistema"
];

$path = [
    "/user",
    "/plan",
    "/monthlyPayment",
    "/payments",
    "/enterprise",
    "/binnacle",
    "/setting"
];


if ($_SESSION['logged_in'] === true) { ?>

    <!DOCTYPE html>
    <html lang="es" class="dark">

    <head>

        <?php require_once "./inc/meta_include.php"; ?>

        <!-- Favicons -->
        <link href="./img/<?= LOGO ?>" rel="shortcut icon" type="image/x-icon">

        <!-- sweet-alert 2 -->
        <link href="./css/sweetalert2.min.css" rel="stylesheet">
        <link href="./css/toastify.css" rel="stylesheet">

        <link href="./css/bootstrap.min.css" rel="stylesheet">
        <link href="./css/bootstrap-icons.css" rel="stylesheet">
        <link href="./css/dataTables.bootstrap5.min.css" rel="stylesheet">

        <link href="./css/animate.min.css" rel="stylesheet">
        <!-- Template Main CSS File -->
        <link href="./css/nice_admin_styles/styles.css" rel="stylesheet">

        <link href="./css/catalogo.css" rel="stylesheet">
        <link href="./css/carousel.css" rel="stylesheet">


    </head>

    <body class=" ">
        <?php
        require_once "./inc/header.php";
        require_once "./inc/adminSideBar.php";

        //   $total_ventas_del_dia = venta_model::totales_ventas_del_dia();

        //   $total_hoy_dolar = $total_ventas_del_dia['dolares'];
        //   $total_hoy_bs = $total_ventas_del_dia['bs'];
        ?>


        <main id="main" class="main">
            <div class="pagetitle">
                <h1> Panel de Control </h1>
            </div>

            <section class="dashboard">
                <div class="row">
                    <?php foreach($titleCards as $index => $title) { ?>
                        <div class="col-12 col-md-4 mb-3">
                            <div class="card bg- text-">
                                <div class="card-body">
                                    <h5 class="card-title "> <a href="<?= $path[$index]; ?>"> <?= $title; ?> </a> </h5>
                                    
                                    <h2 class="card-text">
                                        <i class="fs-1 bi <?= $iconCards[$index]; ?>"></i>&nbsp; <?= $cantRegCards[$index]; ?>
                                    </h2>
                                    <p class="card-text"><small><?= $footerCard[$index]; ?></small></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="col-12 mb-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="card top-selling overflow-auto mb-4">

                                    <div class="card-body">
                                        <h5 class="mb-3 card-title"> Ventas Recientes </h5>

                                        <div class="table-responsive">
                                            <table class="table example table-hover table-striped mb-0" id="example">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" scope="col" style="width: 5%;">N.°</th>
                                                        <th class="text-center" scope="col">N.° de Factura</th>

                                                        <th class="text-center" scope="col">Cédula/RIF Cliente</th>

                                                        <th class="text-center" scope="col" style="width: 10%;">Total </th>

                                                        <th class="text-center" scope="col">Fecha y Hora</th>
                                                        <th class="text-center" scope="col" style="width: 8%;">Detalles</th>
                                                    </tr>
                                                </thead>
                                                <tbody> <?php //venta_model::lista_ventas_diarias(); 
                                                        ?> </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <?php
        //   include_once "./modal/plantillaModalCustom.php";

        include_once "./inc/footer.php";
        include_once "./inc/scripts_include.php";

        // model_user::validar_sesion_activa($id_usuario);

        //   config_model::verificar_actualizacion_configuracion(); 
        ?>
    </body>

    </html>
<?php } else {
    header("location: ../");
}
?>