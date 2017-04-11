<?php
session_start();
if(isset($_SESSION['a']) && $_SESSION['a']<3){
include('connect.php');
$err='';
$errMsg = '';
    if(isset($_GET["page"]))
        $page = (int)$_GET["page"];
    else
        $page = 1;

    $setLimit = 15;
    $pageLimit = ($page * $setLimit) - $setLimit;

    if(isset($_POST['saveCapital'])){
        $amount = filter_var(trim($_POST['amount']), FILTER_SANITIZE_NUMBER_INT);
        $today = $_POST['today'];
        $code1 = trim($_POST['code']);
        $operator = $_SESSION['vpcode'];
        $sql="INSERT INTO transactions (date, client, amount, capital, tr_operator) VALUES ('$today', '$code1', 0, $amount, '$operator')";
        $query = mysql_query($sql, $user_con) or die(mysql_error());
        $sql1="UPDATE loan SET dateok='$today' WHERE lvpcode='$code1'";
        $query1 = mysql_query($sql1, $user_con) or die(mysql_error());
    }

/* * Save Changed Info ********************************************** */
if(isset($_POST['saveAdminInfo'])){
    $name = htmlspecialchars(stripslashes(trim($_POST['name'])));
    $famil = htmlspecialchars(stripslashes(trim($_POST['famil'])));
    $name_user = $name.' '.$famil;
    $vp = htmlspecialchars(stripslashes(trim($_SESSION['vp'])));
    $adress = htmlspecialchars(stripslashes(trim($_POST['adress'])));
    $city = htmlspecialchars(stripslashes(trim($_POST['city'])));
    $province = htmlspecialchars(stripslashes(trim($_POST['province'])));
    $postal = htmlspecialchars(stripslashes(trim($_POST['postal'])));
    $sql=$_POST['birthdate'];
    $birthdate = date("Y-m-d",strtotime($sql));
    $email = trim($_POST['email']);
    $active = trim($_POST['active']);
    $refno = trim($_POST['refno']);
    $phone = trim($_POST['phone1']);
    $filename = '';
    define("UPLOAD_DIR", "image/");
    $uploadOk = 1;
    $filename='';
    $err = '';
    $savedFile = false;   

        if(isset($_FILES["pdf_file"]) and !empty($_FILES["pdf_file"])){
           $myFile = $_FILES["pdf_file"];

            if ($myFile["error"] !== UPLOAD_ERR_OK) {
                $err.="<p>An error occurred.</p>";
                //exit;
            }

            if(!$err){
                $filename = $vp.'_'.preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);
                // don't overwrite an existing file
/*                $i = 0;
                $parts = pathinfo($filename);
                if($parts["extension"]!='pdf'){
                    $err.="<p>NOT PDF</p>";
                    //exit;
                }
/*                while (file_exists(UPLOAD_DIR . $filename)) {
                    $i++;
                    $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
                }
*/
                // preserve file from temporary directory
                if(!$err){
                    $success = move_uploaded_file($myFile["tmp_name"],UPLOAD_DIR . $filename);
                    if (!$success) { 
                        $err.="<p>Unable to save file.</p>";
                        //exit;
                    }
                    else{
                    // set proper permissions on the new file
                    chmod(UPLOAD_DIR . $filename, 0644);     
                    $savedFile = true;   
                    }
                }
            }
        }

    if($savedFile){ 
        $sql = "UPDATE member SET infopdf='$filename' WHERE vpcode='$vp'"; 
        $query = mysql_query($sql, $user_con) or die(mysql_error());
    }    
    $sql = "UPDATE member SET name='$name',famil='$famil',adress='$adress',city='$city',province='$province',postal='$postal',email='$email',active='$active',refno='$refno',phone1='$phone', birthdate='$birthdate' WHERE vpcode='$vp'";
    $query = mysql_query($sql, $user_con) or die(mysql_error());
    $sql = "UPDATE users SET name_user='$name_user',active='$active',email='$email',referredby='$refno' WHERE vpcode='$vp'";
    $query = mysql_query($sql, $user_con) or die(mysql_error());
}
/* *********************************************** */

   function displayPaginationBelow($per_page,$page){
       $page_url="?";
        $query = "SELECT COUNT(*) as totalCount FROM users";
        $rec = mysql_fetch_array(mysql_query($query));
        $total = $rec['totalCount'];
        $adjacents = "2"; 

        $page = ($page == 0 ? 1 : $page);  
        $start = ($page - 1) * $per_page;                               
        
        $prev = $page - 1;                          
        $next = $page + 1;
        $setLastpage = ceil($total/$per_page);
        $lpm1 = $setLastpage - 1;
        
        $setPaginate = "";
        if($setLastpage > 1)
        {   
            $setPaginate .= "<ul class='setPaginate'>";
                    $setPaginate .= "<li class='setPage'>Page $page of $setLastpage</li>";
            if ($setLastpage < 7 + ($adjacents * 2))
            {   
                for ($counter = 1; $counter <= $setLastpage; $counter++)
                {
                    if ($counter == $page)
                        $setPaginate.= "<li><a class='current_page btn btn-info'>$counter</a></li>";
                    else
                        $setPaginate.= "<li><a href='{$page_url}page=$counter' class='btn btn-info'>$counter</a></li>";                 
                }
            }
            elseif($setLastpage > 5 + ($adjacents * 2))
            {
                if($page < 1 + ($adjacents * 2))        
                {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                    {
                        if ($counter == $page)
                            $setPaginate.= "<li><a class='current_page btn btn-info'>$counter</a></li>";
                        else
                            $setPaginate.= "<li><a href='{$page_url}page=$counter' class='btn btn-info'>$counter</a></li>";                 
                    }
                    $setPaginate.= "<li class='dot'>...</li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1' class='btn btn-info'>$lpm1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage' class='btn btn-info'>$setLastpage</a></li>";     
                }
                elseif($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                {
                    $setPaginate.= "<li><a href='{$page_url}page=1' class='btn btn-info'>1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=2' class='btn btn-info'>2</a></li>";
                    $setPaginate.= "<li class='dot'>...</li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                    {
                        if ($counter == $page)
                            $setPaginate.= "<li><a class='current_page btn btn-info'>$counter</a></li>";
                        else
                            $setPaginate.= "<li><a href='{$page_url}page=$counter' class='btn btn-info'>$counter</a></li>";                 
                    }
                    $setPaginate.= "<li class='dot'>..</li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1' class='btn btn-info'>$lpm1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage' class='btn btn-info'>$setLastpage</a></li>";     
                }
                else
                {
                    $setPaginate.= "<li><a href='{$page_url}page=1' class='btn btn-info'>1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=2' class='btn btn-info'>2</a></li>";
                    $setPaginate.= "<li class='dot'>..</li>";
                    for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++)
                    {
                        if ($counter == $page)
                            $setPaginate.= "<li><a class='current_page btn btn-info'>$counter</a></li>";
                        else
                            $setPaginate.= "<li><a href='{$page_url}page=$counter' class='btn btn-info'>$counter</a></li>";                 
                    }
                }
            }
            
            if ($page < $counter - 1){ 
                $setPaginate.= "<li><a href='{$page_url}page=$next' class='btn btn-info'>Next</a></li>";
                $setPaginate.= "<li><a href='{$page_url}page=$setLastpage' class='btn btn-info'>Last</a></li>";
            }else{
                $setPaginate.= "<li><a class='current_page btn btn-info'>Next</a></li>";
                $setPaginate.= "<li><a class='current_page btn btn-info'>Last</a></li>";
            }

            $setPaginate.= "</ul>\n";       
        }
    
    
        return $setPaginate;
    } 



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

?>  
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>EIP Mondial - Admin page</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../grayscale.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="../img/icon32.png">
    <script src="../js/grayscale.js"></script>
    <script src="../js/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>    
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->    
    <style>
    .wrapper{
        overflow-x: scroll;
        padding: 10px;
        font-family: Montserrat;
    }
    table#acrylic {
        border-collapse: separate;
        background: #fff;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        margin: 10px auto;
        -moz-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        -webkit-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        width: 90%;
    }
    #acrylic thead {
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
    }  
    #acrylic thead th {
        font-size: 1em;
        font-weight: 400;
        color: #fff;
        text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.5);
        text-align: center;
        padding: 5px 3px;

        background-size: 100%;
        background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #646f7f), color-stop(100%, #4a5564));
        background-image: -moz-linear-gradient(#646f7f, #4a5564);
        background-image: -webkit-linear-gradient(#646f7f, #4a5564);
        background-image: linear-gradient(#646f7f, #4a5564);
        border-top: 1px solid #858d99;
        border-right: 1px solid #858d99;
    }
    #acrylic thead th:last-child {
        border-right: none;
    }        
    #acrylic thead th:first-child {
        -moz-border-top-right-radius: 5px;
        -webkit-border-top-left-radius: 5px;
        border-top-left-radius: 5px;
    }
    #acrylic thead th:last-child {
        -moz-border-top-right-radius: 5px;
        -webkit-border-top-right-radius: 5px;
        border-top-right-radius: 5px;
    }
    #acrylic thead th:nth-child(1) { width: 2%; }  
    #acrylic thead th:nth-child(2) { width: 7%; }  
    #acrylic thead th:nth-child(3) { width: 17%; }  
    #acrylic thead th:nth-child(4) { width: 2%; }  
    #acrylic thead th:nth-child(5) { width: 9%; }  
    #acrylic thead th:nth-child(6) { width: 11%; }  
    #acrylic thead th:nth-child(7) { width: 20%; }  
    #acrylic thead th:nth-child(8) { width: 5%; }  
    #acrylic thead th:nth-child(9) { width: 5%; }  
    #acrylic thead th:nth-child(10) { width: 5%; }  
    #acrylic thead th:nth-child(11) { width: 3%; }  
    #acrylic tbody tr td {
        font-weight: 400;
        color: #5f6062;
        font-size: 12px;
        padding: 10px;
        border-bottom: 1px solid #e0e0e0;
    }
    #acrylic tbody tr:nth-child(2n) {
        background: #f0f3f5;
    }
    #acrylic tbody tr:last-child td {
        border-bottom: none;
    }
    #acrylic tbody tr:last-child td:first-child {
        -moz-border-bottom-right-radius: 5px;
        -webkit-border-bottom-left-radius: 5px;
        border-bottom-left-radius: 5px;
    }       
    #acrylic tbody tr:last-child td:last-child {
        -moz-border-bottom-right-radius: 5px;
        -webkit-border-bottom-right-radius: 5px;
        border-bottom-right-radius: 5px;
    }
        @media screen and (max-width: 767px) {
            #acrylic thead {
                display: none;
            }
            #acrylic tr {
                margin-bottom: 10px;
                display: block;
            }
            #acrylic td {
                display: block;
                text-align: right;
                font-size: 13px;
                border-bottom: 1px dotted #ccc;
            }
            #acrylic td:last-child {
                border-bottom: 0;
            }
            #acrylic td:before {
                content: attr(data-label);
                float: left;
                text-transform: uppercase;
                font-weight: bold;
            }
            table#acrylic {
                width: 100%;
            }
        }
        .form-container{
            right: 0;
            left: 0;
            top: 3%;
            padding: 3px;
            position: absolute;
            background-color: white;
            box-shadow: 2px 2px 5px #999;
            width: 50%;
            overflow: hidden;
            margin: 0 auto;
            border-radius: 10px;
            z-index: 950;
          }
        .disabler{
            width: 100%;
            min-height: 100%;
            display: table;
            background-color: rgba(20,20,20,.4);
            position: absolute;
            top: 0;
            float: right;
            z-index: 900;
        }  
        form#edit_users{
            padding: 5px 10px 10px 10px;
            border: 3px solid #5bc0de;
            border-radius: 10px;
            margin-bottom: 0;
        }
        form#edit_users label{
            color: #333;
            font-size: 1.1em;
        }
        form#edit_users input{
            color: #393939;
        }
        form#edit_users .row{
            margin-top: 25px;
        }
        .paginate{
            margin: 0 auto;
            display: table;
            color: black;
        }
        .paginate li{
            display: inline;
            margin: 5px 1px;
        }
        .paginate li a{
            display: inline-block;
        }
        .adminCtrl{
            position: absolute;
            bottom: 8px;
            left: 0;
            display: block;
            border: 1px solid #999;
            padding: 0 5px;
            box-shadow: 3px 3px 5px #999;
            border-radius: 0 10px 10px 0;
        }
        .adminCtrl a{
            margin: 5px 0;
            width: 100%;
        }
        .adminCtrl a:first-child{
            border-radius: 0 8px 0 0;
        }
        .adminCtrl a:last-child{
            border-radius: 0 0 8px 0;
        }
        #hammenu{
            position: fixed;
            top:0;
            right:0;
            width: 40px;
            height: 40px;
            background-color: #f0ad4e;
            border-bottom-left-radius: 10px;
            padding: 8px 0 0 10px;
            color: white;
        }
        #hammenu i{
            font-size: 1.8em;
            cursor: pointer;
        }
        #tabs-wrapper{
            position: absolute;
            top: 38px;
            right: 38px;
            background-color: white;
            padding: 3px;
            box-shadow: 0 0 8px #888;
            border-radius: 10px;
            display: none;
        }
        #tabs-wrapper #tabs{
            border: 3px solid #5bc0de;
            border-radius: 10px;
            display: block;
            padding: 1em 1.4em;
            background: none;
        }
        #tabs-wrapper #tabs ul{
            padding-left: 0;
            -webkit-padding-start: 0;
            padding-bottom: 1em;
            border-bottom: 1px solid #5bc0de;
        }
        #tabs-wrapper #tabs li{
            display: inline;
            margin:2px;
        }
        #tabs-wrapper #tabs li:first-child{
            display: none;
        }        
        #tabs-wrapper #tabs li a{
            text-transform: uppercase;
            font-family: "Montserrat";
            font-weight: 400;
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
            display: inline;
        }
        .user_image_edit{
            background-size: cover;
            background-repeat: no-repeat;
            background-position: 50% 50%;            
            border-radius: 50%;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            border: 3px solid #5bc0de;
            float: left;
            margin-right: 10px;
            overflow: hidden;
            box-sizing: border-box;
            width: 75px;
            height: 75px;
        }
        .user_image_table{
            background-size: cover;
            background-repeat: no-repeat;
            background-position: 50% 50%;            
        }


    </style>
</head>
<body>
<div class="wrapper">
    <a class="btn btn-warning" href="<?php echo htmlspecialchars('../../index.php'); ?>" id="cancel">LogOut</a>

<?php 
        $sql = "SELECT * FROM users JOIN member ON users.vpcode=member.vpcode WHERE users.type!='1' order by memberdate desc LIMIT ".$pageLimit." , ".$setLimit;
        $query = mysql_query($sql, $user_con) or die(mysql_error());
        $allPages = mysql_num_rows($query);
       ?>
    <table id="acrylic">
        <thead>
            <tr>
                <th></th>
                <th>VPCode</th>
                <th>Name</th>
                <th>Active</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Province</th>
                <th>P.Code</th>
                <th>Ref. by</th>
                <th></th>
                <th style="width:20px;">File</th>
            </tr>
        </thead>
        <tbody>
        <?php
    while ($rec = mysql_fetch_array($query)) {
            if($rec['active']){$ac='Active';}else{$ac='Désactivé';}
            if($rec['referredby']){$rb=$rec['referredby'];}else{$rb='-';}
            if($rec['type']==1){$dis=' disabled="disabled" ';$ty='Admin';}else{$dis='';if($rec['type']==3){$ty='V.P';}if($rec['type']==2){$ty='Investisseur';}if($rec['type']==4){$ty='Membre';}}
            if($rec['image']){$image=$rec['image'];}else{$image='pub.jpg';}
            if(isset($_GET['page'])){$pg=$_GET['page'];}else{$pg=1;}
                echo '
                    <tr>
                    <td><a href="'.$_SERVER['PHP_SELF'].'?vp='.$rec['vpcode'].'&page='.$pg.'"'.$dis.' class="btn btn-info btn-sm"><i class="fa fa-folder-open-o" aria-hidden="true"></i></a></td>
                    <td data-label="vpcode">'.$rec['vpcode'].'</td>
                    <td data-label="Name">'.$rec['name'].' '.$rec['famil'].'</td>
                    <td data-label="active">'.$ac.'</td>
                    <td data-label="email">'.$rec['email'].'</td>
                    <td data-label="phone1">'.$rec['phone1'].'</td>
                    <td data-label="adress">'.$rec['adress'].', '.$rec['city'].'</td>
                    <td data-label="province">'.$rec['province'].'</td>
                    <td data-label="postal">'.$rec['postal'].'</td>
                    <td data-label="referredby">'.$rb.'</td>
                    <td data-label="memberdate" class="user_image_table" style="background-image: url(image/'.$image.');"></td>
                    <td data-label="infoFile" style="width:20px;"><a target="_blank" href="image/'.$rec['infopdf'].'">'.$rec['infopdf'].'</a></td>
                    </tr>';
                } 
            ?>
        </tbody>
    </table>
    <div class="paginate">
    <?php
    echo displayPaginationBelow($setLimit,$page);
    ?>
    </div>
</div>


<div id="hammenu">
    <i class="fa fa-expand" aria-hidden="true"></i>
</div>


<div id="tabs-wrapper">
    <div id="tabs">
        <ul>
            <li><a href="admin_welcome.html" class="btn" disabled="disabled"></a></li>
        <!--    <?php if($_SESSION['a']==1){echo '<li><a class="btn btn-info" href="messages.php">Messages</a></li>';} ?> -->
            <li><a class="btn btn-info" href="<?php echo 'transaction.php'; ?>">Transaction d'interet</a></li>
            <?php if($_SESSION['a']==1){echo '<li><a class="btn btn-info" href="capital.php">Transaction de capital</a></li>';} ?>
            <li><a class="btn btn-info" href="<?php echo 'member_adm.php'; ?>">nouveau client</a></li>
            <li><a class="btn btn-info" href="<?php echo 'refer_adm.php'; ?>">nouveau Investissement</a></li>
            <li><a class="btn btn-info" href="<?php echo 'dossier_monte.php'; ?>">Dossier client/monté</a></li>
        </ul>
        <div id="tabs-1">
            <p></p>
        </div>
    </div>
</div>






        <?php if(isset($_GET['vp'])){ 
            $vp=$_GET['vp'];
            $_SESSION['vp'] = $vp;
            $sql1 = "SELECT * FROM users JOIN member ON users.vpcode=member.vpcode WHERE users.vpcode='$vp'";
            $result1 = mysql_query($sql1, $user_con) or die(mysql_error());
            $row1 = mysql_fetch_assoc($result1);
        ?>
        <div class="form-container">
        <form id="edit_users" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <?php if($row1['image']){$image1=$row1['image'];}else{$image1="pub.jpg";} ?>
        <div class="user_image_edit" style="background-image: url(image/<?php echo $image1; ?>);"></div>
        <h3><?php echo $row1['vpcode']; ?></h3>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Pr&eacute;nom</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $row1['name']; ?>"/>
                </div>          
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label">Nom famille</label>
                    <input type="text" class="form-control" name="famil" required="required" value="<?php echo $row1['famil']; ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label">Adresse</label>
                    <input type="text" class="form-control" name="adress" value="<?php echo $row1['adress']; ?>"/>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <label class="control-label">Ville</label>
                    <input type="text" class="form-control" name="city" value="<?php echo $row1['city']; ?>"/>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 selectContainer">
                    <label class="control-label">Province</label>
                    <select class="form-control" name="province">
                        <option value="Quebec" <?php if($row1['province']=="Quebec"){echo 'selected="selected"';} ?> >Qu&eacute;bec</option>
                        <option value="Ontario" <?php if($row1['province']=="Ontario"){echo 'selected="selected"';} ?> >Ontario</option>
                        <option value="Nova Scotia" <?php if($row1['province']=="Nova Scotia"){echo 'selected="selected"';} ?> >Nova Scotia</option>
                        <option value="New Brunswick" <?php if($row1['province']=="New Brunswick"){echo 'selected="selected"';} ?> >New Brunswick</option>
                        <option value="Manitoba" <?php if($row1['province']=="Manitoba"){echo 'selected="selected"';} ?> >Manitoba</option>
                        <option value="British Columbia" <?php if($row1['province']=="British Columbia"){echo 'selected="selected"';} ?> >British Columbia</option>
                        <option value="Prince Edward Island" <?php if($row1['province']=="Prince Edward Island"){echo 'selected="selected"';} ?> >Prince Edward Island</option>
                        <option value="Saskatchewan" <?php if($row1['province']=="Saskatchewan"){echo 'selected="selected"';} ?> >Saskatchewan</option>
                        <option value="Alberta" <?php if($row1['province']=="Alberta"){echo 'selected="selected"';} ?> >Alberta</option>
                        <option value="Newfoundland and Labrador" <?php if($row1['province']=="Newfoundland and Labrador"){echo 'selected="selected"';} ?> >Newfoundland and Labrador</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Code postale</label>
                    <input type="text" class="form-control" name="postal" maxlength="7" value="<?php echo $row1['postal']; ?>"/>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">T&eacute;l&eacute;phone</label>
                    <input type="text" class="form-control" name="phone1" value="<?php echo $row1['phone1']; ?>"/>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $row1['email']; ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Ref#</label>
                    <input type="text" class="form-control" name="refno" <?php if($_SESSION['a']!=1){echo ' readonly="readonly "';} ?> value="<?php echo $row1['refno']; ?>"/>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 selectContainer">
                    <label class="control-label">Active</label>
                    <select class="form-control" name="active">
                        <option value="1" <?php if($row1['active']==1){echo 'selected="selected"';} ?> >Oui</option>
                        <option value="0" <?php if($row1['active']==0){echo 'selected="selected"';} ?> >No</option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Date de naissance</label>
                    <input type="date" class="form-control" name="birthdate" value="<?php echo date("Y-m-d",strtotime($row1['birthdate'])); ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="control-label">Télécharer fichier</label>
                        <input type="file" name="pdf_file"><?php echo $err; ?>
                </div>
            </div>
            <?php
            $_SESSION['pr1']=date("d/m/Y",strtotime($row1['memberdate'])).'|'.$row1['vpcode'].'|'.$row1['famil'].'|'.$row1['name'].'|'.$row1['adress'].'|'.$row1['city'].'|'.$row1['postal'].'|'.$row1['email'].'|'.''.'|'.'26062,00 $'.'|'.'500,00 $'.'|'.'X'.'|'.''.'|'.'Capitol One'.'|'.'1 104,00 $'.'|'.''.'|'.''.'|'.''.'|'.''.'|'.''.'|'.''.'|'.'X'.'|'.''.'|'.''.'|'.'X';

            $stdate = date("Y-m-d",strtotime($row1['stdate']));
            $enddate = date("Y-m-d",strtotime($row1['enddate']));
            $_SESSION['pr2']=$row1['vpcode'].'|'.$row1['famil'].'|'.$row1['name'].'|'.$row1['score'].'|'.$row1['montantalloe'].'|'.$row1['dettereal'].'|'.$row1['paypermonthreal'].'|'.$row1['dayforpay'].'|'.$row1['bank1'].'|'.$row1['accountno'].'|'.$stdate.'|'.$enddate.'|'.$row1['totalmonth'];
            ?>
            <div class="row">
                <span style="color:#ff3333;font-size:1.1em;"><?php echo $errMsg; ?></span>
                <button type="submit" name="saveAdminInfo" class="btn btn-info" style="margin-left:20px;margin-right: 10px;display: inline;">Save</button>     
                <a style="display: inline;" href="<?php if(isset($_SESSION["vpcode"]) && $_SESSION["vpcode"]=='vp001'){echo 'vp.php';}else{echo htmlspecialchars($_SERVER["PHP_SELF"]);}?>" class="btn btn-default" id="cancel">Cancel</a>
                <a style="display: inline; float: right;margin-right: 15px;" target="_blank" href="<?php echo 'rep_dossier_client.php'; ?>" class="btn btn-default" id="print">Dossier Client</a>
                <a style="display: inline; float: right;margin-right: 5px;" target="_blank" href="<?php echo 'rep_dossier_monte.php'; ?>" class="btn btn-default" id="print">Dossier Monté</a>
            </div>
        </form>

        </div>
                    <div class="disabler">&nbsp;</div>

    <?php } ?>

<?php } else {header('location:../../index.php');} ?>

<script>
$(function() {

    $("#tabs").tabs({
      beforeLoad: function( event, ui ) {
        ui.jqXHR.fail(function() {
          ui.panel.html("");
        });
      }
    });

    $("#hammenu").click(function () {
        if ($('#tabs-wrapper').is(':visible')) {
            $('#hammenu').html('<i class="fa fa-expand" aria-hidden="true"></i>');           
            $('#tabs-wrapper').css("visibility:hidden");
            $('#tabs-wrapper').hide("slide", { direction: "right" }, 500);
            $('#tabs-wrapper').css("display:none");
        }
        else {
            $('#hammenu').html('<i class="fa fa-compress" aria-hidden="true"></i>');           
            $('#tabs-wrapper').css("display:block");
            $('#tabs-wrapper').css("visibility:visible");
            $('#tabs-wrapper').show("slide", { direction: "right" }, 500);
        }
    });
 });

</script>

</body>