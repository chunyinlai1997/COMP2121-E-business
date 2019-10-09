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
           create();
        else:
            header('Location:register.php?re=FAIL_CAPTCHA');
        endif;
    else:
        header('Location:register.php?re=NO_SUBMIT_CAPTCHA');
    endif;
else:
	header('Location:register.php?re=NO_SUBMIT');
endif;

function create(){
	if(isset($_POST['submit'])){
		$uname = $_POST['inputUsername'];
		$email = $_POST['inputEmail'];
		$password = $_POST['ConfirmPassword'];
		$fname = $_POST['inputFirstName'];
		$lname = $_POST['inputLastName'];
		$phone = $_POST['inputPhone'];
		$country = $_POST['inputCountry'];
		$address = $_POST['inputAddress'];
		$membership = $_POST['inputmembershiptype'];
		$invite = generateRandomString(5);
		$join = date("Y-m-d");
		$status	= "not-verify";
		$hashed_password = password_hash("$password", PASSWORD_DEFAULT);
		$v_hash = md5(rand(0,1000));
		$initial_balance = 0;
		$profiledefaultimg = "https://i.imgur.com/mNrotks.png";
		mysql_query("INSERT INTO member(username,password,email,firstname,lastname,phone,address,country,joindate,status,hash_verification,profileimg,invitation) VALUES('$uname','$hashed_password','$email','$fname','$lname','$phone','$address','$country','$join','$status','$v_hash','$profiledefaultimg','$invite')")or die(mysql_error());
		$sql = mysql_query("SELECT member.m_id FROM member WHERE member.username ='$uname'")or die(mysql_error());
		$result = mysql_fetch_array($sql,MYSQL_NUM);
		$mid =  $result[0];
		if($membership=="premium"){
			$exp_date = date('Y-m-d', strtotime($join. ' + 30 days'));
			mysql_query("INSERT INTO membership(m_id,mem_status,exp_date) VALUES('$mid','$membership','$exp_date')")or die(mysql_error());
			$amount = 29.9;
			$type = "Membership Fee";
			$cc = $_POST['cardnum'];
			mysql_query("INSERT INTO payment_b(payment_type,pay_date ,buyer_id ,amount,cc_num) VALUES('$type','$join','$mid','$amount','$cc')")or die(mysql_error());
		}
		else{
			mysql_query("INSERT INTO membership(m_id,mem_status) VALUES('$mid','$membership')")or die(mysql_error());
		}
		send_email($uname,$email,$v_hash);
	}
	else{
		header("register.php?re=NO_SUBMIT");
	}
}

function send_email($uname,$email,$v_hash){
	$to      = $email; // Send email to our user
	$subject = 'Account Verification| LuxToTrade'; // Give the email a subject
	$message = "
	Dear $uname,

	Thanks for signing up!
	Your account has been created, you can activate your account by pressing the url below.

	---------------------------------------------------------------------------------------

	Please click this link to activate your account:
	http://www2.comp.polyu.edu.hk/~15073415d/comp2121/Project/verify.php?v=activate&e=$email&h=$v_hash


	Thanks,

	LuxToTrade Team
	";

	$headers = 'From:noreply@luxtotrade.com' . "\r\n";
	mail($to, $subject, $message, $headers);
}

function generateRandomString($length = 5) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

$uname = $_POST['inputUsername'];
$email = $_POST['inputEmail'];
$membership = $_POST['inputmembershiptype'];

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
    <title>Registration Process... | LuxToTrade COMP2121 Project</title>
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
								<h3 style="style:200%;">WELCOME <?php echo $uname; ?></h3>
                            </div>
                        </div>
                        <div class="form-bottom">
							<div class="row" style="margin-top:1%;">
								<div class="col-md-10">
									<h3>Thank you for the registration. You are now the <?php echo $membership; ?> membership of LuxToTrade.</h3>
									<p>A verification email has sent to your email adress(<?php echo $email; ?>), you have to activate your account with the verification link.</p>
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
