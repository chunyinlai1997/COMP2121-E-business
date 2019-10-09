<?php
	include_once 'config.php';
	include_once 'token.php';
	if(!isloggedin()){
	header('Location:login.php?need_login=True');
	}

	if(isset($_POST['type'])){
		$type = $_POST['type'];
		$sql2 = "";
		if($type=='bag'){
			$sql2 = mysql_query("SELECT brand FROM bag GROUP BY brand");
		}
		else{
			$sql2 = mysql_query("SELECT brand FROM accessories GROUP BY brand");
		}
		$output =  "<option value='blank'>Select brand...</option>";
		while($row2 = mysql_fetch_array($sql2,MYSQL_NUM)){
			 $output .= "<option value='$row2[0]'>$row2[0]</option>";
		}
		echo $output;
	}

	if(isset($_POST['get_model'])){
		$brand = $_POST['brand2'];
		$type = $_POST['type2'];
		$sql2 = "";
		$output3="";
		if($type=='bag'){
			$sql3 = mysql_query("SELECT model_name FROM bag where brand ='$brand' ");
		}
		else{
			$sql3 = mysql_query("SELECT model_name FROM accessories where brand ='$brand'");
		}
		$output3 =  "<option value='blank'>Select model...</option>";
		while($row3 = mysql_fetch_array($sql3,MYSQL_NUM)){
			 $output3 .= "<option value='$row3[0]'>$row3[0]</option>";
		}
		echo $output3;
	}

	if(isset($_POST['get_price'])){
		$model = $_POST['model3'];
		$type = $_POST['type3'];
		$sql4 = "";
		$p1 = 0;
		$p2 = 0;
		if($type=='bag'){
			$sql4 = mysql_query("SELECT recommended_price FROM bag where model_name ='$model' ");
		}
		else{
			$sql4 = mysql_query("SELECT recommended_price FROM accessories where model_name ='$model'");
		}
		$row4 = mysql_fetch_array($sql4,MYSQL_NUM);
		$p1 = $row4[0];
		$sql5 = mysql_query("SELECT AVG(product.price) FROM accept_product INNER JOIN  product ON accept_product.model_name = '$model' AND product.product_id = accept_product.product_id");
		$row5 = mysql_fetch_array($sql5,MYSQL_NUM);
		$p2 = round($row5[0]);
		if($p2==0){
			$return = "Please set a price for your product. The first-hand price of your product is $".$p1."HKD";
		}
		else{
			$return = "Please set a price for your product. The first-hand price of your product is $".$p1."HKD, and the average selling price of your product is $".$p2."HKD.";
		}

		echo $return;
}

if(isset($_POST['plan'])){
	$plan = $_POST['plan'];
	$type = $_POST['producttype'];
	$discount = 1;
	$amount = 0;
	if(ispremium()){
		$discount = 0.5;
	}
	if($plan=="qc"){
		if($type=="bag"){
				$amount = 200;
		}
		else{
			$amount = 100;
		}
	}
	else if($plan=="3d"){
		$amount = 50;
	}
	else if($plan=="not_need"){
		$amount = 0;
	}
	echo $amount*$discount;
}

if(isset($_POST['get_color'])){
	$model = $_POST['model5'];
	$type = $_POST['type5'];
	$sql6 = "";
	$output6 = "";
	if($type=='bag'){
		$sql6 = mysql_query("SELECT bag_color.bag_color FROM bag_color,bag where bag.bag_id = bag_color.bag_id AND bag.model_name ='$model' ");
	}
	else{
		$sql6 = mysql_query("SELECT color FROM accessories where model_name ='$model'");
	}
	while($row6 = mysql_fetch_array($sql6,MYSQL_NUM)){
		 $output6 .= "<option value='$row6[0]'>$row6[0]</option>";
	}
	echo $output6;
}

if(isset($_POST['search_price'])){
	$pid = $_POST['search_price'];
	$sqlp3 = mysql_query("SELECT price FROM product WHERE product_id = '$pid' ");
	$details = mysql_fetch_array($sqlp3,MYSQL_NUM);
	$price = $details[0];
	$price =  (int)($price);
	echo $price;
}

if(isset($_POST['default_address'])){
	$m_id = isloggedin();
	$address = mysql_query("SELECT address FROM member WHERE m_id = '$m_id' ");
	$actual_address = mysql_fetch_array($address,MYSQL_NUM);
	echo $actual_address[0];
}

 ?>
