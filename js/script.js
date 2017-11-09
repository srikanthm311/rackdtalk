$().ready(function() {

	

	$.validator.addMethod("regx", function(value, element, regexpr) {          

   		return regexpr.test(value);

		}, ".")

		//enquiry validation


	 $("#user_profile").validate({

		rules:{

			firstName:{

				required:true,

				regx: /^[a-z A-Z]*$/,

				},
			lastName:{

				required:true,

				regx: /^[a-z A-Z]*$/,

				},

			alternate_email:{

				required:true,

				email:true,

				},

			mobile:{

				required:true,

				regx: /^[789][0-9]{9}$/,

				},
			gender:{

				required:true,

				},
			address:{

				required:true,

				},
			country:{

				required:true,

				},
			state:{

				required:true,

				},
			city:{

				required:true,

				},
			zipcode:{

				required:true,

				},

			},

		messages:{

			firstName:{

				required:'Enter your First Name',

				regx: 'Enter Name in only alphabits',

				},
			lastName:{

				required:'Enter your Last Name',

				regx: 'Enter Name in only alphabits'

				},

			alternate_email:{

				required:'Enter alternate email id',

				email:'invalid email id',

				},

			mobile:{

				required:'enter your mobile number',

				regx: 'mobile number starts with 7, 8 and 9',

				},
			gender:{

				required:'select gender',

				},
			address:{

				required:'Enter your address',

				},
			country:{

				required:'select your country',

				},
			state:{

				required:'select your state',

				},
			city:{

				required:'select your city',

				},
			zipcode:{

				required:'enter your zip code',

				},

			},

		

		});
		
		});

		
		
		$(document).on("click",".user_profile_submit",function(){

     var form = $(this).closest("form");

     //console.log(form);

     form.submit();

   });


$().ready(function() {

	

	$.validator.addMethod("regx", function(value, element, regexpr) {          

   		return regexpr.test(value);

		}, ".")

		//enquiry validation

		$("#withdraw_form").validate({

		rules:{

			w_amount:{

				required:true,

				regx: /^[0-9]*$/,

				},
			wallet_type:{

				required:true,

				},

			},

		messages:{

			w_amount:{

				required:'Enter Amount',

				regx: 'Enter valid Amount',

				},
			wallet_type:{

				required:'Select Wallet Type',

				},

			},

		});
		
		});
   
   $(document).on("click",".with_dra_btn",function(){

     var form = $(this).closest("form");

     //console.log(form);

     form.submit();

   });