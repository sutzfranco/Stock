<?php
session_start();
include_once "../models/functions.php";

$show=show_state("suppliers");
$showP=show_state("products");

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
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="../assets/css/searchPanes.bootstrap5.css">
    <link rel="stylesheet" href="../assets/css/select.bootstrap5.css">
    <!-- SweetAlert -->
    <script src="../assets/js/sweetalert2@11.js"></script>
    <!-- Incluir el CSS de Select2 -->
    <link href="../assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Hoja de estilo personalizada -->
    <link rel="stylesheet" href="../assets/css/style_lista_cliente.css">
</head>

<body class="sidebar-mini" style="height: auto;">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- HEADER -->
        <?php include "header.php" ?>
        <!-- HEADER -->
        <!-- MENU -->
        <?php include "menu.php" ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 1604.8px;">
            <div class="container-fluid" style="padding:50px;">
                <div class="card" style="margin-top:5px">
                    <div class="card-header">
                        <div class="row mb-12">
                            <div class="col-sm-6">
                                <h4><b>Compras</b>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="../controller/insert_purchase.php" method="post">
                    <div class="card">
                        <div class="card-header" style="display: block;text-align:center">
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="display: block;">
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="id_supplier" class="form-label">Proveedor: <sup
                                            style="color:red">*</sup></label>
                                    <select name="id_supplier" class="form-control select2" id="id_supplier">
                                        <option></option>
                                        <?php foreach ($show as $supplier) : ?>
                                        <option value="<?php echo $supplier->id_supplier; ?>">
                                            <?php echo $supplier->name_supplier; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="view_tax">CUIL/CUIT</label>
                                    <span id="view_tax" class="form-control" readonly></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="view_email">Email</label>
                                    <span id="view_email" class="form-control" readonly></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="view_phone">Teléfono</label>
                                    <span id="view_phone" class="form-control" readonly></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-1">
                                    <label for="purchase_remito">Número de </label>
                                    <input type="text" name="number_remito" id="number_remito" class="form-control"
                                        maxlength="4" value="" placeholder="0000">

                                </div>
                                <div class="form-group col-md-3">
                                    <label for="remito">Remito: <sup style="color:red">*</sup></label>
                                    <input type="text" name="remito" id="remito" class="form-control" maxlength="6"
                                        value="" placeholder="000000" pattern="\d{6}">

                                </div>
                                <div class="form-group col-md-4">
                                    <label for="date_remito">Fecha de Remito: <sup style="color:red">*</sup></label>
                                    <?php
                                    $fechas = obtenerFechasLimite();
                                    ?>
                                    <input type="date" name="date_remito" class="form-control"
                                        value="<?php echo $fechas['today']; ?>" min="<?php echo $fechas['minDate']; ?>"
                                        max="<?php echo $fechas['maxDate']; ?>">
                                    <small id="dateError" style="color:red; display:none;">La fecha debe ser +/-
                                        7.</small>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-1">
                                    <label for="purchase_factura">Número de </label>
                                    <input type="text" name="purchase_factura" class="form-control" maxlength="4"
                                        value="" placeholder="0000">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="factura">Factura: <sup style="color:red">*</sup></label>
                                    <input type="text" name="factura" class="form-control" maxlength="6" value=""
                                        placeholder="000000">

                                </div>
                                <div class="form-group col-md-4">
                                    <label for="date_factura">Fecha de Factura: <sup style="color:red">*</sup></label>
                                    <?php
                                    $fechas = obtenerFechasLimite();
                                    ?>
                                    <input type="date" name="date_factura" class="form-control"
                                        value="<?php echo $fechas['today']; ?>" min="<?php echo $fechas['minDate']; ?>"
                                        max="<?php echo $fechas['maxDate']; ?>">
                                    <small id="dateError" style="color:red; display:none;">La fecha debe ser +/-
                                        7.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card">
                        <div class="card-header" style="display: block;">
                            <h5>Detalle del Remito</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="display: block;">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="items">Producto: <sup style="color:red">*</sup></label>
                                    <div id="products">
                                        <div class="product">
                                            <select name="id_product" id="id_product" class="form-control">
                                                <option value="">Selecciona un producto</option>
                                                <?php foreach ($showP as $product) : ?>
                                                <?php if ($product->stock > 0) : ?>
                                                <option value="<?php echo $product->id_product; ?>"
                                                    data-description="<?php echo $product->description; ?>"
                                                    data-stock="<?php echo $product->stock; ?>">
                                                    <?php echo $product->name_product." - ".$product->description; ?>
                                                </option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="items">Cantidad: <sup style="color:red">*</sup></label>
                                    <input type="number" id="quantity_input" class="form-control" placeholder="Cantidad"
                                        min="1">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3 d-flex align-items-center">
                                    <label for="serial_number" class="mb-0 me-2">Número de Serie:</label>
                                    <input type="checkbox" name="serial_number" id="serial_number"
                                        class="form-check me-2">
                                    <button type="button" id="addSerialNumber" class="btn btn-primary">
                                        <i class="fas fa-plus-circle fa-lg"></i>&nbsp;Agregar N° Serie
                                    </button>
                                </div>
                                <div class="form-group col-md-1 d-flex align-items-center">
                                </div>
                                <div class="form-group col-md-2 d-flex align-items-center">
                                    <label for="items" class="mb-0">&nbsp;</label>
                                    <button type="button" id="addProduct" class="btn btn-primary">
                                        <i class="fas fa-plus-circle fa-lg"></i>&nbsp;Agregar Producto
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div class="table-wrapper">
                                <table id="table_products" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Cantidad</th>
                                            <th>Números de Series</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Filas dinámicas se agregarán aquí -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer" style="text-align:right">
                            <input type="submit" class="btn btn-success" value="Ingresar Remito">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- FOOTER -->
        <?php include "footer.php"?>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="serialNumberModal" tabindex="-1" aria-labelledby="serialNumberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered" style="width: 300px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="serialNumberModalLabel">Ingresar Números de Serie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" style="text-align:center">
                    <form id="serialForm" action="../controller/controller_addSerialNumber.php" method="POST">
                        <input type="hidden" name="id_product_modal" id="id_product_modal" value="">
                        <input type="hidden" name="remito_number" id="remito_number" value="">
                        <input type="hidden" name="id_supplier_modal" id="id_supplier_modal" value="">

                        <table class="table" id="serialTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Número de Serie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Filas dinámicas se agregarán aquí -->
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="serialForm" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Vista Binoculares -->
    <div class="modal fade" id="productDetailsModal" tabindex="-1" aria-labelledby="productDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered" style="width: 300px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="productDetailsModalLabel">Detalles del Producto</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align:center">
                    <form id="serialFormUpdate" action="../controller/controller_updateSerialNumber.php" method="POST">
                        <!-- Campos ocultos -->
                        <input type="hidden" id="id_product_modal" name="id_product">
                        <input type="hidden" id="remito_number" name="remito_number">
                        <input type="hidden" id="id_supplier_modal" name="id_supplier">
                        <!-- Tabla de números de serie -->
                        <table class="table" id="productDetailsTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Código de Serie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí es donde se agregarán las filas dinámicas -->
                                <!-- Cada fila debe incluir su serial_number y su line_number -->
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="serialFormUpdate" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/purchase.js"></script>
    <!-- Incluir jQuery -->
    <script src="../assets/plugins/jquery/jquery-3.6.0.min.js"></script>
    <!-- Incluir el JS de Select2 -->
    <script src="../assets/js/select2.js"></script>
    <!-- Bootstrap JS -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.bumdle-v5.3.js"></script>
    <script src="../assets/js/bootstrapt.bundle5.3.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/adminlte.min.js"></script>
    <!-- DataTables JS -->
    <script src="../assets/js/jquery.datatables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap5.js"></script>
    <script src="../assets/js/dataTables.js"></script>
    <script src="../assets/js/dataTables.searchPanes.js"></script>
    <script src="../assets/js/searchPanes.bootstrap5.js"></script>
    <script src="../assets/js/dataTables.select.js"></script>
    <script src="../assets/js/select.bootstra5.js"></script>
</body>

</html>