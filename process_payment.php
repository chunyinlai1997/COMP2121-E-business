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



if(!isseller()){
	header('Location:become_seller');
}

$m_id = isloggedin();
$sql = mysql_query("SELECT profileimg,username,joindate FROM member WHERE m_id = '$m_id' ");
$row = mysql_fetch_array($sql,MYSQL_NUM);

if(isset($_POST['pay_id'])){
	header('Location:home');
}

if(isset($_POST['submit']) && !empty($_POST['submit'])):
    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])):
        //your site secret key
        $secret = '6LcN5jQUAAAAACa2GtQVN-n7lw3gLgu6RDMCoufK';
        //get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success):
           gotopay();
        else:
            header('Location:make_payment?re=FAIL_CAPTCHA');
        endif;
    else:
        header('Location:make_payment?re=NO_SUBMIT_CAPTCHA');
    endif;
else:
	header('Location:make_payment?re=NO_SUBMIT');
endif;

function gotopay(){

  if(isset($_POST['submit'])){
    if($_SESSION["pay_type"]=="sell"){
			$product_id = $_SESSION["pid"];
      $cc = $_POST['cardnum'];
      $paydate = date("Y-m-d");
      $pay_id = $_POST["pay_id"];
			$amount = $_POST["amount"];
			mysql_query("UPDATE check_record SET status = 'waiting' WHERE product_id = '$product_id'");
			mysql_query("UPDATE product SET STATUS = 'arriving' WHERE product_id = '$product_id'");
			mysql_query("INSERT INTO invoice(invoice_date,product_id,pay_amount) VALUES('$paydate','$product_id','$amount')");
			$get_invoice = mysql_query("SELECT invoice_id FROM invoice WHERE product_id = '$product_id' ");
			$row_invoice = mysql_fetch_array($get_invoice,MYSQL_NUM);
      mysql_query("UPDATE payment_b SET pay_date = '$paydate', cc_num='$cc', unpaid='false', invoice_id='$row_invoice[0]' WHERE payment_id = '$pay_id' ");
			session_destroy();
			header("Location:sell_complete?payment=$pay_id&pid=$product_id");
    }
    else if($_SESSION["pay_type"]=="buy"){
			$m_id = isloggedin();
			$payment_id =$_SESSION["payment"];
	    $invoice_id =$_SESSION["invoice"];
	    $order_id = $_SESSION["order"];
	    $paid_total = $_SESSION["amount"];
			$pids = $_SESSION["selection"];
	    $next_coupon = $_SESSION["next_coupon"];
			$paydate = date("Y-m-d");
			if($next_coupon=="true"){
				$new = date('Y-m-d', strtotime($initial. ' + 30 days'));
				mysql_query("INSERT INTO coupon(m_id,coupon_num,expire_date) VALUES('$m_id','2','$new')");
			}
			$cc = $_POST['cardnum'];
			mysql_query("UPDATE payment_b SET pay_date = '$paydate', cc_num='$cc', unpaid='false', invoice_id='$invoice_id' WHERE payment_id = '$payment_id' ");
			mysql_query("UPDATE orders SET status = 'paid' WHERE order_id = '$order_id' ");

			foreach($pids as $pid){
	        mysql_query("DELETE FROM shopping_cart WHERE product_id = '$pid' AND m_id = '$m_id' ");

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
	    }
			header("Location:shipping");
    }
  }
}

?>
