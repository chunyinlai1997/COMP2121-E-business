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

	<div class="wrap row">
	<div class="col-12 col-sm-12 col-md-8">
			<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" >
					<ol class="carousel-indicators">
					<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
					</ol>
					<div class="carousel-inner">
					<div class="carousel-item active">
						<a href="shop_brand?brand=Louis%20Vuitton"><img class="d-block h-50 w-100" src="images/poster1.png" alt="First slide"></a>
						<div class="carousel-caption" style="color: black;">
						</div>
					</div>
					<div class="carousel-item">
						<a href="shop_brand?brand=Celine"><img class="d-block  h-50 w-100" src="images/poster4.png" alt="Second slide"></a>
						<div class="carousel-caption" style="color: black;">

						</div>
					</div>
					<div class="carousel-item">
						<a href="function_page"><img class="d-block h-50 w-100" src="images/poster3.png" alt="Third slide" ></a>
						<div class="carousel-caption" style="color: black;">

						</div>

					</div>
					<div class="carousel-item">
						<a href="profile"><img class="d-block h-50  w-100" src="images/poster2.png" alt="Fourth slide"></a>
						<div class="carousel-caption" style="color: black;">
						</div>

					</div>
					</div>
					<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
			</div>
	</div>
	<div class="col-12 col-sm-12 col-md-4" style="margin-top:20px; padding:15px;">
		<div class="row">
			<div class="col-lg-12" style="margin-bottom:20px;">
				<h1 style="text-align:center;">Collection</h1>
			</div>
			<div class="col-12 col-sm-6">
					<div class="card " style="">
					  <a href="shop_brand?brand=GUCCI" class=""><img class="card-img-top" src="images/collection_gucci.jpg" alt="Card image cap">
					  <div class="card-body">
					    <h5 class="card-title" style="text-align: center; color:black; margin:0px;">GUCCI</h5></a>
					  </div>
					</div>
			</div>
			<div class="col-12 col-sm-6">
					<div class="card " style="">
					  <a href="shop_brand?brand=CHANEL" class=""><img class="card-img-top" src="images/collection_chanel.jpg" alt="Card image cap">
					  <div class="card-body">
					    <h5 class="card-title" style="text-align: center; color:black; margin:0px;">CHANEL</h5></a>
					  </div>
					</div>
			</div>
			<div class="col-12 col-sm-6">
					<div class="card " style="">
					  <a href="shop_brand?brand=Prada" class=""><img class="card-img-top" src="images/collection_prada.jpg" alt="Card image cap">
					  <div class="card-body">
					    <h5 class="card-title" style="text-align: center; color:black; margin:0px;">PRADA</h5></a>
					  </div>
					</div>
			</div>
			<div class="col-12 col-sm-6">
					<div class="card " style="">
					  <a href="shop_brand?brand=Tiffany%20" class=""><img class="card-img-top" src="images/collection_tiffany.jpg" alt="Card image cap">
					  <div class="card-body">
					    <h5 class="card-title" style="text-align: center; color:black; margin:0px;">TIFFANY & CO.</h5></a>
					  </div>
					</div>
			</div>
		</div>
	</div>

	<div class="maincontent col-12">

	<div class=".offset-md-2">
		<?php
			$error1 = "<div class='alert alert-danger'><a class='close'data-dismiss='alert' href='#'>×</a>";
			$error2 = "</div>";
			if(isset($_GET["m"])){
				$msg = get_words();
				echo $error1.$msg.$error2;
			}
			if(isset($_GET["seller"])){
				$error1 = "<div class='alert alert-info'><a class='close'data-dismiss='alert' href='#'>×</a>";
				$msg = get_words2();
				echo $error1.$msg.$error2;
			}
			if(isset($_GET["cant"])){
				$error1 = "<div class='alert alert-warning'><a class='close'data-dismiss='alert' href='#'>×</a>";
				$msg = get_words3();
				echo $error1.$msg.$error2;
			}
		?>
	</div>

	<section class="container-fluid" style="margin-top:50px;">
		<div class="row">
			<div class="col-12 col-sm12 col-md-6">
				<img src="images/promo1.jpeg" class="img-fluid" alt="Responsive image">
			</div>
			<div class="col-12 col-sm12 col-md-6">
				<img src="images/promo2.jpeg" class="img-fluid" alt="Responsive image">
			</div>
		</div>
	</section>

		<section class="container-fluid" style="margin-top:50px;">
			<div class="row">
				<div class="col-lg-12" style="margin-bottom:20px;">
					<h1 style="text-align:center;" id="features">Feature Items</h1>
				</div>

				<?php

				$q = "SELECT DISTINCT product.product_id,product.price,product.product_image1,product.description,product.STATUS,product.post_date,product.seller_id FROM product,check_record,membership
					WHERE check_record.product_id = product.product_id
					AND membership.m_id = product.seller_id
					AND product.STATUS ='in_stock'
					AND check_record.action ='valid'
					AND check_record.status ='checked'
					ORDER BY  membership.mem_status ASC, product.post_date DESC, check_record.status, RAND() ASC Limit 12";
				$result = print_product($q);
				echo $result[0];

				?>
			</div>
		</section>


		<section class="container-fluid" style="margin-top:50px;">
			<div class="row">
				<div class="col-lg-12" style="margin-bottom:20px;">
					<h1 style="text-align:center;" id="whats_new">What's New</h1>
				</div>

				<?php

				$q = "SELECT DISTINCT product.product_id,product.price,product.product_image1,product.description,product.STATUS,product.post_date,product.seller_id FROM product,seller,check_record,membership
					WHERE check_record.product_id = product.product_id
					AND membership.m_id = product.seller_id
					AND seller.m_id = product.seller_id
					AND (product.STATUS ='in_stock' OR product.STATUS ='arriving')
					ORDER BY  seller.rating DESC, membership.mem_status ASC, product.post_date ASC, check_record.status ASC, RAND() Limit 12";
				$result = print_product($q);
				echo $result[0];

				?>
			</div>
		</section>

		<section class="container-fluid" style="margin-top:50px;">
			<div class="row">
				<div class="col-lg-12" style="margin-bottom:20px;">
					<h1 style="text-align:center;" id="top_sellers	">Top Sellers</h1>
				</div>


				<?php
					$top_seller="SELECT distinct COUNT(seller.m_id), member.username, seller.rating, member.profileimg
					FROM seller,product,member WHERE seller.m_id = member.m_id AND product.seller_id = seller.m_id AND product.seller_id AND product.STATUS = 'sold' GROUP BY seller_id
					ORDER BY seller.rating ";
					$top_seller_query=mysql_query($top_seller);
					while($top_seller_array=mysql_fetch_array($top_seller_query)){?>
					<div class="col-12 col-sm-6 col-md-4 col-lg-2">
						<div class="card " style="">
						  <a href=""><img class="card-img-top" src="<?php echo  $top_seller_array[3]; ?>" alt="Card image cap"></a>
						  <div class="card-body">
						    <h4 class="card-title"></h4>
								<p class="card-text">Seller Name: <a href=""><?php echo $top_seller_array[1]; ?></a></p>
							 <p class="card-text">Items Sold: <?php echo $top_seller_array[0]; ?></p>
						  </div>
						</div>
					</div>

					<?php }




				?>

			</div>
		</section>

		<section class="container-fluid" style="margin-top:50px;">
			<div class="row">
				<div class="col-lg-12" style="margin-bottom:20px;">
					<h1 style="text-align:center;" id="popular">Most People Want...</h1>
				</div>

				<?php
					$q= "SELECT DISTINCT product.product_id,product.price,product.product_image1,product.description,product.STATUS,product.post_date,product.seller_id FROM product,check_record,membership,(SELECT  product_id,count(product_id) FROM wishlist
					GROUP BY product_id ORDER BY count(product_id) DESC LIMIT 6) as res,accept_product
					WHERE check_record.product_id = product.product_id
					AND res.product_id=product.product_id and res.product_id=accept_product.product_id
					AND (product.STATUS = 'in_stock' OR product.STATUS = 'arriving')
					AND membership.m_id = product.seller_id
					ORDER BY RAND() LIMIT 12";
					$result = print_product($q);
					echo $result[0];

				?>
			</div>
		</section>

		<section class="container-fluid" style="margin-top:50px;">
			<div class="row">
				<div class="col-lg-12" style="margin-bottom:20px;">
					<h1 style="text-align:center;" id="guess_what_you_like">Guess what you like</h1>
				</div>

				<?php
					$q= "SELECT DISTINCT product.product_id,product.price,product.product_image1,product.description,product.STATUS,product.post_date,product.seller_id FROM product,check_record,membership
					WHERE check_record.product_id = product.product_id
					AND (product.STATUS = 'in_stock' OR product.STATUS = 'arriving')
					AND membership.m_id = product.seller_id
					ORDER BY RAND() LIMIT 12";
					$result = print_product($q);
					echo $result[0];

				?>
			</div>
		</section>

	  <!--
		<div class="container">

	  <h1 class="my-4">Page Heading
		<small>Secondary Text</small>
	  </h1>
	<div class="row">
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Project One</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur eum quasi sapiente nesciunt? Voluptatibus sit, repellat sequi itaque deserunt, dolores in, nesciunt, illum tempora ex quae? Nihil, dolorem!</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Project Two</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Project Three</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos quisquam, error quod sed cumque, odio distinctio velit nostrum temporibus necessitatibus et facere atque iure perspiciatis mollitia recusandae vero vel quam!</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Project Four</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Project Five</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Project Six</a>
              </h4>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque earum nostrum suscipit ducimus nihil provident, perferendis rem illo, voluptate atque, sit eius in voluptates, nemo repellat fugiat excepturi! Nemo, esse.</p>
            </div>
          </div>
        </div>
      </div>
			-->
      <!-- /.row -->

      <!-- Pagination -->
			  <!--
      <ul class="pagination justify-content-center">
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">1</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">2</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">3</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </a>
        </li>
      </ul>
			  </div>
-->

<!--
	<nav class="nav nav-pills nav-justified" style="margin-button:30px;margin-top:30px;">
	  <a class="nav-item nav-link active" href="#">BAGS</a>
	  <a class="nav-item nav-link" href="#">ACCESORIES</a>
	</nav>
-->
		</div>
	</div>
</div>

		<footer class="footer-4">
			<div class="container">
				<div class="row mb-5 text-center text-md-left">
					<div class="col-md-3 col-lg-4 mb-3">
						<a class="navbar-brand" href="home"><img src="images/brand_logo_white.png" width="150" height="70"></a>
					</div>
					<div class="col-md-3 offset-lg-2 col-lg-2 pt-2">
						<h5>BUYER</h5>
						<ul class="nav-footer">
							<li class="nav-item">
								<a class="nav-link" href="shop">SHOP</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="home#features">FEATURES</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="home#whats_new">NEW ARRIVALS</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="home#popular">POPULAR</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="buypanel">PURCHASE HISTORY</a>
							</li>
						</ul>
					</div>
					<div class="col-md-3 col-lg-2 pt-2">
						<h5>SELLER</h5>
						<ul class="nav-footer">

								<?php
								if(isseller()){
									echo "<li class='nav-item'><a class='nav-link' href='guideline'>SELL NOW</a></li>
												<li class='nav-item'><a class='nav-link' href='sellpanel'>SALES RECORD</a></li>
									";
								}
								else{
									echo "<li class='nav-item'><a class='nav-link' href='become_seller'>BECOME SELLER</a>";
								}
								?>
						</ul>
					</div>
					<div class="col-md-3 col-lg-2 pt-2">
						<h5>MEMBER</h5>
						<ul class="nav-footer">
							<li class="nav-item">
								<a class="nav-link" href="profile">PROFILE</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="container-fluid">
				<div class="divider"></div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-6 text-center text-md-left mt-2 mb-3 pt-1">
						<p class="copyright">Copyright &copy; LuxToTrade, a company of Tangible. All rights reserved.</p>
					</div>
					<div class="col-md-6 text-center text-md-right mb-4">
						<ul class="social">
							<li><a href="#" title="Facebook" class="fa fa-facebook"></a></li>
							<li><a href="#" title="Twitter" class="fa fa-twitter"></a></li>
							<li><a href="#" title="Google+" class="fa fa-google"></a></li>
							<li><a href="#" title="Dribbble" class="fa fa-dribbble"></a></li>
							<li><a href="#" title="Instagram" class="fa fa-instagram"></a></li>
							<div class="clear"></div>
						</ul>
					</div>
				</div>
			</div>
		</footer>

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
	</body>
</html>
