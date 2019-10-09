<?php
	include_once 'config.php';
	include_once 'token.php';
	if(!isloggedin()){
	header('Location:login.php?need_login=True');
	}

	if(isset($_POST["edit"])) {
		$m_id = isloggedin();
		$sql = mysql_query("SELECT firstname,lastname,address,phone,country FROM member WHERE m_id = '$m_id'");
		$array = mysql_fetch_row($sql);
		echo json_encode($array);
	}


 ?>
