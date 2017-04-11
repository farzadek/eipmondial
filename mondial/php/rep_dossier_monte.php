<?php
session_start();
if(!isset($_SESSION['vpcode']) || !isset($_SESSION['pr2'])){header('../../');}
require('fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    $this->Image('../img/eip_new_logo.png',140,15,45);
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
    $this->Cell(0,10,'www.eipMondial.com',0,0,'L');
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$data = explode("|",$_SESSION['pr2']);

    $pdf->SetFont('Helvetica','B',32);
    $pdf->SetXY(25,22); $pdf->Cell(0,0,'Dossier Mont'.chr(233),0,0,'L');
    $pdf->SetFont('Helvetica','B',16);
    $pdf->SetXY(26,35); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', $data[2]).' '.iconv('UTF-8', 'windows-1252', $data[1]).' ('.$data[0].')',0,0,'L');
    $pdf->Line(20, 43, 190, 43);
    $pdf->SetFont('Helvetica','B',14);
    $pdf->SetXY(20,50); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', 'Score de crédit: '),0,0,'L');
    $pdf->SetX(80); $pdf->Cell(25,0,$data[3],0,0,'R');
    $pdf->SetXY(20,60); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', 'Montant de prêt alloué: '),0,0,'L');
    $pdf->SetX(80); $pdf->Cell(25,0,iconv('UTF-8', 'windows-1252', $data[4]),0,0,'R');
    $pdf->SetXY(20,80); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', 'Montant réel des dettes: '),0,0,'L');
    $pdf->SetX(80); $pdf->Cell(25,0,iconv('UTF-8', 'windows-1252', $data[5]),0,0,'R');
    $pdf->SetXY(20,90); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', 'Paiement par mois réel'),0,0,'L');
    $pdf->SetX(80); $pdf->Cell(25,0,iconv('UTF-8', 'windows-1252', $data[6]),0,0,'R');
    $pdf->SetXY(20,110); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', 'Date de prélèvement: '),0,0,'L');
    $pdf->SetX(100); $pdf->Cell(25,0,'Le '.iconv('UTF-8', 'windows-1252', $data[7]).' de chaque mois',0,0,'R');
    $pdf->SetXY(40,120); $pdf->Cell(0,0,'Bank: ',0,0,'L');
    $pdf->SetX(100); $pdf->Cell(25,0,iconv('UTF-8', 'windows-1252', $data[8]),0,0,'R');
    $pdf->SetXY(40,130); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', 'Numéro de compte: '),0,0,'L');
    $pdf->SetX(100); $pdf->Cell(25,0,iconv('UTF-8', 'windows-1252', $data[9]),0,0,'R');
    $pdf->SetXY(40,140); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', 'Date de début'),0,0,'L');
    $pdf->SetX(100); $pdf->Cell(25,0,iconv('UTF-8', 'windows-1252', $data[10]),0,0,'R');
    $pdf->SetXY(40,150); $pdf->Cell(0,0,'Date de fin: ',0,0,'L');
    $pdf->SetX(100); $pdf->Cell(25,0,iconv('UTF-8', 'windows-1252', $data[11]),0,0,'R');
    $pdf->SetXY(40,160); $pdf->Cell(0,0,'Nombre de mois total: ',0,0,'L');
    $pdf->SetX(100); $pdf->Cell(25,0,iconv('UTF-8', 'windows-1252', $data[12]).' mois',0,0,'R');
    $pdf->Line(10, 10, 200, 10);
    $pdf->Line(11, 11, 199, 11);
    $pdf->Line(10, 10, 10, 281);
    $pdf->Line(11, 11, 11, 280);
    $pdf->Line(10, 281, 200, 281);
    $pdf->Line(11, 280, 199, 280);
    $pdf->Line(199, 11, 199, 280);
    $pdf->Line(200, 10, 200, 281);

$pdf->Output();
?>	
