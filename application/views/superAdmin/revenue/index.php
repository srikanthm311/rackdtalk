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
 <div class="dashboard-main-heading">
        <h2>Add Category</h2>
    </div>
    <div class="col-md-12 revenue-pading"> 
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
                    </div>
                </div>
            </div>
        </form>
    </div>
    
  <div class="devider">
    <div class="col-md-12"> 
        <div class="row">
            <div class="col-md-4">
                <div class="dashboard-one">
                    <p> Total Revenue On Bid:</p> <h1>1340.00</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-one">
                    <p> Total Revenue On Comments:</p>   <h1> 160.00</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-one">
                    <p>Total Bid Allocation Amount:</p> <h1>207.00</h1>
                </div>
            </div>
  
        </div>   
    </div>
<div class="col-md-12">  
    <div class="row">
        <div class="col-md-4">
            <div class="dashboard-one">
                <p> Total Comment Allocation Amount:</p>    <h1>2223282.00</h1>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-one">
                <p> Revenue through Bid for rockdtalk  : </p>   <h1>1133            </h1></div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-one">
                <p> Revenue through Comments for rockdtalk:</p>   <h1> -2223122</h1>
            </div>
        </div>
    </div>
</div>
</div>
</div>


</div>
