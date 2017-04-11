<?php
session_start();
$errors         = array();     
$data           = array();      
function validate_phone( $phone_number ) {
    $formats = array(
        "/^([1]-)?[1-9]{1}[0-9]{6}$/i", 
        "/^([1]-)?[1-9]{3}-[0-9]{3}-[0-9]{4}$/i", 
        "/^([1]-)?[1-9]{3} [0-9]{3} [0-9]{4}$/i", 
        "/^([1]-)?\([1-9]{3}\)-[0-9]{3}-[0-9]{4}$/i", 
        "/^([1]-)?\([1-9]{3}\) [0-9]{3}-[0-9]{4}$/i",
        "/^[1-9]{1}[0-9]{9}$/i" 
        );
    foreach( $formats as $format ) {
        if( preg_match( $format, $phone_number ) ) return true;
    }
    return false; 
}
// validate the variables ======================================================
        $today = date("Y-m-d");
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $postal = $_POST['postal'];

//		$email_regex = '/^[A-Z0-9._%+-]{2,}+@[A-Z0-9.-]{2,}+\.[A-Z.]{2,}$/';
        $postal_regex = '/^[ABCEGHJKLMNPRSTVXYabceghjklmnprstvxy][0-9][ABCEGHJKLMNPRSTVWXYZabceghjklmnprstvwxy] ?[0-9][ABCEGHJKLMNPRSTVWXYZabceghjklmnprstvwxy][0-9]$/';
   if (!validate_phone($phone)){
        $errors['name'] = 'No. de téléphone n\'est pas correcte.'."\r\n"; 
    }
//   if (!preg_match($email_regex, $email)){$errors['name'] = 'L\'adresse courriel n\'est pas correcte.'."\r\n";}
   if (!preg_match($postal_regex, $postal)){
        $errors['name'] = 'Code postale n\'est pas correcte.'."\r\n"; 
    }

        $name = $_POST['name'];
        $famil = $_POST['famil'];
        $adress = $_POST['adress'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $pw = $_POST['pw'];
        $nm = $name.' '.$famil;
        $refby = $_POST['refby'];



        include("connect.php");
        $sql = "SELECT * from users WHERE email='$email'";
        $result = mysql_query($sql, $user_con) or die(mysql_error());
        $row = mysql_fetch_assoc($result);
        if($row){$errors['name'] = 'Cette courriel est déjà enregistrée!';}

// return a response ===========================================================
    if ( ! empty($errors)) {

        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

        $ty = date("Y");
        $sql = "select count('id') as counts from users where YEAR(memberdate)=$ty"; 
        if (mysql_query($sql, $user_con)) {
            $result = mysql_query($sql, $user_con) or die(mysql_error());
            $r = mysql_fetch_assoc($result);
        } 
        else {
            echo "Error: " . $sql . "<br>" . mysql_error($user_con);
        }
        $ty= $r['counts']+1;
        if($ty<10){$ty='00'.$ty;}elseif($ty<100 && $ty>9){$ty='0'.$ty;}
        $ty1='VP'.date("y").$ty;

        $sql = "INSERT INTO member (vpcode, name, famil, adress, city, province, postal, email, phone1, membrtype, refno, active) 
                VALUES ('$ty1', '$name', '$famil', '$adress', '$city', '$province', '$postal', '$email', '$phone', '3', '$refby', 0)";

        $sql_o = "INSERT INTO users (vpcode, name_user, type, username, password, active, email, referredby) 
                  VALUES ('$ty1', '$nm', '3', '$email', '$pw', 0, '$email', '$refby')"; 

        $result = mysql_query($sql, $user_con) or die(mysql_error());
        $result_o = mysql_query($sql_o, $user_con) or die(mysql_error());

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
/*        $msg = '<html><head><title>Message from EIP.Solution</title></head><body><h3>Client registered for EIP.Mondial</h3><table style="width:400px; border:2px solid black;font-size:18px;"><tr style="background-color:#483D8B;color: white;"><p style="padding:0 3px;">Nom:<strong> '.$famil.', '.$name.'</strong></p></tr><tr><p style="padding:0 3px;">Tel: <strong>'.$phone.'</strong></p></tr><tr style="background-color:#483D8B;color: white;"><p style="padding:0 3px;">Couriel: <strong>'.$email.'</strong></p></tr><tr><p style="padding:0 3px;">adress: '.$adress.', '.$city.', '.$province.', ('.$postal.')</p></tr><tr style="background-color:#483D8B;color: white;"><p style="padding:0 3px;">Referred by: <strong>'.$refby.'</strong></p></tr></table><p style="padding:0 3px;">'.$today.'</p></body></html>';
        mail('info@eipmondial.com','New registration on EIP.Mondial website',$msg, $headers);
*/
        $messageMailp = '<html><head><title>Message from EIP.Mondial inc.</title></head><body><img src="http://eipmondial.com/mondial/img/eip_new_logo.png" width="200" style="margin:10px 100px;"><h2>M./Mme. '.$famil.', '.$name.'</h2><p style="font-size:20px">Welcome to EIP.Mondial Inc.</p><p style="font-size:18px">Your account is created and now it\'s active, please login to your account. (Link below)</p><p style="font-size:18px"><a href="http://eipmondial.com/mondial/php/login.php" target="_blank">http://eipMondial.com/login</a></p><p style="font-size:18px">Usename : '.$email.'</p><p style="font-size:18px">Password : '.$pw.'</p></body></html>';
        mail($email,'EIP MONDIAL Inc. mail System',$messageMailp, $headers);

        $data['success'] = true;
    }
    echo json_encode($data);
 ?>




