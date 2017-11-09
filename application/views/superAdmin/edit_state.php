<div class="memberlogin-wps col-md-10 products_page">

    <div class="dashboard-main-heading"><h2>Update state</h2></div>

  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>" />

  <div class="col-md-12"> <?php echo validation_errors(); ?>

    <form method="post" role="form" action="<?php echo base_url('admin/edit_state/')?>">

      <input type="hidden" name="id" value="<?php echo $state_details['id']; ?>" />

      <div class="form-group">

        <label for="name" class="col-md-3 catogery_name">State Name</label>

        <div class="col-md-9">

          <input type="text" class="form-control form-shadow" id="sname" name="sname" value="<?php echo $state_details['name']; ?>" placeholder="Enter state name" required>

        </div>
        
      </div>
      <div class="form-group">

        <div class="col-md-3"></div>

        <div class="col-md-9">

          <button type="submit" class="btn btn-primary location_button btn-style-rev">Update</button>

        </div>

      </div>

    </form>

  </div>

</div>

