$(document).ready(function() {
    // Inicializar DataTable con el estilo y configuración deseada
    const table = $('#salesTable').DataTable({
        "language": {
            "paginate": {
                "first": "Primera",
                "last": "Última",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            "lengthMenu": "Mostrar _MENU_ entradas",
            "search": "Buscar:"
        },
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        lengthChange: false,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    $(document).ready(function() {
        var table = $('#salesTable').DataTable();

        $('#orderSelect').on('change', function() {
            var selectedValue = $(this).val();
            var columnIndex;

            switch (selectedValue) {
                case 'customer_name':
                    columnIndex = 0;
                    break;
                case 'sales_number':
                    columnIndex = 1;
                    break;
                case 'sale_date':
                    columnIndex = 2;
                    break;
                default:
                    columnIndex = 0;
            }

            table.order([columnIndex, 'asc']).draw();
        });
    });

    // Manejar el evento de click en el botón de detalles
    $('#salesTable').on('click', '.btn-info', function() {
        const id_sale = $(this).data('id-sale'); 
        loadHistoryDetails(id_sale); // Llamar a la función para cargar los detalles
    });

    // Manejar el evento de cierre del modal
    $('#productHistoryModal').on('hidden.bs.modal', function () {
        // Refresca la página cuando el modal se cierra
        location.reload();
    });
});

// Función para cargar los detalles de la venta
function loadHistoryDetails(sale_number) {
    $.ajax({
        url: '../controller/get_sales_history.php', 
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ sale_number: sale_number }), 
        dataType: 'json',
        success: function(data) {
            if (data && data.products && data.products.length > 0) {
                fillSaleDetailsModal(data);  
                
                // Crear y mostrar el modal con backdrop y teclado activado
                const saleModal = new bootstrap.Modal(document.getElementById("productHistoryModal"), {
                    backdrop: true,  // Permitir cierre al hacer click fuera
                    keyboard: true   // Permitir cierre con tecla escape
                });
                saleModal.show();  // Mostrar el modal
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'No se encontraron productos para esta venta.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', xhr.responseText || error);
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al obtener los detalles de la venta.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    });
}

// Función para llenar el modal con los detalles de la venta
function fillSaleDetailsModal(data) {
    const modalBody = document.querySelector("#HistoryDetailsContent");
    const modalHeader = document.querySelector("#productHistoryModalLabel");
    
    // Actualizar el título del modal con el sale_number
    modalHeader.textContent = `Detalles de Venta - Venta N° ${data.sale_number}`;

    modalBody.innerHTML = '';  // Limpiar el contenido previo

    const table = document.createElement('table');
    table.className = 'table table-bordered';

    const thead = document.createElement('thead');
    thead.innerHTML = `
        <tr>
            <th>Nombre Producto</th>
            <th>Cantidad</th>
        </tr>
    `;
    table.appendChild(thead);

    const tbody = document.createElement('tbody');

    // Rellenar la tabla con los datos de los productos
    data.products.forEach(product => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${product.name_product}</td>
            <td>${product.quantity}</td> 
        `;
        tbody.appendChild(row);
    });

    table.appendChild(tbody);
    modalBody.appendChild(table);  // Añadir la tabla al cuerpo del modal
}

// Función para validar los datos del remito y abrir el PDF
function validarYImprimir(sales_number) {
    // Realiza una llamada AJAX para verificar si hay datos del remito
    fetch(`../views/remito.php?sales_number=${sales_number}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud');
            }
            return response.text();
        })
        .then(data => {
            // Si la respuesta es un mensaje de error, muestra el alert y no continúa
            if (data.includes("Error: Faltan datos del remito o están vacíos.")) {
                Swal.fire({
                    title: 'Error',
                    text: 'Faltan datos del remito o están vacíos.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            } else {
                // Si hay datos, abre el PDF en una nueva pestaña
                window.open(`../views/remito.php?sales_number=${sales_number}`, '_blank');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al intentar verificar los datos.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        });
}