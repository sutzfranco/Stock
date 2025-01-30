<?php
include_once "../models/functions.php";
if (isset($_POST['edit-id_user'], $_POST['edit-phone'], $_POST['edit-name'], $_POST['edit-password'], $_POST['edit-role'])) {  
    $id = $_POST['edit-id_user'];
    $phone = $_POST['edit-phone'];
    $email = $_POST['edit-name'];
    $password = $_POST['edit-password'];
    $status = 1; 
    $id_rol = $_POST['edit-role']; // Obtener el rol seleccionado del formulario
    if(user_exists($email))
    {
        echo '<script>
    localStorage.setItem("mensaje", "El usuario ya existe");
    localStorage.setItem("tipo", "error");
    window.location.href = "../views/crud_usuarios.php";
        </script>'; 
    }
    else
    {
    if (Updateusuario($id, $email, $phone, $status, $password, $id_rol)) {
        echo '<script>
                localStorage.setItem("mensaje", "Usuario editado con éxito");
                localStorage.setItem("tipo", "success");
                window.location.href = "../views/crud_usuarios.php";
              </script>';     
    } else {
        echo '<script>alert("Error al actualizar usuario");</script>';
        echo '<script>window.location.href = "../views/crud_usuarios.php";</script>';
    }
}
 }
else {
    echo '<script>alert("Error: Parámetros no proporcionados correctamente");</script>';
    echo '<script>window.location.href = "../views/crud_usuarios.php";</script>';
}
?>
