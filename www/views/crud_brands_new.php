<?php
session_start();
include_once "../controller/insert_brands.php";
include_once "../controller/edit_brand.php";
include_once "../controller/delete_brand.php";
include_once "../models/functions.php";
$show=show_state("brands");

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control de stock</title>  
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css"></Link>
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css"></Link>
    <link rel="stylesheet" href="../assets/css/style_lista_cliente.css"></Link>
    <link rel="stylesheet" href="../assets/css/bootstrap.min5.3.css"></Link>
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap5.css"></Link>
    <link rel="stylesheet" href="../assets/css/searchPanes.bootstrap5.css"></Link>
    <link rel="stylesheet" href="../assets/css/select.bootstrap5.css"></Link>
    <!-- SweetAlert2 -->
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
            <main>
                <div class="container-fluid" style="padding:50px;">
                    <div class="card" style="margin-top:5px">
                        <div class="card-header">
                            <div class="row mb-12">
                                <div class="col-sm-6">
                                    <h4><b>Listado de Marcas &nbsp&nbsp&nbsp</b>
                                   
                                        <a type="button"
                                            class="btn btn-success btn btn-primary btn-lg create_brands_Btn text-white"
                                            data-toggle="modal" data-target="#" data-action="add" data-placement="right"
                                            title="Nuevo"><i class="fas fa-plus-circle fa-lg"></i></a>
                                    </h4>
                                </div><!-- /.col -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.row -->
                    <div class="table-responsive">
                        <div class="table-wrapper">
                            <table class="table table-striped table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                   
                                             <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($show as $row) { ?>
                                    <tr>
                                        <td><?php echo $row->detail ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-warning float-center editBtn text-white"
                                                data-id_brand="<?php echo $row->id_brand ?>"
                                                data-detail="<?php echo $row->detail?>"><i class="fas fa-edit"></i></a>
                                            <a class="btn btn-danger float-center delete_Btn text-white"
                                                data-id_brands="<?php echo $row->id_brand ?>"><i
                                                    class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <!-- Main content -->
        </div>
        <?php include "footer.php"?>
    </div>
    <!-- Modal para Crear Marcas-->
    <div id="create_Modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered" style="width: 300px">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white">Crear Marca</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="../controller/insert_brands.php" method="post">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="name_product">Nombre</label>
                            <input type="text" name="detail" class="form-control" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ0-9\s]+"
                                minlength="2" maxlength="200" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="enviar">Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Fin Modal para Crear Marcas -->
    <!--Modal de Editar Marcas-->
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered" style="width: 300px">

            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white">Editar Marca</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="../controller/edit_brand.php" method="post">
                        <input type="hidden" name="id_brand" id="id_brand" class="form-control" value="">
                        <div class="form-group">
                            <label for="edit_name">Nombre</label>
                            <input type="text" class="form-control" id="detail" name="detail"
                                pattern="[A-Za-záéíóúÁÉÍÓÚñÑ0-9\s]+" minlength="2" maxlength="200" required value="">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" name="save_data">Guardar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- Fin Modal para Editar Marcas-->

    <!-- Eliminar Marcas -->
    <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered" style="width: 300px">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white">Deshabilitar Marca</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white" ;>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="../controller/delete_brand.php" method="post">
                    <div class="modal-body">
                        <h4>Estas seguro que desea Deshabilitar la Marca </h4>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_brand" id="id_brand_eliminate"
                            value="<?php echo $row->id_brand?>">
                        <input type="button" class="btn btn-success" data-dismiss="modal" value="Volver">
                        <input type="submit" class="btn btn-danger" name="delete" value="Deshabilitar">
                    </div>
                </form>
            </div>
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
    <!-- jQuery -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/adminlte.min.js"></script>
    <!-- jQuery -->
    <script src="../assets/plugins/jquery/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
    <script src="../assets/js/modal_brands.js"></script>
    <!-- DataTables -->
    <script src="../assets/js/dataTables.js"></script>
    <script src="../assets/js/dataTables.bootstrap5.js"></script>
    <script src="../assets/js/dataTables.searchPanes.js"></script>
    <script src="../assets/js/searchPanes.bootstrap5.js"></script>
    <script src="../assets/js/dataTables.select.js"></script>
    <script src="../assets/js/select.bootstrap5.js"></script>
    <script>
    $("#myTable").DataTable({
        pageLength: 5,
     
        columns: [{
            width: '50%'
        }, {
            width: '50%'
        }]
    });
    </script>
</body>

</html>