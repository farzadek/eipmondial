<?php
session_start();
ob_start();
$comm = '';
$username = '';
$password = ''; 
$ty = 0;
if(isset($_SESSION["vpcode"])){
  unset($_SESSION["vpcode"]);
}
$errMsg = '';
$logedin=false;
if (isset($_POST["submitLogin"])) {
  include('connect.php');

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
  
  $username = $_POST['username'];
  $password = $_POST['password']; 

  $sql = "SELECT * FROM users where username='$username' and BINARY password= BINARY '$password'";
    
  $result = mysql_query($sql, $user_con) or die(mysql_error());

  if (mysql_num_rows($result) > 0) {
    $row = mysql_fetch_assoc($result);
    if($row['active']){
      $_SESSION["vpcode"] = $row["vpcode"];
      $logedin=true;
      $ty = $row['type'];
    }
    else{
      $errMsg = "<div class='col-sm-10 col-sm-offset-1' style='color: rgb(255, 100, 100); font-size: 1.2em; margin-top:10px;text-align:center;'>votre compte n'est pas active!<br/>Veuillez vérifiez votre boitre courriel ou contactez-nous.</div>";
      $logedin=false;      
    }
    mysql_free_result($result);
    mysql_close($user_con); 
  } 
  else {
    $errMsg="<div class='col-sm-10 col-sm-offset-1' style='color: rgb(255, 100, 100); font-size: 1.1em; margin-top:10px;text-align:center;'>Nom d’utilisateur ou mot de passe introuvable!</div>";
    $logedin=false;
  }
} 
?>
<html lang="fr">

<head>
    <title>EIP - Login</title>
    <meta charset="utf-8">

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../grayscale.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="../img/icon32.png">

  <style>
  
body{
  background-color: black;
}
.hidden {
  display: none;
}

.button {
  box-sizing: border-box;
  position: absolute;
  display: block;
  width: 220px;
  height: 60px;
  top: 2px;
  left: 35px;
  border: 2px solid #fff;
  border-radius: 30px;
  text-align: center;
  line-height: 60px;
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 2px;
  -webkit-transition: all .3s ease-in-out;
  transition: all .3s ease-in-out;
  cursor: pointer;
}
.button:hover {
  background: #37BE77;
}
.button img {
  position: absolute;
  z-index: 2;
  top: 16px;
  left: 15px;
  opacity: 0;
}

.circle {
  position: absolute;
  width: 60px;
  height: 60px;
  z-index: 2;
  top: 2px;
  left: 72px;
  fill: none;
  stroke: #fff;
  stroke-width: 2px;
  stroke-linecap: round;
  stroke-dasharray: 183 183;
  stroke-dashoffset: 183;
  pointer-events: none;
  -webkit-transform: rotate(-90deg);
          transform: rotate(-90deg);
}

input:active ~ .button {
  -webkit-animation: button .5s ease both, fill .5s ease-out 1.5s forwards;
          animation: button .5s ease both, fill .5s ease-out 1.5s forwards;
}
input:active ~ .button img {
  -webkit-animation: check .5s ease-out 1.5s both;
          animation: check .5s ease-out 1.5s both;
}
input:active ~ .circle {
  -webkit-animation: circle 2s ease-out .5s both;
          animation: circle 2s ease-out .5s both;
}

@-webkit-keyframes button {
  0% {
    width: 220px;
    left: 70px;
    border-color: #fff;
    color: #fff;
  }
  50% {
    color: transparent;
  }
  100% {
    width: 60px;
    left: 72px;
    border-color: #45B078;
    background: transparent;
    color: transparent;
  }
}

@keyframes button {
  0% {
    width: 260px;
    left: 70px;
    border-color: #fff;
    color: #fff;
  }
  50% {
    color: transparent;
  }
  100% {
    width: 60px;
    left: 72px;
    border-color: #45B078;
    background: transparent;
    color: transparent;
  }
}
@-webkit-keyframes circle {
  0% {
    stroke-dashoffset: 183;
  }
  50% {
    stroke-dashoffset: 0;
    stroke-dasharray: 183;
    -webkit-transform: rotate(-90deg) scale(1);
            transform: rotate(-90deg) scale(1);
    opacity: 1;
  }
  90%, 100% {
    stroke-dasharray: 500 500;
    -webkit-transform: rotate(-90deg) scale(2);
            transform: rotate(-90deg) scale(2);
    opacity: 0;
  }
}
@keyframes circle {
  0% {
    stroke-dashoffset: 183;
  }
  50% {
    stroke-dashoffset: 0;
    stroke-dasharray: 183;
    -webkit-transform: rotate(-90deg) scale(1);
            transform: rotate(-90deg) scale(1);
    opacity: 1;
  }
  90%, 100% {
    stroke-dasharray: 500 500;
    -webkit-transform: rotate(-90deg) scale(2);
            transform: rotate(-90deg) scale(2);
    opacity: 0;
  }
}
@-webkit-keyframes fill {
  0% {
    background: transparent;
    border-color: #fff;
  }
  100% {
    background: #fff;
  }
}
@keyframes fill {
  0% {
    background: transparent;
    border-color: #fff;
  }
  100% {
    background: #fff;
  }
}
@-webkit-keyframes check {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
@keyframes check {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
.full-back{
  background: rgba(0,71,102,1);
  background: -moz-linear-gradient(top, rgba(0,71,102,1) 0%, rgba(0,20,36,1) 100%);
  background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(0,71,102,1)), color-stop(100%, rgba(0,20,36,1)));
  background: -webkit-linear-gradient(top, rgba(0,71,102,1) 0%, rgba(0,20,36,1) 100%);
  background: -o-linear-gradient(top, rgba(0,71,102,1) 0%, rgba(0,20,36,1) 100%);
  background: -ms-linear-gradient(top, rgba(0,71,102,1) 0%, rgba(0,20,36,1) 100%);
  background: linear-gradient(to bottom, rgba(0,71,102,1) 0%, rgba(0,20,36,1) 100%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#004766', endColorstr='#001424', GradientType=0 );
  width: 100%;
  height: 100%;
  position: absolute;
  z-index: 900;
  top: 0;
  font-size: 1.2em;
  color: #acfaff;
  display: none;
}
.full-back > div{
  margin: 0 auto;
  position: fixed;
  border-radius: 10px;
  border: 3px dashed white;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}
.full-back input{
  margin: 1em auto;
}
.full-back label{
  margin-top: .7em;
}
.full-back #submitfind,.full-back #cancelfind{
  display: inline;
  margin-left: .5em;
}
#forgetbutton{
  cursor: pointer;
  color: rgb(0,185,220);
}
#success_message1{
  font-size: .8em;
  height: 1em;
}
</style>

</head>
<?php 
if(!isset($_POST["submitLogin"]) || !$logedin){
$comm = "
<div class='full-back'>
  <div class='col-lg-4 col-md-6 col-sm-6 col-xs-10'>
  <form class='form-horizontal' role='form' method='post'  id='lostpassword'>
    <div class='form-group'>
      <label for='emailfind' class='col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label'>Adresse Email</label>
      <div class='col-lg-8 col-md-8 col-sm-8 col-xs-12'>
        <input type='email' class='form-control' id='emailfind' name='emailfind'>
      </div>
    </div>
      <input id='submitfind' name='submitfind' type='submit' value='Envoyer' class='btn btn-info btn-md'>
      <input id='cancelfind' type='button' value='Annuler' class='btn btn-warning btn-md'>
      <div id='success_message1'></div>
  </form>
  </div>
</div>


<section id='login' class='content-section text-center'>
<div class = 'container'>
  <div class='row' id='contactForm'>
    <div class='col-lg-3 col-md-3 col-sm-3'></div>
    <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
      <img src='../img/mainlogo.png' width='250'>
      <form class='form-horizontal' role='form' method='post'>
        <div class='form-group'>
          <label for='name' class='col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label'>Nom d’utilisateur</label>
          <div class='col-lg-8 col-md-8 col-sm-8 col-xs-12'>
            <input type='text' class='form-control' id='username' name='username' ";
            if(isset($_SESSION["un"]) && $_SESSION["un"]){$comm.=" value=".$_SESSION['un'];}
            $comm .= " >
          </div>
        </div>

        <div class='form-group'>
          <label for='password' class='col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label'>Mot de passe</label>
            <div class='col-lg-8 col-md-8 col-sm-8 col-xs-12'>
              <input type='password' class='form-control' id='password' name='password'>
            </div>
        </div>
        <div class='form-group'>
          <div class='col-lg-2 col-md-2'></div>
          <div class='col-lg-4 col-md-4 col-sm-6 col-xs-6'>
            <input id='submitLogin' name='submitLogin' type='submit' value='Connexion' class='btn btn-primary' style='display:inline-block;float:left;width:100%;'>
          </div>
          <div class='col-lg-4 col-md-4 col-sm-6 col-xs-6'>
            <a href='member.php?nvp=TRUE' class='btn btn-info' style='display:inline-block;float:right;width:100%'>Registre</a>
          </div>
        </div>
        <div class='form-group'>"
            .$errMsg.
        "</div>
      </form> 
        </div>
    </div>
    <a href='";
    if(isset($_SESSION['place'])){
      if($_SESSION['place']=='sut'){
        session_unset('place');
        $comm.="http://eipsolution.com";
      }
    }
    else{
      $comm.="../../index.php";        
    }
    $comm.="'>Retour à la page principale</a><br/><a id='forgetbutton'>J’ai oublié mot de passe</a>
</div>
</section>";
echo $comm;
}
else{
  if(!$errMsg){
    if($ty<3){$_SESSION['a']=$ty;header('location:admin.php');}
    if($ty>2){header('location:vp.php');exit();}
  }
}

?>

<script>
$(document).ready(function() {
  $("#forgetbutton").click(function () {
      $('.full-back').css("display:block");
      $('.full-back').slideDown(300);
      $('.full-back').css("visibility:visible");
  });
  $("#cancelfind").click(function () {
      $('.full-back').css("display:none");
      $('.full-back').slideUp(300);
  });
 
  $('form#lostpassword').submit(function(event) {
        var formData = {
            'code' : $('input[name=emailfind]').val()
        };

            $.ajax({
                type : 'POST', 
                url : 'sendemail_lost.php', 
                data : formData, 
                dataType : 'json', 
                encode : true
            })
            .done(function(data) {
                    if(data.success){
                        $("#success_message1").css({"color": "green"});
                        $("#success_message1").text("Votre mot de passe envoyé à votre email");
                        $("input[name=emailfind]").val("");
                        $('.full-back').delay(2000).css("visibility:hidden");
                        $('.full-back').css("display:none");                    
                        $('.full-back').slideUp(300);
                    }
                    else{
                        $("#success_message1").css({"color": "red"});
                        if(!data.errors.name){data.errors.name='';}
                        $("#success_message1").text(data.errors.name);
                    }                
            })
            .fail(function(request, status, error) {
                    $("#success_message1").css({"color": "red"});
                    $("#success_message1").text(request.responseText);
            })
            event.preventDefault();
    });


});

</script>