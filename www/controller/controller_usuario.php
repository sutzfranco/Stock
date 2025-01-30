<?php
include_once "../models/functions.php"; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_user = $_POST['name_user'];
    $email_user=strtoupper($email_user);
    $phone = $_POST['phone'];
    $password = $_POST['password']; 
    $id_status = 1;
    $id_rol = $_POST['role']; // Obtener el rol seleccionado del formulario
    if(user_exists($email_user))
    {
        echo '<script>
    localStorage.setItem("mensaje", "El usuario ya existe");
    localStorage.setItem("tipo", "error");
    window.location.href = "../views/crud_usuarios.php";
        </script>'; 
    }
    else
    {
    if (addUsuario($email_user, $phone, $password, $id_status, $id_rol)) {
        echo '<script>
                localStorage.setItem("mensaje", "Usuario creado con éxito");
                localStorage.setItem("tipo", "success");
                window.location.href = "../views/crud_usuarios.php";
              </script>';    
    } else {
        header("Location: ../views/crud_usuarios.php?error=1"); 
    }
}
}
?>
