<?php
include_once 'config.php';
include_once 'token.php';
if(!isloggedin()){
	header('Location:login.php?need_login=True');
}
$m_id = isloggedin();

if(isset($_POST['payment_record'])){
	$output = '';
	$order = $_POST["order"];
	if($order == 'desc')
	{
	  $order = 'asc';
	}
	else
	{
	  $order = 'desc';
	}

	 $sorting = $_POST["column_name"];

	 $query = mysql_query("SELECT payment_type, pay_date ,invoice_id,cc_num, amount, payment_id FROM payment_b WHERE buyer_id = '$m_id' ORDER BY $sorting $order");
	 $output .= "
	 <table class='table table-bordered'>
		  <tr>
			   <th><a class='column_sort' id='payment_id' data-order='$order' href='#'>Payment ID</a></th>
			   <th><a class='column_sort' id='payment_type' data-order='$order' href='#'>Payment Type</a></th>
			   <th><a class='column_sort' id='pay_date' data-order='$order' href='#'>Paid Date</a></th>
			   <th><a class='column_sort' id='invoice_id' data-order='$order' href='#'>Invoice ID</a></th>
			   <th><a class='column_sort' id='cc_num' data-order='$order' href='#'>Credit Card Number</a></th>
			   <th><a class='column_sort' id='amount' data-order='$order' href='#'>Amount</a></th>
		  </tr>
	 ";

	 while($row2 = mysql_fetch_array($query,MYSQL_NUM)){
		  $cc = $row2[3]; $smcc= substr("$cc", -4); $newcc =  "****".$smcc;
		  $output .= "
			<tr>
				<td>$row2[5]</td>
				<td>$row2[0]</td>
				<td>$row2[1]</td>
				<td>$row2[2]</td>
				<td>$newcc</td>
				<td>$row2[4]</td>
			</tr>
		  ";
	 }

	 $output .= "</table>";
	 echo $output;
}









?>
