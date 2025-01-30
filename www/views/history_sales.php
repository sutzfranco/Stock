<?php
session_start();
include_once "../models/functions.php";

$sales = get_sales_history();


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control de stock</title>  
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
                        <h4><b>Historial de Ventas</b></h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="form-group col-md-4">
                                <label for="orderSelect"></label>
                                <select id="orderSelect" class="form-control">
                                    <option value="customer_name">Ordenar por Cliente</option>
                                    <option value="sales_number">Ordenar por Número de Venta</option>
                                    <option value="sale_date">Ordenar por Fecha de Venta</option>
                                </select>
                            </div>


                            <div class="table-responsive">
                                <div class="table-wrapper">
                                    <table id="salesTable" class="table table-striped table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Cliente</th>
                                                <th>Número de Venta</th>
                                                <th>Fecha Venta</th>
                                                <th>Productos</th>
                                                <th>Cantidad</th>
                                                <th>Imprimir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($sales as $sale) : ?>
                                            <tr>
                                                <td><?= htmlspecialchars($sale['customer_name']); ?></td>
                                                <td><?= str_pad($sale['sales_number'], 6, '0', STR_PAD_LEFT); ?></td>
                                                <td><?= isset($sale['sale_date']) ? date('d-m-Y', strtotime($sale['sale_date'])) : date('d-m-Y'); ?>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-info"
                                                        data-id-sale="<?= $sale['sales_number']; ?>"
                                                        data-bs-toggle="modal" data-bs-target="#productHistoryModal">
                                                        Ver Productos
                                                    </button>
                                                </td>
                                                <td><?= $sale['total_qty']; ?></td>
                                                <td>
                                                    <i class="fas fa-print" style="cursor:pointer; color:blue;"
                                                        onclick="validarYImprimir('<?= $sale['sales_number']; ?>');"></i>
                                                </td>
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
        </div>

        <?php include "footer.php"; ?>
    </div>

    <!-- Modal para ver detalles de productos -->
    <div class="modal fade" id="productHistoryModal" tabindex="-1" aria-labelledby="productHistoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productHistoryModalLabel">Detalles de Venta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="HistoryDetailsContent">
                    <!-- Los detalles del producto se cargarán aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
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

    <script src="../assets/js/history_sales.js"></script>

</body>

</html>