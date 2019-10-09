<!DOCTYPE HTML>
<?php
include_once 'config.php';
include_once 'token.php';
include_once 'home_product.php';
include_once 'home_product2.php';
if(!isloggedin()){
	header('Location:login?need_login=True');
}
if(!isactivated()){
	header('Location:activate');
}
//https://imgur.com/#access_token=9d80a5579bea50b9dbdaad0528ee66d08da6ecca&expires_in=315360000&token_type=bearer&refresh_token=587cb7de7f31ccb9b20ab18356dc84928fe30bf3&account_username=chunyinlai1997&account_id=75370421
// imgur ClientID: 7424eb4ea028890
// imgur Client secret:	ab16c127c11e69bd00cac7fd20e475bbd6a640bf
$m_id = isloggedin();

if(!isseller()){
	header("Location:become_seller");
}

$sql = mysql_query("SELECT profileimg,username,joindate,email,firstname,lastname,phone,address,country FROM member WHERE m_id = '$m_id' ");
$row = mysql_fetch_array($sql,MYSQL_NUM);

$sql2 = mysql_query("SELECT COUNT(*) FROM logintoken WHERE m_id = '$m_id' ");
$active = mysql_fetch_array($sql2,MYSQL_NUM);

?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Just a frame made by Willon hahaha | Here is the discription">
		<meta name="keywords" content="HTML,CSS,PHP,Bootstrap,COMP,Project,polyu,comp,COMP,PolyU,Hong Kong,luxury,LUXTOT0TRADE">
		<meta name="author" content="Willon Lai">
		<link rel="icon" href="images/brand_logo_small_icon.png" >
		<title>Seller Panel | LuxToTrade COMP2121 Project</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/animate.css" />
		<link rel="stylesheet" href="css/waypoints.css" />
		<script src="js/scroll.js"></script>
		<script src="js/waypoints.js"></script>
		<script src="js/waypoints.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
		<style>
		.wrap {
			margin-top: 80px;
			padding-left: 50px;
			padding-right: 50px;

		}
		.wrap {
			width:100%;
		}
		.modal-backdrop
		{
			opacity:1 !important;
		}

		.navbar {
			background-color: grey;
		}

		.navbar-brand {
			color: black;
		}
		.nav-link {
			color: black;
		}
		#sellbutton {
			margin-left:50px;
		}
		@media screen and (max-width:992px){
			#sellbutton{
				margin-left:0px;
				margin-top:5px;
				margin-top: 5px;
			}
			.nav-item{
				margin-bottom:1px;
				margin-top: 1px;
				margin-left: 1px;
				megin-right:1px;
			}
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
				<li class="nav-item active">
					<a class="nav-link" href="profile">Back</a>
				</li>

				<li class="nav-item" id="sellbutton">
					<?php
					if(!isseller()){
						echo "<a href='become_seller'><button class='btn btn-danger' type='button'>Become Seller</button></a>";
					}
					else{
						echo "<a href='guideline'><button class='btn btn-warning' type='button'>Sell Products</button></a>";
					}
					?>
				</li>
			</ul>
			 <!-- Search form -->
			<form class="form-inline">
				 <div class="form-group">
					<input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search"></input>
					<button class="btn btn-outline-primary btn-sm my-0" type="submit">Search</button>
				 </div>
			</form>
			<ul class="navbar-nav ml-auto nav-flex-icons row ">
				<li class="nav-item">
					<a id="view_cart" style="font-size:1.3em;" class="nav-link waves-effect waves-light" href="" data-toggle="modal" data-target="#cart_modal"></a>
				</li>
				<li class="nav-item">
					<a id="view_message" style="font-size:1.3em;" class="nav-link waves-effect waves-light">1 <i class="fa fa-envelope"></i></a>
				</li>
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

	<div class="wrap">
			<div class="row">
				<div class="col-12">
          <h1>Seller Panel</h1>
						<div class="row">
							<div class="nav flex-column nav-pills col-12 col-md-2 col-lg-2" id="purchase_tabs" role="tablist" >
								<a class="nav-link active" id="cart-tab" data-toggle="pill" href="#sell" role="tab" >Selling Item</a>
								<a class="nav-link" id="wishlist-tab" data-toggle="pill" href="#sold" role="tab" >Sold Item</a>
								<a class="nav-link" id="rate-tab" data-toggle="pill" href="#rate" role="tab" >Comment and Rate</a>
							</div>

							<div class="tab-content col-12 col-md-10 col-lg-10" id="v-pills-tabContent">
								<div class="tab-pane fade show active" id="sell">
									<div class="row" id="sell_detail">
										<div class="col-lg-12" style="margin-bottom:20px;">
											<h5 style="text-align:center;">Selling Item</h5>
										</div>

										<?php
										$q = "SELECT product.product_id,product.price,product.product_image1,product.description,product.STATUS,product.post_date,product.seller_id FROM product
											WHERE  product.seller_id = '$m_id' and product.STATUS<>'sold'" ;
										$result = print_row_product_3($q);
										echo $result[0];

										?>
									</div>
								</div>
								<div class="tab-pane fade" id="sold" >
										<div class="row" id="sell_detail">
										<div class="col-lg-12" style="margin-bottom:20px;">
											<h5 style="text-align:center;">Sold Item</h5>
										</div>

										<?php

										$q = "SELECT product.product_id,product.price,product.product_image1,product.description,product.STATUS,product.post_date,product.seller_id FROM product
											WHERE  product.seller_id = '$m_id' and product.STATUS='sold'" ;
										$result = print_row_product_3($q);
										echo $result[0];

										?>
									</div>
								</div>
								<div class="tab-pane fade" id="rate"  >
								<h5 style="text-align:center;">My Rating</h5>
								Still in Development
								</div>
						</div>
        </div>
      </div>
	</div>

	<div class="modal fade" id="view_content" tabindex="-1" role="dialog" aria-labelledby="view_content_detail" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="view_content_detail">Product Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true"></span>
				</button>
			  </div>
			  <div id="detail_generate"></div>
			</div>
		  </div>
	</div>

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
				<form role="form" action="logout" method="POST">
					<button type="submit" name="L1" value="all" class="btn btn-danger">Logout All</button>
					<button type="submit" name="L2" value="this" class="btn btn-primary">Logout This Device</button>
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
		$(document).on('click', '.view_details', function(){
		 var pid = $(this).attr('id');
			 $('#detail').attr('id',pid);
		 var link = 'details?product='+pid;
		 $('#detail').attr('href',link);
		 $('#dcart').attr('id',pid);

		 	$.ajax({
				 url:"content.php",
				 method:"POST",
				 data:{get:pid},
				 success:function(data)
				 {
					 $('#detail_generate').html(data);
				 }
			 });
		});
	});


	</script>


	</body>
</html>
