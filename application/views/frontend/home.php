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

/*.cpanel{
	display:none;
}*/
</style>  
  <?php $talkerBalance=$wallet['talker_credit_amount']-$wallet['talker_debit_amount'];
    if($talkerBalance>= $settings['perCommentDeduction']) $allowedComment=1; else $allowedComment=0;
?>     
        <div class="full-width-con main-banner">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        
                        <div class="home-cover">
                            <h2><?php echo $this->lang->line('welcome_message'); ?></h2>
                            
                            <ul>
                                <li>
                                    <button type="button"><?php echo $this->lang->line('post_your_questions'); ?></button>
                                    
                                </li>
                                <li>
                                    <button type="button"><?php echo $this->lang->line('comment_on_question'); ?></button>
                                    
                                </li>
                                <li>
                                    <button type="button"><?php echo $this->lang->line('bid_on_question'); ?></button>
                                    
                                </li>
                                <li class="win-last">
                                    <button class="win" type="button"><?php echo $this->lang->line('win'); ?></button>
                                </li>
                            </ul>
                            
                        </div>
                        
                        
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="devider"></div><div class="devider"></div>
          <?php if(!empty($questionsList['trending'])){ ?>
        <div class="trending_que_home">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p><?php echo $this->lang->line('trending_questions'); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
          <?php   foreach($questionsList['trending'] as $key=>$question)  { ?>
        
                  <div class="trending trending-main-home">
            <div class="container ">
                <div class="row">
                    <div class="col-md-12 trending-left-main">
                        <div class="trending-left">
                            <div class="trending-left-inner">
                                <div class="col-md-2 col-sm-12 col-xs-12">
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
											    <?php if($question['question_comment_count']>20) { ?>  <li><div class="green-bar bar_landing_page"></div></li>  <?php }  ?>
                                                <?php if($question['question_comment_count']>10) { ?>  <li><div class="yellow-bar bar_landing_page"></div></li><?php }  ?>                                                <?php if($question['question_comment_count']>0)   { ?>  <li><div class="red-bar bar_landing_page"></div></li><?php }  ?>
                                            </ul>
                                            <p class="corpus_fund"><?php echo $this->lang->line('corpus_fund'); ?></p>
                                           
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <div class="tre-ques">
                                        
                                        
                                        
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-12">
                                                <h4>
										<?php $bidding_closed_at=round((strtotime($question['bidding_closed_at']) - strtotime(date("d-m-Y H:i:s")))/(60*60));?>
										<?php 
									  switch($question['type'])
									  {
									   case 1 : echo $question['question'];break;
									   case 2 : echo '<img src='.base_url().$question['question'].' />';break;
									   case 3 : echo '<iframe width="360" height="215" src="'.$question['question'].'?modestbranding=1&showinfo=0" frameborder="0" allowfullscreen></iframe>';break;
									   default: echo $question['question'];break;
									  }?></h4>
                                            </div>
                                            <div class="col-md-7 col-sm-7 col-xs-12">
                                                <ul>
                                            <li><?php echo $this->lang->line('started_at'); ?>: <span> <?php echo time_ago(strtotime($question['approved_at']))?></span></li>
                                            <li><?php echo $this->lang->line('closes_in'); ?>: <span id="countdowntimer"><span class="future_date" id='future_date<?php echo $key?>' rel="<?php echo $bidding_closed_at?>"></span></span></li>
                                        </ul>
                                            </div>
                                        </div>
                                        
                                        
                                      <p><?php echo $question['description']?> </p>
                                      <div class="devider"></div>
                                      <div class="row"> 
                                       <div class="col-md-3">
                                                 <p><i class="fa fa-comment-o" aria-hidden="true"></i>&nbsp;
                                                 <a style="cursor:pointer"  class='commentlink' onclick='openPanel("trendpanel-<?php echo $question['id']?>","tqc")'><?php echo ($question['question_comment_count'])?$question['question_comment_count']:0?> <?php echo $this->lang->line('comments'); ?></a>
                                                 </p>
                                       </div>
                                       </div>
                                        
                                    </div>
                                    
                                      <div id="trendpanel-<?php echo $question['id']?>" class="cpanel">
                                       <div class='newcommentSystem-tqc-<?php echo $question['id']?>'></div>
                                      </div>
                                      <div class='laxcomment commentSystem-tqc-<?php echo $question['id']?>'>
                                      <div class="form-group"> <input type="text" class="tqc-<?php echo $question['id']?> form-control" <?php if($this->session->userdata['USER_ID']==''){?> data-toggle="modal" data-target=".bs-example-modal-lg" <?php }else if(!$allowedComment) { ?>onfocus="showpopup('<?php echo $question['id']?>','tqc');" <?php } else{}  ?> placeholder='Write a comment (Max 300 Characters )' maxlength="300"/><input type="submit" value='<?php echo $this->lang->line('post'); ?>' class="commentButton" rel='<?php echo $question['id']?>' data-type='tqc' /></div>
                                       </div>
                                     
                                     </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>          
            </div>
      
          <?php }   ?>
        
        <div class="devider"></div>
        
        <div class="trending_que_home trending_que_homeone">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="ask-que-btn home-view-all"  onclick="location.href = '<?php echo base_url()?>trending-questions.html';" ><?php echo $this->lang->line('view_all'); ?></button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="devider"></div>
        <div class="devider"></div>
        <div class="devider"></div>
        
        <?php }   ?>
        
        
        
        
        <div class="trending_que_home">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p><?php echo $this->lang->line('latest_questions'); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        
         <?php if(!empty($questionsList['latest'])){                   
			   foreach($questionsList['latest'] as $key=>$question)  { ?>
               <div class="trending trending-main-home">
            <div class="container ">
                <div class="row">
                    <div class="col-md-12 trending-left-main">
                        <div class="trending-left">
                            
                            
                            <div class="trending-left-inner">
                                <div class="col-md-2 col-sm-12 col-xs-12">
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
                                               <ul> 
											   <?php if($question['question_comment_count']>20) { ?>  <li><div class="green-bar"></div></li>  <?php }  ?>
                                                 <?php if($question['question_comment_count']>10) { ?>  <li><div class="yellow-bar"></div></li><?php }  ?>                                                <?php if($question['question_comment_count']>0)   { ?>  <li><div class="red-bar"></div></li><?php }  ?>
                                            </ul>
                                            <p class="corpus_fund"><?php echo $this->lang->line('corpus_fund'); ?></p>
                                           
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <div class="tre-ques">
                                        
                                        <div class="row">
                                            <div class="col-md-7">
                                                <h4>
											<?php $bidding_closed_at=round((strtotime($question['bidding_closed_at']) - strtotime(date("d-m-Y H:i:s")))/(60*60));?>
										<?php 
									  switch($question['type'])
									  {
									   case 1 : echo $question['question'];break;
									   case 2 : echo '<img src='.base_url().$question['question'].' />';break;
									   case 3 : echo '<iframe width="360" height="215" src="'.$question['question'].'?modestbranding=1&showinfo=0" frameborder="0" allowfullscreen></iframe>';break;
									   default: echo $question['question'];break;
									  }?></h4>
                                            </div>
                                            <div class="col-md-5">
                                                <ul>
                                            <li><?php echo $this->lang->line('started_at'); ?>: <span> <?php echo time_ago(strtotime($question['approved_at']))?></span></li>
                                            <li><?php echo $this->lang->line('closes_in'); ?>: <span id="countdowntimer">
                                            <span class="future_date" id='lfuture_date<?php echo $key?>' rel="<?php echo $bidding_closed_at?>"></span></span></li>
                                        </ul>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <p><?php echo $question['description']?> </p>
                                        <div class="devider"></div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                 <p><i class="fa fa-comment-o" aria-hidden="true"></i>&nbsp;
                                                 <a    onclick='openPanel("latestpanel-<?php echo $question['id']?>","lqc")' class='commentlink'><?php echo ($question['question_comment_count'])?$question['question_comment_count']:0?> <?php echo $this->lang->line('comments'); ?></a>
                                                 </p>
                                            </div>
                                              
                                        </div>
                                        
                                    </div>
                                      <div id="latestpanel-<?php echo $question['id']?>" class="cpanel">
                                       <div class='newcommentSystem-lqc-<?php echo $question['id']?>'></div>
                                      </div>
                                       <div class='laxcomment commentSystem-lqc-<?php echo $question['id']?>'>
                                      <div class="form-group"> <input type="text" class="lqc-<?php echo $question['id']?> form-control" <?php if($this->session->userdata['USER_ID']==''){?> data-toggle="modal" data-target=".bs-example-modal-lg" <?php }else if(!$allowedComment) { ?>onfocus="showpopup('<?php echo $question['id']?>','lqc');" <?php } else{}  ?> placeholder='Write a comment (Max 300 Characters )' maxlength="300" /><input type="submit" value='<?php echo $this->lang->line('post'); ?>' class="commentButton" rel='<?php echo $question['id']?>' data-type='lqc' /></div> </div>
                                    
                                     </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>          
            </div>
        <?php }  ?>
        
        
        <div class="devider"></div>
        <div class="trending_que_home trending_que_homeone">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="ask-que-btn home-view-all" onclick="location.href = '<?php echo base_url()?>latest-questions.html';" ><?php echo $this->lang->line('view_all'); ?></button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="devider"></div>
        <div class="devider"></div>
        <div class="devider"></div>
        
           <?php } ?>
        
        <div class="trending_que_home">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p><?php echo $this->lang->line('top_bidded_questions'); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
         <?php if(!empty($questionsList['topbidding'])){                   
			   foreach($questionsList['topbidding'] as $key=>$question)  { ?>
        
        <div class="trending trending-main-home">
            <div class="container ">
                <div class="row">
                    <div class="col-md-12 trending-left-main">
                        <div class="trending-left">
                            
                            
                            <div class="trending-left-inner">
                                <div class="col-md-2 col-sm-12 col-xs-12">
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
                                               <ul> 
											   <?php if($question['question_comment_count']>20) { ?>  <li><div class="green-bar"></div></li>  <?php }  ?>
                                                 <?php if($question['question_comment_count']>10) { ?>  <li><div class="yellow-bar"></div></li><?php }  ?>                                                <?php if($question['question_comment_count']>0)   { ?>  <li><div class="red-bar"></div></li><?php }  ?>
                                            </ul>
                                            
                                           <p class="corpus_fund"><?php echo $this->lang->line('corpus_fund'); ?></p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <div class="tre-ques">
                                        
                                        
                                        
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-12">
                                                <h4>
											<?php $bidding_closed_at=round((strtotime($question['bidding_closed_at']) - strtotime(date("d-m-Y H:i:s")))/(60*60));?>
										<?php 
									  switch($question['type'])
									  {
									   case 1 : echo $question['question'];break;
									   case 2 : echo '<img src='.base_url().$question['question'].' />';break;
									   case 3 : echo '<iframe width="360" height="215" src="'.$question['question'].'?modestbranding=1&showinfo=0" frameborder="0" allowfullscreen></iframe>';break;
									   default: echo $question['question'];break;
									  }?></h4>
                                            </div>
                                            <div class="col-md-5">
                                                <ul>
                                            <li><?php echo $this->lang->line('started_at'); ?>: <span> <?php echo time_ago(strtotime($question['approved_at']))?></span></li>
                                            <li><?php echo $this->lang->line('closes_in'); ?>: <span id="countdowntimer">
                                            <span class="future_date" id='tbfuture_date<?php echo $key?>' rel="<?php echo $bidding_closed_at?>"></span></span></li>
                                        </ul>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        <p><?php echo $question['description']?> </p>
                                        <div class="devider"></div>
                                        <div class="row">
                                            
                                            
                                            <div class="col-md-2">
                                                 <p><i class="fa fa-comment-o" aria-hidden="true"></i>&nbsp;
                                                 <a   onclick='openPanel("topbid-<?php echo $question['id']?>","tbc")' class='commentlink'><?php echo ($question['question_comment_count'])?$question['question_comment_count']:0?> <?php echo $this->lang->line('comments'); ?></a>
                                                 </p>
                                            </div>
                                              
                                        </div>
                                        
                                    </div>
                                    <div class="bid-amountbut">
                                        <span><?php echo $this->lang->line('bid_amount'); ?></span>
                                        <h2><?php echo $question['bidamountTotal']?>$</h2>
                                    </div>
                                      <div id="topbid-<?php echo $question['id']?>" class="cpanel">
                                      <div class='newcommentSystem-tbc-<?php echo $question['id']?>'></div>
                                      </div>
                                      <div class='laxcomment commentSystem-tbc-<?php echo $question['id']?>'>
                                      <div class="form-group">
                                      <input type="text" class="tbc-<?php echo $question['id']?> form-control" <?php if($this->session->userdata['USER_ID']==''){?> data-toggle="modal" data-target=".bs-example-modal-lg" <?php }else if(!$allowedComment) { ?>onfocus="showpopup('<?php echo $question['id']?>','tbc');" <?php } else{}  ?> placeholder='Write a comment (Max 300 Characters )' maxlength="300" /><input type="submit" value='<?php echo $this->lang->line('post'); ?>' class="commentButton" rel='<?php echo $question['id']?>' data-type='tbc'/>
                                      </div> 
                                     </div> 
                                      
                                      </div>
                                     </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>          
           
        
        <?php }  ?>
        <div class="devider"></div>
        
        <div class="trending_que_home trending_que_homeone">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="ask-que-btn home-view-all" onclick="location.href = '<?php echo base_url()?>top-bidding-questions.html';" ><?php echo $this->lang->line('view_all'); ?></button>
                    </div>
                </div>
            </div>
            
            
        </div>

<div class="devider"></div>
<div class="devider"></div>
<div class="devider"></div>
<!--

 <?php if(!empty($winners)){ ?>

<div class="winners_slider">
    
     <div id="bigLantern" class="vector-object">
        <div class="bellImg">
            <img src="<?php echo base_url()?>css/img/lantern-sprite.png">
         </div>
    </div>
    
    <div class="container_main1" id="container">
        <ul>
         <?php  $t=0; foreach($winners as $key=>$winner)  { ?>
            <li>
                 <div class="winner_slider_avatar">
                    <?php if($winner['user_pic']==''){  ?>
                                            <img src="<?php echo base_url()?>css/img/avatar.jpg">
                                              <?php } else{ ?>
                                              <img src="<?php echo base_url().$winner['user_pic']?>">
                                              <?php }  ?>
                </div>
                
                <div class="winner_silder_name">
                    <h4><?php echo $winner['winnername']?></h4>
                    <span><?php echo $winner['winning_position']?> Winner</span>
                </div>
                
                <div class="winner_says">
                    <p><?php echo $winner['comment']?></p>
                    
                    <input type="button" value="<?php echo $winner['winning_amount']?>">
                    
                </div>
                
            </li>
            <?php $t++;}  ?>
            <img class="left control_winners" src="http://www.jqueryscript.net/demo/Simplest-3D-Image-Carousel-Plugin-For-jQuery-Carousel-js/img/left.png">
            <img class="right control_winners" src="http://www.jqueryscript.net/demo/Simplest-3D-Image-Carousel-Plugin-For-jQuery-Carousel-js/img/right.png">
            
        </ul>
    </div>
</div>
  <?php }  ?>



-->



       <?php }  ?>
        <?php if(!empty($testmonials)){                 
			   ?>
        <div class="testmainials">
            <div class="container content">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                     <?php  $t=0; foreach($testmonials as $key=>$testmonial)  { ?>
                        <div class="item <?php echo ($t==0)?'active':''?>">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="thumbnail adjust1">
                                        <div class="col-md-2 col-sm-2 col-xs-12"> 
                                            <?php if($testmonials['user_pic']==''){  ?>
                                            <img src="<?php echo base_url()?>css/img/avatar.jpg">
                                              <?php } else{ ?>
                                              <img src="<?php echo base_url().$testmonial['user_pic']?>">
                                              <?php }  ?>
                                            <blockquote class="adjust2">
                                                    <p><?php echo $testmonial['first_name']?></p>
                                                    <small><cite title="Source Title"><?php echo $testmonial['designation']?></cite></small> 
                                                </blockquote>
                                        </div>
                                        <div class="col-md-10 col-sm-10 col-xs-12">
                                            <div class="caption">
                                                <p><span><i class="fa fa-quote-left" aria-hidden="true"></i></span> <?php echo $testmonial['message']?><span><i class="fa fa-quote-right" aria-hidden="true"></i></span></p>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <?php $t++;}  ?>
                    </div>
                    <!-- Controls --> 
                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev"> <img src="<?php echo base_url()?>css/img/left.png"> </a>
                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next"> <img src="<?php echo base_url()?>css/img/right.png">  </a> 
                </div>
            </div>
        </div>
        
       <?php }  ?>
        
          
<!-- Modal -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Subscrption Plans</h4>
            </div>
            <div class="modal-body"></div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->       
<script src="<?=base_url('');?>js/index.js"></script>
  <script>
  $(function(){
	$(".commentlink").each(function() { 
	 $(this).trigger('click');
	}); 
}); 
  </script>   