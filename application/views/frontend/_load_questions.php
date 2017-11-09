
<script type="text/javascript">
$(function(){
	$('.future_date').each(function(){
		var id=$(this).attr('id'); var closed=$(this).attr('rel');
		$("#"+id).countdowntimer({
					  startDate : "<?php echo date('Y/m/d H:i:s'); ?>" ,
                      dateAndTime : closed ,
					  size : "xs",
		});
	});
});

//Function displays the Feed Dialog
function LaunchFeedDialog() {
	FB.ui(
   {
     method: 'feed',
     name: 'Facebook Dialogs',
     link: 'http://fbrell.com/',
     picture: 'http://fbrell.com/f8.jpg',
     caption: 'Reference Documentation',
     description: 'Dialogs provide a simple, consistent interface for applications to interface with users.',
     message: 'Facebook Dialogs are easy!'
   },
   function(response) {
     if (response && response.post_id) {
       alert('Post was published.');
     } else {
       alert('Post was not published.');
     }
   }
 );
} 
		
</script>

<?php $allowedtComment=0;
    $talkerBalance=$wallet['talker_credit_amount']-$wallet['talker_debit_amount'];
    if($talkerBalance>= $settings['perCommentDeduction'])
	{    
		 $allowedtComment=1; 
	}
	
?>  

						  <?php if(!empty($questionsList)){               
			                  foreach($questionsList as $key=>$question)
			                  {  $allowedComment=0; 
							    if(strtotime($question['comments_closed_at'])>=strtotime("now") && ($allowedtComment))  $allowedComment=1; 
							 
							 ?>
                               <div class="trending-left-inner">
                                <div class="col-md-2 col-xs-12">
                                    <div class="trending-right-inner">
                                        <div class="headques">
                                            <div class="headques-in">
                                               <?php if($question['user_pic']=='') { ?>
                                                <img src="<?php echo base_url()?>css/img/avatar.jpg">
                                                 <?php } else{  ?>
                                                 <img src="<?php echo base_url()?><?php echo $question['user_pic']?>">
                                                 <?php }  ?>
                                            </div>
                                        </div>
                                        
                                        <div class="bar">
                                               <ul> 
											    <?php if($question['question_comment_count']>20) { ?>  <li><div class="green-bar"></div></li>  <?php }  ?>
                                                <?php if($question['question_comment_count']>10) { ?>  <li><div class="yellow-bar"></div></li><?php }  ?>                                                <?php if($question['question_comment_count']>0)   { ?>  <li><div class="red-bar"></div></li><?php }  ?>
                                            </ul>
                                            
                                           <p class="corpus_fund"><?php echo $this->lang->line('corpus_fund'); ?></p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-10 col-xs-12">
                                    <div class="tre-ques">
                                        
                                        
                                        
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>
										<?php //$bidding_closed_at=round((strtotime($question['bidding_closed_at']) - strtotime(date("d-m-Y H:i:s")))/(60*60));?>
										<?php 
									  switch($question['type'])
									  {
									   case 1 : echo $question['question'];break;
									   case 2 : echo '<img src='.base_url().$question['question'].' />';break;
									   case 3 : echo '<iframe width="360" height="215" src="'.$question['question'].'?modestbranding=1&showinfo=0" frameborder="0" allowfullscreen></iframe>';break;
									   default: echo $question['question'];break;
									  }?></h4>
                                            </div>
                                            <div class="col-md-6">
                                                <ul>
                                            <li><?php echo $this->lang->line('started_at'); ?>: <span> <?php echo time_ago(strtotime($question['approved_at']))?></span></li>
                                            <li><?php echo $this->lang->line('closes_in'); ?>: <span id="countdowntimer"><span class="future_date" id='future_date<?php echo $key?>' rel="<?php echo date('Y/m/d H:i:s',strtotime($question['bidding_closed_at']))?>"></span></span></li>
                                        </ul>
                                            </div>
                                        </div>
                                        
                                        <p><?php echo $question['description']?> </p>
                                        <div class="devider"></div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                 <p><i class="fa fa-comment-o" aria-hidden="true"></i>&nbsp;
                                                 <a style="cursor:pointer" class='commentlink' onclick='openPanel("trendpanel-<?php echo $question['id']?>","tqc")'><?php echo ($question['question_comment_count'])?$question['question_comment_count']:0?> <?php echo $this->lang->line('comments'); ?></a>
                                                 </p>
                                            </div>
                                            
                                            <?php /*?><div class="col-md-2">
                                                 <p><?php echo ($question['question_like_count'])?$question['question_like_count']:0?>  Likes</p>
                                            </div><?php */?>
                                            
                                        </div>
                                        
                                    </div>
                                     <?php if($this->router->fetch_method()=='top_bidding'){     ?>
                                    <div class="bid-amountbut">
                                        <span><?php echo $this->lang->line('bid_amount'); ?></span>
                                        <h2><?php echo $question['bidamountTotal']?>$</h2>
                                    </div>
                                     <?php } ?>
                                      <div id="trendpanel-<?php echo $question['id']?>" class="cpanel">
                                      <div class='newcommentSystem-tqc-<?php echo $question['id']?>'></div>
                                      </div>
                                      <?php //if($pageKey!='my' && $pageKey!='myc'){     ?>
                                      <div class='laxcomment commentSystem-tqc-<?php echo $question['id']?>'>
                                      <div class="form-group"> <input type="text" class="tqc-<?php echo $question['id']?> form-control" <?php if($this->session->userdata['USER_ID']==''){?> data-toggle="modal" data-target=".bs-example-modal-lg" <?php }else if(!$allowedtComment) { ?>onfocus="showpopup('<?php echo $question['id']?>','tqc');" <?php } else if(!$allowedComment){ echo 'readonly="readonly"';}else{} ?> placeholder='Write a comment (Max 300 Characters )' maxlength="300" /><input type="submit" value='<?php echo $this->lang->line('post'); ?>' class="commentButton" rel='<?php echo $question['id']?>' data-type='tqc'  /></div>
                                       </div>
                                     <?php //} ?>
                                     </div>
                                </div>
                           <?php }} ?>
						   
                           
  <script>
  $(function(){
	$(".commentlink").each(function() { 
	 $(this).trigger('click');
	}); 
}); 
  </script>                         
                           