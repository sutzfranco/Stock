<?php
include_once "../models/functions.php";
if (isset($_POST['id_customer'])) {
    $id_customer = $_POST['id_customer'];
    $cliente = obtenerClientePorId($id_customer);

    if ($cliente) {
        error_log(print_r($cliente, true)); 
        echo json_encode($cliente);
    } else {
        error_log('Cliente no encontrado'); 
        echo json_encode(['error' => 'Cliente no encontrado']);
    }
}
?>
