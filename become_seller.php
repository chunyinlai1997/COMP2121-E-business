<!DOCTYPE HTML>
<?php
include_once 'config.php';
include_once 'token.php';
if(!isloggedin()){
	header('Location:login.php?need_login=True');
}
if(!isactivated()){
	header('Location:activate.php');
}

if(isseller()){
	header('Location:home');
}

$m_id = isloggedin();

$sql = mysql_query("SELECT profileimg,username,joindate,email,firstname,lastname,phone,address,country FROM member WHERE m_id = '$m_id' ");
$row = mysql_fetch_array($sql,MYSQL_NUM);

if(isset($_POST['submit'])){
	$bankname = $_POST['bankname'];
	$banknumber = $_POST['bankaccount'];
	mysql_query("INSERT INTO seller(m_id,rating,bankname,bankaccount) VALUES('$m_id','3','$bankname','$banknumber')");
	header("Location:home?seller=activated");
}
?>
<html lang="en">
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Just a frame made by Willon hahaha | Here is the discription">
		<meta name="keywords" content="HTML,CSS,PHP,Bootstrap,COMP,Project,polyu,comp,COMP,PolyU,Hong Kong,luxury,LUXTOT0TRADE">
		<meta name="author" content="Willon Lai">
		<title> Become Seller | LuxToTrade COMP2121 Project</title>
		<link rel="icon" href="images/brand_logo_small_icon.png" >
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<link rel="stylesheet" href="css/animate.css" />
		<link rel="stylesheet" href="css/waypoints.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="js/scroll.js"></script>
		<script src="js/waypoints.js"></script>
		<script src="js/waypoints.min.js"></script>
		<script type="text/javascript" src="js/validate3.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
		<style>
			body, html {
				height: 100%;
			}
			.header{
				background-image: url("images/header4.jpg");
				filter: opacity(0.7);
				-webkit-background-size:cover;
				-moz-background-size:cover;
				-o-background-size:cover;
				background-size:cover;
				background-position:center;
				background-repeat:no-repeat;
				height: 70%;
				padding: 20px;
				text-align: center;
				margin-top: 55px;
			}
			.parallax {
				background-attachment: fixed;
				background-position: center;
				background-repeat: no-repeat;
				background-size: cover;
			}

			@media only screen and (max-device-width: 1048px) {
				.parallax {
					background-attachment: scroll;
				}
				.header {
					height:100%;
				}
			}
			.header h1 {
				font-size: 80px;
				color: whitesmoke;
				padding-top:170px;
				font-family: Merriweather-Light;
			}

			.header h2 {
				font-size:25px;
				color: whitesmoke;
				padding-top:20px;
				font-family: Lato-Hairline;
			}
			.nav-item {
				font-size:100%;
				margin-left: 10px;
				padding-left: 40px;
				font-family: Lato-Hairline;
				color: #000;
			}
			#brand{
				color:#000000;
				font-style: italic;
				padding: 10px;
				padding-left: 40px;
			}
			.cta-5 {
			  color: #46484a;
			  padding: 4rem 0;
			}
			  .cta-5 p {
				color: #696b6e;
			}
			  .cta-5 form.subscribe {
				max-width: 40rem;
				margin: 0 auto;
			}
			  .cta-5 .btn {
				width: 100%;
			}
			.divider {
			  display: block;
			  width: 6rem;
			  height: 0.3rem;
			  background-color: #dfe1e5;
			  margin: 2rem auto;
			}

			.justify-center {
			  display: flex;
			  align-items: center;
			  justify-content: center;
			}
			.features-1 {
			  padding: 5rem 0;
			}
			.features-1 h2 {
				margin-top: 2rem;
			}
			.features-1 .col-feature {
				padding-top: 2rem;
				padding-bottom: 2rem;
			}
			.features-1 .col-feature .rounded-circle {
				  margin: 0 auto;
				  margin-bottom: 2rem;
				  width: 6rem;
				  height: 6rem;
				  background: none;
				  border: 0.15rem solid #dfe1e5;
			}
			.cta-4 {
			  background-color: #363636;
			  background-size: cover;
			  color: #fff;
			  padding: 5rem 0;
			  min-height: 50rem;
			}
			  .cta-4 p {
				color: rgba(255, 255, 255, 0.75);
			}
			#section2 {padding-top:20px;height:auto;color: #000; background-color: #f5f5f5; padding:10px;}
			.section2-h1{
				font-size: 45px;
				padding-top:30px;
				font-family: Merriweather-Light;
				font-style: bold;
				padding-bottom: 20px;
				text-align: center;
			}

			.section2-h2{
				text-align: center;
				font-size: 25px;
				font-family: Lato-Hairline;
				font-style: bold;
				padding-bottom: 20px;
			}

			.section2-h3{
				font-size:30px;
				text-align: center;
				padding: 10px;
				padding-top: 30px;
				font-family: Merriweather-Light;
			}

			.section2-p{
				font-size:18px;
				text-align: center;
				padding: 10px;
				font-family: Lato-Hairline;
			}

			#section4-1 {padding-top:50px; padding-bottom: 70px; height:auto;color: #fff; background-color: #193725; padding-left:10px; padding-right:10px; font-family: Lato-Hairline;}
			.section4-h1{
				font-size: 45px;
				padding-top:0px;
				padding-bottom:50px;
				font-family: Merriweather-Light;
				font-style: bold;
				text-align: center;
			}

			.section4-h2{
				text-align: left;
				font-size: 30px;
				font-family: Merriweather-Light;
				font-style: bold;
				padding-top: 20px;
			}

				.section4-td-img{
				padding-left:80px;
				padding-right:30px;
				padding-top: 40px;
				padding-bottom: 40px;
			}

			.section4-p{
				font-size:18px;
				text-align: left;
				padding-right: 80px;
				font-family: Lato-Hairline;
			}
		</style>
	</head>
<body>
			<!--navbar-->
			<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
				<a class="navbar-brand" href="home"><img src="images/brand_logo_black.png" width="100" height="50"></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#Navbar1" aria-controls="Navbar1"
					aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="Navbar1">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link" href="home">Discover</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link" href="shop">Shop</a>
						</li>
					</ul>
					<ul class="navbar-nav ml-auto nav-flex-icons row ">
						<li class="nav-item avatar dropdown">
							<a class="nav-link dropdown-toggle" id="DropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo $row[0]; ?>" class="img-fluid rounded-circle z-depth-0" width="30" height="30"><small><?php echo $row[1]; ?></small></a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="DropdownMenuLink1" style="width:50%;">
								<a class="dropdown-item" href="profile">Profile</a>
								<a class="dropdown-item" href="" data-toggle="modal" data-target="#Modal1">Logout</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>
		<!--Navbar -->
		<div class="header parallax" id="header">
			<h1>BECOME THE SELLER</h1>
			<h2 class="font-weight-bold text-uppercase">Sell via LuxToTrade, earn from your luxuries.</h2>
		</div>

		<section class="cta-5 text-center" id="next">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-8 text-center text-lg-left">
						<h2 class="mt-4 mb-2 font-weight-bold" style="font-family: Lato-Hairline;">Start to sell your bags and acccessories today!</h2>
						<p class="lead mb-3 font-weight-bold" style="font-family: Lato-Hairline;">Start seller role now to earn extra 10% on your first sold item.</p>
					</div>
					<div class="col-lg-4">
						<a href="#getstart" class="btn btn-lg btn-success pill-btn mt-3 font-weight-bold" style="font-family: Lato-Hairline; background-color:#dbc65d; border-color:#dbc65d;">Start Now</a>
					</div>
				</div>
			</div>
		</section>

		<!-- Section 2 -->
			<div id="section2" class="container-fluid">
				<h1 class="section2-h1">WHY LUXTOTRADE?</h1>
					<div class="container">
					 <h2 style="font-size:1.5em;" class="section2-h2 font-weight-bold text-uppercase">We've got what you need!</h2>

					 <hr>
					 <h2 class="section2-h2 font-weight-bold text-uppercase">The LuxPrime Services</h2>
					  <div class="row">
						  <div class="col-12 col-sm-6 col-md-4">
							<div class="row">
								<div class="col-sm-10 col-sm-offset-2 text-center">
									<img class="section2-img-icon" src="images/icon-AUTHENTICITY.png" height="200" width="200" align="middle">
									<h3 class="section2-h3" style="color:#146eb4;">AUTHENTICITY</h3>
									<p class="section2-p font-weight-bold">Our experts authenticate every product sold on
									LUXToTrade. Never need to worry about legit buyers or
									sellers, we’re in the middle.</p>

								</div>
							</div>
						  </div>
						  <div class="col-12 col-sm-6 col-md-4 text-center">
							<div class="row">
							  <div class="col-sm-10 col-sm-offset-1 text-center">
							  <img class="section2-img-icon" src="images/icon-convenience.png" height="200" width="200" align="middle">
							  <h3 class="section2-h3" style="color:#60ab59;">CONVENIENCE</h3>
							  <p class="section2-p font-weight-bold">No need to make any appointment with the buyer/seller.
								Just need to do your “business” on one single device, and
								the product/money will go to you automatically.</p>
								</div>
							</div>
						  </div>
						  <div class="col-12 col-sm-6 col-md-4 text-center">
							<div class="row">
							  <div class="col-sm-10 text-center">
							  <img class="section2-img-icon" src="images/icon-3Dscanning.png" height="200" width="200" align="middle">
							  <h3 class="section2-h3" style="color:#ecb731;">3D SCANNING</h3>
							  <p class="section2-p font-weight-bold">Just takes a few photos of the product with your phone,
							  our system will generate a 3D model of it. Buyer can have a
							  comprehensive understanding of the product.</p>
							  </div>
							</div>
						  </div>
				  </div>
				  <br>
				  <hr>
				  <br>
			  </div>
			</div>
			<!-- Section 2 -->

			<div id="section4-1" class="container-fluid">
						<h1 class="section4-h1">SELLING ON LUXTOTRADE</h1>
						<div class="row" style="margin-top:20px;">
							<div class="col-12 col-sm-6 col-md-4">
							<div class="row">
								<div class="col-sm-10 col-sm-offset-2 text-center">
									<img class="section4-img" src="images/SELLORBUY-white.png" height="200" width="200" align="middle">
									<div class="section4-h2" style="text-align:center;">POST</div>
									<p class="section2-p" style="font-size:1.3em; margin-top:20px; margin-bottom:20px;">Post your item on LuxToTrade. We'll send you a prepaid shipping label to your place so you can send it to us for free. The whole process can be done in 2-3 working days.</p>

								</div>
							</div>
							</div>
							<div class="col-12 col-sm-6 col-md-4 text-center">
							<div class="row">
								<div class="col-sm-10 col-sm-offset-1 text-center">
								<img class="section4-img" src="images/AUTHENTICITY2-white.png" height="200" width="200" align="middle">
								<div class="section4-h2" style="text-align:center;">AUTHENTICATE</div>
								<p class="section2-p" style="font-size:1.3em; margin-top:20px; margin-bottom:20px;">Ship your item within 2 business day after the buyer purchase. We authenticate it and store it in our warehouse.</p>
								</div>
							</div>
							</div>
							<div class="col-12 col-sm-6 col-md-4 text-center">
							<div class="row">
								<div class="col-sm-10 text-center">
								<img class="section4-img" src="images/MONEY-white.png" height="200" width="200" align="middle">
								<div class="section4-h2" style="text-align:center;">PROSPER</div>
								<p class="section2-p" style="font-size:1.3em; margin-top:20px; margin-bottom:20px;">When the buyer make an order on your products, we'll immediately send your item to the buyer and you'll immediately receive the earning paid by the buyer.</p>
								</div>
							</div>
							</div>
					</div>
				</div>

		<section id="getstart" class="cta-4 text-center justify-center" style="height:200px;">
			<div class="container">
				<h2 class="mb-5">Provide your bamk acoount information to activate the seller role.</h2>
				<small>This information is for us to transfer payment to you directly.</small>
				<div class="divider"></div>
				<form class="subscribe" method="POST" action="become_seller.php">
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="bankname">Bank Name</label>
							<input type="text" class="form-control is_valid" id="bankname" name="bankname" placeholder="Bank Name">
							<div id="vBN" class="invalid-feedback" style="display:none;"> Please provide a valid bank name. </div>
						</div>
						<div class="col-md-6 mb-3">
							<label for="bankaccount">Bank Account Number</label>
							<input type="text" class="form-control " id="bankaccount" name="bankaccount" placeholder="Bank Account">
							<div id="vBA" class="invalid-feedback" style="display:none;"> Please provide a valid bank account number. </div>
						</div>
					</div>
					<div class="row">
						<div class="m-auto col-md-4">
							<button type="submit" name="submit" id="submit_seller" class="btn btn-lg btn-primary pill-btn" disabled>Get Started</button>
						</div>
					</div>
				</form>
			</div>
		</section>

		<div class="modal fade" id="Modal1" tabindex="-1" role="dialog" aria-labelledby="ModalContent1" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="ModalContent1">Logout?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true"></span>
				</button>
			  </div>
			  <div class="modal-body">
				Logout all device or this device?
				<form role="form" action="logout.php" method="POST">
					<button type="submit" name="L1" value="all" class="btn btn-danger">Logout All</button></a>
					<button type="submit" name="L2" value="this" class="btn btn-primary">Logout This Device</button></a>
				</form>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>

		<script>
		jQuery.noConflict();

		$(document).ready(function(){
			$('#bankname').keyup(function(){
			   var bn = $('#bankname').val().length;
			   if( bn >= 3 ){
					$('#bankname').addClass("is_valid").removeClass("is_invalid");
					$('#vBN').css("dsiplay","none");
				    checking();
			   }
			   else{
					$('#bankname').addClass("is_invalid").removeClass("is_valid");
					$('#vBN').css("dsiplay","block");
				    checking();
			   }
		    });

			$('#bankaccount').keyup(function(){
			   var c = $('#bankaccount').val();
			   $('#bankaccount').val(c.replace(/[^0-9]/g, ''));
			   var ba = $('#bankaccount').val().length;
			   if( ba >= 11 ){
					$('#bankaccount').addClass("is_valid").removeClass("is_invalid");
					$('#vBA').css("dsiplay","none");
				    checking();
			   }
			   else{
					$('#bankaccount').addClass("is_invalid").removeClass("is_valid");
					$('#vBA').css("dsiplay","block");
				    checking();
			   }
		    });

			function checking(){
				var bn = $('#bankname').val().length;
				var ba = $('#bankaccount').val().length;
				if(bn >=3 && ba>=11){
					$('#submit_seller').attr("disabled",false);
				}
				else{
					$('#submit_seller').attr("disabled",true);
				}
			}

		});
		</script>
</body>
</html>
