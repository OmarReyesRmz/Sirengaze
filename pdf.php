<?php
require('fpdf/fpdf.php');
session_start();

$pdf = new FPDF();
$pdf->AddPage();

// Logo
// $imagePath = 'imagenes/logo.png';
// $pdf->Image($imagePath, 60, 10, 90);

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'S I R E N G A Z E', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'SIRENGAZE MEXICO CONTRATO 1 A EN P', 0, 1);
$pdf->Cell(0, 10, 'SEM93JDM2K42', 0, 1);
$pdf->Cell(0, 10, 'Av. Universidad 940 Bosques del Prado Sur C.P 20100', 0, 1);
$pdf->Cell(0, 10, 'Tel. 5087-093', 0, 1);
date_default_timezone_set('America/Mexico_City');
$pdf->Cell(0, 10, 'Hora de generacion: ' . date("H:i:s"), 0, 1);
$pdf->Ln(10);

$pdf->Cell(0, 10, 'Detalles de la compra:', 0, 1);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);

$pdf->SetFillColor(173, 216, 230);
$pdf->SetTextColor(0, 0, 128);
$pdf->Cell(80, 10, "Producto", 1, 0, 'C', true);
$pdf->Cell(30, 10, "Precio", 1, 0, 'C', true);
$pdf->Cell(30, 10, "Cantidad", 1, 0, 'C', true);
$pdf->Cell(30, 10, "Subtotal", 1, 1, 'C', true);

$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 12);

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sirenegaze";
$tabla = "inventario";
$precio_final = 0;
$total = 0;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
    $carrito = $_SESSION['carrito'];

    foreach ($carrito as $productoId => $detallesProducto) {
        if ($detallesProducto['cantidad'] != 0) {
            $query = "SELECT * FROM inventario WHERE Id_producto = $productoId";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $pdf->Cell(80, 10, $row['nombre'], 1);
                if ($row['descuento'] != 0) {
                    $precio_final = ($row['precio'] - $row['precio'] * $row['descuento'] / 100);
                } else {
                    $precio_final = $row['precio'];
                }
                $pdf->Cell(30, 10, '$' . $precio_final, 1);
                $pdf->Cell(30, 10, $detallesProducto['cantidad'], 1);
                $pdf->Cell(30, 10, '$' . ($precio_final * $detallesProducto['cantidad']), 1);
                $total = $precio_final * $detallesProducto['cantidad'] + $total;
                $pdf->Ln();
            }
        }
    }

    $pdf->Cell(140, 10, 'Total', 1, 0, 'C');
    $pdf->Cell(30, 10, '$' . $total, 1);
    $pdf->Ln(10);

    $pdf->Cell(80, 10, 'Dirreccion de envio:', 0);
    $pdf->Cell(60, 10, $_SESSION["direccion"], 0);
    $pdf->Ln();

    $pdf->Cell(80, 10, 'Tipo de pago:', 0);
    $pdf->Cell(60, 10, $_SESSION["tarjeta"], 0);
    $pdf->Ln();

    $pdf->Cell(80, 10, 'Descuento:', 0);
    $pdf->Cell(60, 10, isset($_SESSION["descuento"]) ? $_SESSION["descuento"] : "0", 0);
    $pdf->Ln();

    $pdf->Cell(80, 10, 'Envio:', 0);
    $pdf->Cell(60, 10, $_SESSION["gastosEnvio"], 0);
    $pdf->Ln();

    $pdf->Cell(80, 10, 'IVA:', 0);
    $pdf->Cell(60, 10, $_SESSION["impuestos"], 0);
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(80, 10, 'TOTAL', 1, 0, 'C');
    $pdf->Cell(60, 10, '$' . $_SESSION["total"], 1, 1, 'C');
    $pdf->SetFont('Arial', '', 12);

    $pdf->Ln(10);

    $pdf->Cell(0, 10, '*** GRACIAS POR SU COMPRA ***', 0, 1, 'C');
    $pdf->Image('imagenes/Log.png', 80, $pdf->GetY(), 50);
    $pdf->Ln(40);
    
    $pdf->Cell(0, 10, 'WWW.SIRENGAZE.COM', 0, 1, 'C');
    $pdf->Ln();

    // Confirmar pago
    // $pdf->Cell(0, 10, 'Para confirmar su pago, haga clic en el siguiente enlace:', 0, 1);
    // $pdf->Ln();
    // $pdf->SetFont('Arial', 'U', 12);
    // $pdf->Cell(0, 10, 'Confirmar Pago', 0, 1, 'C', false, 'http://tu-sitio.com/venta.php');
    // $pdf->SetFont('Arial', '', 12);
    // $pdf->Ln(10);

    // Mostrar el PDF en el navegador
    $pdf->Output();
    exit();
} else {
    // Redirigir a la página de carrito si no hay datos de compra
    header('Location: carrito.php');
    exit();
}
?>
