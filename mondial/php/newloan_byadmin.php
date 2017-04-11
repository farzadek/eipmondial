<?php
session_start();
$errors = array();     
$data = array();      
function validate_amount( $amount ) {
    $formats = array("/^[1-9][0-9]{1,}[.]{0,1}[0-9]{1,2}$/i");
    foreach( $formats as $format ) {
        if( preg_match($format, $amount) ) return true;
    }
    return false; 
}
// validate the variables ======================================================
        $today = date("Y-m-d");
        $code = trim($_POST['client']);
        $amount = floatval($_POST['amount']);
        $stdate = trim($_POST['stdate']);
        $findate = trim($_POST['findate']);
       // $reqtype = $_POST['requesttype'];
  //      if($reqtype=='Loan'){$isloan=1;$pq='d\'investissement';}else{$isloan=0;$pq='de prêt';}
/*
   if (!validate_amount($amount)){
        $errors['name'] = 'Montant n\'est pas correcte. format correct -> 12.34'."\r\n"; 
    }
*/
        $refby = $_SESSION['vpcode'];

        include("connect.php");
        $sql = "SELECT * from loan WHERE lvpcode='$code'";
        $result = mysql_query($sql, $user_con) or die(mysql_error());
        $row = mysql_fetch_assoc($result);
        if($row){$errors['name'] = 'Il existe déjà un dossier d\'investissement pour ce client!';}

// return a response ===========================================================
    if ( ! empty($errors)) {

        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

        $sql = "INSERT INTO loan (lvpcode, refby, amount, situation, dateok, isloan, interest, invest_date_start, stop_date, lastupdate) values 
                                 ('$code', '$refby', $amount, 'OK', '$stdate', 0, 12, '$stdate', '$findate', '$stdate')"; 
        mysql_query($sql, $user_con);

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
/*        $msg = '<html><head><title>Message from EIP.Solution</title></head><body><h3>Client registered for EIP.Mondial</h3><table style="width:400px; border:2px solid black;font-size:18px;"><tr style="background-color:#483D8B;color: white;"><p style="padding:0 3px;">Nom:<strong> '.$famil.', '.$name.'</strong></p></tr><tr><p style="padding:0 3px;">Tel: <strong>'.$phone.'</strong></p></tr><tr style="background-color:#483D8B;color: white;"><p style="padding:0 3px;">Couriel: <strong>'.$email.'</strong></p></tr><tr><p style="padding:0 3px;">adress: '.$adress.', '.$city.', '.$province.', ('.$postal.')</p></tr><tr style="background-color:#483D8B;color: white;"><p style="padding:0 3px;">Referred by: <strong>'.$refby.'</strong></p></tr></table><p style="padding:0 3px;">'.$today.'</p></body></html>';
        mail('info@eipmondial.com','New registration on EIP.Mondial website',$msg, $headers);

        $messageMailp = '<html><head><title>Message from EIP.Mondial inc.</title></head><body><img src="http://eipmondial.com/mondial/img/eip_new_logo.png" width="200" style="margin:10px 100px;"><h2>M./Mme. '.$famil.', '.$name.'</h2><p style="font-size:20px">Welcome to EIP.Mondial Inc.</p><p style="font-size:18px">Your account is created and now it\'s active, please login to your account. (Link below)</p><p style="font-size:18px"><a href="http://eipmondial.com/mondial/php/login.php" target="_blank">http://eipMondial.com/login</a></p><p style="font-size:18px">Usename : '.$email.'</p><p style="font-size:18px">Password : '.$pw.'</p></body></html>';
        mail($email,'EIP MONDIAL Inc. mail System',$messageMailp, $headers);
*/
        $data['success'] = true;
        $data['message'] = 'Processus: OK!';
    }
    echo json_encode($data);
 ?>




