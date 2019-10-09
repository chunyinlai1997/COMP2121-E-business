<!DOCTYPE HTML>
<?php
include_once 'config.php';
include_once 'token.php';
include_once 'home_product.php';
if(!isloggedin()){
	header('Location:login.php?need_login=True');
}
if(!isactivated()){
	header('Location:activate.php');
}
//https://imgur.com/#access_token=9d80a5579bea50b9dbdaad0528ee66d08da6ecca&expires_in=315360000&token_type=bearer&refresh_token=587cb7de7f31ccb9b20ab18356dc84928fe30bf3&account_username=chunyinlai1997&account_id=75370421
// imgur ClientID: 7424eb4ea028890
// imgur Client secret:	ab16c127c11e69bd00cac7fd20e475bbd6a640bf
$m_id = isloggedin();

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
		<title>Buyer Panel | LuxToTrade COMP2121 Project</title>
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
					<a id="view_wish" style="font-size:1.3em;" class="nav-link waves-effect waves-light" href="" data-toggle="modal" data-target="#wish_modal"></a>
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
  <script>
  $(document).ready(function(){
    $('#nav-cart-tab').on('click',function(){
      $('#cart-tab').css('display','block');
      $('#wish-tab').css('display','none');
      $('#order-tab').css('display','none');
      $('#payment-tab').css('display','none');
      $('#rate-tab').css('display','none');
    });
    $('#nav-wish-tab').on('click',function(){
      $('#wish-tab').css('display','block');
      $('#cart-tab').css('display','none');
      $('#order-tab').css('display','none');
      $('#payment-tab').css('display','none');
      $('#rate-tab').css('display','none');
    });
    $('#nav-order-tab').on('click',function(){
      $('#order-tab').css('display','block');
      $('#cart-tab').css('display','none');
      $('#wish-tab').css('display','none');
      $('#payment-tab').css('display','none');
      $('#rate-tab').css('display','none');
    });
    $('#nav-rate-tab').on('click',function(){
      $('#rate-tab').css('display','block');
      $('#cart-tab').css('display','none');
      $('#wish-tab').css('display','none');
      $('#order-tab').css('display','none');
      $('#payment-tab').css('display','none');
    });
    $('#nav-payment-tab').on('click',function(){
      $('#payment-tab').css('display','block');
      $('#cart-tab').css('display','none');
      $('#wish-tab').css('display','none');
      $('#order-tab').css('display','none');
      $('#order-tab').css('display','none');
    });

  });
  </script>
	<div class="wrap">
			<div class="row">
				<div class="col-12">
          <h1>Buyer Panel</h1>
              <nav class="nav nav-pills nav-justified">
								<?php
								$t1 = ""; $st1 = "";
								$t2 = "";	$st2 = "";
								$t3 = "";	$st3 = "";
								$t4 = "";	$st4 = "";
								if(isset($_GET['cart'])){
									$t1 = "active";
									$st1 = "show active";
								}
								else if(isset($_GET['wishlist'])){
									$t2 = "active";
									$st2 = "show active";
								}
								else if(isset($_GET['purchase'])){
									$t3 = "active";
									$st3 = "show active";
								}
								else if(isset($_GET['payment'])){
									$t4 = "active";
									$st4 = "show active";
								}
								else{
									$t1 = "active";
									$st1 = "show active";
								}
								?>

    						<li class="nav-item">
    							<a id="nav-cart-tab" href="#" data-target="#cart-tab" data-toggle="tab" class="nav-link nav-item <?php echo $t1; ?>">Shopping Cart</a>
    						</li>
                <li class="nav-item">
    							<a id="nav-wish-tab" href="#" data-target="#wish-tab" data-toggle="tab" class="nav-link nav-item <?php echo $t2; ?>">Wishlist</a>
    						</li>
                <li class="nav-item">
    							<a id="nav-order-tab" href="#" data-target="#order-tab" data-toggle="tab" class="nav-link nav-item <?php echo $t3; ?>">Purchased Items</a>
    						</li>
                <li class="nav-item">
    							<a id="nav-payment-tab" href="#" data-target="#payment-tab" data-toggle="tab" class="nav-link nav-item <?php echo $t4; ?>">My Payments</a>
    						</li>
    					</nav>

              <div class="tab-content p-b-4">
    						<div class="tab-pane fade <?php echo $st1; ?>" id="cart-tab">
									<div class="row" id="shopping_cart_detail">
										<div class="col-lg-12" style="margin-bottom:20px;">
											<h2 style="text-align:center;">Shopping Cart</h2>
											<a role="button" href="checkout" class="btn btn-lg btn-success">Checkout</a>
										</div>
										<?php
										$q = "SELECT product.product_id,product.price,product.product_image1,product.description,product.STATUS,product.post_date,product.seller_id FROM shopping_cart,product
											WHERE shopping_cart.product_id = product.product_id
											AND shopping_cart.m_id = '$m_id'";
										$result = print_product($q);
										echo $result[0];
										?>
									</div>
								</div>
								<div class="tab-pane fade <?php echo $st2; ?>" id="wish-tab">
									<div class="row" id="shopping_cart_detail">
										<div class="col-lg-12" style="margin-bottom:20px;">
											<h2 style="text-align:center;">Wishlist</h2>
										</div>
										
									<?php
									$q = "SELECT product.product_id,product.price,product.product_image1,product.description,product.STATUS,product.post_date,product.seller_id FROM wishlist,product
										WHERE wishlist.product_id = product.product_id
										AND wishlist.m_id = '$m_id'";
									$result = print_product($q);
									echo $result[0];
									?>
									</div>
                </div>
                <div class="tab-pane fade <?php echo $st3; ?>" id="order-tab">
									<h4 class="m-y-2">Order History</h4>
									<div class="row" id="shopping_cart_detail">
									<?php
									$q = "SELECT product.product_id,product.price,product.product_image1,product.description,product.STATUS,product.post_date,product.seller_id FROM product,order_products,orders WHERE product.product_id = order_products.product_id AND orders.order_id = order_products.order_id AND orders.buyer_id = '$m_id'";
									$result = print_product($q);
									echo $result[0];
									?>
									</div>
									<div class="table-responsive" id="order_record">
										 <table class="table table-bordered">
												<tr>
													 <th class="tableo"><a class="column_sort2" id="order_id" data-order="desc" href="#">Order ID</a></th>
													 <th class="tableo"><a class="column_sort2" id="order_date" data-order="desc" href="#">Order date</a></th>
													 <th class="tableo"><a class="column_sort2" id="count(order_products.product_id)" data-order="desc" href="#">No. of Product</a></th>
													 <th class="tableo"><a class="column_sort2" id="status" data-order="desc" href="#">Order Status</a></th>
													 <th class="tableo"><a class="column_sort2" id="shipping_status" data-order="desc" href="#">Shipping Status</a></th>
												</tr>
												<?php
												$sql4 = mysql_query("SELECT order_id, order_date, status, shipping_status FROM orders WHERE buyer_id = '$m_id' ");
												while($row4 = mysql_fetch_array($sql4,MYSQL_NUM)){
												$sql3 = mysql_query("SELECT count(product_id) FROM order_products WHERE order_id= '$row4[0]' ");
											 	$row3= mysql_fetch_array($sql3,MYSQL_NUM);
												?>
												<tr>
													 <td><?php echo $row4[0]; ?></td>
													 <td><?php echo $row4[1]; ?></td>
													 <td><?php echo $row3[0]; ?></td>
													 <td><?php echo $row4[2]; ?></td>
													 <td><?php echo $row4[3]; ?></td>
												</tr>
												<?php
												}
												?>
										 </table>
									</div>
							  </div>
								<div class="tab-pane fade <?php echo $st4; ?>" id="payment-tab">
									<h4 class="m-y-2">Payment History</h4>
									<div class="table-responsive" id="payment_record">
										 <table class="table table-bordered">
											  <tr>
												   <th class="tablep"><a class="column_sort" id="payment_id" data-order="desc" href="#">Payment ID</a></th>
												   <th class="tablep"><a class="column_sort" id="payment_type" data-order="desc" href="#">Payment Type</a></th>
												   <th class="tablep"><a class="column_sort" id="pay_date" data-order="desc" href="#">Paid Date</a></th>
												   <th class="tablep"><a class="column_sort" id="invoice_id" data-order="desc" href="#">Invoice ID</a></th>
												   <th class="tablep"><a class="column_sort" id="cc_num" data-order="desc" href="#">Credit Card Number</a></th>
												   <th class="tablep"><a class="column_sort" id="amount" data-order="desc" href="#">Amount</a></th>
											  </tr>
											  <?php
											  $sql2 = mysql_query("SELECT payment_type, pay_date ,invoice_id ,cc_num, amount, payment_id FROM payment_b WHERE buyer_id = '$m_id' ");
											  while($row2 = mysql_fetch_array($sql2,MYSQL_NUM))
											  {
											  ?>
											  <tr>
												   <td><?php echo $row2[5]; ?></td>
												   <td><?php echo $row2[0]; ?></td>
												   <td><?php echo $row2[1]; ?></td>
												   <td><?php echo $row2[2]; ?></td>
												   <td><?php $cc = $row2[3]; $smcc= substr("$cc", -4); echo "**",$smcc; ?></td>
												   <td><?php echo $row2[4]; ?></td>
											  </tr>
											  <?php
											  }
											  ?>
										 </table>
									</div>
								</div>
							</div>

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
				<form role="form" action="logout.php" method="POST">
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

	<div id="change_Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalContent2" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		   <div class="modal-content" id="ModalContent2">
				<div class="modal-header">
					 <h4 class="modal-title" >Change Password</h4>
				</div>
				<div class="modal-body">
					 <form method="post" action="update.php" id="changepassword_form">
						<div class="form-group row">
							<label class="col-lg-3 col-form-label form-control-label">Current Password</label>
							<div class="col-lg-9">
								<input class="form-control" type="password" name="current_password" id="current_password">
							</div>
							<div id="wrongpass2" class="col-lg-9 invalid-feedback" style="display:none;">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label form-control-label">New password</label>
							<div class="col-lg-9">
								<input class="form-control" type="password" name="new_password" id="new_password" disabled>
							</div>
							<div id="vPass2" class="col-lg-9 invalid-feedback" style="display:none;">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-lg-3 col-form-label form-control-label">Confirm password</label>
							<div class="col-lg-9">
								<input class="form-control" type="password" name="new_confirm" id="new_confirm" disabled>
							</div>
							<div id="vPass3" class="col-lg-9 invalid-feedback" style="display:none;">
							</div>
							<div id="invalidPassword2" class="col-lg-9 invalid-feedback" style="display:none;">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-9" style="margin-top:20px;">
								 <input type="submit" name="pass_submit" id="pass_submit" class="btn btn-primary" value="Save Changes" disabled>
							</div>
						</div>
					 </form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

	<div class="modal fade" id="cart_modal" tabindex="-1" role="dialog" aria-labelledby="ModalContent1" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="ModalContent1">Shopping Cart</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
				</div>
				<div class="modal-body">
				<div class="col-12" id="cart_content">

				</div>
				</div>
				<div class="modal-footer">
				<button id="cart_close" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
			</div>
	</div>

  <div class="modal fade" id="wish_modal" tabindex="-1" role="dialog" aria-labelledby="ModalContentwish" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="ModalContentwish">Wishlist</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
				</div>
				<div class="modal-body">
				<div class="col-12" id="wish_content">

				</div>
				</div>
				<div class="modal-footer">
				<button id="wish_close" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
			</div>
	</div>

  <script>

		jQuery.noConflict();
		$(document).ready(function(){
			var int = 0;
		 $.ajax({
			url:"cart.php",
			method:"POST",
			data:{number:int},
			success:function(data)
			{
				$('#view_cart').html(data);

			}
		 });

		 $.ajax({
			url:"wish.php",
			method:"POST",
			data:{number:int},
			success:function(data)
			{
				$('#view_wish').html(data);

			}
		 });

		 $(document).on('click', '#view_cart', function(){
			var load = "";
			$.ajax({
			url:"cart.php",
			method:"POST",
			data:{cart:load},
			success:function(data)
			{
				 $('#cart_content').html(data);
			}
				});
		 });

		 $(document).on('click', '#view_wish', function(){
			var load = "";
			$.ajax({
			url:"wish.php",
			method:"POST",
			data:{wish:load},
			success:function(data)
			{
				 $('#wish_content').html(data);
			}
				});
		 });

		 $(document).on('click', '.adding2', function(){
			var pid = $(this).attr('id');
			$.ajax({
				url:"cart.php",
				method:"POST",
				data:{add:pid},
				success:function(data)
				{
					var int = 0;
					$("#view_cart").html(function(){
						$.ajax({
						url:"cart.php",
						method:"POST",
						data:{number:int},
						success:function(data)
						{
							$('#view_cart').html(data);
						}
						});
					});
				}
			});
		});

		$(document).on('click', '.adding', function(){
			var pid = $(this).attr('id');
			if ($(this).hasClass("active")){

				$.ajax({
					url:"cart.php",
					method:"POST",
					data:{add:pid},
					success:function(data)
					{
						var int = 0;
						$("#view_cart").html(function(){
							$.ajax({
							url:"cart.php",
							method:"POST",
							data:{number:int},
							success:function(data)
							{
								$('#view_cart').html(data);
							}
							});
						});
						$(this).removeClass("active");
						$(this).attr('aria-pressed', 'false');
					}
				});
			}
			else{
				$.ajax({
					url:"cart.php",
					method:"POST",
					data:{delete:pid},
					success:function()
					{
						var int = 0;
						$("#view_cart").html(function(){
							$.ajax({
							url:"cart.php",
							method:"POST",
							data:{number:int},
							success:function(data)
							{
								$('#view_cart').html(data);
							}
							});
						});
						$(this).addClass("active");
						$(this).attr('aria-pressed', 'true');
					}
				});

			}
			location.reload(true);
		});


		$(document).on('click', '.hearting', function(){
			var pid = $(this).attr('id');
			if ($(this).hasClass("active")){

				$.ajax({
					url:"wish.php",
					method:"POST",
					data:{add:pid},
					success:function(data)
					{
						var int = 0;
						$("#view_wish").html(function(){
							$.ajax({
							url:"wish.php",
							method:"POST",
							data:{number:int},
							success:function(data)
							{
								$('#view_cart').html(data);
							}
							});
						});
						$(this).removeClass("active");
						$(this).attr('aria-pressed', 'false');
					}
				});
			}
			else{
				$.ajax({
					url:"wish.php",
					method:"POST",
					data:{delete:pid},
					success:function()
					{
						var int = 0;
						$("#view_wish").html(function(){
							$.ajax({
							url:"wish.php",
							method:"POST",
							data:{number:int},
							success:function(data)
							{
								$('#view_wish').html(data);
							}
							});
						});
						$(this).addClass("active");
						$(this).attr('aria-pressed', 'true');
					}
				});

			}
			location.reload(true);
		});

		$(document).on("click", "#cart_close", function(){
			location.reload(true);
		});

		$(document).on("click", "#wish_close", function(){
			location.reload(true);
		});

		$(document).on('click', '.delete', function(){
			var pid = $(this).attr('id');
			if(confirm("Are you sure you want to remove this product from cart?"))
				 {
					 $.ajax({
						url:"cart.php",
						method:"POST",
						data:{delete:pid},
						success:function()
						{
							var load = "";
							var int = 0;
							$("#cart_content").html(function(){
								$.ajax({
								url:"cart.php",
								method:"POST",
								data:{cart:load},
								success:function(data)
								{
									$('#cart_content').html(data);
								}
								});
							});
							$("#view_cart").html(function(){
								$.ajax({
								url:"cart.php",
								method:"POST",
								data:{number:int},
								success:function(data)
								{
									$('#view_cart').html(data);
								}
								});
							});
						}
					 });
				 }
		});

		$(document).on('click', '.delete2', function(){
			var pid = $(this).attr('id');
			if(confirm("Are you sure you want to remove this product from wishlist?"))
				 {
					 $.ajax({
						url:"wish.php",
						method:"POST",
						data:{delete:pid},
						success:function()
						{
							var load = "";
							var int = 0;
							$("#wish_content").html(function(){
								$.ajax({
								url:"wish.php",
								method:"POST",
								data:{wish:load},
								success:function(data)
								{
									$('#wish_content').html(data);
								}
								});
							});
							$("#view_cart").html(function(){
								$.ajax({
								url:"wish.php",
								method:"POST",
								data:{number:int},
								success:function(data)
								{
									$('#view_wish').html(data);
								}
								});
							});
						}
					 });
				 }
		});

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

	<script>


	$(document).ready(function(){
		$(document).on('click', '.column_sort', function(){
			var column_name = $(this).attr("id");
			var order = $(this).data("order");
			var arrow = "";
			if(order == 'desc')
			{
			 arrow = "<i class='fa fa-arrow-down' aria-hidden='true'></i>";
			}
			else
			{
			 arrow = "<i class='fa fa-arrow-up' aria-hidden='true'></i>";
			}
			var payment_record = "payment_record";
			$.ajax({
			 url:"sort.php",
			 method:"POST",
			 data:{payment_record:payment_record,column_name:column_name, order:order},
			 success:function(data)
			 {
					$('#payment_record').html(data);
					$('.tablep #'+column_name+'').html(column_name+arrow);

			 }
			});
	 });

	 $(document).on('click', '.column_sort2', function(){
			var column_name2 = $(this).attr("id");
			var order2 = $(this).data("order");
			var arrow = "";
			if(order == 'desc')
			{
			 arrow = "<i class='fa fa-arrow-down' aria-hidden='true'></i>";
			}
			else
			{

			 arrow = "<i class='fa fa-arrow-up' aria-hidden='true'></i>";
			}
			var order_record = "order_record";
			$.ajax({
			 url:"sort2.php",
			 method:"POST",
			 data:{order_record:order_record,column_name2:column_name, order2:order},
			 success:function(data)
			 {
					$('#order_record').html(data);
					$('.tableo #'+column_name2+'').html(column_name2+arrow);

			 }
			});
	 });
	});

	</script>
	</body>
</html>
