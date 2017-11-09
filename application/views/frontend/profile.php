<div class="container login-main profile_contianer">

            <div class="site-wrapper-inner">

                <div class="cover-container login-cover myprofile">

                    

                    <div class="inner cover">
                       <div class="mp-left">
                        
                           <div class="user">
                                <div class="user-img">
                                    <?php if($userpic['pic']=='') { ?>
                                                <img src="<?php echo base_url()?>css/img/avatar.jpg">
                                                 <?php } else{  ?>
                                                 <img src="<?php echo base_url()?><?php echo $userpic['pic']?>">
                                                 <?php }  ?>
                                    
                                </div>
                               
                           </div>
                           
                           <div class="user">
                               <h4><?php echo $this->session->userdata['USER_NAME'] ?></h4>
                               <?php /*?> <span>UI/UX Developer</span><?php */?>
                           </div>
                           
                          <?php $this->load->view('frontend/includes/user-sidebar');?>
                           
                        </div>
                       <div class="mp-right">
                        
                           <div class="wallet">
                                <a href="javascript:"><img src="<?php echo base_url()?>css/img/wallet.png"><span>Talker Wallet</span>(<?php echo ($wallet['talker_credit_amount']- $wallet['talker_debit_amount'])?$wallet['talker_credit_amount']-$wallet['talker_debit_amount']:0?>)</a>
                                <a href="javascript:"><img src="<?php echo base_url()?>css/img/wallet.png"><span>Rocker Wallet</span> (<?php echo ($wallet['rocker_credit_amount']- $wallet['rocker_debit_amount'])?$wallet['rocker_credit_amount']-$wallet['rocker_debit_amount']:0;?>)</a>
                           </div>
                           
                           <div id="my_questions" class="my_profile_quesstions">
                           
                           
                           <div class="col-md-12 trending-left-main">
                        <div class="trending-left">
                            <div class="trending-left-inner">
                                <p><?php echo $pageHeading?> (<?php echo ($total_count>0)?$total_count:0; ?>)</p>
                            </div>
                            <div id='messages-list'>
                            
                           </div>
                               <div id="hidden_button"  style="display:none;">
                                <div class="loadmore_btn">
                                  <input type="button" class="show-product btn-show_more" value="Show More Questions" id="hidden_button_id"  >
                                </div>
                                </div>
                                <!-- End .category-item-container -->	
                                <div class="hidden-lg hidden-md" id="hidden_button_mobile">
                                <input type="button" class="show-product margin-lft col-xs-11 col-sm-12" value="Show More Questions" id="hidden_mobile_button_id"  >
                                </div>
                                <!-- End .category-item-container -->							 
                                <div id="page-wrap" style="display:none; height: 40px;border: 1px solid #ccc">
                                <div id="page-loading">
                                  <img src="http://bagitbig.com/coupons/load-more-on-scroll/gif-load.gif">
                                  <span>Loading More Results</span>
                                </div>
                                <div id="page-mask"></div>
                                </div>
                    
                   
                        </div>
                    </div>
                           
                           
                           
                           
                           
                           </div>
                        </div>
                       
                    </div>



                </div>

            </div>

        </div><script src="<?=base_url('');?>js/loading.js"></script>
    <script src="<?=base_url('');?>js/index.js"></script>
	