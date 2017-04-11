<?php
session_start();
$valid = false;
$bdl = 0;
include('connect.php');
?>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EIP - <?php
		if(isset($_SESSION["vpcode"])){echo $_SESSION["vpcode"];}
		else {if(isset($_GET["nvp"])){echo 'New member';} $_SESSION["vpcode"] = 'VP001';}?>
	</title>
<!--	<link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'> -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../grayscale.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
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
	#invest_price, #loanbox{
		margin: 1.5em 1em;
		box-sizing: border-box;
		border: 1px solid #999;
	}
	#loanbox{
		padding: .1em 1em;
	}
	#invest_price label, #loanbox label{
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
	#price, #loanbox{
		font-size: 1.1em;
		line-height: 1.2em;
	}
	#loanbox label{
		font-size: 1.2em;		
	}
	#loanbox > div{
		margin-bottom: 1em;
	}
	.noshow{
		display: none;
	}
	</style>
</head>

<?php
if(isset($_GET["i"])){$i=true;}else{$i=false;}
if(isset($_GET["nvp"])){$_SESSION["vpcode"]='vp001';}
if(!isset($_POST["refersuivant"])){
	$formdata['requesttype'] = 'Loan';
	if(isset($_POST['invest_price'])){$formdata['invest_price'] = $_POST['invest_price'];}else{$formdata['invest_price']=0;};
}
else{
	$formdata['requesttype'] = htmlspecialchars(stripslashes(trim($_POST['requesttype'])));
	if(isset($_POST['invest_price'])){$formdata['invest_price'] = $_POST['invest_price'];}else{$formdata['invest_price']=0;};
	if(isset($_POST['loan_type'])){$formdata['loan_type'] = $_POST['loan_type'];}else{$formdata['loan_type']='Personal loan';};
	if(isset($_POST['loanAmount'])){$formdata['loanAmount'] = $_POST['loanAmount'];}else{$formdata['loanAmount']=1000;};
	
	$formdata['name'] = htmlspecialchars(stripslashes(trim($_POST['name'])));
	$formdata['famil'] = htmlspecialchars(stripslashes(trim($_POST['famil'])));
	$formdata['adress'] = htmlspecialchars(stripslashes(trim($_POST['adress'])));
	$formdata['city'] = htmlspecialchars(stripslashes(trim($_POST['city'])));
	$formdata['province'] = $_POST['province'];
	$formdata['postal'] = htmlspecialchars(stripslashes(trim($_POST['postal'])));
	$formdata['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$formdata['phone'] = $_POST['phone1'];
	
	$formdata['referredby'] = $_POST['vp'];

	$s = $formdata['email'];
	$sql = "select vpcode as vpc from users where email='$s'"; 
	if (mysql_query($sql, $user_con)) {
    	$result = mysql_query($sql, $user_con) or die(mysql_error());
    	$r = mysql_fetch_assoc($result);
    }
    if($r['vpc']){$formdata['vpcode'] = $r['vpc'];}
    else{
		$ty = date("Y");
		$sql2 = "select count(id) as counts from users where YEAR(memberdate)=$ty"; 
		if (mysql_query($sql2, $user_con)) {
    		$result2 = mysql_query($sql2, $user_con) or die(mysql_error());
    		$r = mysql_fetch_assoc($result2);
		} 
		else {echo "Error: ".$sql."<br>".mysql_error($user_con);}
		$ty= 'VP';
		$ty.= date("y");
		if($r['counts']<10){$ty.='00';}
		elseif($r['counts']<100 && $r['counts']>9){$ty.='0';}
		$ty.= $r['counts']+1;
    	$formdata['vpcode'] = $ty;
    }
	$formdata['today'] = $_POST['today'];
	
	$valid = true;
	if($valid){
		$_SESSION['formdata'] = $formdata;
		header('location:refer2.php');
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
		<h3>RÉFÉRENCEMENT</h3>
		<form id="newPvForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="row req">
				<div class="col-lg-2 col-md-2 col-sm-2"></div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label class="radio-inline">
						<input type="radio" name="requesttype" value="Investor" id="req2" <?php if($i){echo 'checked="checked"';} ?> /> Investisseur
					</label>	
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label class="radio-inline ">
						<input type="radio" name="requesttype" value="Loan" id="req1" <?php if(!$i){echo 'checked="checked"';} ?> /> Prêt
					</label> 
				</div>
			</div>
			<!-- ======================================  INVEST PRICE =========================================  -->
			<div id="invest_price" <?php if($i){echo ' class="row"';}else{echo ' class="row noshow"';} ?> >
				<h4>Investisseur</h4>
		        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-1"></div>
		        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10 form-group">
		        	<select id="price" name="invest_price" class="form-control">
		        		<option value="25000">25 000$</option>
		        		<option value="50000">50 000$</option>
		        		<option value="75000">75 000$</option>
		        		<option value="100000">100 000$</option>
		        		<option value="125000">125 000$</option>
		        		<option value="150000">150 000$</option>
		        		<option value="175000">175 000$</option>
		        		<option value="200000">200 000$</option>
		        	</select>
		        </div>	
		    </div>
			<!-- ======================================  LOAN BOX =========================================  -->
			<div id="loanbox" <?php if($i){echo ' class="row noshow"';}else{echo ' class="row"';} ?>>
				<h4>Prêt</h4>
		        <div class="row">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				        <label class="control-label">
				        <input type="radio" name="loan_type" value="Personal" id="loan_type" checked="checked" /> Prêt personnel
				        </label>
				    </div>				    
				    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				        <label class="control-label">
				        <input type="radio" name="loan_type" value="Business" id="loan_type" /> Prêt commercial
				        </label>
				    </div>
				    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				        <label class="control-label">
				        <input type="radio" name="loan_type" value="Hypotheque" id="loan_type" /> Prêt hypothécaire
				        </label>
				    </div>
		        </div>
		        <div class="row">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group">
							<label for="loanAmount">Montant</label>
							<div class="input-group">
					      		<div class="input-group-addon">$</div>
					      		<input type="number" min="1000" max="200000" value="1000" class="form-control" id="loanAmount" name="loanAmount" placeholder="Amount">
					      		<div class="input-group-addon">.00</div>
					    	</div>
					  	</div>
  					</div>
				</div>
			</div>
			<!-- ======================================  INFORMATION FORM =========================================  -->
			<div class="row infoform">
	            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	                <label class="control-label">Pr&eacute;nom *</label>
	                <input type="text" class="form-control" name="name" required="required" />
	            </div>			
	            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	                <label class="control-label">Nom *</label>
	                <input type="text" class="form-control" name="famil" required="required" />
	            </div>
	            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	                <label class="control-label">Adresse</label>
	                <input type="text" class="form-control" name="adress" />
	            </div>
	            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	                <label class="control-label">Ville</label>
	                <input type="text" class="form-control" name="city" />
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
	                <input type="text" class="form-control" name="postal" maxlength="6" />
	            </div>
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	                <label class="control-label">T&eacute;l&eacute;phone *</label>
	                <input type="text" class="form-control" name="phone1" required="required" maxlength="10" />
	            </div>
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	                <label class="control-label">Adresse courriel *</label>
	                <input type="email" class="form-control" name="email" required="required"/>
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
			</div>


		    <button type="submit" name="refersuivant" class="btn btn-info" style="margin-left:20px;margin-right: 10px;display: inline;">Suivant <span class="fa fa-angle-double-right"></span></button>     
		    <a style="display: inline;" href="vp.php" class="btn btn-default">Annuler</a>

		</form>

<script>

$(document).ready(function() {

    $("#req2").click(function () {
        $('#invest_price').css("visibility:visible");
        $('#invest_price').slideDown(300);
        $('#loanbox').css("visibility:hidden");
        $('#loanbox').slideUp(300);
    });
    $("#req1").click(function () {
        $('#invest_price').css("visibility:hidden");
        $('#invest_price').slideUp(300);
        $('#loanbox').css("visibility:visible");
        $('#loanbox').slideDown(300);
    });

    /*$("#req3").click(function () {
        if ($('#invest_price').is(':visible')) {
            $('#invest_price').css("visibility:hidden");
            $('#invest_price').slideUp(300);
        }
        if ($('#memberbox').is(':visible')) {
            $('#memberbox').css("visibility:hidden");
            $('#memberbox').slideUp(300);
        }
    });*/

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
/*
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
/*function membrech(m){
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
*/
function membreClicked(x){
	if(x == 'loan'){
	}
	if(x == 'invest'){
	}
}

function init(){
/*	document.getElementById('demand').checked = true;
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
	document.getElementById("mnt12").value = mnt1[11];*/
}
</script>



	
</section>
</body>
