<?
include_once 'config.php';
include_once 'token.php';

if(isset($_POST['L1'])||isset($_POST['L2'])){
	if($_POST['L2']=="this"){
		if(isset($_COOKIE['SNID'])){
			$t  = sha1($_COOKIE['SNID']);
			mysql_query("DELETE FROM logintoken WHERE token= '$t'")or die(mysql_error());
		}
		unset($_COOKIE['SNID']);
		unset($_COOKIE['SNID_']);
		setcookie('SNID', null, -1, '/');
		setcookie('SNID_', null, -1, '/');
	}
	else if($_POST['L1']=="all"){
		$mid = isloggedin();
		mysql_query("DELETE FROM logintoken WHERE m_id ='$mid'")or die(mysql_error());
		unset($_COOKIE['SNID']);
		unset($_COOKIE['SNID_']);
		setcookie('SNID', null, -1, '/');
		setcookie('SNID_', null, -1, '/');
	}
}
header("Location:../Project");
?>
