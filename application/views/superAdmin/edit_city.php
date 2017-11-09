<div class="memberlogin-wps col-md-10 products_page">

  <h2>Update City</h2>

  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>" />

  <div class="col-md-12"> <?php echo validation_errors(); ?>

    <form method="post" role="form" action="<?php echo base_url('admin/edit_city')?>">

      <input type="hidden" name="id" value="<?php echo $city_details['id']; ?>" />

      <div class="form-group">

        <label for="name" class="col-md-2 catogery_name">City Name</label>

        <div class="col-md-10">

          <input type="text" class="form-control form-shadow" id="cityname" name="cityname" value="<?php echo $city_details['name']; ?>" placeholder="Enter state name" required>
                   <button type="submit" class="btn btn-primary location_button btn-update-city">Update</button>

        </div>
        
      </div>


    </form>

  </div>

</div>

