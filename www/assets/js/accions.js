$(document).ready(function(){
    // Activate tooltip
    $('[data-toggle="tooltip"]').tooltip();
    // Select/Deselect checkboxes
    var $checkbox = $('table tbody input[type="checkbox"]');
    $("#selectAll").click(function(){
        $checkbox.prop('checked', this.checked);
    });
    $checkbox.click(function(){
        if(!this.checked){
            $("#selectAll").prop("checked", false);
        }
    });

    // captura el clic en el icono de edición
    $('.edit').on('click', function(){
        // obtiene los datos del cliente del data attributes
        var $editModal = $('#editEmployeeModal');
        var $editForm = $editModal.find('form');

        var id = $(this).data('id');
        var name = $(this).data('name');
        var email = $(this).data('email');
        var cuit = $(this).data('cuit');
        var phone = $(this).data('phone');
        var street = $(this).data('street');
        var height = $(this).data('height');
        var floor = $(this).data('floor');
        var departament = $(this).data('departament');
        var location = $(this).data('location');
        var observaciones = $(this).data('observaciones');
        
        // llena los campos del formulario del modal de edición
        $editForm.find('#edit-id_customer').val(id);
        $editForm.find('#edit-name').val(name);
        $editForm.find('#edit-email').val(email);
        $editForm.find('#edit-cuit').val(cuit);
        $editForm.find('#edit-phone').val(phone);
        $editForm.find('#edit-street').val(street);
        $editForm.find('#edit-height').val(height);
        $editForm.find('#edit-floor').val(floor);
        $editForm.find('#edit-department').val(departament);
        $editForm.find('#edit-location').val(location);
        $editForm.find('#edit-observaciones').val(observaciones);

        // muestra el modal 
        $editModal.modal('show');
    });
});

    // captura el clic en el icono de Vista
    $('.view').on('click', function(){
        // obtiene los datos del cliente del data attributes
        var $viewModal = $('#viewEmployeeModal');
        var $viewForm = $viewModal.find('form');

        var id = $(this).data('id');
        var name = $(this).data('name');
        var email = $(this).data('email');
        var cuit = $(this).data('cuit');
        var phone = $(this).data('phone');
        var street = $(this).data('street');
        var height = $(this).data('height');
        var floor = $(this).data('floor');
        var departament = $(this).data('departament');
        var location = $(this).data('location');
        var observaciones = $(this).data('observaciones');
        
        // llena los campos del formulario del modal de edición
        $viewForm.find('#view-id_customer').val(id);
        $viewForm.find('#view-name').val(name);
        $viewForm.find('#view-email').val(email);
        $viewForm.find('#view-cuit').val(cuit);
        $viewForm.find('#view-phone').val(phone);
        $viewForm.find('#view-street').val(street);
        $viewForm.find('#view-height').val(height);
        $viewForm.find('#view-floor').val(floor);
        $viewForm.find('#view-department').val(departament);
        $viewForm.find('#view-location').val(location);
        $viewForm.find('#view-observaciones').val(observaciones);

        // muestra el modal 
        $viewModal.modal('show');
    });



    $(document).ready(function(){
        // Captura el clic en el enlace de eliminar
        $('.delete').on('click', function(){
            var $viewModal = $('#deleteEmployeeModal');
            var $viewForm = $viewModal.find('form');
    
            var id = $(this).data('id');
            var name = $(this).data('name');   
    
            console.log("ID:", id); 
            console.log("Name:", name); 
            
            $viewForm.find('#edit-id_customer').val(id);
            $viewForm.find('#view-name').val(name);
    
            // Muestra el modal 
            $viewModal.modal('show');
        });
    });
    
    
