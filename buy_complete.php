<!DOCTYPE html>
<?php
include_once 'config.php';
include_once 'token.php';

session_start();
$pay_type = $_SESSION["pay_type"];
$order_id = $_SESSION["order"];
$m_id =  isloggedin();
$sql = mysql_query("SELECT profileimg,username,joindate FROM member WHERE m_id = '$m_id' ");
$row = mysql_fetch_array($sql,MYSQL_NUM);
$payment_id =$_SESSION["payment"];
$invoice_id =$_SESSION["invoice"];
$order_id = $_SESSION["order"];
$paid_total = $_SESSION["amount"];
$next_coupon = $_SESSION["next_coupon"];
$fake_shipping_id = $_SESSION["shipping"];
$address = $_SESSION["address"];
$company = $_SESSION["shipping_company"];

if($pay_type!="buy"){
  header("Location:shop");
}

session_destroy();


?>

<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Just a frame made by Willon hahaha | Here is the discription">
  <meta name="keywords" content="HTML,CSS,PHP,Bootstrap,COMP,Project,polyu,comp,COMP,PolyU,Hong Kong,luxury,LUXTOT0TRADE">
  <meta name="author" content="Willon Lai">
  <title> Order completed | LuxToTrade COMP2121 Project</title>
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
  <style>
  #loader {
    position: absolute;
    left: 50%;
    top: 50%;
    z-index: 1;
    width: 150px;
    height: 150px;
    margin: -75px 0 0 -75px;
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
  }

  @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  .animate-bottom {
    position: relative;
    -webkit-animation-name: animatebottom;
    -webkit-animation-duration: 1s;
    animation-name: animatebottom;
    animation-duration: 1s
  }

  @-webkit-keyframes animatebottom {
    from { bottom:-100px; opacity:0 }
    to { bottom:0px; opacity:1 }
  }

  @keyframes animatebottom {
    from{ bottom:-100px; opacity:0 }
    to{ bottom:0; opacity:1 }
  }

  #myDiv {
    display: none;
    text-align: center;
  }
  .wrap {
    margin-top:80px;
    padding-left : 50px;
    padding-right : 50px;
    width:100%;
  }
  .invoice-head td {
    padding: 0 8px;
  }
  .container {
    padding-top:30px;
  }
  .invoice-body{
    background-color:transparent;
  }
  .invoice-thank{
    margin-top: 60px;
    padding: 5px;
  }
  address{
    margin-top:15px;
}
  </style>
</head>
<body onload="myFunction()" style="margin:0;">

  <div id="loader"></div>

  <div style="display:none;" id="myDiv" class="animate-bottom">

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
  			</ul>
  			<ul class="navbar-nav ml-auto nav-flex-icons row ">
  				<li class="nav-item avatar dropdown">
  					<a class="nav-link dropdown-toggle" id="DropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo $row[0]; ?>" class="img-fluid rounded-circle z-depth-0" width="30" height="30"><small><?php echo $row[1]; ?></small></a>
  					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="DropdownMenuLink1" style="width:50%;">
  						<a class="dropdown-item" href="profile">Profile</a>
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
  				<div class="progress">
  					<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Progress:100%</div>
  				</div>
  				<h1>Purchase Completed!</h1>
  			</div>
  		</div>
  		<div class="form-bottom">
  		  <div class="card card-block" id="payform" style="display:block;margin-buttom:20px;">
  			<!-- form card cc payment -->
  			<div class="card card-outline-secondary" style="padding:10px;">
  				<div class="card-block">
  					  <h5 style="text-align:center; color:green;">You order is made successfully.</h5>
              <h6 style="color:brown;">We will send the purchased items to your shipping adddress (<?php echo $address; ?>) within 1 working day day via <?php echo $company; ?>.</h6>

                <h5 class="pull-left">Invoice</h5>
                <table class="table table-responsive">
                  <?php $get_pay_details = mysql_query("SELECT pay_date,cc_num,amount FROM payment_b WHERE payment_id ='$payment_id'");
                        $row_pay_details = mysql_fetch_array($get_pay_details,MYSQL_NUM);
                  ?>
                <caption>Order details</caption>
                <tbody>
                  <tr>
                    <th>Invoice ID</th>
                    <td><?php echo $invoice_id; ?></td>
                  </tr>
                  <tr>
                    <th>Order ID</th>
                    <td><?php echo $order_id; ?></td>
                  </tr>
                  <tr>
                    <th>Shipping ID</th>
                    <td><?php echo $fake_shipping_id; ?></td>
                  </tr>
                  <tr>
                    <th>Paid Date</th>
                    <td><?php echo $row_pay_details[0]; ?></td>
                  </tr>
                  <tr>
                    <th>Credit Card Number</th>
                    <td><?php $smcc= substr($row_pay_details[1], -4); echo "****".$smcc; ?></td>
                  </tr>
                  <tr>
                    <th>Paid Amount</th>
                    <td><?php echo "$".$row_pay_details[2]."HKD"; ?></td>
                  </tr>
                  <?php
                  if($next_coupon=="true"){
                    echo "<tr><th>Gift Coupon</th><td>10% off Coupon for next purchase</td></tr>";
                  }
                  ?>
                </tbody>
              </table>

              </div>
  						<div style="margin-top:50px; margin-left:10px; padding:10px;">
								<div class="row" style="width:inherit; text-align:center;">
									<div class="col-12 col-sm-6">
										<a href="buypanel?payment"><button type="button" class="btn btn-success btn-lg float-right">View my payment record</button></a>
									</div>
									<div class="col-12 col-sm-6 ">
				            <a href="sellpanel"><button type="button" class="btn btn-info btn-lg float-right">View my order record</button></a>
									</div>
								</div>
								<div class="row" style="width:inherit; text-align:center;">
									<div class="col-12 col-sm-6">
										<a href="shop"><button type="button" class="btn btn-primary btn-lg float-right">Continue Shopping</button></a>
									</div>
								</div>
  						</div>


  				</div>
  			</div>
  			<!-- /form card cc payment -->
  		</div>
    </div>
  	</fieldset>
  	</div>
  	</form>

  </div>

  <script>
  var myVar;

  function myFunction() {
      myVar = setTimeout(showPage, 2000);
  }

  function showPage() {
    document.getElementById("loader").style.display = "none";
    document.getElementById("myDiv").style.display = "block";
  }
  </script>

</html>
