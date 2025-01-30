<?php
include_once "../models/functions.php";

$data = json_decode(file_get_contents('php://input'), true);
$product_id = $data['product_id'];
$serial_number = $data['serial_number'];

// Insertar nuevo número de serie
$bd = database();
$stmt = $bd->prepare("INSERT INTO serial_numbers (id_product, serial_number, used) VALUES (:id_product, :serial_number, 1)");
$stmt->bindParam(':id_product', $product_id);
$stmt->bindParam(':serial_number', $serial_number);
$success = $stmt->execute();

echo json_encode(['success' => $success]);
?>