document.addEventListener("DOMContentLoaded", function () {
    // Inicializar Select2 para los campos de Clientes y Productos
    $('#id_customer, #id_product').select2({
        allowClear: true,
        width: '100%',
    });

    // Manejo de mensajes guardados en el almacenamiento local con SweetAlert
    if (localStorage.getItem('mensaje') && localStorage.getItem('tipo')) {
        Swal.fire({
            title: 'Mensaje',
            text: localStorage.getItem('mensaje'),
            icon: localStorage.getItem('tipo'),
            confirmButtonText: 'Aceptar',
        });

        localStorage.removeItem('mensaje');
        localStorage.removeItem('tipo');
    }  
    // Detectar cambios en el select de clientes
    $('#id_customer').on('change', function () {
        var idCustomer = $(this).val();
        if (idCustomer) {
            $.ajax({
                url: '../controller/get_customer.php',
                type: 'POST',
                data: { id_customer: idCustomer },
                dataType: 'json',
                success: function (data) {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        // Actualizar los campos con la información recibida
                        $('#view_tax').text(data.tax_identifier || '');
                        $('#view_email').text(data.email_customer || '');
                        $('#view_phone').text(data.phone_customer || '');
                    }
                },
                error: function () {
                    alert('Error al obtener la información del cliente.');
                },
            });
        } else {
            // Limpiar los campos si no hay cliente seleccionado
            $('#view_tax, #view_email, #view_phone').text('');
        }
    });
// Escuchar el submit del formulario con el ID correcto
document.querySelector("#insertSalesForm").addEventListener("submit", function (e) {
    e.preventDefault();  // Prevenir el comportamiento por defecto

    const formData = new FormData(this);  // Obtener los datos del formulario

    fetch(this.action, {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Venta registrada con éxito',
                text: data.message,
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Sí, imprimir',
                cancelButtonText: 'No, continuar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Abrir la vista de remito en una nueva pestaña
                    window.open(`../views/remito.php?sales_number=${data.sales_number}`, '_blank');
                    
                    // Después de abrir la nueva pestaña, redirigir a sales.php
                    window.location.href = "../views/sales.php";  
                } else {
                    // Si se cancela la impresión, simplemente redirigir a sales.php
                    window.location.href = "../views/sales.php";
                }
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message || 'Hubo un problema al registrar la venta.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Error',
            text: 'Hubo un problema con la conexión al servidor.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
});

    let productCounter = 0;

    // Inicializa la tabla con anchos de columnas definidos
    const table = $('#table_products').DataTable({
        columnDefs: [
            { width: "2%", targets: 0 }, 
            { width: "43%", targets: 1 }, 
            { width: "10%", targets: 2 }, 
            { width: "35%", targets: 3 },
            { width: "10%", targets: 4 }  
        ],
        autoWidth: false 
    });
    $(document).on('keydown', `.serial-input`, function(e) {
        // Verificamos si se presionó Enter (código 13) o Tab (código 9)
        if (e.which === 13 || e.which === 9) {  
            e.preventDefault(); // Evita el comportamiento por defecto de las teclas
    
            const productId = $(this).data('product-id');
            const quantity = $(this).data('quantity'); // Cantidad máxima permitida de seriales
            const serialInput = $(`#serial_input_${productId}`);
            const serialList = $(`#serial_list_${productId}`);
            const serialsField = $(`#serials_${productId}`);
    
            // Obtenemos el valor del input
            const newSerial = serialInput.val().trim();
    
            if (newSerial) {
                // Verificamos si el serial ya está en la lista de seriales
                let currentSerials = serialsField.val() ? serialsField.val().split(', ') : [];
    
                if (currentSerials.includes(newSerial)) {
                    Swal.fire('Advertencia', `El código de serie "${newSerial}" ya ha sido agregado.`, 'warning');
                    serialInput.val(''); // Limpiar el campo
                    return; // Salimos de la función para evitar duplicados
                }
    
                // Hacer una solicitud AJAX para validar el número de serie en el servidor
                $.ajax({
                    url: '../controller/get_availableSeries.php', // Ruta hacia el controlador PHP
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        serial_number: newSerial,
                        id_product: productId
                    }),
                    success: function(response) {
                        if (response.success) {
                            // Verificamos si ya se ha alcanzado la cantidad máxima
                            if (currentSerials.length < quantity) {
                                // Agregamos el nuevo serial al hidden field
                                currentSerials.push(newSerial);
                                serialsField.val(currentSerials.join(', '));
                                
                                // Actualizamos la lista visual de seriales
                                serialList.text(`Seriales seleccionados: ${serialsField.val()}`);
                                
                                // Limpiamos el input para que se pueda agregar otro serial
                                serialInput.val('');
                            } else {
                                Swal.fire('Advertencia', `Ya has ingresado la cantidad máxima de ${quantity} seriales.`, 'warning');
                            }
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Hubo un problema con la validación del número de serie.', 'error');
                    }
                });
            }
        }
    });          
    // Manejo del evento click en el botón para agregar el producto a la tabla
    $('#addProduct').on('click', function () {
        const productId = $('#id_product').val();
        const productName = $('#id_product option:selected').text().trim();
        const quantity = $('#quantity_input').val();
        const customerId = $('#id_customer').val();
    
        if (productId && quantity > 0 && customerId) {
            let productExists = false;
    
            $('#table_products tbody tr').each(function () {
                const existingProductId = $(this).find('input[name^="items"][name$="[id_product]"]').val();
                if (existingProductId === productId) {
                    productExists = true;
                    return false;
                }
            });
    
            if (productExists) {
                Swal.fire('Error', 'El producto ya ha sido agregado.', 'error');
            } else {
                table.row.add([                    
                    `<input type="hidden" name="items[${productCounter}][id_product]" value="${productId}">${productCounter + 1}`,
                    `<input type="hidden" name="items[${productCounter}][name_product]" value="${productName}">${productName}`,
                    `<input type="hidden" name="items[${productCounter}][quantity]" value="${quantity}">${quantity}`,                   
                    `<div>
                        <button type="button" class="btn btn-secondary" onclick="openSerialModal('${productId}', '${quantity}')">
                            <i class="fas fa-cogs"></i> Seleccionar Seriales
                        </button><br>                
                        <input type="text" id="serial_input_${productId}" class="form-control serial-input" 
                               placeholder="Ingresar serial" data-product-id="${productId}" data-quantity="${quantity}">
                        <br>
                        <span id="serial_list_${productId}">Seriales seleccionados: Ninguno</span>
                        <input type="hidden" id="serials_${productId}" name="items[${productCounter}][serials]" value="">
                    </div>`,                 
                    `<button type="button" class="delete-row"><i class="fas fa-trash-alt"></i></button>`
                ]).draw();                       
    
                productCounter++;
                $('#id_product').val('').trigger('change');
                $('#quantity_input').val('');
                $('#id_customer').prop('disabled', true);
    
                // Si no existe el campo hidden para el cliente, lo agrega
                if (!$('input[name="id_customer"]').length) {
                    $('<input>').attr({
                        type: 'hidden',
                        id: 'hidden_id_customer',
                        name: 'id_customer',
                        value: customerId,
                    }).appendTo('form');
                }
            }
        } else {
            Swal.fire('Error', 'Debe seleccionar un producto, un cliente y una cantidad válida.', 'error');
        }
    });
    
    // Manejar el clic en el botón de eliminar fila
    $('#table_products tbody').on('click', '.delete-row', function (e) {
        e.preventDefault();
        const row = table.row($(this).closest('tr'));
    
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Estás seguro de que deseas eliminar este producto?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                row.remove().draw();
    
                if (table.rows().count() === 0) {
                    $('#id_customer').prop('disabled', false);
                }
    
                Swal.fire('Eliminado', 'El producto ha sido eliminado.', 'success');
            }
        });
    });    

// Manejo del cambio en el select de productos (muestra stock y descripción)
$('#id_product').on('change', function () {
    const selectedProduct = $(this).find('option:selected');
    const description = selectedProduct.data('description');
    const stock = selectedProduct.data('stock');

    if (selectedProduct.val()) {
        // Si hay un producto seleccionado, mostrar la información
        $('#product_info').val(`${description} | Stock: ${stock}`);
        $('#quantity_input').attr('max', stock).val(''); // Limpiar y establecer el máximo permitido
    } else {
        // Si no hay producto seleccionado, limpiar el campo de información
        $('#product_info').val(''); // Dejar vacío
        $('#quantity_input').val('').removeAttr('max'); // Limpiar el campo de cantidad y el límite máximo
    }
});

    // Verificar la cantidad ingresada en relación al stock
    $('#quantity_input').on('input', function () {
        const quantity = parseInt($(this).val());
        const maxQuantity = parseInt($(this).attr('max'));

        if (quantity > maxQuantity) {
            Swal.fire({
                icon: 'error',
                title: 'Cantidad inválida',
                text: `La cantidad no puede ser mayor al stock disponible (${maxQuantity}).`,
            });
            $(this).val(maxQuantity); // Ajustar la cantidad al máximo disponible
        }
    });

 // Asociar las funciones a los botones dentro del modal
 document.getElementById('add_new_serial').addEventListener('click', addNewSerial);
 document.getElementById('save_serials').addEventListener('click', saveSerials);

 document.querySelector("#dispatchForm").addEventListener("submit", function (e) {
    e.preventDefault();

    Swal.fire({
        title: 'Confirmación',
        text: '¿Está seguro de que desea registrar el despacho?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, registrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData(this);
            formData.append('action', 'process_dispatch');

            fetch(this.action, {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Éxito',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Redirigir a la página de remito para generar el PDF
                        window.location.href = `../views/remito.php?sales_number=${data.sales_number}`;
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.error || 'Hubo un problema al procesar el despacho.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema con la conexión.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }
    });
});
});

// Función para agregar serial
function addSerial(productId) {
    const serialInput = $(`#serial_input_${productId}`);
    const serialValue = serialInput.val().trim();

    if (serialValue) {
        // Obtener los seriales actuales
        let currentSerials = $(`#serials_${productId}`).val();

        // Si ya hay seriales, agregamos el nuevo, de lo contrario inicializamos la lista
        if (currentSerials) {
            currentSerials += `,${serialValue}`;
        } else {
            currentSerials = serialValue;
        }

        // Actualizar el input hidden con la lista de seriales
        $(`#serials_${productId}`).val(currentSerials);

        // Actualizar el span que muestra los seriales
        $(`#serial_list_${productId}`).text(`Seriales: ${currentSerials}`);

        // Limpiar el campo de input de seriales para que pueda agregar otro
        serialInput.val('');
    } else {
        Swal.fire('Error', 'Debe ingresar un serial válido.', 'error');
    }
}
// Objeto global para almacenar los seriales seleccionados por producto
let selectedSerialsByProduct = {};
// Función para abrir el modal de números de serie
window.openSerialModal = function(productId, qty) {    
    
    // Almacenar el productId y cantidad en los inputs ocultos del modal
    document.getElementById('product_id_modal').value = productId;
    document.getElementById('product_qty_modal').value = qty;

    // Limpiar el contenedor de números de serie
    document.getElementById('serial_numbers_container').innerHTML = ''; // Limpiar el contenedor de seriales

    // Inicializar el array de seriales seleccionados para este producto si aún no existe
    if (!selectedSerialsByProduct[productId]) {
        selectedSerialsByProduct[productId] = [];
    }

    // Hacer una solicitud AJAX para obtener los números de serie disponibles
    fetch('../controller/controller_sales.php?action=get_serials', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            'product_id': productId
        })
    })
    .then(response => response.json())
    .then(data => {       
        // Crear una tabla para mostrar los números de serie y la fecha de compra
        let table = `<table class="table table-striped"><tbody>`;
        data.serials.forEach(serial => {
            // Verificar si el serial ya está seleccionado para este producto
            const checked = selectedSerialsByProduct[productId].includes(serial.serial_number) ? 'checked' : '';
            table += `<tr>
                        <td style="text-align: center;">
                            <input type="checkbox" class="serial-checkbox form-check-input" id="serial_${serial.serial_number}" value="${serial.serial_number}" onchange="toggleSerialSelection(this, '${productId}')" ${checked}>
                        </td>
                        <td>${serial.serial_number}</td>
                        <td>${new Date(serial.created_at).toLocaleDateString()}</td>
                    </tr>`;
        });
        table += `</tbody></table>`;
        document.getElementById('serial_numbers_container').innerHTML = table;

        // Mostrar el modal
        let modal = new bootstrap.Modal(document.getElementById('serialModal'));
        modal.show();

        // Actualizar el contador de seleccionados para este producto
        updateSelectedCount(productId);
    })
    .catch(error => {
        // Reemplazo de console.error() con Swal.fire para mostrar el error al usuario
        Swal.fire('Error', 'Hubo un problema al obtener los números de serie.', 'error');
    });
};
// Función para gestionar la selección de seriales por producto
function toggleSerialSelection(checkbox, productId) {
    const serialNumber = checkbox.value;

    if (checkbox.checked) {
        // Si el checkbox está seleccionado, agregar el serial a la lista del producto
        if (!selectedSerialsByProduct[productId].includes(serialNumber)) {
            selectedSerialsByProduct[productId].push(serialNumber);
        }
    } else {
        // Si se deselecciona, remover el serial de la lista del producto
        selectedSerialsByProduct[productId] = selectedSerialsByProduct[productId].filter(serial => serial !== serialNumber);
    }
    
    updateSelectedCount(productId); // Actualizamos el contador de seleccionados
}

// Función para actualizar el contador de seleccionados para un producto específico
function updateSelectedCount(productId) {
    const selectedCount = selectedSerialsByProduct[productId].length;
    const totalCount = document.getElementById('product_qty_modal').value;
    document.getElementById('selected_count').innerText = `Seleccionados: ${selectedCount} de ${totalCount}`;
}
// Función para agregar un nuevo número de serie
window.addNewSerial = function() {
    let newSerial = document.getElementById('new_serial_input').value.trim();
    let productId = document.getElementById('product_id_modal').value;

    // Obtener la fecha actual en formato "DD/MM/YYYY"
    let currentDate = new Date();
    let formattedDate = `${('0' + currentDate.getDate()).slice(-2)}/${('0' + (currentDate.getMonth() + 1)).slice(-2)}/${currentDate.getFullYear()}`;

    if (newSerial) {
        // Petición al servidor para agregar el serial
        fetch('../controller/controller_sales.php?action=add_serial', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'product_id': productId,
                'serial_number': newSerial
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Insertar el nuevo número de serie en la tabla (como una nueva fila)
                let serialTableBody = document.getElementById('serial_numbers_container');
                let newRow = `
                    <tr>
                        <td style="text-align: center;">
                            <input type="checkbox" id="serial_${newSerial}" value="${newSerial}" class="serial-checkbox form-check-input" onchange="toggleSerialSelection(this, '${productId}')" checked>
                        </td>
                        <td><label for="serial_${newSerial}">${newSerial}</label></td>
                        <td>${formattedDate}</td>
                    </tr>
                `;
                serialTableBody.innerHTML += newRow;

                // Agregar el nuevo serial a la lista de seleccionados del producto
                selectedSerialsByProduct[productId].push(newSerial);

                // Limpiar el campo de entrada del nuevo serial
                document.getElementById('new_serial_input').value = '';

                // Actualizar el contador de seriales seleccionados
                updateSelectedCount(productId);

                // *** NUEVA LÍNEA ***: Asegurarse de que todos los seriales seleccionados previamente se marquen como "checked" en el DOM
                applySelectedCheckboxes(productId);

            } else {
                // Mostrar el error al usuario
                Swal.fire('Error', data.error || 'No se pudo agregar el número de serie.', 'error');
            }
        })
        .catch(error => {
            // Mostrar el error al usuario
            Swal.fire('Error', 'Hubo un problema al agregar el nuevo número de serie.', 'error');
        });
    } else {
        Swal.fire('Error', 'El número de serie no puede estar vacío.', 'error');
    }
};
// Guardar seriales seleccionados al cerrar el modal
window.saveSerials = function() {
    let productId = document.getElementById('product_id_modal').value;
    let requiredQty = parseInt(document.getElementById('product_qty_modal').value);

    // Verificar que la cantidad de seriales seleccionados coincida con la cantidad requerida
    if (selectedSerialsByProduct[productId].length !== requiredQty) {
        Swal.fire({
            icon: 'error',
            title: 'Cantidad incorrecta',
            text: `Debes seleccionar ${requiredQty} números de serie.`,
        });
        return;
    }

    // Guardar los seriales seleccionados en el input oculto del formulario principal
    document.getElementById(`serials_${productId}`).value = selectedSerialsByProduct[productId].join(',');

    // Mostrar los seriales seleccionados en la tabla para referencia
    document.getElementById(`serial_list_${productId}`).innerText = `Seriales seleccionados: ${selectedSerialsByProduct[productId].join(', ')}`;

    // Cerrar el modal
    let modal = bootstrap.Modal.getInstance(document.getElementById('serialModal'));
    modal.hide();
};

// Función para aplicar el estado visual de los checkboxes seleccionados
function applySelectedCheckboxes(productId) {
    // Obtener todos los checkboxes de seriales
    const allCheckboxes = document.querySelectorAll('.serial-checkbox');
    
    // Recorrer todos los checkboxes y marcar aquellos que estén en la lista de seleccionados
    allCheckboxes.forEach(checkbox => {
        if (selectedSerialsByProduct[productId].includes(checkbox.value)) {
            checkbox.checked = true;  // Asegurarse de que esté marcado visualmente
        } else {
            checkbox.checked = false;  // Desmarcar si no está en la lista
        }
    });
}