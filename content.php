<?php
include_once 'config.php';
include_once 'token.php';

$m_id = isloggedin();

if(isset($_POST['get'])){
	$pid = $_POST['get'];
	$sql1 = mysql_query("SELECT description,price,product_image1,product_image2,product_image3,product_image4,product_image5,product_3dview,STATUS,auth_number,post_date,seller_id,color  FROM product WHERE product_id = '$pid'");
	$row1 = mysql_fetch_array($sql1,MYSQL_NUM);
	$sql2 = mysql_query("SELECT model_name, product_type  FROM accept_product WHERE product_id = '$pid'");
	$row2 = mysql_fetch_array($sql2,MYSQL_NUM);
	$model_name = $row2[0];
	$product_type = $row2[1];
	$seller_id = $row1[11];

	$stars = get_stars($seller_id);

	$sql3 = "";
	if($product_type=="bag"){
		$sql3 = mysql_query("SELECT brand,recommended_price,release_year,size,measurement FROM bag WHERE model_name = '$model_name'");
	}
	else{
		$sql3 = mysql_query("SELECT brand,color,recommended_price,size,measurement FROM accessories WHERE model_name = '$model_name'");
	}
	$row3 = mysql_fetch_array($sql3,MYSQL_NUM);
	$sql4 = mysql_query("SELECT profileimg,firstname,lastname FROM member WHERE m_id = '$seller_id'");
	$row4 = mysql_fetch_array($sql4,MYSQL_NUM);
	$seller_name = $row4[1]." ".$row4[2];
	$profile_pic = $row4[0];

	$sql5 = mysql_query("SELECT condition_description, status, quality FROM check_record WHERE product_id = '$pid'");
	$row5 = mysql_fetch_array($sql5,MYSQL_NUM);

	$sql_check_cart = mysql_query("SELECT COUNT(*) FROM shopping_cart WHERE product_id = '$pid' AND m_id ='$m_id'");
	$sql_check_wish = mysql_query("SELECT COUNT(*) FROM wishlist WHERE product_id = '$pid' AND m_id ='$m_id'");
	$wish_row = mysql_fetch_array($sql_check_wish,MYSQL_NUM);
	$cart_row = mysql_fetch_array($sql_check_cart,MYSQL_NUM);

	$status = $row1[8];
	$status_btn = "";

	if($seller_id!=$m_id){
		if($status=="in_stock"){
			$status = "In Stock";
			if($cart_row[0]==0){
				$status_btn = "<a class='adding2 btn btn-primary ' href='' id='$pid' role='button'>Add to Cart</a>";
			}
			else{
				$status_btn = "<a class='delete btn btn-primary ' href='' id='$pid' role='button'>Remove from Cart</a>";
			}
		}
		else{
			if($wish_row[0]==0){
				$status_btn = "<a class='hearting btn btn-warning ' href='' id='$pid' role='button'>Add to Wishlist</a>";
			}
			else{
				$status_btn = "<a class='delete2 btn btn-warning ' href='' id='$pid' role='button'>Remove from Wishlist</a>";
			}
		}
	}

	$expend_quality = "";
	$auth_label = "";
	if($row5[1]=="checked"){
		$expend_quality = "<div class='col-12 col-sm-6 col-md-6'><hr>
					<h5>Authentication Record</h5>
					<h6>Expert Comment: $row5[0]</h6>
					<h6>Status: $row5[1] </h6>
					<h6>Quality: $row5[2] </h6>
					<p></p>
				</div>
				";
		$auth_label = "<h3 style='font-size:1.5em;' class='badge badge-pill badge-success'><i class='fa fa-check-circle' aria-hidden='true'></i>Checked</h3>";
	}
	else if($row5[1]=="waiting"){
		$expend_quality = "<div class='col-12 col-sm-6 col-md-6'>
					<hr><p>Authentication check is in progress.</p>
				</div>
				";
		$auth_label = "<h3 style='font-size:1.5em;' class='badge badge-pill badge-secondary'><i class='fa fa-spinner' aria-hidden='true'></i> In progress</h3>";
	}
	else if($row5[1]=="checking"){
		$expend_quality = "<div class='col-12 col-sm-6 col-md-6'>
					<hr><p>Authentication check is in progress.</p>
				</div>
				";
		$auth_label = "<h3 style='font-size:1.5em;' class='badge badge-pill badge-secondary'><i class='fa fa-spinner' aria-hidden='true'></i> In progress</h3>";
	}
	else{
		$expend_quality = "<div class='col-12 col-sm-6 col-md-6'>
					<hr><p>No Authentication Record can be provided</p>
				</div>
				";
	}
	$auth = "";
	if($row1[9]!=""||$row1[9]!=null){
		$auth = "	<h6>Authority Number: $row1[9]</h6>
	";
	}

	$p2="";
	$p3="";
	$p4="";
	$p5="";
	$td="";
	$cp1 = "<div class='carousel-item active'><img class='d-block w-100' src='$row1[2]'></div>";
	$cp2 ="";
	$cp3 ="";
	$cp4 ="";
	$cp5 ="";

	if($row1[3]!=""){
		$p2="
		<div class='col-12 col-md-6'>
			<img src='$row1[3]' width='160' height='150'>
		</div>
		";
		$cp2 ="<div class='carousel-item'><img class='d-block w-100' src='$row1[3]'></div>";
	}
	if($row1[4]!=""){
		$p3="
		<div class='col-12 col-md-6'>
			<img src='$row1[4]' width='160' height='150'>
		</div>
		";
		$cp3 ="<div class='carousel-item'><img class='d-block w-100' src='$row1[4]'></div>";
	}
	if($row1[5]!=""){
		$p4="
		<div class='col-12 col-md-6'>
			<img src='$row1[5]' width='160' height='150'>
		</div>
		";
		$cp4 ="<div class='carousel-item'><img class='d-block w-100' src='$row1[5]'></div>";
	}
	if($row1[6]!=""){
		$p5="
		<div class='col-12 col-md-6'>
			<img src='$row1[6]' width='160' height='150'>
		</div>
		";
		$cp5 ="<div class='carousel-item'><img class='d-block w-100' src='$row1[6]'></div>";
	}
	if($row1[7]!=""){
		$td="
		<div class='col-12 col-md-6'>
		<iframe style='border: 0;' src='https://api.cappasity.com/api/player/48783922-a97f-48aa-93e0-c98d72709285/embedded?autorun=0&closebutton=1&hidecontrols=0&logo=1&hidefullscreen=1' width='200' height='200' allowfullscreen='allowfullscreen'></iframe>
		</div>
		";
	}



	$output ="

	<div class='modal-body'>
		<div class='col-12' id='product_view_content' style='text-decoration: none;'>
			<div class='row'>
			<h2 style='font-size:1.5em;' class='badge badge-pill badge-primary'>$status</h2>
			$auth_label
			</div>

			<div class='row'>
				<div class='col-12 col-sm-6 col-md-6'>
				<div id='carouselExampleControls' class='carousel slide' data-ride='carousel'>
					<div class='carousel-inner'>
						$cp1$cp2$cp3$cp4$cp5
					</div>
					<a class='carousel-control-prev' href='#carouselExampleControls' role='button' data-slide='prev'>
					 <span class='carousel-control-prev-icon' aria-hidden='true'></span>
					 <span class='sr-only'>Previous</span>
					</a>
					<a class='carousel-control-next' href='#carouselExampleControls' role='button' data-slide='next'>
					 <span class='carousel-control-next-icon' aria-hidden='true'></span>
					 <span class='sr-only'>Next</span>
					</a>
					</div>
				</div>

				<div class='col-12 col-sm-6 col-md-6'>
				  <h4>Model: <a style='color: blue;' href='shop_model?model_name=$model_name'  target='_blank'>$model_name</a></h4>
					<h6>Brand: <a href='shop_brand?brand=$row3[0]' target='_blank'>$row3[0]</a></h6>
					<h6>Color: $row1[12]</h6>
					<h6>Size: $row3[3]</h6>
					<h6>Measurement: $row3[4]</h6>
					<h6>Release Year: $row3[2]</h6>
					<hr>
					<h6>Price: $$row1[1] HKD</h6>
					<h6>Post Date: $row1[10]</h6>
					$auth
					<h6>Description:</h6><br/><p> $row1[0]</p>
				</div>

				<br>
				$expend_quality
				<br>
				<div class='col-12 col-sm-6 col-md-6'>
					<hr>
					<h5>Seller Details</h5>
					<div class='row'>
						<div class='col-3'><img src='$profile_pic' width='50' height='50'/></div>
						<div class='col-9'>
							<h6>Name: <a href='user_profile?m_id=$seller_id' style='color: blue;'>$seller_name</a></h6>
							<h6>Rating: $stars </h6>
						</div>
					</div>
				</div>
				<div class='col-12'>
					$td
				</div>
		</div>
	</div>
  <div class='modal-footer'>
	$status_btn
	<button id='close' type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
  </div>
	";
	echo $output;
}

	function get_stars($seller_id){
		$full ="<i class='fa fa-star' aria-hidden='true'></i>";
		$empty = "<i class='fa fa-star-o' aria-hidden='true'></i>";
		$sql_star = mysql_query("SELECT rating from seller WHERE m_id = '$seller_id'");
		$rating = mysql_fetch_array($sql_star,MYSQL_NUM);
		$stars = str_repeat($full, $rating[0]);
	  $stars_o = str_repeat($empty, (5-$rating[0]));
		return $stars.$stars_o;
	}
?>
