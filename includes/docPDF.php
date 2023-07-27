<?php


include "fecha.php";
require('../fpdf/fpdf.php');

class PDF extends FPDF
{

    // Cabecera de página
    function Header()
    {

        $this->image('../img/costa.jpg', 175, 10, 25); // X, Y, Tamaño
        $this->image('../img/educacion.jpeg', 5, 1, 80); // X, Y, Tamaño
        $this->image('../img/tec.png', 90, 15, 40); // X, Y, Tamaño
        $this->Ln(20);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 16);

        // Movernos a la derecha
        $this->Cell(100);
        // Título
        $this->setY(10);
        $this->setX(45);

        $this->SetFont('Arial', 'B', 10);
        $this->SetY(57);
        $this->SetX(13);
        $this->Cell(60, 4, 'LUIS ALEBERTO SANCHEZ MARTINEZ', 0, 1, 'L');

        $this->SetFont('Arial', 'B', 10);
        $this->setY(64);
        $this->setX(13);
        $this->Cell(60, 4, 'SUBDIRECTOR DE SERVICIOS ADMINISTRATIVOS', 0, 1, 'L');

        $this->SetFont('Arial', 'B', 10);
        $this->setY(72);
        $this->setX(13);
        $this->Cell(60, 4, 'P R E S E N T E', 0, 1, 'L');

        $this->SetFont('Arial', '', 10);
        $this->setY(83);
        $this->setX(13);
        $this->Cell(60, 4, 'COMPONENTE:', 0, 1, 'L');

        $this->SetFont('Helvetica', 'B', 7);
        $this->Ln(20);
        $this->setY(86);
        $this->setX(40);
        $this->Cell(150, 0, '', 'T'); // DIVISION

        $this->SetFont('Arial', '', 10);
        $this->setY(91);
        $this->setX(13);
        $this->Cell(60, 4, 'ACTIVIDAD:', 0, 1, 'L');

        $this->SetFont('Helvetica', 'B', 7);
        $this->Ln(20);
        $this->setY(94);
        $this->setX(35);
        $this->Cell(155, 0, '', 'T'); // DIVISION

        $this->SetFont('Arial', '', 10);
        $this->setY(99);
        $this->setX(13);
        $this->Cell(60, 4, 'PARTIDAS:', 0, 1, 'L');

        $this->SetFont('Helvetica', 'B', 7);
        $this->Ln(20);
        $this->setY(102);
        $this->setX(33);
        $this->Cell(157, 0, '', 'T'); // DIVISION

        // datos derecheos
        $this->SetFont('Arial', '', 10);
        $this->SetY(40);
        $this->SetX(150);
        $this->Cell(60, 4, 'Ometepec, Guerrero, ' . utf8_decode(fecha()), 0, 1, 'R');

        $this->SetFont('Arial', '', 10);
        $this->setY(45);
        $this->setX(146);
        $this->Cell(60, 4, 'OFICIO NO: ITSCCH/XXXX/XXX/2023', 0, 1, 'R');

        $this->SetFont('Arial', '', 10);
        $this->setY(50);
        $this->setX(148);
        $this->Cell(60, 4, 'ASUNTO: El que se indica.', 0, 1, 'R');

        // Salto de línea
        $this->SetFont('Arial', 'B', 10);
        $this->Ln();
        $this->SetX(20);



        $this->SetFont('Arial', 'B', 10);

        $this->SetY(110);
        $this->SetX(20);


        $this->Cell(145, 10, 'DESCRIPCION', 1, 0, 'C', 0);
        $this->Cell(30, 10, 'CANTIDAD', 1, 1, 'C', 0);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);

        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        extract($_GET);
        include("db.php");
        $consulta = "SELECT s.total, s.fecha, s.id, GROUP_CONCAT( r.producto ,  ' ') AS productos FROM salidas s 
INNER JOIN output_product op ON op.id_salida = s.id INNER JOIN recursos r ON r.id = op.id_producto WHERE s.id = $id";
        $resultado = mysqli_query($conexion, $consulta);

        while ($fila = mysqli_fetch_array($resultado)) {

            $this->SetFont('Helvetica', '', 12);
            $this->Ln(20);
            $this->setY(135);
            $this->setX(165);
            $this->Cell(60, 0, utf8_decode('TOTAL: $'  . utf8_decode($fila['total'])), 0, 1, 'L');
            // Número de página
        }
        $this->SetFont('Helvetica', '', 9);
        $this->Ln(20);
        $this->setY(140);
        $this->setX(17);
        $this->Cell(60, 0, utf8_decode('Sin otro particular reciba un cordial saludo.'), 0, 1, 'L');

        $this->SetFont('Helvetica', 'B', 12);
        $this->Ln(20);
        $this->setY(150);
        $this->setX(70);
        $this->Cell(60, 0, utf8_decode('A T E N T A M E N T E'), 0, 1, 'C');

        $this->SetFont('Helvetica', '', 8);
        $this->Ln(20);
        $this->setY(155);
        $this->setX(73);
        $this->Cell(60, 0, utf8_decode('"Tecnologia para el Progreso de Nuestra Patria"'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 12);
        $this->Ln(20);
        $this->setY(162);
        $this->setX(73);
        $this->Cell(60, 0, utf8_decode('RESPONSABLES DEL EJERCICIO Y COMPROBACION DE LOS RECURSOS'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(172);
        $this->setX(25);
        $this->Cell(60, 0, utf8_decode('SOLICITA'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(172);
        $this->setX(132);
        $this->Cell(60, 0, utf8_decode('APRUEBA'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(200);
        $this->setX(25);
        $this->Cell(60, 0, utf8_decode('NOMBRE DEL JEFE QUE LO SOLICITA'), 0, 1, 'C');


        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(205);
        $this->setX(25);
        $this->Cell(60, 0, utf8_decode('DIV,DEPTO, OFICINA, ETC.'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(200);
        $this->setX(130);
        $this->Cell(60, 0, utf8_decode('NOMBRE COMPLETO DEL JEFE INMEDIATO'), 0, 1, 'C');


        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(205);
        $this->setX(130);
        $this->Cell(60, 0, utf8_decode('JEFE DE DIV, SUBD, ETC.'), 0, 1, 'C');


        $this->SetFont('Helvetica', 'B', 12);

        $this->Ln(20);
        $this->SetY(215);
        $this->SetX(78);
        $this->Cell(60, 0, utf8_decode('VERIFICACION DE PROGRAMACION, PRESUPUESTACION Y AUTORIZACION '), 0, 1, 'C');



        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(220);
        $this->setX(25);
        $this->Cell(60, 0, utf8_decode('Vo.Bo.'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(220);
        $this->setX(130);
        $this->Cell(60, 0, utf8_decode('AUTORIZA'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(240);
        $this->setX(25);
        $this->Cell(60, 0, utf8_decode('LILIANA GUADALUPE ARELLADO SALGADO'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(245);
        $this->setX(25);
        $this->Cell(60, 0, utf8_decode('JEFA DEL DPTO DE PLANACION PROGR.'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(250);
        $this->setX(25);
        $this->Cell(60, 0, utf8_decode('PRESUP Y CONSTRUCCION'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(240);
        $this->setX(130);
        $this->Cell(60, 0, utf8_decode('FERNANDO GARCIA HERRERA'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(245);
        $this->setX(130);
        $this->Cell(60, 0, utf8_decode('DIRECTOR GENERAL'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(250);
        $this->setX(130);
        $this->Cell(60, 0, utf8_decode('ITS DE LA COSTA CHICA'), 0, 1, 'C');

        //$this->SetFillColor(223, 229,235);
        //$this->SetDrawColor(181, 14,246);
        //$this->Ln(0.5);
    }
}



$pdf = new PDF('P', 'mm', 'letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

extract($_GET);
require_once("db.php");
$consulta = "SELECT s.total, s.fecha, s.id, GROUP_CONCAT( r.producto ,  ' ') AS productos FROM salidas s 
INNER JOIN output_product op ON op.id_salida = s.id INNER JOIN recursos r ON r.id = op.id_producto WHERE s.id = $id";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
    while ($row = $resultado->fetch_assoc()) {
        $pdf->SetX(20);
        $pdf->Cell(145, 10, utf8_decode($row['productos']), 1, 0, 'L', 0); // Usamos 'productos' en lugar de 'producto'
        $pdf->Cell(30, 10, utf8_decode('$' . $row['total']), 1, 1, 'C', 0);
    }
} else {
    echo "Error en la consulta SQL: " . mysqli_error($conexion);
}

$pdf->Output();
