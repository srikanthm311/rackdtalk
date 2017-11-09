<script src="https://rawgithub.com/trentrichardson/jQuery-Timepicker-Addon/master/jquery-ui-timepicker-addon.js"></script>
<script src="https://rawgithub.com/trentrichardson/jQuery-Timepicker-Addon/master/jquery-ui-sliderAccess.js"></script>
<div class="col-md-10 col-sm-9 main_backup">


<div class="memberlogin-wps col-md-12 products_page">

    <div class="dashboard-main-block">
        <div class="dashboard-main-hdng">
            <h2>Questions List</h2>
        </div>
        <div class="dashboard-main-btn">
            <a class="category_add" href="<?php echo base_url('superadmin/post_your_question')?>">Post Question</a>
        </div>
    </div>

  <div class="col-md-12"> </div>

  

 <table class="table table-hover table-striped table_hd1">

    <thead class="table_heading">

		<tr>
			<th> S.No</th>
			<th>Name</th>

            <th>Role</th>
            
            <th>Email</th>

			<th>Mobile</th>

            <th>count</th>
		</tr>

	</thead>

	<!-- Table Header -->



	<!-- Table Body -->

	 <tbody>    <?php $i=1;

	 

	             if(!empty($frequent_takers))

				 {

                 foreach($frequent_takers as $frequent_taker)

				 {

                 ?>

                    <tr class="<?php echo ($i%2==0)?'even':'' ?>">
					<td> <?php echo ++$t; ?></td>
                    <td> <?php echo $frequent_taker['first_name'].' '. $frequent_taker['last_name']?></td>

                       <td>
                     <?php if($frequent_taker['role_id'] == 2)
					 			echo "Admin";
							elseif($frequent_taker['role_id'] == 3)
								echo "User";
							else
								echo "Super Admin";
								?>
                     </td>

                     <td> <?php echo $frequent_taker['email_id']?></td>

                     <td> <?php echo $frequent_taker['mobile']?></td>
                     
                    <td> <?php echo $frequent_taker['c']?></td>
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

</div>

</div>
