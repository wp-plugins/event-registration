<?php

/**
 * Event Registration Plugin - Registration Form Captcha js 
 * 
 */
$captcha = $_GET['captcha'];
header("content-type: application/x-javascript");

?>
function validateRadio( obj,correct ){
    var result = 0;
    for(var i=0; i < obj.length; i++){
        if(obj[i].checked==true && obj[i].value==correct){
            result = 1;
        }
    }
    if(!result && obj.value == correct){
        result = 1;
    }
    return result
}



function checkInternationalPhone(strPhone){
    var digits = "0123456789";
    var phoneNumberDelimiters = "()- ";
    var validWorldPhoneChars = phoneNumberDelimiters + "+";
    var minDigitsInIPhoneNumber = 10;

    function isInteger(s){   
        var i;
        for (i = 0; i < s.length; i++){   
            var c = s.charAt(i);
            if (((c < "0") || (c > "9"))) return false;
        }
        return true;
    }
    function trim(s){   
        var i;
        var returnString = "";
        for (i = 0; i < s.length; i++){   
            var c = s.charAt(i);
            if (c != " ") returnString += c;
        }
        return returnString;
    }
    function stripCharsInBag(s, bag){   
        var i;
        var returnString = "";
            for (i = 0; i < s.length; i++){   
                var c = s.charAt(i);
                if (bag.indexOf(c) == -1) returnString += c;
            }
            return returnString;
    }

    var bracket=3;
    strPhone=trim(strPhone);
    if(strPhone.indexOf("+")>1){
        return false;
    } 
    if(strPhone.indexOf("-")!=-1){
        bracket=bracket+1;
    }
    if(strPhone.indexOf("(")!=-1 && strPhone.indexOf("(")>bracket){
        return false;
    }
    var brchr=strPhone.indexOf("(");
    if(strPhone.indexOf("(")!=-1 && strPhone.charAt(brchr+2)!=")"){
        return false;
    }
    if(strPhone.indexOf("(")==-1 && strPhone.indexOf(")")!=-1){
        return false;
    }
    s=stripCharsInBag(strPhone,validWorldPhoneChars);
    return (isInteger(s) && s.length >= minDigitsInIPhoneNumber);
}

function echeck(str) {
    var at="@";
	var dot=".";
	var em = "";
	var lat=str.indexOf(at);
	var lstr=str.length;
    var ldot=str.indexOf(dot);
	if (str.indexOf(at)==-1){
        return false;
        }
    if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
        return false;
        }
    if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
        return false;
	   }
    if (str.indexOf(at,(lat+1))!=-1){
        return false;
        }
    if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
        return false;
        }
    if (str.indexOf(dot,(lat+2))==-1){
        return false;
        }
    if (str.indexOf(" ")!=-1){
        return false;
        }
    return true;					
}
function testIsValidObject(objToTest) {
    if (objToTest == null || objToTest == undefined) {
    return false;
    }
    return true;
}

function jcap(){
    var uword = hex_md5(document.getElementById(jfldid).value);
    if (uword==cword[anum-1]) {
        return true;
        }
    else {
        return false;
        }
}

function validateConfirmationForm(confForm) {
    var msg = "";
    var i = 0;
    var form = confForm['attendee['+i+'][first_name]'];
    while (form != undefined)
    {
      if (confForm['attendee['+i+'][first_name]'].value == "") {  msg += "\n Attendee #"+(i+1)+" Please enter attendee first name";
                confForm['attendee['+i+'][first_name]'].focus( );
            }
      if (confForm['attendee['+i+'][last_name]'].value == "") {  msg += "\n Attendee #"+(i+1)+" Please enter attendee last name";
                confForm['attendee['+i+'][last_name]'].focus( );
                }
      i++;
      var form = confForm['attendee['+i+'][first_name]']; 
    }
     if (msg.length > 0) {
                        msg = "The following fields need to be completed before you can submit.\n\n" + msg;
                        alert(msg);
            if (document.getElementById("mySubmit").disabled==true){
                document.getElementById("mySubmit").disabled=false;}
                document.getElementById("mySubmit").focus( );
                        return false;
                }

        return true;
 }


function validateForm(form) { 
    var msg = "";
    if (form.fname.value == "") {  msg += "\n " +"Please enter your first name"; 
   		form.fname.focus( ); 
   	    }
    if (form.lname.value == "") {  msg += "\n " +"Please enter your last name"; 
   		form.lname.focus( ); 
   		}
    if (echeck(form.email.value)==false){
		msg += "\n " + "Email format not correct!";
		}
    if(form.phone) {
        if (form.phone.value == "" || form.phone.value==null) {  msg += "\n " +"Please enter your phone number."; 
            form.phone.focus( ); 
   		   }
        if (checkInternationalPhone(form.phone.value)==false){
            msg += "\n " +"Please use correct format for your phone number."; 
            form.value="";
            form.phone.focus();
            }
        }
	if(form.address) {
        if (form.address.value == "") {  msg += "\n " +"Please enter your address."; 
   		   form.address.focus( ); 
   		   }
        }
    if(form.city) {
        if (form.city.value == "") {  msg += "\n " +"Please enter your city."; 
   		   form.city.focus( ); 
   		   }  
        }
    if(form.state) {
        if (form.state.value == "") { msg += "\n " + "Please enter your state."; 
   		   form.state.focus( ); 
   	        }
        }
    if(form.zip) {   	    
        if (form.zip.value == "") { msg += "\n " +"Please enter your zip/postal code.";  
   		   form.zip.focus( ); 
            }
        }
    function trim(s) {
        if (s) {
            return s.replace(/^\s*|\s*$/g,"");
            } 
        return null;
        }
    
    if(form.waiver_agree){
        if( !validateRadio( form.waiver_agree, 'Y' ) ){ msg += "\n " +"You must agree to the Disclaimer/Waiver.";}
        }
        
  
        
    var inputs = form.getElementsByTagName("input");
    var e;
    for( var i = 0, e; e = inputs[i]; i++ ){
            var value = e.value ? trim(e.value) : null;
            if (e.type == "text" && e.title && !value && e.className == "r"){
                msg += "\n " + e.title;
                }
            if ((e.type == "radio" || e.type == "checkbox") && e.className == "r") {
                
                
				var rd =""
				var controls = form.elements;
				function getSelectedControl(group) 
					{
					for (var i = 0, n = group.length; i < n; ++i)
						if (group[i].checked) return group[i];
						return null;
                        }
				if (!getSelectedControl(controls[e.name])){
				    msg += "\n " + e.title;
                    }
                } 
			}
    var inputs = form.getElementsByTagName("textarea");
	var e;
	for( var i = 0, e; e = inputs[i]; i++ ){  
		var value = e.value ? trim(e.value) : null;
		if (!value && e.className == "r")
		{msg += "\n " + e.title;}
        }
	var inputs = form.getElementsByTagName("select");
	var e;
	for( var i = 0, e; e = inputs[i]; i++ ){
		var value = e.value ? trim(e.value) : null;
		if ((!value || value =='') && e.className == "r")
		{msg += "\n " + e.title;}
	}
<?php if ($captcha == 'Y') { ?>

    if (jcap() == false){
		msg += "\n " +"ERROR: Invalid Security Code."; 
        }
<?php } ?>
     if (msg.length > 0) {
			msg = "The following fields need to be completed before you can submit.\n\n" + msg;
			alert(msg);
            if (document.getElementById("mySubmit").disabled==true){
                document.getElementById("mySubmit").disabled=false;} 
                document.getElementById("mySubmit").focus( );
			return false;
		}
	
	return true;   
}