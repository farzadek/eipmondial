<?php
session_start();
$valid2 = false;
if(!isset($_SESSION['formdata'])){$_SESSION['formdata']='VP001';}
$formdata = $_SESSION['formdata'];
include('connect.php');
?>
<head>
    <meta charset="utf-8">
    <title>EIP - <?php if($_SESSION["vpcode"]){echo $_SESSION["vpcode"];} ?></title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="../img/icon32.png">
    <script src="../js/jquery.js"></script>
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
    body{
    	background-color: #fefeff;
    }
    section{
    	margin-top: 10px;
    }
    img{
    	left:37%;
    	position:relative;
    }
    .tlt{
    	font: 1.2em/1em Montserrat;
    	text-shadow: 0 0 2px #999;
    	width: 20%;
    }
    .itm{
    	font: 1.3em/1em lora;
    	width: 80%;
    }
    p{
    	font: 1em/1.2em lora;   
    	padding: .1em 2em 1em; 	
    }
    #newPvFormCheck{
    	font: 1.3em/1.3em lora;       
    }
    #newPvFormCheck .row{
    	padding-bottom: 1.5em;
    }
    #successMsg{
    	min-height: 50px;
    	border-radius: 5px;
    	box-shadow: 1px 1px 5px #888;
    	display: absolute;
    	top: 5%;
    	left: 10%;
    	background-color: #08e066;
    	color: white;
    	font: 1.3em/1em lora;
    	padding: 20px;
    	display: table;
    }
    </style>
</head>

<?php

if(isset($_POST["membersuivant2"])){
	$valid = true;
	/*if($_POST['esignname']){$formdata['name'] = $_POST['esignname'];}
	else {$valid = false;echo 'Name is not correct';}*/
	if($valid){
		$_SESSION['formdata'] = $formdata;
		$ty = date("Y");
		$sql2 = "select count('id') as counts from users where YEAR(memberdate)=$ty"; 
		if (mysql_query($sql2, $user_con)) {
    		$result_bemember = mysql_query($sql2, $user_con) or die(mysql_error());
    		$r = mysql_fetch_assoc($result_bemember);
    		//echo $r['counts'];
		} 
		else {
    		echo "Error: " . $sql . "<br>" . mysql_error($user_con);
		}
		$ty= $r['counts']+1;
		if($ty<10){$ty='00'.$ty;}elseif($ty<100 && $ty>9){$ty='0'.$ty;}
		$ty1='VP'.date("y").$ty;

		$name = $formdata['name'];
		$famil = $formdata['famil'];
		$adress = $formdata['adress'];
		$city = $formdata['city'];
		$province = $formdata['province'];
		$postal = $formdata['postal'];
		$email = $formdata['email'];
		$phone = $formdata['phone'];
		//if($formdata['demandfin']){$demand = true;}else{$demand=false;};
		$demand=false;
		$membertype = $formdata['requesttype'];
		//$price = $formdata['invest_price'];
		$dure = $formdata['dure'];
		$un = $email;
		$pw = $formdata['password'];
		$nm = $name.' '.$famil;
		$type = $formdata['cltype'];
		$refby = $formdata['refno'];
		$today = $formdata['today'];

		$sql = "INSERT INTO member (vpcode, name, famil, adress, city, province, postal, email, phone1, membrtype, refno, active) 
				VALUES ('$ty1', '$name', '$famil', '$adress', '$city', '$province', '$postal', '$email', '$phone', '$membertype', '$refby', true)";

		$sql_o = "INSERT INTO users (vpcode, name_user, type, username, password, active, email, referredby) 
			      VALUES ('$ty1', '$nm', '$type', '$un', '$pw', true, '$email', '$refby')"; 

   		$result = mysql_query($sql, $user_con) or die(mysql_error());
  		$result_o = mysql_query($sql_o, $user_con) or die(mysql_error());

		$_SESSION['formdata'] = $formdata;
		$_SESSION['un']=$un;
/* *********************************************************************************************** */		
//$cpuser = 'rabaiseip@gmail.com'; // cPanel username
//$cppass = 'syhelie'; // cPanel password
//$cpdomain = 'eipmondial.com'; // cPanel domain or IP
//$cpskin = 'paper_lantern';  // cPanel skin. Mostly x or x2. 

// check if overrides passed

$euser = $name.'.'.$famil;
$euser1 = $name.'.'.$famil;
$epass = $pw;
$equota = 50; 
$edomain = 'eipmondial.com';

$msg1 = '';$rep=-1;$email_ok=true;
/*
while(true) {


	if(++$rep>0){$euser=$euser1.$rep;}
	$f = fopen ("https://peel.web-dns1.com:2083/cpsess2152517400/frontend/$cpskin/mail/doaddpop.html?email=$euser&domain=$edomain&password=$epass&quota=$equota", "r");
	if (!$f) {
		$msg = 'Cannot create email account. Possible reasons: "fopen" function allowed on your server, PHP is running in SAFE mode';
    	break;
	}

	while (!feof ($f)) {
		$line = fgets ($f, 1024);
    	if (ereg ("already exists", $line, $out)) {
			$msg = "<h2>Email account {$euser}@{$edomain} already exists.</h2>";
			$email_ok = false;
			break;
		}
		else{
			$email_ok = true;
		}
  	}
  	@fclose($f);

  	if(!$email_ok){	$msg = "<h2>Email account {$euser}@{$edomain} created.</h2>";break;}

}
/* *********************************************************************************************** */		
		if ($result) {
    		$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$msg = '<html><head><title>Message from EIP.Solution</title></head><body><h3>Client registered for EIP.Mondial</h3><table style="width:400px; border:2px solid black;font-size:18px;"><tr style="background-color:#483D8B;color: white;"><p style="padding:0 3px;">Nom:<strong> '.$famil.', '.$name.'</strong></p></tr><tr><p style="padding:0 3px;">Tel: <strong>'.$phone.'</strong></p></tr><tr style="background-color:#483D8B;color: white;"><p style="padding:0 3px;">Couriel: <strong>'.$email.'</strong></p></tr><tr><p style="padding:0 3px;">adress: '.$adress.', '.$city.', '.$province.', ('.$postal.')</p></tr><tr style="background-color:#483D8B;color: white;"><p style="padding:0 3px;">Referred by: <strong>'.$refby.'</strong></p></tr></table><p style="padding:0 3px;">'.$today.'</p></body></html>';
			mail('info@eipmondial.com','New registration on EIP.Mondial website',$msg, $headers);

			$messageMailp = '<html><head><title>Message from EIP.Solution</title></head><body><img src="http://eipmondial.com/mondial/img/eip_new_logo.png" width="200" style="margin:10px 100px;"><h2>Mr./Mme. '.$famil.', '.$name.'</h2><p style="font-size:20px">Welcome to EIP.Mondial Inc.</p><p style="font-size:18px">To activate your account, you need to login to your account. (Link below)</p><p style="font-size:18px"><a href="http://eipmondial.com/mondial/php/login.php" target="_blank">http://eipMondial.com/login</a></p><p style="font-size:18px">Usename : '.$un.'</p><p style="font-size:18px">Password : '.$pw.'</p><p style="font-size:18px">un de nos spécialistes se fera un plaisir de vous contactez d’ici 48h.</p></body></html>';
			mail($email,'EIP MONDIAL Inc. mail System',$messageMailp, $headers);

		} 
		else {
    		echo "<div id='errMsg'>Error: ". mysql_error($user_con)."</div>";
		}

		header('location:login.php');  
	} 
}

?>
	

<body>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
				<img src="../img/eip_new_logo.png" width="24%">
			</div>
		</div>
        <div class="row">
            <div class="col-lg-12">
				<table class="table">
					<tbody>
						<tr>
							<td class="tlt">Type de requérant </td>
							<td class="itm"><?php echo $formdata['requesttype']; if($formdata['requesttype']=='Investor'){echo ' ('.$formdata['invest_price'].' $)';} if($formdata['requesttype']=='Membre'){echo ' ('.$formdata['dure'].' mois, '.$formdata['invest_price'].' $/mois)';} ?>
							</td>
						</tr>
						<tr><td class="tlt">Pr&eacute;nom et Nom </td><td class="itm"><?php echo $formdata['name'].' '.$formdata['famil']; ?></td></tr>
						<tr><td class="tlt">Adresse </td><td class="itm"><?php echo $formdata['adress'].', '.$formdata['city'].', '.$formdata['province'].',  '.$formdata['postal']; ?></td></tr>
						<tr><td class="tlt">Courriel </td><td class="itm"><?php echo $formdata['email']; ?></td></tr>
						<tr><td class="tlt">T&eacute;l&eacute;phone </td><td class="itm"><?php echo '('.$formdata['phone'][0].$formdata['phone'][1].$formdata['phone'][2].') '.$formdata['phone'][3].$formdata['phone'][4].$formdata['phone'][5].'-'.$formdata['phone'][6].$formdata['phone'][7].$formdata['phone'][8].$formdata['phone'][9]; ?></td></tr>
						<?php if($formdata['requesttype']!='Investor'){ ?>
						<!--		<tr><td class="tlt">Start Date</td><td class="itm"><?php echo $formdata['startmonth']; ?></td></tr> -->
						<!--		<tr><td class="tlt">Demande de financement</td><td><?php if($formdata['demandfin']){echo 'Oui';}else{echo 'Non';} ?></td></tr> -->
					<!--			<tr><td class="tlt">Payment months</td>
									<td class="itm"><?php echo $formdata["mnt"][0].' , '.$formdata["mnt"][1].' , '.$formdata["mnt"][2]; ?></td>
								</tr> -->
								<?php if($formdata['dure']>3){ ?>
								<!--	<tr>
										<td class="tlt"></td><td class="itm"><?php echo $formdata["mnt"][3].' , '.$formdata["mnt"][4].' , '.$formdata["mnt"][5]; ?></td>
									</tr> -->
								<?php } else{
									$formdata["mnt"][3]='';$formdata["mnt"][4]='';$formdata["mnt"][5]='';$formdata["mnt"][6]='';$formdata["mnt"][7]='';$formdata["mnt"][8]='';$formdata["mnt"][9]='';$formdata["mnt"][10]='';$formdata["mnt"][11]='';}
									if($formdata['dure']>6){ ?>
								<!--	<tr>
										<td class="tlt"></td><td class="itm"><?php echo $formdata["mnt"][6].' , '.$formdata["mnt"][7].' , '.$formdata["mnt"][8]; ?></td>
									</tr>
									<tr>
										<td class="tlt"></td><td class="itm"><?php echo $formdata["mnt"][9].' , '.$formdata["mnt"][10].' , '.$formdata["mnt"][11]; ?></td>
									</tr> -->
								<?php } 
								}	
								?>
						<tr><td class="tlt">Nom d’utilisateur </td><td class="itm"><?php echo $formdata['username']; ?></td></tr>
					</tbody>
				</table>			
			</div>
		</div>
		<p>
		Je soussigné comprends atteste les règlements plus bas et respecte les exigences et les normes de E.I.P Mondial inc. Le présent contrat constitue l’entière convention entre les parties, qui reconnaissent la nullité de toutes représentations ou modifications à moins de confirmation de l’autre partie.		
		</p>
		
		<form id="newPvFormCheck" method="post">
		    <div class="row">
				<div class="checkbox col-lg-2 col-md-3 col-sm-4 col-xs-12">
					<label onclick="esignChk()"><input type="checkbox" name="esign" id="esigncheck" onclick="esignChk()"> E-sign</label>
				</div>
				<div class="checkbox col-lg-3 col-md-3 col-sm-4 col-xs-12">
					<label>Signature électronique</label>
		            <input type="text" id="esignname" disabled="disabled" class="form-control" name="esignname" required="required" onkeyUp="esignName()" />
				</div>
				<div class="checkbox col-lg-3 col-md-3 col-sm-4 col-xs-12">
					<label>Date</label>
		            <input type="text" class="form-control" name="today" readonly="readonly" value="<?php echo date("F j, Y"); ?>"/>
				</div>
			</div>

					
		    <button type="submit" name="membersuivant2" id="btnSuivant" class="btn btn-info" id="sub2btn">Sauvegarder <span class="fa fa-angle-double-right"></span></button>
		    <a href="member.php" class="btn btn-default">Annuler</a>
		</form>		
	</div>	

</section>

<script>
document.getElementById('btnSuivant').disabled = true;
function esignChk(){
	$('#div3').hide();	var x = document.getElementById('esigncheck');
	if (!x.checked){
		document.getElementById("esignname").disabled = true;
	}
	else{
		document.getElementById("esignname").disabled = false;
	}	
}
function esignName(){
	if(document.getElementById('esignname').value.length>0){
		document.getElementById('btnSuivant').disabled = false;
	}
	else{
		document.getElementById('btnSuivant').disabled = true;
	}
}
$(document).ready(function(){
	$("#successMsg").hide();
    $("btnSuivant").click(function(){
        $("#successMsg").fadeToggle(3000);
    });
});

</script>
</body>
