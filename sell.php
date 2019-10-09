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

if(!isseller()){
	header('Location:become_seller');
}

if(!cansell()){
	header("Location:home?cant=true");
}

$m_id = isloggedin();

$sql = mysql_query("SELECT profileimg,username,joindate,email,firstname,lastname,phone,address,country FROM member WHERE m_id = '$m_id' ");
$row = mysql_fetch_array($sql,MYSQL_NUM);


?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Just a frame made by Willon hahaha | Here is the discription">
		<meta name="keywords" content="HTML,CSS,PHP,Bootstrap,COMP,Project,polyu,comp,COMP,PolyU,Hong Kong,luxury,LUXTOT0TRADE">
		<meta name="author" content="Willon Lai">
		<title>Sell Product | LuxToTrade COMP2121 Project</title>
		<link rel="icon" href="images/brand_logo_small_icon.png" >
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
			margin-top:80px;
			padding-left : 50px;
			padding-right : 50px;
			width:100%;
		}
		.modal-backdrop
		{
			opacity:1 !important;
		}

		.file-custom:after {
		    content: attr(data-content);
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
						<a class="nav-link" href="guideline">Back</a>
					</li>
				</ul>
				 <!-- Search form -->
				<ul class="navbar-nav ml-auto nav-flex-icons row">
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
		<form action="sell_process.php" method="POST" style="margin-bottom:150px;" enctype="multipart/form-data">
		<div class="wrap">

		<fieldset class="col-md-10 offset-md-1">
		<div class="form-top">
			<div class="form-top-left">
				<div class="progress">
					<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33.3%;">Progress:33%</div>
				</div>
				<h1 id="ind">Sell Product Form</h1>
				<small style="font-size:80%;">Sell you luxury product now !</small>
			</div>
		</div>
		<div class="form-bottom">
			<div class="row mt-4">
				<div class="form-group col-sm-6 pb-3">
					<label for="product_type">Product Type</label>
					<select class="form-control" id="product_type" name="product_type">
						<option value="blank">Choose a product type</option>
						<option value="bag">bag</option>
						<option value="accessories">accessories</option>
					</select>
				</div>
				<div class="form-group col-sm-6 pb-3">
					<label for="brand">Brand</label>
					<select  class="form-control" id="brand" name="brand" disabled required>
					</select>
					<small class="text-muted">
						Can't find your brand? Please<a href="contact"> Contact Us</a>.
					</small>
				</div>
				<div class="form-group col-sm-6 pb-3">
					<label for="model_name">Model Name</label>
					<select  class="form-control" id="model_name" name="model_name" disabled required>
					</select>
					<small class="text-muted">
						Can't find your model? Please<a href="contact"> Contact Us</a>.
					</small>
				</div>
				<div class="form-group col-sm-3 pb-3">
					<label for="color">Color</label>
					<select  class="form-control" id="color" name="color" disabled required>
					</select>
				</div>
				<div class="form-group col-sm-3 pb-3">
					<label for="auth_number">Authorised number</label>
					<input type="text" class="form-control" id="auth_number" name="auth_number" placeholder="OPTIONAL" disabled>
          <small class="text-muted">
					  Please input the authorised number of your product.
					</small>
				</div>
				 <div class="form-group col-sm-5 pb-3">
					<label for="price">Price</label>
					<div class="input-group">
						<span class="input-group-addon">$</span>
						<input type="text" class="form-control" id="price" name="price" placeholder="" required disabled>
						<span class="input-group-addon">HKD</span>
				  </div>
					<p id="p1" class="text-muted">
					  Please set a price for your product.
					</p>
				</div>
				<div class="form-group col-sm-7 pb-3">
					<label for="plan">LuxPrime Service</label>
					<select class="form-control" id="plan" name="plane">
						<option value="qc" selected>Authentication service + 3D Scanning Bundle</option>
						<option value="3d">3D Scanning only</option>
						<option value="not_need">Don't need any LuxPrime Service.</option>
					</select>
				</div>
				<div class="form-group col-md-12 pb-3" style="height:100px;">
					<label for="description">Description</label>
					<textarea class="form-control" id="description" name="description" placeholder="Introduce your product briefly." required  disabled></textarea>
				</div>
			</div>
			<div class="row mt-4">
					<div class="form-group col-sm-12 pb-3">
						<label for="photo1">Upload 5 product photos from different angles. (at least a front image)</label>
					</div>
					<div class="col-12 col-sm-6 col-md-4">
						<label class="file">
						  Front Image<input type="file" id="photo1" name="photo1">

						</label>

					</div>
					<div class="col-12 col-sm-6 col-md-4">
						<label class="file">
						  Side Image<input type="file" id="photo2" name="photo2">

						</label>
					</div>
					<div class="col-12 col-sm-6 col-md-4">
						<label class="file">
						  Side Image <input type="file" id="photo3" name="photo3">

						</label>
					</div>
						<div class="col-12 col-sm-6 col-md-4">
							<label class="file">
							  Side Image<input type="file" id="photo4" name="photo4">

							</label>
						</div>
						<div class="col-12 col-sm-6 col-md-4">
							<label class="file">
							  Side Image<input type="file" id="photo5" name="photo5">
							</label>
						</div>
					</div>

			</div>
			<div class="row mt-4" id="add_reply">
			</div>
			<input type="hidden" id="amount" name="amount" value="">
			<input type="hidden" id="post_date" name="post_date" value="">
			<input type="hidden" id="payplan" name="payplan" value="">
			<div class="row mt-4">
				<button type="button" class="btn btn-outline-info btn-lg" id="preview_btn" data-toggle="modal" data-target="#previewmodal" disabled>Preview</button>
			</div>
		</div>
  </fieldset>
  </div>

<div class="modal fade" id="previewmodal" tabindex="-1" role="dialog" aria-labelledby="previewcontent" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="previewcontent">Preview Your Selling Item</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true"></span>
			</button>
			</div>
			<div class="modal-body">
					<div class='col-12' id='product_view_content' style='text-decoration: none;'>
						<h6 style='color: blue;' id="t"></h6>
						<div class='row'>
							<div class='col-6'>
								<p id="e"></p>
								<p id="r"></p>
								<p id="w"></p>
								<p id="c"></p>
							</div>
							<div class='col-6'>
								<p ></p>
								<p id="y"></p>
								<p id="u"></p>
								<p id="pdate"></p>
							</div>
							<br>
							</div>
							<div class="row">
							<p id="q"></p>
							</div>
					</div>
					<div class='col-12' id='pay_table'>
					<hr>
					<h6>Payment</h6>
					<table class='col-12'>
						<tr class="text-center">
					    <th>Service</th>
					    <th>Fee</th>
					  </tr>
					  <tr  class="text-center" id="pay">
					  </tr>
					</table>
					</div>
					<hr>
					<div class='col-12'>
						<p>Please note, we will not accept:</p>
						<p>Inauthentic Items:</p>
						<ul>
						<li>Chanel, Louis Vuitton or Hermes brand with Missing or Illegible Interior Serial Codes</li>
						<li>Press Samples (When Marked)</li>
						<li>Employee/Sample Sale Items (When Marked)</li>
						<li>Outlet Items</li>
						<li>Hardsided Luggage over 60cm (Soft Foldable Luggage Over 60cm is Accepted)</li>
						<li>Items Refurbished by Company Other Than Original Manufacturer</li>
						<li>Broken or Missing Hardware</li>
						<li>Personal Monogramming or Artistic Personalization</li>
					</div>
					<div class='col-12'>
						<p>LuxPrime Service:</p>
						<ul>
						<li>All payment are not refundable after the item is posted.</li>
						</ul>
					</div>
					<hr>
					<div class='col-12'>
					You can then send your handbag to us after this submission for qulaity check or/and stocking. We can provide you with a free pickup (provided in Hong Kong and Taiwan), email you a pre-paid label, or send you a free shipping box with the label and packing supplies included to <?php echo $row[7]; ?>. Once we receive your items, we require 1-2 business days for our quality check and authentication processes.
					</div>
					<hr>
					<div class="form-check">
					  <label class="form-check-label">
					    <input class="form-check-input" id="confirm_box" type="checkbox" value="">
					     Please ticket to confirm the submission.
					     </label>
					</div>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="coupon_used" id="coupon_used" value="0"/>
				<button type="submit" name="btn-submit" id="btn-submit" value="btn-submit" class="btn btn-success" disabled>Submit</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</form>
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
	</body>
	<script>

	jQuery.noConflict();
	$(document).ready(function(){
		$("input[type=file]").change(function(){
		    var fieldVal = $(this).val();
		    if (fieldVal != undefined || fieldVal != "") {
		        $(this).next(".file-custom").attr('data-content', fieldVal);
		    }
		});

		$('#product_type').change(function(){
			var type = $('#product_type option:selected').text();
			if(type=="Choose a product type"){
				$('#brand').attr('disabled',true);
        document.getElementById("product_type").classList.add('is-invalid');
				document.getElementById("product_type").classList.remove('is-valid');
			}
			else{
				$('#brand').attr('disabled',false);
        document.getElementById("product_type").classList.add('is-valid');
				document.getElementById("product_type").classList.remove('is-invalid');
				get_brand(type);
			}
			checking();
		});

		function get_brand(type){
			$.ajax({
				url:"fetch2.php",
				method:"POST",
				data:{type:type},
				success:function(data){
					$('#brand').html(data);
				}
			});
		}

		$('#brand').change(function(){
			var brand = $('#brand option:selected').text();
			var type = $('#product_type option:selected').text();
			if(brand=="Select brand..."||type=="Choose a product type"){
				$('#model_name').attr('disabled',true);
        document.getElementById("brand").classList.add('is-invalid');
				document.getElementById("brand").classList.remove('is-valid');
			}
			else{
				$('#model_name').attr('disabled',false);
				get_model(type,brand);
        document.getElementById("brand").classList.add('is-valid');
        document.getElementById("brand").classList.remove('is-invalid');
			}
			checking();
		});

		function get_model(type,brand){
			$.ajax({
				url:"fetch2.php",
				method:"POST",
				data:{get_model:"",type2:type,brand2:brand},
				success:function(data2){
					$('#model_name').html(data2);
				}
			});
		}

		$('#model_name').change(function(){
			var model = $('#model_name option:selected').text();
			var brand = $('#brand option:selected').text();
			var type = $('#product_type option:selected').text();
			if(brand=="Select brand..."||type=="Choose a product type"||model=="Select model..."){
        $('#auth_number').attr('disabled',true);
				$('#price').attr('disabled',true);
				$('#description').attr('disabled',true);
				$('#color').attr('disabled',true);
        document.getElementById("model_name").classList.add('is-invalid');
				document.getElementById("model_name").classList.remove('is-valid');
			}
			else{
        $('#auth_number').attr('disabled',false);
				$('#price').attr('disabled',false);
				$('#description').attr('disabled',false);
				$('#color').attr('disabled',false);
				get_prices(model,type);
				get_color(model,type);
        document.getElementById("model_name").classList.add('is-valid');
        document.getElementById("model_name").classList.remove('is-invalid');
			}
			checking();
		});

		function get_prices(model,type){
			$.ajax({
				url:"fetch2.php",
				method:"POST",
				data:{get_price:"",model3:model,type3:type},
				success:function(price){
						$('#p1').html(price);
				}
			});
			checking();
		}

		function get_color(model,type){
			$.ajax({
				url:"fetch2.php",
				method:"POST",
				data:{get_color:"",type5:type,model5:model},
				success:function(data){
					$('#color').html(data);
				}
			});
		}

    $('#price').keyup(function(){
      var price = $('#price').val();
      if(price<=100){
        document.getElementById("price").classList.add('is-invalid');
        document.getElementById("price").classList.remove('is-valid');
      }
      else{
        document.getElementById("price").classList.add('is-valid');
        document.getElementById("price").classList.remove('is-invalid');
      }
			checking();
    });

		$('#auth_number').keyup(function(){
      var auth = $('#auth_number').val().length;
      if(auth<2 || auth>10){
        document.getElementById("auth_number").classList.add('is-invalid');
        document.getElementById("auth_number").classList.remove('is-valid');
      }
      else{
        document.getElementById("auth_number").classList.add('is-valid');
        document.getElementById("auth_number").classList.remove('is-invalid');
      }
			checking();
    });

    $('#description').on('keyup', function(){
      var description = $('#description').val().length;
      if(description<10 || description>255){
        document.getElementById("description").classList.add('is-invalid');
        document.getElementById("description").classList.remove('is-valid');
      }
      else{
        document.getElementById("description").classList.add('is-valid');
        document.getElementById("description").classList.remove('is-invalid');
      }
			checking();
    });

		$("#photo1").change(function () {
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("Only formats are allowed : "+ fileExtension.join(', '));
						document.getElementById("photo1").classList.add('is-invalid');
		        document.getElementById("photo1").classList.remove('is-valid');
        }
				else{
						document.getElementById("photo1").classList.add('is-valid');
						document.getElementById("photo1").classList.remove('is-invalid');
				}
				checking();
    });

		$("#photo2").change(function () {
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("Only formats are allowed : "+ fileExtension.join(', '));
						document.getElementById("photo2").classList.add('is-invalid');
		        document.getElementById("photo2").classList.remove('is-valid');
        }
				else{
						document.getElementById("photo2").classList.add('is-valid');
						document.getElementById("photo2").classList.remove('is-invalid');
				}
				checking();
    });

		$("#photo3").change(function () {
				var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
				if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
						alert("Only formats are allowed : "+ fileExtension.join(', '));
						document.getElementById("photo3").classList.add('is-invalid');
						document.getElementById("photo3").classList.remove('is-valid');
				}
				else{
						document.getElementById("photo3").classList.add('is-valid');
						document.getElementById("photo3").classList.remove('is-invalid');
				}
				checking();
		});

		$("#photo4").change(function () {
				var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
				if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
						alert("Only formats are allowed : "+ fileExtension.join(', '));
						document.getElementById("photo4").classList.add('is-invalid');
						document.getElementById("photo4").classList.remove('is-valid');
				}
				else{
						document.getElementById("photo4").classList.add('is-valid');
						document.getElementById("photo4").classList.remove('is-invalid');

				}
				checking();
		});

		$("#photo5").change(function () {
				var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
				if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
						alert("Only formats are allowed : "+ fileExtension.join(', '));
						document.getElementById("photo5").classList.add('is-invalid');
						document.getElementById("photo5").classList.remove('is-valid');
				}
				else{
						document.getElementById("photo5").classList.add('is-valid');
						document.getElementById("photo5").classList.remove('is-invalid');
				}
				checking();
		});

		function checking(){
			var type = $('#product_type').hasClass("is-valid");
			var brand = $('#brand').hasClass("is-valid");
			var model = $('#model_name').hasClass("is-valid");
			var auth = $('#auth').hasClass("is-invalid");
			var price = $('#price').hasClass("is-valid");
			var description = $('#description').hasClass("is-valid");
			var photo1 = $('#photo1').hasClass("is-valid");
			var photo2 = $('#photo2').hasClass("is-invalid");
			var photo3 = $('#photo3').hasClass("is-invalid");
			var photo4 = $('#photo4').hasClass("is-invalid");
			var photo5 = $('#photo5').hasClass("is-invalid");
			var bool = (type && brand && model && !auth && price && description && price && photo1 && !photo2&&!photo3&&!photo4&&!photo5);
			if((bool)==true){
				$('#preview_btn').attr("disabled",false);
			}
			else {
				$('#preview_btn').attr("disabled",true);
			}
		}
		var clcik = 0;
		$('#btn-submit').on('click',function(){
			if(clcik==0){
				clcik+=1;
			}
			else{
				 event.preventDefault();
			}
		});
	});

	$('#preview_btn').on( "click", function() {
		var type = $('#product_type option:selected').text();
		var brand = $('#brand option:selected').text();
		var model = $('#model_name option:selected').text();
		var plan = $('#plan option:selected').text();
		var color = $('#color').val();
		var auth = $('#auth_number').val();
		var price = $('#price').val();
		var description = $('#description').val();
		var photo1 = $('#photo1').val();
		var photo2 = $('#photo2').val();
		var photo3 = $('#photo3').val();
		var photo4 = $('#photo4').val();
		var photo5 = $('#photo5').val();
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;
		var yyyy = today.getFullYear();
		var today = yyyy + '-' + mm + '-' + dd ;
		$('#pdate').html("Post Date: "+today);
		$('#post_date').val(today);
		$('#q').html("Description: "+ description);
		$('#w').html("Price: $"+price+"HKD");
		$('#e').html("Type: "+type);
		$('#r').html("Brand: "+brand);
		$('#c').html("Color: "+color);
		$('#t').html("Product Model:<br>"+model);
		$('#y').html("LuxPrime Service: "+plan);
		$('#u').html("Authorised Number: "+auth);
		var planval = $('#plan option:selected').val();
		$.ajax({
				url:"fetch2.php",
				method:"POST",
				data:{plan:planval,producttype:type},
				success:function(data){
					$('#pay').html("<td>"+plan+"</td><td>$"+data+" HKD</td>");
					$('#amount').val(data);
					$('#payplan').val(plan);
					if(data==0){
						$('#pay_table').css("display","none");
					}
					first_sale(data);
				}
		});
	});

	function first_sale(data){
		$.ajax({
			url:"coupon.php",
			method:"POST",
			data:{first_sale:data},
			success:function(data){
				if(data=="true"){
					$('#amount').val(0);
					$('#pay').append("</tr><tr><td>"+"First Sale Discount"+"</td><td>-$"+data+" HKD</td></tr>");
					$('#pay').append("<tr><td>"+"<strong>Total<strong>"+"</td><td>$ 0 HKD</td>");
					$('#coupon_used').val('1');
				}
			}
		});
	}

	$('#confirm_box').on('click',function(){
		if($(this).is(':checked')){
			$('#btn-submit').attr("disabled",false);
		}
		else{
			$('#btn-submit').attr("disabled",true);
		}
	});



	</script>
</html>
