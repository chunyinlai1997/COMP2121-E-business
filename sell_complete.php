<!DOCTYPE HTML>
<?php
include_once 'config.php';
include_once 'token.php';

session_start();

if(!isloggedin()){
	header('Location:login?need_login=True');
}
if(!isactivated()){
	header('Location:activate');
}

if(!isseller()){
	header('Location:become_seller');
}

$m_id = isloggedin();

$sql = mysql_query("SELECT profileimg,username,joindate,email,firstname,lastname,phone,address,country FROM member WHERE m_id = '$m_id' ");
$row = mysql_fetch_array($sql,MYSQL_NUM);
$thank = "Your item has successfully posted on LuxToTrade!";
$pay_notice ="";
if(isset($_GET["pid"]) && isset($_GET["payment"])){
  $product_id = $_GET["pid"];
  $pay_id = $_GET["payment"];
  if($pay_id =="na"){

  }
  else{
    $sql_pay = mysql_query("SELECT amount, cc_num, pay_date FROM payment_b WHERE payment_id ='$pay_id' ");
    $rowpay = mysql_fetch_array($sql_pay,MYSQL_NUM);
    $smcc= substr($rowpay[1], -4);
		$pay_notice = "You have paid $$rowpay[0] by credit card number: ***$smcc on $rowpay[2] for subscribing the LuxPrime Service.";
  }
}
else{
  header('Location:shop');
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
  <title> Sell Complete | LuxToTrade COMP2121 Project</title>
  <link rel="icon" href="images/brand_logo_small_icon.png" >
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <link rel="stylesheet" href="css/animate.css" />
  <link rel="stylesheet" href="css/waypoints.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="js/scroll.js"></script>
  <script src="js/waypoints.js"></script>
  <script src="js/waypoints.min.js"></script>
  <script type="text/javascript" src="js/validate4.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  <style>
  .wrap {
    margin-top:80px;
    padding-left : 50px;
    padding-right : 50px;
    width:100%;
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
  						<a class="dropdown-item" href="#">Help</a>
  						<hr>
  						<a class="dropdown-item" href="" data-toggle="modal" data-target="#Modal1">Logout</a>
  					</div>
  				</li>
  			</ul>
  		</div>
  	</nav>
		<!--Navbar -->
  <form>
    <div class="wrap">
  	<fieldset class="col-md-6 offset-md-3">
  		<div class="form-top">
  			<div class="form-top-left">
  				<div class="progress">
  					<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Progress:100%</div>
  				</div>
  				<h1>Sell Complete</h1>
  			</div>
  		</div>
  		<div class="form-bottom">
  		  <div class="card card-block" id="payform" style="display:block;margin-buttom:20px;">
  			<!-- form card cc payment -->
  			<div class="card card-outline-secondary" style="padding:10px;">
  				<div class="card-block">
  					  <h5 style="text-align:center; color:green;"><?php echo $thank; ?></h5>
							<h6 style="color:brown;"><?php echo $pay_notice; ?></h6>

  						<div style="margin-top:50px; margin-left:10px; padding:10px;">
								<p>We will send the prepaid shipping label to you in 1 working day. Please send your item to us as soon as possible so it can be avavailble to sell.</p>
								<div class="row" style="width:inherit; text-align:center;">
									<div class="col-12 col-sm-6">
										<a href="buypanel?payment"><button type="button" class="btn btn-success btn-lg float-right">View my payment record</button></a>
									</div>
									<div class="col-12 col-sm-6 ">
				            <a href="sellpanel"><button type="button" class="btn btn-info btn-lg float-right">View my sell record</button></a>
									</div>
								</div>
								<div class="row" style="width:inherit; text-align:center;">
									<div class="col-12 col-sm-6">
										<a href="shop"><button type="button" class="btn btn-primary btn-lg float-right">Back to Shop</button></a>
									</div>
								</div>
  						</div>


  				</div>
  			</div>
  			<!-- /form card cc payment -->
  		</div>
    </div>
  	</fieldset>
  	</div>
  	</form>

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
</body>
</html>
