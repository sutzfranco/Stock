$(document).ready(function () {

    // Inicialización de DataTable para proveedores
    var table = $('#table_proveedores').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50, 75, 100], 
        language: {
            url: "../assets/lang/spanish.json",
        },
        columns: [
            { width: '20%' },
            { width: '20%' },
            { width: '20%' },
            { width: '20%' },
            { width: '20%' }
        ],
        dom: '<"top"lf><"table-responsive"t><"bottom"ip>',
        buttons: [
            {
                extend: 'excelHtml5',
                className: 'btn btn-success',
                text: '<i class="far fa-file-excel"></i> Excel',
                exportOptions: {
                    columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                },
                customize: function (xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('row c[r^="A"]', sheet).each(function () {
                        $(this).attr('s', '2'); // Agrega estilo a la primera columna
                    });
                }
            },
            {
                extend: 'pdfHtml5',
                className: 'btn btn-danger',
                text: '<i class="far fa-file-pdf"></i> PDF',
                exportOptions: {
                    columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                },
                pageSize: 'A4',
                customize: function (doc) {
                    doc.content[1].table.widths = ['25%', '25%', '25%', '25%']; 
                }
            }
        ],
        initComplete: function () {
            // Mover los botones al contenedor personalizado
            table.buttons().container().appendTo('#botones');
        }
    });
    // Mostrar modal para crear proveedor
    $('.create_suppliers_Btn').click(function () {
        $('#create_Modal').modal('show');
    });

    // Mostrar modal de vista de proveedor
    $('.viewBtn').click(function () {
        var id_supplier = $(this).data('id');
        var name_supplier = $(this).data('name');
        var phone_supplier = $(this).data('phone');
        var email_supplier = $(this).data('email');
        var observations = $(this).data('obs');
        var tax_identifier = $(this).data('tax');
        var street_supplier = $(this).data('street');
        var height_supplier = $(this).data('height');
        var floor_supplier = $(this).data('floor');
        var departament_supplier = $(this).data('departament');
        var location_supplier = $(this).data('location');

        // Asignar valores a los campos del modal de vista
        $('#view_name').text(name_supplier);
        $('#view_phone').text(phone_supplier);
        $('#view_email').text(email_supplier);
        $('#view_obs').text(observations);
        $('#view_tax').text(tax_identifier);
        $('#view_street').text(street_supplier);
        $('#view_height').text(height_supplier);
        $('#view_floor').text(floor_supplier);
        $('#view_departament').text(departament_supplier);
        $('#view_location').text(location_supplier);

        // Mostrar modal de vista
        $('#viewModal').modal('show');
    });

    // Mostrar modal de edición de proveedor
    $('.editBtn').click(function () {
        var id_supplier = $(this).data('id');
        var name_supplier = $(this).data('name');
        var phone_supplier = $(this).data('phone');
        var email_supplier = $(this).data('email');
        var observations = $(this).data('obs');
        var tax_identifier = $(this).data('tax');
        var street_supplier = $(this).data('street');
        var height_supplier = $(this).data('height');
        var floor_supplier = $(this).data('floor');
        var departament_supplier = $(this).data('departament');
        var location_supplier = $(this).data('location');

        // Asignar valores a los campos del modal de edición
        $('#id_supplier').val(id_supplier);
        $('#name_supplier').val(name_supplier);
        $('#phone').val(phone_supplier);
        $('#email').val(email_supplier);
        $('#obs').val(observations);
        $('#tax').val(tax_identifier);
        $('#street').val(street_supplier);
        $('#height').val(height_supplier);
        $('#floor').val(floor_supplier);
        $('#departament').val(departament_supplier);
        $('#location').val(location_supplier);

        // Mostrar modal de edición
        $('#editModal').modal('show');
    });

    // Mostrar modal de eliminación de proveedor
    $('.delete_Btn').click(function () {
        var supplier_id = $(this).data('id_suppliers');
        var name_supplier = $(this).data('name');  
        // Asignar el ID y el nombre al modal de eliminación
        $('#id_supplier_eliminate').val(supplier_id);
        $('#view-name').val(name_supplier);

        // Mostrar modal de eliminación
        $('#deleteModal').modal('show');
    });

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
});