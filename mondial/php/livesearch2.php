<?php
include('connect.php');
$query = $_REQUEST['query'];
 
if(isset($query)){
    // Attempt select query execution
    $sql = "SELECT * FROM users JOIN member ON users.vpcode=member.vpcode WHERE LOWER(users.name_user) LIKE LOWER('%".$query."%') limit 5";
    if($result = mysql_query($sql, $user_con)){
        if(mysql_num_rows($result) > 0){
            while($row = mysql_fetch_array($result)){
                echo $row['score'].'|'.$row['montantalloe'].'|'.$row['dettereal'].'|'.$row['dayforpay'].'|'.$row['bank1'].'|'.$row['accountno'].'|'.$row['stdate'].'|'.$row['enddate']; 
            }
            // Close result set
            mysql_free_result($result);
        } else{
            echo "<p>No matches found for <b>$query</b></p>";
        }
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysql_error($user_con);
    }
};
?>