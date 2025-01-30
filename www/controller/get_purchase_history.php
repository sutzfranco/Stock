<?php
include_once "../models/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer el remito_number del cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"), true);
    $remito_number = $data['remito_number'] ?? null;

    if ($remito_number) {
        // Obtener los detalles de los productos según el remito_number
        $product_details = get_product_details_by_remito($remito_number);

        if (!empty($product_details)) {
            // Retornar los detalles y el remito_date
            header('Content-Type: application/json');
            echo json_encode([
                'remito_number' => $remito_number,
                'remito_date' => $product_details[0]['remito_date'],  // Asumimos que todas las filas tienen el mismo remito_date
                'products' => $product_details
            ]);
        } else {
            // Responder con un error si no hay detalles
            header('Content-Type: application/json');
            echo json_encode(["error" => "No se encontraron detalles de productos."]);
        }
    } 
} 