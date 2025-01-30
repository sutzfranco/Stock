<?php
include_once "../models/functions.php";
if (isset($_POST['id_supplier'])) {
    $id_supplier = $_POST['id_supplier'];
    $supplier = getSupplier($id_supplier);
    if ($supplier) {
        echo json_encode([
            'name_supplier' => $supplier['name_supplier'],
            'phone_supplier' => $supplier['phone_supplier'],
            'email_supplier' => $supplier['email_supplier'],
            'street' => $supplier['street'],
            'height' => $supplier['height'],
            'floor' => $supplier['floor'],
            'departament' => $supplier['departament'],
            'location' => $supplier['location'],
            'id_status' => $supplier['id_status'],
            'observations' => $supplier['observations'],
            'tax_identifier' => $supplier['tax_identifier']
        ]);
    } else {
        echo json_encode(['error' => 'No se encontró el proveedor.']);
    }
} else {
    echo json_encode(['error' => 'ID de proveedor no proporcionado.']);
}
