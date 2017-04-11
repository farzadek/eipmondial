<?php
$errors = array();     
$data = array();      

// validate the variables ======================================================
function generateRandomString($length = 8) {
    $characters = '123456789abcdefghijkmnpqrstuvwxyz123456789ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

        $mail = trim($_POST['code']);

        include("connect.php");
        $sql = "SELECT * FROM users WHERE email='$mail' AND type<>'1' AND type<>'2'";
        $result = mysql_query($sql, $user_con) or die(mysql_error());
        $row = mysql_fetch_assoc($result);
        if (!$row){
            $errors['name'] = 'Cette adresse e-mail n\'existe pas dans notre système!'; 
        }


// return a response ===========================================================
    if ( ! empty($errors)) {
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $email = $row['email'];
        $ps = generateRandomString();
        $sql = "UPDATE users SET password = '$ps' WHERE email='$mail'";
        $result = mysql_query($sql, $user_con) or die(mysql_error());
        $msg = '<html><head><title>Message from EIP.Mondial - Website</title></head><body><p>Your password changed in our system.</p><p>Your new password is : '.$ps.'</p></body></html>';
        mail($ps,'Email from EIP.Mondial website',$msg, $headers);

        $data['success'] = true;
    }
    echo json_encode($data);
 ?>




