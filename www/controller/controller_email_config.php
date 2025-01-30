<?php
include_once "../models/functions.php";
// Obtener la configuración de correo existente (último ID)
$config = getConfig();
$message = '';
if ($_POST) {
    $email = trim($_POST['email']);
    $email_password = trim($_POST['email_password']);
    $email_receive = trim($_POST['email_receive']);
    $smtp_address = trim($_POST['smtp_address']);
    $smtp_port = trim($_POST['smtp_port']);
    $errors = [];
    if (empty($email)) {
        $errors[] = "El correo es obligatorio.";
    }
    if (empty($email_password)) {
        $errors[] = "La contraseña es obligatoria.";
    }
    if (empty($smtp_address)) {
        $errors[] = "La dirección SMTP es obligatoria.";
    }
    if (empty($smtp_port) || !is_numeric($smtp_port) || $smtp_port <= 0) {
        $errors[] = "El puerto SMTP es obligatorio y debe ser un número positivo.";
    }
    if (empty($errors)) {
        if (saveConfig($email, $email_password,$email_receive,$smtp_address, $smtp_port)) {
            // Mensaje para SweetAlert
            echo '<script>
                    localStorage.setItem("mensaje", "Configuración de correo guardada correctamente.");
                    localStorage.setItem("tipo", "success");
                    window.location.href = "../views/email_config.php";
                  </script>';
            exit; // Salir del script después de la redirección
        } else {
            $message = "No se pudo guardar la configuración de correo.";
        }
        // Refrescar los datos después de la inserción/actualización
        $config = getConfig();
    } else {
        $message = implode('<br>', $errors);
    }
}
// Obtener la configuración de correo existente (último ID)
$config = getConfig();
$message = '';

if ($_POST) {
    $email = trim($_POST['email']);
    $email_password = trim($_POST['email_password']);
    $email_receive = trim($_POST['email_receive']);
    $smtp_address = trim($_POST['smtp_address']);
    $smtp_port = trim($_POST['smtp_port']);
    $errors = [];
    if (empty($email)) {
        $errors[] = "El correo es obligatorio.";
    }
    if (empty($email_password)) {
        $errors[] = "La contraseña es obligatoria.";
    }
    if (empty($smtp_address)) {
        $errors[] = "La dirección SMTP es obligatoria.";
    }
    if (empty($smtp_port) || !is_numeric($smtp_port) || $smtp_port <= 0) {
        $errors[] = "El puerto SMTP es obligatorio y debe ser un número positivo.";
    }
    if (empty($errors)) {
        if (saveConfig($email, $email_password,$email_receive, $smtp_address, $smtp_port)) {
            // Mensaje para SweetAlert
            echo '<script>
                    localStorage.setItem("mensaje", "Configuración de correo guardada correctamente.");
                    localStorage.setItem("tipo", "success");
                    window.location.href = "email_config.php";
                  </script>';
            exit; // Salir del script después de la redirección
        } else {
            $message = "No se pudo guardar la configuración de correo.";
        }
        // Refrescar los datos después de la inserción/actualización
        $config = getConfig();
    } else {
        $message = implode('<br>', $errors);
    }
}
?>


