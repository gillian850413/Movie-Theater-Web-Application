<?php
session_start();

$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$bday = $_POST['bday'];
$email = $_POST['email'];
$phone = $_POST['phone'];


if(isset($_POST['edit'])){
	if(empty($fname) || empty($lname) || empty($bday) || empty($email) || empty($phone)){
		$_SESSION['edit_error'] = "<div>
	                                    <div class='alert alert-danger fade in'>
	                                        <a href='#' class='close' data-dismiss='alert'>&times;</a>
	                                        <strong>Each field must be filled in.</strong>
	                                    </div>
                                	</div>";
        header("location: edit_profile_form.php");              
	}
	else{
		$conn = mysql_connect("mysql.comp.polyu.edu.hk", "14108085d", "ldticogp");
		mysql_select_db("14108085d", $conn);

		//update their profile
		update_profile($fname, $lname, $bday, $email, $phone);
	}
}


function update_profile($fname, $lname, $bday, $email, $phone){
	
	$conn = mysql_connect("mysql.comp.polyu.edu.hk", "14108085d", "ldticogp");
	mysql_select_db("14108085d", $conn);	

	$update_query = 'UPDATE member SET first_name = "' . $fname . '" WHERE username = "' . $_SESSION['username'] . '"';
    $update_result = mysql_query($update_query) or die('error:' . mysql_error());

	$update_query = 'UPDATE member SET last_name = "' . $lname . '" WHERE username = "' . $_SESSION['username'] . '"';
    $update_result = mysql_query($update_query) or die('error:' . mysql_error());

    $update_query = 'UPDATE member SET bday = "' . $bday . '" WHERE username = "' . $_SESSION['username'] . '"';
    $update_result = mysql_query($update_query) or die('error:' . mysql_error());

    $update_query = 'UPDATE member SET email = "' . $email . '" WHERE username = "' . $_SESSION['username'] . '"';
    $update_result = mysql_query($update_query) or die('error:' . mysql_error());

    $update_query = 'UPDATE member SET phone = "' . $phone . '" WHERE username = "' . $_SESSION['username'] . '"';
    $update_result = mysql_query($update_query) or die('error:' . mysql_error());

    if(mysql_error() != ""){
		$_SESSION['edit_error'] = "<div>
	                                    <div class='alert alert-danger fade in'>
	                                        <a href='#' class='close' data-dismiss='alert'>&times;</a>
	                                        <strong>Invaild Update</strong>
	                                    </div>
                                	</div>";
        header("location: edit_profile_form.php");       	
    }
    else{
		$_SESSION['edit_success'] = "<div>
	                                    <div class='alert alert-success fade in'>
	                                        <a href='#' class='close' data-dismiss='alert'>&times;</a>
	                                        <strong>Update Successfully</strong>
	                                    </div>
                                	</div>";    	
    	header("location: user_profile.php"); 
    }


}
?>