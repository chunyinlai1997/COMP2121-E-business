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

if(!isseller()){
	header('Location:become_seller');
}

$m_id = isloggedin();

$sql = mysql_query("SELECT profileimg,username,joindate,email,firstname,lastname,phone,address,country FROM member WHERE m_id = '$m_id' ");
$row = mysql_fetch_array($sql,MYSQL_NUM);

if (isset($_POST['btn-submit'])) {
 $model = $_POST["model_name"];
 $type = $_POST["product_type"];
 $description = $_POST["description"];
 $price = $_POST["price"];
 $amount = $_POST["amount"];
 $payplan = $_POST["payplan"];
 $brand = $_POST["brand"];
 $status = "arriving";
 $auth_number = $_POST["auth_number"];
 $post_date = $_POST["post_date"];
 $color = $_POST["color"];
 $seller_id = $m_id;
 $identify ="9d47a7f5fd33158f6a50ff5f191077607cba5cce";
 $imagelink1 = "";
 $imagelink2 = "";
 $imagelink3 = "";
 $imagelink4 = "";
 $imagelink5 = "";

 //echo  $model,$type,$description,$price,$status,$auth_number,$post_date,$seller_id;
	$imgurURL = "https://api.imgur.com/3/image";
	if(file_exists($_FILES['photo1']['tmp_name']) || is_uploaded_file($_FILES['photo1']['tmp_name'])) {
			$image1 = base64_encode(file_get_contents($_FILES['photo1']['tmp_name']));
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

	if(file_exists($_FILES['photo2']['tmp_name']) || is_uploaded_file($_FILES['photo2']['tmp_name'])) {
		 $image2 = base64_encode(file_get_contents($_FILES['photo2']['tmp_name']));
		 $options = array('http'=>array(
			 'method'=>"POST",
			 'header'=>"Authorization: Bearer 9d80a5579bea50b9dbdaad0528ee66d08da6ecca\n"."Content-Type: application/x-ww-form-urlencoded",
			 'content'=>$image2
		 ));
		 $context = stream_context_create($options);
		 $response = file_get_contents($imgurURL, false, $context);
		 $res = json_decode($response);
		 $imagelink2 = $res->data->link;
	}

	if(file_exists($_FILES['photo3']['tmp_name']) || is_uploaded_file($_FILES['photo3']['tmp_name'])) {
		 $image3 = base64_encode(file_get_contents($_FILES['photo3']['tmp_name']));
		 $options = array('http'=>array(
		 	'method'=>"POST",
		 	'header'=>"Authorization: Bearer 9d80a5579bea50b9dbdaad0528ee66d08da6ecca\n"."Content-Type: application/x-ww-form-urlencoded",
		 	'content'=>$image3
		 ));
		 $context = stream_context_create($options);
		 $response = file_get_contents($imgurURL, false, $context);
		 $res = json_decode($response);
		 $imagelink3 = $res->data->link;
	 }

	if(file_exists($_FILES['photo4']['tmp_name']) || is_uploaded_file($_FILES['photo4']['tmp_name'])) {
		 $image4 = base64_encode(file_get_contents($_FILES['photo4']['tmp_name']));
		 $options = array('http'=>array(
		  'method'=>"POST",
		  'header'=>"Authorization: Bearer 9d80a5579bea50b9dbdaad0528ee66d08da6ecca\n"."Content-Type: application/x-ww-form-urlencoded",
		  'content'=>$image4
		 ));
		 $context = stream_context_create($options);
		 $response = file_get_contents($imgurURL, false, $context);
		 $res = json_decode($response);
		 $imagelink4 = $res->data->link;
	 }

	if(file_exists($_FILES['photo5']['tmp_name']) || is_uploaded_file($_FILES['photo5']['tmp_name'])) {
		 $image5 = base64_encode(file_get_contents($_FILES['photo5']['tmp_name']));
		 $options = array('http'=>array(
		  'method'=>"POST",
		  'header'=>"Authorization: Bearer 9d80a5579bea50b9dbdaad0528ee66d08da6ecca\n"."Content-Type: application/x-ww-form-urlencoded",
		  'content'=>$image5
		 ));
		 $context = stream_context_create($options);
		 $response = file_get_contents($imgurURL, false, $context);
		 $res = json_decode($response);
		 $imagelink5 = $res->data->link;
	 }

	 //echo $identify,$price,$status,$post_date,$seller_id,$imagelink1,$imagelink2,$imagelink3,$imagelink4,$imagelink5,$color;
   mysql_query("INSERT INTO product(description,price,STATUS,post_date,seller_id,product_image1,product_image2,product_image3,product_image4,product_image5,color,brand) VALUES('$identify','$price','$status','$post_date','$seller_id','$imagelink1','$imagelink2','$imagelink3','$imagelink4','$imagelink5','$color','$brand')");
   $sqlproduct = mysql_query("SELECT product_id FROM product WHERE description = '$identify'");
   $rowproduct = mysql_fetch_array($sqlproduct,MYSQL_NUM);
   $pid = $rowproduct[0];
	 //echo $pid;
   mysql_query("UPDATE product SET description = '$description' WHERE product_id = '$pid'");
   mysql_query("INSERT INTO accept_product(product_id,model_name,product_type) VALUES('$pid','$model','$type')");
	 if($amount>0){
		 mysql_query("INSERT INTO payment_b(payment_type,buyer_id,amount,unpaid) VALUES('LuxPrime Service','$seller_id','$amount','true')");
		 mysql_query("UPDATE product SET STATUS = 'waiting' WHERE product_id = '$pid'");
		 $get_payid = mysql_query("SELECT payment_id FROM payment_b WHERE payment_type ='LuxPrime Service' AND buyer_id='$seller_id' AND unpaid='true' AND amount='$amount'");
		 $payment_id = mysql_fetch_array($get_payid,MYSQL_NUM);
	   $_SESSION["pay_type"] = "sell";
	   $_SESSION["payment"] = $payment_id[0];
		 $_SESSION["pid"] = $pid;
		 mysql_query("INSERT INTO check_record(product_id,status,3d_model) VALUES('$pid','no_payment','true')");
		 header("Location:make_payment");
	 }
	 else{
		 if($_POST['coupon_used']==1){
			 mysql_query("INSERT INTO check_record(product_id,status,3d_model) VALUES('$pid','waiting','true')");
		 }
		 else{
			 mysql_query("INSERT INTO check_record(product_id,status,3d_model) VALUES('$pid','NA','false')");
		 }
		 header("Location:sell_complete?payment=na&pid=$pid");
	 }
}
else{
	header("Location:sell.php");
}
