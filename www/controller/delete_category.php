<?php
include_once "../models/functions.php";
if(isset($_POST['edit-id_category'])) {
    $id = $_POST['edit-id_category'];
        $eliminated = deletecategorys("categorys", $id);
        if ($eliminated) {
            echo '<script>
            localStorage.setItem("mensaje", "Categoría deshabilitada con éxito");
            localStorage.setItem("tipo", "success");
            window.location.href = "../views/crud_category.php";
                </script>';    
        } else {
           echo '<script>
           localStorage.setItem("mensaje", "La categoria pertenece a una marca");
           localStorage.setItem("tipo", "error");
           window.location.href = "../views/crud_category.php";
               </script>'; 
        }
    }
?>