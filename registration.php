<?php
session_start();
$username = $_POST['username'];
$pw = $_POST['password'];
$cpw = $_POST['confirm_password'];
$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$bday = $_POST['bday'];
$email = $_POST['email'];
$phone = $_POST['phone'];

function insertRecord($username, $pw, $cpw, $fname, $lname, $bday, $email, $phone){
    $conn = mysql_connect("mysql.comp.polyu.edu.hk", "14108085d", "ldticogp");
    mysql_select_db("14108085d", $conn);
    $query = "insert into member values('". $username. "', MD5('". $pw. "'),MD5('". $cpw. "'), 
    '" . $fname . "', '" . $lname . "', '" . $bday . "', '" . $email . "', '" . $phone . "')";
    mysql_query($query, $conn);
    
    echo $query;
    if(mysql_error() != ""){ 
        $_SESSION['reg_error']= "<div>
                                    <div class='alert alert-danger fade in'>
                                        <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                        <strong>Username has been used already.</strong>
                                    </div>
                                </div>";
        header("location: registration_form.php");
    }
    else{
        $_SESSION['conn'] = $conn;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $pw;
        //echo "Registration is completed successfully";
        header("location: login.php");
    }
    mysql_close($conn);
}
if(isset($_REQUEST['submit']) != ""){
    if(trim($username)!='' && trim($pw)!='' && trim($cpw)!='' && trim($fname)!=''   
    && trim($lname)!='' && trim($bday)!='' && trim($email)!='' && trim($phone)!=''){
	    insertRecord(trim($username), trim($pw), trim($cpw), trim($fname), 
	    trim($lname), trim($bday), trim($email), trim($phone));        
	}
	else{
        $_SESSION['reg_error']= "<div>
                                    <div class='alert alert-danger fade in'>
                                        <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                        <strong>Please input the empty textboxes.</strong>
                                    </div>
                                </div>";
        header("location: registration_form.php");
    }
}



?>



                                