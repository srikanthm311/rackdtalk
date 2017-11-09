<link rel="stylesheet" href="https://goodies.pixabay.com/jquery/auto-complete/jquery.auto-complete.css"> 
<script type="text/javascript">

$(document).ready(function(){
$('#question').autocomplete({
    serviceUrl: '<?php echo base_url()?>main/getQlist',
    onSelect: function (suggestion) {
        alert('The Question "' + suggestion.value +'" is already exists');
		$('#question').val('');return false;
    }
});
});
</script>
<script type="text/javascript" src="http://www.firstseat.in/js/jquery.autocomplete.js"></script>
<div class="full-width-con addmoneywallet">
            <div class="container">
                <div class="row">
                    <div class="addmoney add_test">
                        <h2>Post Your Question</h2>
                       
                        
                        <form method="post" enctype="multipart/form-data" name="postqform" id='postqform'>
                            <div class="form-group">
                                <div class="type_of_que">
                                    <ul>
                                        <li>Type:</li>
                                        <li>
                                            <div class="radio">
                                              <label> <input type="radio" name="qtype" id="optiontext" value="1" checked> Text  </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="radio">
                                              <label> <input type="radio" name="qtype" id="optionimage" value="2" > Gif   </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="radio">
                                              <label> <input type="radio" name="qtype" id="optionvideo" value="3" >Youtube Video  URL</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <select class="form-control" name='segment' id='segment'>
                                 <option value="">Select Segment</option>
                                <?php foreach($categoryList as $list){ ?>
                                  <option value="<?php echo $list['id']?>" <?php echo ($list['id']==$_SESSION['selectSegment'])?'selected':'';?> ><?php echo $list['category_name']?></option>
                                  <?php }?>
                                 </select>
                            </div>
                            
                            <div class="form-group type1">
                                <input type="text" class="form-control question1" id="question"  name="question"  placeholder="Enter Your Question">
                            </div>
                            
                             <div class="form-group type2" style="display:none">
                                <input type="file" class="form-control question2" id="question"  name="question">
                            </div>
                           
                            <div class="form-group">
                                <textarea class="form-control" rows="3" id="description" placeholder="Description" name="description"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <input type="text" class="form-control" id="tags" placeholder="Tags" name="tags">
                            </div>
                            <button class="ask-que-btn addmoney-btn add-testmon" type="submit">Post</button>
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>
        
        
    
        
        <div class="winners-main">
            <img src="<?=base_url('');?>css/img/testmon.jpg">
        </div>
        
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

});
</script>