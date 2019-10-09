<?php
  include_once 'config.php';
  session_start();
  $seller_id = 37;
  $amount = 1;
  mysql_query("INSERT INTO payment_b(payment_type,buyer_id,amount,unpaid) VALUES('LuxPrime Service','$seller_id','$amount','true')");
  $get_payid = mysql_query("SELECT payment_id FROM payment_b WHERE payment_type ='LuxPrime Service' AND pay_date = '0000-00-00' AND buyer_id='$seller_id' AND unpaid='true' AND amount='$amount'");
  $payment_id = mysql_fetch_array($get_payid,MYSQL_NUM);
  $_SESSION["pay_type"] = "sell";
  $_SESSION["payment"] = $payment_id[0];
  header('Location:make_payment');
?>
