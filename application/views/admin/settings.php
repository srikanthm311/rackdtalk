<div class="memberlogin-wps col-md-10 products_page">
    <div class="dashboard-main-heading"><h2>Update Settings</h2></div>
  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>" />
  <div class="col-md-12"> <?php echo validation_errors(); ?>
    <form method="post" role="form" id="add-location-form" class="validate-form">
             
<?php foreach($settings as $settingKey=> $val){ ?>
      <div class="form-group">
        <label for="stax" class="col-md-3 catogery_name form-shadow"><?php echo $settingKey?></label>
        <div class="col-md-9">
          <input type="text" class="form-control text_input1 required num form-shadow" id="<?php echo $settingKey?>" name="<?php echo $settingKey?>" value="<?php echo isset($val) ? $val : ''; ?>" placeholder="Enter <?php echo $settingKey?>">
        </div>
      </div>
<?php } ?>
      <div class="form-group">
        <div class="col-md-3"></div>
        <div class="col-md-9">
          <button type="submit" class="btn btn-primary location_button btn-style-rev">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>


