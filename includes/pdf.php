<?php


require('../fpdf/fpdf.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {

        //$this->image('', 150, 1, 40); // X, Y, Tamaño
        $this->Ln(20);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 16);

        // Movernos a la derecha
        $this->Cell(100);
        // Título
        $this->setY(10);
        $this->setX(110);

        $this->Cell(70, 10, utf8_decode('REPORTE DE INVENTARIO'), 0, 1, 'C');



        $this->SetFont('Arial', 'B', 17);
        $this->setY(40);
        $this->SetX(100);




        // Salto de línea
        $this->SetFont('Arial', 'B', 10);
        $this->Ln();
        $this->SetX(20);


        $this->Ln();
        $this->SetFont('Arial', 'B', 10);
        $this->SetY(45);
        $this->SetX(17);

        $this->Cell(22, 10, 'Codigo', 1, 0, 'C', 0);
        $this->Cell(50, 10, 'Productos', 1, 0, 'C', 0,);
        $this->Cell(20, 10, 'Cant.', 1, 0, 'C', 0);
        $this->Cell(22, 10, 'Cant Min.', 1, 0, 'C', 0);
        $this->Cell(28, 10, 'Precio Compra', 1, 0, 'C', 0);
        $this->Cell(22, 10, 'UND', 1, 0, 'C', 0);
        $this->Cell(28, 10, 'Categoria', 1, 0, 'C', 0);
        $this->Cell(34, 10, 'Fecha', 1, 1, 'C', 0);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);

        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página



        //$this->SetFillColor(223, 229,235);
        //$this->SetDrawColor(181, 14,246);
        //$this->Ln(0.5);
    }
}

include "db.php";
$consulta = "SELECT * FROM recursos";
$resultado = mysqli_query($conexion, $consulta);

$pdf = new PDF();
$pdf = new PDF('L', 'mm', 'letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 0);

//$pdf->SetWidths(array(10, 30, 27, 27, 20, 20, 20, 20, 22));
while ($row = $resultado->fetch_assoc()) {

    $pdf->SetX(17);

    $pdf->Cell(22, 10, utf8_decode($row['codigo']), 1, 0, 'C', 0);
    $pdf->Cell(50, 10, utf8_decode($row['producto']), 1, 0, 'L', 0);
    $pdf->Cell(20, 10, utf8_decode($row['existencia']), 1, 0, 'C', 0);
    $pdf->Cell(22, 10, utf8_decode($row['minimo']), 1, 0, 'C', 0);
    $pdf->Cell(28, 10, utf8_decode($row['compra']), 1, 0, 'C', 0);
    $pdf->Cell(22, 10, utf8_decode($row['unidad']), 1, 0, 'C', 0);
    $pdf->Cell(28, 10, utf8_decode($row['id_categoria']), 1, 0, 'C', 0);
    $pdf->Cell(34, 10, utf8_decode($row['fecha']), 1, 1, 'C', 0);
}


$pdf->Output();
