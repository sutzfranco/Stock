<?php
include_once "../models/functions.php";

$product_id = $_GET['product_id'];

// Obtener los seriales no utilizados
$bd = database();
$stmt = $bd->prepare("SELECT serial_number FROM serial_numbers WHERE id_product = :id_product AND used = 0");
$stmt->bindParam(':id_product', $product_id);
$stmt->execute();
$serials = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['serials' => $serials]);
?>
