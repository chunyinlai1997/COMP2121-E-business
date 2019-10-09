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
			return "Fail Submission or Timeout! Try Again.";
		}
	}
?>
<html id="registerform" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
		<meta name="description" content="Just a frame made by Willon hahaha | Here is the discription">
		<meta name="keywords" content="HTML,CSS,PHP,Bootstrap,COMP,Project,polyu,comp,COMP,PolyU,Hong Kong">
		<meta name="author" content="Willon Lai">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="icon" href="images/brand_logo_small_icon.png" >
    <title>Register Page | LuxToTrade COMP2121 Project</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/captcha.css">
	<link rel="stylesheet" href="css/register_form.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	<script src="js/waypoints.js"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<script type="text/javascript" src="js/validate.js"></script>
</head>
<body>
<script>
 jQuery.noConflict();
 $(document).ready(function () {
    $('.registration-form fieldset:first-child').fadeIn('slow');
    // next step
    $('.registration-form .btn-next').on('click', function () {
        var parent_fieldset = $(this).parents('fieldset');
        var next_step = true;
        if (next_step) {
            parent_fieldset.fadeOut(400, function () {
                $(this).next().fadeIn();
            });
        }
    });

    // previous step
    $('.registration-form .btn-previous').on('click', function () {
        $(this).parents('fieldset').fadeOut(400, function () {
            $(this).prev().fadeIn();
        });
    });

});
</script>
<body>
<div class="container">
    <div class="assessment-container container" id="registerformcontainer">
        <div class="row">
            <div class="col-md-8 form-box">
                <form role="form" class="registration-form" method="POST" action="action_register.php">
                    <fieldset>
                        <div class="form-top">
                            <div class="form-top-left">
                                <h1>LuxToTrade<h1>
								<h3>SIGN UP</h3>
								<h3>Step 1: Account Information</h3>
                            </div>
                        </div>
                        <div class="form-bottom">
                            <div class="col-md-10">
							<?php
								$error1 = "<div class='alert alert-danger'><a class='close'data-dismiss='alert' href='#'>×</a>";
								$error2 = "</div>";
								if(isset($_GET["re"])){
									$msg = re_fail();
									echo $error1.$msg.$error2;
								}
							?>
							</div>
							<div class="form-row">
								<div class="form-group col-md-6 col-sm-12">
								  <label for="inputUsername" class="col-form-label">Username</label>
								  <input type="text" class="form-control" id="inputUsername" name="inputUsername" minlength="6" maxlength="30" placeholder="Username for login" onkeyup = "checkusername(this);" onchange = "checkusername(this);" >
								  <div id="vUser" class="invalid-feedback" style="display:none;"></div>
								  <div id="vUser2" class="invalid-feedback" style="display:none;"></div>
								</div>
								<div class="form-group col-md-6 col-sm-12">
								  <label for="inputEmail" class="col-form-label">Email</label>
								  <input type="email" class="form-control" id="inputEmail" name="inputEmail" onkeyup="email_validate(this.value);" onchange="email_validate(this.value);" placeholder="Input Email" >
								  <div id="invalidemail" class="invalid-feedback" style="display:none;">
										Please provide a valid email address
								  </div>
								  <div id="invalidemail2" class="invalid-feedback" style="display:none;">
								  </div>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-6 col-sm-12">
								  <label for="inputPassword" class="col-form-label">Password</label>
								  <input type="password" class="form-control" id="inputPassword"  name="inputPassword" minlength="6" maxlength="20" placeholder="Input Password" onchange="validatePass(this.value);" >
								  <div id="invalidPassword" class="invalid-feedback" style="display:none;">
								  </div>
								</div>
								<div class="form-group col-md-6 col-sm-12">
								  <label for="ConfirmPassword" class="col-form-label">Confirm Password</label>
								  <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword" placeholder="Confirm the Password" onkeyup="checkPass();next_btn1();" >
								  <div id="vPass" class="invalid-feedback" style="display:none;">
								  </div>
								</div>
							</div>
							<button type="button" id="next1" class="btn btn-next" disabled>Next</button>
							<hr style="background-color:black;">
							<div class="col-md-12">
								<a href="login"><button id="login_register_btn" type="button" class="btn btn-outline-danger">Login</button></a>
								<a href="index.html"><button type="button" class="btn btn-outline-primary">Home</button></a>
							</div>
							<small>Copyright &copy; LuxToTrade, a company of Tangible. All rights reserved.</small>
                        </div>
                    </fieldset>
					<fieldset>
						<div class="form-top">
							<div class="form-top-left">
								<h1>LuxToTrade<h1>
								<h3>SIGN UP</h3>
								<h3>Step 2: Contact Information</h3>
							</div>
						</div>
						<div class="form-bottom">
							<div class="form-row">
								<div class="form-group col-md-6">
								  <label for="inputFirstName" class="col-form-label">First Name</label>
								  <input type="text" class="form-control" id="inputFirstName" name="inputFirstName" minlength="1" maxlength="50" placeholder="First Name in English" onkeyup="validate_First(this);" >
								  <div id="vFirst" class="invalid-feedback" style="display:none;">
								  </div>
								</div>
								<div class="form-group col-md-6">
								  <label for="inputLastName" class="col-form-label">Last Name</label>
								  <input type="text" class="form-control" id="inputLastName" name="inputLastName" minlength="1" maxlength="50" placeholder="Last Name in English" onkeyup="validate_Last(this);" >
								  <div id="vLast" class="invalid-feedback" style="display:none;">
								  </div>
								</div>
							  </div>
							<div class="form-group">
								<label for="inputAddress" class="col-form-label">Address</label>
								<input type="text" class="form-control" id="inputAddress" name="inputAddress" minlength="3" maxlength="90" placeholder="e.g. 1234 Main St, ABC District"  onkeyup="validate_add(this);" >
								 <div id="vAddress" class="invalid-feedback" style="display:none;">
								 </div>
							  </div>
							<div class="form-row">
							<div class="form-group col-md-6">
							  <label for="inputPhone" class="col-form-label">Phone Number</label>
							  <input type="text" class="form-control" id="inputPhone" name="inputPhone" minlength="4" maxlength="20" placeholder="Phone number" onkeyup="validatephone(this);" >
							  <div id="vphone" class="invalid-feedback" style="display:none;">Invalid Phone Number
							  </div>
							</div>
							<div class="form-group col-md-6">
							  <label for="inputCountry" class="col-form-label">Country</label>
							  <select class="form-control" id="inputCountries" name="inputCountry" onchange="validate_country()" >
								<option value="blank" selected>Choose...</option>
								<option value="Afganistan">Afghanistan</option>
								<option value="Albania">Albania</option>
								<option value="Algeria">Algeria</option>
								<option value="American Samoa">American Samoa</option>
								<option value="Andorra">Andorra</option>
								<option value="Angola">Angola</option>
								<option value="Anguilla">Anguilla</option>
								<option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
								<option value="Argentina">Argentina</option>
								<option value="Armenia">Armenia</option>
								<option value="Aruba">Aruba</option>
								<option value="Australia">Australia</option>
								<option value="Austria">Austria</option>
								<option value="Azerbaijan">Azerbaijan</option>
								<option value="Bahamas">Bahamas</option>
								<option value="Bahrain">Bahrain</option>
								<option value="Bangladesh">Bangladesh</option>
								<option value="Barbados">Barbados</option>
								<option value="Belarus">Belarus</option>
								<option value="Belgium">Belgium</option>
								<option value="Belize">Belize</option>
								<option value="Benin">Benin</option>
								<option value="Bermuda">Bermuda</option>
								<option value="Bhutan">Bhutan</option>
								<option value="Bolivia">Bolivia</option>
								<option value="Bonaire">Bonaire</option>
								<option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
								<option value="Botswana">Botswana</option>
								<option value="Brazil">Brazil</option>
								<option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
								<option value="Brunei">Brunei</option>
								<option value="Bulgaria">Bulgaria</option>
								<option value="Burkina Faso">Burkina Faso</option>
								<option value="Burundi">Burundi</option>
								<option value="Cambodia">Cambodia</option>
								<option value="Cameroon">Cameroon</option>
								<option value="Canada">Canada</option>
								<option value="Canary Islands">Canary Islands</option>
								<option value="Cape Verde">Cape Verde</option>
								<option value="Cayman Islands">Cayman Islands</option>
								<option value="Central African Republic">Central African Republic</option>
								<option value="Chad">Chad</option>
								<option value="Channel Islands">Channel Islands</option>
								<option value="Chile">Chile</option>
								<option value="China">China</option>
								<option value="Christmas Island">Christmas Island</option>
								<option value="Cocos Island">Cocos Island</option>
								<option value="Colombia">Colombia</option>
								<option value="Comoros">Comoros</option>
								<option value="Congo">Congo</option>
								<option value="Cook Islands">Cook Islands</option>
								<option value="Costa Rica">Costa Rica</option>
								<option value="Cote DIvoire">Cote D'Ivoire</option>
								<option value="Croatia">Croatia</option>
								<option value="Cuba">Cuba</option>
								<option value="Curaco">Curacao</option>
								<option value="Cyprus">Cyprus</option>
								<option value="Czech Republic">Czech Republic</option>
								<option value="Denmark">Denmark</option>
								<option value="Djibouti">Djibouti</option>
								<option value="Dominica">Dominica</option>
								<option value="Dominican Republic">Dominican Republic</option>
								<option value="East Timor">East Timor</option>
								<option value="Ecuador">Ecuador</option>
								<option value="Egypt">Egypt</option>
								<option value="El Salvador">El Salvador</option>
								<option value="Equatorial Guinea">Equatorial Guinea</option>
								<option value="Eritrea">Eritrea</option>
								<option value="Estonia">Estonia</option>
								<option value="Ethiopia">Ethiopia</option>
								<option value="Falkland Islands">Falkland Islands</option>
								<option value="Faroe Islands">Faroe Islands</option>
								<option value="Fiji">Fiji</option>
								<option value="Finland">Finland</option>
								<option value="France">France</option>
								<option value="French Guiana">French Guiana</option>
								<option value="French Polynesia">French Polynesia</option>
								<option value="French Southern Ter">French Southern Ter</option>
								<option value="Gabon">Gabon</option>
								<option value="Gambia">Gambia</option>
								<option value="Georgia">Georgia</option>
								<option value="Germany">Germany</option>
								<option value="Ghana">Ghana</option>
								<option value="Gibraltar">Gibraltar</option>
								<option value="Great Britain">Great Britain</option>
								<option value="Greece">Greece</option>
								<option value="Greenland">Greenland</option>
								<option value="Grenada">Grenada</option>
								<option value="Guadeloupe">Guadeloupe</option>
								<option value="Guam">Guam</option>
								<option value="Guatemala">Guatemala</option>
								<option value="Guinea">Guinea</option>
								<option value="Guyana">Guyana</option>
								<option value="Haiti">Haiti</option>
								<option value="Hawaii">Hawaii</option>
								<option value="Honduras">Honduras</option>
								<option value="Hong Kong">Hong Kong</option>
								<option value="Hungary">Hungary</option>
								<option value="Iceland">Iceland</option>
								<option value="India">India</option>
								<option value="Indonesia">Indonesia</option>
								<option value="Iran">Iran</option>
								<option value="Iraq">Iraq</option>
								<option value="Ireland">Ireland</option>
								<option value="Isle of Man">Isle of Man</option>
								<option value="Israel">Israel</option>
								<option value="Italy">Italy</option>
								<option value="Jamaica">Jamaica</option>
								<option value="Japan">Japan</option>
								<option value="Jordan">Jordan</option>
								<option value="Kazakhstan">Kazakhstan</option>
								<option value="Kenya">Kenya</option>
								<option value="Kiribati">Kiribati</option>
								<option value="Korea North">Korea North</option>
								<option value="Korea Sout">Korea South</option>
								<option value="Kuwait">Kuwait</option>
								<option value="Kyrgyzstan">Kyrgyzstan</option>
								<option value="Laos">Laos</option>
								<option value="Latvia">Latvia</option>
								<option value="Lebanon">Lebanon</option>
								<option value="Lesotho">Lesotho</option>
								<option value="Liberia">Liberia</option>
								<option value="Libya">Libya</option>
								<option value="Liechtenstein">Liechtenstein</option>
								<option value="Lithuania">Lithuania</option>
								<option value="Luxembourg">Luxembourg</option>
								<option value="Macau">Macau</option>
								<option value="Macedonia">Macedonia</option>
								<option value="Madagascar">Madagascar</option>
								<option value="Malaysia">Malaysia</option>
								<option value="Malawi">Malawi</option>
								<option value="Maldives">Maldives</option>
								<option value="Mali">Mali</option>
								<option value="Malta">Malta</option>
								<option value="Marshall Islands">Marshall Islands</option>
								<option value="Martinique">Martinique</option>
								<option value="Mauritania">Mauritania</option>
								<option value="Mauritius">Mauritius</option>
								<option value="Mayotte">Mayotte</option>
								<option value="Mexico">Mexico</option>
								<option value="Midway Islands">Midway Islands</option>
								<option value="Moldova">Moldova</option>
								<option value="Monaco">Monaco</option>
								<option value="Mongolia">Mongolia</option>
								<option value="Montserrat">Montserrat</option>
								<option value="Morocco">Morocco</option>
								<option value="Mozambique">Mozambique</option>
								<option value="Myanmar">Myanmar</option>
								<option value="Nambia">Nambia</option>
								<option value="Nauru">Nauru</option>
								<option value="Nepal">Nepal</option>
								<option value="Netherland Antilles">Netherland Antilles</option>
								<option value="Netherlands">Netherlands (Holland, Europe)</option>
								<option value="Nevis">Nevis</option>
								<option value="New Caledonia">New Caledonia</option>
								<option value="New Zealand">New Zealand</option>
								<option value="Nicaragua">Nicaragua</option>
								<option value="Niger">Niger</option>
								<option value="Nigeria">Nigeria</option>
								<option value="Niue">Niue</option>
								<option value="Norfolk Island">Norfolk Island</option>
								<option value="Norway">Norway</option>
								<option value="Oman">Oman</option>
								<option value="Pakistan">Pakistan</option>
								<option value="Palau Island">Palau Island</option>
								<option value="Palestine">Palestine</option>
								<option value="Panama">Panama</option>
								<option value="Papua New Guinea">Papua New Guinea</option>
								<option value="Paraguay">Paraguay</option>
								<option value="Peru">Peru</option>
								<option value="Phillipines">Philippines</option>
								<option value="Pitcairn Island">Pitcairn Island</option>
								<option value="Poland">Poland</option>
								<option value="Portugal">Portugal</option>
								<option value="Puerto Rico">Puerto Rico</option>
								<option value="Qatar">Qatar</option>
								<option value="Republic of Montenegro">Republic of Montenegro</option>
								<option value="Republic of Serbia">Republic of Serbia</option>
								<option value="Reunion">Reunion</option>
								<option value="Romania">Romania</option>
								<option value="Russia">Russia</option>
								<option value="Rwanda">Rwanda</option>
								<option value="St Barthelemy">St Barthelemy</option>
								<option value="St Eustatius">St Eustatius</option>
								<option value="St Helena">St Helena</option>
								<option value="St Kitts-Nevis">St Kitts-Nevis</option>
								<option value="St Lucia">St Lucia</option>
								<option value="St Maarten">St Maarten</option>
								<option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
								<option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
								<option value="Saipan">Saipan</option>
								<option value="Samoa">Samoa</option>
								<option value="Samoa American">Samoa American</option>
								<option value="San Marino">San Marino</option>
								<option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
								<option value="Saudi Arabia">Saudi Arabia</option>
								<option value="Senegal">Senegal</option>
								<option value="Serbia">Serbia</option>
								<option value="Seychelles">Seychelles</option>
								<option value="Sierra Leone">Sierra Leone</option>
								<option value="Singapore">Singapore</option>
								<option value="Slovakia">Slovakia</option>
								<option value="Slovenia">Slovenia</option>
								<option value="Solomon Islands">Solomon Islands</option>
								<option value="Somalia">Somalia</option>
								<option value="South Africa">South Africa</option>
								<option value="Spain">Spain</option>
								<option value="Sri Lanka">Sri Lanka</option>
								<option value="Sudan">Sudan</option>
								<option value="Suriname">Suriname</option>
								<option value="Swaziland">Swaziland</option>
								<option value="Sweden">Sweden</option>
								<option value="Switzerland">Switzerland</option>
								<option value="Syria">Syria</option>
								<option value="Tahiti">Tahiti</option>
								<option value="Taiwan">Taiwan</option>
								<option value="Tajikistan">Tajikistan</option>
								<option value="Tanzania">Tanzania</option>
								<option value="Thailand">Thailand</option>
								<option value="Togo">Togo</option>
								<option value="Tokelau">Tokelau</option>
								<option value="Tonga">Tonga</option>
								<option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
								<option value="Tunisia">Tunisia</option>
								<option value="Turkey">Turkey</option>
								<option value="Turkmenistan">Turkmenistan</option>
								<option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
								<option value="Tuvalu">Tuvalu</option>
								<option value="Uganda">Uganda</option>
								<option value="Ukraine">Ukraine</option>
								<option value="United Arab Erimates">United Arab Emirates</option>
								<option value="United Kingdom">United Kingdom</option>
								<option value="United States of America">United States of America</option>
								<option value="Uraguay">Uruguay</option>
								<option value="Uzbekistan">Uzbekistan</option>
								<option value="Vanuatu">Vanuatu</option>
								<option value="Vatican City State">Vatican City State</option>
								<option value="Venezuela">Venezuela</option>
								<option value="Vietnam">Vietnam</option>
								<option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
								<option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
								<option value="Wake Island">Wake Island</option>
								<option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
								<option value="Yemen">Yemen</option>
								<option value="Zaire">Zaire</option>
								<option value="Zambia">Zambia</option>
								<option value="Zimbabwe">Zimbabwe</option>
							  </select>
							  <div id="vcountry" class="invalid-feedback" style="display:none;">
							  </div>
							</div>
						  </div>
						  <hr>
							<button type="button" class="btn btn-previous">Previous</button>
							<button type="button" id="next2" class="btn btn-next" disabled>Next</button>
						</div>
					</fieldset>
					<fieldset>
                        <div class="form-top">
                            <div class="form-top-left">
                                <h1>LuxToTrade<h1>
								<h3>SIGN UP</h3>
								<h3>Step 3: Choose Membership Type</h3>
                                </p>
                            </div>
                        </div>
                        <div class="form-bottom">
							<label for="inputmembershiptype" class="col-form-label">Membership Type</label>
							<select id="membershiptype" name="inputmembershiptype" class="form-control" onchange="membertype();" onkeyup="membertype();" style="margin-buttom:20px;">
								<option value="blank" selected>Choose...</option>
								<option value="standard">STANDARD</option>
								<option value="premium">PREMIUM</option>
							</select>
							<div id="vmembership" class="invalid-feedback" style="display:none;"></div>
							<hr>
							<button type="button" class="btn btn-previous btn-large">Previous</button>
							<button type="button" id="next3" class="btn btn-next" disabled>Next</button>
                        </div>
                    </fieldset>
					<fieldset>
						<div class="form-top">
							<div class="form-top-left">
								<h1>LuxToTrade<h1>
								<h3 id="ind">Credit card payment</h3>
							</div>
						</div>
						<div class="form-bottom">
						  <div class="col-md-10 my-4 mx-auto" id="adv">
								<h2 class="text-center">What We Provide</h2>
								<hr>
								<div class="row">
									<div class="col-md-12 pl-1">
										<div class="list-group text-center bg-alt" style="font-size:140%;">
											<div class="list-group-item text-white" style="background-color:red;">
												<h4 class="text-center my-1">Premium <span class="badge badge-info">NEW</span></h4>
											</div>
											<div class="list-group-item text-uppercase font-weight-bold">
												$29.99HKD/30 Days
											</div>
											<div class="list-group-item font-weight-bold">
												Unlimited Item Spaces
											</div>
											<div class="list-group-item font-weight-bold">
												Frequent & Top Listing
											</div>
											<div class="list-group-item font-weight-bold">
												Free Quality Proof Service
											</div>
											<div class="list-group-item font-weight-bold">
												Service Fee  50% Off
											</div>
											<div class="list-group-item font-weight-bold">
												Shipping Fee 50% Off
											</div>
											<div class="list-group-item font-weight-bold">
												Storage Fee 50% Off
											</div>
											<div class="list-group-item font-weight-bold">
												Auto Advertising
											</div>
											<div class="list-group-item font-weight-bold">
												No Ads
											</div>
										</div>
									</div>
								</div>
								<hr>
							</div>
						  <div class="card card-block" id="payform" style="display:none;margin-buttom:20px;">
							<!-- form card cc payment -->
							<div class="card card-outline-secondary" style="padding:10px;">
								<div class="card-block">
									<div class="form-group text-center">
										<ul class="list-inline">
											<li class="list-inline-item"><i class="text-muted fa fa-cc-visa fa-2x"></i></li>
											<li class="list-inline-item"><i class="fa fa-cc-mastercard fa-2x"></i></li>
											<li class="list-inline-item"><i class="fa fa-cc-amex fa-2x"></i></li>
											<li class="list-inline-item"><i class="fa fa-cc-discover fa-2x"></i></li>
										</ul>
									</div>
									<hr>
									<!--
									<div class="alert alert-info">
										<a class="close" data-dismiss="alert" href="#">×</a>CVC code is required.
									</div>
									-->
										<div class="form-group">
											<label for="cc_name">Card Holder's Name</label>
											<input type="text" class="form-control" id="cc_name" onkeyup="check_hname(this);"  name="cc_name" title="First and last name" >
										</div>
										<div id="vcname" class="invalid-feedback" style="display:none;"></div>
										<div class="form-group">
											<label>Card Number</label>
											<div class="input-group">
												<div class="input-group-addon" id="cardtype" style="dsiplay:none;"></div>
												<input type="text" class="form-control" name="cardnum" autocomplete="off" maxlength="20" id="cardnum" onkeyup="CardNumber();" onchange="CardNumber();" title="Credit card number" >
											</div>
										</div>
										<div id="vcnum" class="invalid-feedback" style="display:none;"></div>
										<div class="form-group row">
											<label class="col-sm-10">Card Exp. Date</label>
											<div class="col-md-4">
												<select id="exMonth" name="cc_exp_mo" class="form-control" onchange="check_exp();" onkeyup="check_exp();" size="0">
													<option value="1">01</option>
													<option value="2">02</option>
													<option value="3">03</option>
													<option value="4">04</option>
													<option value="5">05</option>
													<option value="6">06</option>
													<option value="7">07</option>
													<option value="8">08</option>
													<option value="9">09</option>
													<option value="10">10</option>
													<option value="11">11</option>
													<option value="12">12</option>
												</select>
											</div>
											<div class="col-md-4">
												<select id="exYear" name="cc_exp_yr" class="form-control" onchange="check_exp();" onkeyup="check_exp();"  size="0">
													<option value="2017">2017</option>
													<option value="2018">2018</option>
													<option value="2019">2019</option>
													<option value="2020">2020</option>
													<option value="2021">2021</option>
													<option value="2022">2022</option>
													<option value="2023">2023</option>
													<option value="2024">2024</option>
													<option value="2025">2025</option>
													<option value="2026">2026</option>
													<option value="2027">2027</option>
												</select>
											</div>
											<div class="col-md-4">
												<input type="text" class="form-control" autocomplete="off" maxlength="3" onkeyup="check_cvc(this);" id="cvc" pattern="\d{3}" title="Three digits at back of your card" placeholder="CVC">
											</div>
										</div>
										<div id="vdate" class="invalid-feedback" style="display:none;"></div>
										<div id="vcvc" class="invalid-feedback" style="display:none;"></div>
										<div class="row">
											<label class="col-md-12">Amount</label>
										</div>
										<div class="form-inline">
											<div class="input-group">
												<div class="input-group-addon">$</div>
												<input type="text" class="form-control text-right" id="exampleInputAmount" placeholder="29.9" disabled>
												<div class="input-group-addon">First 30 days</div>
											</div>
										</div>
										<hr>
								</div>
							</div>
							<!-- /form card cc payment -->
						</div>
						<button type="button" class="btn btn-previous btn-large">Previous</button>
						<button type="button" id="next4" class="btn btn-next" disabled>Next</button>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-top">
							<div class="form-top-left">
								<h1>LuxToTrade<h1>
								<h3>SIGN UP</h3>
								<h3>Step 4: Confirm</h3>
							</div>
						</div>
						<div class="form-bottom">

							<div class="form-check">
							  <label class="form-check-label">
								<input class="form-check-input" id="agree1" type="checkbox" name="agreement" onchange="validate_agree();">
								When you Register, you agree to our <a href="" data-toggle="modal" data-target="#Modal1">User Agreement</a> and acknowledge reading our User <a href="" data-toggle="modal" data-target="#Modal2">Privacy Policy</a>.
							  </label>
							  <div class="recaptcha g-recaptcha" data-sitekey="6LcN5jQUAAAAAIHtiXMKYDvCGvfmu0OVothxYUBc"></div>
							</div>
							<button type="button" class="btn btn-previous">Previous</button>
							<button type="submit" class="btn submit" id="reg_submit" name="submit" value="submit" disabled>Submit</button>
						</div>

					</fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Modal1" tabindex="-1" role="dialog" aria-labelledby="ModalContent1" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="ModalContent1">User Agreement</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		...
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	  </div>
	</div>
  </div>
</div>
<div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="ModalContent2" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="ModalContent2">Privacy Policy</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		...
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	  </div>
	</div>
  </div>
</div>
<script>
$(document).ready(function () {
	$('#inputUsername').keyup(function(){
		var username = $(this).val();
		$.ajax({
			url:"check.php",
			method:"POST",
			data:{username:username},
			dataType:"text",
			success:function(response){
				if(username.length>5){
					if(response==0){
						$('#vUser2').css("color","green");
						$('#vUser2').css("display", "block");
						$('#vUser2').html("Available username.");
						$('#inputUsername').removeClass( "is-invalid" ).addClass( "is-valid" );
					}else{
						$('#vUser2').css("color","red");
						$('#vUser2').css("display", "block");
						$('#vUser2').html("Username is already used.");
						$('#inputUsername').removeClass( "is-valid" ).addClass( "is-invalid" );
					}
				}
			}
		});
	});
	$('#inputEmail').change(function(){
		var email = $(this).val();
		$.ajax({
			url:"check.php",
			method:"POST",
			data:{email:email},
			dataType:"text",
			success:function(response){
				if($('#invalidemail').css('display') == 'none' && email.length>3){
					if(response==0){
						$('#invalidemail2').css("color","green");
						$('#invalidemail2').css("display", "block");
						$('#invalidemail2').html("Available email address");
						$('#inputEmail').removeClass( "is-invalid" ).addClass( "is-valid" );
					}else{
						$('#invalidemail2').css("color","red");
						$('#invalidemail2').css("display", "block");
						$('#invalidemail2').html("This email address is already used");
						$('#inputEmail').removeClass( "is-valid" ).addClass( "is-invalid" );
					}
				}
			}
		});
	});
	$("#reg_submit" ).click(function(e) {
		if(grecaptcha.getResponse() == "") {
			e.preventDefault();
			alert("Captcha is Missing!");
		}
	});
});
</script>
</body>
</html>
