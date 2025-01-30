<?php
include_once "../models/functions.php";
if(isset($_GET['id_product'])){
    $id_product = $_GET['id_product'];
    $get_product = getproducts($id_product);
} else {
    // Manejar el caso en el que no se proporciona un ID de proveedor válido
    $get_product = null;
}
// Procesamiento del formulario de edición cuando se envía
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($_POST['save_data'])){
        $id_product = $_POST["id_product"];
        $number_product = isset($_POST['number_product'])  ? $_POST["number_product"] : null;
        $name_product = isset($_POST["name_product"]) ? $_POST["name_product"] : null;
        $description = isset($_POST["description"]) ? $_POST["description"] : null;
        // Actualizar los datos del proveedor en la base de datos
        $updated = update_products($number_product,$id_product,$name_product,$description);
        if ($updated) {
            // Redirigir a la página de gestión de proveedores con un mensaje de éxito en la URL
            echo '<script>
                localStorage.setItem("mensaje", "Producto editado con éxito");
                localStorage.setItem("tipo", "success");
                window.location.href = "../views/crud_products_new.php";
                    </script>';      
        } else {
            // Mostrar un mensaje de error si falla la actualización
            echo '<script>
            localStorage.setItem("mensaje", "Error al actualizar los datos");
            localStorage.setItem("tipo", "error");
            window.location.href = "../views/crud_products_new.php";
                </script>';   
        }
    }
}
?>