<?php
session_start();
include_once "../models/functions.php";
$usuarios = obtenerusuarios();
$roles = obtenerroles();
if (isset($_SESSION["id_rol"]) && ($_SESSION["id_rol"] == 1 || $_SESSION["id_rol"] == 2)) {
} else {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agencia 1</title>
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../assets/css/style_lista_cliente.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min5.3.css"></link>
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
                                    <h4><b>Listado de Usuarios</b>
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
                            <table id="table_usuarios" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Teléfono</th>
                                        <th>Contraseña</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($usuarios as $usuario): ?>
                                    <?php if ($usuario['id_status'] == 1): ?>
                                    <tr>
                                        <td><?php echo $usuario['email_user']; ?></td>
                                        <td><?php echo $usuario['phone']; ?></td>
                                        <td><?php echo $usuario['password']; ?></td>
                                        <td> <a href="#viewEmployeeModal"
                                                class="view btn btn-success long_letter text-white"
                                                data-bs-toggle="modal" data-id="<?php echo $usuario['id_user']; ?>"
                                                data-name="<?php echo $usuario['email_user']; ?>"
                                                data-phone="<?php echo $usuario['phone']; ?>"
                                                data-password="<?php echo $usuario['password']; ?>">
                                                <i style="width: 19px; height: 10px;" class="fas fa-binoculars"></i>
                                            </a>
                                            <a href="#editEmployeeModal"
                                                class="btn btn-warning float-center editBtn text-white"
                                                data-bs-toggle="modal" data-id="<?php echo $usuario['id_user']; ?>"
                                                data-name="<?php echo $usuario['email_user']; ?>"
                                                data-phone="<?php echo $usuario['phone']; ?>"
                                                data-password="<?php echo $usuario['password']; ?>"
                                                data-rol="<?php echo $usuario['id_rol']; ?>">
                                                <i style="width: 19px; height: 10px;" class="fas fa-edit"></i>
                                            </a>
                                            <a href="#deleteEmployeeModal"
                                                class="btn btn-danger float-center deleteBtn text-white"
                                                data-bs-toggle="modal" data-id="<?php echo $usuario['id_user']; ?>"
                                                data-name="<?php echo $usuario['email_user']; ?>"
                                                data-rol="<?php echo $usuario['id_rol']; ?>">
                                                <i class="fas fa-trash-alt">
                                                </i>
                                            </a>
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
 <!-- createEmployeeModal -->
<div id="createEmployeeModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered" style="width: 300px">
        <div class="modal-content">
            <form action="../controller/controller_usuario.php" method="post">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white">Crear Usuario</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="create-user">Email de Usuario</label>
                        <input type="email" class="form-control" id="create-user" name="name_user" minlength="2" maxlength="200" required
                        title="Debe contenter solo letras">
                    </div>
                    <div class="form-group">
                        <label for="create-phone">Teléfono</label>
                        <input type="text" class="form-control" id="create-phone" name="phone" required
                            pattern="^\d{10}$" maxlength="10" title="Debe contener exactamente 10, sin el 0 ni el 15 dígitos">
                    </div>
                    <div class="form-group">
                        <label for="create-password">Contraseña</label>
                        <input type="password" class="form-control" id="create-password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" 
                            title="La contraseña debe tener al menos 8 caracteres, incluyendo al menos un número, una letra mayúscula, una letra minúscula y un carácter especial." minlength="8" required>
                    </div>
                    <div class="form-group">
                        <label for="create-role">Rol</label>
                        <select class="form-control" id="create-role" name="role">     <div class="form-group">
                           <?php
                            foreach ($roles as $role) {
                                echo '<option value="'.$role['id_rol'].'">'.$role['detail'].'</option>';
                            }
                            ?>
                    </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
   <!-- editEmployeeModal -->
<div id="editEmployeeModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered" style="width: 300px">
        <div class="modal-content">
            <form action="../controller/edit_usuario.php" method="post">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white">Editar Usuario</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="edit-id_user" id="edit-id_user">
                    <div class="form-group">
                        <label for="edit-name">Email de usuario</label>
                        <input type="email" class="form-control" id="edit-name" name="edit-name" minlength="2" maxlength="200" required
                        title="Debe contenter solo letras">
                    </div>
                    <div class="form-group">
                        <label for="edit-phone">Teléfono</label>
                        <input type="text" class="form-control" id="edit-phone" name="edit-phone" pattern="^\d{10}$"
                            maxlength="10" title="Debe contener exactamente 10, sin el 0 ni el 15 dígitos">
                    </div>
                    <div class="form-group">
                        <label for="edit-password">Contraseña</label>
                        <input type="text" class="form-control" id="edit-password" name="edit-password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" 
                            title="La contraseña debe tener al menos 8 caracteres, incluyendo al menos un número, una letra mayúscula, una letra minúscula y un carácter especial." minlength="8">
                    </div>
                    <div class="form-group">
                        <label for="edit-role">Rol</label>
                        <select class="form-control" id="edit-role" name="edit-role">
                           <?php
                            foreach ($roles as $role) {
                                echo '<option value="'.$role['id_rol'].'">'.$role['detail'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- View Modal HTML -->
    <div id="viewEmployeeModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered" style="width: 300px">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h4 class="modal-title text-white">Detalles Usuario</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="view-email">Email</label>
                        <input type="email" class="form-control" id="view-name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="view-phone">Teléfono</label>
                        <input type="text" class="form-control" id="view-phone" readonly>
                    </div>
                    <div class="form-group">
                        <label for="view-password">Contraseña</label>
                        <input type="text" class="form-control" id="view-password" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteEmployeeModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered" style="width: 300px">
            <div class="modal-content">
                <form action="../controller/delete_usuario.php" method="post">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title text-white">Deshabilitar Usuario</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Está seguro que desea deshabilitar este usuario?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="delete-id_rol" id="delete-id_rol">
                        <input type="hidden" name="delete-id_user" id="delete-id_user">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
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
<script src="../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/dist/js/adminlte.min.js"></script>
    <script src="../assets/js/accions_usuarios.js"></script>
    <script src="../assets/js/dataTables.js"></script>
    <script src="../assets/js/dataTables.bootstrap5.js"></script>
    <script src="../assets/js/dataTables.searchPanes.js"></script>
    <script src="../assets/js/searchPanes.bootstrap5.js"></script>
    <script src="../assets/js/dataTables.select.js"></script>
    <script src="../assets/js/select.bootstrap5.js"></script>

    <script>
    $('#table_usuarios').DataTable({
        pageLength: 4,
        language: {
            url: "../assets/lang/spanish.json",

        },
        columns: [{
            width: '20%'
        }, {
            width: '20%'
        }, {
            width: '20%'
        }, {
            width: '20%'
        }]



    });
    </script>


</body>

</html>