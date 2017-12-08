<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Cinema - Edit Profile</title>
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
<script type="text/javascript" src="edit_error.js"></script>
</head>
<body>
<?php
session_start()
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
					<li class="active">Edit Profile</li>
				</ul>
			</div>
		</div>
	</div>
	</section>
	
	<section id="content">
	<div class="container">
		<div class="row">
		
			<div class="col-lg-3">
				<aside class="left-sidebar">
				<br>
				<div class="widget">
					<h5 class="widgetheading">Categories</h5>
					<ul class="cat"><b>
						<li><i class="fa fa-angle-right"></i><a href="user_profile.php">User Profile</a></li>
						<li><i class="fa fa-angle-down"></i>Ticket Order</li>
			            <li>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<i class="fa fa-angle-right"></i><a href="ticket_cart.php">Ticket Cart</a></li>
			            <li>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<i class="fa fa-angle-right"></i><a href="ticket_purchase.php">Ticket Purchase History</a></li></b>
					</ul>
				</div>
				</aside>
			</div> 

			<div style="background-color: #CCC">
			    <div class="col-lg-6 col-md-offset-1">
					<form role="form" name="form" id="form" class="register-form" action="edit_profile.php" method='post'>
						<h3>Member: <?php echo $_SESSION['username']?></h3>
						<hr class="colorgraph">
						<h4>Personal Information</h4>
						<?php
						$username = $_SESSION['username'];
						$password = $_SESSION['password'];
						
						$conn = mysql_connect("mysql.comp.polyu.edu.hk", "14108085d", "ldticogp");
				        mysql_select_db("14108085d", $conn);
				        $query = "select * from member where username='$username'";
				        $result = mysql_query($query, $conn);
				        $row = mysql_fetch_row($result);		

				        if(isset($_SESSION['edit_error']) ){
							$edit_error = $_SESSION['edit_error'];
				    		echo $edit_error;
				    		unset($_SESSION['edit_error']);
						}
						?>
						<div class="form-group">
						    <div class="input-group">
							    <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
							    <input type="text" class="form-control input-lg" name="firstname" id="firstname" value="<?php echo $row[3]?>">
							    <div class="input-group-addon"><b>First Name</b></div>
						    </div>
						</div>
						<br>
						<div class="form-group">
						    <div class="input-group">
							    <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
							    <input type="text" class="form-control input-lg" name="lastname" id="lastname" value="<?php echo $row[4]?>">
							    <div class="input-group-addon"><b>Last Name</b></div>
						    </div>
						</div>						
						<br>
						<div class="form-group">
						    <div class="input-group">
							    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
							    <input type="date" class="form-control input-lg" name="bday" id="bday" value="<?php echo $row[5]?>">
							    <div class="input-group-addon"><b>Birthday</b></div>
						    </div>
						</div>						
						<br>											
						<div class="form-group">
						    <div class="input-group">
							    <div class="input-group-addon"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></div>
							    <input type="text" class="form-control input-lg" name="email" id="email" value="<?php echo $row[6]?>">
							    <div class="input-group-addon"><b>Email</b></div>
						    </div>
						</div>						
						<br>		
						<div class="form-group">
						    <div class="input-group">
							    <div class="input-group-addon"><span class="glyphicon glyphicon-phone" aria-hidden="true"></span></div>
							    <input type="text" class="form-control input-lg" name="phone" id="phone" value="<?php echo $row[7]?>">
							    <div class="input-group-addon"><b>Phone</b></div>
						    </div>
						</div>						
						<br>
						<hr class="colorgraph">
						<div class="row">
							<div class="col-xs-12 col-md-3"><input type="submit" name="edit" id="edit" value="Edit" class="btn btn-theme btn-block btn-lg" tabindex="7" onclick="return validate_input();"></div>
						</div>
					</form>
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