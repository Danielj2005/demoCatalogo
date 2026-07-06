<?php 
session_start();

// importacion de la conexion a la base de datos y al modelo de usuario
require_once "../config/APP.php";
require_once "../config/SERVER.php";
require_once "../model/mainModel.php"; // se incluye el model principal
require_once "../model/productModel.php"; 
require_once "../model/categoryModel.php"; // se incluye el model de categorias


// $id_usuario = $_SESSION['id_usuario']; // se obtiene el id del usuario
// validación para verificar que el usuario inicio sesion de manera correcta
// model_user::verificar_intento_de_acceso_al_sistema();

// include_once "../include/verificacion_primer_inicio_usuario.php"; // se incluyen los modelos necesarios para la vista

// $primer_inicio = $_SESSION['primer_inicio'];

// if($primer_inicio == '1' || $_SESSION['dataUsuario']["primer_inicio"] == '1'){
//     echo "<script type='text/javascript'>
//             window.location.href='./mi_perfil.php';
//         </script>";
//     exit();
// }

// $permiso_productos = modeloPrincipal::verificar_permisos_requeridos($_SESSION['permisosRequeridos']['producto']['productos']);

// $r_productos = modeloPrincipal::verificar_permisos_requeridos(['r_productos']);
// $l_productos = modeloPrincipal::verificar_permisos_requeridos(['l_productos']);

// $categoria = modeloPrincipal::verificar_permisos_requeridos(['r_categoria', 'l_categoria']);
// $r_categoria = modeloPrincipal::verificar_permisos_requeridos(['r_categoria']);
// $l_categoria = modeloPrincipal::verificar_permisos_requeridos(['l_categoria']);

// $presentacion = modeloPrincipal::verificar_permisos_requeridos(['r_presentacion','l_presentacion']);
// $r_presentacion = modeloPrincipal::verificar_permisos_requeridos(['r_presentacion']);
// $l_presentacion = modeloPrincipal::verificar_permisos_requeridos(['l_presentacion']);

// $marca = modeloPrincipal::verificar_permisos_requeridos(['r_marca', 'l_marca']);
// $r_marca = modeloPrincipal::verificar_permisos_requeridos(['r_marca']);
// $l_marca = modeloPrincipal::verificar_permisos_requeridos(['l_marca']);



$tasas_cotizacion = modeloPrincipal::obtener_precio_dolar();

$permiso_productos = 11;

$r_productos = 1;
$l_productos = 1;

$categoria = 1;
$r_categoria = 1;
$l_categoria = 1;

$presentacion = 1;
$r_presentacion = 1;
$l_presentacion = 1;

$marca = 1;
$r_marca = 1;
$l_marca = 1;

// se evalua que este rol tenga el acceso a esta vista
// if ($permiso_productos) {  ?>

    <!DOCTYPE html>
    <html lang="en">
        <head>
            <?php 
                // se incluyen los meta datos 
                require_once "./inc/meta_include.php"; 
                // se incluyen los estilos css y sus librerias a la vista
                require_once "./inc/css_include.php";
            ?>
        </head>
        <body>
            <?php
                // se incluye el header / encabezado a la vista
                include_once "./inc/header.php";
                // se incluye el menu lateral a la vista 
                include_once "./inc/adminSideBar.php";
            ?>
            <main id="main" class="main">
                <div class="pagetitle">
                    <a class="btn btn-outline-secondary mb-3" href="./">
                        <i class="bi bi-chevron-left"></i> 
                        <span>Volver al Panel Principal</span>
                    </a>
                    <h1 class="text-center fs-1 titulosH my-2">Gestión de Productos</h1>
                </div>
                <section class="section dashboard">
                    <div class="row m-0"> 
                        <div id="card_gestion_productos" class="col-12 mb-3 pagetitle text-center row m-0 p-0 justify-content-around">

                            <?php if ($categoria || $presentacion > 0 || $marca > 0) : ?>

                                <?php if ($categoria): ?>
                                    <div class="text-center col-12 col-md-3 fs-4 rounded-2 card">
                                        <h3 class="text-center mt-2 titulosH fs-4 fw-bold ">Categorías</h3>

                                        <?php if ($r_categoria == 1 ): ?>

                                            <div class="text-center mb-2">
                                                <button modal="registrarCategoria" type="button" data-bs-toggle="modal" data-bs-target="#registrar_categoria" class="mb-2 btn_modal btn btn-success">
                                                    <i class="bi bi-plus-circle"></i> Registrar nueva
                                                </button>
                                            </div>

                                        <?php endif; if ($l_categoria == 1 ): ?>

                                            <div class="text-center mb-2">
                                                <button modal="listaCategoria" id="btn_ver_listas_categoria" type="button" class="btn_modal btn btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal">
                                                    <i class="bi bi-list-columns-reverse"></i> Ver Lista
                                                </button>
                                            </div>

                                        <?php endif; ?>
                                    </div>   
                                <?php endif; ?>

                                <?php if ($presentacion): ?>
                                    <div class=" text-center col-12 col-md-3 fs-4 rounded-2 card position-relative">
                                        <div class="align-items-center bg-body-secondary bg-opacity-75 d-flex h-100 justify-content-center position-absolute start-0 w-100">
                                            <i class="bi bi-lock-fill"></i>
                                        </div>
                                        <h3 class="text-center mt-2 titulosH fs-4 fw-bold "> Presentaciones</h3>

                                        <?php if ($r_presentacion == 1 ): ?>

                                            <div class="text-center mb-2">
                                                <button modal="registrarPresentacion" type="button" data-bs-toggle="modal" data-bs-target="#modal" class="mb-2 btn_modal btn btn-success">
                                                    <i class="bi bi-plus-circle"></i> Registrar nueva
                                                </button>
                                            </div>

                                        <?php endif; if ($l_presentacion == 1 ): ?>

                                            <div class="text-center mb-2">
                                                <button modal="listaPresentacion" id="btn_ver_listas_presentacion" type="button" class="btn_modal btn btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal">
                                                    <i class="bi bi-list-columns-reverse"></i> Ver Lista
                                                </button>
                                            </div>

                                        <?php endif; ?>
                                    </div>   
                                <?php endif; ?>

                                <?php if ($marca): ?>
                                    <div class="text-center col-12 col-md-3 fs-4 rounded-2 card position-relative">
                                        <div class="align-items-center bg-body-secondary bg-opacity-75 d-flex h-100 justify-content-center position-absolute start-0 w-100">
                                            <i class="bi bi-lock-fill"></i>
                                        </div>
                                        <h3 class="text-center mt-2 titulosH fs-4 fw-bold ">Marcas</h3>

                                        <?php if ($r_marca == 1 ): ?>

                                            <div class="text-center mb-2">
                                                <button modal="registrarMarca" type="button" data-bs-toggle="modal" data-bs-target="#modal" class="mb-2 btn_modal btn btn-success">
                                                    <i class="bi bi-plus-circle"></i> Registrar nueva
                                                </button>
                                            </div>

                                        <?php endif; if ($l_marca == 1 ): ?>

                                            <div class="text-center mb-2">
                                                <button modal="listaMarca" id="btn_ver_listas_marca" type="button" class="btn_modal btn btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal">
                                                    <i class="bi bi-list-columns-reverse"></i> Ver Lista
                                                </button>
                                            </div>

                                        <?php endif; ?>
                                    </div>   
                                <?php endif; ?>

                            <?php endif; ?>
                        </div>

                        <!-- registro y listado de productos -->

                        <div class="col-12 mb-3 pagetitle text-center">
                            <div class="card rounded-2 p-2">
                                <div class="car-body row p-3">
                                    
                                    
                                    
                                    <h2 id="titleModuleProducts" class="mt-2 mb-3 fs-2 col-12 fw-bold card-title">Inventario de Productos</h2>

                                    <?php if ($r_productos && $l_productos): ?>

                                        <div class="setCol text-center col-md-4 col-12 mb-3">
                                            <button data-bs-target="#producto_modal"  data-bs-toggle="registrar_producto" id="btn-toggle" type="button" class="col-12 btn btn-success">
                                                <i class="bi bi-plus-circle"></i> Registrar Productos 
                                            </button>
                                        </div>

                                    <?php endif; ?>

                                    <div class="setCol text-center col-md-4 col-12 mb-3">
                                        <button data-bs-target="#lista_producto_inactivo_modal"  data-bs-toggle="modal" id="btn-toggle" type="button" class="col-12 btn btn-danger">
                                            <i class="bi bi-x-circle"></i> Ver Productos Inactivos
                                        </button>
                                    </div>
                                    
                                    <div class="setCol text-center col-12 mb-2 <?= $r_productos == 0 ? 'col-md-6' : 'col-md-4'?>">
                                        <div class="col-12 dropdown">
                                            <button class="col-12 btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-file-text"></i>
                                                <span>Exportar Lista (.PDF)</span>
                                            </button>

                                            <ul class="dropdown-menu">
                                                <li> <hr class="dropdown-divider"> </li>
                                                <li class="p-2 text-center">
                                                    <a class="btn btn-outline-primary" target="_blank" href="./reportes/lista_productos.php">
                                                        <i class="bi bi-file-text"></i> 
                                                        <span>Todos los Productos</span>
                                                    </a>
                                                </li>
                                                <li> <hr class="dropdown-divider"> </li>
                                                <li class="p-2 text-center">
                                                    <form action="./reportes/lista_productos.php" method="post" class="" target="_blank">
														<input type="hidden" name="UUIDS" value="<?php //modeloPrincipal::encryptionId("1") ?>">
                                                            
                                                        <button type="submit" class="btn btn-outline-success">
                                                            <i class="bi bi-file-text"></i> 
                                                            <span>Productos Con Stock</span>
                                                        </button>
                                                    </form>
                                                </li>
                                                <li> <hr class="dropdown-divider"> </li>
                                                <li class="p-2 text-center">
                                                    <form action="./reportes/lista_productos.php" method="post" class="" target="_blank">
														<input type="hidden" name="UUIDS" value="<?php //modeloPrincipal::encryptionId("0") ?>">
                                                            
                                                        <button type="submit" class="btn btn-outline-danger" >
                                                            <i class="bi bi-file-text"></i> 
                                                            <span>Productos sin Stock</span>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- leyenda de colores -->
                                    <div class="d-none my-3 col-12 text-start">
                                        <p class="text-secondary fs-6 fw-bold mb-1">Los Colores de indicadores en nombres de productos significan: </p>
                                        <ul class="list-unstyled overflow-hidden">
                                            <li class="list-item">
                                                <span class="rounded-5 badge fw-bold text-bg-primary text-primary">.</span>
                                                <span class="fw-bold">Productos con Gran cantidad de stock (50 o más)</span>
                                            </li>
                                            <li class="list-item">
                                                <span class="rounded-5 badge fw-bold text-bg-warning text-warning">.</span>
                                                <span class="fw-bold">Productos con Poca cantidad de stock (30 o menos)</span>
                                            </li>
                                            <li class="list-item">
                                                <span class="rounded-5 badge fw-bold text-bg-danger text-danger">.</span>
                                                <span class="fw-bold">Productos con Baja cantidad de stock (20 o menos)</span>
                                            </li>
                                            <li class="list-item">
                                                <span class="rounded-5 badge fw-bold text-bg-success text-success">.</span>
                                                <span class="fw-bold">Productos Bajo Pedido</span>
                                            </li>
                                            <li class="list-item">
                                                <span class="rounded-5 badge fw-bold text-bg-secondary text-secondary">.</span>
                                                <span class="fw-bold">Productos Cotizados según el pedido</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <?php if ($l_productos == 1 ): ?>

                                        <div id="tableListProducts" class="justify-content-between align-items-center table table-responsive">
                                            <table class="table example mb-3 table-striped" id="example">
                                                <thead>
                                                    <tr>
                                                        <th class="col text-center" scope="col">N.º</th>
                                                        <th class="col text-center" scope="col">Producto</th>
                                                        <th class="col text-center" scope="col">Precios</th>
                                                        <th class="col text-center" scope="col">Imagenes</th>
                                                        <th class="col text-center" scope="col">Editar</th>
                                                        <th class="col text-center" scope="col">Desactivar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    <?php endif; ?>  
                                </div>
                            </div>
                        </div>
                    </>
                </section>
            </main>


            <!-- Modal registro de produtos -->
            <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="lista_producto_inactivo_modal" tabindex="-1" aria-labelledby="lista_producto_modal_label" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="lista_producto_modal_label"><i class="bi bi-x-circle"></i> Lista de productos Inactivos</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                    
                            
                            <div class="my-3 col-12 text-start">
                                <p class="text-secondary fs-6 fw-bold mb-1">Los Colores de indicadores en nombres de productos significan: </p>
                                <ul class="list-unstyled overflow-hidden">
                                    <li class="list-item">
                                        <span class="rounded-5 badge fw-bold text-bg-primary text-primary">.</span>
                                        <span class="fw-bold">Gran cantidad de stock (50 o más)</span>
                                    </li>
                                    <li class="list-item">
                                        <span class="rounded-5 badge fw-bold text-bg-warning text-warning">.</span>
                                        <span class="fw-bold">Poca cantidad de stock (30 o menos)</span>
                                    </li>
                                    <li class="list-item">
                                        <span class="rounded-5 badge fw-bold text-bg-danger text-danger">.</span>
                                        <span class="fw-bold">Baja cantidad de stock (20 o menos)</span>
                                    </li>
                                    <li class="list-item">
                                        <span class="rounded-5 badge fw-bold text-bg-success text-success">.</span>
                                        <span class="fw-bold">Productos Bajo Pedido</span>
                                    </li>
                                    <li class="list-item">
                                        <span class="rounded-5 badge fw-bold text-bg-secondary text-secondary">.</span>
                                        <span class="fw-bold">Productos Cotizados según el pedido</span>
                                    </li>
                                </ul>
                            </div>
                            <div id="tableListProducts" class="justify-content-between align-items-center table table-responsive">
                                <table class="table example mb-3 table-striped" id="example">
                                    <thead>
                                        <tr>
                                            <th class="col text-center" scope="col">N.º</th>
                                            <th class="col text-center" scope="col">Producto</th>
                                            <th class="col text-center" scope="col">Precios</th>
                                            <th class="col text-center" scope="col">Imagenes</th>
                                            <th class="col text-center" scope="col">Editar</th>
                                            <th class="col text-center" scope="col">Activar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle me-2"></i>Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>


            

        <div class="modal fade" id="registrar_categoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div id="modal_tamano" class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content rounded-4 border border-secondary shadow-md">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Registrar Categoría</h5>
                        <button id="btnCloseModal" type="button" class="text-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body" id="body_modal"> 
                        <form id="reg_categoria" action="../controller/categoria_controller.php" method="post" class="SendFormAjax" autocomplete="off" data-type-form="save">
                            <input type="hidden" name="modulo" value="Guardar">          
                            <div class="row mb-3 justify-content-center text-start">
                                <div class="col-12 mb-3">
                                    <label class="col-form-label">Nombre <span style="color:#f00;">*</span> </label>
                                    <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ.,\/ ()]{4,100}" required="" placeholder="Ejemplo: Lácteos y Refrigerados" class="form-control" id="input_añadir_categoria" name="nombre_categoria">
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <label class="col-form-label">Descripción <span style="color:#f00;">*</span> </label>
                                    <textarea required placeholder="Ejemplo: Leche, yogur, queso, mantequilla, huevos, postres fríos." class="form-control" name="descripcion" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ.,\/ ()]{4,200}"></textarea>
                                </div>

                                <div class="col-12 mb-3 text-start">
                                    <p class="form-p">Los campos con <span style="color:#f00;">*</span> son obligatorios</p>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button id="btn_guardar_modal" form="reg_categoria" type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="registrar_producto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-theme="dark">
            <div id="modal_tamano" class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-2xl">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Registrar Producto</h5>
                        <button id="btnCloseModal" type="button" class="text-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body m-0" id="body_modal"> 
                        <form id="product-form" action="../controller/producto_controlador.php" method="post" class="SendFormAjax" autocomplete="off" data-type-form="save" enctype="multipart/form-data" >
                            <input type="hidden" name="modulo" value="Guardar">
                            <div class="row ">
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="col-form-label">Nombre del producto <span style="color:#f00;">*</span> </label>
                                    <input name="producto" placeholder="Nombre" required class="mb-3 w-full bg-slate-800 p-3 rounded-xl border-none text-white outline-none focus:ring-1 ring-purple-500">
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="col-form-label">Precio (opcional)</label>
                                    <input name="price" value="0.00" type="number" min="0" step="0.01" placeholder="Precio ($)" class="w-full mb-3 bg-slate-800 p-3 rounded-xl border-none text-white outline-none focus:ring-1 ring-purple-500">
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="category-selector">
                                        <label class="col-form-label">Selecciona una o más Categorías: <span style="color:#f00;">*</span> </label>
                                        <div id="tag-container" class="flex flex-wrap gap-2 mb-3"></div>
        
                                        <select id="categoryMultiSelect" name="category[]" multiple class="d-none form-select w-full mb-3 bg-slate-800 p-3 rounded-xl border-none outline-none focus:ring-1 ring-purple-500">
                                            <?php category_model::optionsId(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="col-form-label">Cargar Imagen de producto <span style="color:#f00;">*</span> </label>
                                    <input type="file" name="image[]" multiple accept="image/*" class="rounded-3xl border p-2 my-3 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:bg-purple-600 hover:file:bg-purple-500 cursor-pointer text-white transition"/>
                                </div>
                                
                                <div class="col-12 mb-3">
                                    
                                    <label class="col-form-label">Descripción <span style="color:#f00;">*</span> </label>
                                    <textarea name="desc" placeholder="Descripción del producto..." class="w-full bg-slate-800 p-3 rounded-xl border-none text-white h-24 text-sm outline-none focus:ring-1 ring-purple-500"></textarea>

                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button id="btn_guardar_modal" form="product-form" type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editar_producto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-theme="dark">
            <div id="modal_tamano" class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-2xl">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modificar Producto</h5>
                        <button id="btnCloseModal" type="button" class="text-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body m-0"> 
                        <form id="editProduct" action="../controller/producto_controlador.php" method="post" class="SendFormAjax" autocomplete="off" data-type-form="update" enctype="multipart/form-data" >
                            <input type="hidden" name="modulo" value="Modificar">
                            <div id="tableModalEdit" class="row justify-content-center align-items-center">

                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button form="editProduct" type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalList" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-theme="dark">
            <div id="modal_tamano" class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-2xl">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Lista de Categorías</h5>
                        <button id="btnCloseModal" type="button" class="text-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body row m-0" id="bodyModalList"> </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal detalles de producto -->
        <div data-bs-theme="dark" class="modal fade" id="detallesModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content bg-slate-900 rounded-3xl border border-slate-800 shadow-2xl">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles de producto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="gap-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 modal-body" id="modalBodyDetalles">

                    </div>
                </div>
            </div>
        </div>

            <script type="text/javascript">
                // mostrar u ocultar el campo de datos del proveedor segun el tipo de compra seleccionado
                const dataBuyEntries = () => {
                    const tipoCompra = document.querySelector('#tipo_compra_id').value;
                    const datProvider = document.querySelector('#datProvider');

                    if (tipoCompra === 'compra_proveedor' && datProvider.classList.contains('d-none')) {
                        datProvider.classList.remove('d-none');
                    }else{
                        datProvider.classList.add('d-none');
                    }
                };
            
            </script>

            <?php 
                //include_once "./modal/plantillaModalCustom.php"; 
                
                // se incluye el footer / pie de pagina a la vista
                include_once "./inc/footer.php";
                // se incluyen los script de javascript a la vista 
                include_once "./inc/scripts_include.php"; 
            
                //model_user::validar_sesion_activa($id_usuario);
        
                //config_model::verificar_actualizacion_configuracion(); 
            ?>
            <script src="./js/añadir_producto.js"></script>
        </body>
    </html>

<?php 
//}else{
    // se registran las acciones del usuario en la bitacora y es redirijido al inicio
   // bitacora::intento_de_acceso_a_vista_sin_permisos("Gestión de Productos");
//}