<div class="col-md-7 col-sm-9 main_backup">


<div class="memberlogin-wps col-md-12 products_page">

  <h2>Questions List<a class="category_add" href="<?php echo base_url('adminquestions/post_your_question')?>">Post Question</a></h2>

  <div class="col-md-12"> </div>

  

 <table class="table table-hover table-striped table_hd1">

    <thead class="table_heading">

		<tr>
			<th> S.No</th>
			<th>Question</th>

            <th>Category</th>
            
            <th>Possted By</th>

			<th>Type</th>

            <th>Posted at</th>
            
            <th>Status</th>
            
            <th>Approve</th>
            
            <th width="10%">Edit</th>

            <th width="10%">Delete</th>

			

		</tr>

	</thead>

	<!-- Table Header -->



	<!-- Table Body -->

	 <tbody>    <?php $i=1;

	 

	             if(!empty($questions))

				 {

                 foreach($questions as $question)

				 {

                 ?>

                    <tr class="<?php echo ($i%2==0)?'even':'' ?>">
					<td> <?php echo ++$t; ?></td>
                    <td> <?php echo $question['question']?></td>

                      <td> <?php echo $question['category_name']?></td>

                     <td> <?php echo $question['useremail']?></td>

                     <td> <?php echo $question['type']?></td>
                     
                    <td> <?php echo $question['created_at']?></td>

                    <th id="serviceActive-<?php echo $question['id']; ?>"><?php echo ($question['is_active']) ? '<a data-toggle="tooltip" data-placement="top" title="Click here to inactivate" class="btn btn-sm btn-success" onclick="activate(\''.$question['id'].'\', \'0\')">Active</a>' : '<a data-toggle="tooltip" data-placement="top" title="Click here to activate" class="btn btn-sm btn-danger" onclick="activate(\''.$question['id'].'\', \'1\')">Inactive</a>'; ?></th>
                    
                    <th id="serviceApprove-<?php echo $question['id']; ?>"><?php echo (!$question['is_approved']) ? '<a data-toggle="tooltip" data-placement="top" title="Click here to Approve" class="btn btn-sm btn-danger" onclick="approve(\''.$question['id'].'\', \'1\')">Approve</a>' : '<a data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-success">Approved</a>'; ?></th>
                    
                    <td><a href='<?php echo base_url('adminquestions/post_your_question/'.$question['id'])?>' class="fa fa-edit"></a></td>

                    <td > <a onclick='return confirm("Are you sure?")' href='<?php echo base_url('adminquestions/deleteQuestion/'.$question['id'])?>' class="fa fa-trash"></a></td>
                    
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

		url: '<?php echo base_url('adminquestions/updateSubscriptionStatus'); ?>',

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

function approve(ID, status)

{

	var dataString = "ID="+ID+"&status="+status;

	$.ajax({

		type: "POST",

		url: '<?php echo base_url('adminquestions/questionApprove'); ?>',

		data: dataString,

		success: function (data) {

			if(data)

			{

				var html = '';

				if(status == 1) 

					html = '<a class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top">Approved</a>';

				$("#serviceApprove-"+ID).html(html);

			}

		}

	});

}

</script>