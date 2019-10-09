<!DOCTYPE HTML>
<?php
include_once 'config.php';
include_once 'token.php';
include_once 'home_product.php';
include_once 'home_product2.php';

if(!isloggedin()){
	header('Location:login.php?need_login=True');
}
if(!isactivated()){
	header('Location:activate.php');
}

$m_id = isloggedin();
$sql = mysql_query("SELECT profileimg,username,joindate,email,firstname,lastname,phone,address,country FROM member WHERE m_id = '$m_id' ");
$row = mysql_fetch_array($sql,MYSQL_NUM);

if(isset($_GET['m_id'])){
	$seller_id = $_GET['m_id'];
	$m_id = isloggedin();
	if($seller_id==$m_id){
		header("Location:profile");
	}
	else{
		$get = mysql_query("SELECT member.firstname,member.lastname,member.country,member.joindate,member.profileimg,seller.rating,membership.mem_status FROM member,seller,membership WHERE membership.m_id = member.m_id AND seller.m_id = member.m_id AND member.m_id = '$seller_id' ");
		$row_user = mysql_fetch_array($get,MYSQL_NUM);
		$full_name = $row_user[0]." ".$row_user[1];
		$country =  $row_user[2];
		$joindate =  $row_user[3];
		$profileimg = $row_user[4];
		$rating = $row_user[5];
		$membership = $row_user[6];
	}
}
else{
  header("Lcoation:shop");
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
		<title> <?php echo $full_name; ?> | User Profile | LuxToTrade COMP2121 Project</title>
		<link rel="icon" href="images/brand_logo_small_icon.png" >
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<link rel="stylesheet" href="css/animate.css" />
		<link rel="stylesheet" href="css/waypoints.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="js/scroll.js"></script>
		<script src="js/waypoints.js"></script>
		<script src="js/waypoints.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <style>
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
      .display-3 {
        font-size:80%:
      }
      #sellbutton{
        margin-left:0px;
        margin-top:5px;
        margin-top: 5px;
      }
      .nav-item{
        margin-bottom:1px;
        margin-top: 1px;
        margin-left: 1px;
        margin-right:1px;
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
  				<li class="nav-item">
  					<a class="nav-link" href="home">Discover</a>
  				</li>
  				<li class="nav-item">
  					<a class="nav-link" href="shop">Shop</a>
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
		<div class="jumbotron jumbotron-fluid" style="margin-top:60px; background-color:#EEE8AA;">
			<div class="container">
				<h1><?php echo $full_name; ?><h1>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 ">
						<img src="<?php echo $profileimg; ?>" width="250" height="250"/>
					</div>
					<div class='col-12 col-sm-12 col-md-6'>
						<h3>Join from: <?php echo $joindate; ?> </h3>
						<h3>Seller Rating: <?php include_once 'content.php'; $stars = get_stars($seller_id); echo $stars; ?> </h3>
						<h3>Country: <?php echo $country; ?> </h3>
						<h3>Membership: <?php echo $membership; ?> </h3>
						<button type="button" class="btn btn-primary btn-lg" data-toggle="button" aria-pressed="false" autocomplete="off">
						 <i class="fa fa-bookmark-o" aria-hidden="true"></i> Follow
						</button>
						<button type="button" class="btn btn-secondary  btn-lg" data-toggle="button" aria-pressed="false" autocomplete="off">
						<i class="fa fa-exclamation" aria-hidden="true"></i> Report
						</button>
					</div>

			</div>
			</div>
		</div>
		<hr>
		<section class="container" style="padding:1px;margin-bottom:200px;">
			<div class="row">
				<div class='col-12 col-sm-12 col-md-6' style="border: solid black 1px;margin-top:20px;">
					<h5 style="text-align:center;" >Comments From Buyers</h5>
					<?php
					$q = mysql_query("SELECT comments.COMMENT FROM comments,product WHERE product.product_id = comments.product_id AND product.seller_id = '$seller_id' Limit 10");
					$count_q = mysql_num_rows($q);
					while($result = mysql_fetch_array($q,MYSQL_NUM)){
						echo $result[0];
					}
					if($count_q==0){
						echo "<p>No comments from buyer yet.<p>";
					}
					?>
				</div>
				<div class='col-12 col-sm-12 col-md-6' style="margin-top:20px;">
					<h5 style="text-align:center;">Selling Items</h5>
					<?php
					$sqlp = "SELECT DISTINCT product.product_id,product.price,product.product_image1,product.description,product.STATUS,product.post_date,product.seller_id
										FROM bag,accept_product,accessories,product,check_record,seller
										WHERE seller.m_id = product.seller_id AND accept_product.product_id = product.product_id
										AND check_record.product_id = product.product_id
										AND (product.STATUS ='in_stock' OR product.STATUS = 'arriving')
										AND check_record.action !='invalid'
										AND product.seller_id = '$seller_id'
										ORDER BY product.post_date DESC ";  //get all products

					 $result = print_row_product_2($sqlp);
					 $products_list = $result[0];
					 $counter = $result[1];
					 echo $products_list;
					?>
				</div>

			</div>
		</section>


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
				<a role="button" href="buypanel?cart" class="btn btn-primary">Detail</a>
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
  			<a role="button" href="buypanel?wishlist" class="btn btn-primary">Detail</a>
  			<button id="wish_close" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
  									$('#view_wish').html(data);
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
  </body>
  </html>
