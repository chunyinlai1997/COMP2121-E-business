<?php
  include_once 'config.php';
  include_once 'token.php';
  if(isset($_POST['buy_submit'])){
    $selected = $_POST['chosen'];
    $pids = explode(',', $selected);

    $basic_total = $_POST['basic_total'];
    $discount_amount = $_POST['discount_total'];
    $final_total = $_POST['final_total'];
    $next_coupon = $_POST['next_coupon'];
    $trans_total = $_POST['trans_total'];
    $repair_total = $_POST['repair_total'];
    $m_id = isloggedin();
    $today = date("Y-m-d");
    $tmp_index = $m_id.$today.$final_total;

    foreach($pids as $check_pid){
        $available_check = mysql_query("SELECT STATUS FROM product WHERE product_id = '$check_pid' ");
        $row_ava = mysql_fetch_array($available_check,MYSQL_NUM);
        if($row_ava[0]=="sold"){
          header("Location:checkout?tryagain=true");
        }
    }

    mysql_query("INSERT INTO orders(order_date,buyer_id,status,shipping_address,shipping_status) VALUES('$today','$m_id','wait for payment','$tmp_index','wait for payment')");
    $get_order_id = mysql_query("SELECT order_id FROM orders WHERE shipping_address ='$tmp_index' ");
    $order_row = mysql_fetch_array($get_order_id,MYSQL_NUM);
    $order_id = $order_row[0];
    mysql_query("UPDATE orders SET shipping_address='' WHERE order_id ='$order_id' ");

    mysql_query("INSERT INTO invoice(order_id,pay_amount,discount_amount,basic_amount,transaction_fee,invoice_date,repair_amount) VALUES('$order_id','$final_total','$discount_amount','$basic_total','$trans_total','$today','$repair_total')");
    $get_invoice_id = mysql_query("SELECT invoice_id FROM invoice WHERE order_id ='$order_id' ");
    $invoice_row = mysql_fetch_array($get_invoice_id,MYSQL_NUM);
    $invoice_id = $invoice_row[0];

    foreach($pids as $pid){
        mysql_query("INSERT INTO order_products(order_id,product_id) VALUES('$order_id','$pid')");
        mysql_query("UPDATE product SET STATUS='sold' WHERE product_id='$pid'");
        
    }

    mysql_query("INSERT INTO payment_b(payment_type,invoice_id,buyer_id,amount,unpaid) VALUES('Purchase Items','$invoice_id','$m_id','$final_total','true')");
    $get_payment_id = mysql_query("SELECT payment_id FROM payment_b WHERE invoice_id ='$invoice_id' ");
    $payment_row =  mysql_fetch_array($get_payment_id,MYSQL_NUM);
    $payment_id = $payment_row[0];

    session_start();
    $_SESSION["pay_type"] = "buy";
    $_SESSION["payment"] = $payment_id;
    $_SESSION["invoice"] = $invoice_id;
    $_SESSION["order"] = $order_id;
    $_SESSION["amount"] = $final_total;
    $_SESSION["selection"] = $pids;
    $_SESSION["next_coupon"] = $next_coupon;
    header("Location:make_payment");
  }
  else{
    header("Location:checkout");
  }
?>
