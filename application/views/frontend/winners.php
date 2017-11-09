<div class="full-width-con addmoneywallet">
            <div class="container">
                <div class="row">
                    <div class="faqs col-md-12">
                        <h2>Winners</h2>
                    </div>
                    <?php foreach($winners['data'] as $ckey=>$winnersArr){?>
                    <div class="row">
                    
                     <?php foreach($winnersArr as $winnersdata){?> 
                        
                        <div class="col-md-6 col-xs-12 col-sm-6 wiiner_page_p">
                            <div class="winners-main">
                                <div class="winners-main-inner">
                                <?php if($winnersdata['user_pic']!='') {?>
                                    <img src="<?php echo base_url().$winnersdata['user_pic']; ?>">
                                     <?php } else{?>   
                                      <img src="<?php echo base_url();?>images/winnerone.jpg">
                                      <?php } ?>       
                                    <h3><?php echo $winnersdata['winnername']; ?></h3>
                                    <span><?php echo $winnersdata['winning_position']; ?> Winner</span>
                                    <p><?php echo $winners['comments'][$ckey]; ?></p>
                                    <div class="winning_amout">
                                        Rs.<?php echo $winnersdata['winning_amount']; ?>
                                    </div>
                                    
                                    <div class="winner_footer">
                                        <p><?php echo date('D M, Y',strtotime($winnersdata['created_at'])); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                      <?php } ?>     
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>