<?php
session_start();
include_once "../models/functions.php";

$config = getConfig();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control de stock</title>  
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css"></link>
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css"></link>
    <!-- Theme style -->
    <script src="../assets/js/sweetalert2@11.js"></script>
</head>
<body class="sidebar-mini" style="height: auto;">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- HEADER -->
        <?php include "header.php"?>
        <!-- HEADER -->
        <!-- MENU -->
        <?php include "menu.php"?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 1604.8px;">
            <div class="container-fluid" style="padding:50px;">
                <div class="card" style="margin-top:5px;">
                    <div class="card-header" style="text-align:center">
                        <div class="row mb-12">
                            <div class="col-sm-12">
                                <h4><b>Formulario de Actualización de Correo / SMTP</b>
                                    <?php if (isset($_SESSION["id_rol"])) {
                                    if($_SESSION["id_rol"]=== 1) {?>
                                    <?php }} ?>
                                </h4>
                            </div><!-- /.col -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.row -->
                <br><br><br>
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                        <div class="card card-primary" style="margin-top:5px">
                            <div class="card-header">
                                <div class="row mb-8">
                                    <div class="col-sm-6">
                                        <h3 class="card-title"><b><?php echo $config ? 'Editar' : 'Crear'; ?>
                                                Configuración de
                                                Correo</b>
                                            <?php if (isset($_SESSION["id_rol"])) {
                                            if($_SESSION["id_rol"]=== 1) {?>
                                            <?php }} ?>
                                        </h3>
                                    </div><!-- /.col -->
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                            <form id="configForm" action="../controller/controller_email_config.php" method="post"
                                onsubmit="return validateForm()">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="email">Correo para SMTP</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="<?php echo $config ? htmlspecialchars($config->email) : ''; ?>"
                                            placeholder="Ingrese el correo">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email_password" class="form-label">Contraseña</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="email_password"
                                                name="email_password"
                                                value="<?php echo $config ? htmlspecialchars($config->email_password) : ''; ?>"
                                                placeholder="Ingrese la contraseña">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="far fa-eye" id="eyeIcon"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email_receive">Correo Recepción</label>
                                        <input type="email" class="form-control" id="email_receive" name="email_receive"
                                            value="<?php echo $config ? htmlspecialchars($config->email_receive) : ''; ?>"
                                            placeholder="Ingrese el correo">
                                    </div>
                                    <div class="form-group">
                                        <label for="smtp_address">Dirección SMTP</label>
                                        <input type="text" class="form-control" id="smtp_address" name="smtp_address"
                                            value="<?php echo $config ? htmlspecialchars($config->smtp_address) : ''; ?>"
                                            placeholder="Ingrese la dirección SMTP">
                                    </div>
                                    <div class="form-group">
                                        <label for="smtp_port">Puerto SMTP</label>
                                        <input type="number" class="form-control" id="smtp_port" name="smtp_port"
                                            value="<?php echo $config ? htmlspecialchars($config->smtp_port) : ''; ?>"
                                            placeholder="Ingrese el puerto SMTP">
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit"
                                        class="btn btn-success"><?php echo $config ? 'Actualizar' : 'Guardar'; ?></button>
                                </div>
                            </form>
                            <?php if (!empty($message)): ?>
                            <div class="alert alert-info mt-3">
                                <?php echo $message; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.row -->
            </div><!-- /.row -->
        </div>
        <?php include "footer.php"?>
    </div>
    </div>
    <script>
    // Verifica si hay un mensaje en el almacenamiento local
    if (localStorage.getItem('mensaje') && localStorage.getItem('tipo')) {
        Swal.fire({
            title: 'Mensaje',
            text: localStorage.getItem('mensaje'),
            icon: localStorage.getItem('tipo'),
            confirmButtonText: 'Aceptar'
        });
        // Limpia el mensaje después de mostrarlo
        localStorage.removeItem('mensaje');
        localStorage.removeItem('tipo');
    }
    </script>
    <script>
    function validateForm() {
        const email = document.getElementById('email').value.trim();
        const emailPassword = document.getElementById('email_password').value.trim();
        const smtpAddress = document.getElementById('smtp_address').value.trim();
        const smtpPort = document.getElementById('smtp_port').value.trim();
        if (!email || !emailPassword || !smtpAddress || !smtpPort) {
            alert('Todos los campos son obligatorios.');
            return false;
        }
        if (isNaN(smtpPort) || smtpPort <= 0) {
            alert('El puerto SMTP debe ser un número positivo.');
            return false;
        }
        return true;
    }
    </script>
    <!-- jQuery -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/adminlte.min.js"></script>
    <!-- Font Awesome JS -->
    <script src="../assets/js/all.min.js"></script>
    <script>
    // Función para mostrar/ocultar la contraseña
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('email_password');
        const eyeIcon = document.getElementById('eyeIcon');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.remove('far', 'fa-eye');
            eyeIcon.classList.add('fas', 'fa-eye-slash');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.remove('fas', 'fa-eye-slash');
            eyeIcon.classList.add('far', 'fa-eye');
        }
    });
    </script>
</body>
</html>