<div class="col-md-2 col-sm-3 backend_style"  id="floatDiv">

    <div id="MainMenu">

 <?php $controller = $this->router->fetch_class(); ?>

<?php $method = $this->router->fetch_method(); ?> 

    <div class="list-group panel panel_group">

    

      <a href="<?php echo base_url('admin/dashboard')?>" class="list-group-item1 list-group-item-success1 <?php echo (($this->router->fetch_method()=='dashboard'))? 'active':''?>"><i class="icon-dashboard"></i>Dashboard</a> 

<?php foreach($rights as $right){if($right['admincategory'] == 'admincategory' ){?>    
	 <a href="<?php echo base_url('admincategory')?>" class="list-group-item1 list-group-item-success1 <?php echo ((($this->router->fetch_method()=='index') || ($this->router->fetch_method()=='add_category')) && ($this->router->fetch_class()=='admincategory'))? 'active':''?>"><i class="fa fa-tags" aria-hidden="true"></i>Categories</a>
  <?php  }}?>

<?php foreach($rights as $right){if($right['adminsubscriptions'] == 'adminsubscriptions' ){?> 
      <a href="<?php echo base_url('adminsubscription')?>" class="list-group-item1 list-group-item-success1 <?php echo ((($this->router->fetch_method()=='index') || ($this->router->fetch_method()=='add_subscription')) && ($this->router->fetch_class()=='adminsubscription'))? 'active':''?>"><i class="fa fa-tags" aria-hidden="true"></i>Subscriptions</a> 
<?php }}?>

<?php foreach($rights as $right){if($right['adminquestions'] == 'adminquestions' ){?> 
       <a href="<?php echo base_url('adminquestions')?>" class="list-group-item1 list-group-item-success1 <?php echo ((($this->router->fetch_method()=='index') || ($this->router->fetch_method()=='post_question')) && ($this->router->fetch_class()=='adminquestions'))? 'active':''?>"><i class="fa fa-tags" aria-hidden="true"></i>Questions</a>
<?php }}?>

       
<?php foreach($rights as $right){if($right['adminusers'] == 'adminusers' ){?> 
      <a href="<?php echo base_url('adminusers')?>" class="list-group-item1 list-group-item-success1 <?php echo ((($this->router->fetch_method()=='index') || ($this->router->fetch_method()=='add_user')) && ($this->router->fetch_class()=='adminusers'))? 'active':''?>"><i class="fa fa-user" aria-hidden="true"></i>Users</a> 
<?php }}?>

        <a href="<?php echo base_url('admin/countries')?>" class="list-group-item1 list-group-item-success1 <?php echo ((($this->router->fetch_method()=='index') || ($this->router->fetch_method()=='edit_country')) && ($this->router->fetch_class()=='superadmin/countries'))? 'active':''?>"><i class="fa fa-globe" aria-hidden="true"></i>Countries</a>
        
        <a href="<?php echo base_url('admin/states')?>" class="list-group-item1 list-group-item-success1 <?php echo ((($this->router->fetch_method()=='index') || ($this->router->fetch_method()=='edit_state')) && ($this->router->fetch_class()=='superadmin/states'))? 'active':''?>"><i class="fa fa-circle" aria-hidden="true"></i>States</a>
        
        <a href="<?php echo base_url('admin/cities')?>" class="list-group-item1 list-group-item-success1 <?php echo ((($this->router->fetch_method()=='index') || ($this->router->fetch_method()=='edit_city')) && ($this->router->fetch_class()=='superadmin/cities'))? 'active':''?>"><i class="fa fa-caret-down" aria-hidden="true"></i>Cities</a>

<?php foreach($rights as $right){if($right['admin/settings'] == 'admin/settings' ){?> 
       <a href="<?php echo base_url('admin/settings')?>" class="list-group-item1 list-group-item-success1 <?php echo (($this->router->fetch_method()=='settings'))? 'active':''?>"><i class="fa fa-cog" aria-hidden="true"></i>Settings</a> 
<?php }}?>

<?php foreach($rights as $right){if($right['admintestimanials'] == 'admintestimanials' ){?> 
       <a href="<?php echo base_url('admintestimanials')?>" class="list-group-item1 list-group-item-success1 <?php echo (($this->router->fetch_method()=='admintestimanials'))? 'active':''?>"><i class="fa fa-cog" aria-hidden="true"></i>Testimanials</a> 
<?php }}?>

    </div>

  

  </div>

  

    <div> </div>

</div>

