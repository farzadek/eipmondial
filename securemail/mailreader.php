<?php
$errors         = array();
$text='';
setcookie('log', '0', time() + (60 * 15), "/");

        $id = $_REQUEST['query'];
        include("../mondial/php/connect.php");
        $sql = "SELECT message FROM emails WHERE id='$id'";
        $result = mysql_query($sql, $user_con) or die(mysql_error());
        $row = mysql_fetch_assoc($result);
        if(!$row){$errors['name'] = 'Ooops! Je peux pas trouver le message!!!';}
        else{$text=$row['message'];}

// return a response ===========================================================

    if (empty($errors)) {
/*		$sql="UPDATE emails SET read=1 WHERE id=$id";
		$query = mysql_query($sql, $user_con) or die(mysql_error());
*/
    }
        mysql_close($user_con);
    echo $text;
 ?>