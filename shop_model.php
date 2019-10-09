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

if(isset($_GET['model_name'])){
  $model_name = $_GET['model_name'];
	$sql_model = mysql_query("SELECT * FROM bag WHERE model_name='$model_name' ");
  $row_model = mysql_num_rows($sql_model);

	$type = "";
  if($row_model!=0){
      $type = "bag";
  }
  else{
  		$type ="accessories";
  }
	$sql_detail = mysql_query("SELECT brand,recommended_price,release_year,size,measurement FROM $type WHERE model_name='$model_name'");
	$row_detail = mysql_fetch_array($sql_detail,MYSQL_NUM);

	$brand = $row_detail[0];
	$recommended_price = $row_detail[1];
	$release_year = $row_detail[2];
	$size = $row_detail[3];
	$measurement = $row_detail[4];
	$color = array();
	$product_image = array();
	$item_type="";
	if($type=='bag'){
		$sql_color = mysql_query("SELECT bag_color.bag_color, bag_color.product_image FROM bag_color,bag WHERE bag_color.bag_id= bag.bag_id AND bag.model_name = '$model_name' ");
		while($row_color = mysql_fetch_array($sql_color,MYSQL_NUM)){
			array_push($color,$row_color[0]);
			array_push($product_image,$row_color[1]);
		}
	}
	else{
		$sql_color = mysql_query("SELECT color, product_image , item_type FROM $type WHERE model_name = '$model_name' ");
		while($row_color = mysql_fetch_array($sql_color,MYSQL_NUM)){
			array_push($color,$row_color[0]);
			array_push($product_image,$row_color[1]);
			$item_type = $row_color[2];
		}
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
		<title> <?php echo $model_name; ?> | Shop By Model | LuxToTrade COMP2121 Project</title>
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
    <div id="contain" class="container-fluid" style="margin-top:80px; padding-left:10px;padding-right:10px; background-color:white;">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h6 style="font-size:300%; font-weight:700;"><?php echo $model_name; ?></h6>
          <h1><a href="shop_brand?brand=<?php echo $brand; ?>"><?php echo $brand; ?></a></h1>
					  </div>
      </div>

		<section class="container-fluid" style="margin-top:50px; padding:10px; margin-bottom:200px;">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-6 col-lg-4">
					<p>Release Year: <?php echo $release_year; ?></p>
					<p>recommended Price: $<?php 	echo $recommended_price; ?> HKD</p>
					<?php
					if($type=="accessories"){
						echo "<p>Accessories Type: $item_type </p>";
					}
					?>
				</div>
				<div class='col-12 col-sm-12 col-md-6 col-lg-4'>
					<p>Size: <?php echo $size; ?></p>
					<p>Measurement: <?php echo $measurement; ?></p>
					<p>Available Color:<?php
						foreach ($color as &$value) {
								//echo "<div class='col-12 col-sm-12 col-md-6 col-lg-4'><img src='$value' width='200' height='200'/></div>";
								echo " ".$value." ";
						}
						?>
					</p>
				</div>
				<div class='col-12 col-sm-12 col-md-6 col-lg-4'>
				<div id='carouselExampleControlsCOLOR' class='carousel slide' data-ride='carousel' style='width:250px;height:250px;'>
						<div class='carousel-inner'>
						<?php
						$c = 0;
						foreach ($product_image as &$value) {
								if($c==0){
									echo "<div class='carousel-item active'><img src='$value' width='250' height='250'></div>";
									$c += 1;
								}
								else{
									echo "<div class='carousel-item'><img src='$value' width='250' height='250'></div>";
								}
						}
						?>
						</div>
						<a class='carousel-control-prev' href='#carouselExampleControlsCOLOR' role='button' data-slide='prev'>
						 <span class='carousel-control-prev-icon' aria-hidden='true'></span>
						 <span class='sr-only'>Previous</span>
						</a>
						<a class='carousel-control-next' href='#carouselExampleControlsCOLOR' role='button' data-slide='next'>
						 <span class='carousel-control-next-icon' aria-hidden='true'></span>
						 <span class='sr-only'>Next</span>
						</a>
					</div>
				</div>
			</div>
			<hr>
			<div class="row" style="margin-top:50px;">
				<div class="col-lg-12" style="margin-bottom:20px;">
					<h1 style="text-align:center;" id="features">On Sale Items</h1>
				</div>

				<?php

				$q = "SELECT DISTINCT product.product_id,product.price,product.product_image1,product.description,product.STATUS,product.post_date,product.seller_id
				  FROM product,check_record,membership, accept_product
					WHERE check_record.product_id = product.product_id
					AND membership.m_id = product.seller_id
					AND (product.STATUS ='in_stock' OR product.STATUS = 'arriving')
					AND (check_record.action !='invalid' OR check_record.action !='need_change')
     			AND accept_product.product_id = product.product_id
		 			AND accept_product.model_name ='$model_name'
					ORDER BY  membership.mem_status ASC, product.post_date DESC, check_record.status ASC Limit 18";
				$result = print_product($q);
				echo $result[0];

			  if($result[1]==0){
					echo "<h1 style='text-align:center;color:red;font-weight:500;'>Sorry, we do not have any selling items for this model.</h1>";
				}

				?>
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
