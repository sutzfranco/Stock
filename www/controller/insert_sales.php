<?php
include_once "../models/functions.php";

// Código del controlador para registrar la venta.
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_customer = isset($_POST["id_customer"]) ? trim($_POST["id_customer"]) : null;
    $sales_number = isset($_POST["sales_number"]) ? trim($_POST["sales_number"]) : null;
    $date_sales = isset($_POST["date_sales"]) ? trim($_POST["date_sales"]) : null;
    $items = isset($_POST["items"]) && is_array($_POST["items"]) ? $_POST["items"] : [];

    // Array para almacenar errores
    $errorMessages = [];

    // Verificación de los campos obligatorios
    if (empty($id_customer) || empty($sales_number) || empty($date_sales) || empty($items)) {
        $errorMessages[] = "Todos los campos son obligatorios.";
    }

    // Solo continuar si no hay errores hasta ahora
    if (empty($errorMessages)) {
        $insertSuccess = true;

        foreach ($items as $item) {
            $id_product = isset($item["id_product"]) ? trim($item["id_product"]) : null;
            $quantity = isset($item["quantity"]) ? (int)$item["quantity"] : 0;
            $serials = isset($item["serials"]) ? explode(",", $item["serials"]) : [];
            $product_name = isset($item["name_product"]) ? trim($item["name_product"]) : '';


            if (empty($id_product) || $quantity <= 0 || empty($serials)) {
                $errorMessages[] = "Error: Producto, cantidad o seriales no válidos para el producto ID: $id_product.";
                $insertSuccess = false;
                break;
            }

            // Insertar fecha de venta
            $date = insert_date_sales($date_sales);

            // Insertar la venta
            $insert = insert_sales($id_customer, $sales_number, $id_product, $quantity);

            if (!$insert) {
                $errorMessages[] = "Error al insertar la venta para el producto ID: $id_product.";
                $insertSuccess = false;
                break;
            }

            // Actualizar el stock del producto y números de serie
            if ($insert && $date) {
                $updateStock = update_product_stock($id_product, $quantity);
                if (!$updateStock) {
                    $errorMessages[] = "Error al actualizar el stock del producto ID: $id_product.";
                    $insertSuccess = false;
                    break;
                }

                if (!empty($serials)) {
                    $updateSerials = update_serial_numbers($id_product, $serials, $sales_number);
                    if (!$updateSerials) {
                        $errorMessages[] = "Error al actualizar los números de serie para el producto ID: $id_product.";
                        $insertSuccess = false;
                        break;
                    }
                }

                // Registrar despacho para este producto
                $insertDispatch = insert_dispatch($sales_number, $id_customer, $quantity, $product_name, $serials);
                if (!$insertDispatch) {
                    $errorMessages[] = "Error al insertar el despacho para el producto ID: $id_product.";
                    $insertSuccess = false;
                    break;
                }
            } else {
                $errorMessages[] = "Error al insertar la fecha o la venta para el producto ID: $id_product.";
                $insertSuccess = false;
                break;
            }
        }
    }

    if ($insertSuccess) {
        $response['success'] = true;
        $response['sales_number'] = $sales_number;
        $response['message'] = "¿Desea Imprimir el Remito?";
    } else {
        $response['success'] = false;
        $response['message'] = implode(", ", $errorMessages);
    }

    echo json_encode($response);
    exit();
}
?>