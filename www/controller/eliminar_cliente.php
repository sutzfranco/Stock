<?php
include_once "../models/functions.php";
if (isset($_POST['edit-id_customer'])) {
    $id = $_POST['edit-id_customer']; 
    deletecliente($id);    
    echo '<script>
    localStorage.setItem("mensaje", "Cliente deshabilitado con éxito");
    localStorage.setItem("tipo", "success");
    window.location.href = "../views/crud_cliente.php";
        </script>';          
} else {
    echo '<script>
    localStorage.setItem("mensaje", "Error al eliminar el cliente");
    localStorage.setItem("tipo", "error");
    window.location.href = "../views/crud_cliente.php";
        </script>';  
}
?>
