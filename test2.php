<?php
include_once 'config.php';
include_once 'token.php';
$pid = 24;
$paydate = date("Y-m-d");
$get_duration = mysql_query("SELECT post_date,price FROM product WHERE product_id = '$pid'");
$row_duration =  mysql_fetch_array($get_duration,MYSQL_NUM);
$today = new DateTime();
$due_date = new DateTime("$row_duration[0]");
$diff = $due_date->diff($today);
$duration = $diff->format("%d");
$storage = $row_duration[1] * 0.05;
$pay_this  = $row_duration[1] - $storage;
mysql_query("INSERT INTO com_pay_check(confirm_pay_day,confirm_amount,confirm_status,sold_id) VALUES('$paydate','$pay_this','paid','$pid') ");


?>
