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
$sql = mysql_query("SELECT profileimg,username,joindate,email,firstname,lastname,phone,address,country FROM member WHERE m_id = '$m_id' ");
$row = mysql_fetch_array($sql,MYSQL_NUM);

$sqlp = mysql_query("SELECT DISTINCT product.product_id,product.price,product.product_image1,product.description,product.STATUS,product.post_date,product.seller_id
				 FROM product,shopping_cart
         WHERE product.product_id = shopping_cart.product_id
         AND shopping_cart.m_id = '$m_id' ");
 $output = "<div class='row list-unstyled'>";
 $count = mysql_num_rows($sqlp);
 while($rowp = mysql_fetch_array($sqlp,MYSQL_NUM)){
  $product_id = $rowp[0];
  $seller_id = $rowp[6];
  $price = $rowp[1];
  $product_img = $rowp[2];
  $description = $rowp[3];
  $status = $rowp[4];
  $post_date = $rowp[5];
  $sqlp2 = mysql_query("SELECT model_name,product_type FROM accept_product WHERE product_id = '$product_id' ");
  $row_accept = mysql_fetch_array($sqlp2,MYSQL_NUM);
  $model_name = $row_accept[0];
  $product_type = $row_accept[1];
  $brand = "";
  $re_price = 0;
  $size = "";
  if($product_type=="bag"){
    $sqlp3 = mysql_query("SELECT brand,recommended_price,size FROM bag WHERE model_name = '$model_name' ");
    $detail = mysql_fetch_array($sqlp3,MYSQL_NUM);
    $brand = $detail[0];
    $re_price = $detail[1];
    $size = $detail[2];
  }
  else{
    $sqlp3 = mysql_query("SELECT brand,recommended_price,size FROM accessories WHERE model_name = '$model_name' ");
    $details = mysql_fetch_array($sqlp3,MYSQL_NUM);
    $brand = $details[0];
    $re_price = $details[1];
    $size = $details[2];
  }
  $sqlp4 = mysql_query("SELECT firstname,lastname FROM member WHERE m_id = '$seller_id' ");
  $seller_detail = mysql_fetch_array($sqlp4,MYSQL_NUM);
  $full_name = $seller_detail[0]." ".$seller_detail[1];
  $check1 = mysql_query("SELECT COUNT(*) FROM shopping_cart WHERE m_id ='$m_id' AND product_id='$product_id'");
  $rowp2 = mysql_fetch_array($check1,MYSQL_NUM);
  $check2 = mysql_query("SELECT COUNT(*) FROM wishlist WHERE m_id ='$m_id' AND product_id='$product_id'");
  $rowp3 = mysql_fetch_array($check2,MYSQL_NUM);
  $tg = "";
  $active = "";
  $tg2 = "";
  $active2 = "";
  if($rowp2[0]==0){
    $tg = "false";
    $active = "";
  }
  else{
    $tg = "true";
    $active = "active";
  }
  if($rowp3[0]==0){
    $tg2 = "false";
    $active2 = "";
  }
  else{
    $tg2 = "true";
    $active2 = "active";
  }
  $sql5 = mysql_query("SELECT status,quality,action FROM check_record WHERE product_id = '$product_id'");
  $row5 = mysql_fetch_array($sql5,MYSQL_NUM);

  $auth_label = "";

  if($row5[0]=="checked" and $row5[2]=="valid" ){
    $auth_label = "<i class='fa fa-check-circle' aria-hidden='true' style='margin-left:2px; padding:5px; color:green; font-size:150%;'></i>";
  }
  else if($row5[0]=="checked" and $row5[2]=="need_change"){
    $auth_label = "<i class='fa fa-exclamation-circle' aria-hidden='true' style='margin-left:2px; padding:5px; color:yellow; font-size:150%;'></i>";
  }
  else if($row5[0]=="checked" and $row5[2]=="invalid"){
    $auth_label = "<i class='fa fa-times' aria-hidden='true' style='margin-left:2px; padding:5px; color:red; font-size:150%;'></i>";
  }

  include_once 'content.php';
  $stars = get_stars($seller_id);
  $available ="";
  if($row5[2]=='invalid'){
    $available = "<small>This Item is temporary not available.</small>";
  }
  else if($status=="sold"){
    $available = "<small>This Item is sold.</small>";
  }
  else if($status=="removed"){
    $available = "<small>This Item is no longer available.</small>";
  }
  else{
    $available = "<label class='custom-control custom-checkbox'>
        <input value='$product_id' id='$product_id' type='checkbox' class='custom-control-input ready'>
        <span class='custom-control-indicator'></span>
    </label>";
  }

  $output .= "
  <div class='col-12' style='margin-bottom:15px;'>
  <div class='row' >
    <div class='col-0 col-sm-0 col-md-3'>
    <a href='' id='$product_id' class='view_details' data-toggle='modal' data-target='#view_content'><img class='d-flex mr-3' src='$product_img' width='100' height='100'></a>
    </div>
    <div class='col-7'>
          <h5><a href='shop_model?model_name=$model_name' target='_blank'>$model_name</a></h5>
          <h6 class='mb-0 t'>Brand: <a href='shop_brand?brand=$brand' target='_blank'>$brand</a></h6>
          <p>Seller: <a href='user_profile?m_id=$seller_id' target='_blank'>$full_name</a> $stars</p>
          <h6 class='mb-0 t'>$$price HKD  </h6>

          <h6 style='font-size:1em;' class='badge badge-pill badge-primary'>$status</h6>
          $auth_label
          <a href='' style='margin-left:5px;' id='$product_id' class='view_details' data-toggle='modal' data-target='#view_content'></a>
    </div>
    <div class='col-2'>
      $available
    </div>
  </div>
  <hr>
 </div>
 ";
 }
 $output .="</div>";



?>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Just a frame made by Willon hahaha | Here is the discription">
		<meta name="keywords" content="HTML,CSS,PHP,Bootstrap,COMP,Project,polyu,comp,COMP,PolyU,Hong Kong,luxury,LUXTOT0TRADE">
		<meta name="author" content="Willon Lai">
		<title> Checkout | LuxToTrade COMP2121 Project</title>
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
          <li class="nav-item">
  					<a class="nav-link" href="buypanel?cart">Back</a>
  				</li>
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
	<form action="buy_process.php" method="POST">
	<div class="wrap">
	<fieldset class="col-md-6 offset-md-3">
		<div class="form-top">
			<div class="form-top-left">
				<div class="progress">
					<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%">Progress:25%</div>
				</div>
				<h1>Checkout</h1>
				<small style="font-size:80%;">Please choose items to checkout.</small>
			</div>
		</div>
		<div class="form-bottom">
		  <div class="card card-block" id="payform" style="display:block;margin-buttom:20px;">
			<!-- form card cc payment -->
			<div class="card card-outline-secondary" style="padding:10px;">
				<div class="card-block">
          <span class='custom-control-description'>Tick the checkbox for checkout.</span>
          <?php
          echo $output;
          ?>
          <div class="col-12">
            <label class="mr-sm-2" for="shipping_address">LuxPrime Service(Repairing and Cleaning): </label>
            <label class='custom-control custom-checkbox'>
                <input id='repair_check' type='checkbox' class='custom-control-input' disabled>
                <span class='custom-control-indicator'></span>
            </label>
          </div>
          <div class="col-12">
            <h5>Subtotal:</h5>
          </div>
          <div class="col-12 pull-right" style="text-align:right;" id="basic_subtotal">
          <p>Selected 0 item: <strong>$0 HKD</strong></p>
          </div>
          <div class="col-12 pull-right" style="text-align:right;" id="trans_fee">

          </div>
          <div class="col-12 pull-right" style="text-align:right;" id="first_buy">

          </div>
          <div class="col-12 pull-right" style="text-align:right;" id="invite_buy">

          </div>
          <div class="col-12 pull-right" style="text-align:right;" id="repair_buy">

          </div>
          <div class="col-12 pull-right" style="text-align:right;" id="monthly">

          </div>
          <div class="col-12 pull-right" style="text-align:right;" id="weekly">

          </div>
          <div class="col-12 pull-right" style="text-align:right;" id="cheaper">

          </div>

          <div class="col-12 pull-right" style="text-align:right;" id="total">

          </div>
          <input type="hidden" value="" name="discount_total" id="discount_total">
          <input type="hidden" value="" name="next_coupon" id="next_coupon">
          <input type="hidden" value="" name="trans_total" id="trans_total">
          <input type="hidden" value="" name="basic_total" id="basic_total">
          <input type="hidden" value="" name="final_total" id="final_total">
          <input type="hidden" value="" name="repair_total" id="repair_total">
          <input type="hidden" value="" name="chosen" id="chosen">
          <input type="submit" class="btn btn-outline-success" name="buy_submit" id="buy_submit" value="submit" disabled>
					<div style="height:30px;"></div>
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
    var basic_subtotal = 0;
    var trans_fee_amount = 0;
    var item_count = 0;
    var selected = [];
    var first_buy_amount = 0;
    var invite_buy_amount = 0;
    var monthly_amount = 0;
    var weekly_amount = 0;
    var cheaper_amount = 0;
    var final_total = 0;
    var discount_amount = 0;
    var repair_amount = 0;
    var repair_option = "";

    $(document).on('click', '#repair_check', function(){
      if($(this).is(':checked')){
        repair_amount = Math.round(basic_subtotal * 0.1);
        if(repair_amount>10000){
          repair_amount = repair_amount * 0.7;
        }
        $('#repair_buy').html("<p>LuxPrime Service(Reparing and Cleaning): <strong>$"+repair_amount+" HKD</strong></p>");
      }
      else{
        repair_amount = 0;
        $('#repair_buy').html("");
      }
    });

    $(document).on('click', '.ready', function(){
      cal();
      var pid = $(this).attr('id');


      if($(this).is(':checked')){
        $.ajax({
          url:"fetch2.php",
          method:"POST",
          data:{search_price:pid},
          success:function(data)
          {
            data = eval(data);
            basic_subtotal += data;
            item_count += 1 ;
            selected.push(pid);
            $('#basic_subtotal').html("Selected "+item_count+" item: <strong>  $"+basic_subtotal+" HKD</strong>");

            first_buy_function();
            invite_buy_function();
            monthly_function();
            weekly_function();
            cheaper_function();
            next_coupon_function();
            transaction_fee();
            cal();
            }
        });
      }
      else{
        $.ajax({
          url:"fetch2.php",
          method:"POST",
          data:{search_price:pid},
          success:function(data)
          {
            data = eval(data);
            basic_subtotal -= data;
            item_count -= 1 ;
            var index = selected.indexOf(pid);
            delete selected[index];
            $('#basic_subtotal').html("Selected "+item_count+" item: <strong>  $"+basic_subtotal+" HKD</strong>");

            first_buy_function();
            invite_buy_function();
            monthly_function();
            weekly_function();
            cheaper_function();
            next_coupon_function();
            transaction_fee();
            cal();
          }
        });
      }
      cal();
    });

    var tid = setTimeout(mycode, 1000);
    function mycode() {
      cal();
      tid = setTimeout(mycode, 1000); // repeat myself
    }

    function first_buy_function(){
      if(item_count>0){
        $('#first_buy').css("dsiplay","block");
        $.ajax({
          url:"coupon.php",
          method:"POST",
          data:{first_buy:basic_subtotal,item_count:item_count},
          success:function(data)
          {
            data = eval(data);
            if(data>0){
              $('#first_buy').html("<p>First Purchase Discount: <strong>-$"+data+" HKD</strong></p>");
            }
            first_buy_amount = data;
          }
        });
      }
      else{
        first_buy_amount = 0 ;
        $('#first_buy').html("");
      }

    }
    function invite_buy_function(){
      if(item_count>0){
        $('#invite_buy').css("dsiplay","block");
        $.ajax({
          url:"coupon.php",
          method:"POST",
          data:{invite_buy:basic_subtotal,item_count:item_count},
          success:function(data)
          {
            data = eval(data);
            if(data>0){
              $('#invite_buy').html("<p>Friends Invitation Discount: <strong>-$"+data+" HKD</strong></p>");
            }
            invite_buy_amount = data;
          }
        });
      }
      else{
        invite_buy_amount = 0 ;
        $('#invite_buy').html("");
      }

    }
    function monthly_function(){
      if(item_count>0){
        $('#monthly').css("dsiplay","block");
        $.ajax({
          url:"coupon.php",
          method:"POST",
          data:{monthly:selected},
          success:function(data)
          {
            data = eval(data);
            if(data>0){
              $('#monthly').html("<p>Monthly Discount: <strong>-$"+data+" HKD</strong></p>");
            }
            monthly_amount = data;
          }
        });
      }
      else{
        monthly_amount = 0 ;
        $('#monthly').html("");
      }

    }
    function weekly_function(){
      if(item_count>0){
        $('#weekly').css("dsiplay","block");
        $.ajax({
          url:"coupon.php",
          method:"POST",
          data:{weekly:selected},
          success:function(data)
          {
            data = eval(data);
            if(data>0){
              $('#weekly').html("<p>Weekly Discount: <strong>-$"+data+" HKD</strong></p>");
            }
            weekly_amount = data;
          }
        });
      }
      else{
        weekly_amount = 0 ;
        $('#weekly').html("");
      }

    }
    function cheaper_function(){
      if(item_count>0){
        $('#cheaper').css("dsiplay","block");
        $.ajax({
          url:"coupon.php",
          method:"POST",
          data:{cheaper:basic_subtotal},
          success:function(data)
          {
            data = eval(data);
            if(data>0){
              $('#cheaper').html("<p>Discount from prevoius purchase: <strong>-$"+data+" HKD</strong></p>");
            }
            cheaper_amount = data;
          }
        });
      }
      else{
        cheaper_amount = 0 ;
        $('#cheaper').html("");
      }

    }
    function next_coupon_function(){
      $.ajax({
        url:"coupon.php",
        method:"POST",
        data:{next:item_count},
        success:function(data)
        {
          if(data=="true"){
            $('#next_coupon').val("true");
          }
          else{
            $('#next_coupon').val("false");
          }
        }
      });

    }
    function transaction_fee(){
      $.ajax({
        url:"coupon.php",
        method:"POST",
        data:{membership:basic_subtotal},
        success:function(data)
        {
          trans_fee_amount = eval(data);
          $('#trans_fee').html("<p>Transaction Fee: <strong>$"+data+" HKD</strong></p>");
        }
      });
    }

    function cal(){
      if(item_count>0){
        $('#repair_check').attr("disabled",false);
      }
      else{
        $('#repair_check').attr("disabled",true);
      }
      discount_amount = first_buy_amount + invite_buy_amount + weekly_amount + monthly_amount + cheaper_amount;
      final_total = basic_subtotal + repair_amount + trans_fee_amount - discount_amount;
      $('#total').html("<h3>Total Due: $ "+final_total+"HKD</h3>");
      $('#basic_total').val(basic_subtotal);
      $('#discount_total').val(discount_amount);
      $('#repair_total').val(repair_amount);
      $('#final_total').val(final_total);
      $('#trans_total').val(trans_fee_amount);
      $('#chosen').val(selected);
      if(item_count>0){
        $('#buy_submit').attr("disabled",false);
      }
      else{
        $('#buy_submit').attr("disabled",true);
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
