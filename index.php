<?php
session_start();

// importacion de la conexion a la base de datos y al modelo de usuario
require_once "./config/APP.php";
require_once "./config/SERVER.php";
require_once "./model/mainModel.php"; // se incluye el model principal
require_once "./model/productModel.php";

// se definen la cantidad de acticulos que tendra cada pagina  del catalogo
// $page = isset($_POST['page']) ? max(1, intval($_POST['page'])) : 1;
// $per_page = isset($_POST['per_page']) ? max(1, intval($_POST['per_page'])) : 8;
// $offset = ($page - 1) * $per_page;

// se consultan los productos del catalogo
// $catalogo = mysqli_fetch_all(modeloPrincipal::consultar("SELECT id, nombre, description, precio, images, estado
//     FROM productos
//     ORDER BY nombre ASC LIMIT $per_page OFFSET $offset")); 

// definicion de filtros
// $filtro = $_POST['filter'] ?? null;


// if ($filtro !== null) {

//     $filtros[] = $filtro;

//     $addQuery = "WHERE C.nombre IN ('" . implode("','", $filtros) . "') GROUP BY P.id";
//     // obtener total filtrado
//     $countQuery = "SELECT COUNT(DISTINCT P.id) AS total FROM productos AS P INNER JOIN categorias_productos AS CP ON P.id = CP.producto_id INNER JOIN categorias AS C ON C.id = CP.categoria_id WHERE C.nombre IN ('" . implode("','", $filtros) . "')";
//     $total_stmt = modeloPrincipal::consultar($countQuery);
//     $total_row = mysqli_fetch_assoc($total_stmt);
//     $total = intval($total_row['total']);
//     $query = "SELECT P.id, P.nombre, P.precio, P.images FROM productos AS P INNER JOIN categorias_productos AS CP ON P.id = CP.producto_id INNER JOIN categorias AS C ON C.id = CP.categoria_id $addQuery ORDER BY P.nombre ASC LIMIT $per_page OFFSET $offset";
// } else {

//     $total_stmt = modeloPrincipal::consultar("SELECT COUNT(*) AS total FROM productos WHERE estado = 1");
//     $total_row = mysqli_fetch_assoc($total_stmt);
//     $total = intval($total_row['total']);
//     $query = "SELECT P.id, P.nombre, P.description, P.precio, P.images, P.estado FROM productos AS P WHERE P.estado = 1 ORDER BY P.nombre ASC LIMIT $per_page OFFSET $offset";

// }

// // se consultan los productos del catalogo
// $catalogo = mysqli_fetch_all(modeloPrincipal::consultar($query)); 

// $total_pages = ceil($total / $per_page);

// $totalPages = max(1, ceil($total / $per_page));

// $maxButtons = 7;
// $start = max(1, $page - floor($maxButtons / 2));
// $end = min($totalPages, $start + $maxButtons - 1);
// if ($end - $start < $maxButtons - 1) {
//     $start = max(1, $end - $maxButtons + 1);
// }

?>



<!DOCTYPE html>
<html lang="es">
<head>
        
    <!-- titulo -->
    <title><?= COMPANY; ?></title>
    <!-- metadatos -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="E-comerce catálogo de productos, Sistema de Control de Inventario, Punto de Venta y Gestión de Clientes y Proveedores.">
    <meta name="keywords" content="E-comerce, catálogo de productos, ventas, pedidos, whatsapp, Inventario, POS, gestión de clientes, proveedores">
    <meta name="author" content="DANIEL BARRUETA">


    <!-- Favicons -->
    <link href="./view/img/<?= LOGO ?>" rel="shortcut icon" type="image/x-icon">

    <!-- sweet-alert 2 -->
    <link href="./view/css/sweetalert2.min.css" rel="stylesheet">
    <link href="./view/css/toastify.css" rel="stylesheet">

    <link href="./view/css/bootstrap.min.css" rel="stylesheet">
    <link href="./view/css/bootstrap-icons.css" rel="stylesheet">
    <link href="./view/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <link href="./view/css/animate.min.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="./view/css/nice_admin_styles/styles.css" rel="stylesheet">

    <link href="./view/css/catalogo.css" rel="stylesheet">
    <link href="./view/css/carousel.css" rel="stylesheet">

</head>

<body class="toggle-sidebar">

    <?php require_once "./view/inc/catalogo_header.php"; ?>
    <?php require_once "./view/inc/loader.php"; ?>
    
    <div id="app" style="display: none !important;" >
        <main id="main" class="main">
            <div class="pagetitle mb-5">
                
                <!-- Filtros por Categoría -->
                <div class="dropdown text-center">
                    <button class="btn btn-primary dropdown-toggle position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-sliders" ></i>
                        <span class="" > Filtros  </span>
                        <span id="num_filter" class="d-none badge position-absolute text-bg-danger" style="top: -.8rem;  right: -1rem;"></span>
                    </button>
    
                    <ul id="category-filters" class="dropdown-menu overflow-scroll overflow-x-hidden" style="max-height: 25rem;" data-bs-theme="dark">
                        <li id="dropdown-item-all" class="dropdown-item" >
                            <button onclick="filterByCategory('all', 0)" class="w-100 btn border-0 bg-transparent px-3 category-btn">Todos</button>
                        </li>
                        
                    </ul>
                </div>
            </div>
    
            <section class="section dashboard">
                <div id="producto-cards" class="producto-card-container"></div>
            </section>
    
        </main>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content rounded-4 border border-secondary shadow-lg">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles de producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="m-0 p-3 align-items-center justify-content-around modal-body row" id="modalBody">

                </div>
            </div>
        </div>
    </div>


    <script src="./view/js/nice_admin_scripts/main.js"></script>
    <!-- jquery -->
    <script src="./view/js/jquery-3.6.0.min.js"></script>
    <script src="./view/js/bootstrap.bundle.min.js"></script>
    
    <script src="view/js/sweetalert2.min.js"></script>
    <script src="view/js/customSwAlert.js"></script>
    <script src="view/js/renderCatalogo.js"></script>
    <script src="view/js/catalogo.js"></script>
    <script src="view/js/carousell.js"></script>
    <script src="view/js/index.js"></script>

    <?php include_once "./view/inc/footer.php"; ?>
</body>

</html>