<!-- Magnific Popup core CSS file -->
<link rel="stylesheet" href="http://bagitbig.com/conduit/css/magnific-popup.css">
<!-- Magnific Popup core JS file -->
<script src="http://dimsemenov.com/plugins/magnific-popup/dist/jquery.magnific-popup.min.js?v=1.1.0"></script>
<script type="text/javascript" src="http://harshen.github.io/jquery-countdownTimer/jquery.countdownTimer.min.js"></script>
<script type="text/javascript">
$(function(){
	$('.future_date').each(function(){
		var id=$(this).attr('id'); var closed=$(this).attr('rel');
		$("#"+id).countdowntimer({
					hours : closed,
					size : "xs",
		});
	});
});
</script>

<style type="text/css">
.style {
   width: 100%;
   font-family: sans-serif;
  
}

.colorDefinition {
    color : #FFFFFF;
}
.size_xs {
   font-size:13px;
}
.cpanel{
	display:none;
}
</style>

        <div class="tredning-header">
            <div class="container">
            <div class="row row-break">
                    <div class="col-md-6">
                        <h4 class="text-left">Trending Questions</h4>
                    </div>
                    <div class="col-md-6">
                        <ul class="filter">
                            <li>Filter by</li>
                            <li>
                                <select class="form-control">
                                  <option>Marketing</option>
                                  <option>2</option>
                                  <option>3</option>
                                  <option>4</option>
                                  <option>5</option>
                                </select>
                            </li>
                            <li><a href="#">All</a></li>
                        </ul>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="trending">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 trending-left-main">
                        <div class="trending-left">
                            <div class="trending-left-inner">
                                <ul>
                                    <li><button class="active" type="button">Approved</button></li>
                                </ul>
                                <p>Trending Questions (<?php echo (count($questionsList)>0)?count($questionsList):0; ?>)</p>
                            </div>
                             <?php if(!empty($questionsList)){               
			                  foreach($questionsList as $key=>$question)
			                 { ?>
                               <div class="trending-left-inner">
                                <div class="col-md-2">
                                    <div class="trending-right-inner">
                                        <div class="headques">
                                            <div class="headques-in">
                                            <?php if($question['user_pic']=='') { ?>
                                                <img src="<?php echo base_url()?>css/img/avatar.jpg">
                                                 <?php } else{  ?>
                                                    <img src="<?php echo base_url()?>css/img/avatar.jpg">
                                                 <?php }  ?>
                                            </div>
                                        </div>
                                        <div class="bar">
                                            <ul> <?php if($question['question_like_count']>20) { ?>  <li><div class="green-bar"></div></li>  <?php }  ?>
                                                 <?php if($question['question_like_count']>10) { ?>  <li><div class="yellow-bar"></div></li><?php }  ?>                                                <?php if($question['question_like_count']>0)   { ?>  <li><div class="red-bar"></div></li><?php }  ?>
                                                
                                            </ul>
                                        </div>
                                        <p>Corpus Fund</p>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="tre-ques">
                                        <h4>
                                      <?php 
									  switch($question['type'])
									  {
									   case 1 : echo $question['question'];break;
									   case 2 : echo '<img src='.$question['question'].' />';break;
									   case 3 : echo '<iframe width="360" height="215" src="'.$question['question'].'?modestbranding=1&showinfo=0" frameborder="0" allowfullscreen></iframe>';break;
									   default: echo $question['question'];break;
									  }?>
                                        </h4>
                                        
										<?php $bidding_closed_at=round((strtotime($question['bidding_closed_at']) - strtotime(date("d-m-Y H:i:s")))/(60*60));?>
                                        <ul>
                                            <li>Start: <span> <?php echo time_ago(strtotime($question['approved_at']))?></span></li>
                                            <li>Closed In: <span id="countdowntimer">
                                            <span class="future_date" id='future_date<?php echo $key?>' rel="<?php echo $bidding_closed_at?>"></span></span></li>
                                        </ul>
                                        <p><?php echo $question['description']?> </p>
                                        <div class="devider"></div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <ul class="share">
                                                    <li><i class="fa fa-share-alt" aria-hidden="true"></i> share</li>
                                                    <li>
                                                    <a onclick="LaunchFeedDialog('<?php echo urlencode($question['description'])?>')"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                                     <li> <a href='https://twitter.com/intent/tweet/?text=<?php echo urlencode($question['description'])?>&url=<?php echo base_url()?>&via=rockdtalk'><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                                    <li><i class="fa fa-google-plus" aria-hidden="true"></i></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="commetns">
                                                    <p> <?php echo ($question['question_share_count'])?$question['question_share_count']:0?>  shares</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                 <p>
                                                 <a <?php if($this->session->userdata['USER_ID']==''){?> data-toggle="modal" data-target=".bs-example-modal-lg" <?php }else{?> class="flip" <?php }?>  id='makecomment-<?php echo $question['id']?>'><?php echo ($question['question_comment_count'])?$question['question_comment_count']:0?> Comments</a>
                                                 </p>
                                            </div>
                                              <a class="simple-ajax-popup-<?php echo $question['id']?>"  href="<?php echo base_url()?>comment-form/<?php echo $question['id']?>" id='tc-<?php echo $question['id']?>'></a>
                                             <div class="col-md-2">
                                                 <p><?php echo ($question['question_like_count'])?$question['question_like_count']:0?>  Likes</p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                      <div id="panel-<?php echo $question['id']?>" class="cpanel">
                                      <div class="form-group"><input type="text" class="form-control" onfocus="showpopup('<?php echo $question['id']?>');"></div> </div>
                                     </div>
                              
                            </div>
                           <?php }} ?>
            
                        </div>
                    </div>
                    <div class="col-md-3 trending-right-main">
                        <div class="trending-left trending-right">
                            <div class="trending-left-inner sidebar">
                             <?php if($this->session->userdata['USER_ID']==''){ ?>
                               <button class="ask-que-btn" type="button" data-toggle="modal" data-target=".bs-example-modal-lg">Ask a Question</button>
                             <?php } else{ ?>  
                               <button class="ask-que-btn" type="button" onclick="location.href = '<?php echo base_url()?>post-your-question.html';" >Ask a Question</button>
                              <?php }  ?>  
                                <div class="row">
                                    <div class="col-md-6 no-ques">
                                            <span>Questions</span>
                                            <h2><?php echo (count($questionsList)>0)?count($questionsList):0; ?></h2>
                                    </div>
                                    <div class="col-md-6 no-ques members-ques">
                                            <span>Members</span>
                                            <h2>30</h2>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="trending-left-inner sidebar">
                                <div class="segment">
                                    <h4>Segments</h4>
                                    <ul>
                                        <li><a href="#">Politicsn / Burning</a><span>22</span></li>
                                        <li><a href="#">Sports</a><span>22</span></li>
                                        <li><a class="darkseng" href="#">Entertinment</a><span>22</span></li>
                                    </ul>
                                </div>
                            </div>
                            
                            
                            <div class="trending-left-inner sidebar">
                                <div class="segment">
                                    <h4>Users with Best Answers</h4>
                                    <div class="row wiiner-list">
                                        <div class="col-md-8">
                                            <div class="row wiiner-listname">
                                                <div class="col-md-4">
                                                    <img src="<?php echo base_url()?>css/img/winner1.jpg">
                                                </div>
                                                <div class="col-md-8">
                                                    <p>Laxman</p>
                                                    <span>Since 2014</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="typeofwin">
                                                <span><img src="<?php echo base_url()?>css/img/gold.jpg"></span>&nbsp;<span>2,175</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row wiiner-list">
                                        <div class="col-md-8">
                                            <div class="row wiiner-listname">
                                                <div class="col-md-4">
                                                    <img src="<?php echo base_url()?>css/img/winner2.jpg">
                                                </div>
                                                <div class="col-md-8">
                                                    <p>Satish</p>
                                                    <span>Since 2014</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="typeofwin">
                                                <span><img src="<?php echo base_url()?>css/img/silver.jpg"></span>&nbsp;<span>2,175</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row wiiner-list noborder">
                                        <div class="col-md-8">
                                            <div class="row wiiner-listname">
                                                <div class="col-md-4">
                                                    <img src="<?php echo base_url()?>css/img/winner3.jpg">
                                                </div>
                                                <div class="col-md-8">
                                                    <p>Ramu</p>
                                                    <span>Since 2014</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="typeofwin">
                                                <span><img src="<?php echo base_url()?>css/img/silver.jpg"></span>&nbsp;<span>2,175</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="trending-left-inner sidebar">
                                
                                <div class="segment latest-news">
                                    <h4>Latest-news</h4>
                                    
                                    <div class="row wiiner-list">
                                        <div class="col-md-4">
                                            <img src="<?php echo base_url()?>css/img/latest1.jpg">
                                        </div>
                                        <div class="col-md-8">
                                            <p>Entertinment</p>
                                            <span>Katamarayudu New</span>
                                        </div>
                                    </div>
                                    
                                    <div class="row wiiner-list">
                                        <div class="col-md-4">
                                            <img src="<?php echo base_url()?>css/img/latest2.jpg">
                                        </div>
                                        <div class="col-md-8">
                                            <p>Food</p>
                                            <span>Katamarayudu New</span>
                                        </div>
                                    </div>
                                    
                                    <div class="row wiiner-list">
                                        <div class="col-md-4">
                                            <img src="<?php echo base_url()?>css/img/latest3.jpg">
                                        </div>
                                        <div class="col-md-8">
                                            <p>Sports</p>
                                            <span>Katamarayudu New</span>
                                        </div>
                                    </div>
                                    
                                    <div class="row wiiner-list">
                                        <div class="col-md-4">
                                            <img src="<?php echo base_url()?>css/img/latest4.jpg">
                                        </div>
                                        <div class="col-md-8">
                                            <p>Entertinment</p>
                                            <span>Katamarayudu New</span>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>          
            </div>
        </div>
        
 <?php /*?> <?php }else if($question['question_comment_count']){?>  class="simple-ajax-popup"  href="<?php echo base_url()?>comment-form/<?php echo $question['id']?>"<?php */?>
        
        
        
        <div class="winners-main">
            <img src="<?php echo base_url()?>css/img/testmon.jpg">
        </div>
 
<script type="text/javascript">
$(function(){
	
     $(".flip").click(function(){
	    var id=$(this).attr('id').split('-');
        $("#panel-"+id[1]).toggle();
    });	
		
});
function showpopup(id)
{
	$('.simple-ajax-popup-'+id).magnificPopup({
	  type: 'ajax'
	});
	
    $('#tc-'+id).trigger('click');	
}

</script>