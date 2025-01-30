<?php
// Incluir las funciones de la capa de modelo
include_once "../models/functions.php";

// Verificar la acción solicitada por el usuario
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // Acción para mostrar la vista de despacho
    if ($action == 'dispatch' && isset($_GET['sales_number'])) {
        $sales_number = $_GET['sales_number'];
        view_dispatch($sales_number);

    // Acción para procesar el despacho (al enviar el formulario)
    } elseif ($action == 'process_dispatch' && isset($_POST['sales_number'])) {
        $sales_number = $_POST['sales_number'];
        process_dispatch($sales_number);

    // Acción para obtener los seriales disponibles para un producto (vía POST)
} elseif ($action == 'get_serials' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Validar el ID del producto
    if (is_numeric($product_id)) {
        $serials = get_available_serials($product_id);
        echo json_encode(['serials' => $serials]);
    } else {
        echo json_encode(['success' => false, 'error' => 'ID de producto no válido.']);
    }
    exit();
    // Acción para agregar un nuevo número de serie (vía POST)
    } elseif ($action == 'add_serial' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
        $serial_number = isset($_POST['serial_number']) ? $_POST['serial_number'] : null;

        if (is_numeric($product_id) && !empty($serial_number)) {
            try {
                $success = add_serial_numbers($product_id, $serial_number);
                if ($success) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'No se pudo agregar el número de serie.']);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Datos no válidos.']);
        }
        exit();  
    }
}
// Acción por defecto: Mostrar ventas pendientes
//get_pending_sales();
//exit();

// Función para mostrar la vista de despacho de una venta específica
function view_dispatch($sales_number) {
    // Obtener los detalles de la venta por su número
    $sale_details = get_sale_details($sales_number);

    // Verificar si se obtuvieron detalles
    if (!$sale_details) {
        echo json_encode(['success' => false, 'error' => 'No se encontraron detalles para la venta N°: ' . htmlspecialchars($sales_number)]);
        exit();
    }

    // Cargar la vista de despacho con los detalles de la venta
    require '../views/dispatch.php';  // Renderiza la vista sin devolver JSON
}
// Función para procesar el despacho de una venta
function process_dispatch($sales_number) {
    $sale_details = get_sale_details($sales_number);

    if (empty($sale_details)) {
        echo json_encode(['success' => false, 'error' => 'No se encontró información para la venta.']);
        exit();
    }

    if (!isset($_POST['serial_numbers']) || empty($_POST['serial_numbers'])) {
        echo json_encode(['success' => false, 'error' => 'No se han proporcionado números de serie.']);
        exit();
    }

    $serial_numbers = $_POST['serial_numbers']; // Seriales ingresados desde el formulario

    // Agrupar los números de serie por producto
    foreach ($serial_numbers as $product_id => $serial_number_string) {
        // Dividir la cadena de números de serie en un array
        $serial_numbers_array = explode(',', $serial_number_string);

        // Obtener los detalles del producto
        $product_detail = array_filter($sale_details, function($detail) use ($product_id) {
            return $detail['id_product'] == $product_id;
        });

        if (empty($product_detail)) {
            echo json_encode(['success' => false, 'error' => 'No se encontró el producto con ID ' . $product_id . '.']);
            exit();
        }

        $product_detail = reset($product_detail); // Obtener el primer elemento del array filtrado
        $customer_id = $product_detail['id_customer']; // Obtener ID del cliente

        // **Modificar esta parte para actualizar la cantidad de productos y mantener los seriales agrupados**

        // Procesar los números de serie agrupados en una sola entrada para dispatch
        update_serial_numbers($product_id, $serial_numbers_array, $sales_number);

        // Insertar solo una entrada en la tabla de despachos con la cantidad total del producto
        if (!insert_dispatch($sales_number, $customer_id, $product_detail['quantity'], $product_detail['full_product_name'], $serial_numbers_array)) {
            echo json_encode(['success' => false, 'error' => 'No se pudo registrar el despacho del producto ID ' . $product_id . '.']);
            exit();
        }
    }

    // Actualizar el estado de la venta a "Despachado"
    update_sales_status($sales_number, 8); // El código 8 representa "Despachado"

    // Enviar respuesta de éxito con el número de venta
    echo json_encode(['success' => true, 'sales_number' => $sales_number, 'message' => 'Venta despachada correctamente']);
    exit();
}