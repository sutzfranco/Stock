<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once '../vendor/autoload.php';
include_once "../models/functions.php";
$name = $_POST["name"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$message = $_POST["message"];
// Obtener configuración de la base de datos
$config = getConfig();
$email_send =$config->email;
$email_password=$config->email_password;
$email_receive=$config->email_receive;
$smtp_address =$config->smtp_address;
$smtp_port =$config->smtp_port;
if (!$config) {
    die("No se encontró configuración de correo.");
}
function Contact_mail($name,$lastname,$email,$message,$email_send,$smtp_address,$email_password,$smtp_port,$email_receive)
{ 
    $mail = new PHPMailer(true);
if(!empty($name) && !empty($lastname) && !empty($email) && !empty($mail))
{
    $mail->SMTPDebug = 0 ;                      
    $mail->isSMTP();                                            
    $mail->Host       = $smtp_address;                
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = $email_send;                     
    $mail->Password   = $email_password;                               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    $mail->Port       = $smtp_port;                                    
    $mail->setFrom('agencia.uno.2024@gmail.com', 'Agencia Uno');
    $mail->addAddress($email_receive);     
    $mail->isHTML(true);
    $mail->CharSet='UTF-8';                      
    $mail->Subject = $message;
    $mail->Body = 
    '<p>
    El usuario: '.$name.''. $lastname.'
    <br>
    <br>
    Con el mail: '.$email.'
    <br>
    <br>
    Envio la siguiente consulta :<br> '.$message.'
    </p>';
    $mail->send();
    return true;
} 
}
if(Contact_mail($name,$lastname,$email,$message,$email_send,$smtp_address,$email_password,$smtp_port,$email_receive)==true)
{
    echo '<script>window.location.href = "../views/contact_succes.html";</script>'; // Regresar a la página anterior
    exit;
}
?>