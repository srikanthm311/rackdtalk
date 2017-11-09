<div class="col-md-10 col-sm-9 main_backup">
</script>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {

    text-align: left;
    padding: 8px;
	margin-top:30px;
}

tr:nth-child(even) {
  
}
.type_of_que {
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    -ms-border-radius: 4px;
    border-radius: 4px;
    width: 100%;
    height: 48px;
    padding-top: 6px;
    padding-right: 19px;
    padding-bottom: 6px;
    padding-left: 19px;
    border: 1px solid #cccccc;
    line-height: 35px;
}
.type_of_que ul li {
    float: left;
    color: #333;
}
ul li {
    list-style: none;
}
.type_of_que ul li:first-child {
    margin: 0;
}
</style>

                    <div class="addmoney add_test">
                        <h2>Post Your Question</h2>
                        <?php if($this->session->flashdata('message')!='') echo  $this->session->flashdata('message');?>
                        
                        <form method="post" enctype="multipart/form-data" name="postqform" id='postqform'>
                        <input type="hidden" name="qid" value="<?php echo $question_detials['id']?>" ID="qid">
                        <input type="hidden" name="user_role" value="<?php echo $question_detials['role_id']?>" ID="user_role">
                            <div class="form-group">
                                <div class="type_of_que">
                                    <ul>
                                        <li>Type:</li>
                                        <li style="margin-left: 50px; margin-top: -8px;">
                                            <div class="radio">
                                              <label> <input type="radio" name="qtype" id="optiontext" value="1" <?php echo ($question_detials['type'] == 1)?'checked':''?> <?php echo (!$question_detials['type'])?'checked':''?> <?php echo ($question_detials['role_id'] == 3)?'disabled':'';?>> Text  </label>
                                            </div>
                                        </li>
                                        <li style="margin-left: 50px; margin-top: -8px;">
                                            <div class="radio">
                                              <label> <input type="radio" name="qtype" id="optionimage" value="2" <?php echo ($question_detials['type'] == 2)?'checked':''?> <?php echo ($question_detials['role_id'] == 3)?'disabled':'';?>> Gif   </label>
                                            </div>
                                        </li>
                                        <li style="margin-left: 50px; margin-top: -8px;">
                                            <div class="radio">
                                              <label> <input type="radio" name="qtype" id="optionvideo" value="3" <?php echo ($question_detials['type'] == 3)?'checked':''?> <?php echo ($question_detials['role_id'] == 3)?'disabled':'';?>>Youtube Video  URL</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <select class="form-control form-shadow" name='segment' id='segment' <?php echo ($question_detials['role_id'] == 3)?'readonly':'';?>>
                                 <option value="">Select Segment</option>
                                <?php foreach($categoryList as $list){ ?>
                                  <option value="<?php echo $list['id']?>" <?php echo ($question_detials['category_id'] == $list['id'])?'selected':''?>><?php echo $list['category_name']?></option>
                                  <?php }?>
                                 </select>
                            </div>
                            
                            <div class="form-group type1" <?php echo ($question_detials['type'] == 2)?'style="display:none"':''?>>
                                <input type="text" class="form-control form-shadow question1" id="question"  name="question"  placeholder="Enter Your Question" value="<?php echo $question_detials['question']?>" <?php echo ($question_detials['role_id'] == 3)?'readonly':'';?>>
                            </div>
                            
                             <div class="form-group type2" <?php echo ($question_detials['type'] != 2)?'style="display:none"':''?>>
                                <input type="file" class="form-control <?php echo (!$question_detials['id'])?'question2':''?> " id="question"  name="question" <?php echo ($question_detials['role_id'] == 3)?'readonly':'';?>>
                            </div>
                           
                          
                            <div class="form-group">
                                <textarea class="form-control form-shadow" rows="3" id="description" placeholder="Description" name="description" <?php echo ($question_detials['role_id'] == 3)?'readonly':'';?>><?php echo $question_detials['description']?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <input type="text" class="form-control form-shadow" id="tags" placeholder="Tags" name="tags" value="<?php echo $question_detials['tags']?>" <?php echo ($question_detials['role_id'] == 3)?'readonly':'';?>>
                            </div>
                            
                        
                            <div class="form-date-main">
                                <div class="row">
                                    <div class="col-md-4">
                                         <div class="form-group form-group-50 form-group-size">
                                            Comment Closed At: <input type="text" class="datepicker" id="comment_closed_at" name="comment_closed_at" value="<?php echo $question_detials['comments_closed_at']?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-50">
                                            Bidding Closed At: <input type="text" class="datepicker1"  id="bidding_closed_at"  name="bidding_closed_at" value="<?php echo $question_detials['bidding_closed_at']?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                   
                           
                                    <div class="form-group" style="float: left; width: 100%; margin: 0;">
                                        <label class="col-md-1 catogery_name">Trending</label>
                                        <div class="col-md-6">
                                            <input style="margin-top: 10px !important;" type="checkbox" class="form-contro" id="is_trending" name="is_trending" value="1" <?php echo ($question_detials['is_trending'])?'checked':''?>/>
                                        </div>
                                    </div>
                         
                
                                <div class="form-group" style="float: left; width: 100%; margin: 0;">
                                    <label class="col-md-1 catogery_name">Closed</label>
                                    <div class="col-md-6">
                                        <input style="margin-top: 10px !important;" type="checkbox" class="form-contro" id="is_closed" name="is_closed" value="1" <?php echo ($question_detials['is_closed'])?'checked':''?>/>
                                    </div>
                                </div>

                        
                           <?php if($question_detials['is_closed'] != 1){ ?><button class="ask-que-btn addmoney-btn add-testmon post-botton-main" type="submit"><?php  echo ($question_detials['id'])?'Update Post':'Post';?></button><?php }
						   else{
							    echo 'This Question is closed  you Can not Update...!';
							   }?>
                        </form>
                        
                        
                       
                    </div>
                    
   <?php if($question_detials['type'] == 2){?>
 <div style="width: 30%;">
 <img src="<?php echo base_url().$question_detials['question']?>" style="width:100%;margin-top: 74px;">
 </div>
 <?php }?>
<div class="table-main-heading">
<?php if($this->session->flashdata('message_bid')!='') echo  $this->session->flashdata('message_bid');?>
    <h3>Highest Bidded Comment</h3>
</div>
<?php if($this->data['question_detials']['bidding_closed_at'] < date('Y-m-d H:i:s')){?>
    <form name="commentPrize_form" action="<?php echo base_url().'adminquestions/announce_prize'?>" method="post">   
    
      <table class="table table-hover table-striped table_hd1 trable-main-div">
    <thead class="table_heading">
		<tr>
			<th> S.No</th>
			<th>Comment</th>

            <th>Comment By</th>
            
            <th>Comment At</th>
            
            <th>Bids</th>
            
            <th>Comment Prize</th>
            <th>Prize Position</th>

            <th width="10%">Delete</th>

		</tr>

	</thead>

	 <tbody>  <?php 
	 
		
	             if(!empty($CommentsList))

				 {


                 ?>
<?php $i=1; foreach($CommentsList as $Comments){ ?>
                    <tr class="">
					<td> <?php echo $i; ?><input type="hidden" value="<?php echo $Comments['qusetion_id'];?> " name='question_id' /></td>
                    
                    <td> <?php echo $Comments['comment']?></td>

                      <td> <?php echo $Comments['first_name']?></td>

                     <td> <?php echo $Comments['created_at']?></td>

                   <?php /*?> <td><a onClick="getCommentDetails('<?php echo $Comment['id'];?>', '<?php echo $Comment['qusetion_id'];?>')" data-toggle="modal" data-target="#myModal" title="View" class="modal-ajax" rel="modal:open">View Bids</a></td><?php */?>
                    <td><?php if($i == 1){?> <a href="javascript:" onclick='getbids(<?php echo $Comments['id']?>,<?php echo $Comments['qusetion_id']?>)'>View Bids</a><?php }?></td>
                    
                    <td><input type="hidden" value="<?php echo $Comments['user_id'];?> " name='commentPrize[<?php echo $Comments['id'];?>][user_id]>' />
                    
                    <input type="text" placeholder=" prize amount" id="commentPrize" class="form-control" name='commentPrize[<?php echo $Comments['id'];?>][amt]' value="<?php echo $comment_winners[$Comments['id']]['winning_amount']?>"></td>
                    <td>
                        <select name="commentPrize[<?php echo $Comments['id'];?>][posiotion]" id="bidding_select_<?php echo $i;?>">
                        <option value='' >Selete Position</option>
                        <?php $i = 1; while($i<=$Comments_count){?>
                        <option value="<?php echo $i;?>" <?php echo ($comment_winners[$Comments['id']]['winning_position'] == $i)?'selected':''?>><?php echo $i;?> position</option>
                        <?php $i++; }?>
                        </select>
                     </td>

                    <td > <a onclick='return confirm("Are you sure?")' href='<?php echo base_url('adminquestions/deleteComment/'.$Comments['id'].'/'.$Comments['qusetion_id'])?>' class="fa fa-trash"></a></td>
                    
                   </tr>
             <?php


$i++;}?> <input class="btn-style-rev" type="submit" class="btn btn-sm btn-success" value="Announce Prize for Comment" /><?php }else{?>

					 <tr ><td colspan="9" style="text-align:center">No records found</td></tr>

				<?php  }

                 ?>

                
		

	</tbody>

	<!-- Table Body -->



</table>  

</form> 
<?php }else{?>

<table class="table table-hover table-striped table_hd1 trable-main-div">
      
      
      

    <thead class="table_heading">

		<tr>
			<th> S.No</th>
			<th>Comment</th>

            <th>Comment By</th>
            
            <th>Comment At</th>
            <th> Flag</th>
            
            <th width="10%">Delete</th>

			

		</tr>

	</thead>

	<!-- Table Header -->



	<!-- Table Body -->

	 <tbody>    <?php 
	 

	             if(!empty($AllCommentsList))

				 {


                 ?>
<?php $i=1; foreach($AllCommentsList as $AllComment){ ?>
                    <tr class="">
					<td> <?php echo $i; ?></td>
                    <td> <?php echo $AllComment['comment']?></td>
                      <td> <?php echo $AllComment['first_name']?></td>
                     <td> <?php echo $AllComment['created_at']?></td>
                     
                      <th id="serviceApprove-<?php echo $AllComment['id']; ?>"><?php echo ($AllComment['is_flag']) ? '<a data-toggle="tooltip" data-placement="top" title="Click here to Approve" class="btn btn-sm btn-danger threeq" onclick="activate_flag(\''.$AllComment['id'].'\')">Flag Active</a>' : '<a data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-success">Flag Inactive</a>'; ?></th>
                      
                      
                    <td > <a onclick='return confirm("Are you sure?")' href='<?php echo base_url('adminquestions/deleteComment/'.$AllComment['id'].'/'.$AllComment['qusetion_id'])?>' class="fa fa-trash"></a></td>
                   </tr>
             <?php
			$i++;}}else{?>
					 <tr ><td colspan="9" style="text-align:center">No records found</td></tr>
				<?php  }
                 ?>
	</tbody>

	<!-- Table Body -->
</table>
<?php }?>
<div class="bidsForComments"></div>
<link rel="stylesheet" href="<?php echo base_url()?>css/admin/bdtp.css" type="text/css"/>

<script src="<?php echo base_url()?>js/bdtp.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
	$("#comment_closed_at").datetimepicker({
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#bidding_closed_at').datetimepicker('setStartDate', minDate);
    });

    $("#bidding_closed_at").datetimepicker()
        .on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#comment_closed_at').datetimepicker('setEndDate', maxDate);
        });
    });
  </script>
  
<script>
$(document).ready(function () {
$('input:radio[name=qtype]').change(function () {
	if($("input[name='qtype']:checked").val() == 1 || $("input[name='qtype']:checked").val() == 3) {
	  $('.type1').show(); $('.type2').hide();
	  
	   if($("input[name='qtype']:checked").val() == 1) {
		   $('#question').attr('placeholder','Enter Your Question');
	   }
	   else
	   $('#question').attr('placeholder','Enter Youtube Video Url');
	}
	else{
		 $('.type2').show(); $('.type1').hide();
	}
});

$('#postqform').submit(function () {
	
	if($('#segment').val()==''){ $('#segment').css("border", "1px solid red");return false;}else $('#segment').css("border", "");
	
	var qtype=$('input[name=qtype]:checked').val();
	if(qtype==1 || qtype==3)
	{
		if($('.question1').val()==''){ $('.question1').css("border", "1px solid red");$('.question2').css("border", "");return false;}else $('.question1').css("border", "");
	}
	else if(qtype==2)
	{
		if($('.question2').val()==''){ $('.question2').css("border", "1px solid red");	$('.question1').css("border", "");	return false} else $('.question2').css("border", "");
	}
	
	if($('#description').val()==''){ $('#description').css("border", "1px solid red");return false;}else $('#description').css("border", "");
	
});	

</script>

<script>
 
  
  function confirmApprove()
{
	
	var ID=$('#qID').val();
	var dataString = "ID="+ID;
	$.ajax({
		type: "POST",
		url: '<?php echo base_url('adminquestions/commentApprove'); ?>',
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

 function activate_flag(cid)
{
	
	var dataString = "ID="+cid;
	$.ajax({
		type: "POST",
		url: '<?php echo base_url('adminquestions/activate_flag'); ?>',
		data: dataString,
		success: function (data) {
			if(data == 1)
			{
				var html = '';
				html = '<a data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-success">Flag Inactive</a>';
				$("#serviceApprove-"+cid).html(html);
			}
		}
	});
}

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
function getbids(ID,qid)

{

	var dataString = "comment_id="+ID+'&question_id='+qid;

	$.ajax({

		type: "POST",

		url: '<?php echo base_url('adminquestions/getbids'); ?>',

		data: dataString,

		success: function (data) {

			if(data)

			{
				$(".bidsForComments").html(data);
   					 $('html,body').animate({
        				scrollTop: $(".bidsForComments").offset().top},
        			'slow');

			}

		}

	});

}


function getCommentDetails(commentID, qID)

{

	$("#myModal .modal-body").html(' Loading... ');

  	var dataString = "ID="+commentID+"&qID="+qID;

	$.ajax({

		type: "POST",

		url: '<?php echo base_url('adminquestions/getCommentDetails'); ?>',

		data: dataString,

		success: function (data) {

			$("#myModal .modal-body").html(data);

		}

	});

}
$(document).ready(function() {
    //copy the second select, so we can easily reset it
	
    var selectClone1 = $('#bidding_select_2').clone();
	var selectClone2 = $('#bidding_select_3').clone();
    $('#bidding_select_1').change(function() {
        var val = parseInt($(this).val());
        //reset the second select on each change
        $('#bidding_select_2').html(selectClone1.html())
        switch(val) {
			//if 1 is selected remove 1
			case 1 : $('#bidding_select_2').find('option:contains(1)').remove();break;
            //if 2 is selected remove C
            case 2 : $('#bidding_select_2').find('option:contains(2)').remove();break;
            //if 3 is selected remove A
            case 3 : $('#bidding_select_2').find('option:contains(3)').remove();break;
        }
		$('#bidding_select_3').html(selectClone2.html())
		switch(val) {
			//if 1 is selected remove 1
			case 1 : $('#bidding_select_3').find('option:contains(1)').remove();break;
            //if 2 is selected remove C
            case 2 : $('#bidding_select_3').find('option:contains(2)').remove();break;
            //if 3 is selected remove A
            case 3 : $('#bidding_select_3').find('option:contains(3)').remove();break;
        }
    });
	
	$('#bidding_select_2').change(function() {
        var val1 = parseInt($('#bidding_select_1').val());
		var val2 = parseInt($(this).val());
        //reset the second select on each change
        $('#bidding_select_3').html(selectClone2.html())
		switch(val1,val2) {
			//if 1 is selected remove 1case ($var1 && !$var2):
			case (1 && 2) : $('#bidding_select_3').find('option:contains(1)').remove();
							$('#bidding_select_3').find('option:contains(2)').remove();break;
            case (1 && 3) : $('#bidding_select_3').find('option:contains(1)').remove();
							$('#bidding_select_3').find('option:contains(3)').remove();break;
			case (2 && 1) : $('#bidding_select_3').find('option:contains(2)').remove();
							$('#bidding_select_3').find('option:contains(1)').remove();break;
            case (2 && 3) : $('#bidding_select_3').find('option:contains(2)').remove();
							$('#bidding_select_3').find('option:contains(3)').remove();break;
			case (3 && 1) : $('#bidding_select_3').find('option:contains(3)').remove();
							$('#bidding_select_3').find('option:contains(1)').remove();break;
            case (3 && 2) : $('#bidding_select_3').find('option:contains(2)').remove();
							$('#bidding_select_3').find('option:contains(3)').remove();break;
        }
		
    });
});
  </script>