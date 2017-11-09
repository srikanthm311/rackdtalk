<script src="<?php echo base_url()?>js/bdtp.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
	$("#from").datepicker({
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#to').datepicker('setStartDate', minDate);
    });

    $("#to").datepicker()
        .on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#from').datepicker('setEndDate', maxDate);
        });
    });
  </script>
<div class="col-md-10 col-sm-9 main_backup">
<div class="memberlogin-wps col-md-12 products_page">
  <h1>User Activities</h1>
    <div class="col-md-12"> 
  <form method="post" action=""/>
   <div class="form-group form-group-50 form-group-size">
                                From Date: <input type="text" class="datepicker" id="from" name="from" value="<?php echo $post['from']?>">
                            </div> 
  <div class="form-group form-group-50">
                                To Date : <input type="text" class="datepicker1"  id="to"  name="to" value="<?php echo $post['to']?>">
   </div>
   <div class="form-group form-group-50">
                               <input type="submit"   id="submit"  name="submit" value="submit">
   </div>
  </form></div>
  
  <div class="col-md-12"> 
  
   <p> Total Biddded Amount:<?php  echo ($useractivities['totalBiddedAmount']['amount'])?$useractivities['totalBiddedAmount']['amount']:0;?></p>
   <p> Total Amount On Comments:<?php  echo ($useractivities['totalCommentedAmount']['amount'])?$useractivities['totalCommentedAmount']['amount']:0;?></p>
  
  </div>
  <h3>Bidding Activities</h3>
 <table class="table table-hover table-striped table_hd1">
    <thead class="table_heading">
		<tr>
			<th>S.No</th>
			<th>Comment</th>
            <th>Question</th>
             <th>Bidded Amount</th>
            <th>Date</th>
		</tr>
	</thead>
	 <tbody>    <?php $i=1;
	             if(!empty($useractivities['bidActivity']))
				 {
                 foreach($useractivities['bidActivity'] as $bidActivity)
				 {
                 ?>
                    <tr class="<?php echo ($i%2==0)?'even':'' ?>">
					<td> <?php echo ++$t; ?></td>
                    <td> <?php echo $bidActivity['comment']?></td>
                    <td> <?php echo $bidActivity['question']?></td>
                    <td> <?php echo $bidActivity['amount']?></td>
                    <td> <?php echo $bidActivity['created_at']?></td>
                   </tr>
             <?php
				 $i++; }
				 }else{?>
					 <tr ><td colspan="9" style="text-align:center">No records found</td></tr>
				<?php  }
                 ?>
	</tbody>
</table>

<h3>Comment Activities</h3>

<table class="table table-hover table-striped table_hd1">
    <thead class="table_heading">
		<tr>
			<th> S.No</th>
            <th>Comment</th>
            <th>Question</th>
			<th>Date</th>
		</tr>
	</thead>
	 <tbody>    <?php $i=1;
	             if(!empty($useractivities['commentActivity']))
				 {
                 foreach($useractivities['commentActivity'] as $commentActivity)
				 {
                 ?>
                    <tr class="<?php echo ($i%2==0)?'even':'' ?>">
					<td> <?php echo ++$c; ?></td>
                     <td> <?php echo $commentActivity['comment']?></td>
                     <td> <?php echo $commentActivity['question']?></td>
                    <td> <?php echo $commentActivity['created_at']?></td>
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
</div>
