<script type="text/javascript" src="<?php echo base_url('js/ajaxfileupload.js');?>"></script>

<div class="memberlogin-wps col-md-10 products_page">

    <div class="dashboard-main-heading"><h2><?php echo isset($subscriptions_detials['id']) ? 'Update' : 'Add'; ?> Subscription</h2></div>

  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>" />

  <div class="col-md-12"> <?php echo validation_errors(); ?>

    <form method="post" role="form" id="add-location-form" class="validate-form" action="<?php echo base_url('superadmin/add_subscription')?>">

      <input type="hidden" name="id" value="<?php echo isset($subscriptions_detials['id']) ? $subscriptions_detials['id'] : ''; ?>" />

      <div class="form-group">

        <label for="sub_name" class="col-md-3 catogery_name">Subscription Name</label>

        <div class="col-md-9">

          <input type="text" class="form-control text_input1 required alpha form-shadow" id="sub_name" name="sub_name" value="<?php echo isset($subscriptions_detials['subscription_name']) ? $subscriptions_detials['subscription_name'] : ''; ?>" placeholder="Enter Subscription Name">

        </div>

      </div>

        <div class="form-group">

        <label for="sub_price" class="col-md-3 catogery_name">Subscription Price</label>

        <div class="col-md-9">

          <input type="text" class="form-control text_input1 required num form-shadow" id="sub_price" name="sub_price" value="<?php echo isset($subscriptions_detials['subscription_price']) ? $subscriptions_detials['subscription_price'] : ''; ?>" placeholder="Enter Subscription Price">

        </div>

      </div>

      <div class="form-group">

        <label for="discount_type" class="col-md-3 catogery_name">Discount Type</label>

        <div class="col-md-9">

          <select name="discount_type" class="form-control text_input1 col-md-4 required form-shadow">
          <option value="" selected="selected">-- select role --</option>
          <option value="amount" <?php echo ($subscriptions_detials['discount_type'] == 'amount') ? 'selected' : '';?>>Amount</option>
          <option value="percentage" <?php echo ($subscriptions_detials['discount_type'] == 'percentage') ? 'selected' : '';?>>Percentage</option>
          </select>
        </div>

      </div>
      <div class="form-group">

        <label for="discount" class="col-md-3 catogery_name">Discount</label>

        <div class="col-md-9">

          <input type="text" class="form-control text_input1 required num form-shadow" id="discount" name="discount" value="<?php echo isset($subscriptions_detials['discount']) ? $subscriptions_detials['discount'] : ''; ?>" <?php echo isset($subscription['discount']) ? 'readonly' : ''; ?> placeholder="Enter discount">

        </div>

      </div>

        <div class="form-group">

        <label for="time_period" class="col-md-3 catogery_name">Time Period</label>

        <div class="col-md-9">

          <input type="text" class="form-control text_input1 required num form-shadow" id="time_period" name="time_period" value="<?php echo isset($subscriptions_detials['time_period']) ? $subscriptions_detials['time_period'] : ''; ?>" placeholder="Enter No of days">

        </div>

      </div>


      <div class="form-group">

        <div class="col-md-3"></div>

        <div class="col-md-9">

          <button type="submit" class="btn btn-primary btn-style-rev"><?php echo isset($subscriptions_detials['id']) ? 'Update' : 'Add'; ?></button>

        </div>

      </div>

    </form>

  </div>

</div>

