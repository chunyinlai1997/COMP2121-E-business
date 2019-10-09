<?php
include_once 'config.php';

if(isset($_POST["username"])){
	$uname = $_POST["username"];
	$sql= mysql_query("SELECT * FROM member WHERE member.username ='$uname'")or die(mysql_error());
	echo mysql_num_rows($sql);
}
if(isset($_POST["email"])){
	$email = $_POST["email"];
	$sql2= mysql_query("SELECT * FROM member WHERE member.email ='$email'")or die(mysql_error());
	echo mysql_num_rows($sql2);
}

if(isset($_POST["pass"])){
	include_once 'token.php';
	$m_id = isloggedin();
	$pass = $_POST["pass"];
	$sql4 = mysql_query("SELECT password FROM member WHERE member.m_id ='$m_id'")or die(mysql_error());
	$row = mysql_fetch_array($sql4,MYSQL_NUM);
	if(password_verify($pass,$row[0])){
		echo "correct";
	}
	else{
		echo "wrong";
	}
}

if(isset($_POST["plan"])){
	$p = $_POST["plan"];
	include_once 'token.php';
	$m_id = isloggedin();
	if($p==0){
		return "---";
	}
	$sql3 = mysql_query("SELECT mem_status,exp_date FROM membership WHERE m_id='$m_id'");
	$row = mysql_fetch_array($sql3,MYSQL_NUM);
	$initial = date("Y-m-d");
	$new = $initial;	
	if($row[0]=="STANDARD"){
		if($p==30){
			$new = date('Y-m-d', strtotime($initial. ' + 30 days'));
		}
		else if($p==90){
			$new = date('Y-m-d', strtotime($initial. ' + 90 days'));
		}
		else if($p==180){
			$new = date('Y-m-d', strtotime($initial. ' + 180 days'));
		}
		else if($p==365){
			$new = date('Y-m-d', strtotime($initial. ' + 365 days'));
		}
	}
	else{
		$initial = $row[1];
		if($p==30){
			$new = date('Y-m-d', strtotime($initial. ' + 30 days'));
		}
		else if($p==90){
			$new = date('Y-m-d', strtotime($initial. ' + 90 days'));
		}
		else if($p==180){
			$new = date('Y-m-d', strtotime($initial. ' + 180 days'));
		}
		else if($p==365){
			$new = date('Y-m-d', strtotime($initial. ' + 365 days'));
		}
	}
	echo $new;
}
?>