<!DOCTYPE HTML>
<?php
include_once 'config.php';
include_once 'token.php';

session_start();

if(!isloggedin()){
	header('Location:login.php?need_login=True');
}
if(!isactivated()){
	header('Location:activate.php');
}

$m_id = isloggedin();

if(isset($_GET['product_id'])){
  $pid = $_GET['product_id'];
  $check  =  mysql_query("SELECT product.price,product.description,product.seller_id,accept_product.model_name,product.product_image1 FROM product,accept_product WHERE product.product_id = accept_product.product_id  AND product.product_id = '$pid' ");
  $row_check =  mysql_fetch_array($check,MYSQL_NUM);
  if($row_check[2]!=$m_id){
    header('Location:sellpanel');
  }
}
else{
	header('Location:sellpanel');
}


$sql = mysql_query("SELECT profileimg,username,joindate FROM member WHERE m_id = '$m_id' ");
$row = mysql_fetch_array($sql,MYSQL_NUM);


if(isset($_POST["update"])){

  $price = $_POST['price'];
  $pid = $_POST['pid'];
  $description = $_POST['description'];
  $m_id =isloggedin();
  mysql_query("UPDATE product SET price = '$price' , description = '$description' WHERE product_id = '$pid' ");
  header("Location:sellpanel");
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
		<title> Modify Panel | LuxToTrade COMP2121 Project</title>
		<link rel="icon" href="images/brand_logo_small_icon.png" >
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<link rel="stylesheet" href="css/animate.css" />
		<link rel="stylesheet" href="css/captcha.css">
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
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<style>
		.wrap {
			margin-top:80px;
			padding-left : 50px;
			padding-right : 50px;
			width:100%;
		}
		.modal-backdrop
		{
			opacity:1 !important;
		}
		</style>
	</head>
	<body>
		<!--navbar-->
		<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
					<a class="navbar-brand" href="home">LuxToTrade</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#Navbar1" aria-controls="Navbar1"
						aria-expanded="false" aria-label="Toggle navigation">
								<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="Navbar1">
						<ul class="navbar-nav mr-auto">
						</ul>
						 <!-- Search form -->
						<ul class="navbar-nav ml-auto nav-flex-icons row">
							<li class="nav-item avatar dropdown">
								<a class="nav-link dropdown-toggle" id="DropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo $row[0]; ?>" class="img-fluid rounded-circle z-depth-0" width="30" height="30"><small><?php echo $row[1]; ?></small></a>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="DropdownMenuLink1">
									<a class="dropdown-item" href="" data-toggle="modal" data-target="#Modal1">Logout</a>
								</div>
							</li>
						</ul>
					</div>
				</nav>
		<!--Navbar -->
	<form action="modify_product" method="POST">
    <input type="hidden" value="<?php echo $pid; ?>" name="pid">
	<div class="wrap">
	<fieldset class="col-md-6 offset-md-3">
		<div class="form-top">
			<div class="form-top-left">
				<h1>MOdify Products</h1>
			</div>
		</div>
		<div class="form-bottom">
		  <div class="card card-block"  style="display:block;margin-buttom:20px;">
			<!-- form card cc payment -->
			<div class="card card-outline-secondary" style="padding:10px;">
				<div class="card-block">
          <div class="form-group col-12">
           <label for="model_name">Model Name</label>
           <input type="text" class="form-control" id="model_name" value="<?php echo $row_check[3]; ?>" name="model_name" placeholder="" required disabled>
         </div>
          <div class="form-group col-12">
           <label for="price">Price</label>
           <div class="input-group">
             <span class="input-group-addon">$</span>
             <input type="text" class="form-control" id="price" value="<?php echo $row_check[0] ?>" name="price" placeholder="" required>
             <span class="input-group-addon">HKD</span>
           </div>
         </div>
         <div class="form-group col-md-12 ">
   					<label for="description">Description</label>
   					<textarea class="form-control" id="description" name="description" placeholder="Introduce your product briefly." required ><?php echo $row_check[1]; ?></textarea>
   				  </div>
					<hr>
          </div>
					<input type="submit" class="btn btn-outline-danger" name="update" id="update" value="submit">
					<div style="height:30px;"/>
				</div>
			</div>
			<!-- /form card cc payment -->
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
