<?php
session_start();
$_SESSION['un'] = '';
if(isset($_SESSION["vpcode"])){
	unset($_SESSION["vpcode"]);
}
if(isset($_SESSION["a"])){
	unset($_SESSION["a"]);
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

    <title>EIP MONDIAL - </title>

    <!-- Bootstrap Core CSS -->
    <script src="mondial/js/jquery.js"></script>
    <link href="mondial/css/bootstrap.min.css" rel="stylesheet">
    <script src="mondial/js/bootstrap.min.js"></script>
    <script src="mondial/js/grayscale.js"></script>
    <!-- Custom CSS -->
    <link href="mondial/grayscale.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="mondial/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="mondial/img/icon32.png">

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <meta name="google-site-verification" content="" />
    <meta name="keyword" content="redressement de crédit, aide à l'obtention d'un prêt, dette, financement, service aux entreprises, service aux particuliers, prêts hypothécaires, planification de budget, prêt pour fond de roulement, redressement d'entreprises, service comptable, solution d'affaires">
    <meta name="msvalidate.01" content="" />
    <link rel="alternate" hreflang="fr" href="http://eipmondial.com" />
    <meta property="og:locale" content="fr-CA"/>
    <meta property="og:title" content="EIP.Mondial" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://www.eipmondial.com" />
    <meta property="og:image" content="http://eipmondial.com/mondial/img/icon32.png" />
    <meta property="og:description" content="" />


</head>

<?php
include("mondial/php/connect.php");
$errName='';
$errEmail='';
$errMessage='';
$errPhone='';
$messageMail='';
$name='';
$message='';
$phone='';
$email='';
$mailErr = 'q';
if(isset($_SESSION["vpcode"])){unset($_SESSION["vpcode"]);}

    if (isset($_POST["submitMail"])) {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message_text = htmlspecialchars($_POST['message']);
        $phone = htmlspecialchars($_POST['phone']);
		if(!$name){ $errName="Please enter your name"; $mailErr = 'yes';}
		if(!$message){ $errMessage="Please enter your Message"; $mailErr = 'yes';}
		if(!$phone){ $errPhone="Please enter your Phone number"; $mailErr = 'yes';}
		if(!$email){ $errEmail="Please enter your Email"; $mailErr = 'yes';}
		
		if(!$errName && !$errMessage && !$errPhone && !$errEmail){
		
			$message = '<html><body>';
			$message .= '<img src="http://css-tricks.com/examples/WebsiteChangeRequestForm/images/wcrf-header.png" alt="Website Change Request" />';
			$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
			$message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" .$name. "</td></tr>";
			$message .= "<tr><td><strong>Email:</strong> </td><td>" . $email . "</td></tr>";
			$message .= "<tr><td><strong>Phone:</strong> </td><td>" . $phone . "</td></tr>";
			$message .= "<tr><td><strong>Message:</strong> </td><td>" . $message_text . "</td></tr>";
			$message .= "</table>";
			$message .= "</body></html>";
			
						
			//mail('farzadek@google.com','Email from EIP Mondial',$message);
			mail($email,'Email from ContactUs - EIP website','We receievd your Message');
			mail('info@eipmondial.com','Email from ContactUs - EIP website',$message);
			$messageMail = 'We receievd your Message';
			$mailErr = 'no';$email='';$message='';
		}
	}	
		
?>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-86959155-2', 'auto');
  ga('send', 'pageview');

</script>
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
	<img src="mondial/img/mainlogo.png" alt="eip logo" height="52">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                <i class="fa fa-bars"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse navbar-right navbar-main-collapse headMenu">
            <ul class="nav navbar-nav">
                <li class="hidden"><a href="#page-top"></a></li>
                <li><a class="page-scroll" href="#accueil">Accueil</a></li>
                <li><a class="page-scroll" href="#notreequipe">fondateurs</a></li>
                <li><a class="page-scroll" href="#joindre">contact</a></li>
                <li><a class="page-scroll" href="mondial/php/login.php">identification</a></li>
                <li><a class="page-scroll" href="mondial/php/member.php?nvp=TRUE">s'inscrire</a></li>
            </ul>
        </div>
</nav>

<section id="accueil">
    <div class="container content-section text-center">
        <div class="row">
                <h1>ACCUEIL</h1>
                <p style="margin-left:10%;margin-right: 10%;">L’entreprise EIP Mondial inc. commandite et encourage les jeunes entrepreneurs dans la réalisation de leurs rêves. Notre rôle est d’aider à propulser les gens en quête de défi personnel. Par la suite, EIP Solution offre une gamme complète d’outils et de services pour permettre de sécuriser votre investissement et de vous voir réussir dans la vie.</p>
        </div>
    </div>
</section>


<section id="statistics">
	<div class="row">
		<h1 style="margin-bottom: 20px;">NOS SUCCÉS</h1>
		<div class="col-lg-2 col-md-2 col-sm-2"></div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
			<div class="circle"><p id="cnt1">00</p></div><p>Clients satisfaits</p>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
			<div class="circle"><p id="cnt2">00$K</p></div><p>Prêts acceptés</p>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
			<div class="circle"><p id="cnt3">0</p></div><p>Projets ouverts</p>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
			<div class="circle"><p id="cnt4">1</p></div><p>Clients commandités</p>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2"></div>
	</div>
</section>

<div class="row" id="marquee">
	<div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12" role="alert">
		<marquee scrollamount="10" behavior="scroll" class="slogan"> Obtenez gratuitement l’abonnement membre à vie d’une valeur de <span1>1450$</span1> pour une durée limitée<span>***</span><span1>12%</span1> d’intérêt annuel payable mensuellement<span>***</span>1 (888) 368-8949 <span>***</span>Aide à l'obtention d'un prêt <span>***</span> Service de courtage <span>***</span> Financement de projets</marquee>
	</div>
</div>

<section id="notreequipe" class="content-section text-center">
		
	<div class="col-lg-12 div1"></div>
	<div class="col-lg-12 div2"></div>
		
	<div class="div3">
		<div class="row">
			<div class="col-lg-4 col-lg-offset-4 col-sm-4 col-sm-offset-4 col-xs-12">
				<h1>Nos Fondateurs</h1>
			</div>		
		</div>	
		<div class="row">
			<div class="col-lg-2"></div>
			<div class="col-lg-3 col-sm-6 col-xs-12">
				<div id="equipe1">
					<img class="president-image" src="mondial/img/yan.jpg" width="180" height="180" alt="Yan Beaucage">
					<a class="equipe_contact" href="mailto:yanbeaucage@eipmondial.com?subject=a message from EIP website">Contact</a>
				</div>
				<p>Yan Beaucage<br/><span>Président Fondateur</span></p>	
			</div>		
			<div class="col-lg-2"></div>
			<div class="col-lg-3 col-sm-6 col-xs-12">
				<div id="equipe1">
					<img class="president-image" src="mondial/img/sam.jpg" width="180" height="180" alt="Samuel Matrin">
					<a class="equipe_contact" href="mailto:samuelmartin@eipmondial.com?subject=a message from EIP website">Contact</a>
				</div>
				<p>Samuel Martin<br/><span>Co-Fondateur</span></p>	
			</div>		
		</div>	

		<div class="motfondateur">	
			<div class="col-lg-8 col-lg-offset-2">
				<h2>Mot du Fondateur et Co-fondateur</h2>
				<p>Notre mentalité s’exprime par l’entraide des jeunes entrepreneurs plutôt que de les écraser. Cet objectif nous permet de créer l’investissement privé le plus sécuritaire et garantie du Canada à seulement <span class="colorWhite">12% </span> d’intérêt annuellement. C’est une fierté pour nous de pouvoir aider les gens et de stimuler notre économie.</p>
			</div>
		</div>
	</div>	
</section>


<section id="solution" class="content-section text-center">

	<div class="div1">
	    <div class="container div2">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				 <h3><span>E.I.P Solution</span><br/>La solution d’affaires</h3>
				 <h3><span>E.I.P Solution,</span> Le projet clé en main qui vous propulsera vers le <span>succès!</span></h3>
				 <h3 class="h3-1"><i class="fa fa-phone-square"></i> 1 (888) 368-8949</h3>
			</div>
	        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	            <a href="http://eipsolution.com" target="_blank" class="btn btn-default btn-lg">
					<img src="mondial/img/solu.jpg" alt="">
	                <br/>Visitez E.I.P solution
				</a>
	        </div>
	    </div>
	</div>	


	<div id="joindre" style="margin-bottom: 10px;" class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
		<h1>Nous Contacter</h1>
	</div>
	<div class="row after-joindre">
        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
			<form class="form-horizontal" role="form" method="post" action="index.php#contactForm">
				<div class="form-group">
					<label for="name" class="col-sm-4 control-label">Nom <span style="font-size: .8em;">(Prénom et nom)</span></label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="name" name="name" placeholder="First & Last Name" value="<?php if($mailErr == 'y'){echo $name;} ?>">
						<?php if($mailErr == 'y') {echo "<span class='text-danger' style='font-size:.9em;'>$errName</span>";}?>
					</div>
				</div>
 			    <div class="form-group">
					<label for="email" class="col-sm-4 control-label">Adresse courriel</label>
					<div class="col-sm-8">
						<input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="<?php if($mailErr == 'y'){echo $email;} ?>">
						<?php if($mailErr == 'y'){echo "<span class='text-danger' style='font-size:.9em;'>$errEmail</span>";}?>
					</div>
				</div>
				<div class="form-group">
					<label for="phone" class="col-sm-4 control-label">Numéro de téléphone</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="phone" name="phone" placeholder="000 000 0000" value="<?php if($mailErr == 'y'){echo $phone;}?>">
							<?php if($mailErr == 'y') {echo "<span class='text-danger' style='font-size:.9em;'>$errPhone</span>";}?>
					</div>
				</div>
				<div class="form-group">
					<label for="message" class="col-sm-4 control-label">Message</label>
					<div class="col-sm-8">
						<textarea class="form-control" rows="4" name="message"><?php if($mailErr == 'y'){echo $message;}?></textarea>
							<?php if($mailErr == 'y') {echo "<span class='text-danger' style='font-size:.9em;'>$errMessage</span>";}?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10 col-sm-offset-2">
						<input id="submitMail" name="submitMail" type="submit" value="Envoyer le message" class="btn btn-primary">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10 col-sm-offset-2 div4">
							<?php if($mailErr == 'n'){echo $messageMail;} ?>    
					</div>
				</div>
			</form> 
        </div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<a href="tel:-18883688949" class="telLink"><i class="fa fa-phone-square"></i> Téléphone : 1 (888) 368-8949</a>
			<a href="https://www.facebook.com/eip-mondial-inc-1704373986486308/?ref=hl" target="_blank" class="btn btn-default btn-lg" style="margin:0 auto;"><i class="fa fa-facebook fa-fw"></i> <span class="network-name">Facebook</span></a>
		</div>
	</div>
</section>

<section id="carrier" class="content-section">
	<div class="car1" onclick="carrier()">
		<span>X</span>
	</div>
    <div class="container">
		<div class="col-lg-4 col-lg-offset-4 col-sm-4 col-sm-offset-4 col-xs-12">
			<h2>Carrière</h2>
		</div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 car2">
			<p><span>
				<span>Représentant des ventes en investissement</span><br/>
				<span>Envoyez votre CV à <a href="mailto:rh@eipmondial.com?subject=Candidature - Représentant des ventes en investissement">rh@eipmondial.com</a></span>
			</p>
			<hr>
			<p><span>
				<span>Représentant des ventes aux détaillants</span><br/>
				<span>Envoyez votre CV à <a href="mailto:rh@eipmondial.com?subject=Candidature - Représentant des ventes aux détaillants">rh@eipmondial.com</a></span>
			</p>
			<hr>
			<p><span>
				<span>Représentant des ventes en conseils et services</span><br/>
				<span>Envoyez votre CV à <a href="mailto:rh@eipmondial.com?subject=Candidature - Représentant des ventes en conseils et services">rh@eipmondial.com</a></span>
			</p>
		</div>
        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
        </div>
    </div>
</section>	

<section id="actualite" class="content-section">
	<div class="actual" onclick="actual()">
		<span>X</span></div>
    <div class="container">
	<div class="col-lg-4 col-lg-offset-4 col-sm-4 col-sm-offset-4 col-xs-12">
		<h2>Actualité</h2>
	</div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 actual2">
		<img src="mondial/img/actual.jpg" width="100%">
	</div>
    </div>
</section>	


<footer>
    <div class="container text-center">
        <li><a target="_blank" href="securemail">EIP Mailing system</a></li>
        <li><a onclick="actual()" href="#actualite">Actualité</a></li>
        <li><a onclick="carrier()" href="#carrier">Carrière</a></li>
		<li>Copyright &copy; E.I.P.MONDIAL 2001</li>
    </div>
</footer>

    <script src="mondial/js/jquery.easing.min.js"></script>

</body>

</html>
