<?php
include_once "../models/functions.php";
if (isset($_POST)) {
    $id_supplier = $_POST["supplier_id"];
    $number_remito = $_POST["number_remito"] . "-" . $_POST["remito"];
    $date_remito = $_POST["date_remito"];
    $number_invoice = $_POST["purchase_factura"] . "-" . $_POST["factura"];
    $date_invoice = $_POST["date_factura"];


    $items = $_POST["items"];
    $insertSuccess = true;   
    
    if (empty($_POST["number_remito"]) || empty($_POST["remito"])) {
        echo '<script>
            localStorage.setItem("mensaje", "Actualice el número de remito, no pueden estar vacío.");
            localStorage.setItem("tipo", "error");
            window.location.href = "../views/purchase.php";
            </script>';
        exit;
    }
    if (preg_match('/^0+$/', $_POST["number_remito"]) || preg_match('/^0+$/', $_POST["remito"])) {
        echo '<script>
            localStorage.setItem("mensaje", "Actualice el número de remito, no pueden ser ceros.");
            localStorage.setItem("tipo", "error");
            window.location.href = "../views/purchase.php";
            </script>';
        exit;
    }

       if (check_remito_exists($number_remito)) {
        echo '<script>
            localStorage.setItem("mensaje", "El número de remito ya existe. Por favor, ingrese un número diferente.");
            localStorage.setItem("tipo", "error");
            window.location.href = "../views/purchase.php";
            </script>';
        exit;
    }

    if (empty($_POST["purchase_factura"]) || empty($_POST["factura"])) {
        echo '<script>
            localStorage.setItem("mensaje", "Actualice el número de factura, no puede estar vacío.");
            localStorage.setItem("tipo", "error");
            window.location.href = "../views/purchase.php";
            </script>';
        exit;
    }

 
    if (preg_match('/^0+$/', $_POST["purchase_factura"]) || preg_match('/^0+$/', $_POST["factura"])) {
        echo '<script>
            localStorage.setItem("mensaje", "Actualice el número de factura, no puede ser solo ceros.");
            localStorage.setItem("tipo", "error");
            window.location.href = "../views/purchase.php";
            </script>';
        exit;
    }

    foreach ($items as $item) {
        $id_product = $item["id_product"];
        $quantity = !empty($item["quantity"]) ? $item["quantity"] : 0;
        $date = insert_date_sender($date_invoice);
        $insert = insert_sender($id_supplier, $number_remito, $date_remito, $number_invoice, $date_invoice, $id_product, $quantity);

        if (!$insert) {
            $insertSuccess = false;
            break;
        }
    }
 

    if ($insertSuccess) {

        echo '<script>
            localStorage.setItem("mensaje", "Remito ingresado con éxito");
            localStorage.setItem("tipo", "success");
            window.location.href = "../views/purchase.php";
            </script>';      
    } else {
        echo '<script>
            localStorage.setItem("mensaje", "Error al ingresar el remito");
            localStorage.setItem("tipo", "error");
            window.location.href = "../views/purchase.php";
            </script>';   
    }
}
?>
