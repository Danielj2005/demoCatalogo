<?php

require_once "../config/SERVER.php";
require_once "../model/mainModel.php"; 

try {
    
    // --- OBTENER CATEGORÍAS (GET) ---
    $stmt = $conn->prepare("SELECT * FROM categorias ORDER BY nombre ASC");
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Convertimos el string de imágenes de nuevo a Array para el JS
    foreach ($categorias as $cat) { ?>

    <tr>
        <td class="col text-center"></td>
        <td class="col text-start"><?= $cat["nombre"]; ?></td>
        <td class="col text-start"><?= $cat["descripcion"]; ?></td>
        <td scope="row" class="text-center">
            <form action="../controller/categoria_controller.php" method="post" class="SendFormAjax" data-type-form="update_estate" >
                <input type="hidden" name="UID" value="<?= modeloPrincipal::encryptionId($cat["id"]); ?>">
                <?php if ($cat["state"] === 1) { ?>
                    <input type="hidden" name="modulo" value="activo">          
                    <button class="btn btn-success bi-check-circle" title="Categoría activa" type="submit">&nbsp;Activo</button>
                <?php } else { ?>
                    <input type="hidden" name="modulo" value="inactivo">          
                    <button class="btn btn-danger bi-x-circle" title="Categoría inactiva" type="submit">&nbsp;Inactivo</button>
                <?php } ?>
            </form>
        </td>
    </tr>
<?php } 
} catch(PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>