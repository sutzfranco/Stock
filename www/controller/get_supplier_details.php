<?php
include_once "../models/functions.php"; 
if (isset($_POST['id_supplier'])) {
    $id_supplier = $_POST['id_supplier'];
    $supplier_details = getsupplier($id_supplier);
    if ($supplier_details) { 
        echo json_encode([
            'success' => true,
            'tax' => $supplier_details->tax_identifier,
            'email' => $supplier_details->email_supplier,
            'phone' => $supplier_details->phone_supplier
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
