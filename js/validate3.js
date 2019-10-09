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
		document.getElementById("phone").classList.remove('is-invalid');
		document.getElementById("phone").classList.add('is-valid');
		document.getElementById("vphone").style.display = "none";
	}else{
		document.getElementById("phone").classList.add('is-invalid');
		document.getElementById("phone").classList.remove('is-valid');
		document.getElementById("vphone").style.display = "block";
	}
}

function validatePass(pass){
	if (pass.length < 4) {
	    document.getElementById("password").classList.add('is-invalid');
		document.getElementById("password").classList.remove('is-valid');	
		document.getElementById("invalidPassword").style.display = "block";
		document.getElementById("invalidPassword").style.color = "red";
		document.getElementById("invalidPassword").innerHTML = "Invalid password";
	} 
	else
	{
		document.getElementById("password").classList.add('is-valid');
		document.getElementById("password").classList.remove('is-invalid');	
		document.getElementById("invalidPassword").style.display = "none";
	}
}

function checkPass()
{
	var pass1 = document.getElementById('password');
    var pass2 = document.getElementById('confirm');
	if(pass1.value != pass2.value){
		document.getElementById("vPass").style.display = "block";
		document.getElementById("confirm").classList.remove('is-valid');
		document.getElementById("confirm").classList.add('is-invalid');
		document.getElementById("vPass").innerHTML = "Password not match!";
		document.getElementById("vPass").style.color = "red";
	}
	else
	{
		document.getElementById("confirm").classList.remove('is-invalid');
		document.getElementById("confirm").classList.add('is-valid');
		document.getElementById("vPass").innerHTML = "Password match!";
		document.getElementById("vPass").style.color = "green";
	}
}


function validate_First(First)
{
	First.value = First.value.replace(/[^/ ,a-zA-Z-'\n\r.]+/g, '');
	if( First.value.length >=2 && First.value.length <= 50 ){
		document.getElementById("firstname").classList.add('is-valid');
		document.getElementById("firstname").classList.remove('is-invalid');
		document.getElementById("vFirst").style.display = "none";
	}
	else {
		document.getElementById("firstname").classList.add('is-invalid');
		document.getElementById("firstname").classList.remove('is-valid');
		document.getElementById("vFirst").style.display = "block";
		document.getElementById("vFirst").innerHTML = "Invalid First Name!";
	}
}

function validate_Last(Last)
{
	Last.value = Last.value.replace(/[^/ ,a-zA-Z-'\n\r.]+/g, '');
	if( Last.value.length >=2 && Last.value.length <= 40 ){
		document.getElementById("lastname").classList.add('is-valid');
		document.getElementById("lastname").classList.remove('is-invalid');
		document.getElementById("vLast").style.display = "none";
	}
	else {
		document.getElementById("lastname").classList.add('is-invalid');
		document.getElementById("lastname").classList.remove('is-valid');
		document.getElementById("vLast").style.display = "block";
		document.getElementById("vLast").innerHTML = "Invalid Last Name!";
	}
}

function validate_add(address)
{
	address.value = address.value.replace(/[^/ ,0-9a-zA-Z-'\n\r.]+/g, '');
	if( address.value.length >=3 && address.value.length <= 90 ){
		document.getElementById("address").classList.add('is-valid');
		document.getElementById("address").classList.remove('is-invalid');
		document.getElementById("vAddress").style.display = "none";
	}
	else {
		document.getElementById("address").classList.add('is-invalid');
		document.getElementById("address").classList.remove('is-valid');
		document.getElementById("vAddress").style.display = "block";
		document.getElementById("vAddress").innerHTML = "Invalid address!";
	}
}

function validate_country(){
	var select_country = document.getElementById("country").selectedIndex;
	if( select_country == 0){
		document.getElementById("country").classList.add('is-invalid');
		document.getElementById("country").classList.remove('is-valid');
		document.getElementById("vcountry").style.display = "block";
		document.getElementById("vcountry").innerHTML = "Select a country!";
	}
	else{
		document.getElementById("country").classList.add('is-valid');
		document.getElementById("country").classList.remove('is-invalid');
		document.getElementById("vcountry").style.display = "none";
	}
}


