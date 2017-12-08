<!--insert comment to mysql, comment table-->
<?php
session_start();
$movie_id = $_GET['mid'];
$username = $_SESSION['username'];
$date = $_POST['today'];
$comment = $_POST['comment'];
$rating = $_POST['rating'];



function insertRecord($movie_id, $username, $date, $comment, $rating){
    $conn = mysql_connect("mysql.comp.polyu.edu.hk", "14108085d", "ldticogp");
    mysql_select_db("14108085d", $conn);
    $query = "insert into comment (movie_id, username, date, comment, rating)
    values('". $movie_id. "', '" . $username . "','". $date. "', '" . $comment . "', '" . $rating . "')";
    mysql_query($query, $conn);
    
    
    if(mysql_error() != ""){ 
        $_SESSION['com_error']= "<div>
                                    <div class='alert alert-danger fade in'>
                                        <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                        <strong>Comment Failure.</strong>
                                    </div>
                                </div>";
        //echo mysql_error();
        header("location: movie_detail.php?id=$movie_id#comment_section");
    }
    else{
    	//insert successfully
    	//echo "successfully";
        header("location: movie_detail.php?id=$movie_id#comment_section");
    }
    mysql_close($conn);
}

if(isset($_POST['submit']) != ""){
    if($movie_id!='' && $username!='' && $date!='' && $comment!=''){
	    insertRecord($movie_id, $username, $date, $comment, $rating);    
	    //echo"insert";    
	}
	else{
        $_SESSION['com_error']= "<div>
                                    <div class='alert alert-danger fade in'>
                                        <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                        <strong>Please input the empty textboxes.</strong>
                                    </div>
                                </div>";

        //echo"empty";
        header("location: movie_detail.php?id=$movie_id#comment_section");
    }
}

?>
