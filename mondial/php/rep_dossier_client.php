<?php
session_start();
if(!isset($_SESSION['vpcode']) || !isset($_SESSION['pr1'])){header('../../');}
require('fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    //$this->Image('../img/eip_new_logo.png',10,8,45);
    // Arial bold 15
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
$data = explode("|",$_SESSION['pr1']);

    $pdf->SetFont('Helvetica','B',50);
    $pdf->SetXY(25,22); $pdf->Cell(0,0,'Dossier Client',0,0,'L');
    $pdf->SetFont('Helvetica','',11);
    $pdf->SetXY(155,20); $pdf->Cell(0,0,"Date d'ouverture:",0,0,'L');
    $pdf->SetXY(155,25); $pdf->Cell(0,0,$data[0],0,0,'L');
    $pdf->SetXY(142,35); $pdf->Cell(0,0,'NUMERO VP: '.$data[1],0,0,'L');
    $pdf->SetXY(20,45); $pdf->Cell(0,0,'NOM: ',0,0,'L');
    $pdf->SetXY(60,45); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', $data[2]),0,0,'L');
    $pdf->SetXY(20,55); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', 'Prénom'),0,0,'L');
    $pdf->SetXY(60,55); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', $data[3]),0,0,'L');
    $pdf->SetXY(20,65); $pdf->Cell(0,0,'Adresse: ',0,0,'L');
    $pdf->SetXY(60,65); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', $data[4]),0,0,'L');
    $pdf->SetXY(60,70); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', $data[5]),0,0,'L');
    $pdf->SetXY(60,75); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', $data[6]),0,0,'L');
    $pdf->SetXY(20,95); $pdf->Cell(0,0,'Date de naissance: ',0,0,'L');
    $pdf->SetXY(20,105); $pdf->Cell(0,0,'Email: ',0,0,'L');
    $pdf->SetFont('Helvetica','',10);
    $pdf->SetXY(60,105); $pdf->Cell(0,0,$data[7],0,0,'L');
    $pdf->SetFont('Helvetica','',11);
    $pdf->SetXY(20,125); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', 'Montant de prêt: '),0,0,'L');
    $pdf->SetX(100); $pdf->Cell(25,0,$data[8],0,0,'R');
    $pdf->SetXY(20,135); $pdf->Cell(0,0,'Montant des dettes: ',0,0,'L');
    $pdf->SetX(100); $pdf->Cell(25,0,$data[9],0,0,'R');
    $pdf->SetXY(20,145); $pdf->Cell(0,0,'Montant de Paiement possible: ',0,0,'L');
    $pdf->SetX(100); $pdf->Cell(25,0,$data[10],0,0,'R');
    $pdf->SetXY(20,160); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', 'Carte de crétit: '),0,0,'L');
    $pdf->SetX(80); $pdf->Cell(0,0,'Oui: ',0,0,'L');
    $pdf->SetXY(90,157); $pdf->Cell(6,6,$data[11],1,0,'C');
    $pdf->SetXY(110,160); $pdf->Cell(0,0,'No: ',0,0,'L');
    $pdf->SetXY(120,157); $pdf->Cell(6,6,$data[12],1,0,'C');
    $pdf->SetXY(20,170); $pdf->Cell(0,0,'Lesquelles: ',0,0,'L');
    $pdf->SetXY(100,170); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', $data[13]),0,0,'L');
    $pdf->SetX(150); $pdf->Cell(25,0,$data[14],0,0,'R');
    $pdf->SetXY(100,175); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', $data[15]),0,0,'L');
    $pdf->SetX(150); $pdf->Cell(25,0,$data[16],0,0,'R');
    $pdf->SetXY(100,180); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', $data[17]),0,0,'L');
    $pdf->SetX(150); $pdf->Cell(25,0,$data[18],0,0,'R');
    $pdf->SetXY(100,185); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', $data[19]),0,0,'L');
    $pdf->SetX(150); $pdf->Cell(25,0,$data[20],0,0,'R');
    $pdf->SetXY(20,200); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', 'Equifax présent: '),0,0,'L');
    $pdf->SetX(80); $pdf->Cell(0,0,'Oui: ',0,0,'L');
    $pdf->SetXY(90,197); $pdf->Cell(6,6,$data[21],1,0,'C');
    $pdf->SetXY(110,200); $pdf->Cell(0,0,'No: ',0,0,'L');
    $pdf->SetXY(120,197); $pdf->Cell(6,6,$data[22],1,0,'C');
    $pdf->SetXY(20,215); $pdf->Cell(0,0,iconv('UTF-8', 'windows-1252', 'Speciment de chèque présent: '),0,0,'L');
    $pdf->SetX(80); $pdf->Cell(0,0,'Oui: ',0,0,'L');
    $pdf->SetXY(90,212); $pdf->Cell(6,6,$data[23],1,0,'C');
    $pdf->SetXY(110,215); $pdf->Cell(0,0,'No: ',0,0,'L');
    $pdf->SetXY(120,212); $pdf->Cell(6,6,$data[24],1,0,'C');

$pdf->Output();
?>	
