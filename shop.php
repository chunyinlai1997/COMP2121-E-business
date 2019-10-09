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

$sqlp = "SELECT DISTINCT product.product_id,product.price,product.product_image1,product.description,product.STATUS,product.post_date,product.seller_id
					FROM bag,accept_product,accessories,product,check_record,seller
					WHERE seller.m_id = product.seller_id AND accept_product.product_id = product.product_id
					AND check_record.product_id = product.product_id
					AND (product.STATUS ='in_stock' OR product.STATUS = 'arriving')
					AND (check_record.action !='invalid')
					AND product.product_id IN(
						SELECT DISTINCT product.product_id
						FROM bag,accept_product,accessories,product,check_record
						WHERE check_record.product_id = product.product_id
						AND (product.STATUS ='in_stock' OR product.STATUS = 'arriving')
						AND (check_record.action !='invalid')
					)
					ORDER BY product.STATUS DESC, seller.rating DESC, product.post_date DESC, check_record.status ASC";  //get all products

 $result = print_row_product($sqlp);
 $products_list = $result[0];
 $counter = $result[1];

?>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Just a frame made by Willon hahaha | Here is the discription">
		<meta name="keywords" content="HTML,CSS,PHP,Bootstrap,COMP,Project,polyu,comp,COMP,PolyU,Hong Kong,luxury,LUXTOT0TRADE">
		<meta name="author" content="Willon Lai">
		<title> Shopping | LuxToTrade COMP2121 Project</title>
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

		<script>

		jQuery(document).ready(function($) {
			$("#menu-toggle").click(function(e) {
				e.preventDefault();
				$("#wrapper").toggleClass("toggled");

			});

			 $('#menu-toggle').click(function(evt){
			   if(evt.target.id == "sidebar-wrapper" || evt.target.id == "menu-toggle" )
					return false;
					$("#wrapper").removeClass("toggled");
			 });
         });

		</script>

		<style>
					body {
						overflow-x: hidden;
					}
					::-webkit-scrollbar {
						display: none;
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

			.breadcrumb, .card-header, .card-title, .badge{
				font-family: 'Roboto Condensed', sans-serif;
			}
			ol a, ul a {
				color:grey;
			}
			#wrapper {
				padding-left: 0;
				-webkit-transition: all 0.5s ease;
				-moz-transition: all 0.5s ease;
				-o-transition: all 0.5s ease;
				transition: all 0.5s ease;
			}

			#wrapper.toggled {
				padding-left: 200px;
			}

			#sidebar-wrapper {
				z-index: 1000;
				position: fixed;
				left: 200px;
				width: 0;
				height: 100%;
				margin-left: -200px;
				overflow-y: auto;
				/*background: #000;*/
				-webkit-transition: all 0.5s ease;
				-moz-transition: all 0.5s ease;
				-o-transition: all 0.5s ease;
				transition: all 0.5s ease;
			}

			#wrapper.toggled #sidebar-wrapper {
				width: 200px;
			}

			#page-content-wrapper {
				width: 100%;
				position: absolute;
				padding: 15px;
			}

			#wrapper.toggled #page-content-wrapper {
				position: absolute;
				margin-right: -200px;
			}
			 /*sidebar styles*/
			.sidebar-nav {
				position: absolute;
				top: 0;
				width: 200px;
				margin: 0;
				padding: 0;
				list-style: none;
			}

			.sidebar-nav li {
				text-indent: 20px;
				line-height: 1;
			}

			.sidebar-nav li a {
				display: block;
				text-decoration: none;
				color: #999999;
			}

			.sidebar-nav li a:hover {
				text-decoration: none;
				color: #fff;
				background: rgba(255, 255, 255, 0.2);
			}

			.sidebar-nav li a:active,
			.sidebar-nav li a:focus {
				text-decoration: none;
			}

			.sidebar-nav > .sidebar-brand {
				height: 65px;
				font-size: 18px;
				line-height: 60px;
			}

			.sidebar-nav > .sidebar-brand a {
				color: #999999;
			}

			.sidebar-nav > .sidebar-brand a:hover {
				color: #fff;
				background: none;
			}

			@media(min-width:768px) {
				#wrapper {
					padding-left: 200px;
				}

				#wrapper.toggled {
					padding-left: 0;
				}

				#sidebar-wrapper {
					width: 200px;
				}

				#wrapper.toggled #sidebar-wrapper {
					width: 0;
				}

				#page-content-wrapper {
					padding: 20px;
					position: relative;
				}

				#wrapper.toggled #page-content-wrapper {
					position: relative;
					margin-right: 0;
				}
			}
			#sidebar-wrapper{
				font-size:14px;
			}#sidebar-wrapper .categories .card-body{
				line-height:1;
			}
			.fa-sm{
				font-size:10px;
			}
			 #page-content-wrapper .card{
				 height:100%;
			 }
			 .card {
						border: grey 1px solid;
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
	<div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="card mb-3 border-0 categories" style="margin-top: 75px;">
                <div class="card-header bg-transparent">Category</div>
                <div class="card-body px-0">
                    <nav class="nav flex-column">
												<p style="margin-left:5px;">Product type</p>
                        <div class="row" style="margin-bottom:10px;">
													<div class="col-11" style="margin-left:5px;">
														<select class="form-control" id="product_type" name="product_type">
															<option value="All" selected>All</option>
															<option value="Bag">Bag</option>
															<option value="Accessories">Accessories</option>
														</select>
													</div>
												</div>
												<p style="margin-left:5px;">Product status</p>
                        <div class="row" style="margin-bottom:10px;">
													<div class="col-11" style="margin-left:5px;">
														<select class="form-control" id="p_status" name="p_status">
															<option value="All" selected>All</option>
															<option value="stock">In Stock</option>
															<option value="arriving">Arriving</option>
														</select>
													</div>
												</div>
												<p style="margin-left:5px;">Authentication status</p>
                        <div class="row" style="margin-bottom:10px;">
													<div class="col-11" style="margin-left:5px;">
														<select class="form-control" id="a_status" name="a_status">
															<option value="All" selected>All</option>
															<option value="checked">Authenticated</option>
															<option value="progress">In progress</option>
															<option value="na">No Authentication</option>
														</select>
													</div>
												</div>
                    </nav>
                </div>
								<div class="card mb-3 border-0">
			                <div class="card-header bg-transparent">Keyword</div>
			                <div class="card-body">
			                    <form class="form-inline row">
														<input class="form-control col-12" type="text" id="keyword" placeholder="Search Here" aria-label="keyword"></input>
													</form>
			                </div>
	            	</div>
								<div class="card mb-3 border-0">
		                <div class="card-header bg-transparent">Brand  <a href="#" class="pull-right" class="btn btn-light active" id="clear-brand" role="button" aria-pressed="true">Clear</a></div>
		                <div class="card-body">
		                    <nav class="nav flex-column">
													<label class="custom-control custom-checkbox">
															<input name="AMQ" id="AMQ" type="checkbox" class="custom-control-input" checked="">
															<span class="custom-control-indicator"></span>
															<span class="custom-control-description">Alexander McQueen</span>
													</label>
													<label class="custom-control custom-checkbox">
															<input name="Celine" id="Celine" type="checkbox" class="custom-control-input" checked="">
															<span class="custom-control-indicator"></span>
															<span class="custom-control-description">Celine</span>
													</label>
													<label class="custom-control custom-checkbox">
															<input name="Chanel" id="Chanel" type="checkbox" class="custom-control-input" checked="">
															<span class="custom-control-indicator"></span>
															<span class="custom-control-description">Chanel</span>
													</label>
	                        <label class="custom-control custom-checkbox">
	                            <input name="Coach" id="Coach" type="checkbox" class="custom-control-input" checked="">
	                            <span class="custom-control-indicator"></span>
	                            <span class="custom-control-description">Coach</span>
	                        </label>
													<label class="custom-control custom-checkbox">
	                            <input name="Dior" id="Dior" type="checkbox" class="custom-control-input" checked="">
	                            <span class="custom-control-indicator"></span>
	                            <span class="custom-control-description">Dior</span>
	                        </label>
													<label class="custom-control custom-checkbox">
	                            <input name="Gucci" id="Gucci" type="checkbox" class="custom-control-input" checked="">
	                            <span class="custom-control-indicator"></span>
	                            <span class="custom-control-description">Gucci</span>
	                        </label>
													<label class="custom-control custom-checkbox">
	                            <input name="Hermes" id="Hermes" type="checkbox" class="custom-control-input" checked="">
	                            <span class="custom-control-indicator"></span>
	                            <span class="custom-control-description">Hermes</span>
	                        </label>
	                        <label class="custom-control custom-checkbox">
	                            <input name="LV" id="LV" type="checkbox" class="custom-control-input" checked="">
	                            <span class="custom-control-indicator"></span>
	                            <span class="custom-control-description">Louis Vuitton</span>
	                        </label>
													<label class="custom-control custom-checkbox">
															 <input name="Miu_Miu" id="Miu_Miu" type="checkbox" class="custom-control-input" checked="">
															 <span class="custom-control-indicator"></span>
															 <span class="custom-control-description">Miu Miu</span>
													 </label>
													 <label class="custom-control custom-checkbox">
															 <input name="MulBerry" id="MulBerry" type="checkbox" class="custom-control-input" checked="">
															 <span class="custom-control-indicator"></span>
															 <span class="custom-control-description">MulBerry</span>
													 </label>
		                        <label class="custom-control custom-checkbox">
		                            <input name="Prada" id="Prada" type="checkbox" class="custom-control-input" checked="">
		                            <span class="custom-control-indicator"></span>
		                            <span class="custom-control-description">Prada</span>
		                        </label>
														<label class="custom-control custom-checkbox">
																<input name="Swarovski" id="Swarovski" type="checkbox" class="custom-control-input" checked="">
																<span class="custom-control-indicator"></span>
																<span class="custom-control-description">Swarovski</span>
														</label>
														<label class="custom-control custom-checkbox">
		                            <input name="Tiffany" id="Tiffany" type="checkbox" class="custom-control-input" checked="">
		                            <span class="custom-control-indicator"></span>
		                            <span class="custom-control-description">Tiffany & Co.</span>
		                        </label>
		                    </nav>
		                </div>
		            </div>
								<div class="card mb-3 border-0">
		                <div class="card-header bg-transparent">Color</div>
		                <div class="card-body">
		                    <nav class="nav flex-column">
													<select class="form-control" id="get_color" name="get_color">
														<option value="" selected>All</option>
														<option value="Black">Black</option>
														<option value="White">White</option>
														<option value="Red">Red</option>
														<option value="Orange">Orange</option>
														<option value="Yellow">Yellow</option>
														<option value="Green">Green</option>
														<option value="Blue">Blue</option>
														<option value="Purple">Purple</option>
														<option value="Brown">Brown</option>
														<option value="Silver">Silver</option>
														<option value="Gold">Gold</option>
													</select>
		                    </nav>
		                </div>
		            </div>
								<div class="card mb-3 border-0">
		                <div class="card-header bg-transparent">Size</div>
		                <div class="card-body">
		                    <nav class="nav flex-column">
													<select class="form-control" id="get_size" name="get_size">
														<option value="" selected>All</option>
														<option value="L">L</option>
														<option value="M">M</option>
														<option value="S">S</option>
														<option value="XS">XS</option>
														<option value="Yellow">Others</option>
													</select>
		                    </nav>
		                </div>
		            </div>
								<div class="card mb-3 border-0">
									<div class="card-header bg-transparent">Price</div>
									<div class="card-body">
											<nav class="nav flex-column">
												<select class="form-control" id="get_pricerange" name="get_pricerange">
													<option value="pr0" selected>All</option>
													<option value="pr1">$0~$3000</option>
													<option value="pr2">$3001~$6000</option>
													<option value="pr3">$6000~$12000</option>
													<option value="pr4">$12000~$22000</option>
													<option value="pr5">$22000+</option>
												</select>
											</nav>
									</div>
								</div>

        </div>
		 </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" style="padding-top:100px;">
            <div class="container-fluid">
							<div class="row">
								<div class="col-6 col-md-9">
                <a href="#menu-toggle" class="btn btn-success btn-lg" id="menu-toggle">Filters</a>
								<a href="" class="btn btn-secondary btn-lg" id="clear-filter">Reset</a>
							  </div>
									<!--<div class="pull-right"><a class="btn btn-light" href="#"><i class="fa fa-th-large"></i></a></div>-->

								<div class="col-6 col-md-3">
									<select id="sort" class="form-control">
			               <option value= "0" selected>Sort Items</option>
			               <option value= "1">Name (A to Z)</option>
			               <option value= "2">Name (Z to A)</option>
			               <option value= "3">Price (Highest to Lowest)</option>
										 <option value= "4">Price (Lowest to Highest)</option>
										 <option value= "5">Date (Newest to Oldest)</option>
										 <option value= "6">Date (Oldest to Newest)</option>
										 <option value= "7">Seller Rating</option>
			             </select>
								</div>
							</div>
							<div class="row">
								<div class="col-8 col-md-10">
									<h6>showing <strong id="product_printnum"><?php echo $counter; ?></strong> products</h6>
							  </div>
								<div class="col-4 col-md-2">
									<select id="view" class="form-control">
										 <option value= "list" selected>List</option>
			               <option value= "card" >Card</option>
			             </select>
							  </div>
							</div>
								<hr>
								<br>
								<div class="row" id="print_list" style="margin-top:15px;">
								<!--<div class="card-deck">-->
								<?php
									echo $products_list;
								?>
								<!--</div>-->
								</div>
            </div>
        </div>
        <!-- /#page-content-wrapper
		<a href='home' class='btn btn-primary'>Go somewhere</a>-->
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
    </div>
    <!-- /#wrapper -->

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
	<input type="hidden" val="list" id="view_default"/>
	<script>
	jQuery.noConflict();
	/*
	$(window).on('load', function(){
		if ($(window).width() <= 1072){
		$( "#view_default" ).val('list');
		$('#view option:selected').val('list');
	}
	else{
		$( "#view_default" ).val('card');
		$('#view option:selected').val('card');
	}
	new_q();
	});
	$(document).ready(function(){
		$(window).resize(function(){
				if ($(window).width() <= 1072){
				$( "#view_default" ).val('list');
				$('#view option:selected').val('list');
			}
			else{
				$( "#view_default" ).val('card');
				$('#view option:selected').val('card');
			}
			new_q();
		});
	});
	*/
	$(document).ready(function(){
		var scolor = "NULL";
		var size= "NULL";
		var price_range = 0;
		var view = $('#view_default').val();
		var keyword = "";
		var sproduct_type=0;
		var a_status=0;
		var p_status=0;
		var b1 = 1;
		var b2 = 1;
		var b3 = 1;
		var b4 = 1;
		var b5 = 1;
		var b6 = 1;
		var b7 = 1;
		var b8 = 1;
		var b9 = 1;
		var b10 = 1;
		var b11 = 1;
		var b12 = 1;
		var b13 = 1;
		var sort = 0;
		var send="SELECT DISTINCT product.product_id,product.price,product.product_image1,product.description,product.STATUS,product.post_date,product.seller_id FROM bag,accept_product,accessories,product,check_record,seller WHERE seller.m_id = product.seller_id AND accept_product.product_id = product.product_id AND check_record.product_id = product.product_id AND (product.STATUS ='in_stock' OR product.STATUS = 'arriving') AND (check_record.action !='invalid' OR check_record.action !='need_change') AND product.product_id IN( SELECT DISTINCT product.product_id FROM bag,accept_product,accessories,product,check_record WHERE check_record.product_id = product.product_id AND (product.STATUS ='in_stock' OR product.STATUS = 'arriving') AND (check_record.action !='invalid' OR check_record.action !='need_change') ) ORDER BY product.STATUS DESC, seller.rating DESC, product.post_date DESC, check_record.status ASC";

		$(window).keydown(function(event){
	    if(event.keyCode == 13) {
	      event.preventDefault();
	      return false;
	    }
	  });

		$('#view').change(function(){
			view = $('#view option:selected').val();
			view_change();
		});

		$('#sort').change(function(){
			var ordering = $('#sort option:selected').val();
			if(ordering=="0"){
				sort=0;
			}
			else if(ordering=="1"){
				sort=1;
			}
			else if(ordering=="2"){
				sort=2;
			}
			else if(ordering=="3"){
				sort=3;
			}
			else if(ordering=="4"){
				sort=4;
			}
			else if(ordering=="5"){
				sort=5;
			}
			else if(ordering=="6"){
				sort=6;
			}
			else if(ordering=="7"){
				sort=7;
			}
			new_q();
		});

		$('#get_color').change(function(){
			var select_color = $('#get_color option:selected').val();
			if(select_color==""){
				scolor="NULL";
			}
			else{
				scolor = select_color;
			}
			new_q();
		});

		$('#get_size').change(function(){
			var select_size = $('#get_size option:selected').val();
			if(select_size==""){
				size="NULL";
			}
			else{
				size = select_size;
			}
			new_q();
		});

		$('#get_pricerange').change(function(){
			var select_pr = $('#get_pricerange option:selected').val();
			if(select_pr=='pr0'){
				price_range=0;
			}
			else if(select_pr=='pr1'){
				price_range=1;
			}
			else if(select_pr=='pr2'){
				price_range=2;
			}
			else if(select_pr=='pr3'){
				price_range=3;
			}
			else if(select_pr=='pr4'){
				price_range=4;
			}
			else if(select_pr=='pr5'){
				price_range=5;
			}
			new_q();
		});

		$('#keyword').keyup(function(){
       keyword = $(this).val();
			 new_q();
    });

		$('#product_type').change(function(){
			var type = $('#product_type option:selected').val();
			if(type=="Bag"){
				sproduct_type=1;
			}
			else if(type=="Accessories"){
				sproduct_type=2;
			}
			else if(type=="All"){
				sproduct_type=0;
			}
			new_q();
		});

		$('#a_status').change(function(){
			var a = $('#a_status option:selected').val();
			if(a=="All"){
				a_status = 0;
			}
			else if(a=="checked"){
				a_status = 1;
			}
			else if(a=="progress"){
				a_status = 2;
			}
			else if(a=="na"){
				a_status = 3;
			}
			new_q();
		});

		$('#p_status').change(function(){
			var p = $('#p_status option:selected').val();
			if(p=="All"){
				p_status = 0;
			}
			else if(p=="stock"){
				p_status = 1;
			}
			else if(p=="arriving"){
				p_status = 2;
			}
			new_q();
		});

		$('#AMQ').change(function(){
			if ($(this).is(':checked')){
	    	b1 = 1;
	    } else {
				b1 = 0;
	    }
			new_q();
		});
		$('#Chanel').change(function(){
			if ($(this).is(':checked')){
	    	b2 = 1;
	    } else {
				b2 = 0;
	    }
			new_q();
		});
		$('#Coach').change(function(){
			if ($(this).is(':checked')){
	    	b3 = 1;
	    } else {
				b3 = 0;
	    }
			new_q();
		});
		$('#Dior').change(function(){
			if ($(this).is(':checked')){
	    	b4 = 1;
	    } else {
				b4 = 0;
	    }
			new_q();
		});
		$('#Gucci').change(function(){
			if ($(this).is(':checked')){
	    	b5 = 1;
	    } else {
				b5 = 0;
	    }
			new_q();
		});
		$('#Hermes').change(function(){
			if ($(this).is(':checked')){
	    	b6 = 1;
	    } else {
				b6 = 0;
	    }
			new_q();
		});
		$('#LV').change(function(){
			if ($(this).is(':checked')){
	    	b7 = 1;
	    } else {
				b7 = 0;
	    }
			new_q();
		});
		$('#Miu_Miu').change(function(){
			if ($(this).is(':checked')){
	    	b8 = 1;
	    } else {
				b8 = 0;
	    }
			new_q();
		});
		$('#MulBerry').change(function(){

			if ($(this).is(':checked')){
	    	b9 = 1;
	    } else {
				b9 = 0;
	    }
			new_q();
		});
		$('#Prada').change(function(){
			if ($(this).is(':checked')){
	    	b10 = 1;
	    } else {
				b10 = 0;
	    }
			new_q();
		});
		$('#Swarovski').change(function(){
			if ($(this).is(':checked')){
	    	b11 = 1;
	    } else {
				b11 = 0;
	    }
			new_q();
		});
		$('#Tiffany').change(function(){
			if ($(this).is(':checked')){
	    	b12 = 1;
	    } else {
				b12 = 0;
	    }
			new_q();
		});
		$('#Celine').change(function(){
			if ($(this).is(':checked')){
	    	b13 = 1;
	    } else {
				b13 = 0;
	    }
			new_q();
		});

		$('#clear-brand').on('click',function(){
			b1 = 0;
			b2 = 0;
			b3 = 0;
			b4 = 0;
			b9 = 0;
			b5 = 0;
			b6 = 0;
			b7 = 0;
			b8 = 0;
			b10 = 0;
			b11 = 0;
			b12 = 0;
			b13 = 0;
			$('#AMQ').attr('checked', false);
			$('#Chanel').attr('checked', false);
			$('#Coach').attr('checked', false);
			$('#Dior').attr('checked', false);
			$('#Gucci').attr('checked', false);
			$('#Hermes').attr('checked', false);
			$('#LV').attr('checked', false);
			$('#Miu_Miu').attr('checked', false);
			$('#MulBerry').attr('checked', false);
			$('#Prada').attr('checked', false);
			$('#Swarovski').attr('checked', false);
			$('#Tiffany').attr('checked', false);
			$('#Celine').attr('checked', false);
			$('#clear-brand').css("display","none");
			new_q();
		});

		$('#clear-filter').on('click',function(){
			var sort=0;
			var sproduct_type=0;
			var keyword = "";
			var b1 = 1;
			var b2 = 1;
			var b3 = 1;
			var b4 = 1;
			var b5 = 1;
			var b6 = 1;
			var b7 = 1;
			var b8 = 1;
			var b9 = 1;
			var b10 = 1;
			var b11 = 1;
			var b12 = 1;
			var b13 = 1;
			var a_status=0;
			var p_status=0;
			var scolor = "NULL";
			var size= "NULL";
			var price_range = 0;
			var view = $('#view_default').val();
			var send="SELECT DISTINCT product.product_id,product.price,product.product_image1,product.description,product.STATUS,product.post_date,product.seller_id FROM bag,accept_product,accessories,product,check_record,seller WHERE seller.m_id = product.seller_id AND accept_product.product_id = product.product_id AND check_record.product_id = product.product_id AND (product.STATUS ='in_stock' OR product.STATUS = 'arriving') AND check_record.action !='invalid' AND product.product_id IN( SELECT DISTINCT product.product_id FROM bag,accept_product,accessories,product,check_record WHERE check_record.product_id = product.product_id AND (product.STATUS ='in_stock' OR product.STATUS = 'arriving') AND (check_record.action !='invalid' OR check_record.action !='need_change') ) ORDER BY product.STATUS DESC, seller.rating DESC, product.post_date DESC, check_record.status ASC";
			$('#AMQ').attr('checked', true);
			$('#Chanel').attr('checked', true);
			$('#Coach').attr('checked', true);
			$('#Dior').attr('checked', true);
			$('#Gucci').attr('checked', true);
			$('#Hermes').attr('checked', true);
			$('#LV').attr('checked', true);
			$('#Miu_Miu').attr('checked', true);
			$('#MulBerry').attr('checked', true);
			$('#Prada').attr('checked', true);
			$('#Swarovski').attr('checked', true);
			$('#Tiffany').attr('checked', true);
			$('#Celine').attr('checked', true);
			$('#product_type').val('All');
			$('#get_size').val('All');
			$('#get_color').val('All');
			$('#get_pricerange').val('All');
			$('#a_status').val('All');
			$('#p_status').val('All');
			$('#keyword').val("");
			$('#clear-brand').css("display","block");
			//$('#clear-brand').attr('aria-pressed', 'false');
			//$('#clear-color').attr('aria-pressed', 'false');
			new_q();
		});

		function new_q(){

				var query_front = "SELECT DISTINCT product.product_id,product.price,product.product_image1,product.description,product.STATUS,product.post_date,product.seller_id FROM bag,accept_product,accessories,product,check_record,seller";
				var query_brand_front = "SELECT DISTINCT product.product_id FROM bag,accept_product,accessories,product,check_record";
				var order = " ORDER BY product.STATUS DESC, seller.rating DESC, product.post_date DESC, check_record.status ASC ";
				var query_WHERE = " WHERE seller.m_id = product.seller_id AND accept_product.product_id = product.product_id AND check_record.product_id = product.product_id AND (product.STATUS ='in_stock' OR product.STATUS = 'arriving') AND (check_record.action !='invalid' OR check_record.action !='need_change') ";
				var query_brand = " WHERE check_record.product_id = product.product_id AND (product.STATUS ='in_stock' OR product.STATUS = 'arriving') AND check_record.action !='invalid' ";
				var query_type = "";
				var query_price = "";
				var query_color = "";
				var query_size = "";
				var query_key = "";
				var query_a_status = "";
				var query_p_status = "";
				//categories
				if(a_status==0){
					query_a_status = "";
				}
				else if(a_status==1){
					query_a_status = " AND check_record.status = 'checked' AND check_record.action !='invalid' ";
				}
				else if(a_status==2){
					query_a_status = " AND check_record.status = 'waiting' ";
				}
				else if(a_status==3){
					query_a_status = " AND check_record.status = 'NA' ";
				}

				if(p_status==0){
					query_p_status = "";
				}
				else if(p_status==1){
					query_p_status = " AND product.STATUS = 'in_stock' ";
				}
				else if(p_status==2){
					query_p_status = " AND product.STATUS = 'arriving' ";
				}

				if(sproduct_type==1){
					query_type = " AND accept_product.product_type='bag' ";
				}
				else if(sproduct_type==2){
					query_type = " AND accept_product.product_type='accessories' ";
				}
				//categories

				//brand
				if(b1==0){
					query_brand = query_brand.concat(" AND product.brand !='Alexander McQueen' ");
				}
				if(b2==0){
					query_brand = query_brand.concat(" AND product.brand !='Chanel' ");
				}
				if(b3==0){
					query_brand = query_brand.concat(" AND product.brand !='Coach' ");
				}
				if(b4==0){
					query_brand = query_brand.concat(" AND product.brand !='Dior' ");
				}
				if(b5==0){
					query_brand = query_brand.concat(" AND product.brand !='Gucci' ");
				}
				if(b6==0){
					query_brand = query_brand.concat(" AND product.brand !='Hermes' ");
				}
				if(b7==0){
					query_brand = query_brand.concat(" AND product.brand !='Louis Vuitton' ");
				}
				if(b8==0){
					query_brand = query_brand.concat(" AND product.brand !='Miu Miu' ");
				}
				if(b9==0){
					query_brand = query_brand.concat(" AND product.brand !='MulBerry' ");
				}
				if(b10==0){
					query_brand = query_brand.concat(" AND product.brand !='Prada' ");
				}
				if(b11==0){
					query_brand = query_brand.concat(" AND product.brand !='Swarovski' ");
				}
				if(b12==0){
					query_brand = query_brand.concat(" AND product.brand !='Tiffany & Co.' ");
				}
				if(b13==0){
					query_brand = query_brand.concat(" AND product.brand !='Celine' ");
				}
				query_brand = query_brand_front + query_brand;
				//brand
				//price
				if(price_range==0){
					query_price = "";
				}
				else if(price_range==1){
					query_price = " AND product.price<=3000 ";
				}
				else if(price_range==2){
					query_price = " AND (product.price>3000 AND product.price<=6000) ";
				}
				else if(price_range==3){
					query_price = " AND (product.price>6000 AND product.price<=12000) ";
				}
				else if(price_range==4){
					query_price = " AND (product.price>12000 AND product.price<=22000) ";
				}
				else if(price_range==5){
					query_price = " AND product.price > 22000 ";
				}
				//price
				//KEYWORDS
				if(keyword!=""){
					query_key = "  AND ( accept_product.model_name LIKE '%"+ keyword +"%' OR product.brand LIKE '%"+ keyword +"%' OR product.color LIKE '%"+ keyword +"%')  ";
				}
				//KEYWORDS
				//COLOR
				if(scolor=="NULL"){
					query_color = "";
				}
				else{
					query_color = " AND product.color='"+scolor+"' ";
				}
				//COLOR
				//SIZE
				if(size=="NULL"){
					query_size="";
				}
				else{
					query_size= " AND (accept_product.model_name IN (SELECT model_name FROM bag WHERE size='"+ size +"') OR accept_product.model_name IN (SELECT model_name FROM accessories WHERE size='"+ size +"') ) ";
				}
				//SIZE
				//ODRER
				if(sort > 0){
					var order_front = " ORDER BY ";
					var order_content = "";
					var order_basic = " ,product.STATUS DESC, seller.rating DESC, product.post_date DESC, check_record.status ASC ";
					if(sort==1){
						order_content = " accept_product.model_name ASC ";
					}
					else if(sort==2){
						order_content = " accept_product.model_name DESC ";
					}
					else if(sort==3){
						order_content = " product.price DESC ";
					}
					else if(sort==4){
						order_content = " product.price ASC ";
					}
					else if(sort==5){
						order_content = " product.post_date DESC ";
					}
					else if(sort==6){
						order_content = " product.post_date DESC ";
						order_basic = " ,product.STATUS DESC, seller.rating DESC, check_record.status ASC ";
					}
					else if(sort==7){
						order_content = " seller.rating DESC ";
						order_basic = " ,product.STATUS DESC, check_record.status ASC ";
					}
					order = order_front + order_content + order_basic;
				}
				else{
					order = " ORDER BY product.STATUS DESC, product.post_date DESC, check_record.status ASC ";
				}
				//ODRER
				//FINAL
				send = query_front + query_WHERE + query_type + query_price + query_key + query_color + query_size + query_p_status + query_a_status + " AND product.product_id IN( " + query_brand +" ) "+ order;
				//$('#print_list').html(send);
				//alert(send);
				//FINAL
				if(view=="card"){
					$.ajax({
						 url:'home_product.php',
						 method:"POST",
						 data:{sql:send},
						 dataType: "json",
						 success:function(data)
						 {
							 $('#product_printnum').fadeIn("slow").html(data[1]);
							 if(data[1]>0){
								 $('#print_list').html(data[0]);
							 }
							 else{
								 $('#print_list').html("<h6 style='color:red;'>No items found! Please try other options.</h6>");
							 }
						 }
					});
				}
				else{
					$.ajax({
						 url:'home_product2.php',
						 method:"POST",
						 data:{sql:send},
						 dataType: "json",
						 success:function(data)
						 {
							 $('#product_printnum').fadeIn("slow").html(data[1]);
							 if(data[1]>0){
								 $('#print_list').html(data[0]);
							 }
							 else{
								 $('#print_list').html("<h6 style='color:red;'>No items found! Please try other options.</h6>");
							 }
						 }
					});
				}

		}

		function view_change(){
			if(view=="list"){
				$.ajax({
					 url:"home_product2.php",
					 method:"POST",
					 data:{sql:send},
					 dataType: "json",
					 success:function(data)
					 {
						 $('#product_printnum').fadeIn("slow").html(data[1]);
						 $('#print_list').html(data[0]);
					 }
				});
			}
			else{
				$.ajax({
					 url:"home_product.php",
					 method:"POST",
					 data:{sql:send},
					 dataType: "json",
					 success:function(data)
					 {
						 $('#product_printnum').fadeIn("slow").html(data[1]);
						 $('#print_list').html(data[0]);
					 }
				});
			}
		}

	});

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
