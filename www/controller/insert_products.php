<?php
include_once "../models/functions.php";
$show=show_state("products");
if(isset($_POST['enviar'])){   
    $number_serial = $_POST['number_serial'];
    $number_product = $_POST['number_product']; 
    $name_product = $_POST['name_product']; 
    $description = $_POST['description'];
    $id_brand = $_POST['id_brand'];
    $id_category = $_POST['id_category'];
        $insert = insert_products($number_product,$name_product,$description,$id_brand,$id_category);
       if ($insert) {
            echo '<script>
                localStorage.setItem("mensaje", "Producto creado con éxito");
                localStorage.setItem("tipo", "success");
                window.location.href = "../views/crud_products_new.php";
                    </script>';      
        }else
        {
            echo '<script>
            localStorage.setItem("mensaje", "Error al crear el producto");
            localStorage.setItem("tipo", "error");
            window.location.href = "../views/crud_products_new.php";
                </script>';   
        }
}
?>