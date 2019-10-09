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

$pay_type = $_SESSION["pay_type"];

$sql = mysql_query("SELECT profileimg,username,joindate FROM member WHERE m_id = '$m_id' ");
$row = mysql_fetch_array($sql,MYSQL_NUM);

if($pay_type!="buy"){
  header('Location:shop');
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
		<title> Choose Shipping | LuxToTrade COMP2121 Project</title>
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
	<form action="process_shipping.php" method="POST">
	<div class="wrap">
	<fieldset class="col-md-6 offset-md-3">
		<div class="form-top">
			<div class="form-top-left">
				<div class="progress">
					<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">Progress:75%</div>
				</div>
				<h1>Choose Shipping</h1>
				<small style="font-size:80%;">Please choose a shipping compnay.</small>
			</div>
		</div>
		<div class="form-bottom">
		  <div class="card card-block" id="payform" style="display:block;margin-buttom:20px;">
			<!-- form card cc payment -->
			<div class="card card-outline-secondary" style="padding:10px;">
				<div class="card-block">
          <div class="form-row align-items-center">
            <div class="col-auto">
              <label class="mr-sm-2" for="shipping_company">Shipping Company</label>
              <select class="form-control custom-select mb-2 mr-sm-2 mb-sm-0" name="shipping_company" id="shipping_company">
                <option value="default" selected>Choose...</option>
                <option value="sf">SF Express</option>
                <option value="dhl">DHL</option>
              </select>
            </div>
            <div class="col-auto">
              <label class="mr-sm-2" for="shipping_address">Shipping Address</label>
              <select class="form-control custom-select mb-2 mr-sm-2 mb-sm-0" name="shipping_address" id="shipping_address">
                <option value="default" selected>Default</option>
                <option value="other">Other</option>
              </select>
            </div>
				</div>
        <div class="row" style="margin-top:15px;">
          <div class="col-12">
            <input class="form-control" type="text" name="address" id="address" value="" readonly>
          </div>
        </div>
        <div class="row" style="margin-top:15px;">
          <div class="col-12">
          <input type="submit" class="btn btn-outline-danger" name="ship_sub" id="ship_sub" value="submit" disabled>
          </div>
        </div>
        <div style="height:30px;"/>
			</div>
			<!-- /form card cc payment -->
		</div>
	</fieldset>
	</div>
	</form>
	<script>
	jQuery.noConflict();
	$(document).ready(function() {
    var hello = "default";

    $.ajax({
      url:"fetch2.php",
      method:"POST",
      data:{default_address:hello},
      success:function(data)
      {
        $('#address').val(data);
      }
    });

    $('#shipping_company').change(function(){
			shipping_company = $('#shipping_company option:selected').val();
			if(shipping_company=="default"){
        $('#shipping_company').addClass('is-invalid');
        $('#shipping_company').removeClass('is-valid');
      }
      else{
        $('#shipping_company').removeClass('is-invalid');
        $('#shipping_company').addClass('is-valid');
      }
      allow_submit();
		});

    $('#shipping_address').change(function(){
			shipping_address = $('#shipping_address option:selected').val();
			if(shipping_address=="default"){
        var hello = "hello";
        $.ajax({
          url:"fetch2.php",
          method:"POST",
          data:{default_address:hello},
          success:function(data)
          {
            $('#address').val(data);
            $('#address').attr("readonly",true);
          }
        });
      }
      else{
        $('#address').val("");
        $('#address').attr("readonly",false);
      }
      allow_submit();
		});

    $('#address').keyup(function(){
			address = $(this).val();
			if(address.length < 10){
        $('#address').addClass('is-invalid');
        $('#address').removeClass('is-valid');
      }
      else{
        $('#address').addClass('is-valid');
        $('#address').removeClass('is-invalid');
      }
      allow_submit();
		});

    function allow_submit(){
      var add_len = $('#address').val().length;
      var ship_com = $('#shipping_company').val();
      var ship_add = $('#shipping_address').val();
      if(ship_com!="default" ){
        if(ship_add=="default"){
          document.getElementById("ship_sub").disabled = false;
        }
        else{
          if( add_len > 10 ){
              document.getElementById("ship_sub").disabled = false;
          }
          else{
              document.getElementById("ship_sub").disabled = true;
          }
        }

      }
      else{
        document.getElementById("ship_sub").disabled = true;
      }
    }

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
