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

if(isset($_GET['product_id'])){
  $pid = $_GET['product_id'];
  $check  =  mysql_query("SELECT product.price,product.description,product.seller_id,accept_product.model_name,product.product_image1 FROM product,accept_product WHERE product.product_id = accept_product.product_id  AND product.product_id = '$pid' ");
  $row_check =  mysql_fetch_array($check,MYSQL_NUM);
  if($row_check[2]!=$m_id){
    header('Location:sellpanel');
  }
  else{
    mysql_query("DELETE FROM product WHERE product_id= '$pid' ");
    mysql_query("DELETE FROM accept_product WHERE product_id= '$pid' ");
    mysql_query("DELETE FROM check_record WHERE product_id= '$pid' ");
    header('Location:sellpanel');
  }
}
else{
	header('Location:sellpanel');
}


?>
