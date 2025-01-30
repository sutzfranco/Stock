<?php
session_start();
include_once "../models/functions.php";
$purchases = get_purchase_history();
$show = show_state("suppliers");
$showP = show_state("products");


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agencia UNO</title>
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Bootstrap JS -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert -->
    <script src="../assets/js/sweetalert2@11.js"></script>
    <link rel="stylesheet" href="../assets/css/datatables.css">
</head>

<body class="sidebar-mini" style="height: auto;">
    <div class="wrapper">
        <?php include "header.php"; ?>
        <?php include "menu.php"; ?>

        <div class="content-wrapper">
            <div class="container-fluid" style="padding:50px;">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h4><b>Historial de Compras</b></h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="form-group">
                                <label for="orderSelect"></label>
                                <select id="orderSelect">
                                    <option value="1">Ordenar por Número de Remito</option>
                                    <option value="2">Ordenar por Fecha de Remito</option>
                                    <option value="3">Ordenar por Número de Factura</option>
                                    <option value="4">Ordenar por Proveedor (A-Z)</option>

                                </select>
                            </div>


                            <div class="table-responsive">
                                <table id="purchaseTable" class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Proveedor</th>
                                            <th>Número de Remito</th>
                                            <th>Fecha de Remito</th>
                                            <th>Número de Factura</th>
                                            <th>Productos</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($purchases as $purchase) : ?>
                                        <tr>
                                            <td><?= $purchase['name_supplier']; ?></td>
                                            <td><?= $purchase['remito_number']; ?></td>
                                            <td><?= date('d-m-Y', strtotime($purchase['remito_date'])); ?></td>
                                            <td><?= $purchase['invoice_number']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-info"
                                                    onclick="loadHistoryDetails('<?= $purchase['remito_number']; ?>')"
                                                    data-bs-toggle="modal" data-bs-target="#productHistoryModal">
                                                    Ver Productos
                                                </button>
                                            </td>
                                            <td><?= $purchase['total_qty']; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include "footer.php"; ?>
    </div>
    <!-- Modal para ver detalles de productos -->
    <div class="modal fade" id="productHistoryModal" tabindex="-1" aria-labelledby="productHistoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productHistoryModalLabel">Detalles de Compra</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"> <span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="HistoryDetailsContent"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/plugins/jquery/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables & Plugins -->
    <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../assets/plugins/jszip/jszip.min.js"></script>
    <script src="../assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <!-- Select2 -->
    <script src="../assets/dist/js/adminlte.min.js"></script>
    <script src="../assets/plugins/select2/js/select2.full.min.js"></script>
    
    <script src="../assets/js/history.js"></script>

</body>

</html>