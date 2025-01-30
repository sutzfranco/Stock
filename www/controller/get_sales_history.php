<?php
include_once "../models/functions.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer el sale_number del cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);
    $sale_number = $data['sale_number'] ?? null; 
    if ($sale_number) {
        // Obtener los detalles de los productos según el sale_number
        $product_details = get_product_details_by_sale($sale_number); 

        // Aquí puedes depurar para ver qué devuelve la función
        
        if (!empty($product_details)) {         
            // Retornar los detalles
            header('Content-Type: application/json');
            echo json_encode([
                'sale_number' => $sale_number,                 
                'products' => $product_details
            ]);
        } else {
            // Responder con un error si no hay detalles
            header('Content-Type: application/json');
            echo json_encode(["error" => "No se encontraron detalles de productos."]);
        }
    } else {
        // Responder con un error si falta el sale_number
        header('Content-Type: application/json');
        echo json_encode(["error" => "Falta el parámetro sale_number."]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(["error" => "Método no permitido"]);
}
