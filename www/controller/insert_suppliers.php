<?php
include_once "../models/functions.php";
$show=show_state("suppliers");
if(isset($_POST['agregar'])){
    $cuil = $_POST['cuil'];
    $name_Proveedor = $_POST['name_Proveedor']; 
    $email_Proveedor = $_POST['email_Proveedor'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $altura = $_POST['altura'];
    $piso = $_POST['piso'];
    $numero_de_piso = $_POST['numero_de_piso'];
    $ciudad = $_POST['ciudad'];
    $observaciones = $_POST['observaciones'];
    // Verificar si el cuil o el email ya existen en la base de datos
    if (check_existing_supplier($cuil, $email_Proveedor)) {
        echo '<script>
        localStorage.setItem("mensaje", "El mail o el cuil ya existen");
        localStorage.setItem("tipo", "error");
        window.location.href = "../views/crud_suppliers_new.php";
            </script>'; 
    } else {
        // Llamada a la función insert_suppliers
        $insert = insert_suppliers($name_Proveedor,$telefono,$email_Proveedor,$direccion,$altura,$piso,$numero_de_piso,$ciudad,$observaciones,$cuil);
        echo '<script>
                localStorage.setItem("mensaje", "Proveedor creado con éxito");
                localStorage.setItem("tipo", "success");
                window.location.href = "../views/crud_suppliers_new.php";
                    </script>';      
        if (!$insert) {
            echo '<script>
            localStorage.setItem("mensaje", "Error al crear el prooveedor");
            localStorage.setItem("tipo", "error");
            window.location.href = "../views/crud_suppliers_new.php";
                </script>';  
        }
    }
}
