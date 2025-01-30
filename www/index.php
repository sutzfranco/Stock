<?php
session_start();
include_once "models/functions.php";
$show=show_state("brands");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control de stock</title>  
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css"></link>
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css"></link>
</head>
<body class="sidebar-mini" style="height: auto;">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- HEADER -->
        <?php include "views/headers.php"?>
        <!-- HEADER -->
        <!-- MENU -->
        <?php include "views/menus.php"?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 1604.8px;">
            <div class="container-fluid" style="padding:125px;">
            <div class="row">    
                    <div class="col-md-3">
                        <div class="card card-primary">
                            <div class="card-header" style="display: block;text-align:center">
                                <h2 class="card-title"><b>Compras</b></h2>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="display: block;text-align:center">
                                <a href="views/purchase.php">
                                    <img src="assets/img/app/items_2.png" class="col-md-4" alt=""></a>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-3">
                        <div class="card card-primary">
                            <div class="card-header" style="display: block;text-align:center">
                                <h2 class="card-title"><b>Ventas</b></h2>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="display: block;text-align:center">
                                <a href="views/sales.php">
                                    <img src="assets/img/app/transacciones.png" class="col-md-4" alt=""></a>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-3">
                        <div class="card card-primary">
                            <div class="card-header" style="display: block;text-align:center">
                                <h2 class="card-title"><b>Buscas Garantías</b></h2>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="display: block;text-align:center">
                                <a href="views/warranty.php">
                                    <img src="assets/img/app/garantia.png" class="col-md-4" alt=""></a>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-primary">
                            <div class="card-header" style="display: block;text-align:center">
                                <h2 class="card-title"><b>Clientes</b></h2>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="display: block;text-align:center">
                                <a href="views/crud_cliente.php">
                                    <img src="assets/img/app/clientes.png" class="col-md-4" alt=""></a>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-3">
                        <div class="card card-primary">
                            <div class="card-header" style="display: block;text-align:center">
                                <h2 class="card-title"><b>Proveedores</b></h2>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="display: block;text-align:center">
                                <a href="views/crud_suppliers_new.php">
                                    <img src="assets/img/app/proveedores.png" class="col-md-4" alt=""></a>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-3">
                        <div class="card card-primary">
                            <div class="card-header" style="display: block;text-align:center">
                                <h2 class="card-title"><b>Productos</b></h2>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="display: block;text-align:center">
                                <a href="views/crud_products_new.php">
                                    <img src="assets/img/app/producto22.png" class="col-md-4" alt=""></a>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
        <!-- FOOTER -->
        <?php include "views/footers.php"?>
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>