<?php
session_start();
include_once "../models/functions.php";

$sales_number = obtener_number_sales();
$showP = show_state("products");
$clientes = obtenerclientes();


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
    <link href="../assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/style_lista_cliente.css">
    <script src="../assets/js/sweetalert2@11.js"></script>
</head>

<body class="sidebar-mini" style="height: auto;">
    <div class="wrapper">
        <?php include "header.php" ?>
        <?php include "menu.php" ?>
        <div class="content-wrapper" style="min-height: 1604.8px;">
            <div class="container-fluid" style="padding:50px;">
                <div class="card" style="margin-top:5px">
                    <div class="card-header">
                        <div class="row mb-12">
                            <div class="col-sm-6">
                                <h4><b>Registro de Ventas</b></h4>
                            </div>
                            <div class="col-sm-6">
                                <h4><b>N° <?php echo str_pad($sales_number, 6, "0", STR_PAD_LEFT); ?></b></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="../controller/insert_sales.php" id="insertSalesForm" method="post">
                    <div class="card">
                        <div class="card-header" style="display: block;text-align:center">
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="form-row">
                                <!-- Campo oculto para enviar el número de venta -->
                                <input type="hidden" name="sales_number" value="<?php echo $sales_number; ?>">

                                <div class="form-group col-md-8">
                                    <label for="id_customer" class="form-label">Cliente: <sup
                                            style="color:red">*</sup></label>
                                    <select name="id_customer" class="form-control select2" id="id_customer">
                                        <option></option>
                                        <?php foreach ($clientes as $cliente) : ?>
                                        <option value="<?php echo $cliente['id_customer']; ?>">
                                            <?php echo $cliente['customer_name']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4 d-flex align-items-end">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addCustomerModal">
                                        <i class="fas fa-user-plus"></i>&nbsp;Cliente Nuevo
                                    </button>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="date_sales">Fecha de Venta: <sup style="color:red">*</sup></label>
                                    <?php
                                    $fechas = obtenerFechasLimite();
                                    ?>
                                    <input type="date" id="date_sales" name="date_sales" class="form-control"
                                        value="<?php echo $fechas['today']; ?>" min="<?php echo $fechas['minDate']; ?>"
                                        max="<?php echo $fechas['maxDate']; ?>">
                                    <small id="dateError" style="color:red; display:none;">La fecha debe ser +/-
                                        7.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" style="display: block;">
                            <h5>Detalle</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body" style="display: block;">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="id_product">Producto: <sup style="color:red">*</sup></label>
                                    <select name="id_product" id="id_product" class="form-control">
                                        <option value="">Selecciona un producto</option>
                                        <?php foreach ($showP as $product) : ?>
                                        <?php if ($product->stock > 0) : ?>
                                        <option value="<?php echo $product->id_product; ?>"
                                            data-description="<?php echo $product->description; ?>"
                                            data-stock="<?php echo $product->stock; ?>">
                                            <?php echo $product->name_product." | ".$product->description." |Stock: ".$product->stock; ?>
                                        </option>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="items">Cantidad: <sup style="color:red">*</sup></label>
                                    <input type="number" id="quantity_input" name="quantity_input" class="form-control"
                                        placeholder="Cantidad" min="1">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2 d-flex align-items-center">
                                    <label for="items" class="mb-0">&nbsp;</label>
                                    <button type="button" id="addProduct" class="btn btn-primary">
                                        <i class="fas fa-plus-circle fa-lg"></i>&nbsp;Agregar Producto
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="table-responsive">
                                <table id="table_products" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Producto Nombre</th>
                                            <th>Cantidad</th>
                                            <th>Seriales</th>
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
                            <input type="submit" class="btn btn-success" value="Registrar Venta">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="serialModal" tabindex="-1" aria-labelledby="serialModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered" style="width: 300px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="serialModalLabel">Seleccionar Números de Serie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="serial_form">
                            <input type="hidden" id="product_id_modal" />
                            <input type="hidden" id="product_qty_modal" />

                            <table class="table" id="serial_numbers_table">
                                <thead>
                                    <tr>
                                        <th>Seleccionar</th>
                                        <th>Código de Serie</th>
                                        <th>Fecha de Compra</th>
                                    </tr>
                                </thead>
                                <tbody id="serial_numbers_container">
                                    <!-- Aquí se agregarán dinámicamente los seriales -->
                                </tbody>
                            </table>

                            <div id="selected_count" class="mt-3">Seleccionados: 0 de 0</div>

                            <div id="new_serial_container" class="mt-3">
                                <div class="input-group">
                                    <input type="text" id="new_serial_input" class="form-control"
                                        placeholder="Nuevo Número de Serie">
                                    <button type="button" id="add_new_serial" class="btn btn-success">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="save_serials">Guardar Selección</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para agregar clientes -->
        <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered" style="width: 300px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addCustomerModalLabel">Agregar cliente nuevo</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" style="text-align:center">
                        <form id="customerForm" action="../controller/insert_custommer_ventas.php" method="POST">
                            <div class="mb-3">
                                <label for="tax_identifier" class="form-label">CUIT/CUIL <span
                                        style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="tax_identifier" id="tax_identifier"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Nombre del Cliente <span
                                        style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="customer_name" id="customer_name"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="email_customer" class="form-label">Correo Electrónico <span
                                        style="color: red;">*</span></label>
                                <input type="email" class="form-control" name="email_customer" id="email_customer"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="phone_customer" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" name="phone_customer" id="phone_customer">
                            </div>
                            <div class="mb-3">
                                <label for="street" class="form-label">Dirección</label>
                                <input type="text" class="form-control" name="street" id="street">
                            </div>
                            <div class="mb-3">
                                <label for="height" class="form-label">Altura</label>
                                <input type="text" class="form-control" name="height" id="height">
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Ciudad</label>
                                <input type="text" class="form-control" name="location" id="location">
                            </div>
                            <div class="mb-3">
                                <label for="floor" class="form-label">Piso</label>
                                <input type="text" class="form-control" name="floor" id="floor">
                            </div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Departamento</label>
                                <input type="text" class="form-control" name="department" id="department">
                            </div>
                            <div class="mb-3">
                                <label for="observaciones" class="form-label">Observaciones</label>
                                <textarea class="form-control" name="observaciones" id="observaciones"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Guardar</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>

    <?php include "footer.php" ?>
    </div>

    <!-- Incluir jQuery una sola vez -->
    <script src="../assets/plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/select2.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.bumdle-v5.3.js"></script>
    <script src="../assets/js/bootstrapt.bundle5.3.min.js"></script>
    <script src="../assets/dist/js/adminlte.min.js"></script>
    <script src="../assets/js/jquery.datatables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap5.js"></script>
    <script src="../assets/js/dataTables.js"></script>
    <script src="../assets/js/dataTables.searchPanes.js"></script>
    <script src="../assets/js/searchPanes.bootstrap5.js"></script>
    <script src="../assets/js/dataTables.select.js"></script>
    <script src="../assets/js/select.bootstra5.js"></script>
    <script src="../assets/js/sales.js"></script>
</body>

</html>