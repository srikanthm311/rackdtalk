<div class="col-md-9 col-sm-9 main_backup">



<div class="memberlogin-wps col-md-12 products_page">

    <div class="dashboard-main-block">
        <div class="dashboard-main-hdng"><h2>Users</h2></div>
        <div class="dashboard-main-btn"><a class="category_add" href="<?php echo base_url('superadminusers/add_user')?>">Add User</a></div>
    </div>

  <div class="col-md-12"> </div>

  

 <table class="table table-hover table-striped table_hd1">

    <thead class="table_heading">

		<tr>

			<th>First Name</th>

            <th>Last Name</th>

			<th>Username</th>

            <th>Mobile</th>
            
            <th>Role</th>

        <?php /*?>    <th>Country</th>
            <th>State</th>

            <th>City</th><?php */?>

            <th>Status</th>
  <th>Activity</th>
            <th width="5%">Edit</th>
            
            <th width="5%">Delete</th>

			

		</tr>

	</thead>

	<!-- Table Header -->



	<!-- Table Body -->

	 <tbody>    <?php $i=1;

	 

	             if(!empty($users))

				 {

                 foreach($users as $sub)

				 {

                 ?>

                     <tr class="<?php echo ($i%2==0)?'even':'' ?>">
                     <td> <?php echo $sub['first_name']?></td>
                     <td> <?php echo $sub['last_name']?></td>
                     <td> <?php echo $sub['email_id']?></td>
                     <td> <?php echo $sub['mobile']?></td>
                     <td>
                     <?php if($sub['role_id'] == 2)echo "Admin";elseif($sub['role_id'] == 3)echo "User";else echo "Super Admin";
								?>
                     </td>
                    <th id="serviceActive-<?php echo $sub['id']; ?>"><?php echo ($sub['is_active']) ? '<a data-toggle="tooltip" data-placement="top" title="Click here to inactivate" class="btn btn-sm btn-success" onclick="activate(\''.$sub['id'].'\', \'0\')">Active</a>' : '<a data-toggle="tooltip" data-placement="top" title="Click here to activate" class="btn btn-sm btn-danger" onclick="activate(\''.$sub['id'].'\', \'1\')">Inactive</a>'; ?></th>
                    <th id="serviceActivity-<?php echo $sub['id']; ?>"><a href="<?php echo base_url('superadminusers/userActivities/'.$sub['id'].'/'.$sub['role_id'])?>" class="btn btn-sm btn-success">Activities</a></th>
                    <td><a href='<?php echo base_url('superadminusers/add_user/'.$sub['id'])?>' class="fa fa-edit"></a></td>
                    <td > <a onclick='return confirm("Are you sure?")' href='<?php echo base_url('superadminusers/deleteuser/'.$sub['id'])?>' class="fa fa-trash"></a></td>
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

		url: '<?php echo base_url('superadminusers/updateUserStatus'); ?>',

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