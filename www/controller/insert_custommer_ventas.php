<?php
include_once "../models/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = $_POST['tax_identifier'];
    $name_cliente = $_POST['customer_name'];
    $email_cliente = strtoupper($_POST['email_customer']);
    $telefono = $_POST['phone_customer'] ?? null;
    $direccion = $_POST['street'] ?? null;
    $Altura = $_POST['height'] ?? null;
    $ciudad = $_POST['location'] ?? null;
    $piso = $_POST['floor'] ?? null;
    $observaciones = $_POST['observaciones'] ?? null;
    $status = 1;
    $department = $_POST['department'] ?? null;

    // Verificar si el cliente ya existe
    if (clients_exists($email_cliente)) {
        header("Location: ../views/sales.php?error=El cliente ya existe");
    } else {
        // Agregar el cliente al sistema
        $id_cliente = add_custommer_sale($identifier, $name_cliente, $email_cliente, $telefono, $direccion, $Altura, $ciudad, $observaciones, $status, $piso, $department);

        if ($id_cliente) {
            header("Location: ../views/sales.php?success=Cliente agregado correctamente");
        } else {
            header("Location: ../views/sales.php?error=Error al agregar el cliente");
        }
    }
}
