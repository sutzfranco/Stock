<?php
include_once "../models/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer los datos JSON enviados desde el cliente
    $data = json_decode(file_get_contents("php://input"), true);

    $serial_number = $data['serial_number'] ?? null;
    $id_product = $data['id_product'] ?? null;

    if ($serial_number && $id_product) {
        // Llamar a la función del modelo para verificar el serial
        $serialExists = validate_serial_number($id_product, $serial_number);

        // Si el serial existe, devolver éxito
        if ($serialExists) {
            header('Content-Type: application/json');
            echo json_encode(["success" => true, "message" => "El número de serie es válido."]);
        } else {
            // Si no existe, devolver un error
            header('Content-Type: application/json');
            echo json_encode(["success" => false, "message" => "El número de serie no existe o ya está en uso."]);
        }
    } else {
        // Responder con un error si faltan datos
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "Faltan parámetros."]);
    }
} else {
    // Responder con un error si no es una solicitud POST
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
}
?>


