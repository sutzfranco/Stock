<?php
include_once "../models/functions.php";

// Verificar que los datos se recibieron correctamente
$id_product = $_POST['id_product'];
$remito_number = $_POST['remito_number'];
$id_supplier = $_POST['id_supplier'];
$serial_numbers = $_POST['items'][0]['serial_numbers'];
$line_numbers = $_POST['items'][0]['line_numbers'];

error_log("id_product: " . $id_product);
error_log("remito_number: " . $remito_number);
error_log("id_supplier: " . $id_supplier);
error_log("serial_numbers: " . print_r($serial_numbers, true));
error_log("line_numbers: " . print_r($line_numbers, true));

// Actualización de cada serial number
foreach ($serial_numbers as $index => $serial_number) {
    $line_number = $line_numbers[$index]; // Relaciona el `line_number` con el número de serie correspondiente
    $result = update_serial_number($id_product, $serial_number, $remito_number, $id_supplier, $line_number);
    
    if (!$result) {
        echo json_encode(['success' => false, 'error' => 'Error al actualizar el número de serie.']);
        exit;
    }
}

echo json_encode(['success' => true, 'message' => 'Números de serie actualizados correctamente.']);
?>
