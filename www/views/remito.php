<?php
require('../assets/fpdf/fpdf.php');
include_once "../models/functions.php"; 

$sales_number = $_GET['sales_number'] ?? null;

if ($sales_number) {
    $remito_data = get_remito_data($sales_number);
} else {
    die("Número de venta no proporcionado");
}
// Crear clase PDF para remito
class PDF_Remito extends FPDF
{
    // Constructor para cambiar las unidades a milímetros
    function __construct()
    {
        parent::__construct('P', 'mm', 'A4'); // Usar mm como unidad y formato A4
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    // Función para imprimir los datos del remito
    function ImprimirRemito($remito_data) {
        // Verificación genérica de si $remito_data tiene contenido
        if (empty($remito_data) || 
            empty($remito_data['customer']) || 
            empty($remito_data['dispatches']) || 
            count($remito_data['dispatches']) === 0) {
            
            // En lugar de usar un alert, envía un error de vuelta al navegador para que la página no redirija
            echo "<script>alert('Error: Faltan datos del remito o están vacíos.');</script>";
            return false; // Detener ejecución
        }    
        
        // Si los datos están presentes, continuar con la generación del PDF
        $customer_data = $remito_data['customer'];
        $dispatches_data = $remito_data['dispatches'];

        // Datos generales del remito
        $this->SetFont('Arial', '', 12);

        // Establecer color de fondo gris
        $this->SetFillColor(244, 244, 244); // Gris claro

        // Número de remito (con fondo gris)
        $this->SetXY(124, 10.5); // Ajustar coordenadas
        $this->Cell(50, 8, utf8_decode($dispatches_data[0]['sales_number']), 0, 1, '', true); // Fondo gris habilitado

        // Fecha de remito (3mm hacia arriba y con fondo gris)
        $this->SetXY(135, 20); // Ajustar coordenadas
        $this->Cell(60, 5, utf8_decode($dispatches_data[0]['dispatch_date']), 0, 1, '', true); // Fondo gris habilitado

        // Información del cliente
        $this->SetXY(26, 52); // Cliente - Nombre (2mm hacia la derecha)
        $this->MultiCell(100, 10, utf8_decode($customer_data['customer_name']), 0, 'L');
        $this->Ln(2); // Espacio adicional

        $this->SetXY(124, 52); // Cliente - Teléfono (sin cambio)
        $this->Cell(50, 10, utf8_decode($customer_data['phone_customer']), 0, 1);

        $this->SetXY(24, 60); // Cliente - Domicilio (2mm hacia la derecha)
        $this->MultiCell(100, 10, utf8_decode($customer_data['customer_address']), 0, 'L');
        $this->Ln(2); // Espacio adicional

        $this->SetXY(126, 60); // Cliente - Localidad (sin cambio)
        $this->Cell(50, 10, utf8_decode($customer_data['location']), 0, 1);

        $this->SetXY(119, 68); // Cliente - CUIT (1mm hacia arriba)
        $this->Cell(50, 10, utf8_decode($customer_data['tax_identifier']), 0, 1);

        // Detalles de productos
        $y_position = 100;
        foreach ($dispatches_data as $detail) {
            $this->SetXY(20, $y_position); // Cantidad
            $this->Cell(30, 10, utf8_decode($detail['qty']), 0, 1);

            // Limpiar el nombre del producto si es necesario
            $product_name_clean = preg_replace('/\|? ?Stock:.*?(?=\(Seriales)/', '', $detail['product_name']);
            $this->SetXY(50, $y_position); // Nombre del producto
            $this->MultiCell(100, 10, utf8_decode($product_name_clean), 0, 'L'); // MultiCell para ajustar texto

            $y_position += 10; // Avanzar posición en Y
            $this->Ln(6); // Añadir espacio extra entre productos
            $y_position += 10; // Ajustar la posición para la siguiente línea
        }

        return true; // Indica que el proceso fue exitoso
    }   
}

// Instancia la clase y genera el remito solo si hay datos válidos
$pdf = new PDF_Remito();
$pdf->AddPage();

// Valida antes de generar el PDF
if ($pdf->ImprimirRemito($remito_data)) {
    $pdf->Output(); // Generar y mostrar el PDF solo si la validación es correcta
} else {
    // Si hubo un error, no generar el PDF y permanece en la página
    echo "<script>console.log('Remito no generado por datos inválidos.');</script>";
}