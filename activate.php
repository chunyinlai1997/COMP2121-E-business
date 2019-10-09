<!DOCTYPE HTML>
<?php
include_once 'config.php';
include_once 'token.php';
if(!isloggedin()){
	header('Location:login.php?need_login=True');
}
if(isactivated()){
	header('Location:home.php');
}
$m_id = isloggedin();
$sql = mysql_query("SELECT profileimg,username,joindate,email,hash_verification FROM member WHERE m_id = '$m_id' ")or die(mysql_error());
$row = mysql_fetch_array($sql,MYSQL_NUM);

if(isset($_POST['submit'])){
	$email = $row[3];
	$uname = $row[1];
	$v_hash = md5(rand(0,1000));
	if($_POST['submit']=="new"){
		send_email($uname,$email,$v_hash);
		mysql_query("UPDATE member SET hash_verification='$v_hash' WHERE m_id = '$m_id' ")or die(mysql_error());
		$msg = "<div class='alert alert-info'><a class='close'data-dismiss='alert' href='#'>×</a>An activatoin email is already sent to your email address again.</div><script>document.getElementById('content').style.display ='none';</script>";
	}
	else if($_POST['submit']=="change"){
		$email = $_POST['email'];
		mysql_query("UPDATE member SET email='$email',hash_verification='$v_hash' WHERE m_id = '$m_id' ")or die(mysql_error());
		send_email($uname,$email,$v_hash);
		$msg = "<div class='alert alert-info'><a class='close'data-dismiss='alert' href='#'>×</a>An activatoin email is already sent to your new email address.</div><script>document.getElementById('content').style.display ='none';</script>";
	}
}

function send_email($uname,$email,$v_hash){
	$to      = $email; // Send email to our user
	$subject = 'Resend Account Verification| LuxToTrade'; // Give the email a subject
	$message = "
	Dear $uname,

	You have request for resend email activation email, you can activate your account by pressing the url below.

	---------------------------------------------------------------------------------------

	Please click this link to activate your account:
	http://www2.comp.polyu.edu.hk/~15073415d/comp2121/Project/verify.php?v=activate&e=$email&h=$v_hash

	---------------------------------------------------------------------------------------
	Due to security problem, the previous activation link is now disabled.

	Thanks,

	LuxToTrade Team
	";

	$headers = 'From:noreply@luxtotrade.com' . "\r\n";
	mail($to, $subject, $message, $headers);
}
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Just a frame made by Willon hahaha | Here is the discription">
		<meta name="keywords" content="HTML,CSS,PHP,Bootstrap,COMP,Project,polyu,comp,COMP,PolyU,Hong Kong,luxury,LUXTOT0TRADE">
		<meta name="author" content="Willon Lai">
		<title>Premium Membership Payment | LuxToTrade COMP2121 Project</title>
		<link rel="icon" href="https://cdn3.iconfinder.com/data/icons/business-office-2/512/tag-512.png" >
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<link rel="stylesheet" href="css/animate.css" />
		<link rel="stylesheet" href="css/waypoints.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="js/scroll.js"></script>
		<script src="js/waypoints.js"></script>
		<script src="js/waypoints.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
		<style>
		.wrap {
			margin-top:80px;
			padding-left : 50px;
			padding-right : 50px;

		}
		.wrap {
			width:100%;
		}
		.modal-backdrop
		{
			opacity:1 !important;
		}
		.alert {
			margin-top:150px;
		}
		</style>
		<script>
		function email_validate(email){
			var regMail = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
			if(regMail.test(email) == false)
			{
				document.getElementById("invalidemail").style.display = "block";
				document.getElementById("inputResetPasswordEmail").classList.add('is-invalid');
				document.getElementById("inputResetPasswordEmail").classList.remove('is-valid');
				document.getElementById("inputResetPasswordEmail").classList.remove('is-valid');
				document.getElementById("s1").disabled = true;
			}
			else
			{
				document.getElementById("inputResetPasswordEmail").classList.remove('is-invalid');
				document.getElementById("inputResetPasswordEmail").classList.add('is-valid');
				document.getElementById("invalidemail").style.display = "none";
				document.getElementById("s1").disabled = false;
			}
		}
		jQuery.noConflict();
		$(document).ready(function(){
			$('#inputResetPasswordEmail').change(function(){
				var email = $(this).val();
				$.ajax({
					url:"check.php",
					method:"POST",
					data:{email:email},
					dataType:"text",
					success:function(response){
						if(response==0){
							$('#invalidemail').css("color","green");
							$('#invalidemail').css("display", "block");
							$('#invalidemail').html("Available email address");
							$('#inputResetPasswordEmail').removeClass( "is-invalid" ).addClass( "is-valid" );
						}else{
							$('#invalidemail').css("color","red");
							$('#invalidemail').css("display", "block");
							$('#invalidemail').html("This email address is already used");
							$('#inputResetPasswordEmail').removeClass( "is-valid" ).addClass( "is-invalid" );
						}
					}
				});
			});
		});
		</script>
	</head>
	<body>
		<!--navbar-->
		<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="home">LuxToTrade</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#Navbar1" aria-controls="Navbar1"
				aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="Navbar1">
				<ul class="navbar-nav mr-auto">
				</ul>
				 <!-- Search form -->
				<ul class="navbar-nav ml-auto nav-flex-icons row">
					<li class="nav-item avatar dropdown">
						<a class="nav-link dropdown-toggle" id="DropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo $row[0]; ?>" class="img-fluid rounded-circle z-depth-0" width="30" height="30"><small><?php echo $row[1]; ?></small></a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="DropdownMenuLink1">
							<a class="dropdown-item" href="#">Help</a>
							<hr>
							<a class="dropdown-item" href="" data-toggle="modal" data-target="#Modal1">Logout</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>
		<!--Navbar -->

		<div class="wrap">
			<fieldset id="content" class="col-md-6 offset-md-3">
					<div class="form-top">
						<div class="form-top-left">
							<h1>Activation is required.</h1>
							<small style="font-size:80%;">Your account has to be activated before accessing our member system.</small>
						</div>
						<form role="form" action="activate.php" method="POST">
						<div class="form-bottom">
							<button type="submit" name="submit" value="new" class="btn btn-info">Get a new activation email</button>
							<hr>
							<div class="form-group">
                                    <label for="inputResetPasswordEmail">Change Email Address</label>
                                    <input type="email" class="form-control" onchange="email_validate(this.value);" onkeyup="email_validate(this.value);" name="email" id="inputResetPasswordEmail">
									  <div id="invalidemail" class="invalid-feedback" style="display:none;">
										Please provide a valid email address
									  </div>
									  <span id="helpResetPasswordEmail" class="form-text small text-muted">
                                      <a href="">Have problem with activation? Contact Us.</a></span>
							</div>
							<button type="submit" id="s1" name="submit" value="change" class="btn btn-primary" disabled>Change Email</button>
						</form>
						</div>
					</div>
			</fieldset>
			<?php
			if(isset($_POST['submit'])){
				 echo $msg;
			}
			?>
		</div>

		<div class="modal fade" id="Modal1" tabindex="-1" role="dialog" aria-labelledby="ModalContent1" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="ModalContent1">Logout?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true"></span>
					</button>
				  </div>
				  <div class="modal-body">
					Logout all device or this device?
					<form role="form" action="logout.php" method="POST">
						<button type="submit" name="L1" value="all" class="btn btn-danger">Logout All</button>
						<button type="submit" name="L2" value="this" class="btn btn-primary">Logout This Device</button>
					</form>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
		</div>

</body>
</html>
