<?php
require_once "../../assest/fpdf/fpdf.php";
require_once "../../controlador/productoControlador.php";
require_once "../../modelo/productoModelo.php";

$categoria = isset($_GET['categoriaProducto']) ? $_GET['categoriaProducto'] : '';
// Consulta de productos (ajusta según tu modelo)
$productos = ControladorProducto::ctrProductosPorCategoria($categoria);

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Imagen de fondo para el encabezado (opcional)
        $bgPath = '../../assest/dist/img/encabezado.jpg';
        if (file_exists($bgPath)) {
            // Colocar la imagen a lo ancho del papel (A4 width ~210) con altura 30
            $this->Image($bgPath, 0, 0, 210, 30);
        }

        // Logo
        $this->Image('../../assest/dist/img/logo.jpg', 10, 8, 20);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30, 10, 'Catalogo de productos', 0, 0, 'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);

// Ahora 1 producto por fila y 3 por página
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

$rowHeight = 80; // altura por fila
$itemsPerRow = 2;
$rowsPerPage = 3;
$itemsPerPage = $itemsPerRow * $rowsPerPage; // 6 productos por página

$i = 0;
$yStart = 35;

foreach ($productos as $producto) {
    $currentItem = $i % $itemsPerPage;
    $currentRow = floor($currentItem / $itemsPerRow);
    $currentColumn = $currentItem % $itemsPerRow;

    $x = 10 + ($currentColumn * 100); // separación horizontal entre columnas
    $y = $yStart + ($currentRow * $rowHeight);

    // ********** Imagen ***********
    // Configuración
    $basePath = '../../assest/dist/img/producto/';
    $defaultImage = $basePath . 'product_default.png';
  
    //poscicion
    $imgX = $x + 25;
    $imgY = $y;
  
  // Obtener nombre de imagen desde BD
    $nombreImagen = trim($producto['imagen_producto'] ?? '');
  // Ruta final de imagen
    $rutaImagen = $basePath . $nombreImagen;
  
    // Validación final
if (!empty($nombreImagen) && file_exists($rutaImagen)) {
    
    // Caso ideal: existe en BD y en disco
    $pdf->Image($rutaImagen, $imgX, $imgY, 35, 35);

} elseif (file_exists($defaultImage)) {
    
    // Caso fallback: usar imagen por defecto
    $pdf->Image($defaultImage, $imgX, $imgY, 35, 35);

} else {
    
    // Caso extremo: no hay nada
    $pdf->Rect($imgX, $imgY, 35, 35);
    $pdf->SetXY($imgX, $imgY + 15);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(35, 5, 'Sin imagen', 0, 0, 'C');
}

    // Datos del producto
    $pdf->SetXY($x, $y + 40);
    $pdf->SetFillColor(255, 250, 240);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(90, 6, utf8_decode($producto['nombre_producto'] ?? ''), 0, 1, 'C', true);

    $pdf->SetFont('Arial', '', 10);
    $pdf->SetX($x);
    $pdf->MultiCell(90, 6, utf8_decode($producto['descripcion_prod'] ?? ''), 0, 'C', true);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(0, 102, 153);
    $pdf->SetX($x);
    $pdf->Cell(90, 6, isset($producto['precio']) ? number_format($producto['precio'], 2) . ' Bs.' : '-', 0, 1, 'C', true);

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetX($x);
    $pdf->Cell(45, 6, utf8_decode('Código:'), 0, 0, 'R', true);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(45, 6, $producto['cod_producto'] ?? '', 0, 1, 'L', true);

    $i++;
    if ($i % $itemsPerPage == 0 && $i < count($productos)) {
        $pdf->AddPage();
    }
}

$pdf->Output();
