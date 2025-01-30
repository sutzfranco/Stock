<?php
session_start();
include_once "../models/functions.php";
$error_message = isset($_SESSION["error_message"]) ? $_SESSION["error_message"] : "";
unset($_SESSION["error_message"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control de stock</title>  
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min5.3.css">
    <!-- SweetAlert -->
    <script src="../assets/js/sweetalert2@11.js"></script>
</head>
<body class="sidebar-mini" style="height: auto;">
    <div class="wrapper">
        <!-- HEADER -->
        <?php include "header.php" ?>
        <!-- MENU -->
        <?php include "menu.php" ?>
        <!-- Contenido Principal -->
        <div class="content-wrapper">
            <div class="container-fluid" style="padding:50px;">
                <div class="card" style="margin-top:5px">
                    <div class="card-header">
                        <h4>Búsqueda de Garantía</h4>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form id="warranty-form">
                            <div class="form-group">
                                <label for="serial_number">Número de Serie del Producto</label>
                                <input type="text" name="serial_number" id="serial_number" class="form-control" placeholder="Ingrese el número de serie" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Buscar Garantía</button>
                        </form>

                        <?php if ($error_message): ?>
                            <div class="alert alert-danger mt-3">
                                <i class="fas fa-exclamation-triangle"></i> 
                                <?php echo htmlspecialchars($error_message); ?>
                            </div>
                        <?php endif; ?>

                        <div id="result"></div> <!-- Contenedor para mostrar resultados -->

                    </div>
                </div>
            </div>
        </div>
        <!-- FOOTER -->
        <?php include "footer.php" ?>
    </div>
    <!-- Incluir jQuery una sola vez -->
    <script src="../assets/plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/bootstrap.bundle5.3.min.js"></script>
    <script src="../assets/dist/js/adminlte.min.js"></script>
    <script src="../assets/js/warranty.js"></script>
   
</body>
</html>
