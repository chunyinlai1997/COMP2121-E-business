<?php
	include_once 'config.php';
	include_once 'token.php';
	//mysql_query("UPDATE member SET profileimg = 'profile.png'");
	//mysql_query("ALTER TABLE member ADD profileimg VARCHAR(225);")or die(mysql_error());
	//$sql= mysql_query("SELECT COUNT(*) FROM seller")or die(mysql_error());
/*
	$result = mysql_query("SHOW COLUMNS FROM product");
	while($row = mysql_fetch_array($result)){
		echo $row['Field']."<br>";
	}
	$result = mysql_query("SHOW COLUMNS FROM accept_product");
	while($row = mysql_fetch_array($result)){
		echo $row['Field']."<br>";
	}
	$result = mysql_query("SHOW COLUMNS FROM bag");
	while($row = mysql_fetch_array($result)){
		echo $row['Field']."<br>";
	}

	//mysql_query("DELETE FROM product WHERE price = 1500 ");
	//mysql_query("DELETE FROM accept_product WHERE type = 1500 ");

$result = mysql_query("SELECT recommended_price,bag_id FROM bag");
while($row = mysql_fetch_array($result,MYSQL_NUM)){
	$new = $row[0] * 7.78;
	$new = round($new, -2);
	$bag = $row[1];
	mysql_query("UPDATE bag SET recommended_price=$new WHERE bag_id = $bag");
}
*/
if(isset($_POST['Submit'])){
	$imagelink1 = "";
	$imgurURL = "https://api.imgur.com/3/image";
	if(file_exists($_FILES['photo']['tmp_name']) || is_uploaded_file($_FILES['photo']['tmp_name'])) {
			$image1 = base64_encode(file_get_contents($_FILES['photo']['tmp_name']));
			$options = array('http'=>array(
			 'method'=>"POST",
			 'header'=>"Authorization: Bearer 9d80a5579bea50b9dbdaad0528ee66d08da6ecca\n"."Content-Type: application/x-ww-form-urlencoded",
			 'content'=>$image1
			));
			$context = stream_context_create($options);
			$response = file_get_contents($imgurURL, false, $context);
			$res = json_decode($response);
			$imagelink1 = $res->data->link;
	}

	$type = $_POST['product_type'];
	$model = $_POST['model_name'];
	$color = $_POST['color'];

	if($type=="bag"){
		$q = mysql_query("SELECT bag_id FROM bag WHERE model_name = '$model'");
		$rowq = mysql_fetch_array($q,MYSQL_NUM);
		$bid = $rowq[0];
		mysql_query("UPDATE bag_color SET product_image = '$imagelink1' WHERE bag_color = '$color' AND bag_id = '$bid' ");
	}
	else{
		mysql_query("UPDATE accessories SET product_image = '$imagelink1' WHERE model_name = '$model'");
	}
	header("Refresh:0");
}

if(isset($_POST['run_sql'])){
	$text = $_POST['sql'];
	mysql_query("$text");
	header("Refresh:0");
}

?>
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Just a frame made by Willon hahaha | Here is the discription">
		<meta name="keywords" content="HTML,CSS,PHP,Bootstrap,COMP,Project,polyu,comp,COMP,PolyU,Hong Kong,luxury,LUXTOT0TRADE">
		<meta name="author" content="Willon Lai">
		<title> Become Seller | LuxToTrade COMP2121 Project</title>
		<link rel="icon" href="https://cdn3.iconfinder.com/data/icons/business-office-2/512/tag-512.png" >
		<link rel="icon" href="https://cdn3.iconfinder.com/data/icons/business-office-2/512/tag-512.png" >
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<link rel="stylesheet" href="css/animate.css" />
		<link rel="stylesheet" href="css/waypoints.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="js/scroll.js"></script>
		<script src="js/waypoints.js"></script>
		<script src="js/waypoints.min.js"></script>
		<script type="text/javascript" src="js/validate3.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</head>
<body>
	<form action="bruteforce.php" method="POST" style="margin-bottom:150px;" enctype="multipart/form-data">

	<div class="wrap">
	<fieldset class="col-md-10 offset-md-1">
	<div class="form-top">
		<div class="form-top-left">
			<h1>Easy Upload Panel</h1>
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
				<select  class="form-control" id="brand" name="brand"  required>
				</select>
			</div>
			<div class="form-group col-sm-6 pb-3">
				<label for="model_name">Model Name</label>
				<select  class="form-control" id="model_name" name="model_name"  required>
				</select>
			</div>
			<div class="form-group col-sm-6 pb-3">
				<label for="color">Color</label>
				<select  class="form-control" id="color" name="color"  required>
				</select>
			</div>
			<div class="col-sm-3">
				<label class="file">
					Product Image<input type="file" id="photo" name="photo" required>
					<span class="file-custom" data-content="Choose file..."></span>
				</label>
			</div>
			<div class="col-sm-12">
			<button type="submit" name="Submit" id="Submit" value="Submit" class="btn btn-success">Submit</button>
		 </div>
 </form>

 <br>
 <h4 class="m-y-2">Bag Photos</h4>
 <div class="table-responsive" id="bag">
		<table class="table table-bordered">
			 <tr>
				  <th class="tablep">BAG ID</th>
					<th class="tablep">BAG Model Name</th>
					<th class="tablep">BAG color</th>
					<th class="tablep">iamge_link</th>
			 </tr>
			 <?php
			 $sq2 = mysql_query("SELECT bag_color.bag_id,bag_color.bag_color,bag_color.product_image,bag.model_name FROM bag_color, bag WHERE bag_color.bag_id = bag.bag_id ORDER BY  bag_id ");
			 while($row1 = mysql_fetch_array($sq2,MYSQL_NUM))
			 {
			 ?>
			 <tr>
					<td><?php echo $row1[0]; ?></td>
					<td><?php echo $row1[3]; ?></td>
					<td><?php echo $row1[1]; ?></td>
					<td><img src="<?php echo $row1[2]; ?>" width="50" height="50"/></td>
			 </tr>
			 <?php
			 }
			 ?>
		</table>
 </div>

 <h4 class="m-y-2">Accessories Photos</h4>
 <div class="table-responsive" id="bag">
		<table class="table table-bordered">
			 <tr>
				  <th class="tablep">Accessories ID</th>
					<th class="tablep">Accessories Model Name</th>
					<th class="tablep">Accessories Type</th>
					<th class="tablep">iamge_link</th>
			 </tr>
			 <?php
			 $sql = mysql_query("SELECT accessories_id,product_image,model_name,item_type FROM accessories");
			 while($row1 = mysql_fetch_array($sql,MYSQL_NUM)) {
			 ?>
			 <tr>
			 	<td><?php echo $row1[0]; ?></td>
				<td><?php echo $row1[2]; ?></td>
				<td><?php echo $row1[3]; ?></td>
				<td><img src="<?php echo $row1[1]; ?>" width="50" height="50"/></td>
			 </tr>
			 <?php
			 }
			 ?>
		</table>
 </div>


 <script>
 jQuery.noConflict();
 $(document).ready(function(){
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
 		//checking();
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
 		//checking();
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
 			document.getElementById("model_name").classList.add('is-invalid');
 			document.getElementById("model_name").classList.remove('is-valid');
 		}
 		else{
 			get_color(model,type);
 			document.getElementById("model_name").classList.add('is-valid');
 			document.getElementById("model_name").classList.remove('is-invalid');
 		}
 		//checking();
 	});

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
 });
 </script>

 <form action="bruteforce" method='POST'>
	 <div class="table-responsive">
	 <input type='text' clas='form-control' name='sql'/>
	 <button type='submit' name='run_sql' value='run_sql'>Run SQL</button>
   </div>
 </form>
 <br>
 <h4 class="m-y-2">Payment Record</h4>
 <div class="table-responsive" id="bag">
		<table class="table table-bordered">
			 <tr>
				  <th class="tablep">Payment ID</th>
					<th class="tablep">Payment Type</th>
					<th class="tablep">Order ID</th>
					<th class="tablep">Amount</th>
					<th class="tablep">Buyer ID</th>
					<th class="tablep">Pay Date</th>
					<th class="tablep">cc num</th>
					<th class="tablep">pay status</th>
			 </tr>
			 <?php
			 $sql = mysql_query("SELECT payment_id, payment_type, order_id,amount,buyer_id,pay_date,cc_num,unpaid FROM payment_b");
			 while($row1 = mysql_fetch_array($sql,MYSQL_NUM)) {
			 ?>
			 <tr>
			 	<td><?php echo $row1[0]; ?></td>
				<td><?php echo $row1[1]; ?></td>
				<td><?php echo $row1[2]; ?></td>
				<td><?php echo $row1[3]; ?></td>
				<td><?php echo $row1[4]; ?></td>
				<td><?php echo $row1[5]; ?></td>
				<td><?php echo $row1[6]; ?></td>
				<td><?php echo $row1[7]; ?></td>
			 </tr>
			 <?php
			 }
			 ?>
		</table>

		 <iframe style="border: 0;" src="https://api.cappasity.com/api/player/48783922-a97f-48aa-93e0-c98d72709285/embedded?autorun=0&closebutton=1&hidecontrols=0&logo=1&hidefullscreen=1" width="50%" height="300" allowfullscreen="allowfullscreen"></iframe>

		 <?php
		 include_once 'content.php';
		 	echo get_stars(37);
		 ?>


 <?php
 $m_id = isloggedin();
 $sql = "SELECT DISTINCT product.product_id,product.price,product.product_image1,product.description,product.STATUS,product.post_date,product.seller_id
 											FROM product,check_record WHERE check_record.product_id = product.product_id
 											AND (product.STATUS ='in_stock' OR product.STATUS = 'arriving')
 											AND (check_record.action !='invalid' OR check_record.action !='need_change')
 											ORDER BY product.STATUS DESC, product.post_date DESC, check_record.status ASC";  //get all products



 $sqlp = mysql_query("$sql");  //get  products

 $output = "<div class='row list-unstyled'>";
 $count = 0;
 while($rowp = mysql_fetch_array($sqlp,MYSQL_NUM)){
 	$count +=1;
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
 	$sqlp4 = mysql_query("SELECT username FROM member WHERE m_id = '$seller_id' ");
 	$seller_detail = mysql_fetch_array($sqlp4,MYSQL_NUM);

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

 	$sql5 = mysql_query("SELECT status,quality FROM check_record WHERE product_id = '$product_id'");
 	$row5 = mysql_fetch_array($sql5,MYSQL_NUM);

 	$print_btn = "";
 	if($status=="in_stock"){
 		if($seller_id!=$m_id){
 			$status = "In Stock";
 			$print_btn = "<a id='$product_id' class='hearting btn btn-outline-warning  rounded-circle mr-3 $active2' href='#' data-toggle='button' aria-pressed='$tg2'><i class='fa fa-heart-o'></i></a>
 			<a id='$product_id' class='adding btn btn-outline-info  rounded-circle mr-7 $active' data-toggle='button' aria-pressed='$tg' href='#'><i class='fa fa-shopping-cart'></i></a>";
 		}
 	}
 	else{
 		if($seller_id!=$m_id){
 			$print_btn = "<a id='$product_id' class='hearting btn btn-outline-warning rounded-circle mr-3 $active2' href='#' data-toggle='button' aria-pressed='$tg2'><i class='fa fa-heart-o'></i></a>";
 		}
 	}

 	include_once 'content.php';
 	$stars = get_stars($seller_id);

	$output .= "
	<div class='media col-12 col-sm-12 col-md-6 col-lg-4' style='margin-bottom:15px;'>
	<div class='row'>
		<div class='col-4'>
			<div class='row'>
				<div class='col-12'>
				<img class='d-flex mr-3' src='$product_img' width='100' height='100'>
				</div>
				<div class='col-12'>
				$print_btn
				</div>
			</div>
		</div>
		<div class='col-8'>
			<div class='media-body d-flex'>
				<div class='mr-auto'>
					<h5><a href=''>$model_name</a></h5>
					<h6 class='mb-0 t'>Brand: $brand</h6>
					<p>Seller:<a href='userprofile?username=$seller_detail[0]'>$seller_detail[0]</a> $stars</p>
					<h6 class='mb-0 t'>$$price HKD  </h6>

					<h6 style='font-size:1em;' class='badge badge-pill badge-primary'>$status</h6>
					<a href='' id='$product_id' class='view_details' data-toggle='modal' data-target='#view_content'><h6 class='badge badge-danger rounded-0' style='font-size:1.5em;'>VIEW</h6></a>
				</div>
			</div>
		</div>
	</div>
 </div>
 ";
 }

 $output .="	</div><hr>";

	 $m_id = isloggedin();
	 $check = mysql_query("SELECT COUNT(*) FROM orders WHERE buyer_id = '$m_id' ");
	 $num = mysql_fetch_array($check,MYSQL_NUM);
	 echo $num;
 ?>

 </div>


</body>
</html>
