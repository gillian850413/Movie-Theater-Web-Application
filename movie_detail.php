<?php
session_start();
?>
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
	<script type="text/javascript">
	function validate_input() {
	    var err_msg = '';
	    var quan = document.getElementById("quan").value;	    
	    if(quan == '' || quan <= 0) {
	        err_msg += "You must buy at least one ticket";
	        err_msg += "\n";
	    } 
	    
	    if(err_msg != '') {
	        alert(err_msg);
	        return false;
	    }
	    return true;
	}		
	</script>
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
	
	<style type="text/css">
	  @import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);

	fieldset, label { margin: 0; padding: 0; }
	body{ margin: 20px; }

	/****** Style Star Rating Widget *****/

	.rating { 
	  border: none;
	  float: left;
	}

	.rating > input { display: none; } 
	.rating > label:before { 
	  margin: 5px;
	  font-size: 1.25em;
	  font-family: FontAwesome;
	  display: inline-block;
	  content: "\f005";
	}

	.rating > .half:before { 
	  content: "\f089";
	  position: absolute;
	}

	.rating > label { 
	  color: #ddd; 
	 float: right; 
	}

	/***** CSS Magic to Highlight Stars on Hover *****/

	.rating > input:checked ~ label, /* show gold star when clicked */
	.rating:not(:checked) > label:hover, /* hover current star */
	.rating:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */

	.rating > input:checked + label:hover, /* hover current star when changing rating */
	.rating > input:checked ~ label:hover,
	.rating > label:hover ~ input:checked ~ label, /* lighten current selection */
	.rating > input:checked ~ label:hover ~ label { color: #FFED85;  } 
	</style>
</head>

<body>
<?php
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

$queryC = "select * from comment where  movie_id=".$detail;
$resultC = mysql_query($queryC, $conn);
$countC = mysql_num_rows($resultC);

$queryCT = "select rating from comment where  movie_id=".$detail;
$resultCT = mysql_query($queryCT, $conn);
$countCT = mysql_num_rows($resultCT);

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
					<li><a href="index.php"><i class="fa fa-home"></i></a></li>
					<li>Movie</li>
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
							<?php 
							if($countCT != 0){
								$addRating = 0;
								while($rowCT = mysql_fetch_row($resultCT)){
									$addRating += $rowCT[0];
								}
								$avgRating = round($addRating / $countCT, 2) ;	
								?>
									<li><font size=3><i class="fa fa-star-half-o"></i><b>Rating: <?php echo $avgRating;?> / 5</b></font></li>	
								<?php							
							}
							else{
								?>
									<li><font size=3><i class="fa fa-star-half-o"></i><b>Rating: --- </b></font></li>	
								<?php								
							}
							?>
							
							<br>	
							<li>
							<button class="btn btn-outline-default"><a href="#ticket_section" name="buy" id="buy"><font size=3><b>Buy Ticket</b></font></a></button>&nbsp;&nbsp;&nbsp;
							<button class="btn btn-outline-default"><a href="#comment_section" name="buy" id="buy"><span class="glyphicon glyphicon-comment"></span><font size=3><b> View Comments (<?php echo $countC;?>)</b></font></a></button>
							</li>								
						</ul>
					</div>						
				</div>
				<div class="col-lg-12">
				<br>
					<p align="justify"><font size="3"><b>Synopsis:</b></font><br><br><?php echo $rowD[2]?></p>
				</div>	
			</div>
	</section>
	<hr>
	<section id="comment_section">
	<div class="container"><br><br>	
		<div class="row">	
			<div class="col-lg-3">
				<aside class="left-sidebar">
				</aside>
			</div>		
			<div class="col-lg-9">                              
				<div class="comment-area">     
						<h4><?php echo $countC?> Comments</h4>  
						<?php
						$i = 0;
						while($rowC = mysql_fetch_row($resultC)) { 
							?>
							<div class="media">
								<a href="#" class="pull-left"><img src="asset/img/user.png" alt="" class="img-circle" style="width: 60px; height: 60px;" /></a>
								<div class="media-body">
									<div class="media-content">
										<label class="pull-right col-lg-4"><font size="4">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rating: 
										<?php
										$star = explode(".", $rowC[5]);
										for($i=0; $i<$star[0]; $i++){
										?>	
											<i class="fa fa-star" aria-hidden="true"></i>
										<?php
										}
										if(count($star)==2){
										?>
											<i class="fa fa-star-half-o" aria-hidden="true"></i>
										<?php										
										}
										if((5 - $star[0]) != 0 && $rowC[5] != ''){
											for($j=1; $j<(5 - $star[0]); $j++){
											?>
												<i class="fa fa-star-o" aria-hidden="true"></i>
											<?php
											}
										}
										if($rowC[5] == ''){
											for($j=0; $j<5; $j++){
											?>
												<i class="fa fa-star-o" aria-hidden="true"></i>
											<?php
											}
										}
										?>
										</font></label>							
										<label class="col-lg-8"><font size="4"><?php echo $rowC[2]?> &nbsp;&nbsp;<span><?php echo $rowC[3]?></span></font></label>
										<br><br>
										<label class="col-lg-12"><p><?php echo $rowC[4]?></p></label>									
									</div>
								</div>
							</div>						
							<?php
							$i++;
						}
						?>

						<hr>
						<?php
						if(isset($_SESSION['username'])){
							$query = "select movie_id, username from movie_buy where username='".$_SESSION['username']."' AND movie_id=".$_GET['id'];
							$result = mysql_query($query, $conn);
							$row = mysql_fetch_row($result);
							if($_SESSION['username'] == $row[1]){
							?>
								<div class="marginbot30"></div>
								<h4>Leave your comment</h4>

								<?php
								if(isset($_SESSION['com_error']) ){
									$com_error = $_SESSION['com_error'];
								    echo $com_error;
								    unset($_SESSION['com_error']);
								}
								?>								
								<form role="form" method="post" name="comForm" id="comForm" action="comment.php?mid=<?php echo $row[0]?>">
									<label><font size="3">&nbsp;Rating: </font></label>
									<div class="form-group">
										<fieldset class="rating">
										    <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
										    <input type="radio" id="star4half" name="rating" value="4.5" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
										    <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
										    <input type="radio" id="star3half" name="rating" value="3.5" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
										    <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
										    <input type="radio" id="star2half" name="rating" value="2.5" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
										    <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
										    <input type="radio" id="star1half" name="rating" value="1.5" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
										    <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
										    <input type="radio" id="starhalf" name="rating" value="0.5" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
										</fieldset><br>			 	
									</div>		

									<div class="form-group">
										<div class="input-group">
											<div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
											<input type="text" class="form-control input-lg exampleclass" id="username" name="username" value="<?php echo $_SESSION['username'];?>" style="height: 40px" readonly> 
										</div>
								 	</div>
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>									
											<input type="text" class="form-control input-lg exampleclass" id="today" name="today" value="" style="height: 40px" readonly>
										</div>
								 	</div>	
					                <script>
					                    <!--
					                    var currentTime = new Date();
					                    var month = currentTime.getMonth() + 1;
					                    var day = currentTime.getDate();
					                    var year = currentTime.getFullYear();
					                    var date = (year + "-" + month + "-" + day);
					                    document.getElementById("today").value = date;
					                    //-->
					                </script>								 	
								 	<div class="form-group">
										<textarea class="form-control" name="comment" id="comment" rows="8" placeholder="* Your comment here"></textarea>
									</div>
									<button type="submit" name="submit" id="submit" class="btn btn-theme btn-md">Submit</button>
								</form>
							<?php						
							}
						}
						?>
						<br>
					</div>
				<div class="clear"></div>
			</div>							
			</div>
	</section>
	<hr>
	<section style="background-color:#FFFFFF" id="ticket_section" >
	<div class="container" >
		<div class="row">	
			<div class="col-lg-3">
				<aside class="left-sidebar">
				</aside>
			</div>
						
			<div class="col-lg-8">
				<form method="post">
					<br>
					<h4>Choose Date (Only the following week schedule will be displayed):</h4>
					<b><input type="date" class="form-control" name="datefield" id="datefield" min='1899-01-01' max='2000-01-01' onchange="this.form.submit()" style="width: 200px" value="<?php if(isset($_POST['datefield'])){echo $_POST['datefield'];} else{ echo "";}?>" /></b>
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
						document.getElementById("datefield").setAttribute("min", today);
						var today = new Date();
						var maxDate = new Date(today);
						maxDate.setDate(today.getDate() + 6);
						var dd = maxDate.getDate();
						var mm = maxDate.getMonth()+1; //January is 0!
						var yyyy = maxDate.getFullYear();
				        if(dd<10){
					        dd='0'+dd
					    } 
					    if(mm<10){
					        mm='0'+mm
					    } 						
						maxDate = yyyy+'-'+mm+'-'+dd;
						document.getElementById("datefield").setAttribute("max", maxDate);

					</script>
					</form>
	                <br>  
	                <!--if isset datefeild, then post the table, else print today's session-->
						<table class="table table-hover" name="timetable" id="timetable">
						    <thead>
								<tr class="bg-info">
							        <th class="text-center"><font size=3>Time</font></th>
							        <th class="text-center"><font size=3>Price</font></th>
							        <th class="text-center"><font size=3>Quantity</font></th>
							        <th class="text-right"><font size=3>Add to Cart</font></th>
						    	</tr>
						    </thead>
							    
						    <tbody>
								<?php
						        if(isset($_SESSION['add_error']) ){
									$add_error = $_SESSION['add_error'];
						    		echo $add_error;
						    		unset($_SESSION['add_error']);
								}
								else{
									if(isset($_POST['datefield'])){
										$date = $_POST['datefield'];
										$queryDate = "SELECT t.id, t.time, m.price  FROM timeslot t, movie m where t.movie_id = m.movie_id AND t.movie_id = '".$rowD[0]."' AND concat(date, ' ', time) > now() AND date='".$date."'  order by time";
										$resultDate = mysql_query($queryDate, $conn);
										$countDate = mysql_num_rows($resultDate);
										if($countDate != 0){
											while($row = mysql_fetch_row($resultDate)){
											?>
												<form method="post" name="form" id="form" action="ticket_cart.php?id=<?php echo $row[0]?>">
										    	<tr >
											        <td class="text-center"><b><?php echo $row[1]?></b></td>
											        <td class="text-center" style="width: 300px;"><b><?php echo $row[2]?></b></td>
											        <td class="col-lg-2 col-md-offset-2">
											        	<b><input id="quan" name="quan" class="form-control" type="number" value="1" min="1" max="100" /></b>
											        </td>
											        <td class="text-right">
											        	<button type="submit" class="btn btn-outline-danger" name="add" id="add" onclick="return validate_input()">
								                        <span class="glyphicon glyphicon-plus" style="color:#2A7BCC"></span></button>
								                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								                    </td>					                    
										    	</tr>
										    	<input type="hidden" name="date" id="date" value="<?php echo $date?>">
										    	</form> 								
											<?php
											}
										}
										else{
											?>
											<tr><td><font size=4><b>No Timeslot</b></font></td></tr>
											<?php
										}										
									}
								}
								?>					    	
						    </tbody>
						</table>  
			<br><br><br>
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