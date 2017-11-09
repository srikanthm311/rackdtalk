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
  <h1>Admin Activities</h1>
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
  
   <p> Total Subscrptions Uploaded: <?php  echo ($adminactivities['subscrptions']['subCount'])?$adminactivities['subscrptions']['subCount']:0;?></p>
   <p> Total Questions Uploaded:    <?php  echo ($adminactivities['questions']['questionCount'])?$adminactivities['questions']['questionCount']:0;?></p>
    <p> Total Users Uploaded: <?php  echo ($adminactivities['users']['usersCount'])?$adminactivities['users']['usersCount']:0;?></p>
   <p> Total Categories Uploaded:    <?php  echo ($adminactivities['categories']['categoryCount'])?$adminactivities['categories']['categoryCount']:0;?></p>
  
  </div>

</div>
</div>
