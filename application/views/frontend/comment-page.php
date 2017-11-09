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


</script>

<?php $talkerBalance=$wallet['talker_credit_amount']-$wallet['talker_debit_amount'];
    if($talkerBalance>= $settings['perCommentDeduction']) $allowedComment=1; else $allowedComment=0;
 
 $rockerBalance=$wallet['rocker_credit_amount']-$wallet['rocker_debit_amount'];
    if($rockerBalance>= $settings['MinimumBidValue']) $allowedBid=1; else $allowedBid=0;
 ?> 
<div class="container login-main profile_contianer">

         <div class="trending trending-main-home">
            <div class="container ">
                <div class="row">
                    <div class="col-md-12 trending-left-main">
                        <div class="trending-left">


						  <?php if(!empty($commentInfo)){               
			                  foreach($commentInfo['data'] as $key=>$question)
			                 { ?>
                               <div class="trending-left-inner">
                                <div class="col-md-2">
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
                                            
                                           
                                        </div>
                                        <p>Corpus Fund</p>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="tre-ques">
                                        
                                        
                                        
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>
										<?php $bidding_closed_at=date('Y/m/d H:i:s',strtotime($question['bidding_closed_at']));?>
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
                                            <li>Start: <span> <?php echo time_ago(strtotime($question['approved_at']))?></span></li>
                                            <li>Closed In: <span id="countdowntimer"><span class="future_date" id='future_date<?php echo $key?>' rel="<?php echo $bidding_closed_at?>"></span></span></li>
                                        </ul>
                                            </div>
                                        </div>
                                        
                                        <p><?php echo $question['description']?> </p>
                                        <div class="devider"></div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                 <p><i class="fa fa-comment-o" aria-hidden="true"></i>&nbsp;
                                                 <a style="cursor:pointer"   onclick='openPanel("trendpanel-<?php echo $key?>","tqc")'><?php echo ($question['question_comment_count'])?$question['question_comment_count']:0?> Comments</a>
                                                 </p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                     <?php if($this->router->fetch_method()=='top_bidding'){     ?>
                                    <div class="bid-amountbut">
                                        <span>Bid Amount</span>
                                        <h2><?php echo $question['bidamountTotal']?>$</h2>
                                    </div>
                                     <?php } ?>
                                      <div id="trendpanel-<?php echo $key?>" class="cpanel">
                                      <div class='newcommentSystem-tqc-<?php echo $key?>'>
                                            <?php $p=0;foreach($commentInfo['comments'][$key] as $Comment){ ?>
                                          <div class="inner cover price comment_ques_bi">
                                          <div class="img_var_come"> <?php if($Comment['upic']==''){  ?> <img src="<?php echo base_url()?>css/img/avatar.jpg" width="30" height="30" />
                       <?php } else{ ?>
                         <img src="<?php echo base_url().$Comment['upic']?>" width="30" height="30" />
                      <?php }  ?></div>
                          
                                          <div class="comment_area_re">
                                              <p><strong><?php echo $Comment['first_name'] ?></strong></p> <p><?php echo $Comment['comment'] ?></p> 
                                          </div>
                          
                          
                     
                     <div class="col-md-3">
                        <ul class="share share_one">
                            <li><i class="fa fa-share-alt" aria-hidden="true"></i> share</li>
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url().'main/comment_page/'.$key.'/'.$Comment['id']?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($Comment['comment']);?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="https://plus.google.com/share?url=<?php echo base_url().'main/comment_page/'.$key.'/'.$Comment['id']?>" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                             <li><a data-text="<?php echo $Comment['comment'] ?>" data-link="<?php echo base_url().'main/comment_page/'.$key.'/'.$Comment['id']?>" class="whatsapp"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                     <div class="col-md-4">
                     <p class="bid_likes_comment"><a href='javascript:' class='newcomm' id='newcom-<?php echo $Comment['id'] ?>' rel='<?php echo $Comment['id'] ?>' rel1='likes'><?php echo ($Comment['comment_likes_count'])?$Comment['comment_likes_count']:0?> Likes</a> 
                     
					   <?php /*?> condition for minimum likes & is Comment allowed for bid && not myquestions page <?php */?>
					  <?php if(($Comment['comment_likes_count']>=$settings['MinimumLikesForBid']) && $Comment['is_biddable']){ ?>
					  <a href='javascript:' class='newbid' id='newbid-<?php echo $Comment['id'] ?>' rel='<?php echo $Comment['id'] ?>' rel1='bid'  <?php if($allowedBid){ ?> onclick="addBidonComment('<?php echo $Comment['id'] ?>')"<?php } else{ ?>  onclick="window.location.href='<?php echo base_url()?>main/addFunds'"  <?php } ?>><?php echo ($Comment['fg'])?$Comment['df']:''?>Make a Bid</a>
					<?php } ?>
                    
                    
					</p>
                  </div>        <?php /*?> condition for minimum likes & is Comment allowed for bid && not myquestions page <?php */?>
                            <?php if(($Comment['comment_likes_count']>=$settings['MinimumLikesForBid']) && $Comment['is_biddable'] && $Comment['bidamountTotal']){ ?>
                          <div class="col-md-4">
                            <div class="bid-amountbut bid-amountbut2">
                                        <h2>Bid Amount <strong><?php echo ($Comment['bidamountTotal'])?$Comment['bidamountTotal']:0 ?>$</strong></h2>
                                    </div>
                          </div>
                            <?php } ?>
                      </div>
                                          <?php ++$p;}?>
                                      
                                      </div>
                                      </div>
                                      <?php if($pageKey!='my' && $pageKey!='myc'){     ?>
                                      <div class='laxcomment commentSystem-tqc-<?php echo $Comment['qusetion_id']?>'>
                                      <div class="form-group"> <input type="text" class="tqc-<?php echo $Comment['qusetion_id']?> form-control" <?php if($this->session->userdata['USER_ID']==''){?> data-toggle="modal" data-target=".bs-example-modal-lg" <?php }else if(!$allowedComment) { ?>onfocus="showpopup('<?php echo $Comment['qusetion_id']?>');" <?php } else{}  ?> placeholder='Write a comment'/><input type="submit" value='Post' class="commentButton" rel='<?php echo $Comment['qusetion_id']?>' data-type='tqc'  /></div>
                                       </div>
                                     <?php } ?>
                                     </div>
                                </div>
                           <?php }} ?>
						   </div> </div> </div> </div> </div>
                           </div>
    <script src="<?=base_url('');?>js/index.js"></script>                       