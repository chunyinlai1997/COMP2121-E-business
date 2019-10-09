<!DOCTYPE html>
<?php
include_once 'config.php';
include_once 'token.php';

session_start();

if(!isloggedin()){
	header('Location:login?need_login=True');
}
if(!isactivated()){
	header('Location:activate');
}

$m_id = isloggedin();

$pay_type = $_SESSION["pay_type"];

$sql = mysql_query("SELECT profileimg,username,joindate FROM member WHERE m_id = '$m_id' ");
$row = mysql_fetch_array($sql,MYSQL_NUM);

if(isset($_POST['ship_sub'])){
  if($pay_type!="buy"){
    header('Location:shop');
  }
  else{
    $address = $_POST['address'];
    $company = $_POST['shipping_company'];
    $payment_id =$_SESSION["payment"];
    $invoice_id =$_SESSION["invoice"];
    $order_id = $_SESSION["order"];
    $paid_total = $_SESSION["amount"];
    $next_coupon = $_SESSION["next_coupon"];
    $sh_com_id = 0;
    $fake_shipping_id = generateRandomString(8);
    $fake_shipping_id = $company.$fake_shipping_id;
    if($company=="sf"){
      $sh_com_id = 1;
      $company = "SF Express";
    }
    else if($company=="dhl"){
      $sh_com_id = 2;
      $company = "DHL";
    }
    else{
      header('Location:shop');
    }

    $_SESSION["shipping"] =$fake_shipping_id;
    $_SESSION["address"] = $address;
    $_SESSION["shipping_company"] = $company;
    mysql_query("UPDATE orders SET sh_com_id ='$sh_com_id',shipping_status='shipping',shipping_address='$address',shipping_id='$fake_shipping_id' WHERE order_id='$order_id' ");
    sleep(5);
    header('Location:buy_complete');
    exit();
  }
}
else{
  header('Location:shop');
}

function generateRandomString($length = 8) {
    return substr(str_shuffle(str_repeat($x='012345678901234567890123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
?>
<html>
<body>
  <form>
    <div class="wrap" style='margin-top:100px;'>
        <h1>Processing shipping...</h1>
    </div>
    </form>
</body>
</html>
