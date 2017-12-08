<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Cinema - Ticket Purchase History</title>
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
$conn = mysql_connect("mysql.comp.polyu.edu.hk", "14108085d", "ldticogp");
mysql_select_db("14108085d", $conn);

if(isset($_SESSION['username']) && isset($_SESSION['password'])){
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
					<li class="active">Ticket Purchase History</li>
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
					<ul class="cat">
						<li><i class="fa fa-angle-right"></i><a href="user_profile.php" style="font-weight: bold;">User Profile</a></li>
						<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i><a href="ticket_cart.php" style="font-weight: bold;">Ticket Cart</a></li>			            
			            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i><a href="ticket_purchase.php" style="font-weight: bold;">Ticket Purchase</a></li>
					</ul>					
				</div>
				</aside>
			</div> 

			<div style="background-color: #CCC">
			    <div class="col-lg-9">
					<form role="form" name="form" id="form" class="register-form" action="#" method='post'>
						<h3>Ticket Purchase History</h3>
						<hr class="colorgraph">
							<!--if is post submit and successfully insert to db, print...-->
			            
						<?php
						$query_up = "SELECT mo.name, m.quantity, m.seat_num, m.date, m.time, m.id, m.order_date  FROM movie_buy m, movie mo
									where m.movie_id = mo.movie_id AND CAST(m.date AS DateTime) > curdate() AND m.username = '".$_SESSION['username']."' order by m.date;";
						$result_up = mysql_query($query_up, $conn);						
						?>			            
			            <table class="table table-hover">
			            	<caption style="padding: 15px 15px 15px 15px"><font size="4"><b>Upcoming</b></font></caption>
			                <thead>
			                    <tr class="bg-info">

			                    	<th style="width: 100px"  class="text-center">Puchase ID</th>
			                        <th class="text-center"><font size=3>Movie</font></th>
			                        <th class="text-center"><font size=3>Quantity</font></th>
			                        <th class="text-center"><font size=3>Seat</font></th>
			                        <th class="text-center"><font size=3>Movie Date</font></th>
			                        <th class="text-center"><font size=3>Time</font></th>
			                        <th class="text-center"><font size=3>Ordered Date</font></th>
			                    </tr>
			                </thead>
			                <tbody>	
			                	<?php
			                	$i = 1;
			                	$count = mysql_num_rows($result_up);
			                	if($count != 0){
				                	while($rowV = mysql_fetch_row($result_up)){
				                	?>				                
				                    <tr>
				                    	<td class="text-center"><b><?php echo $rowV[5]?></b></td>
				                        <td class="text-center"><b><?php echo $rowV[0]?></b></td>
				                        <td class="text-center"><b><?php echo $rowV[1]?></b></td>
				                        <td class="text-center"><b><?php echo $rowV[2]?></b></td>
				                        <td class="text-center"><b><?php echo $rowV[3]?></b></td>
				                        <td class="text-center"><b><?php echo $rowV[4]?></b></td>	
				                        <td class="text-center"><b><?php echo $rowV[6]?></b></td>				
									</tr> 
									<?php
										$i++;
				                	}
			                	}
			                	else{
			                		?>
				                    <tr>
				                    	<td colspan="6"><font size=4><b>No record<b></b></td>					
									</tr> 
			                		<?php
			                	}
								?>				 	 
			                </tbody>  
			            </table>	
			            <br><hr>
						<?php  
						$query_in = "SELECT mo.name, m.quantity, m.seat_num, m.date, m.time, m.id, m.order_date 
									FROM movie_buy m, movie mo
									where m.movie_id = mo.movie_id AND 
									m.date >= now()-interval 3 month AND CAST(m.date AS DateTime) <= curdate()
									AND m.username = '".$_SESSION['username']."'
									order by m.date;";	
						$result_in = mysql_query($query_in, $conn);
						?>			            
			            <table class="table table-hover">	
			            <caption style="padding: 15px 15px 15px 15px">
			            	<font size="4"><b>Viewed (Only the order records within 3 months are displayed)</b></font>
			            </caption>
			                <thead >
			                    <tr class="bg-info">
			                    	<th style="width: 100px"  class="text-center">Puchase ID</th>
			                        <th class="text-center"><font size=3>Movie</font></th>
			                        <th class="text-center"><font size=3>Quantity</font></th>
			                        <th class="text-center"><font size=3>Seat</font></th>
			                        <th class="text-center"><font size=3>Movie Date</font></th>
			                        <th class="text-center"><font size=3>Time</font></th>
			                        <th class="text-center"><font size=3>Ordered Date</font></th>
			                    </tr>
			                </thead>
			                <tbody>					                
			                	<?php
			                	$i = 1;
			                	$count = mysql_num_rows($result_in);
			                	if($count != 0){ 
				                	while($rowV = mysql_fetch_row($result_in)){
				                	?>				                
				                    <tr>
				                    	<td class="text-center"><b><?php echo $rowV[5]?></b></td>
				                        <td class="text-center"><b><?php echo $rowV[0]?></b></td>
				                        <td class="text-center"><b><?php echo $rowV[1]?></b></td>
				                        <td class="text-center"><b><?php echo $rowV[2]?></b></td>
				                        <td class="text-center"><b><?php echo $rowV[3]?></b></td>
				                        <td class="text-center"><b><?php echo $rowV[4]?></b></td>	
				                        <td class="text-center"><b><?php echo $rowV[6]?></b></td>						
									</tr> 
									<?php
										$i++;
				                	}
			                	}
			                	else{
			                		?>
				                    <tr>
				                    	<td colspan="6"><font size=4><b>No record<b></b></td>					
									</tr> 
			                		<?php
			                	}
								?>			 	 
			                </tbody>  
			            </table>	
			            <br><br><br>	            			            
					</form>
					<hr class="colorgraph">	
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
<?php
}
else{
	header("location: login.php");
}
?>
	
</body>
</html>