<?php
include_once "../models/functions.php";
// Procesamiento del formulario de edición cuando se envía
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($_POST['save_data'])){ 
        // Validar y sanitizar los datos recibidos
        $id_supplier = isset($_POST["id_supplier"]) ? intval($_POST["id_supplier"]) : null;
        $name = isset($_POST["name"]) ? trim($_POST["name"]) : null;
        $phone = isset($_POST["phone"]) ? trim($_POST["phone"]) : null;
        $email = isset($_POST["email"]) ? trim($_POST["email"]) : null;
        $observation = isset($_POST["observaciones"]) ? trim($_POST["observaciones"]) : null;
        $tax = isset($_POST["cuil"]) ? trim($_POST["cuil"]) : null;
        $street = isset($_POST["street"]) ? trim($_POST["street"]) : null;
        $height = isset($_POST["height"]) ? intval($_POST["height"]) : null;
        $floor = isset($_POST["floor"]) ? trim($_POST["floor"]) : null;
        $departament = isset($_POST["departament"]) ? trim($_POST["departament"]) : null;
        $location = isset($_POST["location"]) ? trim($_POST["location"]) : null;
        // Verificar que id_supplier no sea null
        if ($id_supplier !== null) {
            // Actualizar los datos del proveedor en la base de datos
            $result = updateSupplier($id_supplier, $name, $phone, $email, $observation, $tax, $street, $height, $floor, $departament, $location);
            if ($result['success']) {
                echo '<script>
                localStorage.setItem("mensaje", "' . $result['message'] . '");
                localStorage.setItem("tipo", "success");
                window.location.href = "../views/crud_suppliers_new.php";
                    </script>';          
            } else {
                // Mostrar un mensaje de error si falla la actualización
                echo '<script>
                localStorage.setItem("mensaje", "' . $result['message'] . '");
                localStorage.setItem("tipo", "error");
                window.location.href = "../views/crud_suppliers_new.php";
                    </script>';  
            }
        } else {
            echo '<script>
            localStorage.setItem("mensaje", "ID de proveedor inválido.");
            localStorage.setItem("tipo", "error");
            window.location.href = "../views/crud_suppliers_new.php";
                </script>';
        }
    }
}
?>
