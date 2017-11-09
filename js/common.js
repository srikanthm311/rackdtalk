
function isEmail(strvalue) {
	return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(strvalue)
}
function jsTrim(strvalue) {
	if(strvalue!=''){
		return strvalue.replace(/^(\s)+/g, '').replace(/(\s)+$/g, '');
	}else{
		return '';
	}
}
function isMobileNumber(strvalue){
        var ValidChars = "0123456789";
        var IsNumber = true;
        var Char;
        for (i = 0; i < strvalue.length && IsNumber == true; i++)
        {
                Char = strvalue.charAt(i);
                if (strvalue.match(/^0+$/)) return false;
                if (ValidChars.indexOf(Char) == -1)
                        IsNumber = false;
        }
        if(strvalue.length != 10 && strvalue.length != 11)
        {
                return false;
        }
        return IsNumber;
}

function FnPostContinue(VarValue){
	var name			=	$("#name").val();
	var email		    =	$("#email").val();
	var password		=	$("#password").val();
	var cpassword		=	$("#cpassword").val();
	var mobile		    =	$("#mobile").val();
	var acard		    =	$("#acard").val();
	var age			    =	$("#age").val();
	var validMsg	    =	$("#valid-msg");
	
	
	if(jsTrim(name)==''){
		$("#name").focus();
		$("#name").addClass("errClass").removeClass("glow");
		$("#Errname").html("Enter First Name");
		return false;
		}else{
		$("#name").addClass("glow").removeClass("errClass");
		$("#Errname").html("");
	}
	
	if(jsTrim(email)==''){
		$("#email").focus();
		$("#email").addClass("errClass").removeClass("glow");
		$("#Erremail").html("Enter Email Id");
		return false;
	}else if(!isEmail(email)){
		$("#email").focus();
		$("#email").addClass("errClass").removeClass("glow");
		$("#Erremail").html("Invalid Email Id");
		return false;
	}else{
		$("#email").addClass("glow").removeClass("errClass");
		$("#Erremail").html("");
	}
	
	if(jsTrim(mobile)==''){
		$("#mobile").focus();
		$("#mobile").addClass("errClass").removeClass("glow");
		$("#Errmobile").html("Enter Mobile Number");
		return false;
	}else if(validMsg.hasClass('hide')){
		$("#mobile").focus();
		//$("#mobile").addClass("errClass").removeClass("glow");
		$("#Errmobile").html("");
		return false;
	}else{
		$("#mobile").addClass("glow").removeClass("errClass");
		$("#Errmobile").html("");
	}
	
	
	if(jsTrim(age)==''){
		$("#age").focus();
		$("#age").addClass("errClass").removeClass("glow");
		$("#Errage").html("Enter Age");
		return false;
		}else{
		$("#age").addClass("glow").removeClass("errClass");
		$("#Errage").html("");
	}
	
	if(jsTrim(acard)==''){
		$("#acard").focus();
		$("#acard").addClass("errClass").removeClass("glow");
		$("#Erracard").html("Enter Age");
		return false;
		}else{
		$("#acard").addClass("glow").removeClass("errClass");
		$("#Erracard").html("");
	}

	
	if(jsTrim(password)=='')
	{
		$("#password").focus();
		$("#password").addClass("errClass").removeClass("glow");
		$("#Errpassword").html("Enter Password");
		return false;
	}
	else if(jsTrim(password).length<5)
	{
		$("#password").focus();
		$("#password").addClass("errClass").removeClass("glow");
		$("#Errpassword").html("Password Should be Minimum 5 Charcters");
		return false;
	}
	else{
		$("#password").addClass("glow").removeClass("errClass");
		$("#Errpassword").html("");
	}
	
	if(jsTrim(password)!=jsTrim(cpassword))
	{
		$("#cpassword").focus();
		$("#cpassword").addClass("errClass").removeClass("glow");
		$("#Errcpassword").html("Password & Confirm Password Should be Same");
		return false;
	}
	else{
		$("#cpassword").addClass("glow").removeClass("errClass");
		$("#Errcpassword").html("");
	}
	
	if($("#tc").length>0){
	if($("#tc").is(":checked")==false){
		alert("Please agree the Terms and Conditions to continue");
		return false;
	}
	}
	//$(".signup_form").submit();
	             $.ajax({
				         dataType: 'json',
						 type: 'post',
						 url: $(".signup_form").attr('action'),
						 data: $(".signup_form").serialize(),
						 success: function(responseData) { 
							 if(responseData.message=='success')
							 {
							  $("#login-error").text(responseData.sucmessage); 
							  window.setTimeout(function(){window.location=window.location.href;},1500);
							//  window.location=window.location.href;
							 }
							 else
							 {  
								$("#login-error").text(responseData.message);
								$("#login-error").show(); 
							  }
						 },
						 error:function(xhr, err, status){
							  alert(xhr + err + status);
						 }
					  });
}

$(document).ready(function() {
$(document).on('submit', '#login_form', function(event) { event.preventDefault();
	var email		    =	$("#lemail").val();
	var password		=	$("#lpassword").val();
	
	if(jsTrim(email)==''){
		$("#lemail").focus();
		$("#lemail").addClass("errClass").removeClass("glow");
		$("#Errlemail").html("Enter Email Id");
		return false;
	}/*else if(!isEmail(email)){
		$("#lemail").focus();
		$("#lemail").addClass("errClass").removeClass("glow");
		$("#Errlemail").html("Invalid Email Id");
		return false;
	}*/else{
		$("#lemail").addClass("glow").removeClass("errClass");
		$("#Errlemail").html("");
	}
	
	
	if(jsTrim(password)==''){
		$("#lpassword").focus();
		$("#lpassword").addClass("errClass").removeClass("glow");
		$("#Errlpassword").html("Enter Password");
		return false;
		}
	else{
		$("#lpassword").addClass("glow").removeClass("errClass");
		$("#Errlpassword").html("");
	}
	

	             $.ajax({
				         dataType: 'json',
						 type: 'post',
						 url: $(".login_form").attr('action'),
						 data: $(".login_form").serialize(),
						 success: function(responseData) {  //alert(responseData);
						  	 if(responseData.message=='success')
							 {
								 //alert('NAGS');
								 window.location.href = window.location.href;
 
							 }
							 else
							 {  
								$("#login-error").text(responseData.message);
								$("#login-error").show(); 
							  }
						 },
						 error:function(xhr, err, status){
							  alert(xhr + err + status);
						 }
					  });

   });	
});
function forgotpwd(VarValue){

	var email		    =	$("#fusername").val();
	
	if(jsTrim(email)==''){
		$("#fusername").focus();
		$("#fusername").addClass("errClass").removeClass("glow");
		$("#Errfusername").html("Enter Email Id");
		return false;
	}else if(!isEmail(email)){
		$("#fusername").focus();
		$("#fusername").addClass("errClass").removeClass("glow");
		$("#Errfusername").html("Invalid Email Id");
		return false;
	}else{
		$("#fusername").addClass("glow").removeClass("errClass");
		$("#Errfusername").html("");
	}

	             $.ajax({
				         dataType: 'json',
						 type: 'post',
						 url: $(".fwd_form").attr('action'),
						 data: $(".fwd_form").serialize(),
						 success: function(responseData) {  //alert(responseData);
							 if(responseData.msg=='success')
							 {
							    $("#fwd-error").text(responseData.msg).addClass(responseData.color);
							    $("#fwd-error").show();
 
							 }
							 else
							 {  
								$("#fwd-error").text(responseData.msg).addClass(responseData.color);
								$("#fwd-error").show(); 
							  }
						 },
						 error:function(xhr, err, status){
							  alert(xhr + err + status);
						 }
					  });
					  return false;
}




$(document).ready(function () {
$(document).on('keyup', '.chk',function(){ 
var value = $(this).val();
var flag    =  $(this).data('role');
var msgbox = $(".server-error");
var curItem=$(this).attr('id');
var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
if((value.length > 9 && flag==2) || ((testEmail.test(value)) && flag==1))
{
$("#status").html('Checking availability...');

$.ajax({  
    type: "POST",  
    url: base_url+"main/userexists",  
    data: "value="+ value+"&flag="+flag,  
    success: function(msg){  
	console.log(msg);
    if(msg == 0)
    { 
        $('#'+curItem).removeClass("red");
         msgbox.html('');msgbox.hide();
    }  
    else  
    {
         $('#'+curItem).removeClass("green");
          msgbox.html(msg); msgbox.show();

		  $('#'+curItem).val('');
    }  
   } 
  }); 
}
return false;
});



});