

        <!--<div class="tredning-header">
            <div class="container">
            <div class="row row-break">
                    <div class="col-md-6">
                        <h4 class="text-left"><?php echo $pageHeading?></h4>
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
        </div>-->
        
        <div class="trending">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 trending-left-main">
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
                                  <span><?php echo $this->lang->line('loading_more_results'); ?></span>
                                </div>
                                <div id="page-mask"></div>
                                </div>
                    
                   
                        </div>
                    </div>
                 
                    <div class="col-md-3 trending-right-main">
                        <div class="trending-left trending-right">
                            <div class="trending-left-inner sidebar">
                             <?php if($this->session->userdata['USER_ID']==''){ ?>
                               <button class="ask-que-btn" type="button" data-toggle="modal" data-target=".bs-example-modal-lg"><?php echo $this->lang->line('ask_question'); ?></button>
                             <?php } else{ ?>  
                               <button class="ask-que-btn" type="button" onclick="location.href = '<?php echo base_url()?>post-your-question.html';" ><?php echo $this->lang->line('ask_question'); ?></button>
                              <?php }  ?>  
                                <div class="row">
                                    <div class="col-md-6 no-ques col-sm-6 col-xs-6">
                                            <span><?php echo $this->lang->line('questions'); ?></span>
                                            <h2><?php echo ($commonData['totalQuestions'])?($commonData['totalQuestions']):0; ?></h2>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6 no-ques members-ques">
                                            <span><?php echo $this->lang->line('members'); ?></span>
                                           <h2><?php echo ($commonData['totalUsers'])?$commonData['totalUsers']:0; ?></h2>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="trending-left-inner sidebar">
                                <div class="segment">
                                    <h4><?php echo $this->lang->line('segments'); ?></h4>
                                    <ul>
                                       <?php  foreach($categoriesList as $list){ ?>
                  <li><a href="<?=base_url('');?>category.html/<?php echo $list['id']?>"><?php echo $list['category_name']?></a></li>
                   <?php }  ?> 
                                    </ul>
                                </div>
                            </div>
                            
                            
                            <div class="trending-left-inner sidebar">
                                <div class="segment">
                                    <h4><?php echo $this->lang->line('users_with_best_answers'); ?></h4>
                                    
                                      <?php  foreach($bestAnsweredWinners as $list){ ?>
                                    <div class="row wiiner-list">
                                        <div class="col-md-8">
                                            <div class="wiiner-listname">
                                                <div class="col-md-4">
                                                   <?php if($list['user_pic']==''){  ?> <img src="<?php echo base_url()?>css/img/avatar.jpg" width="30" height="30" />
                       <?php } else{ ?>
                         <img src="<?php echo base_url().$list['user_pic']?>" width="30" height="30" />
                      <?php }  ?>
                                                </div>
                                                <div class="col-md-8 col-xs-6">
                                                    <p><?php echo $list['first_name']?></p>
                                                    <span>Since 2014</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="typeofwin">
                                                <span><img src="<?php echo base_url()?>css/img/gold.jpg"></span>&nbsp;<span><?php echo $list['winning_amount']?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }  ?> 
                                    
                                    
                                    
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>          
            </div>
        </div>
        
        
<!-- Modal -->
<div class="modal plans_modiel fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    <h4><?php echo $winner['first_name']?></h4>
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
                                                    <p><?php echo $testmonial['winnername']?></p>
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
 


<script src="<?=base_url('');?>js/loading.js"></script>
<script src="<?=base_url('');?>js/index.js"></script>
	
