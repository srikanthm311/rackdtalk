<div class="memberlogin-wps col-md-10 products_page">

    <div class="dashboard-main-heading"><h2>Update Category</h2></div>

  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>" />

  <div class="col-md-12"> <?php echo validation_errors(); ?>

    <form method="post" role="form" action="<?php echo base_url('admin/edit_country/')?>">

      <input type="hidden" name="id" value="<?php echo $country_details['id']; ?>" />

      <div class="form-group">

        <label for="name" class="col-md-2 catogery_name">Country Code</label>

        <div class="col-md-10">

          <input type="text" class="form-control orm-shadow" id="ccode" name="ccode" value="<?php echo $country_details['sortname']; ?>" placeholder="Enter Country code" required>

        </div>
        
      </div>
      <div class="form-group">

        <label for="name" class="col-md-2 catogery_name">Country Name</label>

        <div class="col-md-10">

          <input type="text" class="form-control orm-shadow" id="cname" name="cname" value="<?php echo $country_details['name']; ?>" placeholder="Enter Country Name" required>

        </div>
        
      </div>
      <div class="form-group">

        <label for="name" class="col-md-2 catogery_name">Phone Code</label>

        <div class="col-md-10">

          <input type="text" class="form-control orm-shadow" id="cpcode" name="cpcode" value="<?php echo $country_details['phonecode']; ?>" placeholder="Enter Country phone Code" required>

        </div>
        
      </div>

      <div class="form-group">

        <div class="col-md-2"></div>

        <div class="col-md-10">

          <button type="submit" class="btn btn-primary location_button btn-style-rev">Update</button>

        </div>

      </div>

    </form>

  </div>

</div>

