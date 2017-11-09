<div class="col-md-10 col-sm-9 main_backup">


<div class="memberlogin-wps col-md-12 products_page">
	<div class="col-md-12"> 
        
  <form method="post" action=""/>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group form-group-50 form-group-size">
                From Date: <input type="text" class="datepicker" id="from" name="from" value="<?php echo ($post['from'])?$post['from']:'';?>">
                </div> 
            </div>
            <div class="col-md-3">
                <div class="form-group form-group-50">
                To Date : <input type="text" class="datepicker1"  id="to"  name="to" value="<?php echo ($post['to'])?$post['to']:'';?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group form-group-50">
                    <input class="btn-style-rev" type="submit"   id="submit"  name="submit" value="submit" class="btn btn-success">
                </div>
            </div>
        </div>
            <input type="hidden" name="identity" value="1">
  </form>
    </div>
  <div class="dashboard-main-block">
      <div class="dashboard-main-hdng"> <h2>Questions List</h2></div>
      <div class="dashboard-main-btn"><a class="category_add" href="<?php echo base_url('superadmin/post_your_question')?>">Post Question</a></div>
    </div>

  <div class="col-md-12"> </div>

  

 <table class="table table-hover table-striped table_hd1">

    <thead class="table_heading">

		<tr>
			<th> S.No</th>
			<th>withdrawl Amount</th>
            <th>User</th>
            <th>Requested at</th>
            <th>status</th>
            <th>Approve</th>
		</tr>

	</thead>
	<!-- Table Header -->
	<!-- Table Body -->
	 <tbody>    <?php $i=1;
	             if(!empty($withdrawData))
				 {
                 foreach($withdrawData as $withdraw)
				 {
                 ?>
                    <tr class="<?php echo ($i%2==0)?'even':'' ?>">
					<td> <?php echo ++$t; ?></td>
                      <td> <?php echo $withdraw['amount']?></td>
                     <td> <?php echo $withdraw['useremail']?></td>
                    <td> <?php echo $withdraw['created_at']?></td>
                    <td> <?php echo $withdraw['status']?></td>
                    <th id="serviceApprove-<?php echo $withdraw['id']; ?>"><?php echo ($withdraw['status'] == 'PENDING') ? '<a data-toggle="tooltip" data-placement="top" title="Click here to Approve" class="btn btn-sm btn-danger threeq" onclick="approve_withdraw(\''.$withdraw['id'].'\')">Approve</a>' : '<a data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-success">Approved</a>'; ?></th>
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

<script type="text/javascript">
 function approve_withdraw(wid)
{
	
	var dataString = "ID="+wid;
	$.ajax({
		type: "POST",
		url: '<?php echo base_url('superadminwithdraw/approve_withdraw'); ?>',
		data: dataString,
		success: function (data) {
			if(data == 1)
			{
				var html = '';
				html = '<a data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-success">Approved</a>';
				$("#serviceApprove-"+wid).html(html);
			}
		}
	});
}

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