<!DOCTYPE HTML>
<?php
	include_once 'config.php';
	include_once 'token.php';
	if(isloggedin()){
		header('Location:home.php');
	}

	function re_fail(){
		if($_GET["re"]=="FAIL_CAPTCHA"){
			return "Fail Captcha Verification! Try Again.";
		}
		else if($_GET["re"]=="NO_SUBMIT_CAPTCHA"){
			return "No Captcha Submission! Try Again.";
		}
		else if($_GET["re"]=="NO_SUBMIT"){
			return "Fail Login Submission or Timeout! Try Again.";
		}
	}

	function ac_fail(){
		if($_GET["ac"]=="WRONG"){
			return "Wrong username or password! Try Again!";
		}
		else if($_GET["ac"]=="NO_SUBMIT"){
			return "Empty Login Submission! Try Again.";
		}
	}

	function need_login(){
		if($_GET["need_login"]=="True"){
			return "Login to continue.";
		}
	}
?>
<html lang="en">
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
		<meta name="description" content="Just a frame made by Willon hahaha | Here is the discription">
		<meta name="keywords" content="HTML,CSS,PHP,Bootstrap,COMP,Project,polyu,comp,COMP,PolyU,Hong Kong">
		<meta name="author" content="Willon Lai">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="icon" href="images/brand_logo_small_icon.png" >
    <!-- Site Properties -->
    <title>Login Page | LuxToTrade COMP2121 Project </title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	<link rel="stylesheet" href="css/captcha.css">
	<link rel="stylesheet" href="css/login_form.css">
	<script src="js/waypoints.js"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>
<body>
	<div class="container">
		<div class="assessment-container container" id="loginformcontainer">
		<div class="row">
            <div class="col-md-8 form-box">
                <form role="form" class="login-form" method="POST" action="action_login.php">
                    <fieldset>
                        <div class="form-top">
                            <div class="form-top-left">
                                <h1>LuxToTrade<h1>
								<h3>LOGIN</h3>
								<h3>Simple, Fast, Secure</h3>
                            </div>
                        </div>
						<div class="form-bottom">
						<div class="row" style="margin-top:1%;">
						<div class="col-md-10">
						<?php
							$error1 = "<div class='alert alert-danger'><a class='close'data-dismiss='alert' href='#'>×</a>";
							$error2 = "</div>";
							if(isset($_GET["re"])){
								$msg = re_fail();
								echo $error1.$msg.$error2;
							}
							else if(isset($_GET["ac"])){
								$msg = ac_fail();
								echo $error1.$msg.$error2;
							}
							else if(isset($_GET["need_login"])){
								$msg = need_login();
								echo $error1.$msg.$error2;
							}
						?>
						</div>
						</div>
						<div class="row">
							<div class="col-md-2"></div>
							<div class="col-md-6">
								<div class="form-group has-danger">
									<label class="sr-only" for="username">Username</label>
									<div class="input-group mb-2 mr-sm-2 mb-sm-0">
										<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-users"></i></div>
										<input type="text" name="username" class="form-control" id="username"
											   placeholder="Username Here" minlength="6" maxlength="30"  required autofocus>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2"></div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="sr-only" for="password">Password</label>
									<div class="input-group mb-2 mr-sm-2 mb-sm-0">
										<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
										<input type="password" name="password" class="form-control" id="password"
											   placeholder="Password" minlength="6" maxlength="20" required>
									</div>
								</div>
							</div>
						</div>
						<div class="row" style="padding-top: 1rem">
							<div class="col-md-2"></div>
							<div class="col-md-6">
								<div class="recaptcha g-recaptcha" data-sitekey="6LcN5jQUAAAAAIHtiXMKYDvCGvfmu0OVothxYUBc"></div>
							</div>
						</div>

						<div class="row" style="padding-top: 1rem">
							<div class="col-md-2"></div>
							<div class="col-md-6">
								<button type="submit" id="submit" name="submit" value="SUBMIT" class="btn btn-success btn-lg"><i class="fa fa-sign-in"></i> Login</button>
							</div>
						</div>
						<div class="row" style="padding-top: 1rem">
							<div class="col-md-3">
								<a class="btn btn-link" href="forget_password">Forgot Your Password?</a>
							</div>
							<hr>
							<div class="col-md-6">
								<a href="register"><button id="login_register_btn" type="button" class="btn btn-danger">Register</button></a>
								<a href="index.html"><button type="button" class="btn btn-secondary">Home</button></a>
							</div>
						</div>
						<small>Copyright &copy; LuxToTrade, a company of Tangible. All rights reserved.</small>
						</div>
					</fieldset>

				</form>
			</div>
		</div>
		</div>
	</div>
<script>
$(document).ready(function () {
	$("#submit" ).click(function(e) {
		if(grecaptcha.getResponse() == "") {
			e.preventDefault();
			alert("Captcha is Missing!");
		}
	});
});
</script>
</body>
</html>
