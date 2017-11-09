<div class="memberlogin-wps col-md-10 products_page">

    <div class="dashboard-main-heading"><div class="dashboard-main-heading"><h2><?php echo isset($category['id']) ? 'Update' : 'Add'; ?> Category</h2></div></div>

  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>" />

  <div class="col-md-12"> <?php echo validation_errors(); ?>

    <form method="post" role="form" id="add-location-form" class="validate-form" enctype="multipart/form-data">

      <input type="hidden" name="id" value="<?php echo isset($category['id']) ? $category['id'] : ''; ?>" />

      <div class="form-group">

        <label for="name" class="col-md-2 catogery_name">Name</label>

        <div class="col-md-10">

          <input type="text" class="form-control text_input1 required alpha form-shadow" id="name" name="name" value="<?php echo isset($category['category_name']) ? $category['category_name'] : ''; ?>" placeholder="Enter Category Name">

        </div>

      </div>
      
      <div class="form-group">

        <label for="name" class="col-md-2 catogery_name">Name In Hindi: </label>

        <div class="col-md-10">

          <input type="text" class="form-control text_input1 required alpha form-shadow" id="name_hi" name="name_hi" value="<?php echo isset($category['category_name_hi']) ? $category['category_name_hi'] : ''; ?>" placeholder="Enter Category Name In Hindi">

        </div>

      </div>
      
      <div class="form-group">

        <label for="statusa" class="col-md-2 catogery_name">Image</label>

        <div class="col-md-10">

          <input type="file" class="form-control form-shadow" id="cat_image" name="cat_image" />

        </div>

      </div>

       <div class="form-group">

        <label for="statusa" class="col-md-2 catogery_name">Status</label>

        <div class="col-md-10">

          <input type="radio" class="" id="statusa" name="status" value="1" <?php echo (isset($category['is_active']) && ($category['is_active']==1))?'checked':'';?>/>Active 

          <input style="margin-left: 40px;" type="radio" class="" id="statusia" name="status" value="0" <?php echo (($category['is_active']==0))?'checked':'';?>/>Inactive

        </div>

      </div>
      
      

      <div class="form-group">

        <div class="col-md-2"></div>

        <div class="col-md-10">

          <button type="submit" class="btn btn-primary location_button btn-style-rev"><?php echo isset($category['id']) ? 'Update' : 'Add'; ?></button>

        </div>

      </div>

    </form>
    <?php if($category['image'] != ''){?>
 <div style="width: 30%;">
 <img src="<?php echo base_url().$category['image']?>" style="width:100%;margin-top: 74px;">
 </div>
 <?php }?>
  </div>

</div>

