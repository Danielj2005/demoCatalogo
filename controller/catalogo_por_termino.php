<?php

require_once "../config/SERVER.php";
require_once "../model/mainModel.php"; 
require_once "../model/productModel.php"; 

try {

    $method = $_SERVER['REQUEST_METHOD'];

    // --- OBTENER PRODUCTOS PARA EDITAR (GET) ---
    if ($method === 'GET') {
        
        $termino = $_GET['termino'] ?? '';

        $catalogo = modeloPrincipal::consultar("SELECT id, nombre, precio, images, estado FROM productos AS P WHERE P.nombre LIKE '%$termino%';"); 
        $total = mysqli_num_rows($catalogo);
        $catalogo = mysqli_fetch_all($catalogo); 
        
        $productos = [];
        foreach ($catalogo as $producto) {
            $id = $producto[0];
            $nombre = $producto[1];
            $precio = $producto[2];
            $images = explode(',', $producto[3]);
            $images = $images[0];
            $estado = $producto[4];

            $productos[] = [
                "id" => $id,
                "nombre" => ucwords(strtolower($nombre)),
                "precio" => $precio,
                "images" => $images,
                "estado" => $estado,
            ];

        }

        $data = [
            "status" => "success",
            "productos" => json_encode($productos)
        ];
    
        echo json_encode($data);
    }
    

} catch(PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}