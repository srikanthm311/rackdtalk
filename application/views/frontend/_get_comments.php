

 
  <?php $rockerBalance=$wallet['rocker_credit_amount']-$wallet['rocker_debit_amount'];
    if($rockerBalance>= $settings['MinimumBidValue']) $allowedBid=1; else $allowedBid=0;
 ?>                       
                     <?php $p=0;foreach($CommentsList as $Comment){ ?>
                      <div class="inner cover price comment_ques_bi">
                           <div class="img_var_come">
                      <?php if($Comment['user_pic']==''){  ?> <img src="<?php echo base_url()?>css/img/avatar.jpg" width="30" height="30" />
                       <?php } else{ ?>
                         <img src="<?php echo base_url().$Comment['user_pic']?>" width="30" height="30" />
                      <?php }  ?>
                     </div>
                          
                           <div class="comment_area_re">
                              <p><strong><?php echo ($this->session->userdata['USER_ID']==$Comment['user_id'])?'You':$Comment['first_name'] ?></strong></p> <p><?php echo $Comment['comment'] ?></p> 
                          </div>
                          
                          
                           <div class="row get_comments">
                     
                     <div class="col-md-3 col-xs-12 get_comments_in get_comments_in_first">
                        <ul class="share share_one">
                            <li><i class="fa fa-share-alt" aria-hidden="true"></i> <?php echo $this->lang->line('share'); ?></li>
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url().'main/comment_page/'.$q.'/'.$Comment['id']?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($Comment['comment']);?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="https://plus.google.com/share?url=<?php echo base_url().'main/comment_page/'.$q.'/'.$Comment['id']?>" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                            
                             <li><a data-text="<?php echo $Comment['comment'] ?>" data-link="<?php echo base_url().'main/comment_page/'.$q.'/'.$Comment['id']?>" class="whatsapp"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
                            
                        </ul>
                    </div>
                     <div class="col-md-5 col-xs-12 get_comments_in">
                     <p class="bid_likes_comment"><a href='javascript:' class='newcomm' id='newcom-<?php echo $Comment['id'] ?>' rel='<?php echo $Comment['id'] ?>' rel1='likes'  rel2='<?php echo $q ?>'><?php echo ($Comment['comment_likes_count'])?$Comment['comment_likes_count']:0?> <?php echo $this->lang->line('likes'); ?></a> 
                     
					   <?php /*?> condition for minimum likes & is Comment allowed for bid && not myquestions page <?php */?>
					  <?php if(($Comment['comment_likes_count']>=$settings['MinimumLikesForBid']) && $Comment['is_biddable']){ ?>
					  <a href='javascript:' class='newbid' id='newbid-<?php echo $Comment['id'] ?>' rel='<?php echo $Comment['id'] ?>' rel1='bid'  <?php if($this->session->userdata['USER_ID']==''){?> data-toggle="modal" data-target=".bs-example-modal-lg" <?php }else if($allowedBid){ ?> onclick="addBidonComment('<?php echo $Comment['id'] ?>')"<?php } else{ ?>  onclick="window.location.href='<?php echo base_url()?>main/addFunds'"  <?php } ?>><?php echo ($Comment['fg'])?$Comment['df']:''?><?php echo $this->lang->line('Make_Bid'); ?></a>
					<?php } ?>
                    
                    <?php  if($Comment['is_biddable']){ if($Comment['is_flag']){ ?>
                     <a href='javascript:' class='Reported'><?php echo $this->lang->line('reported'); ?></a>
                     <?php } else{ ?>
                      <a href='javascript:' class='report' id='report-<?php echo $Comment['id'] ?>'  <?php if($this->session->userdata['USER_ID']==''){?> data-toggle="modal" data-target=".bs-example-modal-lg" <?php }else { ?>  onclick="addReport('<?php echo $Comment['id'] ?>')"  <?php } ?>><i class="fa fa-flag" aria-hidden="true"></i><?php echo $this->lang->line('report'); ?></a>
                    <?php } } ?>
					</p>
                  </div>      
                  
                          <?php /*?> condition for minimum likes & is Comment allowed for bid && not myquestions page <?php */?>
                            <?php if(($Comment['comment_likes_count']>=$settings['MinimumLikesForBid']) && $Comment['is_biddable'] && $Comment['highestBidAmount']){ ?>
                          <div class="col-md-4 col-xs-12 get_comments_in">
                            <div class="bid-amountbut bid-amountbut2">
                                        <h2><?php echo $this->lang->line('highest_bid'); ?> <strong>Rs. <?php echo ($Comment['highestBidAmount'])?$Comment['highestBidAmount']:0 ?></strong></h2>
                                    </div>
                          </div>
                            <?php } ?>
                            
                     </div>         
                   </div>  
                      <?php ++$p;}?>
                  