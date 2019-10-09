<!DOCTYPE HTML>
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
            generate();
        else:
            header('Location:forget_password.php?re=FAIL_CAPTCHA');
        endif;
    else:
        header('Location:forget_password.php?re=NO_SUBMIT_CAPTCHA');
    endif;
else:
	header('Location:forget_password.php?re=NO_SUBMIT');
endif;

function generate(){
	if(isset($_POST['submit'])){
		$username = $_POST['username'];
		$email = $_POST['email'];
		$sql = mysql_query("SELECT * FROM member WHERE username ='$username' AND email ='$email' ")or die(mysql_error());
		$match  = mysql_num_rows($sql);
		if($match>0){
			$new_pass = generateRandomString(8);
			$hashed_password = password_hash("$new_pass", PASSWORD_DEFAULT);
			mysql_query("UPDATE member SET password = '$hashed_password' WHERE email = '$email' AND username='$username'") or die(mysql_error());
			send_email($username,$email,$new_pass);
		}
		else{
			header('Location:forget_password.php?ac=WRONG');
		}
	}
	else{
		header('Location:forget_password.php?ac=NO_SUBMIT');
	}
}

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

function send_email($username,$email,$new_pass){
	$to      = $email;
	$subject = 'Reset Password | LuxToTrade';
	$message = "
	Dear $username,

	We have reeceive your reset password request!
	Your password is reset as below:
	-----------------------------------------------------------
	Password: $new_pass
	-----------------------------------------------------------
	To protect your privacy, please change the password as soon as possible.

	Best Regards,
	LuxToTrade Team
	";

	$headers = 'From:noreply@luxtotrade.com' . "\r\n";
	mail($to, $subject, $message, $headers);
}
$email = $_POST['email'];
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
    <title> Reset Password Process... | LuxToTrade COMP2121 Project</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/forget_form.css">
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
    <div class="assessment-container container" id="loginformcontainer">
        <div class="row">
            <div class="col-md-8 form-box">
                    <fieldset>
                        <div class="form-top">
                            <div class="form-top-left">
                                <h1>LuxToTrade<h1>
								<h3 style="style:200%;">DONE!</h3>
                            </div>
                        </div>
                        <div class="form-bottom">
							<div class="row" style="margin-top:1%;">
								<div class="col-md-10">
									<p>A new password has sent to your email adress(<?php echo $email; ?>), please use the new password to access the system and change  the password to protect your privacy.</p>
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
