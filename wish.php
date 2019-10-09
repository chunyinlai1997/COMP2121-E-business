<?php
include_once 'config.php';
include_once 'token.php';
if(!isloggedin()){
	header('Location:login.php?need_login=True');
}
$m_id = isloggedin();

if(isset($_POST['number'])){
	$sqlcart = mysql_query("SELECT product_id FROM wishlist WHERE m_id = '$m_id' ");
	$output = mysql_num_rows($sqlcart)." <i class='fa fa-heart'></i>";
	if($output==0){
		$output = "0 <i class='fa fa-heart' aria-hidden='true'></i>";
	}
	echo $output;
}

if(isset($_POST['wish'])){
	$sqlcart = mysql_query("SELECT product_id FROM wishlist WHERE m_id = '$m_id' ");
	$output = "<ul class='list-unstyled'>";
	$amount = 0;
	$check = 0;

	while($row = mysql_fetch_array($sqlcart,MYSQL_NUM))
	{
		$pid = $row[0];
		$sql = mysql_query("SELECT price,product_image1,seller_id,STATUS FROM product WHERE product_id = '$pid' ");
		$row2 = mysql_fetch_array($sql,MYSQL_NUM);
		$sql2 =  mysql_query("SELECT model_name,product_type FROM accept_product WHERE product_id = '$pid' ");
		$row3 = mysql_fetch_array($sql2,MYSQL_NUM);
		$sql3 = "";
		if($row3[1]=="bag"){
			$sql3= mysql_query("SELECT brand FROM bag WHERE model_name = '$row3[0]' ");
		}
		else{
			$sql3= mysql_query("SELECT brand FROM accessories WHERE model_name = '$row3[0]' ");
		}

		$row4 = mysql_fetch_array($sql3,MYSQL_NUM);

		$sql6 = mysql_query("SELECT member.firstname,member.lastname,member.m_id FROM member INNER JOIN seller ON member.m_id = seller.m_id AND seller.m_id =  '$row2[2]' ");

		$usn = mysql_fetch_array($sql6,MYSQL_NUM);

		$full_name = $usn[0]." ".$usn[1];

		$seller_id =  $usn[2];

		$status = $row2[3];
		if($status=="in_stock"){
      $status = "In Stock";
    }

		$output .= "
		<li class='media'>
		<img class='d-flex mr-3' src='$row2[1]' width='60' height='60'>
		<div class='media-body d-flex'>
		<div class='mr-auto'>
			<h5><a href='shop_model?model_name=$row3[0]'  target='_blank'>$row3[0]</a></h5>
			<h6 class='mb-0 t'>Brand: <a href='shop_brand?brand=$row4[0]' target='_blank'>$row4[0]</a></h6>
			<small>Seller: <a href='user_profile?m_id=$seller_id'>$full_name</a></small>
			<h6 class='mb-0 t'>$$row2[0] HKD</h6>
			<p style='font-size:1em;' class='badge badge-pill badge-primary'>$status</p>
		</div>
		<a class='delete text-danger' id='$pid' href='#'><i class='fa fa-trash-o'></i></a>
		</div>
	</li>
		";
		$amount = $amount + $row2[0];
		$check = $check + 1;
	}

	$output .="	</ul>";

	if( $check  == 0){
		$output = "<h3>Your wishlist is empty!</h3>";
	}

	echo $output;

}

if(isset($_POST['delete'])){
	$pid = $_POST['delete'];
	mysql_query("DELETE FROM wishlist WHERE product_id = '$pid' ");
}

if(isset($_POST['add'])){
	$check = mysql_query("SELECT COUNT(*) FROM wishlist WHERE product_id = '$pid' AND m_id = '$m_id' ");
	$row = mysql_fetch_array($check,MYSQL_NUM);
	$msg = "";
	if($row[0]==1){
		$msg = "notok";
	}
	else{
		$pid = $_POST['add'];
		mysql_query("INSERT INTO wishlist(product_id,m_id) VALUES('$pid','$m_id')");
		$msg = "ok";
	}
	echo $msg;
}
?>
