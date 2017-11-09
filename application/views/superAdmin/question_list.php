<script src="https://rawgithub.com/trentrichardson/jQuery-Timepicker-Addon/master/jquery-ui-timepicker-addon.js"></script>
<script src="https://rawgithub.com/trentrichardson/jQuery-Timepicker-Addon/master/jquery-ui-sliderAccess.js"></script>
<div class="col-md-10 col-sm-9 main_backup">


<div class="memberlogin-wps col-md-12 products_page">
	<div class="col-md-12"> 
  <form method="post" action="">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group form-group-50 form-group-size">
                    From Date: <input type="text" class="datepicker hasDatepicker" id="from" name="from" value="" autocapitalize="off">
                </div> 
            </div>
            <div class="col-md-3">
                <div class="form-group form-group-50">
                    To Date : <input type="text" class="datepicker1 hasDatepicker" id="to" name="to" value="" autocapitalize="off">
                </div>
            </div>
            <div class="col-md-3">
           <div class="form-group form-group-50">
                <input class="btn-style-rev" type="submit" id="submit" name="submit" value="submit">
           </div><input type="hidden" name="identity" value="1">
            </div>
        </div>
  </form>
    </div>
    <div class="dashboard-main-block">
        <div class="dashboard-main-hdng"><h2>Questions List</h2></div>
        <div class="dashboard-main-btn"><a class="category_add" href="<?php echo base_url('superadmin/post_your_question')?>">Post Question</a></div>
    </div>

  <div class="col-md-12"> </div>

  

 <table class="table table-hover table-striped table_hd1">

    <thead class="table_heading">

		<tr>
			<th> S.No</th>
			<th>Question</th>

            <th>Category</th>
            
            <th>Possted By</th>


            <th>Posted at</th>
            <th>Closed</th>
            <th>Status</th>
            
            <th>Approve</th>
             <th>More</th>
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
                    <td> 
                    
                    	<?php 
									  switch($question['type'])
									  {
									   case 1 : echo $question['question'];break;
									   case 2 : echo '<img src='.base_url().$question['question'].' width="250" height="150"/>';break;
									   case 3 : echo '<iframe width="250" height="150" src="'.$question['question'].'?modestbranding=1&showinfo=0" frameborder="0" allowfullscreen></iframe>';break;
									   default: echo $question['question'];break;
									  }?></td>

                      <td> <?php echo $question['category_name']?></td>

                     <td> <?php echo $question['useremail']?></td>

                     
                    <td> <?php echo $question['created_at']?></td>
                    <td> <?php echo ($question['is_closed'])?'YES':'NO';?></td>

                    <th id="serviceActive-<?php echo $question['id']; ?>"><?php echo ($question['is_active']) ? '<a data-toggle="tooltip" data-placement="top" title="Click here to inactivate" class="btn btn-sm btn-success" onclick="activate(\''.$question['id'].'\', \'0\')">Active</a>' : '<a data-toggle="tooltip" data-placement="top" title="Click here to activate" class="btn btn-sm btn-danger" onclick="activate(\''.$question['id'].'\', \'1\')">Inactive</a>'; ?></th>
                    
                    <th id="serviceApprove-<?php echo $question['id']; ?>"><?php echo (!$question['is_approved']) ? '<a data-toggle="tooltip" data-placement="top" title="Click here to Approve" class="btn btn-sm btn-danger threeq" onclick="approve(\''.$question['id'].'\', \'1\')">Approve</a>' : '<a data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-success">Approved</a>'; ?></th>
                    
                   <th> <a class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal" title="View" onclick="viewMore(<?php echo $question['id']?>)">View More</a></th>
                    
                    <td><a href='<?php echo base_url('superadmin/post_your_question/'.$question['id'])?>' class="fa fa-edit"></a></td>

                    <td > <a onclick='return confirm("Are you sure?")' href='<?php echo base_url('superadmin/deleteQuestion/'.$question['id'])?>' class="fa fa-trash"></a></td>
                    
                   </tr>

             <?php

				 $i++; }

				 }else{?>

					 <tr ><td colspan="9" style="text-align:center">No records found</td></tr>

				<?php  }

                 ?>

                



	</tbody>

</table>

</div>
<?php if(isset($paginationLinks))echo $paginationLinks; ?>
</div>

                   <div class="modal fade" id="myModalStatus" role="dialog">
					<div class="modal-dialog">
					<form method="post" name="statusForm" action="<?php echo base_url('adminvideos/rejectVideo'); ?>"> 
					  <!-- Modal content-->
					  <div class="modal-content">
						<div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title" id='reasonTitle'>Question Approval</h4>
						</div>
                        <input type="hidden" name="qID"  id="qID" /> 
                        <div class="modal-body">
                        <div class="form-group">Comment Closed At: 
                        <input type="text" id="comment_closed_at" name="comment_closed_at" value="" autocapitalize="off" class="">
                         </div>
                       <div class="form-group">
                                Bidding Closed At: <input type="text" id="bidding_closed_at" name="bidding_closed_at" value="" autocapitalize="off" class="">
                            </div>
                        </div>
                        
						<div class="modal-footer">
                          <button type="button"  class="btn" onclick='confirmApprove()'>Approve</button>
						  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					  </div>
					  <!-- end model content -->
                      </form>
					</div>
				  </div>
                  
                  
                  
                  
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><p style="float: left; font-size: 14px; margin-top: 4px;">close&nbsp;</p><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Ticket Details</h4>

      </div>

      <div class="modal-body">

        ...

      </div>

      <!--<div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>-->

    </div>

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

function confirmApprove()
{
	
	var ID=$('#qID').val();
	var dataString = "ID="+ID+"&comment_closed_at="+$('#comment_closed_at').val()+"&bidding_closed_at="+$('#bidding_closed_at').val();
	$.ajax({
		type: "POST",
		url: '<?php echo base_url('superadmin/questionApprove'); ?>',
		data: dataString,
		success: function (data) {
			if(data)
			{
				var html = '';
				if(status == 1) 
				html = '<a class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top">Approved</a>';
				$("#serviceApprove-"+ID).html(html);$('#myModalStatus').modal('hide');
				window.location=location.href;
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
function viewMore(qid)
{
	var ID=$('#qID').val();
	$("#myModal .modal-body").html(' Loading... ');

  	var dataString = "ID="+qid;

	$.ajax({

		type: "POST",

		url: '<?php echo base_url('superadmin/questionDetails'); ?>',

		data: dataString,

		success: function (data) {

			$("#myModal .modal-body").html(data);

		}

	});

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
<script type="text/javascript">
  $(document).ready(function () {
	$("#from").datepicker({dateFormat: 'yy-mm-dd'}).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#to').datepicker('setStartDate', minDate);
    });

    $("#to").datepicker({dateFormat: 'yy-mm-dd'
    }).on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#from').datepicker('setEndDate', maxDate);
        });
    });
  </script>