<?php
include_once "../models/functions.php";
if(isset($_GET['id_brand'])){
    $id_brand = $_GET['id_brand'];
    $get_brand = getbrands($id_brand);
} else {
    // Manejar el caso en el que no se proporciona un ID de proveedor válido
    $get_brand = null;
}
// Procesamiento del formulario de edición cuando se envía
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($_POST['save_data'])){ 
        $id_brand = $_POST["id_brand"];
        $detail = isset($_POST["detail"]) ? $_POST["detail"] : null;
        $detail = strtoupper($detail);
        // Verificar si la marca ya existe
        if (brand_exists($detail) && $detail != $get_brand['detail']) {
            echo '<script>
                localStorage.setItem("mensaje", "La marca ya existe. Por favor, elija un nombre diferente");
                localStorage.setItem("tipo", "error");
                window.location.href = "../views/crud_brands_new.php";
            </script>'; 
        } else {
            // Actualizar los datos del proveedor en la base de datos
            $updated = update_brands($id_brand, $detail);
            if ($updated) {
                // Redirigir a la página de gestión de proveedores con un mensaje de éxito en la URL
                echo '<script>
                    localStorage.setItem("mensaje", "Marca editada con éxito");
                    localStorage.setItem("tipo", "success");
                    window.location.href = "../views/crud_brands_new.php";
                </script>';     
            } else {
                // Mostrar un mensaje de error si falla la actualización
                echo '<script>
                    localStorage.setItem("mensaje", "Error al editar marca");
                    localStorage.setItem("tipo", "error");
                    window.location.href = "../views/crud_brands_new.php";
                </script>'; 
            }
        }
    }
}
?>
