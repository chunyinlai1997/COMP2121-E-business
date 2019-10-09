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
  reg_sub();
}

function check_exp(){
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
  if ((now_Year>exY)||(now_Year==exY && now_month+1 > exM)) {
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
  reg_sub();
}

function check_hname(name){
  var hname = name.value;
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
  reg_sub();
}

function check_cvc(code){
  var cvc = code.value;
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
  reg_sub();
}

function reg_sub(){
  var cvc_check =  document.getElementById("cvc").classList.contains('is-valid');
  var hname_check =  document.getElementById("cc_name").classList.contains('is-valid');
  var cardnum_check =  document.getElementById("cardnum").classList.contains('is-valid');
  var check_month =  document.getElementById("exMonth").classList.contains('is-valid');
  var check_year =  document.getElementById("exYear").classList.contains('is-valid');
  if(cvc_check == true && hname_check==true && cardnum_check==true && check_month == true && check_year == true ){
    document.getElementById("regsub").disabled = false;
  }
  else{
    document.getElementById("regsub").disabled = true;
  }
}
