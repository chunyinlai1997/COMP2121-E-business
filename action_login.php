<?php
include_once 'config.php';
include_once 'token.php';
if(isloggedin()){
	header('Location:home.php');
}

if(isset($_POST['submit']) && !empty($_POST['submit'])):
    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])):
        //your site secret key
        $secret = '6LcN5jQUAAAAACa2GtQVN-n7lw3gLgu6RDMCoufK';
        //get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success):
           validate();
        else:
            header('Location:login.php?re=FAIL_CAPTCHA');
        endif;
    else:
        header('Location:login.php?re=NO_SUBMIT_CAPTCHA');
    endif;
else:
	header('Location:login.php?re=NO_SUBMIT');
endif;


function validate(){
	
	if(isset($_POST['submit'])){
		$uname= $_POST['username']; 
		$pass = $_POST['password']; 
		$sql= mysql_query("SELECT member.m_id, member.username, member.password, member.status FROM member WHERE member.username = '$uname'")or die(mysql_error());
		$row= mysql_fetch_array($sql,MYSQL_NUM);
		$hp = $row[2];
		if(password_verify($pass,$hp)) {
			$cstrong = True;
			$token = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
			$h_token = sha1($token);
			$mid = $row[0];
			mysql_query("INSERT INTO logintoken(token,m_id) VALUES('$h_token','$mid')")or die(mysql_error());
			setcookie("SNID",$token,time()+60*60*24*1,'/',NULL,NULL,TRUE);	//first login token will expire after 24 hours
			setcookie("SNID_",'1',time()+60*60*24*0.5,'/',NULL,NULL,TRUE);	//second login token will expire after 12 hours
			$sql2 = mysql_query("SELECT mem_status,exp_date FROM membership WHERE m_id=$mid");
			$row2 = mysql_fetch_array($sql2,MYSQL_NUM);
			$today = date("Y-m-d");
			$date = $row2[1];
			if($row2[0]=="PREMIUM"){
				$ts1 = strtotime($date);
				$ts2 = strtotime($today);
				$diff = floor(($ts1 - $ts2)/3600/24);				
				if($date<=$today){
					mysql_query("UPDATE membership SET mem_status = 'STANDARD', exp_date = 'NULL' WHERE m_id=$mid");
					header("Location:home.php?m=1&r=0");
				}
				else if($diff<=7){
					header("Location:home.php?m=2&r=$diff");
				}
				else{
					header("Location:home.php");
				}
			}
			else{
				header("Location:home.php");
			}
		}
		else{
			header("Location:login.php?ac=WRONG");
		}
	}
	else{
		header("Location:login.php?ac=NO_SUBMIT");
	}	
}
?>