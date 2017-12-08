<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Cinema - Movie detail</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Bootstrap 3 template for corporate business" />
	<!-- css -->
	<link href="asset/css/bootstrap.min.css" rel="stylesheet" />
	<link href="asset/plugins/flexslider/flexslider.css" rel="stylesheet" media="screen" />	
	<link href="asset/css/cubeportfolio.min.css" rel="stylesheet" />
	<link href="asset/css/style.css" rel="stylesheet" />
	<link href="asset/css/clndr.css" rel="stylesheet" />	

	<!-- Theme skin -->
	<link id="t-colors" href="asset/skins/default.css" rel="stylesheet" />

	<!-- boxed bg -->
	<link id="bodybg" href="asset/bodybg/bg10.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" rel="stylesheet" />

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
	$(document).ready(function(){
		$(".td").hide();
		$(".ld").hide();

	    $(".typeDrop").click(function(){
	        $(".td").slideToggle();
	    });
	    $(".lanDrop").click(function(){
	        $(".ld").slideToggle();
	    });
	});		
	</script>
	

</head>
<body>
<?php
session_start();
$conn = mysql_connect("mysql.comp.polyu.edu.hk", "14108085d", "ldticogp");
mysql_select_db("14108085d", $conn);
$query_in="select movie_id, name, price from movie where CAST(open_date AS DateTime) <= curdate() order by name";	
$result_in = mysql_query($query_in, $conn);
$count_in=mysql_num_rows($result_in);

$query_up="select movie_id, name, price from movie where CAST(open_date AS DateTime) > curdate() order by open_date";
$result_up = mysql_query($query_up, $conn);
$count_up=mysql_num_rows($result_up);

$detail = $_GET['id'];
$query="SELECT m.movie_id, name, description, director, cast, price, length_of_film,language, type, open_date 
FROM movie m, type t where m.movie_id = t.movie_id AND m.movie_id=".$detail;
$result = mysql_query($query, $conn);
$count = mysql_num_rows($result);
$rowD = mysql_fetch_row($result);

$queryT="SELECT type FROM type where movie_id=".$detail;
$resultT = mysql_query($queryT, $conn);

$query_t="SELECT distinct type, count(type) FROM type GROUP BY type;";
$result_t = mysql_query($query_t, $conn);
$count_t=mysql_num_rows($result_t);

$query_l="SELECT distinct language, count(language) FROM movie GROUP BY language;";
$result_l = mysql_query($query_l, $conn);
$count_l=mysql_num_rows($result_l);


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
					<li>Movie<i class="icon-angle-right"></i></li>
					<li class="active">In Theater</li>
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
					<div class="widget">
						<br>
						<h5 class="widgetheading">Categories</h5>
						<ul class="cat"><b>
							<!--sort by name-->
							<li><i class="fa fa-angle-right"></i><a href="movie_coming.php">Upcoming</a><span> (<?php echo $count_up?>)</span></li>
							<li><i class="fa fa-angle-right"></i><a href="movie_inTh.php">In Theater</a><span> (<?php echo $count_in?>)</span></li>	
							<!--dropdown on the page-->
							<!--sort by type-->
							<li ><i class="fa fa-angle-down"></i><a class="typeDrop">Type</a><span> (<?php echo $count_t?>)</span></li>
								<ul class="td">
									<?php
										while($rowT = mysql_fetch_row($result_t)){?>
												<li><i class="fa fa-angle-right"></i>
													<a href="movie_type.php?id=<?php echo $rowT[0];?>" class="hidden-sm" name="ty" id="ty";><?php echo $rowT[0];?></a><span> (<?php echo $rowT[1]?>)</span>
												</li>
											<?php	
										}
									?>
								</ul>	
							<!--sort by language-->
							<li><i class="fa fa-angle-down"></i><a class="lanDrop">Language</a><span> (<?php echo $count_l?>)</span></li>
								<ul class="ld">
									<?php
										while($rowL = mysql_fetch_row($result_l)){?>
												<li><i class="fa fa-angle-right"></i>
													<a href="movie_lan.php?id=<?php echo $rowL[0];?>" class="hidden-sm" name="lan" id="lan";><?php echo $rowL[0];?></a><span> (<?php echo $rowL[1]?>)</span>
												</li>
											<?php
										}
									?>
								</ul>							
					</b></ul>
					</div>
					<div id="custom-search-input">
			            <form role="form" id="movie_search" name="movie_search" method="post" action="movie_search.php">            	<div id="custom-search-input">
		                        <div class="input-group col-md-12">
		                            <input type="text" name="search" id="search" class="search-query form-control" placeholder=" Search Movie" />
		                            <span class="input-group-btn">
		                                <button class="btn btn-danger" type="submit" name="submit" id="submit">
		                                    <span class=" glyphicon glyphicon-search"></span>
		                                </button>
		                            </span>
		                        </div>
		                    </div>
						</form>					
					</div>
				</aside>
			</div>
			
			<div class="col-lg-9">
				<div class="col-lg-3">
					<img src="asset/img/movie/m<?php echo $rowD[0]?>.jpg">
				</div>
				<div class="col-lg-8 pull-right">
						<label ><span class="label label-info">
							<font size=2><?php $date = date('Y-m-d');
								if(strtotime($rowD[9]) < strtotime($date)){
								echo "In theater";
							}
							else{
								echo "Upcoming";
							}?>	
							</font>	
						</span></label>				
					<?php
					 //error cannot pop out the last type
					while($rowT = mysql_fetch_row($resultT)){
						?>
						<label><span class="label label-warning">
							<font size=2><?php echo $rowT[0]?></font>
						</span></label>		
						<?php
					} 
					?>						
					<hr/>
					<h3><?php echo $rowD[1]?></h3>
					<div>	
						<ul class="cat">
							<li><font size=3><i class="fa fa-video-camera"></i><b>Director:</b> <?php echo $rowD[3]?></font></li>
							<li><font size=3><i class="fa fa-video-camera"></i><b>Cast:</b> <?php echo $rowD[4]?></font></li>
							<li><font size=3><i class="fa fa-globe"></i><b>Language:</b> <?php echo $rowD[7]?></font></li>
							<li><font size=3><i class="fa fa-calendar"></i><b>Open Date:</b> <?php echo $rowD[9]?></font></li>	
							<br>	
						</ul>
					</div>						
				</div>
				<div class="col-lg-12">
				<br>
					<p align="justify"><font size="3"><b>Synopsis:</b></font><br><br><?php echo $rowD[2]?></p>
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