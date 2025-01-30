<?php
session_start();
include_once "../models/functions.php";
$categorys = obtenercategorys();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control de stock</title>  
    <!-- Google Font: Source Sans Pro --> 
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css"></Link>
        <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css"></Link>
        <link rel="stylesheet" href="../assets/css/style_lista_cliente.css"></Link>
        <link rel="stylesheet" href="../assets/css/bootstrap.min5.3.css"></Link>
        <link rel="stylesheet" href="../assets/css/dataTables.bootstrap5.css"></Link>
        <link rel="stylesheet" href="../assets/css/searchPanes.bootstrap5.css"></Link>
        <link rel="stylesheet" href="../assets/css/select.bootstrap5.css"></Link>
        <!-- SweetAlert -->
        <script src="../assets/js/sweetalert2@11.js"></script>
</head>
<body class="sidebar-mini" style="height: auto;">
    <div class="wrapper">
        <?php include "header.php"?>
        <?php include "menu.php"?>
        <div class="content-wrapper" style="min-height: 1604.8px;">
            <main>
                <div class="container-fluid" style="padding:50px;">
                    <div class="card" style="margin-top:5px">
                        <div class="card-header">
                            <div class="row mb-12">
                                <div class="col-sm-6">
                                    <h4><b>Listado de Categorías</b>
                               
                                        <a type="button"
                                            class="btn btn-success btn btn-primary btn-lg create_brands_Btn text-white"
                                            data-bs-toggle="modal" data-bs-target="#createEmployeeModal"
                                            data-action="add" data-placement="right" title="Nuevo"><i
                                                class="fas fa-plus-circle fa-lg"></i></a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="table-wrapper">
                            <table class="table table-striped table-hover" id="table_products">
                                <thead>
                                    <tr>
                                        <th>Categorías</th>
                                     
                                          <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categorys as $categoria): ?>
                                    <?php if ($categoria['id_status'] == 1): ?>
                                    <tr>
                                        <td><?php echo $categoria['detail']; ?></td>
                                        <td>
                                       
                                            <a class="btn btn-warning float-center editBtn text-white"
                                                data-bs-toggle="modal"
                                                data-id="<?php echo $categoria['id_category']; ?>"
                                                data-detail="<?php echo $categoria['detail']; ?>"><i
                                                    class="fas fa-edit"></i></a>
                                            <a class="btn btn-danger float-center delete_Btn text-white"
                                                data-bs-toggle="modal"
                                                data-id="<?php echo $categoria['id_category']; ?>"
                                                data-detail="<?php echo $categoria['detail']; ?>"><i
                                                    class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <?php include "footer.php"?>
    </div>

    <div id="createEmployeeModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered" style="width: 300px">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white">Crear Categoría</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white;">&times;</span>
                    </button>
                </div>
                <form action="../controller/controller_categorys.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="create-detail">Nombre</label>
                            <input type="text" class="form-control" id="create-detail" name="name_category"
                                pattern="[A-Za-záéíóúÁÉÍÓÚñÑ0-9\s]+" minlength="2" maxlength="200" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="editEmployeeModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered" style="width: 300px">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white">Editar Categoría</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white;">&times;</span>
                    </button>
                </div>
                <form action="../controller/edit_category.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="edit-id" id="edit-id">
                        <div class="form-group">
                            <label for="edit-detail">Nombre</label>
                            <input type="text" class="form-control" id="edit-detail" name="edit-detail"
                                pattern="[A-Za-záéíóúÁÉÍÓÚñÑ0-9\s]+" minlength="2" maxlength="200" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="deleteEmployeeModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered" style="width: 300px">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white">Deshabilitar Categoría</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white;">&times;</span>
                    </button>
                </div>
                <form action="../controller/delete_category.php" method="post">
                    <div class="modal-body">
                        <p>¿Está seguro que desea Deshabilitar esta categoría?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="edit-id_category" id="edit-id_category">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Deshabilitar</button>
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
<script src="../assets/plugins/bootstrap/js/bootstrap.bumdle-v5.3.js"></script>
<script src="../assets/js/accions_categorys.js"></script>
    <!-- jQuery -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/adminlte.min.js"></script>
    <!-- jQuery -->
    <script src="../assets/plugins/jquery/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/modal_products.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="../assets/js/dataTables.js"></script>
    <script src="../assets/js/dataTables.bootstrap5.js"></script>
    <script src="../assets/js/dataTables.searchPanes.js"></script>
    <script src="../assets/js/searchPanes.bootstrap5.js"></script>
    <script src="../assets/js/dataTables.select.js"></script>
    <script src="../assets/js/select.bootstrap5.js"></script>
    <script>
    $("#table_products").DataTable({
        pageLength: 5,
     
        columns: [{
            width: '50%'
        }, {
            width: '50%'
        }, ]
    });
    </script>
    <script>
    $(document).on("click", ".editBtn", function() {
        var id_category = $(this).data('id');
        var detail = $(this).data('detail');
        $("#editEmployeeModal #edit-id").val(id_category);
        $("#editEmployeeModal #edit-detail").val(detail);
        $("#editEmployeeModal").modal("show");
    });
    $(document).on("click", ".delete_Btn", function() {
        var id_category = $(this).data('id');
        var detail = $(this).data('detail');
        $("#deleteEmployeeModal #edit-id_category").val(id_category);
        $("#deleteEmployeeModal").modal("show");
    });
    </script>
</body>

</html>