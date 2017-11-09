<div class="col-md-10 col-sm-9 main_backup">



<div class="memberlogin-wps col-md-12 products_page">

    <div class="dashboard-main-heading"> <h2>Countries<?php /*?><a class="category_add" href="<?php echo base_url('adminusers/add_user')?>">Add New Service</a><?php */?></h2></div>

  <div class="col-md-12"> </div>

  <div class="search">
<!--  <div> search</div>-->
  <form action="" method="post">
  <div style="width:100%;float:left;"><input type="text" class="form-control form-shadow" name="country_title" style="width:50%; float:left; margin-left: 12px;"placeholder="enter country name"/><span>
      <input class="btn btn-primary btn-style-rev" style=" margin-left:20px" type="submit" value="search" /></span><input type="hidden" name="identity" value="1"></div>
  </form>
  </div>
  
    <div class="devider-dashboard"></div>
 
 
 <table class="table table-hover table-striped table_hd1">

    <thead class="table_heading">

		<tr>
			<th> S.No</th>
			<th>Country Code</th>

            <th>Country Name</th>
            <th>Phone Code</th>
            <th width="10%">Edit</th>

		</tr>

	</thead>

	<!-- Table Header -->



	<!-- Table Body -->

	 <tbody>    <?php $i=1;

	 

	             if(!empty($countries))

				 { $cnt = $this->uri->segment(3);

                 foreach($countries as $country)

				 {

                 ?>

                    <tr class="<?php echo ($i%2==0)?'even':'' ?>">
					<td> <?php echo ++$cnt;?></td>
                    <td> <?php echo $country['sortname']?></td>

                      <td> <?php echo $country['name']?></td>
                      <td> <?php echo $country['phonecode']?></td>

                    <td style=" text-align:center"><a href="<?php echo base_url('superadmin/edit_country/'.$country['id'])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>

                    <?php /*?><td class="textbutton"> <a href='<?php echo base_url('admincustomers/add_customer/'.$sub['customer_id'])?>' data-toggle="tooltip" data-placement="top" title="Edit" class="glyphicon glyphicon-pencil view_button"></a></td><?php */?>


                   </tr>

             <?php

				 $i++; }

				 }else{?>

					 <tr ><td colspan="9" style="text-align:center">No records found</td></tr>

				<?php  }

                 ?>

                



	</tbody>

	<!-- Table Body -->



</table>
<?php if(isset($paginationLinks))echo $paginationLinks; ?>
</div>

</div>