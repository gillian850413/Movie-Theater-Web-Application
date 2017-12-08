<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Cinema - Login</title>
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
</head>
<body>
<?php
session_start();
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
                        		$user = $_SESSION['username'];
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
					<li class="active">Login</li>
				</ul>
			</div>
		</div>
	</div>
	</section>
	
	<section id="content">
	<div class="container">
	<!--login start-->
	<div class="row">
	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form name="form" id="form "role="form" class="register-form" method='post'>
				<h2>Sign in</h2>
				<hr class="colorgraph">
				<?php

				//captcha 
				function changeCode(){
					$ans_char=0; $ans_str='';

					$_SESSION['capt_word'] = '';
					mt_srand((double)microtime()*1000000);
					for($i=0; $i<6; $i++){
						$ans_char = mt_rand(97, 122);
						$ans_str = $ans_str.chr($ans_char); //append them to a string
					}
					$_SESSION['capt_word'] = $ans_str;
				} 

				function securityCheck(){
					//the input is not empty and input is same as pic -> success

					if(empty($_POST['secure_code'])){ //input is empty
						changeCode();
						?>
						<div>
						    <div class="alert alert-danger fade in">
						        <a href="#" class="close" data-dismiss="alert">&times;</a>
						        <strong>Please input security code.</strong>
						    </div>
						</div>    
						<?php	
						
						return false;
					}

					else if(!empty($_SESSION['capt_word'])){
						//success
						if($_SESSION['capt_word'] == $_POST['secure_code']){
							$_SESSION['capt_word'] = ''; //success, clean the value
							header('content-Type: text/html; charset=utf-8');
							return true;
							exit();
						}
						//not success, random the pic
						else{
						    ?>
						    <div>
						        <div class="alert alert-danger fade in">
						            <a href="#" class="close" data-dismiss="alert">&times;</a>
							            <strong>Please input invaild security code</strong>
							    </div>
							</div>    
							<?php					
							changeCode();
							return false;
						} 
					}
				}
				//login 

				if(isset($_POST['submit'])){
					if(empty($_POST['username']) || empty($_POST['password'])){
					    ?>
					    <div>
					        <div class="alert alert-danger fade in">
					            <a href="#" class="close" data-dismiss="alert">&times;</a>
						            <strong>Please input username and password.</strong>
						    </div>
						</div>    
						<?php		
						changeCode();
					}
					else{
						//define $username and $password
						$username = $_POST['username'];
						$password = $_POST['password'];
								
						//connect to server
						$conn = mysql_connect("mysql.comp.polyu.edu.hk", "14108085d", "ldticogp");

						if(!$conn){
							die('Could not connect: ' . mysql_error());
						}

						//protect MySQL injection for security prupose
						$username = stripslashes($username);
						$password = stripslashes($password);
						$username = mysql_real_escape_string($username);
						$password = mysql_real_escape_string($password);

						mysql_select_db('14108085d', $conn);
						$query = "select * from member where username='$username' and password = MD5('$password')";
						$result = mysql_query($query, $conn);
						$record = mysql_fetch_assoc($result);
						$count = mysql_num_rows($result);

						if($count == 1){
							if(securityCheck() == true){
								//login successfully
								$_SESSION['username'] = $username;
								$_SESSION['password'] = $password;

								if(isset($_SESSION['cart'])){
									header("location: ticket_cart.php");
								}							
								else{
									header('location: index.php');	
								}
							}
						}
						else{
							changeCode();
						    ?>
						    <div>
						        <div class="alert alert-danger fade in">
						            <a href="#" class="close" data-dismiss="alert">&times;</a>
							            <strong>Invalid username or password.</strong>
							    </div>
							</div>    
							<?php					
						}
					}
					changeCode();
				}
				changeCode();
				?>
				<div class="form-group">
					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="Username" tabindex="4">
				</div>
				<div class="form-group">
					<input type="password" class="form-control input-lg" name="password" id="password" placeholder="Password">
				</div>
				<div class="row">
					<div class="col-xs-3 col-md-3">
	                    <img src=./captcha.php>
					</div>											
					<div class="form-group">
	                    <input type="text" name="secure_code" id="secure_code" placeholder="Security Code">
					</div>				
				</div>					
				<hr class="colorgraph">
				<div class="row">
					<div class="col-xs-12 col-md-6"><input type="submit" name='submit' id='submit' value="Sign in" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
					<div class="col-xs-12 col-md-6">Don't have an account? <a href="registration_form.php">Register</a><br><a href="forget_pw.php">Forget Password?</a></div>
				</div>
			</form>
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