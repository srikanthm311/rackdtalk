<script src="http://cdn.ckeditor.com/4.5.2/standard-all/ckeditor.js"></script>
<script src="http://cdn.ckeditor.com/4.5.2/standard-all/adapters/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url('library/js/ajaxfileupload.js');?>"></script>
<script type="text/javascript">
function ajaxFileUpload(pathsetid , elementid, filetype)
{
	var uplaod_url = $("#base_url").val()+'admin/uploadImage';var imgw= $("#imgw").val();var imgh= $("#imgh").val();
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
			data:{ name:elementid, showid:pathsetid, filetype:filetype, pathfolder:'blogs',width:imgw,height:imgh},
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
<div class="memberlogin-wps col-md-7 products_page">
  <h2><?php echo isset($blog['id']) ? 'Update' : 'Add'; ?> Blog</h2>
  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>" />
  <div class="col-md-12"> <?php echo validation_errors(); ?>
    <form method="post" role="form" id="add-location-form" class="validate-form">
      <input type="hidden" name="id" value="<?php echo isset($blog['id']) ? $blog['id'] : ''; ?>" />
      
      
      <div class="form-group">
        <label for="name" class="col-md-4 catogery_name">Blog Title</label>
        <div class="col-md-6">
          <input type="text" class="form-control text_input1 required alpha" id="title" name="title" value="<?php echo isset($blog['title']) ? $blog['title'] : ''; ?>" placeholder="Enter Package Name">
        </div>
      </div>
     
        <div class="form-group">
        <label for="email" class="col-md-4 catogery_name">Short Description</label>
        <div class="col-md-6">
          <textarea type="text" class="form-control text_input1 required" id="short_description" name="short_description"  placeholder="Enter Short Description"><?php echo isset($blog['short_description']) ? $blog['short_description'] : ''; ?></textarea>
        </div>
      </div>
      
        <div class="form-group">
        <label for="email" class="col-md-4 catogery_name">Description</label>
        <div class="col-md-6">
          <textarea type="text" class="form-control text_input1 required" id="description" name="description"  placeholder="Enter Description"><?php echo isset($blog['description']) ? $blog['description'] : ''; ?></textarea>
        </div>
      </div>
      
       <div class="form-group"><input type="hidden" id="imgw"  value="1024"/><input type="hidden" id="imgh"  value="442"/>
        <label for="upload-appl-imgPath" class="col-md-4 catogery_name">Image(1024 X 442)</label>
        <div class="col-md-6">
          <input type="file" name="upload_appl" id="upload-appl" onchange="return ajaxFileUpload('applimagepath','upload-appl');" class="input-file"/>
          <input type="hidden" name="applimagepath" id="upload-appl-imgPath" style="margin:5px 0px 10px 0px" value="<?php echo isset($blog['image']) ? $blog['image'] : '';?>"/>
          <a href="<?php echo base_url(isset($blog['image']) ? $blog['image'] : '');?>" id="upload-appl-imgPath_a" target="_blank"><img name="upload-appl-imgPath_img" id="upload-appl-imgPath_img"  style='margin:5px 0px 10px 0px;' src="<?php echo base_url(isset($blog['image']) ? $blog['image'] : 'images/nopreview.jpg');?>" width='400' height='242' /></a> <span id="upload-appl-success-mssg"></span> <span id="upload-appl-error-mssg"></span> </div>
      </div>
       
      
       
      <div class="form-group">
        <label for="statusa" class="col-md-4 catogery_name">Status</label>
        <div class="col-md-6">
          <input type="radio" class="" id="statusa" name="status" value="1" <?php echo (isset($blog['is_active']) && ($blog['is_active']==1))?'checked':'';?>/>Active 
          <input type="radio" class="" id="statusia" name="status" value="0" <?php echo (($blog['is_active']==0))?'checked':'';?>/>Inactive
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-4"></div>
        <div class="col-md-6">
          <button type="submit" class="btn btn-primary location_button"><?php echo isset($blog['id']) ? 'Update' : 'Add'; ?></button>
        </div>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">
CKEDITOR.replace( 'description', {
			/*fullPage: true,
			extraPlugins: 'docprops',*/
			// Disable content filtering because if you use full page mode, you probably
			// want to  freely enter any HTML content in source mode without any limitations.
			allowedContent: true,
			width: 1109,
			height: 200,
			filebrowserUploadUrl: "<?php echo base_url(); ?>uploadckimage.php",
		} 
		);

</script>
