<!DOCTYPE HTML>
<?php
include_once 'config.php';
include_once 'token.php';
if(!isloggedin()){
	header('Location:login.php?need_login=True');
}
if(!isactivated()){
	header('Location:activate.php');
}
$m_id = isloggedin();
$sql = mysql_query("SELECT profileimg,username,joindate FROM member WHERE m_id = '$m_id' ");
$row = mysql_fetch_array($sql,MYSQL_NUM);
$sql2 = mysql_query("SELECT mem_status,exp_date FROM membership WHERE m_id='$m_id'");
$row2 = mysql_fetch_array($sql2,MYSQL_NUM);

$text = "";
$mode = 0;

if($row2[0]=='STANDARD'){
	$text = "Upgrade Membership";
}
else{
	$mode = 1;
	$text = "Extend Premium Membership";
}

function re_fail(){
		if($_GET["re"]=="FAIL_CAPTCHA"){
			return "Fail Captcha Verification! Try Again.";
		}
		else if($_GET["re"]=="NO_SUBMIT_CAPTCHA"){
			return "No Captcha Submission! Try Again.";
		}
		else if($_GET["re"]=="NO_SUBMIT"){
			return "Fail Submission or Timeout! Try Again.";
		}
		else if($_GET["re"]=="ERROR"){
			return "Payment Fail! Try Again.";
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
		<title>Premium Membership Payment | LuxToTrade COMP2121 Project</title>
		<link rel="icon" href="https://cdn3.iconfinder.com/data/icons/business-office-2/512/tag-512.png" >
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<link rel="stylesheet" href="css/animate.css" />
		<link rel="stylesheet" href="css/captcha.css">
		<link rel="stylesheet" href="css/waypoints.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="js/scroll.js"></script>
		<script src="js/waypoints.js"></script>
		<script src="js/waypoints.min.js"></script>
		<script type="text/javascript" src="js/validate2.js"></script>
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
					<li class="nav-item active">
						<a class="nav-link" href="profile.php">Back</a>
					</li>
				</ul>
				 <!-- Search form -->
				<ul class="navbar-nav ml-auto nav-flex-icons row">
					<li class="nav-item avatar dropdown">
						<a class="nav-link dropdown-toggle" id="DropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo $row[0]; ?>" class="img-fluid rounded-circle z-depth-0" width="30" height="30"><small><?php echo $row[1]; ?></small></a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="DropdownMenuLink1">
							<a class="dropdown-item" href="profile.php">Profile</a>
							<a class="dropdown-item" href="#">Help</a>
							<hr>
							<a class="dropdown-item" href="" data-toggle="modal" data-target="#Modal1">Logout</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>
		<!--Navbar -->
	<form action="payment.php" method="POST">
	<div class="wrap">
	<fieldset class="col-md-6 offset-md-3">
		<div class="form-top">
			<div class="form-top-left">
				<h1><?php echo $text; ?></h1>
				<small style="font-size:80%;">We provide a flexible option for you to subscrible premium membership.</small>
				<h3 id="ind">Credit card payment</h3>
			</div>
		</div>
		<div class="form-bottom">
		  <div class="card card-block" id="payform" style="display:block;margin-buttom:20px;">
			<!-- form card cc payment -->
			<div class="card card-outline-secondary" style="padding:10px;">
				<div class="card-block">
					<div class="form-group text-center">
						<ul class="list-inline">
							<li class="list-inline-item"><i class="text-muted fa fa-cc-visa fa-2x"></i></li>
							<li class="list-inline-item"><i class="fa fa-cc-mastercard fa-2x"></i></li>
							<li class="list-inline-item"><i class="fa fa-cc-amex fa-2x"></i></li>
							<li class="list-inline-item"><i class="fa fa-cc-discover fa-2x"></i></li>
						</ul>
					</div>
					<hr>
						<?php
							$error1 = "<div class='alert alert-info'><a class='close'data-dismiss='alert' href='#'>×</a>";
							$error2 = "</div>";
							if(isset($_GET["re"])){
								$msg = re_fail();
								echo $error1.$msg.$error2;
							}
						?>
						<div class="form-group">
							<label for="cc_name">Card Holder's Name</label>
							<input type="text" class="form-control" id="cc_name" onkeyup="check_hname(this);"  name="cc_name" title="First and last name" >
						</div>
						<div id="vcname" class="invalid-feedback" style="display:none;"></div>
						<div class="form-group">
							<label>Card Number</label>
							<div class="input-group">
								<div class="input-group-addon" id="cardtype" style="dsiplay:none;"></div>
								<input type="text" class="form-control" name="cardnum" autocomplete="off" maxlength="20" id="cardnum" onkeyup="CardNumber();" onchange="CardNumber();" title="Credit card number" >
							</div>
						</div>
						<div id="vcnum" class="invalid-feedback" style="display:none;"></div>
						<div class="form-group row">
							<label class="col-sm-10">Card Exp. Date</label>
							<div class="col-md-4">
								<select id="exMonth" name="cc_exp_mo" class="form-control" onchange="check_exp();" onkeyup="check_exp();" size="0">
									<option value="1">01</option>
									<option value="2">02</option>
									<option value="3">03</option>
									<option value="4">04</option>
									<option value="5">05</option>
									<option value="6">06</option>
									<option value="7">07</option>
									<option value="8">08</option>
									<option value="9">09</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
								</select>
							</div>
							<div class="col-md-4">
								<select id="exYear" name="cc_exp_yr"  class="form-control" onchange="check_exp();" onkeyup="check_exp();"  size="0">
									<option value="2017">2017</option>
									<option value="2018">2018</option>
									<option value="2019">2019</option>
									<option value="2020">2020</option>
									<option value="2021">2021</option>
									<option value="2022">2022</option>
									<option value="2023">2023</option>
									<option value="2024">2024</option>
									<option value="2025">2025</option>
									<option value="2026">2026</option>
									<option value="2027">2027</option>
								</select>
							</div>
							<div class="col-md-4">
								<input type="text" class="form-control" autocomplete="off" maxlength="3" onkeyup="check_cvc(this);" id="cvc" pattern="\d{3}" title="Three digits at back of your card" placeholder="CVC">
							</div>
						</div>
						<div id="vdate" class="invalid-feedback" style="display:none;"></div>
						<div id="vcvc" class="invalid-feedback" style="display:none;"></div>

						<label class="col-md-12">Membership Plan</label>
						<select name="plan" class="form-control" id="planoption" onchange="plans();" onkeyup="plans();">
							<option value="" selected="selected">Choose</option>
							<option value="30">30 Days $29.9</option>
							<option value="90">90 Days $79.9</option>
							<option value="180">180 Days $119.9</option>
							<option value="365">365 Days $200</option>
						</select>
						<div id="vplan" class="invalid-feedback" style="display:none;">Please choose a plan</div>
						<div class="row">
							<label class="col-md-12">Amount</label>
						</div>
						<div class="form-inline">
							<div class="input-group">
								<div class="input-group-addon">$</div>
								<input type="text" class="form-control text-right" id="exampleInputAmount" placeholder="---" disabled>
								<div id="day" class="input-group-addon">---</div>
							</div>
						</div>
						<p>New expire date: </p>
						<p id="update"></p>
						<div class="recaptcha g-recaptcha" data-sitekey="6LcN5jQUAAAAAIHtiXMKYDvCGvfmu0OVothxYUBc"></div>
					</div>
					<hr>
					<input type="submit" class="btn btn-outline-danger" name="submit" id="regsub" value="submit" disabled>
					<div style="height:30px;"/>
				</div>
			</div>
			<!-- /form card cc payment -->
		</div>
	</fieldset>
	</div>
	</form>
	<script>
	jQuery.noConflict();
	$(document).ready(function() {
		$('#planoption').change(function() {
			var p = $(this).val();
			if(p==0){
				$('#exampleInputAmount').attr("placeholder",+"---");
				$('#day').html("---");
				$('#update').html("---");
				document.getElementById("planoption").classList.add('is-invalid');
				document.getElementById("planoption").classList.remove('is-valid');
				document.getElementById("vplan").style.display = "block";

			}
			else{
				document.getElementById("planoption").classList.add('is-valid');
				document.getElementById("planoption").classList.remove('is-invalid');
				document.getElementById("vplan").style.display = "none";
				if(p==30){
					$('#exampleInputAmount').attr("placeholder",+"29.9");
					$('#day').html("30 days");

				}
				else if(p==90){
					$('#exampleInputAmount').attr("placeholder",+"79.9");
					$('#day').html("90 days");

				}
				else if(p==180){
					$('#exampleInputAmount').attr("placeholder",+"119.9");
					$('#day').html("180 days");

				}
				else if(p==365){
					$('#exampleInputAmount').attr("placeholder",+"200.0");
					$('#day').html("365 days");

				}

				$.ajax({
					url:"check.php",
					method:"POST",
					data:{plan:p},
					dataType:"text",
					success:function(response){
						$('#update').html(response);
					}
				});
			}
			reg_sub2();
		});

		function reg_sub2(){
			var cvc_check =  document.getElementById("cvc").classList.contains('is-valid');
			var hname_check =  document.getElementById("cc_name").classList.contains('is-valid');
			var cardnum_check =  document.getElementById("cardnum").classList.contains('is-valid');
			var check_month =  document.getElementById("exMonth").classList.contains('is-valid');
			var check_year =  document.getElementById("exYear").classList.contains('is-valid');
			var check_plan =  document.getElementById("planoption").classList.contains('is-valid');
			if(cvc_check == true && hname_check==true && cardnum_check==true && check_month == true && check_year == true && check_plan == true ){
				document.getElementById("regsub").disabled = false;
			}
			else{
				document.getElementById("regsub").disabled = true;
			}
		}

		$("#regsub" ).click(function(e) {
			if(grecaptcha.getResponse() == "") {
				e.preventDefault();
				alert("Captcha is Missing!");
			}
		});
	});

	</script>
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
