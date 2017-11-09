  <?php $rockerBalance=$wallet['rocker_credit_amount']-$wallet['rocker_debit_amount'];
    if($rockerBalance>= $settings['MinimumBidValue']) $allowedBid=1; else $allowedBid=0;
 ?>                       
                     <?php $p=0;foreach($CommentsList as $Comment){ ?>
                      <div class="inner cover price comment_ques_bi">
                     <div class="img_var_come"> <?php if($Comment['user_pic']==''){  ?> <img src="<?php echo base_url()?>css/img/avatar.jpg" width="30" height="30" />
                       <?php } else{ ?>
                         <img src="<?php echo base_url().$Comment['user_pic']?>" width="30" height="30" />
                      <?php }  ?></div>
                          
                          <div class="comment_area_re">
                              <p><strong><?php echo $Comment['first_name'] ?></strong></p> <p><?php echo $Comment['comment'] ?></p> 
                          </div>
                     <div class="col-md-4">
                     <p class="bid_likes_comment"><a href='javascript:' class='' id='newcom-<?php echo $Comment['id'] ?>' rel='<?php echo $Comment['id'] ?>' rel1='likes'><?php echo ($Comment['comment_likes_count'])?$Comment['comment_likes_count']:0?> Likes</a> 
					</p>
                  </div>        <?php /*?> condition for minimum likes & is Comment allowed for bid && not myquestions page <?php */?>
                           
                      </div>
                      <?php ++$p;}?>
                  