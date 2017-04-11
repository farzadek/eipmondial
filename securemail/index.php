<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EIP.MONDIAL - Secure Internal Mailing System</title>

    <!-- Bootstrap Core CSS -->
    <script src="../mondial/js/jquery.js"></script>
    <link href="../mondial/css/bootstrap.min.css" rel="stylesheet">
    <script src="../mondial/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link rel="shortcut icon" href="../mondial/img/icon32.png">

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<style>
table{
	border: 2px solid orange;
	margin: 1em;
	padding: 2px;
}
th{
	color: white;
	font: 1.4em/1.2em roboto;
	font-weight: 700;
	background-color: orange;
	text-align: center;
	padding: 2px;
}
td{
	text-align: center;
	color: black;
	font: 1.2em/1.2em roboto;
	padding: 2px;
}
td:nth-child(1){width: 75px;}
td:nth-child(2){width: 200px;text-align: left;}
td:nth-child(3){width: 250px;text-align: left;font: 1em/1.2em roboto;}
td:nth-child(4){width: 150px;}
button{
	float: right;
}
h1{
	font: 2.8em/1.5em roboto;	
}
h2{
	font: 2.5em/1.5em roboto;	
}
pre{
	position: absolute;
	top: 81px;
	left: 700px;
	width: 500px;
	height: 500px;
	overflow-y: scroll;
	background-color:rgba(255,165,0,.2); 
	font: 1.2em/1.6em roboto;
}
tr:nth-child(odd){ 
	background-color:rgba(255,165,0,.2); 
}
</style>
<?php
include("../mondial/php/connect.php");
if(isset($_COOKIE['log'])){$loggedin=true;}else{$loggedin=false;}
$username='';
$password='';
$date='';
$subject='';
$message='';

    if (isset($_POST["submitMail"])) {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
		$sql = "SELECT name FROM usermail WHERE username='$username' AND BINARY passw=BINARY '$password'";
		$result = mysql_query($sql, $user_con) or die(mysql_error());
		$row = mysql_fetch_assoc($result);
		$owner = $row['name'];
		if($row){setcookie('log', '0', time() + (60 * 15), "/");}
		$sql = "SELECT id, senddate, subject FROM emails ORDER BY senddate DESC";
		$result = mysql_query($sql, $user_con) or die(mysql_error());
		mysql_close($user_con);
	}	
		
?>

<body>

<?php if(!$loggedin){  ?>
	<section>
	    <div class="col-sm-11 col-sm-offset-1">
			<h1>Login <small>EIP - Internal Secure Mailing System</small></h1>
		</div>
		<div class="row">
	        <div class="col-sm-4 col-sm-offset-1">
				<form class="form-horizontal" method="post">
					<div class="form-group">
						<label for="name" class="col-sm-3">Username</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="username" name="username">
						</div>
					</div>
	 			    <div class="form-group">
						<label for="email" class="col-sm-3">Password</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" id="password" name="password" autocomplete="off">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6 col-sm-offset-3">
							<input id="submitMail" name="submitMail" type="submit" value=" Login " class="btn btn-primary">
						</div>
					</div>
				</form> 
	        </div>
		</div>
	</section>
<?php }
else{ ?>
	<section>
	    <div class="col-sm-11 col-sm-offset-1">
			<h2>EIP - Internal Secure Mailing System</h2>
			<h3>Hi <span style="color:rgba(255,165,0,.8);"><?php echo $owner; ?></span></h3>
		</div>		
		<table>
			<th>ID</th><th>DATE</th><th>SUBJECT</th><th></th>
			<?php $now=0; 
			while($now < mysql_num_rows($result)){
				$row = mysql_fetch_assoc($result);
				echo '<tr><td>'.$row["id"].'</td><td>'.$row["senddate"].'</td><td>'.$row["subject"].'</td><td><button id="'.$row["id"].'" class="btn btn-sm btn-info" id="'.$row["id"].'">Read message</button></td></tr>';
				$now++;
			} ?>
		</table>
		<pre id="message"></pre>
	</section>
<?php } ?>

<script>
    $("button").on("click", function(){
        var term = $(this).attr('id');
        if(term.length){
            $.get("mailreader.php", {query: term}).done(function(data){
                $("#message").html(data);
            });
        } else{
            $("#message").empty();
        }
    });
</script>
</body>

</html>
