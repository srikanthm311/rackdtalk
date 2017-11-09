<script src="https://rawgithub.com/trentrichardson/jQuery-Timepicker-Addon/master/jquery-ui-timepicker-addon.js"></script>
<script src="https://rawgithub.com/trentrichardson/jQuery-Timepicker-Addon/master/jquery-ui-sliderAccess.js"></script>
<div class="col-md-7 col-sm-9 main_backup dashboard-left-main">


<div class="memberlogin-wps col-md-12 products_page">

  <h2>Testimanials List<a class="category_add" href="<?php echo base_url('superadmin/post_your_question')?>">Post Question</a></h2>

  <div class="col-md-12"> </div>

  

 <table class="table table-hover table-striped table_hd1">

    <thead class="table_heading">

		<tr>
        <th>S No</th>

			<th>Name</th>

            <th>Designation</th>
            
            <th>Message</th>
            
            <th width="10%">Approve</th>

            <th width="10%">Delete</th>
		</tr>

	</thead>

	<!-- Table Header -->



	<!-- Table Body -->

	 <tbody>    <?php $i=1;

	 

	             if(!empty($testimanials))

				 {

                 foreach($testimanials as $testimanial)

				 {

                 ?>

                    <tr class="<?php echo ($i%2==0)?'even':'' ?>">
					<td> <?php echo ++$t; ?></td>
                    <td> <?php echo $testimanial['first_name']?></td>

                      <td> <?php echo $testimanial['designation']?></td>

                     <td> <?php echo $testimanial['message']?></td>
                    
                    <th id="serviceApprove-<?php echo $testimanial['id']; ?>"><?php echo (!$testimanial['is_approve']) ? '<a data-toggle="tooltip" data-placement="top" title="Click here to Approve" class="btn btn-sm btn-danger threeq" onclick="confirmApprove(\''.$testimanial['id'].'\')">Approve</a>' : '<a data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-success">Approved</a>'; ?></th>
                    
                    <td > <a onclick='return confirm("Are you sure?")' href='<?php echo base_url('superadmin/deleteTestimanial/'.$testimanial['id'])?>' class="fa fa-trash"></a></td>
                    
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

function confirmApprove(id)
{
	
	var dataString = "ID="+id;
	$.ajax({
		type: "POST",
		url: '<?php echo base_url('superadmin/testimanialApprove'); ?>',
		data: dataString,
		success: function (data) {
			if(data)
			{
				var html = '';
				if(data == 1) 
				html = '<a class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top">Approved</a>';
				$("#serviceApprove-"+id).html(html);
			}
		}
	});
}

function approve(qID)
{
$('#qID').val(qID); 
 $('#comment_closed_at').datepicker("setDate", "+<?php echo $settings['QuestionCommentExpiryTime']?>");
 $('#bidding_closed_at').datepicker("setDate", "+<?php echo $settings['QuestionCommentBiddingExpiryTime']?>");
$('#myModalStatus').modal('show');
}


</script>

<script>
  $( function() {
    $( "#comment_closed_at" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  $( function() {
    $( "#bidding_closed_at" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>
