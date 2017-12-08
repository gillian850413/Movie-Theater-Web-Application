<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Cinema - Seat Selection</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="Bootstrap 3 template for corporate business" />
<!-- css -->
<link href="asset/css/bootstrap.min.css" rel="stylesheet" />
<link href="asset/plugins/flexslider/flexslider.css" rel="stylesheet" media="screen" />	
<link href="asset/css/cubeportfolio.min.css" rel="stylesheet" />
<link href="asset/css/style.css" rel="stylesheet" />
<!-- Theme skin -->
<link id="t-colors" href="asset/skins/default.css" rel="stylesheet" />

<!-- boxed bg -->
<link id="bodybg" href="asset/bodybg/bg10.css" rel="stylesheet" type="text/css" />

<!-- =======================================================
    Theme Name: Sailor
    Theme URL: https://bootstrapmade.com/sailor-free-bootstrap-theme/
    Author: BootstrapMade
    Author URL: https://bootstrapmade.com
======================================================= -->
<script>
    var x = 0
    //var count = 1;
    var seats = [];

    function setColor(btn, color) {
    	var property = document.getElementById(btn);
    	var err_msg = '';
    	var quan = document.getElementById("quan").value;	

    	if(seats.length == 0){ // no seat selected
    		property.style.background = "#A9E2F3";
    		seats[x++] = property.value;
    	}
    	else{ //there are seats selected
			//if not found
			if(seats.indexOf(property.value) === -1){
				if(x >= quan){
			    	if(quan == 1){
				        err_msg += "You can only select "+quan+" seat.";
				        alert(err_msg);    		
			    	}
			    	else{
				        err_msg += "You can only select "+quan+" seats.";
				        alert(err_msg);	
			    	}
				}
				else{
			 		property.style.background = "#A9E2F3";
					seats[x++] = property.value;
			   	}		
			}
			else{ //found
				property.style.background = "#ddd";
			    var index = seats.indexOf(btn);
			    seats.splice(index, 1);	
			    x--;
			}	
    	}

    	var seatT = seats.join(',');
        document.getElementById("seat").innerHTML = seatT;
        document.getElementById("seatT").value = seatT;    	
    }

    function validate() {
    	var err_msg = '';
		var seatT = document.formT.seatT.value;
		var quan = document.getElementById("quan").value;	
    	//var seatT = document.getElementById("seatT");
    	if (seatT == ''){
    		err_msg = "Please select the seat";
    	}
    	if (seatT.split(",").length < quan){
    		err_msg = "Please select "+quan+" seats.";
    	}

	    if(err_msg != '') {
	        alert(err_msg);
	        return false;
	    }
	    return true;    	
    }

</script>
</head>
<body>
<?php
session_start();
$conn = mysql_connect("mysql.comp.polyu.edu.hk", "14108085d", "ldticogp");
mysql_select_db("14108085d", $conn);

?>

<div id="wrapper">
	<!-- start header -->
	<header>
        <div class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><img src="asset/img/logo.png" alt="" width="199" height="52" /></a>
                </div>
                <div class="navbar-collapse collapse ">
                    <ul class="nav navbar-nav">
                        <li class="dropdown"><a href="#" class="dropdown-toggle " data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">Movie <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu">
                                <li><a href="movie_inTh.php">In Theater</a></li>
                                <li><a href="movie_coming.php">Upcoming</a></li>
                            </ul>
						</li>
                        <!-- if login, change to user name which can change personal profile-->
                        <?php
                        	if(isset($_SESSION['username']) && isset($_SESSION['password'])){
                        		$user = $_SESSION['username']
                        		?>
								<li class="dropdown"><a href="#" class="dropdown-toggle " data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false"><?php echo $user ?><i class="fa fa-angle-down"></i></a>
									<ul class="dropdown-menu">
			                                <li><a href="user_profile.php">Profile</a></li>
			                                <li><a href="ticket_purchase.php">Ticket Order</a></li>
			                                <li><a href="logout.php">Logout</a></li>
		                            </ul>
								</li>      		
                        		<?php
                        	}
                        	else{
                        		?>
                        		<li><a href="login.php">Login</a></li>
                        		<?php
                        	}
                        ?>  
                        
                        <li><a href="ticket_cart.php">Cart <span class="glyphicon glyphicon-shopping-cart"></span></a></li>
		    		</ul>                         
                </div>            
            </div>
        </div>
	</header>
	<!-- end header -->
	
	<section id="inner-headline">
	<div class="container">
		<div class="row">
	<div class="col-lg-12">
		<ul class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-home"></i></a><i class="icon-angle-right"></i></li>
			<li><a href="ticket_cart.php">Cart <i class="fa fa-shopping-cart"></i></a><i class="icon-angle-right"></i></li>
			<li class="active">Seat Selection</li>
		</ul>
	</div>
		</div>
	</div>
	</section>

	<section id="content">
	<div class="container">
		<div class="row">
	<div class="col-lg-8 col-md-offset-1">
		<h2 class="text-center">Seat</h2>
		<hr class="colorgraph">
		   		<div id="seat-map">
			<div class="front"><b>SCREEN</b></div>	
			<div class="col-lg-6 ">	
		<?php
		$alphas = range('A', 'Z');
		for($j=0; $j<7; $j++){
		?>
			<label class="col-lg-1">&nbsp;&nbsp;<?php echo $alphas[$j];?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php
			$queryS = "SELECT t.id, m.seat_num FROM movie_buy m, timeslot t where t.movie_id = m.movie_id AND t.date = m.date AND t.time = m.time AND  t.id=".$_GET['tid'];
			$resultS = mysql_query($queryS, $conn);
			$countS = mysql_num_rows($resultS);
			$occupied = [];
			for($i=0; $i<$countS; $i++){
				$rowS = mysql_fetch_row($resultS);
				$occupied[$i] = $rowS[1];
				//print_r($occupied);
			}

			for($i=1; $i<=6; $i++){   
				$seat_num = $alphas[$j]."$i";
					if(in_array($seat_num, $occupied)){
					?>
						<button class="btn btn-outline-secondary" name="<?php echo $alphas[$j]."$i";?>" id="<?php echo $alphas[$j]."$i";?>" value="<?php echo $alphas[$j]."$i";?>" style="background: #585858; width: 42px; height: 33px;" >
						<span class="glyphicon glyphicon-user" style="color:#D0D3D4"></span>
						</button>	
					<?php				
					}
					else{ 
					?>
						<button class="btn btn-outline-secondary" name="<?php echo $alphas[$j]."$i";?>" id="<?php echo $alphas[$j]."$i";?>" value="<?php echo $alphas[$j]."$i";?>" style="background: #ddd; width: 42px; height: 33px;" onclick="setColor('<?php echo $alphas[$j]."$i";?>', '#101010');">
							<b>0<?php echo $i?></b>
						</button>
					<?php
					}
						
			}
			?><br><br><?php
		}	
		?>				
			</div>	
			<div class="col-lg-6">	
		<?php
		for($j=0; $j<7; $j++){
		?>
			<?php
			for($i=7; $i<=12; $i++){
				$seat_num = $alphas[$j]."$i";
				if(in_array($seat_num, $occupied)){
				?>
					<button class="btn btn-outline-secondary" name="<?php echo $alphas[$j]."$i";?>" id="<?php echo $alphas[$j]."$i";?>" value="<?php echo $alphas[$j]."$i";?>" style="background: #585858; width: 42px; height: 33px;">	
					<span class="glyphicon glyphicon-user" style="color:#D0D3D4"></span>
					</button>	
				<?php
				}	
				else{
				?>
					<button class="btn btn-outline-secondary" name="<?php echo $alphas[$j]."$i";?>" id="<?php echo $alphas[$j]."$i";?>" value="<?php echo $alphas[$j]."$i";?>" style="background: #ddd; width: 42px; height: 33px;" onclick="setColor('<?php echo $alphas[$j]."$i";?>', '#101010')"><b><?php if($i < 10){echo "0".$i;}else{echo $i;}?></b>		
					</button>
				<?php					
				}							

			}
			?><br><br><?php
		}
		?>				
			</div>					
		</div>		
	</div>	
	<?php 
	$tid = $_GET['tid'];
	$query_in="select t.id, m.name, t.date, t.time FROM timeslot t, movie m where t.movie_id = m.movie_id AND t.id=".$_GET['tid'];
	$result_in = mysql_query($query_in, $conn);
	$row=mysql_fetch_row($result_in);
	?>
	<div class="col-lg-3">
		<aside class="right-sidebar">
			<div class="widget">
		<br>
		<h5 class="widgetheading"><?php echo $row[1];?></h5>
		<ul class="cat">
			<!--sort by name-->
			<li><i class="fa fa-calendar"></i><font size=3><b>Date: <?php echo $row[2];?></b></font></li>
			<li><i class="fa fa-clock-o"></i><font size=3><b>Time: <?php echo $row[3];?></b></font></li>
			<?php
			if(isset($_GET['sid']) && $_GET['sid']!=''){
			?>
				<li><i class="fa fa-check-circle"></i><font size=3><b>New Seat(s): <label id="seat"></label></b></font></li>
				<li><i class="fa fa-times-circle"></i><font size=3><b>Previous Seat(s): <?php echo $_GET['sid'];?></b></font></li>				
			<?php
			}
			else{
			?>
				<li><i class="fa fa-ticket"></i><font size=3><b>Seat: <label id="seat"></label></b></font></li>
			<?php
			}
			?>
			<hr class="colorgraph">
			<li>
				<label><button class="btn btn-outline-secondary" type="button" style="background: #ddd; width: 42px; height: 33px;"></button>&nbsp;&nbsp; Seat Available</label>
			</li>			
			<li >
				<label><button class="btn btn-outline-secondary" type="button" style="background: #A9E2F3; width: 42px; height: 33px;"></button>&nbsp;&nbsp; Seat Selected</label>
			</li>	
			<li >
				<label><button class="btn btn-outline-secondary" type="button" style="background: #585858; width: 42px; height: 33px;"><span class="glyphicon glyphicon-user" style="color:#D0D3D4"></span></button>&nbsp;&nbsp; Seat Occupied</label>
			</li>	
			<li><input type="hidden" name="quan" id="quan" value="<?php echo $_GET['quan'];?>"></li>
			<hr class="colorgraph">
			<form method="post" action="ticket_cart.php?tmid=<?php echo $row[0]?>&quan=<?php echo $_GET['quan'];?>" name="formT" id="formT">
				<button type="button" class="btn btn-outline-default">
					<font color="#A93226"><span class="glyphicon glyphicon-chevron-left"></span><a href="ticket_cart.php"><font color="#A93226"><b> Back</b>
				</button>
				<input type="hidden" name="seatT" id="seatT" value="">
				<li class="pull-right"><font color="#A93226"><input type="submit" class="btn btn-outline-danger" id="add_seat" name="add_seat" value="Submit" onclick="return validate();" style="font-weight:bold;"></font></li>
			</form>		
		</ul>				
			</div>
		</aside>
	</div>
		</div>
		

	
		</div>


	</div>
	</section>

	<footer>
	<div class="container">
		<div class="row">
			<div class="col-sm-3 col-lg-3">
				<div class="widget">
					<h4>Get in touch with us</h4>
					<address>
					<strong>Cinema</strong><br>
					 Sailor suite room V124, DB 91<br>
					 Someplace 71745 Earth </address>
					<p>
						<i class="icon-phone"></i> (123) 456-7890 <br>
						<i class="icon-envelope-alt"></i> email@cinema.com
					</p>
				</div>
			</div>
			<div class="col-sm-4 col-lg-4">
				<div class="widget">
					<h4>Information</h4>
					<ul class="link-list">
						<li><a href="#">Press release</a></li>
						<li><a href="#">Terms and conditions</a></li>
						<li><a href="#">Privacy policy</a></li>
						<li><a href="#">Career center</a></li>
						<li><a href="#">Contact us</a></li>
					</ul>
				</div>
			</div>
            <div class="col-sm-4 col-lg-4">
				<div class="widget">
					<h4>Newsletter</h4>
					<p>Fill your email and sign up for monthly newsletter to keep updated</p>
                    <div class="form-group multiple-form-group input-group">
                        <input type="email" name="email" class="form-control">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-theme btn-add">Subscribe</button>
                        </span>
                    </div>
				</div>
			</div>			
		</div>
	</div>
	<div id="sub-footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="copyright">
						<p>&copy; Sailor Theme - All Right Reserved</p>
                        <div class="credits">
                            <!-- 
                                All the links in the footer should remain intact. 
                                You can delete the links only if you purchased the pro version.
                                Licensing information: https://bootstrapmade.com/license/
                                Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Sailor
                            -->
                            <a href="https://bootstrapmade.com/free-business-bootstrap-themes-website-templates/">Business Bootstrap Themes</a> by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                        </div>
					</div>
				</div>
				<div class="col-lg-6">
					<ul class="social-network">
						<li><a href="#" data-placement="top" title="Facebook"><i class="fa fa-facebook"></i></a></li>
						<li><a href="#" data-placement="top" title="Twitter"><i class="fa fa-twitter"></i></a></li>
						<li><a href="#" data-placement="top" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
						<li><a href="#" data-placement="top" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
						<li><a href="#" data-placement="top" title="Google plus"><i class="fa fa-google-plus"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	</footer>
	
</div>
<a href="#" class="scrollup"><i class="fa fa-angle-up active"></i></a>
<!-- javascript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="asset/js/bootstrap-number-input.js"></script>
<script src="asset/js/jquery.min.js"></script>
<script src="asset/js/modernizr.custom.js"></script>
<script src="asset/js/jquery.easing.1.3.js"></script>
<script src="asset/js/bootstrap.min.js"></script>
<script src="asset/plugins/flexslider/jquery.flexslider-min.js"></script> 
<script src="asset/plugins/flexslider/flexslider.config.js"></script>
<script src="asset/js/jquery.appear.js"></script>
<script src="asset/js/stellar.js"></script>
<script src="asset/js/classie.js"></script>
<script src="asset/js/uisearch.js"></script>
<script src="asset/js/jquery.cubeportfolio.min.js"></script>
<script src="asset/js/google-code-prettify/prettify.js"></script>
<script src="asset/js/animate.js"></script>
<script src="asset/js/custom.js"></script>

	
</body>
</html>