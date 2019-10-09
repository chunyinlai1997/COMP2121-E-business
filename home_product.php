<?php
include_once 'config.php';
include_once 'token.php';
function print_product($sql){

$m_id = isloggedin();
$sqlp = mysql_query("$sql");  //get  products

$products_list = "";
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

	$print_btn = "";
	if($status=="in_stock"){
		$status = "In Stock";
		if($seller_id!=$m_id){
			$print_btn = "<a id='$product_id' class='hearting btn btn-outline-warning btn-lg rounded-circle pull-right mr-3 $active2' href='#' data-toggle='button' aria-pressed='$tg2'><i class='fa fa-heart-o'></i></a>
			<a id='$product_id' class='adding btn btn-outline-info btn-lg rounded-circle pull-right mr-7 $active' data-toggle='button' aria-pressed='$tg' href='#'><i class='fa fa-shopping-cart'></i></a>";
		}
	}
	else{
		if($seller_id!=$m_id){
			$print_btn = "<a id='$product_id' class='hearting btn btn-outline-warning btn-lg rounded-circle pull-right mr-3 $active2' href='#' data-toggle='button' aria-pressed='$tg2'><i class='fa fa-heart-o'></i></a>";
		}
	}

	include_once 'content.php';
	$stars = get_stars($seller_id);

	$products_list .= "
	<div class='col-12 col-sm-6 col-md-4 col-lg-2' style='margin-left:0px; margin-bottom:10px;'>
		<div class='card'>
			<div class='product-img'>
				<img class='card-img-top img-fluid rounded-0' src='$product_img' width='60' height='60' alt='Card image cap'>
				<div class='card-img-overlay px-0'>
					$print_btn
					<a href='' id='$product_id' class='view_details' data-toggle='modal' data-target='#view_content'><h2 class='badge badge-danger rounded-0' style='font-size:1.5em;'>VIEW</h2></a>
				</div>
			</div>
			<div class='card-body'>
				<h5 class='card-text'>$model_name</h5>
				<p class='card-text'>Brand: $brand</p>
				<p class='card-text'>From: $full_name<br/><small>Rating:</small>$stars</p>
				<h6 class='card-text'><strong>Price: $$price</strong><h6><small class='card-text' style='text-decoration:line-through;' disabled>standard: $$re_price</small>
				<h2 style='font-size:1.5em;' class='badge badge-pill badge-primary'>$status</h2>$auth_label
				<br>
			</div>
		</div>
	</div>
	";
}


return array($products_list,$count);

}

if(isset($_POST['sql'])){
	$sql = $_POST['sql'];
	$m_id = isloggedin();
	$sqlp = mysql_query("$sql");  //get  products

	$products_list = "";
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

		$print_btn = "";
		if($status=="in_stock"){
			$status = "In Stock";
			if($seller_id!=$m_id){
				$print_btn = "<a id='$product_id' class='hearting btn btn-outline-warning btn-lg rounded-circle pull-right mr-3 $active2' href='#' data-toggle='button' aria-pressed='$tg2'><i class='fa fa-heart-o'></i></a>
				<a id='$product_id' class='adding btn btn-outline-info btn-lg rounded-circle pull-right mr-7 $active' data-toggle='button' aria-pressed='$tg' href='#'><i class='fa fa-shopping-cart'></i></a>";
			}
		}
		else{
			if($seller_id!=$m_id){
				$print_btn = "<a id='$product_id' class='hearting btn btn-outline-warning btn-lg rounded-circle pull-right mr-3 $active2' href='#' data-toggle='button' aria-pressed='$tg2'><i class='fa fa-heart-o'></i></a>";
			}
		}

		include_once 'content.php';
		$stars = get_stars($seller_id);

		$products_list .= "
		<div class='col-12 col-sm-6 col-md-4 col-lg-2' style='margin-left:0px; margin-bottom:10px;'>
			<div class='card'>
				<div class='product-img'>
					<img class='card-img-top img-fluid rounded-0' src='$product_img' width='60' height='60' alt='Card image cap'>
					<div class='card-img-overlay px-0'>
						$print_btn
						<a href='' id='$product_id' class='view_details' data-toggle='modal' data-target='#view_content'><h2 class='badge badge-danger rounded-0' style='font-size:1.5em;'>VIEW</h2></a>
					</div>
				</div>
				<div class='card-body'>
					<h5 class='card-text'>$model_name</h5>
					<p class='card-text'>Brand: $brand</p>
					<p class='card-text'>From: $full_name<br/><small>Rating:</small>$stars</p>
					<h6 class='card-text'><strong>Price: $$price</strong><h6><small class='card-text' style='text-decoration:line-through;' disabled>standard: $$re_price</small>
					<h2 style='font-size:1.5em;' class='badge badge-pill badge-primary'>$status</h2>$auth_label
					<br>
				</div>
			</div>
		</div>
		";
	}


$array = array($products_list,$count);
echo json_encode($array);

}

?>
