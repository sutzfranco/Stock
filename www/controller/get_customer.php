<?php
include_once "../models/functions.php";
if (isset($_POST['id_customer'])) {
    $id_customer = $_POST['id_customer'];
    $cliente = getCustomer($id_customer);
    if ($cliente) {
        echo json_encode([
            'tax_identifier' => $cliente['tax_identifier'],
            'email_customer' => $cliente['email_customer'],
            'phone_customer' => $cliente['phone_customer'],
            'street' => $cliente['street'],
            'height' => $cliente['height'],
            'floor' => $cliente['floor'],
            'departament' => $cliente['departament'],
            'location' => $cliente['location'],
            'observaciones' => $cliente['observaciones'],
            'id_status' => $cliente['id_status']
        ]);
    } else {
        echo json_encode(['error' => 'No se encontró el cliente.']);
    }
} else {
    echo json_encode(['error' => 'ID de cliente no proporcionado.']);
}
