<style>
label.error { 
   float: none; color: red; 
   padding-left: .5em;
   vertical-align: top; 
   display: block;
}​
</style>
<div class="container login-main profile_contianer">

            <div class="site-wrapper-inner">

                <div class="cover-container login-cover myprofile">

                    

                    <div class="inner cover">
                       <div class="mp-left">
                        
                           <div class="user">
                                <div class="user-img">
                                    <img src="<?php echo base_url()?>css/img/avatar.png">
                                    
                                </div>
                               
                           </div>
                           
                           <div class="user">
                               <h4><?php echo $this->session->userdata['USER_NAME'] ?></h4>
                               <?php /*?> <span>UI/UX Developer</span><?php */?>
                           </div>
                           
                           <?php $this->load->view('frontend/includes/user-sidebar');?>
                           
                        </div>
                       <div class="mp-right">
                        
                           <div id="my_questions" class="my_profile_quesstions">
                           
                           
                           <div class="col-md-12 trending-left-main">
                           <div class="trending-left">
                               <div class="devider"></div>
                               <div class="devider"></div>
                            <div class="">
                                <p><?php echo $pageHeading?></p>
                                
                                
                                <form class="recet_password" id="recet_password_form" action="<?php echo base_url()?>main/resetpassword" method="post">
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="corrent_pw" name="corrent_pw" placeholder="Current Password">
                                        <div class="Errtg"></div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="new_pw" name="new_pw" placeholder="New Password">
                                        <div class="Errtg"></div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="cnew_pw" name="cnew_pw" placeholder="Confirm New Password">
                                        <div class="Errtg"></div>
                                    </div>
                                    
                                    
                                    <input class="recet_password_btn" type="submit" value="Submit">
                                    
                                </form>
                                
                            </div>
                            <div id='messages-lists'> </div>
                       
                   
                        </div>
                    </div>
                           
                           
                           
                           
                           
                           </div>
                        </div>
                       
                    </div>



                </div>

            </div>

        </div>
<script src="<?=base_url('');?>js/index.js"></script>
<script>
$().ready(function() {

	 $("#recet_password_form").validate({

		rules:{

			corrent_pw:{

				required:true,

				},

			new_pw:{

				required:true,
				minlength: 5,

				},

			cnew_pw:{

				required:true,
				equalTo : "#new_pw",

				},

			},

		messages:{

			corrent_pw:{

				required:"Enter your current password",

				},

			new_pw:{

				required:"Enter your new password",

				},

			cnew_pw:{

				required:"Enter confirm password",

				},

			},
			
			/*errorElement : 'div',
    		errorLabelContainer: '.Errtg'*/
			
			
		});
		
		});
		$(document).on("click",".recet_password",function(){

     var form = $(this).closest("form");

     //console.log(form);

     form.submit();

   });
		

</script>