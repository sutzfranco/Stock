document.getElementById('warranty-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevenir el envío tradicional del formulario

    let serialNumber = document.getElementById('serial_number').value;

    // Hacer la solicitud AJAX
    fetch('../controller/warranty_search.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `serial_number=${encodeURIComponent(serialNumber)}`
    })
    .then(response => response.json()) // Parsear la respuesta a JSON
    .then(data => {
        if (data.error) {
            // Mostrar mensaje de error si existe
            document.getElementById('result').innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
        } else {
            // Mostrar los datos de la garantía
            document.getElementById('result').innerHTML = `
                <div class="card mt-4">
                    <div class="card-header bg-primary text-white">
                        <h5>Información de la Garantía</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr><th>Producto:</th><td>${data.name_product}</td></tr>
                            <tr><th>Descripción:</th><td>${data.description}</td></tr>
                            <tr><th>Factura de Compra:</th><td>${data.remito_number}</td></tr>
                            <tr><th>Fecha de Compra:</th><td>${formatDateTime(data.created_at)}</td></tr>
                            <tr><th>Proveedor:</th><td>${data.name_supplier}</td></tr>
                            <tr><th>Factura de Venta:</th><td>${data.sales_number.toString().padStart(6, '0')}</td></tr>                            
                            <tr><th>Fecha de Venta:</th><td>${formatDateTime(data.dispatch_date)}</td></tr>
                            <tr><th>Cliente:</th><td>${data.customer_name}</td></tr>                                                        
                        </table>
                    </div>
                </div>`;
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
        document.getElementById('result').innerHTML = `<div class="alert alert-danger">Error en la solicitud.</div>`;
    });
});

function formatDateTime(dateString) {
    const date = new Date(dateString);
    
    // Formatear la fecha
    const day = String(date.getDate()).padStart(2, '0'); // Obtener el día
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Obtener el mes (sumar 1 porque empieza en 0)
    const year = date.getFullYear(); // Obtener el año

    // Formatear la hora
    const hours = String(date.getHours()).padStart(2, '0'); // Obtener las horas
    const minutes = String(date.getMinutes()).padStart(2, '0'); // Obtener los minutos
    const seconds = String(date.getSeconds()).padStart(2, '0'); // Obtener los segundos

    return `${day}/${month}/${year} Hora: ${hours}:${minutes}:${seconds}`; // Retornar la fecha en el formato deseado
}
