<script type="text/javascript" src="<?php echo base_url('js/ajaxfileupload.js');?>"></script>

<script type="text/javascript">

function ajaxFileUpload(pathsetid , elementid, filetype)

{

	var uplaod_url = $("#base_url").val()+'superadmin/uploadImage';

	console.log(uplaod_url+'---'+elementid);

	var newelementid = '';

	newelementid = elementid;

	$.ajaxFileUpload

	(

		{

			url:uplaod_url,

			secureuri:false,

			fileElementId:elementid,

			dataType: 'json',

			data:{ name:elementid, showid:pathsetid, filetype:filetype, pathfolder:'customers'},

			success: function (data)

			{

				if(typeof(data.error) != 'undefined')

				{

					if(data.error != '')

					{

						alert(data.error);

					}

				}else{

					alert(data);

				}

			},

			error:function(XMLHttpRequest,textStatus,errorThrown)

		    {

			   //alert("There was an <strong>"+errorThrown+"</strong> error due to  <strong>"+textStatus+" condition");

		    }   

		}

	);	

}

</script>

<div class="memberlogin-wps col-md-10 products_page">

  <h2><?php echo ($user['id'] != '') ? 'Update' : 'Add'; ?> Customer</h2>

  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>" />

  <div class="col-md-12"> <?php echo validation_errors(); ?>
 <?php if($this->session->flashdata('message')!='') echo  $this->session->flashdata('message');?>
<span class='server-error'></span>
    <form method="post" role="form" id="add-location-form" class="validate-form" action="<?php echo base_url('superadminusers/add_user')?>">

      <input type="hidden" name="id" value="<?php echo isset($user['id']) ? $user['id'] : ''; ?>" />

      

     

      

      <div class="form-group">

        <label for="first_name" class="col-md-2 catogery_name">First Name</label>

        <div class="col-md-6">

          <input type="text" class="form-control form-shadow text_input1 required alpha" id="first_name" name="first_name" value="<?php echo isset($user['first_name']) ? $user['first_name'] : ''; ?>" placeholder="Enter First Name">

        </div>

      </div>

      

        <div class="form-group">

        <label for="last_name" class="col-md-2 catogery_name">Last Name</label>

        <div class="col-md-6">

          <input type="text" class="form-control form-shadow text_input1 required alpha" id="last_name" name="last_name" value="<?php echo isset($user['last_name']) ? $user['last_name'] : ''; ?>" placeholder="Enter Last Name">

        </div>

      </div>

      

      

        <div class="form-group">

        <label for="username" class="col-md-2 catogery_name">Email</label>

        <div class="col-md-6">

          <input type="email" class="form-control form-shadow text_input1 email chk" id="email" name="email" data-role='1' value="<?php echo isset($user['email_id']) ? $user['email_id'] : ''; ?>" <?php echo isset($user['email_id']) ? 'readonly' : ''; ?> placeholder="Enter your Email" required>

        </div>

      </div>
      
      <div class="form-group">

        <label for="role" class="col-md-2 catogery_name">Role</label>

        <div class="col-md-6">

          <select name="role" class="form-control form-shadow text_input1 col-md-4 required" id="role_drop">
          <option value="" selected="selected">-- select role --</option>
          <option value="2" <?php echo ($user['role_id'] == 2) ? 'selected' : '';?>>Admin</option>
          <option value="3" <?php echo ($user['role_id'] == 3) ? 'selected' : '';?>>User</option>
          </select>
        </div>

      </div>

        <div class="form-group">

        <label for="mobile" class="col-md-2 catogery_name">Mobile</label>

        <div class="col-md-6">

          <input type="text" class="form-control form-shadow text_input1 required num chk" id="mobile" name="mobile" value="<?php echo isset($user['mobile']) ? $user['mobile'] : ''; ?>" placeholder="Enter Mobile" data-role='2'>

        </div>

      </div>

      

      

       <div class="form-group">

        <label for="address" class="col-md-2 catogery_name">Address</label>

        <div class="col-md-6">

          <textarea  class="form-control form-shadow text_input1 required alphanum" id="address" name="address"  placeholder="Enter Address"><?php echo isset($user['street_address']) ? $user['street_address'] : ''; ?></textarea>

        </div>

      </div>

      

       <div class="form-group">

        <label for="zipcode" class="col-md-2 catogery_name">Pincode</label>

        <div class="col-md-6">

           <input type="text" class="form-control form-shadow text_input1 required num" id="zipcode" name="zipcode" value="<?php echo isset($user['pin_code']) ? $user['pin_code'] : ''; ?>" placeholder="Enter Pincode">

        </div>

      </div>
      
      <div class="form-group">

        <label for="country" class="col-md-2 catogery_name">Country</label>

        <div class="col-md-6">

         <select name="country" id="country" class="form-control text_input1 col-md-4 required country_drop">



         <option value="">-select-</option>

          <?php foreach($countries as $country){ ?>

         <option value="<?php echo $country['id']?>" <?php echo (isset($country['id']) && ($country['id']==$user['country'])) ? 'selected' : ''; ?> ><?php echo $country['name']?></option>

          <?php } ?>

          </select>

        </div>

      </div>

      

        <div class="form-group">

        <label for="state" class="col-md-2 catogery_name">State</label>

        <div class="col-md-6">

         <select name="state" id="state" class="form-control text_input1 col-md-4 required state_drop">

         <option value="">-select-</option>

          <?php foreach($states as $state){ ?>

         <option value="<?php echo $state['id']?>" <?php echo (isset($state['id']) && ($state['id']==$user['state'])) ? 'selected' : ''; ?> ><?php echo $state['name']?></option>

          <?php } ?>

          </select>

        </div>

      </div>

      

        <div class="form-group">

        <label for="city" class="col-md-2 catogery_name">City</label>

        <div class="col-md-6" id='loadcities'>

         <select name="city" id="city" class="form-control text_input1 col-md-4 required cities_drop">

         <option value="">-select-</option>

          <?php foreach($cities as $city){ ?>

         <option value="<?php echo $city['id']?>" <?php echo (isset($city['id']) && ($city['id']==$user['city'])) ? 'selected' : ''; ?> ><?php echo $city['name']?></option>

          <?php } ?>

          </select>

        </div>

      </div>

       <div class="form-group">

        <label class="col-md-2 catogery_name">Status</label>

        <div class="col-md-6">

          <input type="checkbox" class="" id="is_active" name="is_active" value="1" <?php echo (isset($user['is_active']) && ($user['is_active']==1))?'checked':'';?>/>Is Active
          <input type="checkbox" class="" id="is_delted" name="is_delted" value="1" <?php echo (($user['is_delete']==1))?'checked':'';?>/>Is Deleted

        </div>

      </div>
      <div class="admin_permissions" style="display:none">
      <div class="form-group">
      <h3 class="col-md-4">Permissions</h3>
      </div>
      
      <div class="form-group">

        <label class="col-md-2 catogery_name">Question</label>

        <div class="col-md-6">

          <input type="checkbox" class="form-contro" id="question_right" name="questionsRight[]" value="adminquestions" />

        </div>

      </div>
      <div class="form-group">

        <label class="col-md-2 catogery_name">Create User</label>

        <div class="col-md-6">

          <input type="checkbox" class="form-contro" id="user_right" name="questionsRight[]" value="adminusers" />

        </div>

      </div>
      <div class="form-group">

        <label class="col-md-2 catogery_name">Subscriptions</label>

        <div class="col-md-6">

          <input type="checkbox" class="form-contro" id="subscription_right" name="questionsRight[]" value="adminsubscriptions"/>

        </div>

      </div>
      <div class="form-group">

        <label class="col-md-2 catogery_name">categories</label>

        <div class="col-md-6">

          <input type="checkbox" class="form-contro" id="categories_right" name="questionsRight[]" value="admincategory"/>

        </div>

      </div>
      <div class="form-group">

        <label class="col-md-2 catogery_name">Settings</label>

        <div class="col-md-6">

          <input type="checkbox" class="form-contro" id="settings_right" name="questionsRight[]" value="admin/settings"/>

        </div>

      </div>
      
      <div class="form-group">

        <label class="col-md-2 catogery_name">Testimonials</label>

        <div class="col-md-6">

          <input type="checkbox" class="form-contro" id="testimonials_right" name="questionsRight[]" value="adminTestimonials"/>

        </div>

      </div>
      </div>
      
      <div class="form-group">

        <div class="col-md-2 catogery_name"></div>

        <div class="col-md-6">

          <button type="submit" class="btn btn-primary location_button"><?php echo ($user['id'] != '') ? 'Update' : 'Add'; ?></button>

        </div>

      </div>
      

    </form>

  </div>

</div>



<script type="text/javascript">

$('.state_drop').change(function () {
	var state_id = jQuery("#state option:selected").val();
	$.ajax({

		type: "POST",

		url: '<?php echo base_url('superadmin/ajax_getcities'); ?>',
		dataType: 'json',
		data: {'id': state_id}, 

		success: function (data) {

			if(data)
			{
			$( ".cities_drop option" ).remove();
			   var combo = $(".cities_drop");
   				$.each(data, function (index, element) {
      			combo.append("<option value='"+ element.id +"'>" + element.name + "</option>");
   				 });

			}

		}

	});

});			

$('.country_drop').change(function () {
	var country_id = jQuery("#country option:selected").val();
	$.ajax({

		type: "POST",

		url: '<?php echo base_url('superadmin/getstates'); ?>',
		dataType: 'json',
		data: {'id': country_id}, 

		success: function (data) {

			if(data)
			{
			$( ".state_drop option" ).remove();
			   var combo = $(".state_drop");
   				$.each(data, function (index, element) {
      			combo.append("<option value='"+ element.id +"'>" + element.name + "</option>");
   				 });

			}

		}

	});

});	

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
    url: "userexists",  
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
$('#role_drop').on('change',function() {
    var $option = $(this).find('option:selected');
    var value = $option.val();
	if(value == 2)
	$('.admin_permissions').fadeIn();
	else{
		$('.admin_permissions').fadeOut();
		}
});
});
</script>

