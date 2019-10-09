<?php
include_once 'config.php';
	include_once 'token.php';
	if(!isloggedin()){
	header('Location:login.php?need_login=True');
	}

	if(isset($_POST["submit"])) {
		$m_id = isloggedin();
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		$address = $_POST["address"];
		$phone = $_POST["phone"];
		$country = $_POST["country"];
		mysql_query("UPDATE member SET firstname='$firstname',lastname='$lastname',address='$address',phone='$phone',country='$country' WHERE m_id='$m_id'");
		header('Location:profile.php?update=success');
	}

	if(isset($_POST["pass_submit"])) {
		$m_id = isloggedin();
		$current = $_POST["current_password"];
		$new = $_POST["new_confirm"];
		$sql1 = mysql_query("SELECT password FROM member where m_id = '$m_id'");
		$row1 = mysql_fetch_array($sql1,MYSQL_NUM);
		if(password_verify($current,$row1[0])){
			$new_hash = password_hash("$new", PASSWORD_DEFAULT);
			mysql_query("UPDATE member SET password = '$new_hash' WHERE m_id='$m_id'");
			header('Location:profile.php?update=successpass');
		}
		else{
			header('Location:profile.php?update=fail');
		}


	}
?>
