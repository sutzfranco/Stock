<?php
include_once "../models/functions.php";
// Verifica si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtén los datos del formulario
    $id_product = $_POST['id_product_modal'];
    $remito_number = $_POST['remito_number'];
    $id_supplier = $_POST['id_supplier_modal'];
    $serial_numbers = $_POST['items'][0]['serial_numbers'];
    // Validación básica
    if (empty($id_product)) {
        echo json_encode(['error' => 'El ID del producto está vacío.']);
        exit;
    }

    //verifica numeros repetidos en la lista
    if (count($serial_numbers) !== count(array_unique($serial_numbers))) {
        echo json_encode(['error' => 'Hay números de serie repetidos en la lista. Por favor, revisa los números e inténtalo de nuevo.']);
        exit;
    }

    try {
        // Insertar los números de serie en la base de datos
        foreach ($serial_numbers as $line_number => $serial_number) {
            add_serial_number($id_product, $serial_number, $remito_number, $line_number + 1, $id_supplier);
        }
        // Si la inserción es exitosa, devuelve un mensaje de éxito
        echo json_encode(['success' => true, 'message' => 'Números de serie agregados con éxito.']);
    } catch (Exception $e) {
        // Si ocurre un error, devuelve un mensaje de error
        echo json_encode(['error' => 'Error en guardar el numero de serie']);
    }
} else {
    // Si la solicitud no es POST, devuelve un error
    echo json_encode(['error' => 'Solicitud inválida.']);
}
