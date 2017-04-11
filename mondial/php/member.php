<?php
session_start();
$valid = false;
$bdl = 0;
?>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>EIP - <?php
	    include('connect.php');
		if(isset($_SESSION["vpcode"])){echo $_SESSION["vpcode"];}
		else {if(isset($_GET["nvp"])){echo 'New member';} $_SESSION["vpcode"] = 'VP001';}?>
	</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../grayscale.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="../img/icon32.png">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
	body{
		background-color: #feffff;
		padding-top: 0;
	}
	body section{
		color:#222;
		padding-bottom: 20px;
		font: 16px/16px lora;
	}
	body section .container{
		padding:10px 0;
	}
	section .container img{
		left:35%;
		position:relative;
	}
	h3{
		text-align: center;
		font: 1.8em/2em Montserrat;
		font-weight: 700;
	}
	h4{
		text-align: center;
		text-shadow: 0 0 3px black;
	}
	.req{
		font-size: 1.5em;
		font-weight: 700;
	}
	.req label{
		margin: 0 auto;
		display: table;
	}
	#newPvForm{
		border:4px groove #999;
		padding: 1em;
		width: 100%;
	}
	#invest_price, #memberbox{
		margin: 1.5em 1em;
		box-sizing: border-box;
		border: 1px solid #999;
	}
	#memberbox{
		padding: .1em 1em;
	}
	#invest_price label, #memberbox label{
		margin: 5px auto;
		display: table;
		font-size: 1.3em;
		font-weight: 400;
	}
	.membertype{
		margin-top: 1.5em;
		display: table;
	}
	.membertype label{
		line-height: 1.25em; 
	}
	.membertype label s{
		font-size: .7em;
		color: #888;
	}
	.membertype label span{
		font-size: .9em;
		margin-left: .5em;
	}
	.membertype p{
		font:.95em/1.2em lora;
	}
	.infoform{
		margin: 2.5em 1em 1.5em;
		border: 1px solid #999;
		padding: .5em;
		box-sizing: border-box;
	}
	.infoform > div{
		margin-bottom: 1.5em;
	}
	.soussig{
		font:.8em/1.2em lora;
		margin:5px 1em 1.5em;
	}
	.month-pays{
		margin: .5em 2em 2em;
	}
	.month-pays div{
		padding: 0;
		box-sizing: border-box;
	}
	.month-pays label{
		display: inline;
		width: 100%;
	}
	.month-pays span{
		text-shadow: 0 0 1px black;
		font-size: .8em;
		display: inline;
	}
	.stMonth{
		margin-bottom: 1em;
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
	.lsmonth{
		margin-bottom: 1em;
	}
	.lsmonth .btn-default{
		color: #333;	
		border: none;	
		background-color: rgba(0,0,0,0);
	}
	.lsmonth span[id$="lb"]{
		font: .9em/1em lora;		
	}
	#startdate .form-control{
		font-size: 1.2em;
	}
	</style>
</head>

<?php
$errMsg='';
if(isset($_GET["nvp"])){$_SESSION["vpcode"]='vp001';}
if(!isset($_POST["membersuivant1"])){
	$formdata['requesttype'] = 'V.P';
	if(isset($_POST['invest_price'])){$formdata['invest_price'] = $_POST['invest_price'];}else{$formdata['invest_price']=0;};
}
else{
	$formdata['requesttype'] = htmlspecialchars(stripslashes(trim($_POST['requesttype'])));
	$formdata['name'] = htmlspecialchars(stripslashes(trim($_POST['name'])));
	$formdata['famil'] = htmlspecialchars(stripslashes(trim($_POST['famil'])));
	$formdata['adress'] = htmlspecialchars(stripslashes(trim($_POST['adress'])));
	$formdata['city'] = htmlspecialchars(stripslashes(trim($_POST['city'])));
	$formdata['province'] = $_POST['province'];
	$formdata['postal'] = htmlspecialchars(stripslashes(trim($_POST['postal'])));
	$formdata['email'] = $_POST['email'];
	$em = $formdata['email'];
	$sql = "SELECT id FROM users where email='$em'"; 
	$result = mysql_query($sql, $user_con) or die(mysql_error());
	if(mysql_num_rows($result)){$errMsg='This Email is already registered!';}
	$formdata['phone'] = $_POST['phone1'];
	$formdata['username'] = $formdata['name'].'.'.$formdata['famil'].'@eipmondial.com';
	$formdata['password'] = $_POST['passw'];
	if(isset($_POST['demandfin'])){$formdata['demandfin'] = true;}else{$formdata['demandfin'] = false;};
	$formdata['referredby'] = $_POST['vp'];
	$formdata['today'] = $_POST['today'];
	$formdata['startmonth'] = $_POST['startdate'];
	if($formdata['requesttype']=='Investor'){
		$formdata['invest_price'] = $_POST['invest_price'];
		$formdata['cltype'] = 2;
		$formdata['dure'] = 0;
		$formdata['mnt'][0]='';
		$formdata['mnt'][1]='';
		$formdata['mnt'][2]='';
		$formdata['mnt'][3]='';
		$formdata['mnt'][4]='';
		$formdata['mnt'][5]='';
		$formdata['mnt'][6]='';
		$formdata['mnt'][7]='';
		$formdata['mnt'][8]='';
		$formdata['mnt'][9]='';
		$formdata['mnt'][10]='';
		$formdata['mnt'][11]='';
		$formdata['demandfin']='';
	}
	else{
		if($formdata['requesttype']=='Membre'){
			$formdata['membrtype'] = $_POST['membrtype'];
			$formdata['dure'] = $_POST['dure'];
			if($formdata['membrtype']=='v1'){$formdata['invest_price'] = 1450;}
			else{
				if($formdata['dure']=='3'){$formdata['invest_price'] = 321.7;}
				if($formdata['dure']=='6'){$formdata['invest_price'] = 160.85;}
				if($formdata['dure']=='12'){$formdata['invest_price'] = 80.43;}
			}
			$formdata['demandfin'] = $_POST['demandfin'];
			$formdata['cltype'] = 3;}
		else{
			$formdata['membrtype'] = 'V.P';
			$formdata['dure'] = 0;
			$formdata['cltype'] = 3;		
		}
	}
	if(isset($_POST['mnt'][0])){$formdata['mnt'][0] = $_POST['mnt'][0];}else{$formdata['mnt'][0]='';}
	if(isset($_POST['mnt'][1])){$formdata['mnt'][1] = $_POST['mnt'][1];}else{$formdata['mnt'][1]='';}
	if(isset($_POST['mnt'][2])){$formdata['mnt'][2] = $_POST['mnt'][2];}else{$formdata['mnt'][2]='';}
	if(isset($_POST['mnt'][3])){$formdata['mnt'][3] = $_POST['mnt'][3];}else{$formdata['mnt'][3]='';}
	if(isset($_POST['mnt'][4])){$formdata['mnt'][4] = $_POST['mnt'][4];}else{$formdata['mnt'][4]='';}
	if(isset($_POST['mnt'][5])){$formdata['mnt'][5] = $_POST['mnt'][5];}else{$formdata['mnt'][5]='';}
	if(isset($_POST['mnt'][6])){$formdata['mnt'][6] = $_POST['mnt'][6];}else{$formdata['mnt'][6]='';}
	if(isset($_POST['mnt'][7])){$formdata['mnt'][7] = $_POST['mnt'][7];}else{$formdata['mnt'][7]='';}
	if(isset($_POST['mnt'][8])){$formdata['mnt'][8] = $_POST['mnt'][8];}else{$formdata['mnt'][8]='';}
	if(isset($_POST['mnt'][9])){$formdata['mnt'][9] = $_POST['mnt'][9];}else{$formdata['mnt'][9]='';}
	if(isset($_POST['mnt'][10])){$formdata['mnt'][10] = $_POST['mnt'][10];}else{$formdata['mnt'][10]='';}
	if(isset($_POST['mnt'][11])){$formdata['mnt'][11] = $_POST['mnt'][11];}else{$formdata['mnt'][11]='';}
	$formdata['vp'] = $_POST['vp'];
	$formdata['refno'] = isset($_POST['refno'])?$_POST['refno']:'VP001';
	$formdata['today'] = $_POST['today'];
	$mm = date('Y').date('m');
	//$formdata['strdemandy'] = isset($_POST['payments'])?$_POST['payments']:$m;
	$valid = true;
	if($valid && !$errMsg){
		$_SESSION['formdata'] = $formdata;
		header('location:member2.php');
	}
}
?>

<body onload="init()">
<section>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
				<img src="../img/eip_new_logo.png" width="25%">
			</div>
		</div>
		<h3>S'INSCRIRE</h3>
		<form id="newPvForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="row req">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<!--		<label class="radio-inline">
						<input type="radio" name="requesttype" value="Investor" id="req2" onclick="membreClicked('invest')" <?php if($formdata['requesttype']=='Investor'){echo 'checked="checked"';} ?>/> Investiseur
					</label>	-->
				</div>
		<!--		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label class="radio-inline ">
						<input type="radio" name="requesttype" onclick="membreClicked('membre')" value="Membre" <?php if($formdata['requesttype']=='Membre'){echo 'checked="checked"';} ?> id="req1"/> Membre
					</label> 
				</div>  -->
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label class="radio-inline ">
						<input type="radio" name="requesttype" value="V.P" <?php if($formdata['requesttype']=='V.P'){echo 'checked="checked"';} ?> id="req3"/> V.P
					</label>
				</div>
			</div>
			<!-- ======================================  INVEST PRICE =========================================  -->
			<div id="invest_price" class="row">
<!--				<h4>Investiseur</h4>
		        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
		            <label class="control-label">
		                <input type="radio" name="invest_price" value="25 000" id="invest_price1" checked="checked" /> 25 000$
		            </label>
		        </div>
		        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
		            <label class="control-label">
		                <input type="radio" name="invest_price" value="50 000" id="invest_price2" /> 50 000$
		            </label>
		        </div>
		        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
		            <label class="control-label">
		                <input type="radio" name="invest_price" value="75 000" id="invest_price3" /> 75 000$
		            </label>
		        </div>
		        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
		            <label class="control-label">
		                <input type="radio" name="invest_price" value="100 000" id="invest_price4" /> 100 000$
		            </label>
		        </div>
		        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
		            <label class="control-label">
		                <input type="radio" name="invest_price" value="125 000" id="invest_price1"/> 125 000$
		            </label>
		        </div>
		        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
		            <label class="control-label">
		                <input type="radio" name="invest_price" value="150 000" id="invest_price1"/> 150 000$
		            </label>
		        </div>
		        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
		            <label class="control-label">
		                <input type="radio" name="invest_price" value="175 000" id="invest_price1"/> 175 000$
		            </label>
		        </div>
		        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
		            <label class="control-label">
		                <input type="radio" name="invest_price" value="200 000" id="invest_price1"/> 200 000 $
		            </label>
		        </div>  -->
		    </div>
			<!-- ======================================  MEMBER BOX =========================================  -->
			<div id="memberbox" class="row">
<!--				<h4>Membre</h4>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<label onClick="demandCh()"><input type="checkbox" name="demandfin" id="demand"> Demande de financement</label>
				</div>
	
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 membertype" onclick="membrech('membe1')">
						<label class="radio-inline ">
							<input type="radio" name="membrtype" value="v1" checked="checked" id="membe1"/> ADHÉSION VIE E.I.P.Mondial<br/><span>(<s>1 650,<sup>00</sup>$</s>&nbsp;1 450,<sup>00</sup>&nbsp;$+taxes)</span>
						</label>
						<p>
						Numéro membre V.P. E.I.P Mondial<br/>
						Kit personnalisé<br/>
						Certificat garanti sceau E.I.P. avec numéro de membre<br/>
						Votre première Charte de point fidélité<br/>
						1 contrat numéroté selon le certificat<br/>
						Login au bureau virtuel personnalisé<br/>
						10 kits de présentation avec contrat (règle s’applique si financé)<br/>
						Courriel personnalisé<br/>
						100 carte personalisés<br/>
						Domaine personnalisé<br/>
						</p>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 membertype" onclick="membrech('membe2')">
						<label class="radio-inline">
							<input type="radio" name="membrtype" value="v2" id="membe2" checked="checked" /> Membre E.I.P. Mondial<br/>(839,<sup>40</sup>&nbsp;$+taxes)
						</label>
						<p>
						Numéro membre V.P. E.I.P Mondial<br/>
						1-Kit personnalisé<br/>
						Certificat garanti sceau E.I.P. avec numéro de membre<br/>
						1-contrat numéroté selon de votre numéro V.P.<br/>
						Login au bureau virtuel personnalisé<br/>
						</p>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 membertype">
						<label>Profitez aussi de:</label>
						<p>
						50% sur nos frais de services<br/>
						Rabais exclusif dans nos magasins participant<br/>
						Program de points P.F.P<br/>
						</p>
					</div>
				</div>

	            <div class="row month-pays">
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="12mpnot">
				        <label class="radio-inline">
				            <input type="radio" name="dure" value="12" id="m12" checked="checked" onclick="m12checked()"/> 12 Mois <span id="12mp"></span>
				        </label>
				    </div>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="6mpnot">
				        <label class="radio-inline">
				            <input type="radio" name="dure" value="6" id="m6" onclick="m6checked()"/> 6 Mois <span id="6mp"></span>
				        </label>
			        </div>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="3mpnot">
				        <label class="radio-inline">
				            <input type="radio" name="dure" value="3" id="m3" onclick="m3checked()"/> 3 Mois <span id="3mp"></span>
				        </label>
				    </div>
				</div>

				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 stmonth">
					    <div class="form-group">
							<label for="startdate">Date de début</label>
							<select id="startdate" name="startdate" onchange="startDateCahnged()" class="selectpicker show-tick form-control" data-width="auto"></select>
						</div>
					</div>
					<div class="col-lg-9 col-md-9 col-sm-8"></div>
				</div>

				<div class="row lsmonth" id="lsmonth">	
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt1" class="btn btn-default"><span id="mnt1lb"></span><input onclick="payMnt(1)" type="checkbox" id="mnt1" name="mnt[]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt2" class="btn btn-default"><span id="mnt2lb"></span><input onclick="payMnt(2)" type="checkbox" id="mnt2" name="mnt[]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt3" class="btn btn-default"><span id="mnt3lb"></span><input onclick="payMnt(3)" type="checkbox" id="mnt3" name="mnt[]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt4" class="btn btn-default"><span id="mnt4lb"></span><input onclick="payMnt(4)" type="checkbox" id="mnt4" name="mnt[]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt5" class="btn btn-default"><span id="mnt5lb"></span><input onclick="payMnt(5)" type="checkbox" id="mnt5" name="mnt[]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt6" class="btn btn-default"><span id="mnt6lb"></span><input onclick="payMnt(6)" type="checkbox" id="mnt6" name="mnt[]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt7" class="btn btn-default"><span id="mnt7lb"></span><input onclick="payMnt(7)" type="checkbox" id="mnt7" name="mnt[]" class="badgebox"><span class="badge">&check;</span></label>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
						<label for="mnt8" class="btn btn-default"><span id="mnt8lb"></span><input onclick="payMnt(8)" type="checkbox" id="mnt8" name="mnt[]" class="badgebox"><span class="badge">&check;</span></label>
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
-->
			</div>
			<!-- ======================================  INFORMATION FORM =========================================  -->
			<div class="row infoform">
	            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	                <label class="control-label">Pr&eacute;nom</label>
	                <input type="text" class="form-control" name="name" required="required" value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>"/>
	            </div>			
	            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	                <label class="control-label">Nom</label>
	                <input type="text" class="form-control" name="famil" required="required" value="<?php if(isset($_POST['famil'])){echo $_POST['famil'];} ?>"/>
	            </div>
	            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	                <label class="control-label">Adresse</label>
	                <input type="text" class="form-control" name="adress" required="required" value="<?php if(isset($_POST['adress'])){echo $_POST['adress'];} ?>"/>
	            </div>
	            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	                <label class="control-label">Ville</label>
	                <input type="text" class="form-control" name="city" required="required" value="<?php if(isset($_POST['city'])){echo $_POST['city'];} ?>"/>
	            </div>
	            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 selectContainer">
	                <label class="control-label">Province</label>
	                <select class="form-control" name="province">
	                    <option value="Quebec">Qu&eacute;bec</option>
	                    <option value="Ontario">Ontario</option>
	                    <option value="Nova Scotia">Nova Scotia</option>
	                    <option value="New Brunswick">New Brunswick</option>
	                    <option value="manitoba">Manitoba</option>
	                    <option value="British Columbia">British Columbia</option>
	                    <option value="Prince Edward Island">Prince Edward Island</option>
	                    <option value="Saskatchewan">Saskatchewan</option>
	                    <option value="Alberta">Alberta</option>
	                    <option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
	                </select>
	            </div>
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	                <label class="control-label">Code postal</label>
	                <input type="text" class="form-control" name="postal" required="required" maxlength="7" value="<?php if(isset($_POST['postal'])){echo $_POST['postal'];} ?>"/>
	            </div>
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	                <label class="control-label">Numéro de téléphone</label>
	                <input type="text" class="form-control" name="phone1" required="required" value="<?php if(isset($_POST['phone1'])){echo $_POST['phone1'];} ?>"/>
	            </div>
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	                <label class="control-label">adresse courriel</label>
	                <input type="email" class="form-control" name="email" required="required" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>"/>
	            </div>
	            <div class="row">
		            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-lg-offset-4 col-md-offset-4 col-sm-offset-4">
		                <label class="control-label">Mot de passe (min. 5 lettres)</label>
		                <input type="password" minlength="5" class="form-control" name="passw" required="required"/>
		            </div>
	            </div>

				<p class="soussig">Je soussigné comprends atteste les règlements plus bas et respecte les exigences et les normes de E.I.P Mondial inc. Le présent contrat constitue l’entière convention entre les parties, qui reconnaissent la nullité de toutes représentations ou modifications à moins de confirmation de l’autre partie.
				</p>
		        <div class="row">
					<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
						<label>VP#</label>
						<input type="text" class="form-control" name="vp" readonly="readonly" value="<?php echo $_SESSION["vpcode"]; ?>"/>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
						<label>Date</label>
						<input type="text" class="form-control" name="today" readonly="readonly" value="<?php echo date("Y-m-d H:i"); ?>"/>
					</div>
				</div>
		    <span style="color:#ff3333;font-size:1.1em;"><?php echo $errMsg; ?></span>
			</div>


		    <button type="submit" name="membersuivant1" class="btn btn-info" style="margin-left:20px;margin-right: 10px;display: inline;">Suivant <span class="fa fa-angle-double-right"></span></button>     
		    <a style="display: inline;" href="../../" class="btn btn-default">Annuler</a>

		</form>

<!-- =======================MEMBER========================== -->
<!--	
<?php
	$yr = date('Y');
	$mn = date('m');
	$dy = date('d');
	$mnt=array('January','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre');
?>
<!--
        <div class="row" style="margin-top:20px;">
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="mnth1">
				<label id="pay1lb" onMouseUp="payMnt1()"></label>&nbsp;<input id="pay1" type="checkbox" name="demand1" onChange="payMnt1()" checked="checked">
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="mnth2">
				<label id="pay2lb" onMouseUp="payMnt2()"></label>&nbsp;<input id="pay2" type="checkbox" name="demand2" onChange="payMnt2()">
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="mnth3">
				<label id="pay3lb" onMouseUp="payMnt3()"></label>&nbsp;<input id="pay3" type="checkbox" name="demand3" onChange="payMnt3()">
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="mnth4">
				<label id="pay4lb" onMouseUp="payMnt4()"></label>&nbsp;<input id="pay4" type="checkbox" name="demand4" onChange="payMnt4()">
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="mnth5">
				<label id="pay5lb" onMouseUp="payMnt5()"></label>&nbsp;<input id="pay5" type="checkbox" name="demand5" onChange="payMnt5()">
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="mnth6">
				<label id="pay6lb" onMouseUp="payMnt6()"></label>&nbsp;<input id="pay6" type="checkbox" name="demand6" onChange="payMnt6()">
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="mnth7">
				<label id="pay7lb" onMouseUp="payMnt7()"></label>&nbsp;<input id="pay7" type="checkbox" name="demand7" onChange="payMnt7()">
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="mnth8">
				<label id="pay8lb" onMouseUp="payMnt8()"></label>&nbsp;<input id="pay8" type="checkbox" name="demand8" onChange="payMnt8()">
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="mnth9">
				<label id="pay9lb" onMouseUp="payMnt9()"></label>&nbsp;<input id="pay9" type="checkbox" name="demand9" onChange="payMnt9()">
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="mnth10">
				<label id="pay10lb" onMouseUp="payMnt10()"></label>&nbsp;<input id="pay10" type="checkbox" name="demand10" onChange="payMnt10()">
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="mnth11">
				<label id="pay11lb" onMouseUp="payMnt11()"></label>&nbsp;<input id="pay11" type="checkbox" name="demand11" onChange="payMnt11()">
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="mnth12">
				<label id="pay12lb" onMouseUp="payMnt12()"></label>&nbsp;<input id="pay12" type="checkbox" name="demand12" onChange="payMnt12()">
			</div>
		</div> 
		<p style="font-size:75%;margin:15px 0 5px 0;">
		Je, soussigné comprends et atteste les règlements ci-joints plus bas et de respecter les exigences et les normes de E.I.P Mondial Inc. Le présent contrat constitue l’entière convention entre les parties, qui reconnaissent la nullité de toutes représentations ou modifications à moins de confirmation par l’autre partie. Le présent contrat est soumis aux lois de la province du Québec; tout litige sera du ressort exclusif des tribunaux siégeant dans le district de Longueuil. Où les parties déclarent élire domicile en vue de l’exécution du contrat ou de l’exercice des droits qui en découlent.
		</p> -->
		<!--
        <div class="row" style="margin:0 0 20px 0;">

			<div class="checkbox col-lg-2 col-md-2 col-sm-3 col-xs-12" style="margin-top:-5px;">
				<label>VP#</label>
                <input type="text" class="form-control" name="vp" readonly="readonly" value="<?php echo $_SESSION["vpcode"]; ?>"/>
			</div>
			<div class="checkbox col-lg-2 col-md-2 col-sm-3 col-xs-12">
				<label>Date</label>
                <input type="text" class="form-control" name="today" readonly="readonly" value="<?php echo date("F j, Y"); ?>"/>
			</div>
		</div>
		--><!--
</div>


<!-- INVESTMENT -->
<!--
	<div id="investbox">

    <div class="row"style="border:1px solid #666;padding:5px 0;margin-bottom:15px;">
        <label class="control-label"></label>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"style="margin:5px 0;">
			<label class="radio-inline ">
				<input type="radio" name="bundle" value="bundle1" <?php if($bdl == 1){echo "checked='checked'";} ?> id="bdl1"/> Commandité un entrepreneur pour 25 000 $<br/>et recevez 15 000 $ de profit<br/>en 5 ans garanti
			</label>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"style="margin:5px 0;" onclick="membrech('invest2')">
			<label class="radio-inline ">
				<input type="radio" name="bundle" value="bundle2" id="bdl2" <?php if($bdl == 2){echo "checked='checked'";} ?> /> Commandité un entrepreneur pour 50 000 $<br/>et recevez 30 000 $ de profit<br/>en 5 ans garanti
			</label>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"style="margin:20px 0 5px;" onclick="membrech('invest3')">
			<label class="radio-inline ">
				<input type="radio" name="bundle" value="bundle3" id="bdl3" <?php if($bdl == 3){echo "checked='checked'";} ?> /> Commandité un entrepreneur pour 75 000 $<br/>et recevez 45 000 $ de profit<br/>en 5 ans garanti
			</label>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"style="margin:20px 0 5px;" onclick="membrech('invest2')">
			<label class="radio-inline ">
				<input type="radio" name="bundle" value="bundle4" id="bdl4" <?php if($bdl == 4){echo "checked='checked'";} ?> /> Commandité un entrepreneur pour 100 000 $<br/>et recevez 60 000 $ de profit<br/>en 5 ans garanti
			</label>
		</div>
    </div>
-->
<?php
	$yr = date('Y');
	$mn = date('m');
	$dy = date('d');
	$mnt=array('January','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre');
?>
<!--	<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 selectContainer" style="margin:-10px 0 5px 0;">
       <label class="control-label">Date de paiement</label>
			<select class="form-control" name="payments" id="payments">
			<?php
			for($i=0;$i<3;$i++){ ?>
                <option value="<?php echo $yr.'-'.$mn.'-'.$dy; ?>" <?php if($i==0){echo "selected='selected'";}?>name="startdate"><?php echo $yr.'-'.$mnt[$mn-1];$mn++;?></option>
			<?php
			if($mn>12){$mn=1;$yr++;}
			}
			?>
        </select>
    </div> 
	</div>

		<p style="font-size:75%;margin:15px 0 5px 0;">Je, soussigné comprends et atteste les règlements ci-joints plus bas et de respecter les exigences et les normes de E.I.P Mondial Inc. Le présent contrat constitue l’entière convention entre les parties, qui reconnaissent la nullité de toutes représentations ou modifications à moins de confirmation par l’autre partie. Le présent contrat est soumis aux lois de la province du Québec; tout litige sera du ressort exclusif des tribunaux siégeant dans le district de Longueuil. Où les parties déclarent élire domicile en vue de l’exécution du contrat ou de l’exercice des droits qui en découlent.</p>
        <div class="row" style="margin:0 0 20px 0;">

			<div class="checkbox col-lg-2 col-md-2 col-sm-3 col-xs-12" style="margin-top:-5px;">
				<label>VP#</label>
                <input type="text" class="form-control" name="vp" readonly="readonly" value="<?php echo $_SESSION["vpcode"]; ?>"/>
			</div>
			<div class="checkbox col-lg-2 col-md-2 col-sm-3 col-xs-12">
				<label>Date</label>
                <input type="text" class="form-control" name="today" readonly="readonly" value="<?php echo date("F j, Y"); ?>"/>
			</div>
		</div>
</div>



    <button type="submit" name="membersuivant1" class="btn btn-info" style="margin-left:20px;margin-right: 10px;display: inline;">Suivant <span class="fa fa-angle-double-right"></span></button>     
    <a style="display: inline;" href="<?php if(isset($_SESSION["vpcode"]) && $_SESSION["vpcode"]=='vp001'){echo '../index.php';}else{echo 'vp.php';}?>" class="btn btn-default">Cancel</a>
</form>
-->
<script>

$(document).ready(function() {

	$('#invest_price').hide();
	$('#memberbox').hide();

    $("#req2").click(function () {
        if ($('#invest_price').is(':hidden')) {
            $('#invest_price').css("visibility:visible");
            $('#invest_price').slideDown(300);
        }
        if ($('#memberbox').is(':visible')) {
            $('#memberbox').css("visibility:hidden");
            $('#memberbox').slideUp(300);
        }
    });
    $("#req1").click(function () {
        if ($('#invest_price').is(':visible')) {
            $('#invest_price').css("visibility:hidden");
            $('#invest_price').slideUp(300);
        }
        if ($('#memberbox').is(':hidden')) {
            $('#memberbox').css("visibility:visible");
            $('#memberbox').slideDown(300);
        }
    });
    $("#req3").click(function () {
        if ($('#invest_price').is(':visible')) {
            $('#invest_price').css("visibility:hidden");
            $('#invest_price').slideUp(300);
        }
        if ($('#memberbox').is(':visible')) {
            $('#memberbox').css("visibility:hidden");
            $('#memberbox').slideUp(300);
        }
    });

    /*
    $('#newPvForm').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                row: '.col-xs-8',
                validators: {
                    notEmpty: {
                        message: 'The Name is required'
                    },
                    stringLength: {
                        max: 50,
                        message: 'The title must be less than 50 characters long'
                    }
                }
            },
            genre: {
                row: '.col-xs-4',
                validators: {
                    notEmpty: {
                        message: 'The genre is required'
                    }
                }
            },
            director: {
                row: '.col-xs-4',
                validators: {
                    notEmpty: {
                        message: 'The director name is required'
                    },
                    stringLength: {
                        max: 80,
                        message: 'The director name must be less than 80 characters long'
                    }
                }
            },
            writer: {
                row: '.col-xs-4',
                validators: {
                    notEmpty: {
                        message: 'The writer name is required'
                    },
                    stringLength: {
                        max: 80,
                        message: 'The writer name must be less than 80 characters long'
                    }
                }
            },
            producer: {
                row: '.col-xs-4',
                validators: {
                    notEmpty: {
                        message: 'The producer name is required'
                    },
                    stringLength: {
                        max: 80,
                        message: 'The producer name must be less than 80 characters long'
                    }
                }
            },
            website: {
                row: '.col-xs-6',
                validators: {
                    notEmpty: {
                        message: 'The website address is required'
                    },
                    uri: {
                        message: 'The website address is not valid'
                    }
                }
            },
            trailer: {
                row: '.col-xs-6',
                validators: {
                    notEmpty: {
                        message: 'The trailer link is required'
                    },
                    uri: {
                        message: 'The trailer link is not valid'
                    }
                }
            },
            review: {
                // The group will be set as default (.form-group)
                validators: {
                    stringLength: {
                        max: 500,
                        message: 'The review must be less than 500 characters long'
                    }
                }
            },
            rating: {
                // The group will be set as default (.form-group)
                validators: {
                    notEmpty: {
                        message: 'The rating is required'
                    }
                }
            }
        }
    });*/
});
mnt=['Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'];

function checkedCount(){
	var ch = 0;
	if(document.getElementById('mnt1').checked){ch++;}
	if(document.getElementById('mnt2').checked){ch++;}
	if(document.getElementById('mnt3').checked){ch++;}
	if(document.getElementById('mnt4').checked){ch++;}
	if(document.getElementById('mnt5').checked){ch++;}
	if(document.getElementById('mnt6').checked){ch++;}
	if(document.getElementById('mnt7').checked){ch++;}
	if(document.getElementById('mnt8').checked){ch++;}
	if(document.getElementById('mnt9').checked){ch++;}
	if(document.getElementById('mnt10').checked){ch++;}
	if(document.getElementById('mnt11').checked){ch++;}
	if(document.getElementById('mnt12').checked){ch++;}
	return ch;
}

function startDateCahnged(){
	e = document.getElementById('startdate').value;
	var d = new Date();
	var n = d.getMonth();
	dt = d.getFullYear().toString();
	monthSelected = e[0];
	yearSelected = Number(e[e.length-4]+e[e.length-3]+e[e.length-2]+e[e.length-1]);
	if(e[1]!="-"){monthSelected += e[1];}
	for(i=0;i<12;i++){
		mnt1[i]=mnt[monthSelected]+"-"+yearSelected.toString();
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

function demandCh(){
	if (document.getElementById('demand').checked){  // demandDeFinancement checked
		document.getElementById('12mpnot').style.display = 'inline';
		document.getElementById('6mpnot').style.display = 'inline';
		document.getElementById('3mpnot').style.display = 'inline';
	}
	else{
		if(document.getElementById('membe1').checked){
			document.getElementById('12mpnot').style.display = 'none';
			document.getElementById('6mpnot').style.display = 'none';
			document.getElementById('3mpnot').style.display = 'none';
		}
	}
}

function m12checked(){
	document.getElementById('m12').checked = true;
	if(document.getElementById('membe1').checked){
		document.getElementById('12mp').innerHTML='(120.<sup>83</sup> $/mois)';
	}
	else {
		document.getElementById('12mp').innerHTML='(80.<sup>43</sup> $/mois)';
	}
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
	if(document.getElementById('membe1').checked){
		document.getElementById('6mp').innerHTML='(277.<sup>85</sup> $/mois)';
	}
	else{
		document.getElementById('6mp').innerHTML='(160.<sup>85</sup> $/mois)';
	}
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
	if(document.getElementById('membe1').checked){
		document.getElementById('3mp').innerHTML='(555.<sup>71</sup> $/mois)';
	}
	else{
		document.getElementById('3mp').innerHTML='(321.<sup>70</sup> $/mois)';
	}
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

/*  ------------------------   mbrench   ----------------------- */
function membrech(m){
	if(m == 'membe1'){
		if(!document.getElementById('demand').checked){
			document.getElementById('3mpnot').style.display = 'none';
			document.getElementById('6mpnot').style.display = 'none';
			document.getElementById('12mpnot').style.display = 'none';
			document.getElementById('3mp').innerHTML='(1450,<sup>00</sup> $/mois)';
			m12checked();
		}
		else{
			document.getElementById('3mpnot').style.display = 'inline';
			document.getElementById('6mpnot').style.display = 'inline';
			document.getElementById('12mpnot').style.display = 'inline';
			document.getElementById('m12').checked = true;
			if(document.getElementById('m12').checked){document.getElementById('12mp').innerHTML='(120,<sup>83</sup> $/mois)';m12checked();}
			if(document.getElementById('m6').checked){document.getElementById('6mp').innerHTML='(241,<sup>67</sup> $/mois)';m6checked();}
			if(document.getElementById('m3').checked){document.getElementById('3mp').innerHTML='(483,<sup>33</sup> $/mois)';m3checked();}
		}
	}
	else{//alert(m);
		document.getElementById('3mpnot').style.display = 'inline';
		document.getElementById('6mpnot').style.display = 'inline';
		document.getElementById('12mpnot').style.display = 'inline';
		if(document.getElementById('m12').checked){document.getElementById('12mp').innerHTML='(80,<sup>43</sup> $/mois)';m12checked();}
		if(document.getElementById('m6').checked){document.getElementById('6mp').innerHTML='(160,<sup>85</sup> $/mois)';m6checked();}
		if(document.getElementById('m3').checked){document.getElementById('3mp').innerHTML='(321,<sup>70</sup> $/mois)';m3checked();}
	}
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

function membreClicked(x){
	if(x == 'membre'){
		document.getElementById('membe2').checked = true;
		document.getElementById('m12').checked = true;
		m12checked();

	}
	if(x == 'invest'){
		document.getElementById('invest_price1').checked = true;	
	}
}

function init(){
	document.getElementById('demand').checked = true;
	m12checked();
	var d = new Date();
	var n = d.getMonth();
	dt = d.getFullYear().toString();
	options = '';
	for(i=0;i<12;i++){
		vl = n.toString()+'-'+dt.toString();
		mnt1[i]=mnt[n]+"-"+dt;
		options += "<option value='"+vl+"'>"+mnt1[i]+"</option>";		
		n++;
		if(n>11){n=0;dt = (d.getFullYear()+1).toString();}
	}
	document.getElementById("startdate").innerHTML = options;
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
</script>



	
</section>
</body>
