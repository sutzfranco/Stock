<?php
session_start();
include_once "../models/functions.php";

$dataGraficos = obtenerDatosGraficos();
$productosMasVendidos = $dataGraficos['productosMasVendidos'];
$vendidoEnElMes = $dataGraficos['vendidoenelmes'];
$stockProductos = $dataGraficos['stockProductos'];
$gananciasAnuales = $dataGraficos['gananciasAnuales'];
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="sidebar-mini" style="height: auto;">
    <div class="wrapper">
        <!-- HEADER -->
        <?php include "header.php" ?>
        <!-- MENU -->
        <?php include "menu.php" ?>
        <!-- Contenido Principal -->
        <div class="container mt-5">
            <!-- Title -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <h1 class="text-center">Estadísticas</h1>
                </div>
            </div>

            <div class="row">
                <!-- Producto Más Vendido - Pie Chart -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <h5 class="card-title mb-0">Producto Más Vendido</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Ganancias Mensuales - Bar Chart -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">Ventas en el Mes</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Stock Actual - Line Chart -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Stock Actual</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Ganancias Anuales - Area Chart -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">Ventas Anuales</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="areaChart"></canvas>
                        </div>
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

    <!-- Chart.js Script -->
    <script>
        // Pie Chart - Producto Más Vendido
        var productos = <?php echo json_encode(array_column($productosMasVendidos, 'name_product')); ?>;
        var vendidos = <?php echo json_encode(array_column($productosMasVendidos, 'total_vendido')); ?>;
        var ctxPie = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: productos,
                datasets: [{
                    label: 'Producto más vendido',
                    data: vendidos,
                    backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef']
                }]
            }
        });

        // Bar Chart - Ganancias Mensuales
        var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        var ganancias = <?php echo json_encode(array_column($vendidoEnElMes, 'total_vendido')); ?>; // Asegúrate de que esta sea la columna correcta
        var ctxBar = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: meses.slice(0, ganancias.length),
                datasets: [{
                    label: 'Ventas totales en el mes ',
                    data: ganancias,
                    backgroundColor: '#00a65a',
                }]
            }
        });

        // Line Chart - Stock Actual
        var productosStock = <?php echo json_encode(array_column($stockProductos, 'name_product')); ?>;
        var stock = <?php echo json_encode(array_column($stockProductos, 'stock')); ?>;
        var ctxLine = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: productosStock,
                datasets: [{
                    label: 'Stock Actual',
                    data: stock,
                    borderColor: '#3b8bba',
                    fill: false
                }]
            }
        });

        // Area Chart - Ganancias Anuales
        var anios = <?php echo json_encode(array_column($gananciasAnuales, 'año')); ?>; // Asegúrate de que esta sea la columna correcta
        var gananciasAnuales = <?php echo json_encode(array_column($gananciasAnuales, 'total_anual')); ?>; // Asegúrate de que esta sea la columna correcta
        var ctxArea = document.getElementById('areaChart').getContext('2d');
        var areaChart = new Chart(ctxArea, {
            type: 'line',
            data: {
                labels: anios,
                datasets: [{
                    label: 'Ventas Anuales',
                    data: gananciasAnuales,
                    backgroundColor: 'rgba(60, 141, 188, 0.7)',
                    borderColor: 'rgba(60, 141, 188, 1)',
                    fill: true
                }]
            }
        });
    </script>
</body>

</html>