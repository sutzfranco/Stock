$(document).ready(function() {
    $('.select2').select2();
    $('#id_customer').on('change', function() {
        var customerId = $(this).val();
        console.log('Cliente seleccionado:', customerId); 
        if (customerId) {
            $.ajax({
                url: '../controller/get_sales_details.php',
                type: 'POST',
                data: { id_customer: customerId },
                dataType: 'json',
                success: function(response) {
                    console.log('Respuesta del servidor:', response); 
                    if (response && !response.error) {
                        $('#view_tax').text(response.tax_identifier);
                        $('#view_email').text(response.email_customer);
                        $('#view_phone').text(response.phone_customer);
                    } else {
                        console.error('Error en la respuesta:', response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud:', status, error);
                }
            });
        } else {
            $('#view_tax').text('');
            $('#view_email').text('');
            $('#view_phone').text('');
        }
    });
});
