<?php

require_once "../config/SERVER.php";
require_once "../model/mainModel.php"; 
require_once "../model/productModel.php"; 

try {

    $method = $_SERVER['REQUEST_METHOD'];

    // --- OBTENER PRODUCTOS PARA EDITAR (GET) ---
    if ($method === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        $UID = $data['UID'];
        
        
        $prices = $data['prices'];

        if ($UID >= 0 && $UID <= 1) {
            // Valid state, proceed with fetching products
            producto_model::lista($prices);

        }else if ($UID == 2) {
            
            $catalogo = modeloPrincipal::consultar("SELECT id, nombre, precio, images, estado FROM productos ORDER BY nombre ASC"); 
            
            while ($mostrar = mysqli_fetch_assoc($catalogo)) {
        
                $imgSrc = explode(',', $mostrar['images']);

                $images = $imgSrc[0];

                $id_producto = $mostrar["id"];
                $categorias = modeloPrincipal::consultar("SELECT C.nombre AS categorias FROM `categorias_productos` AS CP 
                    INNER JOIN categorias AS C ON C.id = CP.categoria_id
                    WHERE CP.producto_id = $id_producto"); 
                    
                $precio_usd = producto_model::formatnumber("USD",$mostrar["precio"]);
                $precio_bs = producto_model::formatnumber("VES",$mostrar["precio"] * $prices['USD']);
                $precio_euro = producto_model::formatnumber("VES",$mostrar["precio"] * $prices['EURO']);
                $precio_usdt = producto_model::formatnumber("VES",$mostrar["precio"] * ($prices['USD'] * 1.3));

            ?>

                <div class="fs-4 rounded-4 card p-2 producto-card" data-bs-theme="drk">
                    <div data-categories="" class="product-card product_<?= $id_producto ?> overflow-hidden">
                    
                        <div class="position-relative overflow-hidden mb-3" style="height: 15rem;">
                            <img src="<?= '.'.$images ?? './img/404.png' ?>" class="w-100 h-100 rounded-bottom-0 rounded-4" alt="Imagen del producto">
                        </div>

                        <div class="text-start">
                            <button onclick="detallesProductoById(<?= $mostrar['id'] ?>)" class="btn mb-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#detallesModal"> <?= ucwords(strtolower($mostrar["nombre"])) ?> </button>
                        </div>
                        
                        <div class="text-center">
                    
                            <small class="btn btn-outline-success d-flex justify-content-between fw-bold mb-1 p-1" onclick="copyToClipboard('<?= $precio_usd; ?>')">
                                <span class="fw-bold">USD:</span> <?= $precio_usd ?>
                                <i class="bi bi-copy"></i>
                            </small>
                            <small class="btn btn-outline-primary d-flex justify-content-between fw-bold mb-1 p-1" onclick="copyToClipboard('<?= $precio_bs; ?>')">
                                <span class="fw-bold">BS:</span> <?= $precio_bs ?>
                                <i class="bi bi-copy"></i>
                            </small>
                            <small class="btn btn-outline-secondary d-flex justify-content-between fw-bold mb-1 p-1" onclick="copyToClipboard('<?= $precio_euro; ?>')">
                                <span class="fw-bold">Euro:</span> <?=  $precio_euro ?>
                                <i class="bi bi-copy"></i>
                            </small>
                            <small class="d-none text-muted btn ">
                                <span class="text-danger fw-bold">USDT:</span> <?= $precio_usdt ?>
                                <i class="btn bi bi-copy" onclick="copyToClipboard('<?= $precio_usdt; ?>')"></i>
                            </small>

                        </div>

                        <div class="row justify-content-center align-items-center">
                            <div class="col-4 mb-2 text-center">
                                <button onclick="editingProduct('<?= modeloPrincipal::encryptionId($mostrar['id']) ?>')" type="button" class="small btn_details btn btn-warning " data-bs-toggle="modal" data-bs-target="#editar_producto">
                                    <i class="bi bi-pencil-square"></i>
                                    <span class="fw-bold"> Editar</span>
                                </button> 
                            </div>
                            <div class="col-4 mb-2 text-center">
                                <button onclick="detallesProductoById(<?= $mostrar['id'] ?>)" type="button" class="small btn_details btn btn-secondary " data-bs-toggle="modal" data-bs-target="#detallesModal">
                                    <i class="bi bi-eye"></i> 
                                    <span class="fw-bold">Detalles</span>
                                </button> 
                            </div>
                                

                            <div class="col-4 mb-2 text-center">
                                <?php if ($mostrar["estado"] == 1) { ?>

                                    <form action="../controller/producto_controlador.php" method="post" class="SendFormAjax" data-type-form="update_estate" >
                                        <input type="hidden" name="modulo" value="activo">          
                                        <input type="hidden" name="id" value="<?= modeloPrincipal::encryptionId($mostrar['id']) ?>">
                                        <button class="btn btn-success bi bi-check-circle " title="estado del producto">&nbsp;Activo</button>
                                    </form>

                                <?php } else { ?>

                                    <form action="../controller/producto_controlador.php" method="post" class="SendFormAjax" data-type-form="update_estate" >
                                        <input type="hidden" name="modulo" value="inactivo">          
                                        <input type="hidden" name="id" value="<?= modeloPrincipal::encryptionId($mostrar['id']) ?>">
                                        <button class="btn btn-danger bi bi-x-circle " title="estado del producto" type="submit">&nbsp;Inactivo</button>
                                    </form>

                                <?php }  ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } 
        }else {
            echo json_encode(["status" => "error", "message" => "Invalid state value. Must be 0 or 1."]);
            exit;

        }
    }
    
} catch(PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>