var type = 0;
function checkusername(inputUsername) {
	var ac = inputUsername.value;
    var newac = ac.replace(/[\\ !"£$%^&\,*+_=(){};:'@#~,.Š\/<>?|`¬\]\[]/g,'');
	inputUsername.value = newac;
	if(ac.length <= 30 && ac.length >= 6){
		document.getElementById("inputUsername").classList.add('is-valid');
		document.getElementById("inputUsername").classList.remove('is-invalid');
		document.getElementById("vUser").style.display = "none";
	}else{
		document.getElementById("inputUsername").classList.remove('is-valid');
		document.getElementById("inputUsername").classList.add('is-invalid');
		document.getElementById("vUser").style.display = "block";
		document.getElementById("vUser").innerHTML = "Username too short!";
	}
	next_btn1();
}

function email_validate(email)
{
	var regMail = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
    if(regMail.test(email) == false)
    {
		document.getElementById("invalidemail").style.display = "block";
		document.getElementById("inputEmail").classList.add('is-invalid');
		document.getElementById("inputEmail").classList.remove('is-valid');
    }
    else	
    {
		document.getElementById("inputEmail").classList.remove('is-invalid');
		document.getElementById("inputEmail").classList.add('is-valid');	
		document.getElementById("invalidemail").style.display = "none";
    }
	next_btn1();
}

function validatephone(phone) 
{
    var maintainplus = '';
    var numval = phone.value;
    if ( numval.charAt(0)=='+' )
    {
        var maintainplus = '';
    }
    curphonevar = numval.replace(/[\\ A-Za-z!"£$%^&\,*+_={};:'@#~,.Š\/<>?|`¬\]\[]/g,'');
    phone.value = maintainplus + curphonevar;
    var maintainplus = '';
    phone.focus;
	if(numval.length >= 4 && numval.length <= 20){
		document.getElementById("inputPhone").classList.remove('is-invalid');
		document.getElementById("inputPhone").classList.add('is-valid');
		document.getElementById("vphone").style.display = "none";
	}else{
		document.getElementById("inputPhone").classList.add('is-invalid');
		document.getElementById("inputPhone").classList.remove('is-valid');
		document.getElementById("vphone").style.display = "block";
	}
	next_btn2();
}

function validatePass(pass){
	if (pass.search(/[a-z]/) < 0) {
	    document.getElementById("inputPassword").classList.add('is-invalid');
		document.getElementById("inputPassword").classList.remove('is-valid');	
		document.getElementById("invalidPassword").style.display = "block";
		document.getElementById("invalidPassword").style.color = "red";
		document.getElementById("invalidPassword").innerHTML = "Your password must contain a lower case letter";
	} else if(pass.search(/[A-Z]/) < 0) {
	    document.getElementById("inputPassword").classList.add('is-invalid');
		document.getElementById("inputPassword").classList.remove('is-valid');	
		document.getElementById("invalidPassword").style.display = "block";
		document.getElementById("invalidPassword").style.color = "red";
		document.getElementById("invalidPassword").innerHTML = "Your password must contain an upper case letter";
	} else  if (pass.search(/[0-9]/) < 0) {
		document.getElementById("inputPassword").classList.add('is-invalid');
		document.getElementById("inputPassword").classList.remove('is-valid');	
		document.getElementById("invalidPassword").style.display = "block";
		document.getElementById("invalidPassword").style.color = "red";
		document.getElementById("invalidPassword").innerHTML = "Your password must contain a number";	
	}
	else  if (pass.length < 6) {
		document.getElementById("inputPassword").classList.add('is-invalid');
		document.getElementById("inputPassword").classList.remove('is-valid');	
		document.getElementById("invalidPassword").style.display = "block";
		document.getElementById("invalidPassword").style.color = "red";
		document.getElementById("invalidPassword").innerHTML = "Your password is too short";	
	}
	else{
		document.getElementById("inputPassword").classList.remove('is-invalid');
		document.getElementById("inputPassword").classList.add('is-valid');	
		document.getElementById("invalidPassword").style.display = "block";
		document.getElementById("invalidPassword").innerHTML = "Valid password";
		document.getElementById("invalidPassword").style.color = "green";
	}
	next_btn1();
}

function checkPass()
{
	var pass1 = document.getElementById('inputPassword');
    var pass2 = document.getElementById('ConfirmPassword');
	if(pass1.value != pass2.value){
		document.getElementById("vPass").style.display = "block";
		document.getElementById("ConfirmPassword").classList.remove('is-valid');
		document.getElementById("ConfirmPassword").classList.add('is-invalid');
		document.getElementById("vPass").innerHTML = "Password not match!";
		document.getElementById("vPass").style.color = "red";
	}
	else
	{
		document.getElementById("ConfirmPassword").classList.remove('is-invalid');
		document.getElementById("ConfirmPassword").classList.add('is-valid');
		document.getElementById("vPass").innerHTML = "Password match!";
		document.getElementById("vPass").style.color = "green";
	}
	next_btn1();
}

function validate_First(First)
{
	First.value = First.value.replace(/[^/ ,a-zA-Z-'\n\r.]+/g, '');
	if( First.value.length >=2 && First.value.length <= 50 ){
		document.getElementById("inputFirstName").classList.add('is-valid');
		document.getElementById("inputFirstName").classList.remove('is-invalid');
		document.getElementById("vFirst").style.display = "none";
	}
	else {
		document.getElementById("inputFirstName").classList.add('is-invalid');
		document.getElementById("inputFirstName").classList.remove('is-valid');
		document.getElementById("vFirst").style.display = "block";
		document.getElementById("vFirst").innerHTML = "Invalid First Name!";
	}
	next_btn2();
}

function validate_Last(Last)
{
	Last.value = Last.value.replace(/[^/ ,a-zA-Z-'\n\r.]+/g, '');
	if( Last.value.length >=2 && Last.value.length <= 40 ){
		document.getElementById("inputLastName").classList.add('is-valid');
		document.getElementById("inputLastName").classList.remove('is-invalid');
		document.getElementById("vLast").style.display = "none";
	}
	else {
		document.getElementById("inputLastName").classList.add('is-invalid');
		document.getElementById("inputLastName").classList.remove('is-valid');
		document.getElementById("vLast").style.display = "block";
		document.getElementById("vLast").innerHTML = "Invalid Last Name!";
	}
	next_btn2();
}

function validate_add(address)
{
	address.value = address.value.replace(/[^/ ,0-9a-zA-Z-'\n\r.]+/g, '');
	if( address.value.length >=3 && address.value.length <= 90 ){
		document.getElementById("inputAddress").classList.add('is-valid');
		document.getElementById("inputAddress").classList.remove('is-invalid');
		document.getElementById("vAddress").style.display = "none";
	}
	else {
		document.getElementById("inputAddress").classList.add('is-invalid');
		document.getElementById("inputAddress").classList.remove('is-valid');
		document.getElementById("vAddress").style.display = "block";
		document.getElementById("vAddress").innerHTML = "Invalid address!";
	}
	next_btn2();
}

function validate_country(){
	var select_country = document.getElementById("inputCountries").selectedIndex;
	if( select_country == 0){
		document.getElementById("inputCountries").classList.add('is-invalid');
		document.getElementById("inputCountries").classList.remove('is-valid');
		document.getElementById("vcountry").style.display = "block";
		document.getElementById("vcountry").innerHTML = "Select a country!";
	}
	else{
		document.getElementById("inputCountries").classList.add('is-valid');
		document.getElementById("inputCountries").classList.remove('is-invalid');
		document.getElementById("vcountry").style.display = "none";
	}
	next_btn2();
}

function membertype() {
	var select_membertype = document.getElementById("membershiptype").selectedIndex;
	if ( select_membertype == 0 ){
	  document.getElementById("membershiptype").classList.add('is-invalid');
	  document.getElementById("membershiptype").classList.remove('is-valid');
	  document.getElementById("vmembership").style.display = "block";
	  document.getElementById("vmembership").innerHTML = "Select a membership!";
	  document.getElementById("payform").style.display = "none";  
	}
	else if( select_membertype == 1){
	  document.getElementById("membershiptype").classList.add('is-valid');
	  document.getElementById("membershiptype").classList.remove('is-invalid');
	  document.getElementById("vmembership").style.display = "none";
	  document.getElementById("ind").innerHTML = "Consider Our Premium Membership?";
	  document.getElementById("payform").style.display = "none"; 
	  document.getElementById("adv").style.display = "block";  
	}
	else if( select_membertype == 2){
	  document.getElementById("membershiptype").classList.add('is-valid');
	  document.getElementById("membershiptype").classList.remove('is-invalid');
	  document.getElementById("vmembership").style.display = "none";
	  document.getElementById("ind").innerHTML = "Premium Membership Fee Payment.";
	  document.getElementById("payform").style.display = "block";   
	  document.getElementById("adv").style.display = "none";  
	}
	type = select_membertype;
	if(type==1){
		document.getElementById("next4").disabled = false;
	}
	else{
		document.getElementById("next4").disabled = true;
	}
	next_btn3();
} 

var visaPattern = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;
var mastPattern = /^(?:5[1-5][0-9]{14})$/;
var amexPattern = /^(?:3[47][0-9]{13})$/;
var discPattern = /^(?:6(?:011|5[0-9][0-9])[0-9]{12})$/; 

function CardNumber() {
    var ccNum  = document.getElementById("cardnum").value;
    var isVisa = visaPattern.test( ccNum ) === true;
    var isMast = mastPattern.test( ccNum ) === true;
    var isAmex = amexPattern.test( ccNum ) === true;
    var isDisc = discPattern.test( ccNum ) === true;
	if(type == 2){
		if( ccNum.length >=15 && (isVisa || isMast || isAmex || isDisc) ) {
			document.getElementById("cardtype").style.display = "block"; 
			document.getElementById("vcnum").style.display = "none"; 
			document.getElementById("cardnum").classList.add('is-valid');
			document.getElementById("cardnum").classList.remove('is-invalid');
			if( isVisa ) {
				document.getElementById("cardtype").innerHTML = "<i class='fa fa-cc-visa fa-2x'>";
			}
			else if( isMast ) {
				 document.getElementById("cardtype").innerHTML = "<i class='fa fa-cc-mastercard fa-2x'>";
			}
			else if( isAmex ) {
				document.getElementById("cardtype").innerHTML = "<i class='fa fa-cc-amex fa-2x'>";
			}
			else if( isDisc ) {
				document.getElementById("cardtype").innerHTML = "<i class='fa fa-cc-discover fa-2x'>";
			}
		}
		else {
			document.getElementById("cardtype").style.display = "none"; 
			document.getElementById("cardnum").classList.remove('is-valid');
			document.getElementById("cardnum").classList.add('is-invalid');
			document.getElementById("vcnum").innerHTML = "Please input a valid credit card number.";
			document.getElementById("vcnum").style.display = "block"; 
		}
	} 
	next_btn4();
}

function check_exp(){
	if(type == 2){
		var e1 = document.getElementById("exMonth");
		var e2 = document.getElementById("exYear");
		var exM = e1.options[e1.selectedIndex].value;
		var exY = e2.options[e2.selectedIndex].value;
		var today = new Date();
		var someday = new Date();
		var d = new Date();
		var now_month = d.getMonth();
		var now_Year = d.getFullYear();
		document.getElementById("vdate").style.display = "block"; 
		if ((now_Year>exY)||(now_Year==exY && now_month+1 >exM)) {
		    document.getElementById("exMonth").classList.add('is-invalid');
			document.getElementById("exMonth").classList.remove('is-valid');
			document.getElementById("exYear").classList.add('is-invalid');
			document.getElementById("exYear").classList.remove('is-valid');
			document.getElementById("vdate").innerHTML = "Please select a valid expiry date";
			document.getElementById("vdate").style.display = "block"; 
		}
		else{
			document.getElementById("exMonth").classList.add('is-valid');
			document.getElementById("exMonth").classList.remove('is-invalid');
			document.getElementById("exYear").classList.add('is-valid');
			document.getElementById("exYear").classList.remove('is-invalid');
			document.getElementById("vdate").style.display = "none"; 
		}
	}	
	next_btn4();
}

function check_hname(name){
	var hname = name.value;
	if(type==2){
		if(hname.length<6){
			document.getElementById("cc_name").classList.add('is-invalid');
			document.getElementById("cc_name").classList.remove('is-valid');
			document.getElementById("vcname").innerHTML = "Please input a valid name.";
			document.getElementById("vcname").style.display = "block"; 
		}
		else{
			document.getElementById("cc_name").classList.add('is-valid');
			document.getElementById("cc_name").classList.remove('is-invalid');
			document.getElementById("vcname").style.display = "none"; 
		}
	}
	next_btn4();
}
function check_cvc(code){
	var cvc = code.value;
	if(type==2){
		if(cvc.length<3){
			document.getElementById("cvc").classList.add('is-invalid');
			document.getElementById("cvc").classList.remove('is-valid');
			document.getElementById("vcvc").innerHTML = "Please input a valid security code.";
			document.getElementById("vcvc").style.display = "block"; 
		}
		else{
			document.getElementById("cvc").classList.add('is-valid');
			document.getElementById("cvc").classList.remove('is-invalid');
			document.getElementById("vcvc").style.display = "none";
		}
	}
	next_btn4();
}

function validate_agree(){
	if(document.getElementById("agree1").checked==true){
		document.getElementById("agree1").classList.add('is-valid');
		document.getElementById("agree1").classList.remove('is-invalid');
	}
	else{
		document.getElementById("agree1").classList.add('is-invalid');
		document.getElementById("agree1").classList.remove('is-valid');
	}
	reg_sub();
}

function next_btn1(){
	var username = document.getElementById("inputUsername").classList.contains('is-valid');
	var pass1 = document.getElementById("inputPassword").classList.contains('is-valid');
	var pass2 = document.getElementById("ConfirmPassword").classList.contains('is-valid');
	var email = document.getElementById("inputEmail").classList.contains('is-valid');
	if(username == true && pass1 == true && pass2 == true && email == true){
		document.getElementById("next1").disabled = false;
	}
	else{
		document.getElementById("next1").disabled = true;
	}
}

function next_btn2(){
	var fname = document.getElementById("inputFirstName").classList.contains('is-valid');
	var lname = document.getElementById("inputLastName").classList.contains('is-valid');
	var add = document.getElementById("inputAddress").classList.contains('is-valid');
	var phone = document.getElementById("inputPhone").classList.contains('is-valid');
	var country = document.getElementById("inputCountries").classList.contains('is-valid');
	if(fname == true && lname == true && add == true && phone == true && country == true){
		document.getElementById("next2").disabled = false;
	}
	else{
		document.getElementById("next2").disabled = true;
	}
}

function next_btn3(){
	var type = document.getElementById("membershiptype").classList.contains('is-valid');
	if(type == true){
		document.getElementById("next3").disabled = false;
	}
	else{
		document.getElementById("next3").disabled = true;
	}
}

function next_btn4(){
	if(type==2){
		var cvc_check =  document.getElementById("cvc").classList.contains('is-valid');
		var hname_check =  document.getElementById("cc_name").classList.contains('is-valid');
		var cardnum_check =  document.getElementById("cardnum").classList.contains('is-valid');
		var check_month =  document.getElementById("exMonth").classList.contains('is-valid');
		var check_year =  document.getElementById("exYear").classList.contains('is-valid');
		if(cvc_check == true && hname_check==true && cardnum_check==true && check_month == true && check_year == true ){
			document.getElementById("next4").disabled = false;
		}
		else{
			document.getElementById("next4").disabled = true;
		}
	}
	if(type==1){
		document.getElementById("next4").disabled = false;
	}
}

function reg_sub(){
	var agree = document.getElementById("agree1").classList.contains('is-valid');
	if(agree == true){
		document.getElementById("reg_submit").disabled = false;
	}
	else{
		document.getElementById("reg_submit").disabled = true;
	}
}
