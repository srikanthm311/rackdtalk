<div class="col-md-2 col-sm-3 backend_style"  id="floatDiv">

    <div id="MainMenu">

 <?php $controller = $this->router->fetch_class(); ?>

<?php $method = $this->router->fetch_method(); ?> 

    <div class="list-group panel panel_group">

    

      <a href="<?php echo base_url('superadmin/dashboard')?>" class="list-group-item1 list-group-item-success1 <?php echo (($this->router->fetch_method()=='dashboard'))? 'active':''?>"><i class="icon-dashboard"></i>Dashboard</a> 

      



      <a href="<?php echo base_url('superadmincategory')?>" class="list-group-item1 list-group-item-success1 <?php echo ((($this->router->fetch_method()=='index') || ($this->router->fetch_method()=='add_category')) && ($this->router->fetch_class()=='superadmincategory'))? 'active':''?>"><i class="fa fa-tags" aria-hidden="true"></i>Categories</a> 

      <a href="<?php echo base_url('superadmin/subscriptions')?>" class="list-group-item1 list-group-item-success1 <?php echo ((($this->router->fetch_method()=='subscriptions') || ($this->router->fetch_method()=='add_subscription')) && ($this->router->fetch_class()=='superadmin'))? 'active':''?>"><i class="fa fa-tags" aria-hidden="true"></i>Subscriptions</a> 
      
             <a href="<?php echo base_url('superadminrevenue')?>" class="list-group-item1 list-group-item-success1 <?php echo (($this->router->fetch_class()=='superadminrevenue'))? 'active':''?>"><i class="fa fa-cog" aria-hidden="true"></i>Revenue</a>
      
       <a href="<?php echo base_url('superadmin/questions')?>" class="list-group-item1 list-group-item-success1 <?php echo ((($this->router->fetch_method()=='questions') || ($this->router->fetch_method()=='post_your_question')) && ($this->router->fetch_class()=='superadmin'))? 'active':''?>"><i class="fa fa-tags" aria-hidden="true"></i>Questions</a> 

      <a href="<?php echo base_url('superadminusers')?>" class="list-group-item1 list-group-item-success1 <?php echo ((($this->router->fetch_method()=='index') || ($this->router->fetch_method()=='add_user') || ($this->router->fetch_method()=='userActivities')) && ($this->router->fetch_class()=='superadminusers'))? 'active':''?>"><i class="fa fa-user" aria-hidden="true"></i>Users</a> 
      
      <a href="<?php echo base_url('superadmin/transactions')?>" class="list-group-item1 list-group-item-success1 <?php echo ((($this->router->fetch_method()=='transactions') || ($this->router->fetch_method()=='add_user')) && ($this->router->fetch_class()=='superadmin'))? 'active':''?>"><i class="fa fa-user" aria-hidden="true"></i>Users Transactions</a> 

        <a href="<?php echo base_url('superadmin/countries')?>" class="list-group-item1 list-group-item-success1 <?php echo ((($this->router->fetch_method()=='countries') || ($this->router->fetch_method()=='edit_country')) && ($this->router->fetch_class()=='superadmin'))? 'active':''?>"><i class="fa fa-globe" aria-hidden="true"></i>Countries</a>
        
        <a href="<?php echo base_url('superadmin/states')?>" class="list-group-item1 list-group-item-success1 <?php echo ((($this->router->fetch_method()=='states') || ($this->router->fetch_method()=='edit_state')) && ($this->router->fetch_class()=='superadmin'))? 'active':''?>"><i class="fa fa-circle" aria-hidden="true"></i>States</a>
        
        <a href="<?php echo base_url('superadmin/cities')?>" class="list-group-item1 list-group-item-success1 <?php echo ((($this->router->fetch_method()=='cities') || ($this->router->fetch_method()=='edit_city')) && ($this->router->fetch_class()=='superadmin'))? 'active':''?>"><i class="fa fa-caret-down" aria-hidden="true"></i>Cities</a>

       <a href="<?php echo base_url('superadmin/settings')?>" class="list-group-item1 list-group-item-success1 <?php echo (($this->router->fetch_method()=='settings'))? 'active':''?>"><i class="fa fa-cog" aria-hidden="true"></i>Settings</a> 
       
       <a href="<?php echo base_url('superadmin/frequent_takers')?>" class="list-group-item1 list-group-item-success1 <?php echo (($this->router->fetch_method()=='frequent_takers'))? 'active':''?>"><i class="fa fa-cog" aria-hidden="true"></i>Frequent Takers</a>
       
       <a href="<?php echo base_url('superadmin/trending_talkers')?>" class="list-group-item1 list-group-item-success1 <?php echo (($this->router->fetch_method()=='trending_talkers'))? 'active':''?>"><i class="fa fa-cog" aria-hidden="true"></i>Trending Talkers</a>
       
       <a href="<?php echo base_url('superadminwithdraw')?>" class="list-group-item1 list-group-item-success1 <?php echo (($this->router->fetch_method()=='index'))? 'active':''?>"><i class="fa fa-cog" aria-hidden="true"></i>Withdrawls</a>

    

    </div>

  

  </div>

  

    <div> </div>

</div>

