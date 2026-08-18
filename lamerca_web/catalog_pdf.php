<?php

declare(strict_types=1);

require_once __DIR__ . '/app/Database.php';

// Load local FPDF library from assets
$fpdfPath = __DIR__ . '/assets/fpdf/fpdf.php';
if (file_exists($fpdfPath)) {
    require_once $fpdfPath;
} elseif (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

if (!class_exists('FPDF')) {
    header('HTTP/1.1 500 Internal Server Error');
    echo 'FPDF library not found. Coloca assets/fpdf/fpdf.php o instala con Composer.';
    exit;
}

$category = isset($_GET['category']) ? trim((string) $_GET['category']) : '';

$db = Database::getInstance();
$sql = 'SELECT id_producto AS id,
               cod_producto AS codigo,
               nombre_producto AS name,
               categoria AS category,
               precio AS price,
               descripcion_prod AS description,
               imagen_producto AS image
        FROM producto
        WHERE disponible = 1';
if ($category !== '') {
    $sql .= ' AND categoria = :category';
}
$sql .= ' ORDER BY id_producto ASC';

$stmt = $db->prepare($sql);
if ($category !== '') {
    $stmt->bindValue(':category', $category, PDO::PARAM_STR);
}
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$displayCategory = $category !== '' ? $category : 'Todas las categorías';

class PDF extends FPDF
{
    public function Header()
    {
        $logoPath = __DIR__ . '/assets/dist/img/fondo.jpg';
        if (file_exists($logoPath)) {
            try {
                $this->Image($logoPath, 0, 0, 210,40);
            } catch (Throwable $e) {
                // ignore logo load error
            }
        }

        $this->SetFont('Arial', 'B', 15);
        $this->SetTextColor(255, 255, 255, 255);
        $this->SetXY(0, 28);
        $this->Cell(0, 10, utf8_decode('Catálogo de productos'), 0, 0, 'C');

        $this->SetFont('Arial', '', 10);
        $this->SetXY(0, 35);
        $displayCategory = isset($GLOBALS['displayCategory']) ? $GLOBALS['displayCategory'] : 'Todas las categorías';
        $this->Cell(0, 6, utf8_decode($displayCategory), 0, 0, 'C');

        $this->Ln(20);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

$rowHeight = 80;
$itemsPerRow = 2;
$rowsPerPage = 3;
$itemsPerPage = $itemsPerRow * $rowsPerPage;
$yStart = 42;

$baseImageDir = __DIR__ . '/assets/dist/img/producto/';
$defaultImage = __DIR__ . '/assets/dist/img/product_default.png';

$i = 0;
foreach ($products as $product) {
    $currentItem = $i % $itemsPerPage;
    $currentRow = (int) floor($currentItem / $itemsPerRow);
    $currentColumn = $currentItem % $itemsPerRow;

    if ($currentItem === 0 && $i > 0) {
        $pdf->AddPage();
    }

    $x = 10 + ($currentColumn * 100);
    $y = $yStart + ($currentRow * $rowHeight);

    $imageName = trim((string) ($product['image'] ?? ''));
    $imagePath = '';
    if ($imageName !== '') {
        $localPath = $baseImageDir . $imageName;
        if (file_exists($localPath)) {
            $imagePath = $localPath;
        } else {
            $imagePath = 'https://lamercabolivia.com/assest/dist/img/producto/' . rawurlencode($imageName);
        }
    }

    if ($imagePath === '' && file_exists($defaultImage)) {
        $imagePath = $defaultImage;
    }

    $imgX = $x + 25;
    $imgY = $y;

    if ($imagePath !== '') {
        try {
            $pdf->Image($imagePath, $imgX, $imgY, 35, 35);
        } catch (Throwable $e) {
            // ignore if image cannot be loaded
        }
    }


    $pdf->SetFillColor(255, 250, 240);
    $pdf->SetXY($x, $y + 40);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->MultiCell(90, 5, utf8_decode((string) $product['name']), 0, 'C', true);

    $pdf->SetFont('Arial', '', 9);
    $pdf->SetX($x);
    $pdf->MultiCell(90, 5, utf8_decode($product['description']), 0, 'C', true);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(0, 102, 153);
    $pdf->SetX($x);
    $priceText = isset($product['price']) ? number_format((float) $product['price'], 2) . ' Bs.' : '-';
    $pdf->Cell(90, 6, utf8_decode($priceText), 0, 1, 'C', true);

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetX($x);
    $pdf->Cell(45, 6, utf8_decode('Código:'), 0, 0, 'R', true);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(45, 6, utf8_decode((string) ($product['codigo'] ?? '')), 0, 1, 'L', true);

    $i++;
}

$pdf->Output('I', 'catalogo_' . ($category !== '' ? preg_replace('/[^A-Za-z0-9_]/', '_', $category) : 'todas') . '.pdf');
exit;
