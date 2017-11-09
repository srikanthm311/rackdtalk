<div class="col-md-10 col-sm-9 main_backup">

<div class="memberlogin-wps col-md-12 products_page">

    <div class="dashboard-main-block">
        <div class="dashboard-main-hdng"><h2>Subscription List</h2></div>
        <div class="dashboard-main-btn"><a class="category_add" href="<?php echo base_url('superadmin/add_subscription')?>">Add Subscription</a></div>
    </div>

  <div class="col-md-12"> </div>

 <table class="table table-hover table-striped table_hd1">

    <thead class="table_heading">

		<tr>

			<th>Subscription Name</th>

            <th>Subscription Price</th>
            
            <th>discount Type</th>

			<th>discount</th>

            <th>Time period</th>
            
            <th>Status</th>
            
            <th width="10%">Edit</th>

            <th width="10%">Delete</th>
		</tr>

	</thead>

	<!-- Table Header -->
	<!-- Table Body -->

	 <tbody>    <?php $i=1;

	             if(!empty($subscriptions))

				 {

                 foreach($subscriptions as $subscription)

				 {

                 ?>

                    <tr class="<?php echo ($i%2==0)?'even':'' ?>">

                    <td> <?php echo $subscription['subscription_name']?></td>

                      <td> <?php echo $subscription['subscription_price']?></td>

                     <td> <?php echo $subscription['discount_type']?></td>

                     <td> <?php echo $subscription['discount']?></td>
                     
                    <td> <?php echo $subscription['time_period']?></td>

                    <th id="serviceActive-<?php echo $subscription['id']; ?>"><?php echo ($subscription['is_active']) ? '<a data-toggle="tooltip" data-placement="top" title="Click here to inactivate" class="btn btn-sm btn-success" onclick="activate(\''.$subscription['id'].'\', \'0\')">Active</a>' : '<a data-toggle="tooltip" data-placement="top" title="Click here to activate" class="btn btn-sm btn-danger" onclick="activate(\''.$subscription['id'].'\', \'1\')">Inactive</a>'; ?></th>
                    
                    <td><a href='<?php echo base_url('superadmin/add_subscription/'.$subscription['id'])?>' class="fa fa-edit"></a></td>

                    <td > <a onclick='return confirm("Are you sure?")' href='<?php echo base_url('superadmin/deleteSubscription/'.$subscription['id'])?>' class="fa fa-trash"></a></td>
                    
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

<script type="text/javascript">

function activate(ID, status)

{

	var dataString = "ID="+ID+"&status="+status;

	$.ajax({

		type: "POST",

		url: '<?php echo base_url('superadmin/updateSubscriptionStatus'); ?>',

		data: dataString,

		success: function (data) {

			if(data)

			{

				var html = '';

				if(status == 0)

					html = '<a data-toggle="tooltip" data-placement="top" title="Click here to activate" class="btn btn-sm btn-danger" onclick="activate(\''+ID+'\', \'1\')">Inactive</a>';

				else 

					html = '<a class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Click here to inactivate" onclick="activate(\''+ID+'\', \'0\')">Active</a>';

				$("#serviceActive-"+ID).html(html);

			}

		}

	});

}

</script>