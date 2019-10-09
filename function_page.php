<!DOCTYPE HTML>
<?php
include_once 'config.php';
include_once 'token.php';
include_once 'home_product.php';

if(!isloggedin()){
	header('Location:login.php?need_login=True');
}
$m_id = isloggedin();
if(!isactivated()){
	header('Location:activate.php');
}

$sql = mysql_query("SELECT profileimg,username FROM member WHERE m_id = '$m_id' ");
$row= mysql_fetch_array($sql,MYSQL_NUM);

function get_words(){
	if($_GET["m"]=="1"){
		return "Your Premium membership is expired. You are now in Standard membership. Click <a href='premium'>here</a> to upgrade to Premium.";
	}
	else if($_GET["m"]=="2"){
		$d = $_GET["r"];
		return "Your Premium membership is about to expire in $d-day. Click <a href='premium'>here</a> to extend Premium membership. ";
	}
}

function get_words2(){
	if($_GET["seller"]){
		return "You have successfully activate the seller role. You are able to sell items now.";
	}
}
function get_words3(){
	if($_GET["cant"]){
		return "You are still in standard membership. You cannot sell more than one item at a time. Click <a href='premium'>here</a> to upgrade to Premium. ";
	}
}
?>
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
	
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Just a frame made by Willon hahaha | Here is the discription">
		<meta name="keywords" content="HTML,CSS,PHP,Bootstrap,COMP,Project,polyu,comp,COMP,PolyU,Hong Kong,luxury,LUXTOT0TRADE">
		<meta name="author" content="Willon Lai">
		<title><?php $row[1]; ?> Home | LuxToTrade COMP2121 Project</title>
		<link rel="icon" href="images/brand_logo_small_icon.png" >
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<link rel="stylesheet" href="css/footer.css" />
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
		<script>
			 $(function(){
				$('#next1').click(function(){ $('#postsCarousel').carousel('next');return false; });
				$('#prev1').click(function(){ $('#postsCarousel').carousel('prev');return false; });
			});
			$(function(){
				$('#next2').click(function(){ $('#postsCarousel2').carousel('next');return false; });
				$('#prev2').click(function(){ $('#postsCarousel2').carousel('prev');return false; });
			});
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
			});
		</script>
		<style>
		body {
			width:100%;
		}
		.wrap {
			margin-top:75px;
			width: 100%;
		}
		.alert {
			margin-top:50px;
		}
		navbar {
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

		a:hover {
			color:brown;
		}
		.conatiner {
			height: auto;
		}

		.card-img-top-250 {
			max-height: 250px;
			overflow:hidden;
		}
		.modal-backdrop
		{
			opacity:1 !important;
		}

		.product-img{
			width:inherit;
			height:inherit;

		}

		.product img {
		    zoom: 70%;
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
	<!--Navbar-->
	<a href="shop_brand?brand=Louis%20Vuitton"><img style="height:10%; width:100%;" src="images/poster3v2.png"></a>
		<div class="wrap">
		<fieldset class="col-md-10 offset-md-1">
		<div class="form-top">
			<div class="form-top-left">
        <div class="col-md-12 ">
				<h1 id="ind">Win The Balenciaga Triple S Now !</h1>
			</div>
    </div>
		</div>
		
		
	<div class="form-bottom">
  <section class="content-1">
    <div class="container">
      <div class="row ">
        <div class="col-md-6  text-md-left pl-5">
          <h3 class="mt-4">Raffle ends at 31 Dec, 23:59 HKT</h3>
          <p>Instructions: </br> </br> 
          1. Register as our member, all types of members are allowed to join the raffle.</br></br> 
          2. Like our Facebook Page "LUXToTrade".</br></br> 
          3. Tag 3 friends, and comment your LUXToTrade account name and your UK shoe size on the Balenciaga Triple S raffle post.</br></br> 
          4. Follow our Instagram "LUXToTrade".</br></br> 
          5. Tag 3 friends, and comment your LUXToTrade account name and your UK shoe size on the Balenciaga Triple S raffle post.</br></br> 
          6. Two winners will be randomly selected. (One from Facebook, another from Instagram.)</br></br> 
          7. LUXToTrade reserves the right to suspend, modify, terminate or amend the terms of this pre-order registration without further notice.</p>
          
        </div>
        <div class="col-md-6 ">
          <img class=" img-fluid" src="images/Balenciaga_Triples.jpg" >
        </div>
      </div>
    </div>
  </section>
</section>


  </fieldset>
  </div>
  </div>




	</body>
</html>
