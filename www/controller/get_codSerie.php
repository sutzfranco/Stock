<?php
include_once "../models/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer los datos JSON enviados desde el cliente
    $data = json_decode(file_get_contents("php://input"), true);

    $id_product = $data['id_product'] ?? null;
    $remito_number = $data['remito_number'] ?? null;
    $id_supplier = $data['id_supplier'] ?? null;

    if ($id_product && $remito_number && $id_supplier) {
        // Llamar a la función para obtener los números de serie
        $results = get_serial_numbers($id_product, $remito_number, $id_supplier);

        // Verificar si se obtuvieron resultados
        if (!empty($results)) {
            header('Content-Type: application/json');
            echo json_encode($results);
        } else {
            header('Content-Type: application/json');
            echo json_encode(["error" => "No se encontraron detalles del producto."]);
        }
    } else {
        // Responder con un error si faltan datos
        header('Content-Type: application/json');
        echo json_encode(["error" => "Faltan parámetros"]);
    }
} else {
    // Responder con un error si no es una solicitud POST
    header('Content-Type: application/json');
    echo json_encode(["error" => "Método no permitido"]);
}
?>

