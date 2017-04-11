<?php
session_start();
include('connect.php');
if(!isset($_SESSION["vpcode"])){
	header('location:login.php');
}
	$errMsg = '';
	$succ='';
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

	$src = $_SESSION['vpcode'];
	$sql = "SELECT * FROM users INNER JOIN member ON users.vpcode=member.vpcode where users.vpcode='$src'";
	$result = mysql_query($sql, $user_con) or die(mysql_error());
	$row = mysql_fetch_assoc($result);
	
	if(isset($_POST['save_profile'])){

		$target_dir = "image/";
		$uploadOk = 1;

		if(isset($_FILES["user_image"]) and $_FILES["user_image"]["name"]){
			$target_file = $target_dir . basename($_FILES["user_image"]["name"]);
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$check = getimagesize($_FILES["user_image"]["tmp_name"]);
	    	if(!$check) {
	        	$errMsg.=" File is not an image.<br/>";
	        	$uploadOk = 0;
	    	}
	    	if ($_FILES["user_image"]["size"] > 2000000) {
	    		$errMsg.=" Sorry, image file should  than 2MB.<br/>";
	    		$uploadOk = 0;
			}
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			    $errMsg.=" Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br/>";
	    		$uploadOk = 0;
			}
			if ($uploadOk == 0) {
		 		$errMsg.=" Sorry, your file was not uploaded.<br/>";
		 	} 
    		if ($uploadOk && move_uploaded_file($_FILES["user_image"]["tmp_name"], $target_file)) {
	        	$succ= "The file ". basename( $_FILES["user_image"]["name"]). " has been uploaded.<br/>";
	        	$fl=basename($_FILES['user_image']['name']);
				$sql1 = "update users set image='$fl' where vpcode='$src' ";
				$result1 = mysql_query($sql1, $user_con) or die(mysql_error());
				$succ.="Image file uploaded.<br/>";
	        }
		}
       	$ad=$_POST['adress'];
       	$ct=$_POST['city'];
       	$pv=$_POST['province'];
       	$po=$_POST['postal'];
       	$ph=$_POST['phone1'];
       	$pswChanged=false;
       	if((isset($_POST["old_psw"]))and $_POST["old_psw"]){
        	$pswChanged=true;
       		if($_POST["old_psw"]!=$row["password"]){
       			$errMsg.="Old password is not correct!<br/>";
       			$pswChanged=false;
       		}
       		if(($_POST["new_psw1"]!=$_POST["new_psw2"])||(!$_POST["new_psw1"])||(!$_POST["new_psw2"])){
       			$errMsg.="New passwords are not the same!<br/>";
		        $pswChanged=false;
       		}
       	}
       	if(!$errMsg){
			$sql2 = "update member set adress='$ad',city='$ct',province='$pv',postal='$po', phone1='$ph' where vpcode='$src' ";
			if($pswChanged){
				$ps=$_POST["new_psw2"];
				$sql3 = "update users set password='$ps' where vpcode='$src' ";						
				$result3 = mysql_query($sql3, $user_con) or die(mysql_error());
				$succ.="Password changed.<br/>";
			}
			$result2 = mysql_query($sql2, $user_con) or die(mysql_error());
			$succ.="All information saved.<br/>";
		   	header('refresh:2;url=vp.php');
   		} 

	}

?>	
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EIP Mondial - <?php echo $_SESSION["vpcode"] ?></title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../grayscale.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="../js/grayscale.js"></script>
    <script src="../js/jquery.js"></script>
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->	
    <style>
    	th{font:1.1em/1.1em Montserrat;font-weight: 700;}
    	td{font:1.2em/1.1em lora;}
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

    	#referrals, #commission{
    		padding:10px 0;
    		background-color:#666;
    		border:1px solid #000;
    		margin-bottom: 30px;
    	}
    	#referrals table, #commission table{
    		width: 100%;
    	}
    	#referrals th, #commission th{
    		text-align: center;
    		font: 1em/1em Montserrat;  
    		font-weight: 700; 
    		border-bottom: 1px solid white; 		
    		text-shadow: 0 0 3px #111;
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
		right: 5%;
		top: 0;
		margin-top: 20px;
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
		right: 5%;
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
	.boxclose:before {
    	content: "×";
	}


#loanbox label{
	font-size: 1.4em;
}
#loanbox input{
	margin-left: 25%;
}



</style>
</head>
<body>
<div id="bkop"></div>
<!--<div id="ptexch" class="col-lg-6 col-lg-offset-3">
	<input id='closebtn' type='button' value='X' class='btn btn-xs btn-danger closebtn' onclick="closePtexch()">
	<i class="fa fa-times-circle"></i>	
	<h3 id="t"></h3>
</div>-->
		
<section style="background-color:#42DCA3;">
	<div class = 'container' style="height:40px;">
		<div class='row'>
        	<div class='col-lg-4 col-sm-6 col-xs-10' style="color:white;text-transform: capitalize;">
				<p><img style="margin:5px 0 0 5px;border-radius: 50%;-webkit-border-radius: 50%;-moz-border-radius: 50%;" 
				src="image/pub.jpg" width="30" height="30"> 
				<?php echo $_SESSION["vpcode"]; ?> - <?php echo $row["name"].' '.$row["famil"]; ?></p>
			</div>
        	<div class='col-lg-8 col-sm-6 col-xs-2'>
				<a style="float:right;color:white;margin-top:8px;margin-right: 10px;" href="../">HOME</a>
			</div>
		</div>
    </div>
</section>	

<section style="background-color:#eee;color:#222;">
    <div class="container" style="padding-top:20px;">
		<form id="profileForm" enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<a class="btn btn-success" style="float:right;color:white;margin-top:8px;margin-bottom: 10px;" href="vp.php">Cancel</a>
			<button type="submit" name="save_profile" class="btn btn-info" style="float:right;margin-top:8px;color:white;margin-right: 10px;">Save</button>
			<div class="row"></div>
		    <div class="row">

			    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			    	<div class="form-group">
	        			<label for="nom">Pr&eacute;nom</label>
	        			<input type="text" class="form-control" id="nom" placeholder="<?php echo $row["name"]; ?>" value="<?php echo $row["name"]; ?>" name="nom" readonly="readonly">
	    			</div>
	    		</div>
			    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			    	<div class="form-group">
	        			<label for="nom">Famil</label>
	        			<input type="text" class="form-control" id="famil" placeholder="<?php echo $row["famil"]; ?>" value="<?php echo $row["famil"]; ?>" name="famil" readonly="readonly">
	    			</div>
	    		</div>
    		</div>

		    <div class="row" style="margin-top: 10px;">
			    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			    	<div class="form-group">
	        			<label for="famil">Adresse</label>
	        			<input type="text" class="form-control" id="adress" placeholder="<?php echo $row["adress"]; ?>" value="<?php echo $row["adress"]; ?>" name="adress">
	    			</div>
	    		</div>
			    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			    	<div class="form-group">
	        			<label for="nom">Ville</label>
	        			<input type="text" class="form-control" id="city" placeholder="<?php echo $row["city"]; ?>" value="<?php echo $row["city"]; ?>" name="city">
	    			</div>
	    		</div>
	            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 selectContainer">
	                <label class="control-label">Province</label>
	                <select class="form-control" name="province">
	                    <option <?php if($row["province"]=="Qu&eacute;bec"){echo 'selected="selected"';} ?> value="Quebec">Qu&eacute;bec</option>
	                    <option <?php if($row["province"]=="Ontario"){echo 'selected="selected"';} ?> value="Ontario">Ontario</option>
	                    <option <?php if($row["province"]=="Nova Scotia"){echo 'selected="selected"';} ?> value="Nova Scotia">Nova Scotia</option>
	                    <option <?php if($row["province"]=="New Brunswick"){echo 'selected="selected"';} ?> value="New Brunswick">New Brunswick</option>
	                    <option <?php if($row["province"]=="Manitoba"){echo 'selected="selected"';} ?> value="Manitoba">Manitoba</option>
	                    <option <?php if($row["province"]=="British Columbia"){echo 'selected="selected"';} ?> value="British Columbia">British Columbia</option>
	                    <option <?php if($row["province"]=="Prince Edward Island"){echo 'selected="selected"';} ?> value="Prince Edward Island">Prince Edward Island</option>
	                    <option <?php if($row["province"]=="Saskatchewan"){echo 'selected="selected"';} ?> value="Saskatchewan">Saskatchewan</option>
	                    <option <?php if($row["province"]=="Alberta"){echo 'selected="selected"';} ?> value="Alberta">Alberta</option>
	                    <option <?php if($row["province"]=="Newfoundland and Labrador"){echo 'selected="selected"';} ?> value="Newfoundland and Labrador">Newfoundland and Labrador</option>
	                </select>
	            </div>
    		</div>

    		<div class="row" style="margin-top: 10px;">
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	                <label class="control-label">Code postale</label>
	                <input type="text" class="form-control" name="postal" maxlength="6" value="<?php echo $row["postal"]; ?>" value="<?php echo $row["postal"]; ?>"/>
	            </div>
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	                <label class="control-label">T&eacute;l&eacute;phone</label>
	                <input type="text" class="form-control" name="phone1" required="required" maxlength="10" value="<?php echo $row["phone1"]; ?>"/>
	            </div>
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	                <label class="control-label">Email</label>
	                <input type="email" class="form-control" name="email" required="required" readonly="readonly" value="<?php echo $row["email"]; ?>" />
	            </div>
	        </div>
	        <div class="row" style="margin-top:20px;">
	        	<button type="button" name="save_profile" id="save_profile" class="btn btn-sm btn-default" style="float:left;color:black;margin-left: 15px;">I want change my password</button>
	        </div>
    		<div class="row" style="margin-top: 20px;" id="psw">
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	                <label class="control-label">Old Password</label>
	                <input type="text" class="form-control" name="old_psw" id="old_psw"/>
	            </div>
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	                <label class="control-label">New Password</label>
	                <input type="text" class="form-control" name="new_psw1" id="new_psw1" minlength="5"/>
	            </div>
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	                <label class="control-label">Confirm new Password</label>
	                <input type="text" class="form-control" name="new_psw2" id="new_psw2" minlength="5" />
	            </div>
	        </div>
	        <div class="row" style="margin-top: 20px;">
	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	                <label class="control-label">Télécharer l'image</label>
		    			<input type="file" name="user_image" accept="image/*">
				</div>

	            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-top: 20px;">
		    		<div style="width:90px;height:90px;border-radius: 50%;border:2px solid white;overflow: hidden;">
		    			<img src="<?php $img=$row["image"];if($img){echo 'image/'.$img;}else{echo 'image/pub.jpg';}?>" height="100%" alt="Votre image">
		    		</div>	
	            </div>
            </div>
            <p><span style="color:#ff3333;font-size:1.1em;"><?php echo $errMsg;?></span>
            <span style="color:#069c00;font-size:1.1em;"><?php echo $succ;?></span></p>

		    </div>
	    </form>
	</div>
</section>

<script type="text/javascript">
$(document).ready(function() {

	$('#psw').hide();
	$("#save_profile").click(function () {
        if ($('#psw').is(':hidden')) {
            $('#psw').css("visibility:visible");
            $('#psw').slideDown(300);
        }
        else {
            $('#psw').css("visibility:hidden");
            $('#psw').slideUp(300);
            var x="";
            $('#old_psw').val(x);
            $('#new_psw1').val(x);
            $('#new_psw2').val(x);
        }
    });

});

</script>
</body>






















