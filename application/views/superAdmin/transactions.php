<script src="https://rawgithub.com/trentrichardson/jQuery-Timepicker-Addon/master/jquery-ui-timepicker-addon.js"></script>
<script src="https://rawgithub.com/trentrichardson/jQuery-Timepicker-Addon/master/jquery-ui-sliderAccess.js"></script>
<div class="col-md-10 col-sm-9 main_backup">


<div class="memberlogin-wps col-md-12 products_page">

    <div class="dashboard-main-heading"><h2>Transactions List<?php /*?>/*<a class="category_add" href="<?php echo base_url('superadmin/post_your_question')?>">Post Question</a><?php */?></h2></div>

  <div class="col-md-12"> </div>

 <table class="table table-hover table-striped table_hd1">

    <thead class="table_heading">

		<tr>
			<th> S.No</th>
			<th>Transaction ID</th>

            <th>Trasaction Amount</th>
            
            <th>Transaction Type</th>
            
            <th>User</th>

			<th>User Type</th>
            <th>Is refunded</th>

            <th>Status</th>
            <th>Created At</th>
            <th>Updated At</th>

		</tr>

	</thead>

	<!-- Table Header -->

	<!-- Table Body -->

	 <tbody>    <?php $i=1;

	             if(!empty($transactions))

				 {

                 foreach($transactions as $transaction)

				 {

                 ?>

                    <tr class="<?php echo ($i%2==0)?'even':'' ?>">
					<td> <?php echo ++$t; ?></td>
                    <td> <?php echo $transaction['txn_uid']?></td>

                      <td> <?php echo $transaction['amount']?></td>
                      <td> <?php echo $transaction['txn_type']?></td>

                     <td> <?php echo $transaction['email_id']?></td>

                     <td> <?php echo $transaction['user_type']?></td>
                     
                    <td> <?php echo $transaction['is_refunded']?></td>
                    <td> <?php echo $transaction['status']?></td>
                    
                    <td> <?php echo $transaction['created_at']?></td>
                    <td> <?php echo $transaction['updated_at']?></td>

                   </tr>

             <?php

				 $i++; }

				 }else{?>

					 <tr ><td colspan="9" style="text-align:center">No records found</td></tr>

				<?php  }

                 ?>
	</tbody>
</table>
<?php if(isset($paginationLinks))echo $paginationLinks; ?>
</div>

</div>

<script>
  $( function() {
    $( "#comment_closed_at" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  $( function() {
    $( "#bidding_closed_at" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>
