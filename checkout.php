<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Cinema - Checkout</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="Bootstrap 3 template for corporate business" />
<!-- css -->
<link href="asset/css/bootstrap.min.css" rel="stylesheet" />
<link href="asset/plugins/flexslider/flexslider.css" rel="stylesheet" media="screen" />	
<link href="asset/css/cubeportfolio.min.css" rel="stylesheet" />
<link href="asset/css/style.css" rel="stylesheet" />
<link href="asset/css/build.css" rel="stylesheet" >

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
	  // Add smooth scrolling to all links
	  $("a").on('click', function(event) {

	    // Make sure this.hash has a value before overriding default behavior
	    if (this.hash !== "") {
	      // Prevent default anchor click behavior
	      event.preventDefault();

	      // Store hash
	      var hash = this.hash;

	      // Using jQuery's animate() method to add smooth page scroll
	      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
	      $('html, body').animate({
	        scrollTop: $(hash).offset().top
	      }, 800, function(){
	   
	        // Add hash (#) to URL when done scrolling (default click behavior)
	        window.location.hash = hash;
	      });
	    } // End if
	  });
	});	
</script>
<script type="text/javascript">
	function validate_input() {	
	    var err_msg = '';
	    var card_num = document.cform.card_num.value;
	    var card_name = document.cform.card_name.value;
	    var card_exdate = document.cform.card_exdate.value;
	    var card_code = document.cform.card_code.value;   
   		var re_card_num = /^[0-9\s\(\)\+\-]{16}$/;	  
   		var re_card_code = /^[0-9\s\(\)\+\-]{3}$/;	    

	    if(card_num =='') {
	    	err_msg += 'Please input your credit card number';
	    	err_msg += "\n";
	    } 
	    else if (!re_card_num.test(card_num)) {
	        err_msg += "Please input validate credit card number";
	        err_msg += "\n";
	    }	    
	    
	    if(card_name ==''){
	    	err_msg += 'Please input the name on card.'
	    	err_msg += "\n";
	    }

	    if(card_exdate ==''){
	    	err_msg += 'Please input the expiration dare.'
	    	err_msg += "\n";
	    }

	    if(card_code ==''){
	    	err_msg += 'Please input the security code.'
	    	err_msg += "\n";
	    }
	    else if (!re_card_code.test(card_code)) {
	        err_msg += "Please input validate security code";
	        err_msg += "\n";
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
					<li class="active">Checkout</li>
				</ul>
			</div>
		</div>
	</div>
	</section>
	<section id="content">	
	<div class="container">
		<div class="row">
		    <div class="col-lg-10 col-lg-offset-1">
				<h2>Checkout</h2>
				<hr class="colorgraph">
		            <table class="table table-hover" name="ticket_table" id="ticket_table">
		                <thead>
		                    <tr>
		                    	<th>#</th>
		                    	<th></th>
		                        <th>Movie</th>
		                        <th>Quantity</th>
		                        <th>Seat</th>
		                        <th>Date</th>
		                        <th>Time</th>
		                        <th>Price</th>
		                        <th> </th>
		                    </tr>
		                </thead>
		                <tbody>					                
		                    
								<?php
								$total = 0; 
								if(!empty($_SESSION['cart'])){ //check the session cart is not empty
								///$count = count($_SESSION['cart']);									
									$i = 1;
									foreach ($_SESSION['cart'] as $key => $value) {			
										if($value['item_seat'] == '' || $value['item_quantity'] == ''){
											?>
											<script type="text/javascript">
											alert("Please select the quantity or seat(s) before checkout.");
											window.location.href = "ticket_cart.php";
											</script>
											<?php   											
										}
										else{
										?>
											<tr>
							                   	<th scope="row"><br><?php echo $i?></th>
							            	    <td style="width: 130px;">
													<a class="thumbnail pull-left" href="movie_detail.php?id=<?php echo $value['item_id'];?>"> <img src="asset/img/movie/m<?php echo$value['item_id']?>" style="width: 60px; height: 90px;"></a>
							                    </td>
							                    <td><br>
							                       	<h4><a href="movie_detail.php?id=<?php echo $value['item_id'];?>" style="color:#34495E"><?php echo  $value['item_name']?></a></h4>
							                    </td>
							                    <td><br><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value['item_quantity'];?></strong></td>
							                    <td><br><strong>&nbsp;&nbsp;<?php echo $value['item_seat'];?></strong></td>
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
									<th colspan="5">
										<button type="button" class="btn btn-outline-default">
											<font color="#A93226"><span class="glyphicon glyphicon-chevron-left"></span><a href="ticket_cart.php"><font color="#A93226"><b> Back</b>
										</button>
									</th>
									<th colspan="5" class="text-right">
										<button type="button" name="checkout" id="checkout" class="btn btn-outline-default"><a href="#payment"><font color="#A93226"><b>Place Order </b><span class="glyphicon glyphicon-chevron-down"></span></font></a></button>
									</th>										
									
									<?php	
									}	
									else{		
									?>
										<div>
									        <div class='alert alert-danger fade in'>
									            <a href='#' class='close' data-dismiss='alert'>&times;</a>
									            <strong>There is no ticket in your cart.&nbsp;&nbsp;&nbsp;&nbsp;<a href="movie_inTh.php" style="color: #0F356C;">View Movies</a></strong>
									        </div>
									    </div>    
									<?php															
									}									
									?>							
								</tr> 		 	 
		                </tbody>
		                
		            </table>
		        <hr class="colorgraph">	
			</div>
		</div>
		<hr>
	</div>
	</section>	
	<?php
	if(!empty($_SESSION['cart'])){	
	?>
	<form method="post" name="cform" id="cform" action="ticket_order.php">
	<section style="background-color:#FFFFFF"  id="payment">
	<div class="container">
		<div class="row">	
		    <div class="col-lg-10 col-lg-offset-1">
				<h2>Payment Information</h2>
				<hr class="colorgraph "><br>				
				<div class="form-group col-lg-offset-1">
				    <h3>&nbsp;&nbsp;&nbsp;Member: <?php echo $user;?>
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total: <?php echo $total;?></h3>
				</div>		
				<hr> 
				<div class="form-group col-lg-10 col-lg-offset-1">
					<font size="3">		
	                    <label>&nbsp;Credit Card: </label>&nbsp;&nbsp;
	                    <div class="radio radio-danger radio-inline">
	                        <input type="radio" id="inlineRadio1" name="card_type" id="card_type" value="visa" checked>
	                        <label for="inlineRadio1"> Visa </label>
	                    </div>
	                    <div class="radio radio-danger radio-inline">
	                        <input type="radio" id="inlineRadio1" value="master" name="card_type" id="card_type">
	                        <label for="inlineRadio1"> Master Card </label>
	                    </div>
	                    <div class="radio radio-danger radio-inline">
	                        <input type="radio" id="inlineRadio1" value="cpu" name="card_type" id="card_type">
	                        <label for="inlineRadio1"> CPU </label>
	                    </div>
	                    <div class="radio radio-danger radio-inline">
	                        <input type="radio" id="inlineRadio1" value="ae" name="card_type" id="card_type">
	                        <label for="inlineRadio1"> American Express </label>
	                    </div>	                    	                    
	                </font> 
				</div>										
				<div class="form-group col-lg-10 col-lg-offset-1">
				    <div class="input-group">
					    <div class="input-group-addon"><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span></div>
					    <input type="text" class="form-control input-lg" name="card_num" id="card_num" placeholder="Credit Card">
				    </div>
				</div>	
				<div class="form-group col-lg-10 col-lg-offset-1">
				    <div class="input-group">
					    <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
					    <input type="text" class="form-control input-lg" name="card_name" id="card_name" placeholder="Name on card">
				    </div>
				</div>	
				<div class="form-group col-md-5 col-lg-offset-1">
					<div class="input-group">
				    	<div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                    	<input type="date" name="card_exdate" id="card_exdate" class="form-control input-lg" placeholder="Expiration Date" tabindex="1" min="">
                    	<div class="input-group-addon"><b>Expiration Date</b></div>
                    </div>
					<script type="text/javascript">
						var today = new Date();
						var dd = today.getDate();
						var mm = today.getMonth()+1; //January is 0!
						var yyyy = today.getFullYear();
						if(dd<10){
						    dd='0'+dd
						} 
						if(mm<10){
						    mm='0'+mm
						} 
						today = yyyy+'-'+mm+'-'+dd;
						document.getElementById("card_exdate").setAttribute("min", today);
					</script>                    
				</div>

				<div class="form-group col-md-4 col-lg-offset-1">
					<div class="input-group">
				    	<div class="input-group-addon"><span class="glyphicon glyphicon-italic" aria-hidden="true"></span></div>
                    	<input type="text" name="card_code" id="card_code" class="form-control input-lg" placeholder="Security Code" tabindex="1">
                    </div>
				</div>			
				<div class="form-group col-lg-10 col-lg-offset-1">
				    <div class="input-group">
					    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
					    <input type="text"  name="today" id="today" value="" class="form-control input-lg exampleclass" readonly>
					    <div class="input-group-addon"><b>Order Date</b></div>					    							    
				    </div>
				</div>	
		            <script>
		                var currentTime = new Date();
		               	var month = currentTime.getMonth() + 1;
		                var day = currentTime.getDate();
		                var year = currentTime.getFullYear();
		                var date = (year + "-" + month + "-" + day);
		                document.getElementById("today").value = date;
		            </script> 								
				<div class="form-group col-md-10 col-lg-offset-1">
				    <div class="input-group pull-right">
					    <input type="submit" name="confirm" id="confirm" class="btn btn-outline-default" value=" Confirm " style="font-weight: bold; color: #A93226;" onclick="return validate_input();">
				    </div>
				</div>																								    
			</div>
		    <div class="col-lg-10 col-lg-offset-1">		
		    	<br>		
		   		<hr class="colorgraph">     
			</div>				
		</div>
	</div>
	</section>
	</form>
	<?php
	}
	?>
	
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