<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Cinema - Ticket Cart</title>
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

if(isset($_POST['add']) && isset($_GET['id'])){
	$query_in="select t.movie_id, m.name, t.date, t.time, m.price FROM timeslot t, movie m where t.movie_id = m.movie_id AND t.id=".$_GET['id'];
	$result_in = mysql_query($query_in, $conn);
	$row=mysql_fetch_row($result_in);
	
	//check this session has data or not
	if(isset($_SESSION['cart'])){
		$item_array_id = array_column($_SESSION['cart'], 'timeslot_id');
		//print_r($item_array_id);
		if(!in_array($_GET['id'], $item_array_id)){
			$count = count($_SESSION['cart']); // count the number of element
			$item_array = array(
				'timeslot_id' => $_GET['id'],
				'item_id' => $row[0],
				'item_name' => $row[1],
				'item_date' => $row[2],
				'item_time' => $row[3],
				'item_price' => $row[4],
				'item_quantity' => $_POST['quan'],
				'item_seat' => ''
			);
			$_SESSION['cart'][$count] = $item_array;

		}
		//add in array alr
		else{
			echo '<script>alert("Item already added")</script>';
		}
	}
	else{ // cart no data
		$item_array = array(
			'timeslot_id' => $_GET['id'],
			'item_id' => $row[0],
			'item_name' => $row[1],
			'item_date' => $row[2],
			'item_time' => $row[3],
			'item_price' => $row[4],
			'item_quantity' => $_POST['quan'],
			'item_seat' => ''
		);

		$_SESSION['cart'][0] = $item_array;
	}
	//print_r($_SESSION['cart']);
}

if(isset($_GET['action']) ){
	if($_GET['action'] == "delete"){
		foreach ($_SESSION['cart'] as $key => $value) {
			if($value['timeslot_id'] == $_GET['did']){
				array_splice($_SESSION['cart'], $key, 1);
				echo '<script>window.location="ticket_cart.php"</script>';
			}
		}
	}
	//print_r($_SESSION['cart']);
}

if(isset($_POST['quanU'])){
	$query_in="select t.movie_id, m.name, t.date, t.time, m.price FROM timeslot t, movie m where t.movie_id = m.movie_id AND t.id=".$_GET['upid'];
	$result_in = mysql_query($query_in, $conn);
	$row=mysql_fetch_row($result_in);	
	
	foreach ($_SESSION['cart'] as $key => $value) {
		if($value['timeslot_id'] == $_GET['upid']){;
			$_SESSION['cart'][$key]=array(
				'timeslot_id' => $_GET['upid'],
				'item_id' => $row[0],
				'item_name' => $row[1],
				'item_date' => $row[2],
				'item_time' => $row[3],
				'item_price' => $row[4],
				'item_quantity' => $_POST['quanU'],
				'item_seat' => $_GET['seat']		
			);
			//print_r($_SESSION['cart']);
		}
	}
}

if(isset($_POST['add_seat']) && isset($_GET['tmid'])){
	$query_in="select t.movie_id, m.name, t.date, t.time, m.price FROM timeslot t, movie m where t.movie_id = m.movie_id AND t.id=".$_GET['tmid'];
	$result_in = mysql_query($query_in, $conn);
	$row=mysql_fetch_row($result_in);		
	foreach ($_SESSION['cart'] as $key => $value) {
		if($value['timeslot_id'] == $_GET['tmid']){
			$_SESSION['cart'][$key]=array(
				'timeslot_id' => $_GET['tmid'],
				'item_id' => $row[0],
				'item_name' => $row[1],
				'item_date' => $row[2],
				'item_time' => $row[3],
				'item_price' => $row[4],
				'item_quantity' => $_GET['quan'],
				'item_seat' => $_POST['seatT']		
			);
		}
	}
}

?>
<?php
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
					<li class="active">Ticket Cart</li>
				</ul>
			</div>
		</div>
	</div>
	</section>
	<section id="content">	
	<div class="container">
		<div class="row">
		    <div class="col-lg-10 col-lg-offset-1">
				<h2>Ticket Cart</h2>
				<hr class="colorgraph">
				<?php
				    if(isset($_SESSION['seat_empty']) ){
						$seat_empty = $_SESSION['seat_empty'];
				    	echo $seat_empty;
				    	unset($_SESSION['seat_empty']);
					}
				?>
		            <table class="table table-hover" name="ticket_table" id="ticket_table">
		                <thead>
		                    <tr>
		                    	<th>#</th>
		                    	<th></th>
		                        <th>Movie</th>
		                        <th>Quantity</th>
		                        <th>&nbsp;&nbsp;&nbsp;&nbsp;Seat</th>
		                        <th>Date</th>
		                        <th>Time</th>
		                        <th>Price</th>
		                        <th> </th>
		                    </tr>
		                </thead>
		                <tbody>						                
		                    <tr>
								<?php
								$total = 0; 
								if(!empty($_SESSION['cart'])){ //check the session cart is not empty
								///$count = count($_SESSION['cart']);									
									$i = 1;
									foreach ($_SESSION['cart'] as $key => $value) {					
									?>
					                   	<th scope="row"><br><?php echo $i?></th>
					            	    <td style="width: 130px;">
											<a class="thumbnail pull-left" href="movie_detail.php?id=<?php echo $value['item_id'];?>"> <img src="asset/img/movie/m<?php echo$value['item_id']?>" style="width: 60px; height: 90px;"></a>
					                    </td>
					                    <td><br>
					                       	<h4><a href="movie_detail.php?id=<?php echo $value['item_id'];?>" style="color:#34495E"><?php echo  $value['item_name']?></a></h4>
					                    </td>
					                    <td class="col-lg-1"><br>
					                    <form method="post" action="ticket_cart.php?upid=<?php echo $value['timeslot_id']?>&seat=<?php echo $value['item_seat']?>">
					                       	<input id="quanU" name="quanU" class="form-control" type="number" min="1" max="100" onchange="this.form.submit();" value="<?php echo $value['item_quantity']?>" />
					                    </form>   	
					                    </td>
					                    <td class="col-lg-2" style="word-break:break-all"><br>
					                       	<div class="col-lg-9">
												<label><?php echo $value['item_seat']?></label>
												<input type="hidden" name="seat" id="seat" value="<?php echo $value['item_seat']?>">
					                       	</div>
						                    <div class="col-lg-3">
						                       	<?php $quan = $value['item_quantity'];?>
						                       	<?php $timeslot_id = $value['timeslot_id'];?>
						                       	<button type="button" class="btn btn-outline-danger pull-right" onclick="window.location.href='seat.php?action=add&quan=<?php echo $quan?>&tid=<?php echo $timeslot_id?>&sid=<?php echo $value['item_seat']?>'"> 	
						                        <span class="glyphicon glyphicon-plus" style="color:#26425A"></span></button>
						                    </div>						                        		
					                    </td>
					                    <td><br><strong><?php echo $value['item_date'];?></strong></td>
					                    <td><br><strong><?php echo $value['item_time']?></strong></td>
					                    <td><br><strong><?php echo $value['item_price']* $value['item_quantity'];?></strong></td>
					                    <td><br>
					                      	<button type="button" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')"><a href="ticket_cart.php?action=delete&did=<?php echo $value['timeslot_id'];?>"><span class="glyphicon glyphicon-trash" style="color:#A93226"></span></a></button>
					                    </td>				                        
					            </tr>	
								<?php
									$total += ($value['item_quantity'] * $value['item_price']);
										$i++;
									}
								}										
								?>	
								<tr>
									<th colspan="10" class="text-right"><font size="3">Total: <?php echo $total;?>&nbsp;&nbsp;</font></th>				
								</tr>     	                
								<tr>
									<th colspan="5"><button type="button" class="btn btn-outline-default"><a href="movie_inTh.php"><font color="#A93226"><span class="glyphicon glyphicon-chevron-left"></span><b> View More Movies</b></font></a></button></th>	

									<th colspan="5" class="text-right"><button type="button" name="checkout" id="checkout" class="btn btn-outline-default"><a href="checkout.php"><font color="#A93226"><b>Checkout </b><span class="glyphicon glyphicon-chevron-right"></span></font></a></button></th>							
								</tr>		 
		                </tbody>
		                
		            </table>
		        <hr class="colorgraph">	
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
<?php
}
else{
	header("location: login.php");	
}
?>
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