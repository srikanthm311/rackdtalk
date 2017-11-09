<div class="container login-main profile_contianer">
<script src="https://rawgithub.com/trentrichardson/jQuery-Timepicker-Addon/master/jquery-ui-timepicker-addon.js"></script>
<script src="https://rawgithub.com/trentrichardson/jQuery-Timepicker-Addon/master/jquery-ui-sliderAccess.js"></script>
<style>
.form-color{
	color: #333;
	}
.right_class
{
	height: auto;
	}
#imgArea img {
    outline: medium none;
    vertical-align: middle;
    width: 100px;
    height: 100px;
}
div#imgArea img {
}
#imgChange
{
	position: absolute;
	text-align:center
	}
#progress-wrp {
    border: 1px solid #0099CC;
    padding: 1px;
    position: relative;
    border-radius: 3px;
    margin: 10px;
    text-align: left;
    background: #fff;
    box-shadow: inset 1px 3px 6px rgba(0, 0, 0, 0.12);
}
#progress-wrp .progress-bar{
    height: 20px;
    border-radius: 3px;
    background-color: #f39ac7;
    width: 0;
    box-shadow: inset 1px 1px 10px rgba(0, 0, 0, 0.11);
}
#progress-wrp .status{
    top:3px;
    left:50%;
    position:absolute;
    display:inline-block;
    color: #000000;
}
.progressBar{background:none repeat scroll 0 0 #E0E0E0;left:0;padding:3px 0;position:absolute;top:50%;width:100%;display:none;}
.progressBar .bar{background-color:#FF6C67;width:0%;height:14px;}.progressBar .percent{display:inline-block;left:0;position:absolute;text-align:center;top:2px;width:100%;}
</style>
            <div class="site-wrapper-inner">

                <div class="cover-container login-cover myprofile">

                    

                    <div class="inner cover">
                       <div class="mp-left">
                        
                           <div class="user">
                                <div class="user-img">
                                   <form enctype="multipart/form-data" action="<?php echo base_url();?>main/profilePic" method="post" name="image_upload_form" id="image_upload_form">
                                    <div id="imgArea"> 
                                    <?php if($this->session->userdata('pic'))
                                    {?>
                                     <img src="<?php echo base_url().$this->session->userdata('pic');?>" alt=" ">
                                    <?php } else { ?>
                                     <img src="<?php echo base_url();?>images/user.jpg" alt="" class="img-responsive">
                                    <?php }?>
                                    <div id="imgChange"><span class="upload-button"><?php echo $this->lang->line('change_photo'); ?></span>
                                    <input type="file" accept="image/*" name="image_upload_file" id="image_upload_file" style="display:none">
                                    <div class="progressBar">
                                    <div class="bar"></div>
                                    <div class="percent">0%</div>
                                    </div>
                                    </div>
                                    
                                    <input type="submit" value="upload" />
                                    </div>
                                    </form>
                                    
                                </div>
                               
                           </div>
                           
                           <div class="user"  style="margin-top: 30px; text-align: center;">
                               <h4><?php echo $this->session->userdata['USER_NAME'] ?></h4>
                               <?php /*?> <span>UI/UX Developer</span><?php */?>
                           </div>
                           
                             <?php $this->load->view('frontend/includes/user-sidebar');?>
                           
                        </div>
                       <div class="mp-right right_class">
                            
                            
                            <form class="form-horizontal form-color my_infromation" role="form" method="post" id="user_profile">
                                <h4 class = "form-color"><?php echo $this->lang->line('my_information'); ?></h4>
                            <input type="hidden" name="user_id" value=<?php echo $profile['id'];?> />
                               <div class="form-group">
                                <label class="col-lg-2 control-label"><?php echo $this->lang->line('firstname'); ?>:</label>
                                <div class="col-lg-10">
                                  <input class="form-control" type="text" value="<?php echo $profile['first_name']?>" name="firstName" id="firstName">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-lg-2 control-label"><?php echo $this->lang->line('lastname'); ?>:</label>
                                <div class="col-lg-10">
                                  <input class="form-control" type="text" value="<?php echo $profile['last_name']?>" name="lastName" id="lastName">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-lg-2 control-label"><?php echo $this->lang->line('email'); ?>:</label>
                                <div class="col-lg-10">
                                  <input class="form-control" type="text" value="<?php echo $profile['email_id']?>" name="email" id="email" readonly>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-lg-2 control-label"><?php echo $this->lang->line('alternate_email'); ?>:</label>
                                <div class="col-lg-10">
                                  <input class="form-control" type="text" value="<?php echo $profile['alternate_email']?>" name="alternate_email" id="alternate_email" onblur="equalemail()">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-lg-2 control-label"><?php echo $this->lang->line('mobile'); ?>:</label>
                                <div class="col-lg-10">
                                  <input class="form-control" type="text" value="<?php echo $profile['mobile']?>" name="mobile" id="mobile" readonly>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-lg-2 control-label"><?php echo $this->lang->line('Gender'); ?>:</label>
                                <div class="col-lg-10">
                                 <span> <input class="" type="radio" name="gender" value="male" <?php echo ($profile['gender'] == 'male')?'checked':'';?>><?php echo $this->lang->line('male'); ?></span>
                                 <span> <input class="" type="radio" name="gender" value="female" <?php echo ($profile['gender'] == 'female')?'checked':'';?>><?php echo $this->lang->line('female'); ?></span>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-lg-2 control-label"><?php echo $this->lang->line('street_address'); ?>:</label>
                                <div class="col-lg-10">
                                  <textarea class="form-control" name="address" id="address"><?php echo $profile['street_address']?></textarea>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-lg-2 control-label"><?php echo $this->lang->line('country'); ?>:</label>
                                <div class="col-lg-10">
                                  <div class="ui-select">
                                    <select class="form-control country_drop" name="country" id="country">
                                     <option value=""> select country</option>
                                     <?php foreach($countries as $country){?>
                                     	<option value="<?php echo $country['id']?>" <?php echo ($country['id'] == $profile['country'])?'selected':''?>><?php echo $country['name']?></option>
                                     <?php }?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-lg-2 control-label"><?php echo $this->lang->line('state'); ?>:</label>
                                <div class="col-lg-10">
                                  <div class="ui-select">
                                    <select class="form-control state_drop" name="state" id="state" >
                                    <option value=""> select state</option>
                                    <?php foreach($states as $state){?>
                                     	<option value="<?php echo $state['id']?>" <?php echo ($state['id'] == $profile['state'])?'selected':''?>><?php echo $state['name']?></option>
                                     <?php }?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-lg-2 control-label"><?php echo $this->lang->line('city'); ?>:</label>
                                <div class="col-lg-10">
                                  <div class="ui-select">
                                    <select class="form-control cities_drop" name="city" id="city">
                                     <option value=""> select city</option>
                                     <?php foreach($cities as $city){?>
                                     	<option value="<?php echo $city['id']?>" <?php echo ($city['id'] == $profile['city'])?'selected':''?>><?php echo $city['name']?></option>
                                     <?php }?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-lg-2 control-label"><?php echo $this->lang->line('zip_code'); ?>:</label>
                                <div class="col-lg-10">
                                  <input class="form-control" type="text" value="<?php echo $profile['pin_code']?>" name="zipcode" id="zipcode">
                                </div>
                              </div>
                              <!--<h3> Credit Card Details:</h3>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Enter Card NO:</label>
                                    <div class="col-lg-10">
                                      <input class="form-control" type="text" value="" name="ccno" id="ccno">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-lg-2 control-label">Name on the Card:</label>
                                    <div class="col-lg-10">
                                      <input class="form-control" type="text" value="" name="ccname" id="ccname">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-lg-2 control-label">Card Expiry Date:</label>
                                    <div class="col-lg-10">
                                      <input class="form-control datepicker"type="text" name="ccexpiry" id="ccexpiry">
                                    </div>
                                  </div>-->
                                  
                                  <!--<h3> Debit Card Details:</h3>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Enter Card NO:</label>
                                    <div class="col-lg-10">
                                      <input class="form-control" type="text" value="" name="dcno" id="dcno">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-lg-2 control-label">Name on the Card:</label>
                                    <div class="col-lg-10">
                                      <input class="form-control" type="text" value="" name="dcname" id="dcname">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-lg-2 control-label">Card Expiry Date:</label>
                                    <div class="col-lg-10">
                                      <input class="form-control datepicker" type="text"  name="dcexpiry" id="dcexpiry">
                                    </div>
                                  </div>-->
                                  
                                   <!--<h3> Bank Account Details:</h3>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Enter Bank Name:</label>
                                    <div class="col-lg-10">
                                      <input class="form-control" type="text" value="" name="bname" id="bname">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-lg-2 control-label">Account Holder Name:</label>
                                    <div class="col-lg-10">
                                      <input class="form-control" type="text" value="" name="customer_name" id="customer_name">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-lg-2 control-label">Bank Branch:</label>
                                    <div class="col-lg-10">
                                      <input class="form-control" type="text" value="" name="branch" id="branch">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-lg-2 control-label">Bank IFSC Code:</label>
                                    <div class="col-lg-10">
                                      <input class="form-control" type="text" value="" name="bank_ifsc" id="bank_ifsc">
                                    </div>
                                  </div>-->
                              <div class="form-group">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-10">
                                  <input type="submit" class="user_profile_submit submit" value="<?php echo $this->lang->line('save_changes'); ?>">
                                  <span></span>
                                  <input type="reset" class="user_profile_submit cancel" value="<?php echo $this->lang->line('cancel'); ?>">
                                </div>
                              </div>
                            </form>
                        </div>
                       
                    </div>



                </div>

            </div>

        </div>
<script>
function base_url(){
	return '<?php echo base_url()?>';
	}
</script>
<script type="text/javascript">
$('.country_drop').change(function () {
	var country_id = jQuery("#country option:selected").val();
	$.ajax({

		type: "POST",

		url: '<?php echo base_url('main/getstates'); ?>',
		dataType: 'json',
		data: {'id': country_id}, 

		success: function (data) {

			if(data)
			{
			$( ".state_drop option" ).remove();
			   var combo = $(".state_drop");
			   combo.append("<option value=''> -- select state-- </option>");
   				$.each(data, function (index, element) {
      			combo.append("<option value='"+ element.id +"'>" + element.name + "</option>");
   				 });

			}

		}

	});

});

$('.state_drop').change(function () {
	var state_id = jQuery("#state option:selected").val();
	$.ajax({

		type: "POST",

		url: '<?php echo base_url('main/ajax_getcities'); ?>',
		dataType: 'json',
		data: {'id': state_id}, 

		success: function (data) {

			if(data)
			{
			$( ".cities_drop option" ).remove();
			   var combo = $(".cities_drop");
			   combo.append("<option value=''> -- Select City-- </option>");
   				$.each(data, function (index, element) {
      			combo.append("<option value='"+ element.id +"'>" + element.name + "</option>");
   				 });

			}

		}

	});

});

$(document).ready(function() {
    
    $(".upload-button").on('click', function() {
       $("#image_upload_file").click();
    });
});

</script>
<script type="text/javascript">
 $(function() {
$(document).on('change', '#image_upload_file', function () {
var progressBar = $('.progressBar'), bar = $('.progressBar .bar'), percent = $('.progressBar .percent');

$('#image_upload_form').ajaxForm({
    beforeSend: function() {
		progressBar.fadeIn();
        var percentVal = '0%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    uploadProgress: function(event, position, total, percentComplete) {
        var percentVal = percentComplete + '%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    success: function(html, statusText, xhr, $form) {		
		obj = $.parseJSON(html);	
		if(obj.status){		
			var percentVal = '100%';
			bar.width(percentVal)
			percent.html(percentVal);
			$("#imgArea>img").prop('src','<?php echo base_url()?>'+obj.image_medium);			
		}else{
			alert(obj.error);
		}
    },
	complete: function(xhr) {
		progressBar.fadeOut();			
	}	
}).submit();		

});
});
</script>

<script>
  $( function() {
    $( "#ccexpiry" ).datepicker({ dateFormat: 'mm/yy' });
  } );
  $( function() {
    $( "#dcexpiry" ).datepicker({ dateFormat: 'mm/yy' });
  } );
  </script>