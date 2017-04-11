<?php
session_start();
if(!isset($_SESSION['vpcode'])){header('../../');}
require('fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('../img/eip_new_logo.png',10,8,45);
    // Arial bold 15
    $this->SetFont('Helvetica','B',16);
    // Move to the right
    $this->Cell(80);
    // Title
	$w = $this -> GetStringWidth('Report of Certificate of '.$_SESSION['vpcode'])+6;
    $this->SetX(60);
    $this->Cell($w,10,'Report of Certificate of '.$_SESSION['vpcode'],1,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
for($i=1;$i<=10;$i++)
    $pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output();
?>	
