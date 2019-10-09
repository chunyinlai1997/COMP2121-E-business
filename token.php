<?php
include_once 'config.php';
function isloggedin(){
	if(isset($_COOKIE['SNID'])){
		$d_token = sha1($_COOKIE['SNID']);
		if(mysql_query("SELECT m_id FROM logintoken WHERE token = '$d_token'")){
			$sql = mysql_query("SELECT m_id FROM logintoken WHERE token = '$d_token'");
			$result = mysql_fetch_array($sql,MYSQL_NUM);
			$m_id = $result[0];
			if(isset($_COOKIE['SNID_'])){
				return $m_id;
			}
			else{
				$cstrong = True;
				$token = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
				$h_token = sha1($token);
				$h_snid = sha1($_COOKIE['SNID']);
				mysql_query("INSERT INTO logintoken(token,m_id) VALUES('$h_token ','$m_id')");
				mysql_query("DELETE FROM logintoken WHERE token = '$h_snid'");
				return $m_id;
			}
		}
		return false;
	}
}

function isactivated(){
	$mid = isloggedin();
	$sql= mysql_query("SELECT member.status FROM member WHERE member.m_id = '$mid'")or die(mysql_error());
	$row= mysql_fetch_array($sql,MYSQL_NUM);
	if($row[0]=="not-verify"){
		return false;
	}
	else{
		return true;
	}
}

function isseller(){
	$mid = isloggedin();
	$sql= mysql_query("SELECT COUNT(*) FROM seller WHERE seller.m_id = '$mid'")or die(mysql_error());
	$row= mysql_fetch_array($sql,MYSQL_NUM);
	if($row[0]==1){
		return true;
	}
	else{
		return false;
	}
}

function ispremium(){
	$mid = isloggedin();
	$sql= mysql_query("SELECT COUNT(*) FROM membership WHERE m_id = '$mid' AND mem_status='PREMIUM'")or die(mysql_error());
	$row= mysql_fetch_array($sql,MYSQL_NUM);
	if($row[0]==1){
		return true;
	}
	else{
		return false;
	}
}

function cansell(){
	$mid = isloggedin();
	if(ispremium()){
		return true;
	}
	else{
		$sql= mysql_query("SELECT COUNT(*) FROM product WHERE seller_id = '$mid' AND (STATUS='in_stock' OR STATUS='arriving')")or die(mysql_error());
		$row = mysql_fetch_array($sql,MYSQL_NUM);
		if($row[0]==0){
			return true;
		}
		else{
			return false;
		}
	}
}
?>
