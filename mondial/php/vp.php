<?php
session_start();
include('connect.php');
if(isset($_SESSION["vpcode"])){
	$errMsg = '';
	$logedin=false;
	if (!function_exists("GetSQLValueString")) {
		function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
			if (PHP_VERSION < 6) {
				$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
			}
			$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
			switch ($theType) {
				case "text":
					$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
					break;    
				case "long":
				case "int":
					$theValue = ($theValue != "") ? intval($theValue) : "NULL";
					break;
				case "double":
					$theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
					break;
				case "date":
					$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
					break;
				case "defined":
					$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
					break;
		  }
		  return $theValue;
		}
	}

	$src=$_SESSION['vpcode'];
	$sql = "SELECT * FROM certificate where vpcode='$src'";
	$result = mysql_query($sql, $user_con) or die(mysql_error());

	if (isset($_POST["certpdf"])) {
		include('certdetail.php');
	}
	if(isset($_POST["bemember"])){
		$sql_bemember = "UPDATE users SET ismember=1 where vpcode='$src'";
		$result_bemember = mysql_query($sql_bemember, $user_con) or die(mysql_error());
	}
}	

?>	
<html lang="fr">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>EIP Mondial - <?php echo $_SESSION["vpcode"] ?></title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../grayscale.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Cousine" rel="stylesheet">
    <link rel="shortcut icon" href="../img/icon32.png">
    <script src="../js/grayscale.js"></script>
    <script src="../js/jquery.js"></script>
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->	
    <style>
    	th{font:1.1em/1.1em Montserrat;font-weight: 700;}
    	td{font:1.2em/1em Cousine;}
    	tr{height: 30px;margin-bottom: 5px;}
    	#bkop{
    		width:100%;
    		height:100%;
    		background-color:rgba(50,50,70,0.5);
    		display:none;
    		position:fixed;
    		z-index:190;
    	}
    	body{
    		background-color:#eee;
    		padding-top: 0;
    	}
    	.services tr{
    		color: #ddd;
    		font-size: .9em;
    		height: 25px;
    	}
    	.services i{
    		color: #3e5;
    		margin-right: 5px;
    	}

    	#referrals, #commission, #interest{
    		padding:10px 0;
    		background-color:#666;
    		border:1px solid #000;
    		margin-bottom: 30px;
    	}
    	#referrals table, #commission , #interest table{
    		width: 100%;
    	}
    	#interest table{
    		margin-bottom: 5px;
    	}
    	#referrals th, #commission th{
    		text-align: center;
    		font: 1em/1em Montserrat;  
    		font-weight: 700; 
    		border-bottom: 1px solid white; 		
    		text-shadow: 0 0 2px #111;
    	}
    	#referrals td, #commission td{
    		padding-left: 3px;
    		font: 1em/1em lora;  
    		text-shadow: 0 0 1px #333;
    	}
    	#referrals td .btn{
    		border-radius:2px;
    		box-shadow:1px 1px 5px rgba(50,50,50,0.7);
    		margin-left: 5px;
    	}
    	#commission td .btn{
    		border-radius:2px;
    		box-shadow:1px 1px 5px rgba(50,50,50,0.7);
    		display: inline;
    		margin-left: 5px;
    		float: right;
    		font: .8em/.9em Montserrat;  
    	}


	.vpmonth{
		margin-bottom: 0.5em;
		display: inline-block;
		margin-top:1em;
	}
	.vpmonth .btn-default{
		color: #333;	
		border: none;	
		background-color: rgba(0,0,0,0);
	}
	.badgebox{
	    opacity: 0;
	}

	.badgebox + .badge{
	    /* Move the check mark away when unchecked */
	    text-indent: -999999px;
	    /* Makes the badge's width stay the same checked and unchecked */
		width: 27px;
	}

	.badgebox:focus + .badge{
	    /* Set something to make the badge looks focused */
	    /* This really depends on the application, in my case it was: */
	    
	    /* Adding a light border */
	    box-shadow: inset 0px 0px 5px;
	    /* Taking the difference out of the padding */
	}

	.badgebox:checked + .badge{
	    /* Move the check mark back when checked */
		text-indent: 0;
	}	
	hr{
		width: 75%;
		background-color: white;
		box-shadow: 1px 1px 3px #111;
	}
	span[id$="lb"]{
		color: #ddd;
		font-size: 1.2em;
	}
	i[id^="y"]{cursor:pointer;}
	.month-pays{
		margin: .5em 2em 2em;
	}
	.month-pays div{
		margin: 15px 40px 0 0;
		display: inline;
		font-size: 1.4em;
	}
	#msg1{
		color: white;
		width: 250px;
		background-color: #05c066;
		padding: 10px 15px;
		border-radius: 5px;
		box-shadow: 1px 1px 5px #444;
		font-size: 1.3em;
		position: absolute;
		right: 300px;
		top: 0;
		margin-top: -200px;
		z-index: 9777;
	}
	#msg1:before {
		content:"";
	    position: absolute;
	    left: 99%;
	    top: 26px;
	    width: 0;
	    height: 0;
	    border-top: 10px solid transparent;
	    border-left: 26px solid #05c066;
	    border-bottom: 10px solid transparent;
	}
	#msg2{
		color: white;
		width: 250px;
		background-color: #05c066;
		padding: 10px 15px;
		border-radius: 5px;
		box-shadow: 1px 1px 5px #444;
		font-size: 1.3em;
		position: absolute;
		right: 300px;
		top: 0;
		margin-top: -5px;
		z-index: 9277;
	}
	#msg2:before {
		content:"";
	    position: absolute;
	    left: 99%;
	    top: 11px;
	    width: 0;
	    height: 0;
	    border-top: 10px solid transparent;
	    border-left: 21px solid #05c066;
	    border-bottom: 10px solid transparent;
	}
	#msg3{
		color: white;
		width: 450px;
		background-color: #05c066;
		padding: 10px 15px;
		border-radius: 5px;
		box-shadow: 1px 1px 5px #444;
		font-size: 1.3em;
		position: absolute;
		left: 250px;
		top: 0;
		margin-top: -50px;
		z-index: 9877;
	}

	#msg1 a.boxclose{
	    float:right;
	    margin-top:-42px;
	    margin-right:-22px;
	    cursor:pointer;
	    color: #fff;
	    border: 1px solid #AEAEAE;
	    border-radius: 30px;
	    background: #605F61;
	    font-size: 26px;
	    font-weight: bold;
	    display: inline-block;
	    line-height: 0px;
	    padding: 9px 2px;   
	    text-decoration: none;    
	}
	#msg2 a.boxclose{
	    float:right;
	    margin-top:-20px;
	    margin-right:-20px;
	    cursor:pointer;
	    color: #fff;
	    border: 1px solid #AEAEAE;
	    border-radius: 30px;
	    background: #605F61;
	    font-size: 26px;
	    font-weight: bold;
	    display: inline-block;
	    line-height: 0px;
	    padding: 9px 2px;   
	    text-decoration: none;    
	}
	#msg4{
		color: white;
		background-color: #05c066;
		padding: 10px 15px;
		border-radius: 5px;
		box-shadow: 1px 1px 5px #444;
		font-size: 1.3em;
		position: absolute;
		left: -130px;
		top: 0;
		margin-top: 10px;
		z-index: 9777;
	}
	#msg5{
		color: white;
		background-color: #05c066;
		padding: 10px 15px;
		border-radius: 5px;
		box-shadow: 1px 1px 5px #444;
		font-size: 1.3em;
		position: absolute;
		left: -130px;
		top: 0;
		margin-top: 10px;
		z-index: 9777;
	}
	#msg4 a.boxclose,#msg5 a.boxclose{
	    float:right;
	    margin-top:-20px;
	    margin-right:-20px;
	    cursor:pointer;
	    color: #fff;
	    border: 1px solid #AEAEAE;
	    border-radius: 30px;
	    background: #605F61;
	    font-size: 26px;
	    font-weight: bold;
	    display: inline-block;
	    line-height: 0px;
	    padding: 9px 2px;   
	    text-decoration: none;    
	}
	.boxclose:before {
    	content: "×";
	}


#loanbox label{
	font-size: 1.4em;
}
#loanbox input{
	margin-left: 25%;
}
#vpHeader{
	background-color:#42DCA3;
}
#vpHeader .container{
	height:40px;
}
#vpHeader .container .row{
	color:white;
	text-transform: capitalize;
}
#vpHeader .container .row img{
	margin:2px 0 0 5px;
	border-radius: 50%;
	-webkit-border-radius: 50%;
	-moz-border-radius: 50%;
	border:2px solid white;
}
td{font-size: 1.3em;}
.vpn-btn-top{
	float:right;
	color:white;
	margin:8px 4px 10px;
}
.my-button{
	border-radius:2px;
	box-shadow:1px 1px 5px rgba(50,50,50,0.5);
	width:100%;
	margin-bottom: 5px;
}
@media(max-width: 1030px){
		#msg1,#msg2{right: 250px;}
}
@media(max-width: 770px){
		#msg1,#msg2{right: 20px;}
		td:nth-child(2),td:nth-child(4),td:nth-child(5){font-size: .7em;}
}
@media(max-width: 570px){
		#msg1,#msg2{right: 0;left:10px;top:70px;}
		#req1{margin-top: 15px;}
		td{font-size: .6em !important;}
}
@media print{
	.phide{
		display:none;
	}
	.big14pt{
		font-size: 16pt !important;
	}
	#vpHeader{
		background-color: #fff;
		border-bottom: 1px solid black;
		font-size: 20pt;
		font-weight: bold;
	}
}

</style>
</head>
<body>
<?php
	if($_SESSION["vpcode"]){

	$s=$_SESSION["vpcode"];
	$sql2 = "SELECT * FROM users JOIN member ON users.vpcode=member.vpcode WHERE users.vpcode='$s'";
	$result2 = mysql_query($sql2, $user_con) or die(mysql_error());
	$curr_user = mysql_fetch_assoc($result2);
	if($curr_user['card']){$x1='X';$x2='';}else{$x1='';$x2='X';}
	if($curr_user['speciment']){$x3='X';$x4='';}else{$x3='';$x4='X';}
	$stdate = date("Y-m-d",strtotime($curr_user['stdate']));
	$enddate = date("Y-m-d",strtotime($curr_user['enddate']));
    $_SESSION['pr2']=$curr_user['vpcode'].'|'.$curr_user['famil'].'|'.$curr_user['name'].'|'.$curr_user['score'].'|'.$curr_user['montantalloe'].'|'.$curr_user['dettereal'].'|'.$curr_user['paypermonthreal'].'|'.$curr_user['dayforpay'].'|'.$curr_user['bank1'].'|'.$curr_user['accountno'].'|'.$stdate.'|'.$enddate.'|'.$curr_user['totalmonth'];

	$_SESSION['type'] = $curr_user['type'];  
	$grp = strval($curr_user['type']); 
	$sql3 = "SELECT * FROM messages";
	$result3 = mysql_query($sql3, $user_con) or die(mysql_error());
?>
<div id="bkop"></div>
		
<section id="vpHeader">
	<div class = 'container'>
		<div class='row'>
        	<div class='col-lg-8 col-sm-8 col-xs-10'>
				<p><img class="phide" 
				src="<?php $img=$curr_user['image'];if($img){echo 'image/'.$img;}else{echo 'image/pub.jpg';}?>" width="35" height="35"> 
				<?php echo $_SESSION["vpcode"].' - '.$curr_user['name_user']; ?></p>
			</div>
        	<div class='col-lg-4 col-sm-4 col-xs-2 phide'>
				<a style="float:right;color:white;margin-top:8px;margin-right: 10px;" href="../../">Page d’accueil</a>
			</div>
		</div>
    </div>
</section>	

<section style="background-color:#eee;color:#222;">
    <div class="container" style="padding-top:20px;">
	<a class="btn btn-xs btn-success phide vpn-btn-top" href="../../">Déconnexion</a>
	<a class="btn btn-xs btn-success phide vpn-btn-top" href="profile.php">Profil</a>
	<a class="btn btn-xs btn-success phide vpn-btn-top" target="_blank" href="rep_dossier_monte.php" id="print"><img src="../img/pdf.gif" style="width:16px"> Dossier Monté</a>        
	<div class="row"></div>

		    <div class="row phide" style="margin-bottom:20px;">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">				
					<div style="margin-bottom: 5px;">
						<a target="_blank" class="btn btn-default btn-lg" style="margin-top:0px;border-radius:10px;">
						<img src="../img/gpm1.jpg" style="margin: 5px auto;" width="90%"></a>
					</div>
					<div style="margin-bottom: 5px;">
						<a target="_blank" class="btn btn-default btn-lg" style="margin-top:0px;border-radius:10px;">
						<img src="../img/realstate.jpg" style="margin: 5px auto;" width="90%"></a>
					</div>
					<div>
						<a target="_blank" class="btn btn-default btn-lg" style="margin-top:0px;border-radius:10px;">
						<img src="../img/rabais.jpg" style="margin: 5px auto;" width="90%"></a>
					</div>
				</div>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
					<h3 style="text-shadow:1px 1px 3px #aaa;margin-top: 0;">Lettre d’informations</h3>
					<div style="width:100%;padding:10px;box-sizing:border-box;height: 300px;font:1.25em/1.4em lora;background-color: white;overflow-y: scroll;" >
					<?php 
						if(!isset($_SESSION['type'])){$_SESSION['type']=2;} 
						if($_SESSION['type']<3){echo '<p>Vous etes Visiteur, pour voir les nouvel vous devez etre membre ou utilisateur VP.</p>';}
						else{
							$now=0;
							while (mysql_num_rows($result3) > $now) {
								$data = mysql_fetch_assoc($result3);
								if( ((strpos($data['group'],(string)$_SESSION['type'])) || $data['group']==$_SESSION['type']) &&
									$data['stdate']<date("Y-m-d H:i:s") && $data['enddate']>date("Y-m-d H:i:s") )
									{echo '<p style="font:1.1em/1.4em lora;"><span style="color:#56a54c;"> ■ </span>'.$data['message'].'</p>';}
								$now++;
							}
						} ?>
					</div>
				</div>
			</div>

		<div class="phide">
		<h3 style="text-shadow:1px 1px 3px #aaa;">RÉFÉRENCEMENT</h3>
		<div class="row" id="referrals">
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
				<table class="table">
					<tr>
						<th style="width:12%">CODE</th>
						<th style="width:25%">NOM</th>
						<th style="width:8%">ACTIVE</th>
						<th style="width:7%"><i  style="color:red;" class="fa fa-circle-o" aria-hidden="true"></i></th>
						<th style="width:7%"><i style="color:#05c066;" class="fa fa-circle" aria-hidden="true"></i></th>
						<th>Commissions</th>
					</tr>
					<?php
						$total = 0;
						$sql = "SELECT * FROM users as u JOIN loan as l ON u.vpcode = l.refby where u.vpcode='$src'"; 
						if (mysql_query($sql, $user_con)) {
    						$result = mysql_query($sql, $user_con) or die(mysql_error());
	   						$now = 0;
							while ($now < mysql_num_rows($result)) {
    							$r = mysql_fetch_assoc($result);
    							$n = $r['lvpcode'];
								$sql1 = "SELECT name_user FROM users where vpcode='$n'"; 
	    						$result1 = mysql_query($sql1, $user_con) or die(mysql_error());
    							$r1 = mysql_fetch_assoc($result1);
								$report = '<tr><td>'.$r['vpcode'].'</td><td>'.$r1['name_user'].'</td><td></td>';
								if($r['situation']!='OK'){$report.='<td><i style="color:red;margin-left: 40%;" class="fa fa-check" aria-hidden="true"></i></td><td></td><td style="text-align: right;padding-right:15%;">0 $</td>';
								}
								else{$report.='<td></td><td><i style="color:#05c066;margin-left: 40%;" class="fa fa-check" aria-hidden="true"></i></td><td style="text-align: right;padding-right:15%;">1 000 $</td>';
									$total +=1000;
								}
								$report.='</tr>';
								echo $report;
								$now++;
								mysql_free_result($result1);
							}
    					}
    					echo '<tr><td></td><td></td><td><td></td><td></td><th style="border-bottom:none;">TOTAL : '.number_format($total, 2, ',', ' ').' $</th></tr>';
					?>
					<?php 	$now=0;	
						/*	$sql2 = "SELECT * FROM users where referredby=$currentid";
						//	$sql2 = "SELECT * FROM eip_users where referredby='$id'";
							$result2 = mysql_query($sql2, $user_con) or die(mysql_error());
							while (mysql_num_rows($result2) > $now) {
								$row2 = mysql_fetch_assoc($result2);
								$now++;
					?>
					<tr>
						<td><?php echo $row2['vpcode']; ?></td>
						<td><?php echo $row2['name']; ?></td>
						<td><?php if($row2['active']){echo 'Oui';}else{echo 'Non';} ?></td>
						<td>
							<button type='submit' name='loanrefer' style='border-radius:2px;box-shadow:1px 1px 5px rgba(50,50,50,0.5);' class='btn btn-sm btn-success'>Refer à loan</button>
						</td>
					</tr>
					<?php
							}*/
					?>
				</table>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 phide">
				<a href="refer.php" class="btn btn-md btn-success my-button">Referer</a>
				<?php 
				$sql2 = "SELECT * FROM users where vpcode='$src'";
				$result2 = mysql_query($sql2, $user_con) or die(mysql_error());
				$row = mysql_fetch_assoc($result2);
				?>
				<a <?php if($row['ismember']==2){echo "href='member.php'";} ?> class='btn btn-md btn-success my-button' id="referMember">Référer un nouveau membre</a>
				<div class="checkbox"><label style="color: white;"><input type="checkbox" value="1" name="addToPort">Ajouter les commissions à son portefeuille EIP</label></div>

			</div>
		</div>

		<h3 style="text-shadow:1px 1px 3px #aaa;">Certification</h3>
		<div class="row" style="padding:10px;background-color:#666;border:1px solid #000;margin-bottom: 30px;">
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="border-top: 1px solid white;border-bottom: 1px solid white;">
<?php	
	$pt = 0; $pt1 = 0; $now = 0; $c = array(); 
	while (mysql_num_rows($result) > $now) {
		$row = mysql_fetch_assoc($result);
		$now++;
		$year1 = date('Y', strtotime($row['startdate']));
		$year2 = date('Y');
		$month1 = date('m', strtotime($row['startdate']));
		$month2 = date('m');
		$day = date('d', strtotime($row['startdate']));
		if($now==1){$dt=$year1+'-';}
		$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
		if($diff<=34){$pt=$diff*30;}		
		if($diff>34 && $diff<=51){$pt=(34*30)+($diff-34)*60;}		
		if($diff>51 && $diff<=62){$pt=(34*30)+(17*60)+($diff-34-17)*90;}		
		if($diff>62 && $diff<=71){$pt=(34*30)+(17*60)+(11*90)+($diff-34-17-11)*120;}		
		if($diff>71 && $diff<=77){$pt=(34*30)+(17*60)+(11*90)+(9*120)+($diff-34-17-11-9)*150;}		
		if($diff>77 && $diff<=83){$pt=(34*30)+(17*60)+(11*90)+(9*120)+(6*150)+($diff-34-17-11-9-6)*180;}		
		if($diff>83 && $diff<=90){$pt=(34*30)+(17*60)+(11*90)+(9*120)+(6*150)+(6*180)+($diff-34-17-11-9-6-6)*210;}		
		if($diff>90 && $diff<=94){$pt=(34*30)+(17*60)+(11*90)+(9*120)+(6*150)+(6*180)+(7*210)+($diff-34-17-11-9-6-6-7)*240;}		
		if($diff>94 && $diff<=99){$pt=(34*30)+(17*60)+(11*90)+(9*120)+(6*150)+(6*180)+(7*210)+(4*240)+($diff-34-17-11-9-6-6-7-4)*270;}		
		if($diff>99 && $diff<=108){$pt=(34*30)+(17*60)+(11*90)+(9*120)+(6*150)+(6*180)+(7*210)+(4*240)+(5*270)+($diff-34-17-11-9-6-6-7-4-5)*300;}		
		
		if($diff>83 && $diff<=96){$diff-=400;}
		else if($diff>96 && $diff<=108){$diff-=800;}
		else if($diff>108 && $diff<=120){$diff-=1400;}
		
		$c[$now-1][0] = $year1;
		$c[$now-1][1] = $month1;
		$c[$now-1][2] = $pt;
		$c[$now-1][3] = $diff;
		$c[$now-1][4] = $day;
		$c[$now-1][5] = $row['id'];
		$pt1 += $pt;
	}	
?>
				<span style="font-size:22px;color:#fff;">Point de fidélité : <span style="font-weight:bolder;"><?php echo number_format($pt1); ?><sub>pts</sub></span></span><br/>
				<form role='form' method='post' action='' target='_blank' class="phide">
					<input id='certpdf' name='certpdf' type='submit' value='Download PDF' style='border-radius:3px;box-shadow:1px 1px 4px rgba(50,50,50,0.5);' class='btn btn-xs btn-success' <?php if($pt1==0){echo "disabled='disabled'";} ?> />
				</form>	
				<?php				
					for($i=0;$i<count($c);$i++){
				?>
				<!--
				<span style="font-size:16px;color:#ddd;">C<?php echo $i+1; ?> Fidelity Points: <span style="font-weight:bolder;"><?php //echo number_format($c[$i][2]); ?><sub>pts</sub></span>  </span>
					<span style="color:black;font-size:11px;">(
						<?php //echo $c[$i][0].'-'.$c[$i][1].'-'.$c[$i][4]; 
							if(floor($c[$i][3]/12)>0){/*echo '|&nbsp;'.floor($c[$i][3]/12).'year';*/}if(floor($c[$i][3]/12)>1){/*echo 's';*/} 
							if(floor($c[$i][3]/12)==0 && fmod($c[$i][3],12)>0){/*echo '| ';*/}if(fmod($c[$i][3],12)>0){
								//echo fmod($c[$i][3],12).'month'; 
								if(fmod($c[$i][3],12)>1){/*echo 's';*/} 
							}?>)</span>&nbsp;
						<script>
							var pt = <?php echo $c[$i-1][2]; ?>;
							var vp = <?php echo $c[$i-1][5]; ?>	;						
						</script>	
						<?php //if($c[$i][3]>72){echo "<input onclick='exch(pt,vp)' id='exch' type='button' value='Exchange' style='border-radius:2px;box-shadow:1px 1px 4px rgba(50,50,50,0.5);' class='btn btn-xs btn-info'>";} ?>
					<br/>--> 
				<?php		
					}
				?>	
			</div>

			<?php   
				$sql2 = "SELECT * FROM users where vpcode='$src'";
				$result2 = mysql_query($sql2, $user_con) or die(mysql_error());
				$row = mysql_fetch_assoc($result2);
				$currentid = $row['id'];
			?>
			<form method="post">
			<div class="col-lg-3 col-md-3 col-sm-6">
				<div id="msg1">To refer a member, You need to be a member!<a class="boxclose"></a></div>
				<div id="msg2">Tél: 1 (888) 368-8949<a class="boxclose"></a></div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 phide" style="position: relative;">
				<?php
				if($row['ismember']==0){
					echo '<a name="bemember" id="req1" class="btn btn-md btn-success my-button">Devenir membre</a>';
				}
				if($row['ismember']==1){
					echo "<div disabled='disabled' class='btn btn-md btn-success my-button'>Devenir membre (Pending...)</div>";
				}	
				if($row['ismember']==2){
					echo "<div disabled='disabled' class='btn btn-md btn-success my-button'>MEMBRE</div>";
				}	

				 ?>
			</div>
			
			<div id="loanbox" class="row">
	<!--			<h3 style="text-align: center;">Loan</h3>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<input id="personal" type="radio" name="loanType" value="personal">
  					<label for="personal">Personal</label>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<input id="business" type="radio" name="loanType" value="business">
					<label for="business"><span class="radio">Business</span></label>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<input id="hypotheque" type="radio" name="loanType" value="hypotheque">
					<label for="hypotheque"><span class="radio">Hypotheque</span></label>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<input id="amount" type="number" name="loanamount" min="1000">
					<label for="amount"><span class="radio">Amount</span></label>
				</div> -->
			</div>


			<div id="memberbox">
<!--				<div style="width: 200px;margin-left: 15px;">
					<label style="font-size: 1.2em;" for="startdate">Date de début</label>
					<select id="startdate" name="startdate" onchange="startDateCahnged()" class="selectpicker show-tick form-control" data-width="auto"></select>
				</div>

	            <div class="row month-pays">
				    <div><input type="radio" name="dure" value="12" id="m12" checked="checked" onclick="m12checked()"/> 12 Mois <span id="12mp"></span></div>
				    <div><input type="radio" name="dure" value="6" id="m6" onclick="m6checked()"/> 6 Mois <span id="6mp"></span></div>
				    <div><input type="radio" name="dure" value="3" id="m3" onclick="m3checked()"/> 3 Mois <span id="3mp"></span></div>
				</div>

				<div class="vpmonth" id="vpmonth">	
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt1" class="btn btn-default"><span id="mnt1lb"></span><input onclick="payMnt(1)" type="checkbox" id="mnt1" name="mnt[0]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt2" class="btn btn-default"><span id="mnt2lb"></span><input onclick="payMnt(2)" type="checkbox" id="mnt2" name="mnt[1]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt3" class="btn btn-default"><span id="mnt3lb"></span><input onclick="payMnt(3)" type="checkbox" id="mnt3" name="mnt[2]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt4" class="btn btn-default"><span id="mnt4lb"></span><input onclick="payMnt(4)" type="checkbox" id="mnt4" name="mnt[3]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt5" class="btn btn-default"><span id="mnt5lb"></span><input onclick="payMnt(5)" type="checkbox" id="mnt5" name="mnt[4]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt6" class="btn btn-default"><span id="mnt6lb"></span><input onclick="payMnt(6)" type="checkbox" id="mnt6" name="mnt[5]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt7" class="btn btn-default"><span id="mnt7lb"></span><input onclick="payMnt(7)" type="checkbox" id="mnt7" name="mnt[6]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt8" class="btn btn-default"><span id="mnt8lb"></span><input onclick="payMnt(8)" type="checkbox" id="mnt8" name="mnt[7]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt9" class="btn btn-default"><span id="mnt9lb"></span><input onclick="payMnt(9)" type="checkbox" id="mnt9" name="mnt[]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt10" class="btn btn-default"><span id="mnt10lb"></span><input onclick="payMnt(10)" type="checkbox" id="mnt10" name="mnt[]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt11" class="btn btn-default"><span id="mnt11lb"></span><input onclick="payMnt(11)" type="checkbox" id="mnt11" name="mnt[]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt12" class="btn btn-default"><span id="mnt12lb"></span><input onclick="payMnt(12)" type="checkbox" id="mnt12" name="mnt[]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
				</div>
					<a name='bemember' style='border-radius:2px;box-shadow:1px 1px 5px rgba(50,50,50,0.5);width:80px;margin:0 auto;' class='btn btn-md btn-success'>OK</a> 
					-->
			</div>

			</form>
		</div>
		</div>

<!--
		<h3 style="text-shadow:1px 1px 3px #aaa;">COMMISSION 10%</h3>
		<div class="row" id="commission">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<table class="table">
					<tr>
						<th style="width:10%">CODE</th>
						<th style="width:25%">NOM</th>
						<th style="width:5%">ACTIVE</th>
						<th>Services</th>
					</tr>
					<?php 	/*$now=0;	
							$sql2 = "SELECT * FROM users where referredby=$currentid";
						//	$sql2 = "SELECT * FROM eip_users where referredby='$id'";
							$result2 = mysql_query($sql2, $user_con) or die(mysql_error());
							while (mysql_num_rows($result2) > $now) {
								$row2 = mysql_fetch_assoc($result2);
								$now++;
					?>
					<tr>
						<td><?php echo $row2['vpcode']; ?></td>
						<td><?php echo $row2['name']; ?></td>
						<td><?php if($row2['active']){echo 'Oui';}else{echo 'Non';} ?></td>
						<td>
							<div class="btn btn-sm <?php if($row2['issolutionclient']==0){echo 'btn-danger';} if($row2['issolutionclient']==1){echo 'btn-info';} if($row2['issolutionclient']==2){echo 'btn-success';} ?>">Solution <?php if($row2['issolutionclient']==1){echo '(pending)';}?></div>
							<div class="btn btn-sm <?php if($row2['isgpmclient']==0){echo 'btn-danger';} if($row2['isgpmclient']==1){echo 'btn-info';} if($row2['isgpmclient']==2){echo 'btn-success';} ?>">GPM <?php if($row2['isgpmclient']==1){echo '(pending)';}?></div>
							<div class="btn btn-sm <?php if($row2['istransportclient']==0){echo 'btn-danger';} if($row2['istransportclient']==1){echo 'btn-info';} if($row2['istransportclient']==2){echo 'btn-success';} ?>">Transport <?php if($row2['istransportclient']==1){echo '(pending)';}?></div>
							<div class="btn btn-sm <?php if($row2['ismaindouvreclient']==0){echo 'btn-danger';} if($row2['ismaindouvreclient']==1){echo 'btn-info';} if($row2['ismaindouvreclient']==2){echo 'btn-success';} ?>">Main d'ouvre <?php if($row2['ismaindouvreclient']==1){echo '(pending)';}?></div>
						</td>
					</tr>
					<?php
							}*/
					?>
				</table>
			</div>
		</div> -->

		<h3 style="text-shadow:1px 1px 3px #aaa;display: table;" class="phide" id="porte">Portefeuille.EIP</h3>
			<div class="col-lg-3 col-md-3 col-sm-6">
				<div id="msg3">12% d’intérêt annuel payable mensuellement!</div>
			</div>
		<div class="row" id="interest">
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">

	<?php
	function difdays($date1, $date2){
		$dates=date_create($date1);
		$s1= date_format($dates,"Y-m-d");

		$dates=date_create($date2);
		$s2= date_format($dates,"Y-m-d");

		$date1=date_create($s1);
		$date2=date_create($s2);
		$diff=date_diff($date1,$date2);
		return $diff->format("%a");
	}
	$transactions = [];
	$payable_upToNow = 0;
	$sql = "SELECT * from loan where lvpcode='$src' and isloan=0"; 
   	$result = mysql_query($sql, $user_con) or die(mysql_error());
	if (mysql_num_rows($result)>0) {
   		$r = mysql_fetch_assoc($result);

		$sql1 = "SELECT * from transactions where client='$src'"; 
	   	$result1 = mysql_query($sql1, $user_con) or die(mysql_error());
	   	$i=0;
		while ($row = mysql_fetch_array($result1, MYSQL_ASSOC)) {
		    $transactions[$i]=$row; $i++;
		}	   	
		$now = 0;
   		$this_year = date("Y");
   		$this_month = date("m");
	   	$total=0; $payable = 0;
	   	$month_name = ['jan.','fév.','mars','avr.','mai','juin','juil.','aôut','sép.','oct.','nov.','déc.'];
	   	$month_days = ['31','28','31','30','31','30','31','31','30','31','30','31'];
	   	$bkc = ['#666666','#566666','#766666','#466666','#866666','#665666','#667666','#664666','#666656','#666676','#666646','#666686','#566666'];
    							
    	$start_year = date("Y",strToTime($r['invest_date_start']));
    	$month_start = date("m",strToTime($r['invest_date_start']));
    	$day_start = date("d",strToTime($r['invest_date_start']));

    	if($month_start<11){$month_start+=2;}
    	else {
    		if($month_start==11){$month_start=1;$start_year++;}
    		else{ 
    			if($month_start==12){$month_start=2;$start_year++;}
    		}
    	}

    	$annual_year = date("Y",strToTime($r['invest_date_start']));
    	$annual_month = date("m",strToTime($r['invest_date_start']))+1;
    	$capital_year = date("Y",strToTime($r['dateok']));
    	$capital_month = date("m",strToTime($r['dateok']));
    	$capital_day = date("d",strToTime($r['dateok']));
    	$end_year = date("Y",strToTime($r['stop_date']));
    	$end_month = date("m",strToTime($r['stop_date']));
    	$end_day = date("d",strToTime($r['stop_date']));
    	if($end_month<1){$end_month=12;$end_year--;}
    	$total_month = (($end_year-$start_year)*12)+($end_month-$month_start);
    	$interest = $r['interest'];
    	$countYear = $start_year;
    	$countMonth = $month_start;
    	$annuel = 1;
		$break=false;
//echo 'start: '.$start_year.','.$month_start;
    	$pay = 0; $bk=0;
    	$y_interest = 0;
    	$year_for_pay = 0;
    	$capital = $r['amount'];
    	$first_capital = $r['amount'];
    	$count=0;$i=0;
	    $counter = 0;
	    $total=$first_capital;$tmp_countMonth_to=$countMonth;$tmp_countYear_to=$countYear;
    	while($countYear<=$end_year && $countYear<=date("Y")){
    		$j=1;
    		$total_this_year = 0;
			$rep1 = '<table class="table" id="ts'.$i.'" border="1">
					<tr style="background-color: #444;">
						<th>MOIS</th>
						<th>CAPITAL (CA$)</th>
						<th>INTÉRÊT (CA$)</th>
						<th>TOTAL (CA$)</th>
					</tr>';
			$tmp_countYear_from = $countYear;
			$tmp_countMonth_from = $countMonth;
	    	while($j<13){
				$s1=strtotime($capital_year.'-'.$capital_month.'-01');
				$s2=strtotime($countYear.'-'.$countMonth.'-01');
//echo $s1.'<'.$s2.'<br/>';
	    		if($s1<$s2){$counter++;}
	    		if($counter>12){$capital = $total;$annuel++;$counter=1;$bk++;}
    			$pay = ($capital*$interest)/($interest*100);
    			$payable += $pay;

				if(($countYear>=$this_year && $countMonth>$this_month)||($countYear>=$end_year && $countMonth>$end_month))
					{$break=true;break;}	
    			$total += $pay;
    			$total_this_year += $pay; 
    			$payable_upToNow += $pay;

				$rep1.='
					<tr style="font-size:.8em;background-color:'.$bkc[$bk].';">
						<td class="big14pt">01-'.$month_name[$countMonth-1].' '.$countYear.'</td>
						<td class="big14pt" style="text-align:right;margin-right:5px;font-family:Cousine;">+'.number_format($capital,2,","," ").'</td>
						<td class="big14pt" style="text-align:right;margin-right:5px;font-family:Cousine;">+'.number_format($pay,2,","," ").'</td>
						<td class="big14pt" style="text-align:right;margin-right:5px;font-family:Cousine;">'.number_format($total,2,","," ").'</td>
					</tr>';
					for($i=0;$i<sizeof($transactions);$i++) {
						if(date("Y",strToTime($transactions[$i]['date']))==$countYear && date("m",strToTime($transactions[$i]['date']))==$countMonth){
							$dt=date("m",strToTime($transactions[$i]['date']));
			    			if($transactions[$i]['amount']!==0){$total += $transactions[$i]['amount'];}
			    			if($transactions[$i]['capital']!==0){
			    				$capital+=$transactions[$i]['capital'];
								$total += $transactions[$i]['capital'];
			    			}
						$rep1.='
							<tr style="font-size:.8em;background-color:'.$bkc[$bk].';">
								<td class="big14pt">'.$capital_day.'-'.$month_name[$dt-1].' '.$countYear.'</td>
								<td></th>
								<td class="big14pt" style="text-align: right;margin-right:5px;font-family:Cousine;">';
						$payable_upToNow +=$transactions[$i]['amount'];	
						if($transactions[$i]['amount']!=='0'){if($transactions[$i]['amount']>'0'){$rep1.='+';}$rep1.=number_format($transactions[$i]['amount'],2,","," ");}
						if($transactions[$i]['capital']!=='0'){$rep1.='(CAP.) ';if($transactions[$i]['capital']>'0'){$rep1.='+';}$rep1.=number_format($transactions[$i]['capital'],2,","," ");$bk++;if($bk>12){$bk=0;}}
						$rep1.='</td>
								<td style="text-align: right;margin-right: 5px;font-family:Cousine;" class="big14pt">'.number_format($total,2,","," ").'</td>
							</tr>';
						}
					}
				$countMonth++;
				$tmp_countYear_to = $countYear;
				$tmp_countMonth_to = $countMonth-1;
				if($countMonth>12){$countMonth=1;$countYear++;}
				if($countMonth>$end_month && $countYear>=$end_year){$break=true;break;}
				$j++;
			}
			$rep = '<table class="table" id="y'.$i.'">
						<tr style="background-color: #eee; color: #222;">
						<th class="big14pt" style="qwidth: 15%;font-size:1em;"><i class="fa fa-chevron-circle-down phide" aria-hidden="true" style="margin-right:10px;font-size:1.5em;"></i>'.$month_name[$tmp_countMonth_from-1].' '.$tmp_countYear_from.' à '.$month_name[$tmp_countMonth_to-1].' '.$tmp_countYear_to.'</th>
						<th style="width:40%;">Cumulatif Ann. '.number_format($total_this_year,2,","," ").' $</th>
						<th>Total: '.number_format($total,2,","," ").' $</th>
						<th></th>
					</tr></table>'.$rep1.'</table>';

			$now++;
			echo $rep;
			$year_for_pay++;
			$i++;
			if($break){break;}
		}
							
						//include('invest_rep.php');
			$tmp=$month_start-2;
			$tmp1=$end_month-2;
				echo '</table> 
				<table class="table">
					<tr style="background-color: #eee; color: #222;width:100%;"><th>Compte</th></tr>
					<tr style="background-color: #5cb85c; color: #012; font-size: .8em; text-shadow:none;"><td style="padding-left:3em;"  class="big14pt">'.$day_start.'-'.$month_name[$tmp].' '.$start_year.' à '.$month_days[$tmp1].'-'.$month_name[$tmp1].' '.$end_year.'</td></tr>
					<tr style="background-color: #5cb85c; color: #012; font-size: .8em; text-shadow:none;"><td class="big14pt" style="padding-left:3em;">Total : '.number_format($total,2,","," ").' CA$&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Payable: '.number_format($payable_upToNow,2,","," ").' CA$</td></tr>
					<tr style="background-color: #5cb85c; color: #012; font-size: .8em; text-shadow:none;"><td class="big14pt" style="padding-left:3em;">Intérêt : '.$interest.'%</td></tr>
					
				</table>';
    }
				$sql = "UPDATE loan SET payable=$payable_upToNow, lastupdate=NOW() where lvpcode='$src'";
				$result = mysql_query($sql, $user_con) or die(mysql_error());

					?>

				</table>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 phide">
				<div style="margin-top:15%;">
<!--					<a id="payme" class="btn btn-md btn-success my-button">demande de paiement</a> -->
					<a href="refer.php" class="btn btn-md btn-success my-button">Crée son capital</a>
					<div class="checkbox" id="reno5ans">
					<!--	<label style="color: white;"><?php if(isset($r['reno5y']) && $r['reno5y']){echo '<i class="fa fa-check-circle-o" aria-hidden="true" style="font-size:1.3em;"></i>';}else{echo '<i class="fa fa-circle-o" aria-hidden="true"></i>';}?>&nbsp;Renouveler 5 ans</label> -->
						<div id="msg5">Tél: 1 (888) 368-8949<a class="boxclose"></a></div>
					</div>
					<div class="checkbox" id="payMonth">
					<label style="color: white;"><?php if(isset($r['pay_monthly']) && $r['pay_monthly']){echo '<i class="fa fa-check-circle-o" aria-hidden="true"></i>';}else{echo '<i class="fa fa-circle-o" aria-hidden="true"></i>';}?>&nbsp;Payable mensuellement</label>
						<div id="msg4">Tél: 1 (888) 368-8949<a class="boxclose"></a></div>
					</div>
					<a href="refer.php?i=i" class="btn btn-md btn-success my-button">Devenez prêteur privé</a>
					<a class="btn btn-md btn-success my-button">Liste de transactions</a>
				</div>
			</div>
		</div>


	</div>

</section>


<section style="background-color:#aaa;color:#222;padding: 10px 10px 15px;" class="phide"><span id="qq1"></span>
<div class="row">
  	<div class="col-xs-4 col-xs-offset-4">
	<h3 style="text-align:center;">Raccourci internet</h3>
    <div class="form-group">
      <select class="selectpicker form-control" id="links">
		    <option><a href="">Select your favorite websites</a></option>
		  <optgroup label="Moteur de recherche" data-max-options="1">
		    <option value="http://www.google.com">Google</option>
		    <option value="http://www.yahoo.com">Yahoo</a></option>
		  </optgroup>
		  <optgroup label="Système de messagerie" data-max-options="1">
		    <option value="http://mail.yahoo.com">Mail.Yahoo</option>
		    <option value="http://mail.google.com">Mail.Google</option>
		  </optgroup>
		  <optgroup label="Nouvelles" data-max-options="1">
		    <option value="">CBC</option>
		    <option value="">TVA</option>
		    <option value="">FOX</option>
		  </optgroup>
		  <optgroup label="SPORTS" data-max-options="1">
		    <option value="">Hockey</option>
		    <option value="">Football</option>
		    <option value="">Soccer</option>
		    <option value="">Golf</option>
		  </optgroup>
      </select>
    </div>
  </div>
</div>
</section>
<?php	
}
else{
	header('location:login.php');
}
?>
<script type="text/javascript">
months = ['January','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'];
$(document).ready(function() {

	$('#memberbox').hide();
	$('#loanbox').hide();
	$('#msg1').hide();
	$('#msg2').hide();
	$('#msg3').hide();
	$('#msg4').hide();
	$('#msg5').hide();
	$("table[id^='ts']").hide();

    $(".boxclose").click(function () {
        if ($('#msg1').is(':visible')) {
            $('#msg1').css("visibility:hidden");
            $('#msg1').fadeOut(500);
        }
        if ($('#msg2').is(':visible')) {
            $('#msg2').css("visibility:hidden");
            $('#msg2').fadeOut(500);
        }
        if ($('#msg4').is(':visible')) {
            $('#msg4').css("visibility:hidden");
            $('#msg4').fadeOut(500);
        }
    });
    $("#referMember").click(function () {
        if ($('#msg1').is(':hidden')) {
            $('#msg1').css("visibility:visible");
            $('#msg1').fadeIn(600);
        }
        if ($('#msg2').is(':visible')) {
            $('#msg2').css("visibility:hidden");
            $('#msg2').fadeOut(500);
        }
    });
    $("#req1").click(function () {
        if ($('#msg2').is(':hidden')) {
            $('#msg2').css("visibility:visible");
            $('#msg2').fadeIn(600);
        }
        if ($('#msg1').is(':visible')) {
            $('#msg1').css("visibility:hidden");
            $('#msg1').fadeOut(500);
        }
    });

	$('#links').change( function(){
	        window.open($(this).val(),'_blank');
	});

    $("#porte").mouseover(function () {
        if ($('#msg3').is(':hidden')) {
            $('#msg3').css("visibility:visible");
            $('#msg3').fadeIn(100);
        }
    });
    $("#porte").mouseout(function () {
        if ($('#msg3').is(':visible')) {
            $('#msg3').css("visibility:hidden");
            $('#msg3').fadeOut(400);
        }
    });

    $("#payMonth").click(function () {
        if ($('#msg4').is(':visible')) {
            $('#msg4').css("visibility:hidden");
            $('#msg4').fadeOut(200);
        }
        if ($('#msg4').is(':hidden')) {
            $('#msg4').css("visibility:visible");
            $('#msg4').fadeIn(500);
        }
    });

    $("#reno5ans").click(function () {
        if ($('#msg5').is(':visible')) {
            $('#msg5').css("visibility:hidden");
            $('#msg5').fadeOut(200);
        }
        if ($('#msg5').is(':hidden')) {
            $('#msg5').css("visibility:visible");
            $('#msg5').fadeIn(500);
        }
    });

    $("table[id^=y").click(function () {
        $(this).next().slideToggle("slow",function(){$(this).prev().find("i").toggleClass("fa-chevron-circle-down").toggleClass("fa-times-circle-o")})
    });

	var d = new Date();
	var thisMonth = d.getMonth();
	var thisYear = d.getFullYear();
/*	for(i=1;i<13;i++){
		$('#mnt'+i+'lb').text(months[thisMonth]+'-'+thisYear);
		$('select').append($('<option>', {value:months[thisMonth]+'-'+thisYear, text:months[thisMonth]+'-'+thisYear}));
		thisMonth++;
		if(thisMonth > 11){thisMonth=0;thisYear+=1;}
		$('#mnt'+i).attr('checked', true);
		$('#12mp').html('(80.<sup>43</sup> $/mois)');
	}*/

});

function favoLinks(){

}
/*
function startDateCahnged(){
	e = document.getElementById('startdate').value;
	var d = new Date();
	var n = d.getMonth();
	dt = d.getFullYear().toString();
	monthSel = e[0]+e[1]+e[2]+e[3];
	var monthSelected = 0;
	switch (monthSel){
		case 'Janu': monthSelected = 0; break;
		case 'Fevr': monthSelected = 1; break;
		case 'Mars': monthSelected = 2; break;
		case 'Avri': monthSelected = 3; break;
		case 'Mai-': monthSelected = 4; break;
		case 'Juin': monthSelected = 5; break;
		case 'Juil': monthSelected = 6; break;
		case 'Aout': monthSelected = 7; break;
		case 'Sept': monthSelected = 8; break;
		case 'Octo': monthSelected = 9; break;
		case 'Nove': monthSelected = 10; break;
		case 'Dece': monthSelected = 11; break;
	}
	yearSelected = Number(e[e.length-4]+e[e.length-3]+e[e.length-2]+e[e.length-1]);
	for(i=0;i<12;i++){
		mnt1[i]=months[monthSelected]+"-"+yearSelected.toString();
		monthSelected++;
		if(monthSelected>11){monthSelected=0;yearSelected++;}
	}
	document.getElementById("mnt1lb").innerHTML = mnt1[0];
	document.getElementById("mnt2lb").innerHTML = mnt1[1];
	document.getElementById("mnt3lb").innerHTML = mnt1[2];
	document.getElementById("mnt4lb").innerHTML = mnt1[3];
	document.getElementById("mnt5lb").innerHTML = mnt1[4];
	document.getElementById("mnt6lb").innerHTML = mnt1[5];
	document.getElementById("mnt7lb").innerHTML = mnt1[6];
	document.getElementById("mnt8lb").innerHTML = mnt1[7];
	document.getElementById("mnt9lb").innerHTML = mnt1[8];
	document.getElementById("mnt10lb").innerHTML = mnt1[9];
	document.getElementById("mnt11lb").innerHTML = mnt1[10];
	document.getElementById("mnt12lb").innerHTML = mnt1[11];

	document.getElementById("mnt1").value = mnt1[0];
	document.getElementById("mnt2").value = mnt1[1];
	document.getElementById("mnt3").value = mnt1[2];
	document.getElementById("mnt4").value = mnt1[3];
	document.getElementById("mnt5").value = mnt1[4];
	document.getElementById("mnt6").value = mnt1[5];
	document.getElementById("mnt7").value = mnt1[6];
	document.getElementById("mnt8").value = mnt1[7];
	document.getElementById("mnt9").value = mnt1[8];
	document.getElementById("mnt10").value = mnt1[9];
	document.getElementById("mnt11").value = mnt1[10];
	document.getElementById("mnt12").value = mnt1[11];
}	
function mnChCount(){
	var i=0;
	if(document.getElementById('mnt1').checked){i++;}
	if(document.getElementById('mnt2').checked){i++;}
	if(document.getElementById('mnt3').checked){i++;}
	if(document.getElementById('mnt4').checked){i++;}
	if(document.getElementById('mnt5').checked){i++;}
	if(document.getElementById('mnt6').checked){i++;}
	if(document.getElementById('mnt7').checked){i++;}
	if(document.getElementById('mnt8').checked){i++;}
	if(document.getElementById('mnt9').checked){i++;}
	if(document.getElementById('mnt10').checked){i++;}
	if(document.getElementById('mnt11').checked){i++;}
	if(document.getElementById('mnt12').checked){i++;}
	return i;
}
function m12checked(){
	document.getElementById('m12').checked = true;
	document.getElementById('12mp').innerHTML='(80.<sup>43</sup> $/mois)';

	document.getElementById('6mp').innerHTML = '';
	document.getElementById('3mp').innerHTML = '';

	document.getElementById("mnt1").checked = true;
	document.getElementById("mnt2").checked = true;
	document.getElementById("mnt3").checked = true;
	document.getElementById("mnt4").checked = true;
	document.getElementById("mnt5").checked = true;
	document.getElementById("mnt6").checked = true;
	document.getElementById("mnt7").checked = true;
	document.getElementById("mnt8").checked = true;
	document.getElementById("mnt9").checked = true;
	document.getElementById("mnt10").checked = true;
	document.getElementById("mnt11").checked = true;
	document.getElementById("mnt12").checked = true;
}

function m6checked(){
	document.getElementById('m6').checked = true;
	document.getElementById('6mp').innerHTML='(160.<sup>85</sup> $/mois)';

	document.getElementById('12mp').innerHTML = '';
	document.getElementById('3mp').innerHTML = '';

	document.getElementById("mnt1").checked = true;
	document.getElementById("mnt2").checked = true;
	document.getElementById("mnt3").checked = true;
	document.getElementById("mnt4").checked = true;
	document.getElementById("mnt5").checked = true;
	document.getElementById("mnt6").checked = true;
	document.getElementById("mnt7").checked = false;
	document.getElementById("mnt8").checked = false;
	document.getElementById("mnt9").checked = false;
	document.getElementById("mnt10").checked = false;
	document.getElementById("mnt11").checked = false;
	document.getElementById("mnt12").checked = false;

	document.getElementById("mnt7").value = '';	
	document.getElementById("mnt8").value = '';	
	document.getElementById("mnt9").value = '';	
	document.getElementById("mnt10").value = '';	
	document.getElementById("mnt11").value = '';	
	document.getElementById("mnt12").value = '';	
}

function m3checked(){
	document.getElementById('m3').checked = true;
	document.getElementById('3mp').innerHTML='(321.<sup>70</sup> $/mois)';

	document.getElementById('12mp').innerHTML = '';
	document.getElementById('6mp').innerHTML = '';
	document.getElementById("mnt1").checked = true;
	document.getElementById("mnt2").checked = true;
	document.getElementById("mnt3").checked = true;
	document.getElementById("mnt4").checked = false;
	document.getElementById("mnt5").checked = false;
	document.getElementById("mnt6").checked = false;
	document.getElementById("mnt7").checked = false;
	document.getElementById("mnt8").checked = false;
	document.getElementById("mnt9").checked = false;
	document.getElementById("mnt10").checked = false;
	document.getElementById("mnt11").checked = false;
	document.getElementById("mnt12").checked = false;

	document.getElementById("mnt4").value = '';	
	document.getElementById("mnt5").value = '';	
	document.getElementById("mnt6").value = '';	
	document.getElementById("mnt7").value = '';	
	document.getElementById("mnt8").value = '';	
	document.getElementById("mnt9").value = '';	
	document.getElementById("mnt10").value = '';	
	document.getElementById("mnt11").value = '';	
	document.getElementById("mnt12").value = '';	
}

function payMnt(x){
	if(document.getElementById('m12').checked && mnChCount()<12){
		document.getElementById('mnt'+x).checked = true;
	}
	else 
		if(document.getElementById('m6').checked && mnChCount()<6){
			document.getElementById('mnt'+x).checked = true;
		}
		else 
			if(document.getElementById('m3').checked && mnChCount()<3){
				document.getElementById('mnt'+x).checked = true;
			}

	if(document.getElementById('mnt1').checked){document.getElementById('mnt1').value = mnt1[0];}
	else{document.getElementById('mnt1').value = '';}	
	if(document.getElementById('mnt2').checked){document.getElementById('mnt2').value = mnt1[1];}
	else{document.getElementById('mnt2').value = '';}	
	if(document.getElementById('mnt3').checked){document.getElementById('mnt3').value = mnt1[2];}
	else{document.getElementById('mnt3').value = '';}	
	if(document.getElementById('mnt4').checked){document.getElementById('mnt4').value = mnt1[3];}
	else{document.getElementById('mnt4').value = '';}	
	if(document.getElementById('mnt5').checked){document.getElementById('mnt5').value = mnt1[4];}
	else{document.getElementById('mnt5').value = '';}	
	if(document.getElementById('mnt6').checked){document.getElementById('mnt6').value = mnt1[5];}
	else{document.getElementById('mnt6').value = '';}	
	if(document.getElementById('mnt7').checked){document.getElementById('mnt7').value = mnt1[6];}
	else{document.getElementById('mnt7').value = '';}	
	if(document.getElementById('mnt8').checked){document.getElementById('mnt8').value = mnt1[7];}
	else{document.getElementById('mnt8').value = '';}	
	if(document.getElementById('mnt9').checked){document.getElementById('mnt9').value = mnt1[8];}
	else{document.getElementById('mnt9').value = '';}	
	if(document.getElementById('mnt10').checked){document.getElementById('mnt10').value = mnt1[9];}
	else{document.getElementById('mnt10').value = '';}	
	if(document.getElementById('mnt11').checked){document.getElementById('mnt11').value = mnt1[10];}
	else{document.getElementById('mnt11').value = '';}	
	if(document.getElementById('mnt12').checked){document.getElementById('mnt12').value = mnt1[11];}
	else{document.getElementById('mnt12').value = '';}	
}
*/
</script>
</body>