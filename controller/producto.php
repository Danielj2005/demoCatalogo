<?php

require_once "../config/SERVER.php";
require_once "../model/mainModel.php"; 

try {

    $method = $_SERVER['REQUEST_METHOD'];

    // --- OBTENER PRODUCTOS PARA EDITAR (GET) ---
    if ($method === 'GET') {
        $details = $_GET['details'] ?? false;

        if ($details): 
            $id = $_GET['UID'];
            $path = $_GET['path'] ?? null;
            
            $phone = $conn->prepare("SELECT telefono FROM users WHERE id = 2");
            $phone->execute();
            $number = $phone->fetchAll(PDO::FETCH_ASSOC);
            $phone = $number[0];
            
            $stmt = $conn->prepare("SELECT * FROM productos WHERE id = $id");
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $products = $products[0];

            // Ruta de la carpeta de imágenes
            $files = explode(",",$products['images']);  
            $quety = $products;
            $i = 0 ;
        ?>
        
            <div class="col-12 col-md-6 mb-3">
            
                <div class="custom-carousel">
                    <div class="carousel-track-container">
                        <ul class="carousel-track" id="carouselTrack">
                            <?php foreach ($files as $file) { ?>
                                <li class="carousel-slide <?= $i++ == 0 ? 'active' : '' ?>">
                                    <img src="<?= '.'.$file ?? './img/404.png' ?>">
                                </li>
                            <?php  } ?>
                        </ul>
                    </div>
                    <?php if (count($files) > 1) { ?>
                        <button class="carousel-button prev-btn" id="prevBtn">&#10094;</button>
                        <button class="carousel-button next-btn" id="nextBtn">&#10095;</button>
                    <?php  } ?>
                </div>
            </div>

            
            <div class="col-12 col-md-6 mb-3 p-3 text-start border border-secondary rounded-3" style="height: fit-content;">
                <h3 class="fw-bold mb-4 text-xl">
                    <?= mb_convert_encoding(ucwords(strtolower($quety['nombre'])), 'UTF-8', 'ISO-8859-1') ?>
                </h3>
                <div class="mb-2">
                    <div class="bg_badge_precio badge border border-white rounded-5">
                        <span class="fs-5"><?= $quety['estado'] == 1 ? "$ ".$quety['precio'] : 'AGOTADO' ?></span>
                    </div>
                </div>
                
                <p class="col-12 fw-bold text-muted mb-4 "><?= mb_convert_encoding($quety['description'], 'UTF-8', 'ISO-8859-1') ?></p>
            </div>

        <?php else:
            $id = modeloPrincipal::decryptionId($_GET['UID']);

            $stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $products = $products[0];
            // Convertimos el string de imágenes de nuevo a Array para el JS
            $products['imgs'] = explode(",",$products['images']);  ?>

                <input name="id" value="<?= modeloPrincipal::encryptionId($id) ?>" type="hidden">
                <div class="col-12 col-md-6 mb-3">
                    <label class="">Nombre del producto <span style="color:#f00;">*</span> </label>
                    <input name="producto" value="<?= mb_convert_encoding($products['nombre'], 'UTF-8', 'ISO-8859-1') ?>" placeholder="Nombre" required class="w-100 form-control">
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label class="">Precio <span style="color:#f00;">*</span> </label>
                    <input name="price" value="<?= $products['precio'] ?>" type="number" min="0" step="0.01" placeholder="Precio ($)" class="w-100 form-control">
                </div>
                
                <div class="rounded-4 mb-4 bg-white col-12 table-responsive overflow-hidden overflow-x-auto">

                    <table class="mb-3 no-footer table table-borderless table-group-divider table-hover table-striped">
                        <thead>
                            <tr class="text-black">
                                <th class="col text-center" scope="col">Imagen</th>
                                <th class="col text-center" scope="col">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            foreach ($products['imgs'] as $img) { ?>
                                
                                <tr class="text-black">
                                    <th class="col text-center" scope="col">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <img src=".<?= $img ?>" style="width: 5rem; height:5rem; " class="d-block" alt="...">
                                        </div>
                                    </th>
                                    <th class="col text-center" scope="col">
                                        <button dataId="<?= $products['id'] ?>" class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </th>
                                </tr>
                            
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-12 mb-3">
                    <label class="col-form-label">Cargar más Imagenes del producto <span style="color:#f00;">*</span> </label>
                    <input type="file" name="image[]" multiple accept="image/*" class="rounded-5 w-100 form-control"/>
                </div>

                <div class="col-12 mb-3">
                    <label class="col-form-label">Descripción <span style="color:#f00;">*</span> </label>
                    <textarea readOnly style="height: 10rem;" name="desc" value="<?= mb_convert_encoding($products['description'], 'UTF-8', 'ISO-8859-1') ?>" placeholder="Descripción del producto..." class="w-100 form-control"><?= mb_convert_encoding($products['description'], 'UTF-8', 'ISO-8859-1') ?></textarea>
                </div>
                
            <?php
        endif;            
    }

    
} catch(PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>