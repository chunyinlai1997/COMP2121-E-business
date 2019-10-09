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

if(isset($_POST['submit']) && !empty($_POST['submit'])):
    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])):
        //your site secret key
        $secret = '6LcN5jQUAAAAACa2GtQVN-n7lw3gLgu6RDMCoufK';
        //get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success):
           $thanks = gotopay();
        else:
            header('Location:premium?re=FAIL_CAPTCHA');
        endif;
    else:
        header('Location:premium?re=NO_SUBMIT_CAPTCHA');
    endif;
else:
	header('Location:premium?re=NO_SUBMIT');
endif;


function gotopay(){
	if(isset($_POST['submit'])){
		$mid = isloggedin();
		$sql = mysql_query("SELECT mem_status,exp_date FROM membership WHERE m_id ='$mid'")or die(mysql_error());
		$result = mysql_fetch_array($sql,MYSQL_NUM);
		$membertype = $result[0];
		$plan = $_POST['plan'];
		$original_exp = $result[1];
		$exp_date = findexp($membertype,$plan,$original_exp);
		$amount = findamount($plan);
		$paytype = "Membership Fee";
		$cc = $_POST['cardnum'];
		$paydate = date("Y-m-d");
		$premium = "PREMIUM";
		$type = "Membership Fee";
		$smcc= substr("$cc", -4);
		if($membertype=="PREMIUM"){
			mysql_query("UPDATE membership SET exp_date='$exp_date' WHERE m_id='$mid'") or die(mysql_error());
			$thanks = "Thank you! You have extended the PREMIUM membership for $plan days(expire on $exp_date). We have received $amount paid by your credit card (no.*****$smcc) on $paydate.<br>If you have any inquires about this payment, please <a href='#'>contact us</a>.";
		}
		else{
			mysql_query("UPDATE membership SET mem_status='$premium', exp_date='$exp_date' WHERE m_id='$mid'") or die(mysql_error());
			$thanks = "Thank you! You have upgraded to the PREMIUM membership for $plan days(expire on $exp_date). We have received $amount paid by your credit card (no.*****$smcc) on $paydate.<br>If you have any inquires about this payment, please <a href='#'>contact us</a>.";
		}
		mysql_query("INSERT INTO payment_b(payment_type,pay_date,buyer_id ,amount,cc_num,unpaid) VALUES('$type','$paydate','$mid','$amount','$cc','false')")or die(mysql_error());
		return $thanks;
	}
	else{
		header('Location:premium?re=ERROR');
	}
}

function findexp($membertype,$plan,$original_exp){
	$initial = date("Y-m-d");
	$new = $initial;
	if($membertype=="STANDARD"){
		if($plan==30){
			$new = date('Y-m-d', strtotime($initial. ' + 30 days'));
		}
		else if($plan==90){
			$new = date('Y-m-d', strtotime($initial. ' + 90 days'));
		}
		else if($plan==180){
			$new = date('Y-m-d', strtotime($initial. ' + 180 days'));
		}
		else if($plan==365){
			$new = date('Y-m-d', strtotime($initial. ' + 365 days'));
		}
	}
	else{
		$initial = $original_exp;
		if($plan==30){
			$new = date('Y-m-d', strtotime($initial. ' + 30 days'));
		}
		else if($plan==90){
			$new = date('Y-m-d', strtotime($initial. ' + 90 days'));
		}
		else if($plan==180){
			$new = date('Y-m-d', strtotime($initial. ' + 180 days'));
		}
		else if($plan==365){
			$new = date('Y-m-d', strtotime($initial. ' + 365 days'));
		}
	}
	return $new;
}

function findamount($plan){
	$amount = 0;
	if($plan==30){
		$amount = 29.9;
	}
	else if($plan==90){
		$amount = 79.9;
	}
	else if($plan==180){
		$amount = 119.9;
	}
	else if($plan==365){
		$amount = 200;
	}
	return $amount;
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
  <title> Payment Process | LuxToTrade COMP2121 Project</title>
  <link rel="icon" href="https://cdn3.iconfinder.com/data/icons/business-office-2/512/tag-512.png" >
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <link rel="stylesheet" href="css/animate.css" />
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
  <style>
		.wrap {
			margin-top:80px;
			padding-left : 50px;
			padding-right : 50px;
			width:100%;
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
						<a class="nav-link" href="profile">Back</a>
					</li>
				</ul>
				 <!-- Search form -->
				<ul class="navbar-nav ml-auto nav-flex-icons row">
					<li class="nav-item avatar dropdown">
						<a class="nav-link dropdown-toggle" id="DropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo $row[0]; ?>" class="img-fluid rounded-circle z-depth-0" width="30" height="30"><small><?php echo $row[1]; ?></small></a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="DropdownMenuLink1">
							<a class="dropdown-item" href="profile">Profile</a>
							<a class="dropdown-item" href="#">Help</a>
							<hr>
							<a class="dropdown-item" href="" data-toggle="modal" data-target="#Modal1">Logout</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>
		<!--Navbar -->
		<form>
	    <div class="wrap">
	  	<fieldset class="col-md-6 offset-md-3">
	  		<div class="form-top">
	  			<div class="form-top-left">
	  				<h1>Payment Complete</h1>
	  			</div>
	  		</div>
	  		<div class="form-bottom">
	  		  <div class="card card-block" id="payform" style="display:block;margin-buttom:20px;">
	  			<!-- form card cc payment -->
	  			<div class="card card-outline-secondary" style="padding:10px;">
	  				<div class="card-block">
							<div class="form-group">
								<h5 style="text-align:center;"><?php echo $thanks; ?><h5>
							</div>
							<a href="buypanel?payment"><button type="button" class="btn btn-success btn-lg float-right">View my payment record</button></a>
							<a href="home"><button type="button" class="btn btn-secondary btn-lg float-right">Home</button></a>
	  				</div>
	  			</div>
	  			<!-- /form card cc payment -->
	  		</div>
	    </div>
	  	</fieldset>
	  	</div>
	  	</form>

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
