document.addEventListener("DOMContentLoaded", function () {    
    $('#id_supplier').select2({
        placeholder: "Seleccione un proveedor",
        allowClear: true,
        width: '100%'
    });
    $('#id_product').select2({
        placeholder: "Seleccione un Producto",
        allowClear: true,
        width: '100%'
    });
    // Manejo de mensajes guardados en el almacenamiento local (para mostrar con SweetAlert)
    if (localStorage.getItem('mensaje') && localStorage.getItem('tipo')) {
        Swal.fire({
            title: 'Mensaje',
            text: localStorage.getItem('mensaje'),
            icon: localStorage.getItem('tipo'),
            confirmButtonText: 'Aceptar'
        });
        // Limpiar el mensaje después de mostrarlo
        localStorage.removeItem('mensaje');
        localStorage.removeItem('tipo');
    }
    // Manejo del cambio de proveedor para actualizar la información correspondiente
    $('#id_supplier').on('change', function() {
        var idSupplier = $(this).val();

        if (idSupplier) {
            $.ajax({
                url: '../controller/get_supplier.php',
                type: 'POST',
                data: { id_supplier: idSupplier },
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        Swal.fire({
                            title: 'Error',
                            text: data.error,
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    } else {
                        $('#view_tax').text(data.tax_identifier || '');
                        $('#view_email').text(data.email_supplier || '');
                        $('#view_phone').text(data.phone_supplier || '');
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al obtener la información del proveedor.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        } else {
            $('#view_tax').text('');
            $('#view_email').text('');
            $('#view_phone').text('');
        }
    });   

    const addSerialButton = document.getElementById("addSerialNumber");
if (addSerialButton) {
    addSerialButton.addEventListener("click", function() {
        console.log("Botón 'Agregar N° Serie' fue clickeado");

        const serialCheckbox = document.getElementById("serial_number");
        const product = $('#id_product').val();

        // Obtener el valor de cantidad usando el id del input
        const quantityInput = document.getElementById("quantity_input");
        const quantity = quantityInput ? quantityInput.value : 0; // Proporciona un valor predeterminado

        const serialCheckboxChecked = serialCheckbox.checked;
        const remitoNumber = $('#number_remito').val() + '-' + $('#remito').val();
        const supplier = $('#id_supplier').val();
        
        let errors = [];
        
        if (!product) {
            errors.push('Debe seleccionar un producto.');
        }
        if (quantity <= 0) {
            errors.push('Debe ingresar una cantidad mayor a 0.');
        }
        if (!serialCheckboxChecked) {
            errors.push('Debe marcar el checkbox de números de serie.');
        }
        if (!remitoNumber) {
            errors.push('Debe proporcionar un número de remito.');
        }
        if (!supplier) {
            errors.push('Debe seleccionar un proveedor.');
        }
        
        if (errors.length > 0) {
            Swal.fire({
                title: 'Error',
                text: errors.join(' '),
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        } else {
            console.log("Mostrando modal con producto:", product);
            console.log("Cantidad ingresada:", quantity); // Agrega esta línea para depuración

            // Cargar datos y abrir el modal
            document.getElementById("id_product_modal").value = product;
            document.getElementById("remito_number").value = remitoNumber;
            document.getElementById("id_supplier_modal").value = supplier;
            const tableBody = document.querySelector("#serialTable tbody");
            tableBody.innerHTML = "";
            for (let i = 0; i < quantity; i++) {
                const row = document.createElement("tr");
                const indexCell = document.createElement("th");
                indexCell.scope = "row";
                indexCell.textContent = i + 1;
                const serialInputCell = document.createElement("td");
                const serialInput = document.createElement("input");
                serialInput.type = "text";
                serialInput.name = `items[0][serial_numbers][${i}]`;
                serialInput.className = "form-control";
                serialInput.placeholder = `Ingrese el número de serie ${i + 1}`;
                serialInputCell.appendChild(serialInput);
                row.appendChild(indexCell);
                row.appendChild(serialInputCell);
                tableBody.appendChild(row);
            }
            const serialNumberModal = new bootstrap.Modal(document.getElementById("serialNumberModal"));
            serialNumberModal.show();

            // Deshabilitar los campos solo después de abrir el modal y validar que no haya errores
            serialCheckbox.disabled = true; // Deshabilitar el checkbox
            addSerialButton.disabled = true; // Deshabilitar el botón
            disableProductEditing(); // Deshabilitar producto y cantidad
        }
    });
}
    // Validación del formulario y envío con AJAX (Agregar números de serie)
    document.getElementById("serialForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Evita el envío normal del formulario    
        // Verificar que los campos ocultos tengan valores válidos
        const idProduct = document.getElementById("id_product_modal").value;
        const remitoNumber = document.getElementById("remito_number").value;
        const idSupplier = document.getElementById("id_supplier_modal").value;    
        if (!idProduct || !remitoNumber || !idSupplier) {
            Swal.fire({
                title: 'Error',
                text: 'Faltan datos esenciales para el envío. Verifique el ID del producto, el número de remito y el proveedor.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            return;
        }    
        const serialInputs = document.querySelectorAll("#serialTable input[name^='items[0][serial_numbers]']");
        let emptyFields = false;    
        serialInputs.forEach(function(input) {
            if (!input.value.trim()) {
                emptyFields = true;
            }
        });    
        if (emptyFields) {
            Swal.fire({
                title: 'Error',
                text: 'Todos los campos de números de serie deben estar completos.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        } else {
            // Enviar los datos con AJAX
            const formData = $(this).serialize();    
            $.ajax({
                url: '../controller/controller_addSerialNumber.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Éxito',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            const serialNumberModal = bootstrap.Modal.getInstance(document.getElementById("serialNumberModal"));
                            serialNumberModal.hide();
                            document.getElementById("serialForm").reset();
                            // Deshabilitar el checkbox y el botón solo si el formulario fue exitoso
                            const serialCheckbox = document.getElementById("serial_number");
                            const addSerialButton = document.getElementById("addSerialNumber");
                            serialCheckbox.checked = true; // Asegurarse de que esté marcado
                            serialCheckbox.disabled = true; // Deshabilitar el checkbox
                            addSerialButton.disabled = true; // Deshabilitar el botón
                            disableProductEditing(); // Deshabilitar producto y cantidad después del éxito
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.error || 'Error al guardar los números de serie.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al enviar el formulario.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }
    }); 
     //Verificar si ya hay números de serie ingresados
    const hasSerialNumbers = false;
    if (hasSerialNumbers) {
        const serialCheckbox = document.getElementById("serial_number");
        const addSerialButton = document.getElementById("addSerialNumber");
        
        serialCheckbox.checked = true;
        serialCheckbox.disabled = true;
        addSerialButton.disabled = true;
    }
    document.getElementById("serialFormUpdate").addEventListener("submit", function(event) {
        event.preventDefault(); // Evita el envío normal del formulario    
        const idProduct = document.getElementById("id_product_modal").value;
        const remitoNumber = document.getElementById("remito_number").value;
        const idSupplier = document.getElementById("id_supplier_modal").value;    
        if (!idProduct || !remitoNumber || !idSupplier) {
            Swal.fire({
                title: 'Error',
                text: 'Faltan datos esenciales para el envío. Verifique el ID del producto, el número de remito y el proveedor.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            return;
        }    
        const serialInputs = document.querySelectorAll("#productDetailsTable input[name^='items[0][serial_numbers]']");
        let emptyFields = false;    
        serialInputs.forEach(function(input) {
            if (!input.value.trim()) {
                emptyFields = true;
            }
        });
            if (emptyFields) {
            Swal.fire({
                title: 'Error',
                text: 'Todos los campos de números de serie deben estar completos.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        } else {
            const formData = new FormData(this);
            formData.append("id_product", idProduct);
            formData.append("remito_number", remitoNumber);
            formData.append("id_supplier", idSupplier);    
            $.ajax({
                url: '../controller/controller_updateSerialNumber.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Éxito',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            const productDetailsModal = bootstrap.Modal.getInstance(document.getElementById("productDetailsModal"));
                            productDetailsModal.hide();
                            document.getElementById("serialFormUpdate").reset();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.error || 'Error al actualizar los números de serie.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al enviar el formulario.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }
    });   
    let productCounter = 0;
    const table = $('#table_products').DataTable();    
    // Manejo del evento click en el botón para agregar el producto a la tabla
    $('#addProduct').on('click', function() {
        const productId = $('#id_product').val(); 
        const productName = $('#id_product option:selected').text().trim();
        const quantity = $('#quantity_input').val(); 
        const supplierId = $('#id_supplier').val();     
        // Verificar si se seleccionó un producto, se ingresó una cantidad y un proveedor
        if (productId && quantity > 0 && supplierId) {
            let productExists = false;    
            // Verificar si el producto ya ha sido agregado a la tabla
            $('#table_products tbody tr').each(function() {
                const existingProductId = $(this).find('input[name^="items"][name$="[id_product]"]').val();
                if (existingProductId === productId) {
                    productExists = true;
                    return false; // Salir del loop si el producto ya existe
                }
            });    
            if (productExists) {
                Swal.fire('Error', 'El producto ya ha sido agregado.', 'error');
            } else {
                // Agregar la nueva fila a la tabla con los datos seleccionados
                table.row.add([
                    `<input type="hidden" name="items[${productCounter}][id_product]" value="${productId}">${productCounter+1}`,
                    `<input type="hidden" name="items[${productCounter}][name_product]" value="${productName}">${productName}`,
                    `<input type="hidden" name="items[${productCounter}][quantity]" value="${quantity}">${quantity}`,
                    `<button type="button" class="view-details" data-product-id="${productId}" data-supplier-id="${supplierId}"><i class="fa fa-binoculars"></i></button>`,
                    `<button type="button" class="delete-row"><i class="fas fa-trash-alt"></i></button>`
                ]).draw();    
                // Incrementar el contador de productos
                productCounter++;    
                // Limpiar los campos para la próxima entrada
                $('#id_product').val('').trigger('change'); 
                $('#quantity_input').val('');     
                // Manejar la lógica del proveedor
                $('#id_supplier').prop('disabled', true); // Deshabilitar la selección de proveedor si es necesario    
                // Habilitar la edición de productos
                enableProductEditing();    
                // Habilitar o deshabilitar el checkbox y botón de serie si corresponde
                const serialCheckbox = document.getElementById("serial_number");
                const addSerialButton = document.getElementById("addSerialNumber");    
                serialCheckbox.checked = false;
                serialCheckbox.disabled = false;
                addSerialButton.disabled = false;    
                // Si no existe el campo oculto de proveedor, agregarlo
                if (!$('input[name="supplier_id"]').length) {
                    $('<input>').attr({
                        type: 'hidden',
                        id: 'hidden_supplier_id',
                        name: 'supplier_id',
                        value: supplierId
                    }).appendTo('form');
                }
            }
        } else {
            Swal.fire('Error', 'Debe seleccionar un producto, un proveedor y una cantidad válida.', 'error');
        }
    });    
    // Manejo de la edición de códigos de serie al mostrar detalles del producto
    $('#table_products tbody').on('click', '.view-details', function() {
        const productId = $(this).data('product-id');
        const supplierId = $(this).data('supplier-id');
        const remitoNumber = document.querySelector('input[name="remito_number"]').value;
        const dataToSend = {
            id_product: productId,
            remito_number: remitoNumber,
            id_supplier: supplierId
        };
        $.ajax({
            url: '../controller/get_codSerie.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(dataToSend),
            dataType: 'json',
            success: function(data) {
                if (data && data.length > 0) {
                    fillProductDetailsModal(data);
                    // Completa los campos ocultos del modal
                    document.getElementById("id_product_modal").value = productId;
                    document.getElementById("remito_number").value = remitoNumber;
                    document.getElementById("id_supplier_modal").value = supplierId;
                    const productDetailsModal = new bootstrap.Modal(document.getElementById("productDetailsModal"), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    productDetailsModal.show();
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'No se encontraron detalles del producto.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error during POST request:', xhr.responseText || error);
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al obtener los detalles del producto.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });
    
// Manejar el clic en el botón de eliminar fila
$('#table_products tbody').on('click', '.delete-row', function (e) {
    e.preventDefault(); // Evita la acción por defecto del enlace o botón
    const row = table.row($(this).closest('tr')); 
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Estás seguro de que deseas eliminar este producto?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Eliminar la fila solo si el usuario confirma
            row.remove().draw();
            // Si no hay filas restantes, permitir la selección del proveedor nuevamente
            if (table.rows().count() === 0) {
                $('#id_supplier').prop('disabled', false);
                enableProductEditing(); // Habilitar edición de producto y cantidad nuevamente
            }
            Swal.fire(
                'Eliminado',
                'El producto ha sido eliminado.',
                'success'
            );
        }
    });
});
});
function disableProductEditing() {
    // Deshabilita el select de producto y el campo de cantidad
    $('#id_product').prop('disabled', true);
    $('input[name="items[0][quantity]"]').prop('disabled', true);
}

function enableProductEditing() {
    // Habilita el select de producto y el campo de cantidad
    $('#id_product').prop('disabled', false);
    $('input[name="items[0][quantity]"]').prop('disabled', false);
}

// Función para llenar el modal con los datos existentes del producto
function fillProductDetailsModal(serialNumbers) {
    const tbody = document.querySelector("#productDetailsTable tbody");
    tbody.innerHTML = ''; // Limpiar filas existentes
    serialNumbers.forEach((serial, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <th scope="row">${index + 1}</th>
            <td>
                <input type="text" name="items[0][serial_numbers][]" value="${serial.serial_number}" class="form-control">
                <input type="hidden" name="items[0][line_numbers][]" value="${serial.line_number}">
            </td>
        `;
        tbody.appendChild(row);
    });
}