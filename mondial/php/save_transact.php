<?php
session_start();
$errors         = array();      // array to hold validation errors
$data           = array();      // array to pass back data
// validate the variables ======================================================
    // if any of these variables don't exist, add an error to our $errors array
        $today = $_POST['today'];
		$date_regex = '/^(20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/';
   if (!preg_match($date_regex, $today)){
        $errors['name'] = 'La date n\'est pas correcte.'."\r\n"; 
    }

        $code = trim($_POST['code']);
        $amount = filter_var(trim($_POST['amount']), FILTER_SANITIZE_NUMBER_INT);

        include("connect.php");
        $sql = "SELECT * from loan WHERE lvpcode='$code'";
        $result = mysql_query($sql, $user_con) or die(mysql_error());
        $row = mysql_fetch_assoc($result);
        if(!$row){$errors['name'] .= 'Cet utilisateur est introuvable!';}
        else{
        	if(-$row['payable']>$amount){$errors['name'] = 'Le montant payable: '.$row['payable'].'$'."\r\n";}
        }

// return a response ===========================================================

    if ( ! empty($errors)) {

        $data['success'] = false;
        $data['errors']  = $errors;
    } else {


/*
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
            $msg = '<html><head><title>Message from EIP.Solution</title></head><body><table><tr style="font-size:14px;">'.$prename.' '.$name.'</tr><tr style="font-size:14px;">'.$phone.'</tr><tr style="font-size:14px;">'.$email.'</tr></table>Enregsitre dans system EIP.SOLUTION</body></html>';
            mail('info@eipmondial.com','Email from Solution page - EIP website',$msg, $headers);

            $messageMail = '<html><head><title>Message from EIP.Solution</title></head><body><p style="font-size:16px">Vous avez enregistre dns le system EIP.Solution.</p><p style="font-size:12px">USERNAME: '.$email.'<br/>MOT DE PASSE: '.$pass.'</p></body></html>';
            mail($email,'EIP SOLUTION Inc. mail System',$messageMail, $headers);
  */         
        // if there are no errors process our form, then return a message

        // DO ALL YOUR FORM PROCESSING HERE
        // THIS CAN BE WHATEVER YOU WANT TO DO (LOGIN, SAVE, UPDATE, WHATEVER)

        // show a message of success and provide a true success variable
        $operator = $_SESSION['vpcode'];
		$sql="INSERT INTO transactions (date, client, amount, capital, tr_operator) VALUES ('$today', '$code', $amount, 0, '$operator')";
		$query = mysql_query($sql, $user_con) or die(mysql_error());

        $data['success'] = true;
        $data['message'] = 'Processus: 1OK!';
    }

    // return all our data to an AJAX call
    echo json_encode($data);
 ?>
