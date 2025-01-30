$(document).ready(function() {
    // Destruir la tabla si ya fue inicializada previamente para evitar errores de reinicialización
    if ($.fn.DataTable.isDataTable('#purchaseTable')) {
        $('#purchaseTable').DataTable().destroy();
    }

    // Inicializar DataTable con paginación, búsqueda, botones y opciones de exportación
    const table = $('#purchaseTable').DataTable({
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
            'excel', 'pdf', 'imprimir'
        ],
        // Inicializar con orden por la columna 1 (Número de Remito)
        "order": [[1, "asc"]]
    });

    // Manejar el cambio en el select para cambiar el orden
    $('#orderSelect').on('change', function() {
        const selectedValue = $(this).val();  // Obtener el valor seleccionado

        // Cambiar el orden según la selección
        switch (selectedValue) {
            case '1':
                table.order([1, 'asc']).draw();  
                break;
            case '2':
                table.order([2, 'asc']).draw();  
                break;
            case '3':
                table.order([3, 'asc']).draw();  
                break;
            case '4':
                table.order([0, 'asc']).draw(); 
                break;
        }
    });

    $('#searchBox').on('keyup', function() {
        const searchTerm = $(this).val();
        const filterValue = $('#filterOptions').val(); 

        table.search('').columns().search('').draw();

        switch (filterValue) {
            case 'supplier':
                table.column(0).search(searchTerm).draw();  
                break;
            case 'remito_number':
                table.column(1).search(searchTerm).draw();
                break;
            case 'remito_date':
                table.column(2).search(searchTerm).draw();  
                break;
            case 'invoice_number':
                table.column(3).search(searchTerm).draw();  
                break;
            case 'product':
                table.column(4).search(searchTerm).draw();  
                break;
            case 'quantity':
                table.column(5).search(searchTerm).draw();  
                break;
            default:
                table.search(searchTerm).draw();
                break;
        }
    });

    // Asignar evento al botón de detalles dentro de la tabla
    $('#purchaseTable').on('click', '.btn-info', function() {
        const remito_number = $(this).data('remito_number'); 
        loadHistoryDetails(remito_number);  // Llamar a la función para cargar los detalles
    });

    // Detectar cuando se cierra el modal
    $('#productHistoryModal').on('hidden.bs.modal', function() {
        location.reload(); 
    });
});

// Función para cargar los detalles de la compra
function loadHistoryDetails(remito_number) {
    $.ajax({
        url: '../controller/get_purchase_history.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ remito_number: remito_number }),
        dataType: 'json',
        success: function(data) {
            if (data && data.products && data.products.length > 0) {
                fillPurchaseDetailsModal(data);  // Llenar el modal con los datos de productos
                const purchaseModal = new bootstrap.Modal(document.getElementById("productHistoryModal"), {
                    backdrop: true,
                    keyboard: true
                });
                purchaseModal.show();
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'No se encontraron productos para este remito.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        }
    });
}

// Función para llenar el modal con los detalles de la compra
function fillPurchaseDetailsModal(data) {
    const modalBody = document.querySelector("#HistoryDetailsContent");
    const modalHeader = document.querySelector("#productHistoryModalLabel");

    // Actualizar el título del modal con el remito_number y remito_date
    modalHeader.textContent = `Detalles de Compra - Remito N° ${data.remito_number} (${data.remito_date})`;

    modalBody.innerHTML = '';  // Limpiar el contenido previo

    const table = document.createElement('table');
    table.className = 'table table-bordered';

    // Crear la cabecera de la tabla
    const thead = document.createElement('thead');
    thead.innerHTML = `
        <tr>
            <th>Nombre Producto</th>
            <th>Cantidad</th>
        `;
    table.appendChild(thead);

    const tbody = document.createElement('tbody');

    // Rellenar la tabla con los datos de los productos
    data.products.forEach(product => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${product.name_product}</td>
            <td>${product.qty}</td>
        `;
        tbody.appendChild(row);
    });

    table.appendChild(tbody);
    modalBody.appendChild(table);  // Añadir la tabla al cuerpo del modal
}
