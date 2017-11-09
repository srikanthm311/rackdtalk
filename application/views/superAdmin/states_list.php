<div class="col-md-10 col-sm-9 main_backup">



<div class="memberlogin-wps col-md-12 products_page">

    <div class="dashboard-main-heading"><h2>States<?php /*?><a class="category_add" href="<?php echo base_url('adminusers/add_user')?>">Add New Service</a><?php */?></h2></div>

  <div class="col-md-12"> </div>
 <div class="search cities-block">
   
     <table><tr>
   <tr>
  <form action="" method="post">
<td><select name="country_id" class="form-control form-shadow">
  <option value="">select country</option>
  <?php foreach($countries as $country){?>
  <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
  <?php }?>
  </select>
      </td>
      
  <td><input style=" margin-left:20px" type="text" class="form-control form-shadow" name="state_title" placeholder="Enter State Name"/></td>
      
  <td><input class="btn btn-primary form-shadow btn-style-rev" style=" margin-left:40px" type="submit" value="search" /></td>
  <input type="hidden" name="identity" value="1">
  </form>
  </tr>
  </table>
  </div>
  <div class="devider-dashboard"></div>

 <table class="table table-hover table-striped table_hd1">

    <thead class="table_heading">

		<tr>
			<th> S.No</th>
			<th>State Name</th>
            <th>country Name</th>
            <th width="10%">Edit</th>

		</tr>

	</thead>

	<!-- Table Header -->



	<!-- Table Body -->

	 <tbody>    <?php $i=1;

	 

	             if(!empty($states))

				 { $cnt = $this->uri->segment(3);

                 foreach($states as $state)

				 {

                 ?>

                    <tr class="<?php echo ($i%2==0)?'even':'' ?>">
					<td> <?php echo ++$cnt;?></td>
                    <td> <?php echo $state['name']?></td>
                    <td> <?php echo $state['country_name']?></td>
                    <td style=" text-align:center"><a href="<?php echo base_url('superadmin/edit_state/'.$state['id'])?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>

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