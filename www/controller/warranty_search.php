<?php
session_start();
include_once "../models/functions.php"; // Asegúrate de que este archivo contiene la función

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['serial_number'])) {
        $serial_number = $_POST['serial_number'];

        // Llamar a la función
        $product = get_warranty_by_serial_number($serial_number);

        if ($product) {
            // Devolver la respuesta en formato JSON
            echo json_encode($product);
        } else {
            echo json_encode(['error' => 'No se encontró el producto con ese número de serie.']);
        }
    } else {
        echo json_encode(['error' => 'No se ha proporcionado un número de serie.']);
    }
}
?>
