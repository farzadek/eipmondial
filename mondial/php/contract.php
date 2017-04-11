<?php
session_start();
require('fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('../img/eip_new_logo.png',90,8,25);
    // Arial bold 15
    //$this->SetFont('Helvetica','B',16);
    // Move to the right
    //$this->Cell(80);
    // Title
	//$w = $this -> GetStringWidth('')+6;
    //$this->SetX(60);
    //$this->Cell($w,8,'Report of Certificate of ',1,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-18);
    // Arial italic 8
    $this->SetFont('Arial','',9);
	$this->SetTextColor(120,120,120);
	setlocale(LC_CTYPE, 'en_US');
    // Page number
    $this->Cell(0,3,'---------------------------------',0,1,'C');
    $this->SetFont('Arial','',8);
    $this->Cell(0,3,utf8_decode('Ce document, contient des éléments confidentiels et ne devra pas être imprimé et/ou publié, en partie ou en totalité.'),0,1,'C');
	$this->Cell(0,3,utf8_decode('Ce document est la propriété de E.I.P. Mondial. Inc. Seul E.I.P. Mondial. Inc. a le droit de soumettre ce document'),0,1,'C');
	$this->Cell(0,2,utf8_decode(''),0,1,'C');
	$this->Cell(0,3,utf8_decode('Copyright ©E.I.P.Mondial Inc. Depuis 2001.'),0,1,'C');
	





}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Cell(90,10,utf8_decode('Adhérant Prénom: '.$_SESSION['vpcode']),1,0,'L');
$pdf->Cell(100,10,utf8_decode('Adhérant nom famille: '.$_SESSION['vpcode']),1,1,'L');

$pdf->Cell(100,10,utf8_decode('Adresse: '.$_SESSION['vpcode']),1,0,'L');
$pdf->Cell(50,10,utf8_decode('Ville: '.$_SESSION['vpcode']),1,0,'L');
$pdf->Cell(40,10,utf8_decode('Province: '.$_SESSION['vpcode']),1,1,'L');

$pdf->Cell(50,10,utf8_decode('Code Postal : '.$_SESSION['vpcode']),1,0,'L');
$pdf->Cell(70,10,utf8_decode('Téléphone1 : '.$_SESSION['vpcode']),1,0,'L');
$pdf->Cell(70,10,utf8_decode('Téléphone2 : '.$_SESSION['vpcode']),1,1,'L');

$pdf->Cell(190,10,utf8_decode('Email: '.$_SESSION['vpcode']),1,1,'L');

$pdf->Cell(95,10,utf8_decode("Pièce D'identité#1: ".$_SESSION['vpcode']),1,0,'L');
$pdf->Cell(95,10,utf8_decode("Pièce D'identité#12: ".$_SESSION['vpcode']),1,1,'L');

$pdf->Cell(95,10,utf8_decode("Demande de Financement: "),1,1,'L');

$pdf->Cell(95,10,utf8_decode("Membre E.I.P. Mondial (839.40$ +taxes) "),1,0,'L');
$pdf->Cell(95,10,utf8_decode("ADHESION VIE E.I.P.Mondial (1450$ +taxes) "),1,1,'L');

$pdf->Cell(65,10,utf8_decode("12 Mois (69.95$)"),1,0,'L');
$pdf->Cell(65,10,utf8_decode("6 Mois (139.90$)"),1,0,'L');
$pdf->Cell(60,10,utf8_decode("3 Mois (279.80$)"),1,1,'L');

$pdf->Cell(65,10,utf8_decode("12 Mois (138.92$)"),1,0,'L');
$pdf->Cell(65,10,utf8_decode("6 Mois (277.85$)"),1,0,'L');
$pdf->Cell(60,10,utf8_decode("3 Mois (555.71$)"),1,1,'L');

$pdf->Cell(190,10,utf8_decode("Mai2016"." o   "."Mai2016"." o   "."Mai2016"." o   "."Mai2016"." o   "."Mai2016"." o   "."Mai2016"." o   "."Mai2016"." o   "."Mai2016"." o   "),0,1,'L');


$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,7,utf8_decode('Bienvenue au programme de ristourne PFP de E.I.P.'),0,1,'C');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,4.5,utf8_decode("En devenant membre E.I.P.Mondial Inc. vous recevez un bureau virtuel avec une trousse d'information"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("ainsi qu'un certificat. Une adhésion à vie vous procure une ristourne PFP (point fidélité proactif)"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("règlement s'applique pour membre annuel cette ristourne consiste en un bénéfice de point que vous"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("pourrez utiliser pour payer jusqu'à 50% de votre facture chez E.I.P. avec vos année de fidélité ses"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("point peuvent être échangé en argent exclusivement pour le membre E.I.P.Mondial Inc. Un membre étant"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("une personne ayant acheté une ou plusieurs certificats PFP."),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode(" "),0,1,'L');
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,7,utf8_decode("Règlements d'une ristourne PFP"),0,1,'C');
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,4.5,utf8_decode("1. l'adhésion : deux pièces d'identité officielles et valides ainsi qu'un numéro de compte bancaire sont exigés "),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   (spécimen de cheque). Celle-ci doit être exécutée avec l'un de nos agents VPS, VPF ou à l'un des points de"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   service d'E.I.P. Mondial Inc. Vos PFP sont effectif le 1e du mois suivant la date d'adhésion ou le 1e du mois"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   suivant votre dernierpaiement de financement vos point fidélité augmente de 30 point tous les 1e du mois, pour"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   chaque tranche de 1000 point la proactivité se met en effet et augmente de 30 point supplémentaire (voir charte),"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   un adhérer annuelle doit attendre deux année de fidélité pour acquérir son premier certificat de ristourne PFP."),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   L'adhésion est non remboursable après 30 jours."),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode(""),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("2.  Valeur : Après 5e année de fidélité compléter, vos PFP peuvent être échangé leur valeur 1$ par PSP en"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   argent jusqu'à 90% de ceux-ci peuvent vous être échangé, dans le cas de décès ou par choix personnel, la"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   transmission de vos ristournes PFP est transmissible au récipiendaire de votre choix. Bien entendu, deux"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   pièces d'identité officielles et valides sont requises pour l'approbation de cette personne."),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode(""),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("3.	Échange : des lors vous commencer à accumuler vos point PFP vous pouvez payer jusqu’à 50% de votre"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   facture sur tous les services de E.I.P. et ce en tous temps directement de votre bureaux virtuel ceux-ci"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("    sont arrondie aux plus haut. (Doit finir par zéro)"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode(""),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("4.	Fonds principaux : À la 6e année, vos points PFP peuvent être échangés. Vous avez deux manières d'y"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   toucher: Pour votre principal (ex) vous échanger une partie de vos PFP principaux, dans les 24hrs vos"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   point vous seront échanger et envoyer directement dans votre compte bancaire votre principal diminuera"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   selon l'échelle (voir charte). Celui-ci remontera pro activement par lui-même. Votre principal est"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   restreint à 1000 PFP plus les frais annuels si applicables et vous pouvez échanger jusqu'à 90% des point"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   restant en argent les PFP sont automatiquement arrondie aux plus haut. (Doit finir par zéro)"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode(" "),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   Résiduel mensuel : Celui-ci peut être transféré à tous les mois. À cet effet, votre principal reste le même."),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   Vous pouvez toucher 90% de vos PFP résiduel aussi longtemps que vous le désirez. Lorsque intouché, il prend"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   son cours pro activement et il continuera à augmenter vos PFP principaux jusqu'à la somme maximale de"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   10,000 PFP (voir charte) arrondie aux plus haut. (Doit finir par zéro) Si annulée avant votre 5e année, aucun"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   retour d'argent ne vous sera acquitté."),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode(" "),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("5.	La ristourne : PFP est fermée, c'est-à-dire que vous ne pouvez pas ajouter de PFP additionnel. Simplement"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   en restent membre a vie et restant adhérer celle-ci augmente par elle-même."),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode(""),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("6.	Le plafond : de la ristourne PFP est de 10 000 PFP par certificat avec un retour de 300 PFP par mois à"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   vie et est transmissible de génération à génération, vous devez tout fois vous assurer de faire le transfert"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   de ses PFP ou les utilisez sinon les PFP mensuelle feront que disparaitre vous pouvez faire cette action auto"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   m'attiser de votre bureau virtuel moins les frais applicable. Un individu peut acheter un maximum de 100"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("   certificats de ristourne PFP. peut être modifiée selon la croissance et la hausse économique de notre société"),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode(""),0,1,'L');
$pdf->Cell(0,4.5,utf8_decode("J'atteste que je comprends les règlements tels que décrits précédemment et j'accepte de devenir membre chez"),0,1,'C');
$pdf->Cell(0,4.5,utf8_decode("E.I.P. Mondial Inc."),0,1,'C');
$pdf->Cell(0,4.5,utf8_decode(""),0,1,'L');
$pdf->Cell(0,5.5,utf8_decode("Adhérant Prénom: ".$_SESSION["vpcode"]),0,0,'L');





$pdf->Output();
?>	
