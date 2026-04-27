<?php
require_once "../../assest/fpdf/fpdf.php";
require_once "../../controlador/salidaControlador.php";
require_once "../../modelo/salidaModelo.php";

$id = $_GET["id"];

$factura = ControladorSalida::ctrInfoFactura($id);
$producto = json_decode($factura["detalle_venta"], true);

class PDF extends FPDF
{

  // Pie de página
  function Footer()
  {
    global $factura;
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'',0,0,'C');
  }

}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

/****** encabezado *********/
$pdf->SetFont('Arial','B',15);
$pdf->Cell(190, 20, "LA MERCA", 0, 1, 'C');

//datos de la empresa
$pdf->SetFont('Arial','',10);
$pdf->Cell(80, 8, "NIT: 374956026", 0, 1);
$pdf->Cell(80, 8, "Nro. Factura: ".$factura["codigo_venta"], 0, 1);
$pdf->Cell(80, 8, utf8_decode("Teléfonos: 74333434 - 67555547 - 63885388"), 0, 1);
$pdf->Cell(80, 8, utf8_decode("Fecha emisión: ".$factura["create_at"]), 0, 1);
$pdf->Cell(80, 8, utf8_decode("Emitido por: ".$factura["nombre"]), 0, 1);
$pdf->Cell(100, 8, utf8_decode("Dirección: Av. Ayacucho S/N"), 0, 1);

//datos del cliente
$pdf->SetXY(120,30);
$pdf->Cell(80, 8, utf8_decode("Nombre: ".$factura["razon_social_cliente"]), 0, 2);
$pdf->Cell(80, 8, utf8_decode("NIT/CI: ".$factura["nit_ci_cliente"]), 0, 1);

//detalle
$pdf->SetFont('Arial','B',14);
$pdf->SetY(90);
$pdf->Cell(190, 15, "DETALLE", 0, 1, "C");

$pdf->SetFont('Arial','B',10);  
$pdf->SetFillColor(75, 98, 241);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(25, 10, "CODIGO", 1, 0, "C", true);
$pdf->Cell(90, 10, utf8_decode("DESCRIPCIÓN"), 1, 0, "C", true);
$pdf->Cell(25, 10, "CANTIDAD", 1, 0, "C", true);
$pdf->Cell(25, 10, "P. UNITARIO", 1, 0, "C", true);
$pdf->Cell(25, 10, "TOTAL", 1, 1, "C", true);

$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0, 0, 0);

$total=0;
foreach($producto as $value){
  $pdf->Cell(25, 8, $value["codigoProducto"], 1, 0, "C");
  $pdf->Cell(90, 8, utf8_decode($value["descripcion"]), 1, 0, "C");
  $pdf->Cell(25, 8, $value["cantidad"], 1, 0, "C");
  $pdf->Cell(25, 8, $value["precioUnitario"], 1, 0, "C");
  $pdf->Cell(25, 8, $value["subtotal"], 1, 1, "C");
  
  $total = $total + $value["subtotal"];
}


$pdf->Cell(165, 10, "TOTAL", 1, 0, "C");
$pdf->Cell(25, 10, $total, 1, 1, "C");


$pdf->Output();
?>




















