
$(document).ready(function() {
    // Evento para capturar el cambio en el select de proveedores
    $('select[name="id_supplier"]').change(function() {
        var id_supplier = $(this).val(); // Obtengo el ID del proveedor seleccionado
        if (id_supplier) {
            $.ajax({
                url: '../controller/get_supplier_details.php', 
                type: 'POST',
                data: { id_supplier: id_supplier },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                      
                        $('#view_tax').text(response.tax);
                        $('#view_email').text(response.email);
                        $('#view_phone').text(response.phone);
                    } else {
                        Swal.fire('Error', 'No se pudieron obtener los detalles del proveedor.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'Hubo un problema con la solicitud AJAX.', 'error');
                }
            });
        }
    });
});

