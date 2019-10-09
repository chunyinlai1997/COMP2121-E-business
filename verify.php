<!DOCTYPE HTML>
<?php
	include_once 'config.php';
	include_once 'token.php';
	if(isloggedin()){
		header('Location:home.php');
	}
	$msg="";
	$flag="Verification Fail";
	if(isset($_GET['v']) && !empty($_GET['v']) AND isset($_GET['e']) && !empty($_GET['e']) AND isset($_GET['h']) && !empty($_GET['h'])){
		if($_GET['v']=="activate"){
			$email = mysql_escape_string($_GET['e']); 
			$hash = mysql_escape_string($_GET['h']);
			$sql = mysql_query("SELECT m_id, email, status, hash_verification FROM member WHERE email='$email' AND hash_verification='$hash'") or die(mysql_error()); 
			$row = mysql_fetch_array($sql,MYSQL_NUM);
			$match  = mysql_num_rows($sql);
			if($row[2]=="not-verify"){
				if($match > 0){
					$msg="Verification Success! Your account has activated now!";
					$flag="Verification Success!";
					$act = "verify";
					mysql_query("UPDATE member SET status = '$act', hash_verification = '' WHERE email = '$email'") or die(mysql_error()); 
				}
				else{
					$msg="Verification Error! We have send you a new verification link to your email address. If you have any diffculties, please <a href=''>Contact Us</a> for help.";
					$v_hash = md5(rand(0,1000));	
					mysql_query("UPDATE member SET hash_verification = '$v_hash' WHERE email = '$email'");
					send_email($email,$v_hash);
				}
			}
			else{
				header("Location:home.php");
			}
		}
		else{
			header("Location:index.html");
		}
	}
	else{
		header("Location:index.html");
	}
	
	function send_email($email,$v_hash){
		$to      = $email; // Send email to our user
		$subject = 'UPDATED! Account Verification| LuxToTrade'; // Give the email a subject 
		$message = "
		 
		Thanks for signing up!
		Your account has been created, you can activate your account by pressing the url below.
		 
		---------------------------------------------------------------------------------------
		 
		Please click this link to activate your account:
		http://www2.comp.polyu.edu.hk/~15073415d/comp2121/Project/verify.php?e='.$email.'&h='.$v_hash.'
		
		
		Thanks,
		
		LuxToTrade Team
		"; 
							 
		$headers = 'From:noreply@luxtotrade.com' . "\r\n"; 
		mail($to, $subject, $message, $headers);	
	}
?>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<meta name="description" content="Just a frame made by Willon hahaha | Here is the discription">
	<meta name="keywords" content="HTML,CSS,PHP,Bootstrap,COMP,Project,polyu,comp,COMP,PolyU,Hong Kong">
	<meta name="author" content="Willon Lai">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="icon" href="https://cdn3.iconfinder.com/data/icons/business-office-2/512/tag-512.png" >
    <title> Verify account | LuxToTrade COMP2121 Project</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">	
	<link rel="stylesheet" href="css/register_form.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	<script src="js/waypoints.js"></script>	
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>	
</head>
<body>
<div class="container">
    <div class="assessment-container container" id="registerformcontainer">
        <div class="row">
            <div class="col-md-8 form-box">
                    <fieldset>
                        <div class="form-top">
                            <div class="form-top-left">
                                <h1>LuxToTrade<h1>
								<h3 style="style:200%;"><?php echo $flag;  ?></h3>
                            </div> 
                        </div>
                        <div class="form-bottom">
							<div class="row" style="margin-top:1%;">
								<div class="col-md-10">        		
									<h5><?php echo $msg; ?></h5>
								</div>
							</div>
							<div class="row" style="margin-top:1%;">
								<div class="col-md-10">        		
									<a href="login"><button type="button" class="btn btn-secondary">Login</button></a>
									<a href="index.html"><button type="button" class="btn btn-secondary">Home</button></a>
								</div>
							</div>
						</div>
					</fieldset>
			</div>
		</div>
	</div>
</div>
</body>
</html>