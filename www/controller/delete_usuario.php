<?php
include_once "../models/functions.php";
if(isset($_POST['delete-id_user'])) {
    $id = $_POST['delete-id_user'];
    $id_rol=$_POST['delete-id_rol'];
    $resultado = deleteusuarios($id,$id_rol);
    if($id_rol==2){
    if (!$resultado) {
        echo '<script>
                localStorage.setItem("mensaje", "Usuario deshabilitado con éxito");
                localStorage.setItem("tipo", "success");
                window.location.href = "../views/crud_usuarios.php";
                    </script>';    
    } else {  
        echo '<script>
        localStorage.setItem("mensaje", "Error al eliminar al usuario");
        localStorage.setItem("tipo", "error");
        window.location.href = "../views/crud_usuarios.php";
            </script>'; 
    }
    }else{
        echo '<script>
        localStorage.setItem("mensaje", "No se puede borrar al ADMINISTRADOR");
        localStorage.setItem("tipo", "error");
        window.location.href = "../views/crud_usuarios.php";
            </script>'; 
        }
} else {
    echo '<script>alert("Error: ID de usuario no proporcionado");</script>';
    echo '<script>window.location.href = "../views/crud_usuarios.php";</script>';
}
?>
