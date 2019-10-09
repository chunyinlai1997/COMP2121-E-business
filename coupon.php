<?php
include_once 'config.php';
include_once 'token.php';

function can_first_buy(){
  $m_id = isloggedin();
  $check = mysql_query("SELECT COUNT(*) FROM orders WHERE buyer_id = '$m_id' ");
  $num = mysql_fetch_array($check,MYSQL_NUM);
  if($num[0]==0){
    return true;
  }
  else{
    return false;
  }
}

function can_invite_buy(){
  $m_id = isloggedin();
  $today = date("Y-m-d");
  $check = mysql_query("SELECT COUNT(*) FROM coupon WHERE m_id='$m_id' AND coupon_num = 1 AND expire_date >= $today ");
  $num = mysql_fetch_array($check,MYSQL_NUM);
  if($num[0]==1){
    return true;
  }
  else{
    return false;
  }
}


function can_purchase_cheaper(){
  $m_id = isloggedin();
  $today = date("Y-m-d");
  $check = mysql_query("SELECT COUNT(*) FROM coupon WHERE m_id='$m_id' AND coupon_num = 2 AND expire_date >= $today ");
  $num = mysql_fetch_array($check,MYSQL_NUM);
  if($num[0]==1){
    return true;
  }
  else{
    return false;
  }
}

function isfirstsale(){
  $m_id = isloggedin();
  $check = mysql_query("SELECT COUNT(*) FROM product WHERE seller_id = '$m_id' ");
  $num = mysql_fetch_array($check,MYSQL_NUM);
  if($num[0]==0){
    return true;
  }
  else{
    return false;
  }
}



if(isset($_POST['first_buy'])){
  $basic_subtotal = $_POST['first_buy'];
  $item_count = $_POST['item_count'];
  $discount = 0;
  $m_id = isloggedin();
  if($item_count>0){
    if(can_first_buy()){
      $discount = round($basic_subtotal * 0.05);
    }
    else{
        $discount = 0;
    }
  }
  else{
    $discount = 0;
  }
  echo $discount;
}

if(isset($_POST['invite_buy'])){
  $basic_subtotal = $_POST['invite_buy'];
  $item_count = $_POST['item_count'];
  $discount = 0;
  $m_id = isloggedin();
  if($item_count>0){
    if(can_invite_buy()){
        $discount = round($basic_subtotal * 0.05);
    }
    else{
        $discount = 0;
    }
  }
  else{
    $discount = 0;
  }
  echo $discount;
}

if(isset($_POST['monthly'])){
  $selected = $_POST['monthly'];
  $discount = 0;
  $m_id = isloggedin();
  if(ispremium()){
    foreach($selected as $d){
      $sql = mysql_query("SELECT price,brand FROM product WHERE product_id='$d'");
      $check = mysql_fetch_array($sql,MYSQL_NUM);

      if($check[1]=="Louis Vuitton"){  //$match1[0]
        $discount += ($check[0] * 0.05);
      }

    }
  }
  else{
    $discount = 0;
  }
  echo $discount;
}

if(isset($_POST['weekly'])){
  $selected = $_POST['weekly'];
  $discount = 0;
  $m_id = isloggedin();
  if(ispremium()){
    foreach($selected as $d){
      $sql = mysql_query("SELECT price,brand FROM product WHERE product_id='$d'");
      $check = mysql_fetch_array($sql,MYSQL_NUM);

      if($check[1]=="Prada"){
        $discount += ($check[0] * 0.05);
      }
    }
  }
  else{
    $discount = 0;
  }
  echo $discount;
}

if(isset($_POST['cheaper'])){
  $basic_subtotal = $_POST['cheaper'];
  $discount = 0;
  $m_id = isloggedin();
  if(can_purchase_cheaper()){
    $discount = ($basic_subtotal * 0.1);
  }
  else{
    $discount = 0;
  }
  echo $discount;
}

if(isset($_POST['next'])){
  $items = $_POST['next'];
  $m_id = isloggedin();
  if(!can_purchase_cheaper() && $items >= 5 ){
    echo "true";
  }
  else{
    echo "false";
  }
}

if(isset($_POST['membership'])){
  $subtotal = $_POST['membership'];
  $trans = 0;
  $m_id = isloggedin();
  if(ispremium()){
    $trans = $subtotal * 0.025;
  }
  else{
    $trans = $subtotal * 0.05;
  }
  echo round($trans);
}

if(isset($_POST['first_sale'])){
  if(isfirstsale()){
    echo "true";
  }
  else{
    echo "false";
  }
}

?>
