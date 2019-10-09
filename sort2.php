<?php
include_once 'config.php';
include_once 'token.php';
if(!isloggedin()){
	header('Location:login.php?need_login=True');
}
$m_id = isloggedin();

if(isset($_POST['order_record'])){
	$output = '';
	$order = $_POST["order2"];
	if($order == 'desc')
	{
	  $order = 'asc';
	}
	else
	{
	  $order = 'desc';
	}

	 $sorting = $_POST["column_name2"];

	 $sql4 = mysql_query("SELECT orders.order_id, orders.order_date, orders.status, orders.shipping_status,count(order_products.product_id) FROM order_products,orders WHERE orders.order_id = order_products.order_id AND buyer_id = '$m_id' GROUP BY order_id ORDER BY $sorting $order " );
	 $output .= "
	 <table class='table table-bordered'>
								  <tr>
									   <th class='tableo'><a class='column_sort2' id='order_id' data-order='$order' href='#'>Order ID</a></th>
									   <th class='tableo'><a class='column_sort2' id='order_date' data-order='$order' href='#'>Order date</a></th>
									   <th class='tableo'><a class='column_sort2' id='count(order_products.product_id)' data-order='$order' href='#'>No. of Product</a></th>
									   <th class='tableo'><a class='column_sort2' id='status' data-order='desc' href='#'>Order Status</a></th>
									   <th class='tableo'><a class='column_sort2' id='shipping_status' data-order='$order' href='#'>Shipping Staus</a></th>
								  </tr>
	 ";

	 while($row4 = mysql_fetch_array($sql4,MYSQL_NUM)){
		  $output .= "
			<tr>
				 <td><?php echo $row4[0]; ?></td>
				 <td><?php echo $row4[1]; ?></td>
				 <td><?php echo $row4[4]; ?></td>
				 <td><?php echo $row4[2]; ?></td>
				 <td><?php echo $row4[3]; ?></td>
			</tr>
		  ";
	 }

	 $output .= "</table>";
	 echo $output;
}





?>
