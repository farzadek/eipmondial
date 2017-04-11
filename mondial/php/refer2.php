<?php
session_start();
$valid2 = false;
if(!isset($_SESSION['formdata'])){$_SESSION['formdata']='VP001';}
$formdata = $_SESSION['formdata'];
include('connect.php');
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EIP - <?php echo $_SESSION["vpcode"] ?></title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
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
    h3{
		text-align: center;
		font: 1.8em/2em Montserrat;
		font-weight: 700;
	}
	#errMsg{
		color: red;
		font: 1.3em/1em lora;
	}
	#successMsg{
		color: green;
		font: 1.3em/1em lora;		
	}
    </style>
</head>

<?php
function generateRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if(isset($_POST["refersuivant2"])){
	$valid = true;
	/*if($_POST['esignname']){$formdata['name'] = $_POST['esignname'];}
	else {$valid = false;echo 'Name is not correct';}*/
	if($valid){
		$_SESSION['formdata'] = $formdata;
		$ty = date("Y");
		$sql = "select count(id) as counts from users where YEAR(memberdate)=$ty"; 
		if (mysql_query($sql, $user_con)) {
    		$result = mysql_query($sql, $user_con) or die(mysql_error());
    		$r = mysql_fetch_assoc($result);
    		//echo $r['counts'];
		} 
		else {
    		echo "Error: " . $sql . "<br>" . mysql_error($user_con);
		}

//		$mnt = $formdata['mnt'];
		$vpcode = $formdata['vpcode'];
		$name = $formdata['name'];
		$famil = $formdata['famil'];
		$nm = $name.' '.$famil;
		$adress = $formdata['adress'];
		$city = $formdata['city'];
		$province = $formdata['province'];
		$postal = $formdata['postal'];
		$phone = $formdata['phone'];
		$email = $formdata['email'];
		$refno = $formdata['referredby'];
		$today = date("Y-m-d H:i");
		//$amount = $formdata['invest_price'];
		$pw = generateRandomString(8);

		$sql_member = "INSERT INTO member (vpcode, name, famil, adress, city, province, postal, email, phone1, refno, today, active) 
			VALUES ('$vpcode', '$name', '$famil', '$adress', '$city', '$province', '$postal', '$email', '$phone', '$refno', '$today', 0)";
		$sql_user = "INSERT INTO users (vpcode, name_user, type, username, password, active, email, referredby, ismember) VALUES 
									 ('$vpcode', '$nm', 3, '$email', '$pw', 0, '$email', '$refno', 0)"; 
		if($formdata['requesttype']=='Loan'){
			$amount = $formdata['loanAmount'];
			$loan_type = $formdata['loan_type'];
			$sql_loan = "INSERT INTO loan (lvpcode, refby, amount, type) 
						VALUES ('$vpcode', '$refno', $amount, '$loan_type')"; 
	   		$result_l = mysql_query($sql_loan, $user_con) or die(mysql_error());
		}
		else{
			$amount = $formdata['invest_price'];
			$sql_loan = "INSERT INTO loan (lvpcode, refby, amount) 
						VALUES ('$vpcode', '$refno', $amount)"; 
	   		$result_l = mysql_query($sql_loan, $user_con) or die(mysql_error());			
		}



   		$result_m = mysql_query($sql_member, $user_con) or die(mysql_error());
   		$result_u = mysql_query($sql_user, $user_con) or die(mysql_error());
		if ($result_m && $result_u)  {
    		$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$messageMailp = '<html><head><title>Refer for loan, EIP.Mondial</title></head><body><h3>Nom et prénom: '.$famil.', '.$name.'</h3><p style="font-size:20px">Email: '.$email.'</p><p style="font-size:18px">Phone : '.$phone.'</p><p style="font-size:18px"></p></body></html>';
			mail('info@eipmondial.com','EIP MONDIAL Inc. mail System',$messageMailp, $headers);
			$messageMailp = '<html><head><title>Message from EIP.Solution</title></head><body><img src="http://eipmondial.com/mondial/img/eip_new_logo.png" width="200" style="margin:10px 100px;"><h2>Mr./Mme. '.$famil.', '.$name.'</h2><p style="font-size:20px">Welcome to EIP.Mondial Inc.</p><p style="font-size:18px">If your account is not cativate yet, you need to activate your account, you need to login to your account. (Link below)</p><p style="font-size:18px"><a href="http://eipmondial.com/mondial/php/login.php" target="_blank">http://eipMondial.com/login</a></p><p style="font-size:18px">Usename : '.$email.'</p><p style="font-size:18px">Password : '.$pw.'</p><p style="font-size:18px">un de nos spécialistes se fera un plaisir de vous contactez d’ici 48h.</p></body></html>';
			mail($email,'EIP MONDIAL Inc. mail System',$messageMailp, $headers);
    		echo "<div id='successMsg'>New record created successfully</div>";
		} 
		else {
    		echo "<div id='errMsg'>Error: ". mysql_error($user_con)."</div>";
		}
		header( "refresh:2;url=vp.php" );
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
		<h3>Refer</h3>
        <div class="row">
            <div class="col-lg-12">
				<table class="table">
					<tbody>
						<tr>
							<td class="tlt">Type de demande</td>
							<td class="itm"><?php echo $formdata['requesttype']; if($formdata['requesttype']=='Investor'){echo ' ('.number_format($formdata['invest_price'], 2, ',', ' ').'$)';} if($formdata['requesttype']=='Loan'){echo ' ('.$formdata['loan_type'].' - '.number_format($formdata['loanAmount'], 2, ',', ' ').'$)';} ?>
							</td>
						</tr>
						<tr><td class="tlt">Pr&eacute;nom et Nom </td><td class="itm"><?php echo $formdata['name'].' '.$formdata['famil']; ?></td></tr>
						<tr><td class="tlt">Adresse </td><td class="itm"><?php echo $formdata['adress'].', '.$formdata['city'].', '.$formdata['province'].',  '.$formdata['postal']; ?></td></tr>
						<tr><td class="tlt">Adresse courriel </td><td class="itm"><?php echo $formdata['email']; ?></td></tr>
						<tr><td class="tlt">T&eacute;l&eacute;phone </td><td class="itm"><?php echo $formdata['phone']; ?></td></tr>
						<tr><td class="tlt">Référencé par </td><td class="itm"><?php echo $formdata['referredby']; ?></td></tr>
						<tr><td class="tlt">VP Code </td><td class="itm"><?php echo $formdata['vpcode']; ?></td></tr>
					</tbody>
				</table>			
			</div>
		</div>
		<p>
		Je, soussigné comprends et atteste les règlements ci-joints plus bas et de respecter les exigences et les normes de E.I.P Mondial Inc. Le présent contrat constitue l’entière convention entre les parties, qui reconnaissent la nullité de toutes représentations ou modifications à moins de confirmation par l’autre partie. Le présent contrat est soumis aux lois de la province du Québec; tout litige sera du ressort exclusif des tribunaux siégeant dans le district de Longueuil. Où les parties déclarent élire domicile en vue de l’exécution du contrat ou de l’exercice des droits qui en découlent.		
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

					
		    <button type="submit" name="refersuivant2" id="btnSuivant" class="btn btn-info" id="sub2btn">Sauvegarder <span class="fa fa-angle-double-right"></span></button>
		    <a href="refer.php" class="btn btn-default">Cancel</a>
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
