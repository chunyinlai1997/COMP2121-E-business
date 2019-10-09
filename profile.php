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
if(isset($_POST['uploadprofile'])){

	$image = base64_encode(file_get_contents($_FILES['profileimg']['tmp_name']));

	$options = array('http'=>array(
		'method'=>"POST",
		'header'=>"Authorization: Bearer 9d80a5579bea50b9dbdaad0528ee66d08da6ecca\n"."Content-Type: application/x-ww-form-urlencoded",
		'content'=>$image
	));

	$context = stream_context_create($options);

	$imgurURL = "https://api.imgur.com/3/image";

	$response = file_get_contents($imgurURL, false, $context);

	$res = json_decode($response);

	$imagelink = $res->data->link;

	mysql_query("UPDATE member SET profileimg='$imagelink' WHERE m_id = '$m_id'");

}

$sql = mysql_query("SELECT profileimg,username,joindate,email,firstname,lastname,phone,address,country,invitation FROM member WHERE m_id = '$m_id' ");
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
		<title><?php echo $row[1]; ?> User Profile | LuxToTrade COMP2121 Project</title>
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
			margin-top: 85px;
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

	<div class="wrap">
			<div class="row">
				<div class="col-12">
					<?php
						if(isset($_GET["update"])){
							$m1 = "<div class='alert alert-success'><a class='close'data-dismiss='alert' href='#'>×</a>";
							$msg = "";
							$m2 = "</div>";
							if($_GET["update"]=="success"){
								$msg = "Your information is succesfully updated";
							}
							else if($_GET["update"]=="successpass"){
								$msg = "Your password is succesfully updated";
							}
							else if($_GET["update"]=="fail"){
								$m1 = "<div class='alert alert-danger'><a class='close'data-dismiss='alert' href='#'>×</a>";
								$msg = "Your password update request fails, please try again!";
							}
							echo $m1.$msg.$m2;
						}
					?>

					<nav class="nav nav-pills nav-justified">
						<li class="nav-item">
							<a href="#" data-target="#activity" data-toggle="tab" class="nav-link nav-item active">Dashboard</a>
						</li>
						<li class="nav-item">
							<a href="#" data-target="#info" data-toggle="tab" class="nav-link nav-item">My Info</a>
						</li>

					</nav>



					<div class="tab-content p-b-4">
						<div class="tab-pane fade show active" id="activity">
								<div class="row" style="margin-top:20px;">
				 				 <div class="col-12 col-sm-12 col-md-6">
				 					 <div class="card">
				 						  <div class="card-header">
				 						    My Purchase
				 						  </div>
				 						  <div class="card-body">
				 						    <h4 class="card-title">View Buyer Panel</h4>
				 						    <p class="card-text">Get your order record, payment record, wishlist etc.</p>
				 						    <a href="buypanel" class="btn btn-success">View My Purchase</a>
				 						  </div>
				 						</div>
				 				 </div>
				 				 <div class="col-12 col-sm-12 col-md-6">
				 					<div class="card">
				 						 <div class="card-header">
				 							 My Sells
				 						 </div>
				 						 <div class="card-body">

				 							 <?php
											 if(isseller()){
												 echo "
												 <h4 class='card-title'>View Seller Panel</h4>
												 <p class='card-text'>Get your selling record, sold items record, receive payment etc.</p>
					 							 <a href='sellpanel' class='btn btn-warning'>View My Sells</a>";
											 }
											 else{
												 echo "
												 <h4 class='card-title'>No Premission</h4>
												 <p class='card-text'>You haven't start the seller role yet!</p>
					 							 <a href='become_seller' class='btn btn-danger'>Become Seller Now!</a>";
											 }

											 ?>
				 						 </div>
				 					 </div>
				 				</div>
								<div class="col-12" style="margin-top: 15px;">
									<div class="card">
										 <div class="card-header">
											 My Coupons
										 </div>
										 <div class="card-body">
											 <div class="row">
												 <div class="col-12 col-sm-12 col-md-6" style="margin-top:5px;">
													 <h4 class="card-title">View your coupons, enjoy discounts.</h4>
													 <a href="" class="btn btn-info">View My Coupons</a>
												 </div>
												 <div class="col-12 col-sm-12 col-md-6" style="margin-top:5px;">
													 <h6 class="card-title">My Invitation Code</h6>
													 <h1 class="card-text" style="color:brown;"><?php echo $row[9]; ?></h1>
													 <a href="" class="btn btn-success btn-sm">Invite Friends</a>
												 </div>
											 </div>
										 </div>
									 </div>
								</div>
				 			</div>
			
						</div>

						<div class="tab-pane fade" id="info">
							<h4 class="m-y-2" style="margin-top:10px;">User Membership</h4>
							<div class="row">
							<div class="col-md-6">
							<h6 style="margin-top:10px;">Membership Type</h6>
							<?php
							$sql2 = mysql_query("SELECT mem_status,exp_date FROM membership WHERE m_id='$m_id'");
							$row2 = mysql_fetch_array($sql2,MYSQL_NUM);
							if($row2[0]=='STANDARD'){
							echo "<p>Standard</p> <a href='premium.php'><button type='button' class='btn btn-info btn-lg'>UPGRADE TO PREMIUM</button></a>";
							}
							else{
							$exp = $row2[1];
							echo "<p>Premium (expire on $exp)</p> <a href='premium.php'><button type='button' class='btn btn-info btn-lg'>Extend</button></a>";
							}
							?>

							<h6 style="margin-top:10px;">Join Date</h6>
							<p>
							<?php echo $row[2]; ?>
							</p>
							<h6 style="margin-top:10px;">Registered Email Address</h6>
							<p>
							<?php echo $row[3]; ?>
							</p>
							<h6 style="margin-top:10px;">Login Devices</h6>
							<p>
							<?php echo $active[0]; ?>
							</p>
							<h6 style="margin-top:10px;">My Invitation Code</h6>
							<p>
							<?php echo $row[9]; ?>
							<a href='#'><button type='button' class='btn btn-success'>Invite Friends</button></a>
							</p>
							</div>
							<div class="col-md-6">
							<h6 style="margin-top:10px;">First Name</h6>
							<p>
							<?php echo $row[4]; ?>
							</p>
							<h6 style="margin-top:10px;">Last Name</h6>
							<p>
							<?php echo $row[5]; ?>
							</p>
							<h6 style="margin-top:10px;">Phone</h6>
							<p>
							<?php echo $row[6]; ?>
							</p>
							<h6 style="margin-top:10px;">Country</h6>
							<p>
							<?php echo $row[8]; ?>
							</p>
							<h6 style="margin-top:10px;">Address</h6>
							<p>
							<?php echo $row[7]; ?>
							</p>
							<!--
							<h6>Recent Tags</h6>
							<a href="" class="tag tag-default tag-pill">html5</a>
							<hr>

							<span class="tag tag-primary"><i class="fa fa-user"></i> 900 Followers</span>
							<span class="tag tag-success"><i class="fa fa-cog"></i> 43 Forks</span>
							<span class="tag tag-danger"><i class="fa fa-eye"></i> 245 Views</span>
							-->
							</div>
							<hr>
							<div class="col-12 col-sm-12 col-md-6">
							<input type="button" name="edit" value="Edit Profile"  id="edit_profile" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-primary btn-lg edit_data" />
							<input type="button" name="change" value="Change Password"  id="change_password" data-toggle="modal" data-target="#change_Modal" class="btn btn-danger btn-lg change_password" />
							</div>
							<div class="col-12 col-sm-12 col-md-6">
							<h4 class="m-y-2" style="color:blue;"><?php echo $row[1]; ?></h4>
							<img src="<?php
							$sql = mysql_query("SELECT profileimg FROM member WHERE m_id = '$m_id' ");
							$row= mysql_fetch_array($sql,MYSQL_NUM);
							echo $row[0];
							?>" height="100" width="100" class="m-x-auto img-fluid img-circle" alt="No profile icon yet!">
							<div id="Accordion" data-children=".item">
							<div class="item">
							<a data-toggle="collapse" data-parent="#Accordion" href="#Accordioncontent" aria-expanded="true" aria-controls="exampleAccordion1">
							<small>Upload a new icon</small>
							</a>
							<div id="Accordioncontent" class="collapse" role="tabpanel">
							<label class="custom-file">
							<form action="profile.php" method="POST" enctype="multipart/form-data">
							<label for="file">Choose file to upload</label>
							<input id="profileimg" name="profileimg" type="file">
							</input>
							<input type="submit" class="btn btn-primary" id="uploadprofile" name="uploadprofile" value="Upload" disabled>
							</form>
							</label>
							</div>
							</div>
							</div>
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
	<script>
	   $('#current_password').keyup(function(){
		   var pass = $('#current_password').val();
		   $.ajax({
				url:"check.php",
				method:"POST",
				data:{pass:pass},
				dataType:"text",
				success:function(response){
					if(response=="correct"){
						    $('#current_password').removeClass( "is-invalid").addClass( "is-valid" );
							$('#wrongpass2').css("color","green");
							$('#wrongpass2').css("display", "block");
							$('#wrongpass2').html("Correct Password");
							$('#current_password').removeClass( "is-invalid").addClass( "is-valid" );
							$('#new_password').attr("disabled", false);
					}
					else{
							$('#wrongpass2').css("color","red");
							$('#wrongpass2').css("display","block");
							$('#wrongpass2').html("Wrong Password");
							$('#current_password').removeClass("is-valid").addClass( "is-invalid" );
							$('#new_password').attr("disabled", true);

					}
				}
			});
	   });

	   $('#new_password').keyup(function(){
		   var pass = $('#new_password').val();
		   if (pass.search(/[a-z]/) < 0) {
				$('#new_password').removeClass("is-valid").addClass( "is-invalid" );
			    $('#vPass2').css("display", "block");
				$('#vPass2').css("color", "red");
				$('#vPass2').html("Your password must contain a lower case letter");
			    $('#new_confirm').attr("disabled", true);
			}
		   else if(pass.search(/[A-Z]/) < 0) {
				$('#new_password').removeClass("is-valid").addClass( "is-invalid" );
			    $('#vPass2').css("display", "block");
				$('#vPass2').css("color", "red");
				$('#vPass2').html("Your password must contain an upper case letter");
				$('#new_confirm').attr("disabled", true);
			}
		   else  if (pass.search(/[0-9]/) < 0) {
				$('#new_password').removeClass("is-valid").addClass( "is-invalid" );
			    $('#vPass2').css("display", "block");
				$('#vPass2').css("color", "red");
				$('#vPass2').html("Your password must contain a number");
				$('#new_confirm').attr("disabled", true);
			}
			else  if (pass.length < 6) {
				$('#new_password').removeClass("is-valid").addClass( "is-invalid" );
			    $('#vPass2').css("display", "block");
				$('#vPass2').css("color", "red");
				$('#vPass2').html("Your password is too short");
				$('#new_confirm').attr("disabled", true);
			}
			else{
				$('#new_password').removeClass("is-invalid").addClass( "is-valid" );
			    $('#vPass2').css("display", "block");
				$('#vPass2').css("color", "green");
				$('#vPass2').html("Valid password");
				$('#new_confirm').attr("disabled", false);
			}
	   });

	   $('#new_confirm').keyup(function(){
		   var pass = $('#new_password').val();
	   	   var firm = $('#new_confirm').val();
		   if(pass==firm){
			   $('#new_confirm').removeClass("is-invalid").addClass( "is-valid" );
			    $('#vPass3').css("display", "block");
				$('#vPass3').css("color", "green");
				$('#vPass3').html("Password match!");
			   $('#pass_submit').attr("disabled", false);
		   }else{
			   $('#new_confirm').removeClass("is-valid").addClass( "is-invalid" );
			   $('#vPass3').css("display", "block");
				$('#vPass3').css("color", "red");
				$('#vPass3').html("Password not  match!");
			   $('#pass_submit').attr("disabled", true);
		   }
	   });
	</script>

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

	<div id="add_data_Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalContent3" aria-hidden="true">
		  <div class="modal-dialog">
			   <div class="modal-content" id="ModalContent3">
					<div class="modal-header">
						 <h4 class="modal-title" id="output">Update User Profile</h4>
					</div>
					<div class="modal-body">
					     <small>Please fill in your password after modifing the profile.</small>
						 <form method="post" action="update.php" id="edit_form">
									<div class="form-group row">
										<label class="col-lg-3 col-form-label form-control-label">First name</label>
										<div class="col-lg-9">
											<input class="form-control" name="firstname" id="firstname" type="text" onkeyup="validate_First(this);" onchange="validate_First(this);" value="">
										</div>
										<div id="vFirst" class=" col-lg-9 invalid-feedback" style="display:none;">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label form-control-label">Last name</label>
										<div class="col-lg-9">
											<input class="form-control" name="lastname" id="lastname" type="text" onkeyup="validate_Last(this);" onchange="validate_Last(this);" value="">
										</div>
										<div id="vLast" class=" col-lg-9 invalid-feedback" style="display:none;">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label form-control-label">Address</label>
										<div class="col-lg-9">
											<input class="form-control" name="address" id="address" type="text" value="" onkeyup="validate_add(this);" onchange="validate_add(this);" placeholder="This address is for delivery.">
										</div>
										<div id="vAddress" class="col-lg-9 invalid-feedback" style="display:none;">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label form-control-label">Phone Number</label>
										<div class="col-lg-9">
											<input class="form-control" name="phone" id="phone" value="" onchange="validatephone(this);" placeholder="phone number without country code">
										</div>
										<div id="vphone" class=" col-lg-9 invalid-feedback" style="display:none;">Invalid Phone Number
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label form-control-label">Country</label>
										<div class="col-lg-9">
											<select id="country" onchange="validate_country();" name="country" class="form-control" size="0">
												<option value="blank" selected>Choose...</option>
												<option value="Afganistan">Afghanistan</option>
												<option value="Albania">Albania</option>
												<option value="Algeria">Algeria</option>
												<option value="American Samoa">American Samoa</option>
												<option value="Andorra">Andorra</option>
												<option value="Angola">Angola</option>
												<option value="Anguilla">Anguilla</option>
												<option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
												<option value="Argentina">Argentina</option>
												<option value="Armenia">Armenia</option>
												<option value="Aruba">Aruba</option>
												<option value="Australia">Australia</option>
												<option value="Austria">Austria</option>
												<option value="Azerbaijan">Azerbaijan</option>
												<option value="Bahamas">Bahamas</option>
												<option value="Bahrain">Bahrain</option>
												<option value="Bangladesh">Bangladesh</option>
												<option value="Barbados">Barbados</option>
												<option value="Belarus">Belarus</option>
												<option value="Belgium">Belgium</option>
												<option value="Belize">Belize</option>
												<option value="Benin">Benin</option>
												<option value="Bermuda">Bermuda</option>
												<option value="Bhutan">Bhutan</option>
												<option value="Bolivia">Bolivia</option>
												<option value="Bonaire">Bonaire</option>
												<option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
												<option value="Botswana">Botswana</option>
												<option value="Brazil">Brazil</option>
												<option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
												<option value="Brunei">Brunei</option>
												<option value="Bulgaria">Bulgaria</option>
												<option value="Burkina Faso">Burkina Faso</option>
												<option value="Burundi">Burundi</option>
												<option value="Cambodia">Cambodia</option>
												<option value="Cameroon">Cameroon</option>
												<option value="Canada">Canada</option>
												<option value="Canary Islands">Canary Islands</option>
												<option value="Cape Verde">Cape Verde</option>
												<option value="Cayman Islands">Cayman Islands</option>
												<option value="Central African Republic">Central African Republic</option>
												<option value="Chad">Chad</option>
												<option value="Channel Islands">Channel Islands</option>
												<option value="Chile">Chile</option>
												<option value="China">China</option>
												<option value="Christmas Island">Christmas Island</option>
												<option value="Cocos Island">Cocos Island</option>
												<option value="Colombia">Colombia</option>
												<option value="Comoros">Comoros</option>
												<option value="Congo">Congo</option>
												<option value="Cook Islands">Cook Islands</option>
												<option value="Costa Rica">Costa Rica</option>
												<option value="Cote DIvoire">Cote D'Ivoire</option>
												<option value="Croatia">Croatia</option>
												<option value="Cuba">Cuba</option>
												<option value="Curaco">Curacao</option>
												<option value="Cyprus">Cyprus</option>
												<option value="Czech Republic">Czech Republic</option>
												<option value="Denmark">Denmark</option>
												<option value="Djibouti">Djibouti</option>
												<option value="Dominica">Dominica</option>
												<option value="Dominican Republic">Dominican Republic</option>
												<option value="East Timor">East Timor</option>
												<option value="Ecuador">Ecuador</option>
												<option value="Egypt">Egypt</option>
												<option value="El Salvador">El Salvador</option>
												<option value="Equatorial Guinea">Equatorial Guinea</option>
												<option value="Eritrea">Eritrea</option>
												<option value="Estonia">Estonia</option>
												<option value="Ethiopia">Ethiopia</option>
												<option value="Falkland Islands">Falkland Islands</option>
												<option value="Faroe Islands">Faroe Islands</option>
												<option value="Fiji">Fiji</option>
												<option value="Finland">Finland</option>
												<option value="France">France</option>
												<option value="French Guiana">French Guiana</option>
												<option value="French Polynesia">French Polynesia</option>
												<option value="French Southern Ter">French Southern Ter</option>
												<option value="Gabon">Gabon</option>
												<option value="Gambia">Gambia</option>
												<option value="Georgia">Georgia</option>
												<option value="Germany">Germany</option>
												<option value="Ghana">Ghana</option>
												<option value="Gibraltar">Gibraltar</option>
												<option value="Great Britain">Great Britain</option>
												<option value="Greece">Greece</option>
												<option value="Greenland">Greenland</option>
												<option value="Grenada">Grenada</option>
												<option value="Guadeloupe">Guadeloupe</option>
												<option value="Guam">Guam</option>
												<option value="Guatemala">Guatemala</option>
												<option value="Guinea">Guinea</option>
												<option value="Guyana">Guyana</option>
												<option value="Haiti">Haiti</option>
												<option value="Hawaii">Hawaii</option>
												<option value="Honduras">Honduras</option>
												<option value="Hong Kong">Hong Kong</option>
												<option value="Hungary">Hungary</option>
												<option value="Iceland">Iceland</option>
												<option value="India">India</option>
												<option value="Indonesia">Indonesia</option>
												<option value="Iran">Iran</option>
												<option value="Iraq">Iraq</option>
												<option value="Ireland">Ireland</option>
												<option value="Isle of Man">Isle of Man</option>
												<option value="Israel">Israel</option>
												<option value="Italy">Italy</option>
												<option value="Jamaica">Jamaica</option>
												<option value="Japan">Japan</option>
												<option value="Jordan">Jordan</option>
												<option value="Kazakhstan">Kazakhstan</option>
												<option value="Kenya">Kenya</option>
												<option value="Kiribati">Kiribati</option>
												<option value="Korea North">Korea North</option>
												<option value="Korea Sout">Korea South</option>
												<option value="Kuwait">Kuwait</option>
												<option value="Kyrgyzstan">Kyrgyzstan</option>
												<option value="Laos">Laos</option>
												<option value="Latvia">Latvia</option>
												<option value="Lebanon">Lebanon</option>
												<option value="Lesotho">Lesotho</option>
												<option value="Liberia">Liberia</option>
												<option value="Libya">Libya</option>
												<option value="Liechtenstein">Liechtenstein</option>
												<option value="Lithuania">Lithuania</option>
												<option value="Luxembourg">Luxembourg</option>
												<option value="Macau">Macau</option>
												<option value="Macedonia">Macedonia</option>
												<option value="Madagascar">Madagascar</option>
												<option value="Malaysia">Malaysia</option>
												<option value="Malawi">Malawi</option>
												<option value="Maldives">Maldives</option>
												<option value="Mali">Mali</option>
												<option value="Malta">Malta</option>
												<option value="Marshall Islands">Marshall Islands</option>
												<option value="Martinique">Martinique</option>
												<option value="Mauritania">Mauritania</option>
												<option value="Mauritius">Mauritius</option>
												<option value="Mayotte">Mayotte</option>
												<option value="Mexico">Mexico</option>
												<option value="Midway Islands">Midway Islands</option>
												<option value="Moldova">Moldova</option>
												<option value="Monaco">Monaco</option>
												<option value="Mongolia">Mongolia</option>
												<option value="Montserrat">Montserrat</option>
												<option value="Morocco">Morocco</option>
												<option value="Mozambique">Mozambique</option>
												<option value="Myanmar">Myanmar</option>
												<option value="Nambia">Nambia</option>
												<option value="Nauru">Nauru</option>
												<option value="Nepal">Nepal</option>
												<option value="Netherland Antilles">Netherland Antilles</option>
												<option value="Netherlands">Netherlands (Holland, Europe)</option>
												<option value="Nevis">Nevis</option>
												<option value="New Caledonia">New Caledonia</option>
												<option value="New Zealand">New Zealand</option>
												<option value="Nicaragua">Nicaragua</option>
												<option value="Niger">Niger</option>
												<option value="Nigeria">Nigeria</option>
												<option value="Niue">Niue</option>
												<option value="Norfolk Island">Norfolk Island</option>
												<option value="Norway">Norway</option>
												<option value="Oman">Oman</option>
												<option value="Pakistan">Pakistan</option>
												<option value="Palau Island">Palau Island</option>
												<option value="Palestine">Palestine</option>
												<option value="Panama">Panama</option>
												<option value="Papua New Guinea">Papua New Guinea</option>
												<option value="Paraguay">Paraguay</option>
												<option value="Peru">Peru</option>
												<option value="Phillipines">Philippines</option>
												<option value="Pitcairn Island">Pitcairn Island</option>
												<option value="Poland">Poland</option>
												<option value="Portugal">Portugal</option>
												<option value="Puerto Rico">Puerto Rico</option>
												<option value="Qatar">Qatar</option>
												<option value="Republic of Montenegro">Republic of Montenegro</option>
												<option value="Republic of Serbia">Republic of Serbia</option>
												<option value="Reunion">Reunion</option>
												<option value="Romania">Romania</option>
												<option value="Russia">Russia</option>
												<option value="Rwanda">Rwanda</option>
												<option value="St Barthelemy">St Barthelemy</option>
												<option value="St Eustatius">St Eustatius</option>
												<option value="St Helena">St Helena</option>
												<option value="St Kitts-Nevis">St Kitts-Nevis</option>
												<option value="St Lucia">St Lucia</option>
												<option value="St Maarten">St Maarten</option>
												<option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
												<option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
												<option value="Saipan">Saipan</option>
												<option value="Samoa">Samoa</option>
												<option value="Samoa American">Samoa American</option>
												<option value="San Marino">San Marino</option>
												<option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
												<option value="Saudi Arabia">Saudi Arabia</option>
												<option value="Senegal">Senegal</option>
												<option value="Serbia">Serbia</option>
												<option value="Seychelles">Seychelles</option>
												<option value="Sierra Leone">Sierra Leone</option>
												<option value="Singapore">Singapore</option>
												<option value="Slovakia">Slovakia</option>
												<option value="Slovenia">Slovenia</option>
												<option value="Solomon Islands">Solomon Islands</option>
												<option value="Somalia">Somalia</option>
												<option value="South Africa">South Africa</option>
												<option value="Spain">Spain</option>
												<option value="Sri Lanka">Sri Lanka</option>
												<option value="Sudan">Sudan</option>
												<option value="Suriname">Suriname</option>
												<option value="Swaziland">Swaziland</option>
												<option value="Sweden">Sweden</option>
												<option value="Switzerland">Switzerland</option>
												<option value="Syria">Syria</option>
												<option value="Tahiti">Tahiti</option>
												<option value="Taiwan">Taiwan</option>
												<option value="Tajikistan">Tajikistan</option>
												<option value="Tanzania">Tanzania</option>
												<option value="Thailand">Thailand</option>
												<option value="Togo">Togo</option>
												<option value="Tokelau">Tokelau</option>
												<option value="Tonga">Tonga</option>
												<option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
												<option value="Tunisia">Tunisia</option>
												<option value="Turkey">Turkey</option>
												<option value="Turkmenistan">Turkmenistan</option>
												<option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
												<option value="Tuvalu">Tuvalu</option>
												<option value="Uganda">Uganda</option>
												<option value="Ukraine">Ukraine</option>
												<option value="United Arab Erimates">United Arab Emirates</option>
												<option value="United Kingdom">United Kingdom</option>
												<option value="United States of America">United States of America</option>
												<option value="Uraguay">Uruguay</option>
												<option value="Uzbekistan">Uzbekistan</option>
												<option value="Vanuatu">Vanuatu</option>
												<option value="Vatican City State">Vatican City State</option>
												<option value="Venezuela">Venezuela</option>
												<option value="Vietnam">Vietnam</option>
												<option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
												<option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
												<option value="Wake Island">Wake Island</option>
												<option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
												<option value="Yemen">Yemen</option>
												<option value="Zaire">Zaire</option>
												<option value="Zambia">Zambia</option>
												<option value="Zimbabwe">Zimbabwe</option>
											</select>
										</div>
										<div id="vcountry" class="col-lg-9 invalid-feedback" style="display:none;">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label form-control-label">Password</label>
										<div class="col-lg-9">
											<input class="form-control" onkeyup="validatePass(this);" onchange="validatePass(this);" type="password" name="password" id="password">
										</div>
										<div id="invalidPassword" class="col-lg-9 invalid-feedback" style="display:none;">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label form-control-label">Confirm password</label>
										<div class="col-lg-9">
											<input class="form-control" type="password" name="confirm" id="confirm" onkeyup="checkPass();" onchange="checkPass();">
										</div>
										<div id="vPass" class="col-lg-9 invalid-feedback" style="display:none;">
										</div>
										<div id="wrongpass" class="col-lg-9 invalid-feedback" style="display:none;">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-lg-9" style="margin-top:20px;">
											 <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Save Changes" disabled>
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
		$("#profileimg").change(function () {
				var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
				if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
						alert("Only formats are allowed : "+ fileExtension.join(', '));
						document.getElementById("profileimg").classList.add('is-invalid');
						document.getElementById("profileimg").classList.remove('is-valid');
						$('#uploadprofile').attr("disabled",true);
				}
				else{
						document.getElementById("profileimg").classList.add('is-valid');
						document.getElementById("profileimg").classList.remove('is-invalid');
						$('#uploadprofile').attr("disabled",false);

				}
		});

	   $('#password').keyup(function(){
		   var pass = $('#password').val();
		   var firm = $('#confirm').val();
		   var c = $("#wrongpass").html();
		   if(pass.length < 4 ){
			    $('#vPass').css("color","red");
				$('#vPass').css("display", "block");
				$('#vPass').html("Invalid Password");
				$('#password').removeClass( "is-valid").addClass( "is-invalid" );
				$('#confirm').removeClass( "is-valid").addClass( "is-invalid" );
				checking();
		   }
		   else{
			    $('#vPass').css("color","green");
				$('#vPass').css("display", "block");
				$('#vPass').html("Valid Password");
				$('#password').removeClass( "is-invalid").addClass( "is-valid" );
				$('#confirm').removeClass( "is-invalid").addClass( "is-valid" );
				checking();
		   }
	   });


	   $('#confirm').keyup(function(){
		   	var pass = $('#password').val();
			var firm = $('#confirm').val();
			$.ajax({
				url:"check.php",
				method:"POST",
				data:{pass:firm},
				dataType:"text",
				success:function(response){
					if(pass==firm && firm.length>0){
						if(response=="correct"){
							$('#wrongpass').css("color","green");
							$('#wrongpass').css("display", "block");
							$('#wrongpass').html("Correct Password");
							$('#password').removeClass( "is-invalid").addClass( "is-valid" );
							$('#confirm').removeClass( "is-invalid").addClass( "is-valid" );
							if(checking()==true){
								$('#submit').attr("disabled", false);
							}
						}
						else{
							$('#wrongpass').css("color","red");
							$('#wrongpass').css("display", "block");
							$('#wrongpass').html("Wrong Password");
							$('#password').removeClass( "is-valid").addClass( "is-invalid" );
							$('#confirm').removeClass( "is-valid").addClass( "is-invalid" );
							$('#submit').attr("disabled", true);
						}
					}
					else{
						$('#wrongpass').css("color","red");
						$('#wrongpass').css("display", "block");
						$('#wrongpass').html("Invlaid Password");
						$('#password').removeClass( "is-valid").addClass( "is-invalid" );
						$('#confirm').removeClass( "is-valid").addClass( "is-invalid" );
						$('#submit').attr("disabled", true);
					}
				}
			});
	   });

	   $('#firstname').keyup(function(){
		    $('#confirm').val('');
		    var firstname = $('#firstname').val();
		    if(firstname.lnegth  < 2 ) {
				checking();//$('#submit').attr("disabled", true);
			}
		    else{
				checking();//$('#submit').attr("disabled", false);
			}

	   });

	   $('#lastname').keyup(function(){
		    $('#confirm').val('');
		    var lastname = $('#lastname').val();
		    if(lastname.lnegth  < 2 ) {
				checking();//$('#submit').attr("disabled", true);
			}
		    else{
				checking();//$('#submit').attr("disabled", false);
			}

	   });

	   $('#phone').keyup(function(){
		   $('#confirm').val('');
		    var phone = $('#phone').val();
		    if(phone.lnegth  < 3 ) {
				checking();//$('#submit').attr("disabled", true);
			}
		    else{
				checking();//$('#submit').attr("disabled", false);
			}

	   });

	   $('#address').keyup(function(){
		   $('#confirm').val('');
		    var address = $('#address').val();
		    if(address.lnegth  < 3 ) {
				checking();//$('#submit').attr("disabled", true);
			}
		    else{
				checking();//$('#submit').attr("disabled", false);
			}

	   });

	   $('#country').change(function(){
		    $('#confirm').val('');
		    var country = $('#country').val();
		    if(country == "blank" ) {
				checking();//$('#submit').attr("disabled", true);
			}
		    else{
				checking();
				//$('#submit').attr("disabled", false);
			}
	   });

	   function checking(){
		  var country = $('#country').val();
		  var address = $('#address').val().length;
		  var phone = $('#phone').val().length;
		  var firstname = $('#firstname').val().length;
		  var lastname = $('#lastname').val().length;
		  var c = $( "#wrongpass" ).html();
		  var pass = $('#password').val().length;
		  if(country!="blank" && address > 2 && phone > 2 && firstname > 1 && lastname > 1 && c=="Correct Password" && password > 3 )
		  {
			  $('#submit').attr("disabled", false);
			  return false;
		  }
		  else{
			  $('#submit').attr("disabled", true);
			  return true;
		  }

	   }


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
