 <!-- Modal -->
<div class="modal fade" id="notifyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog success_message_pop">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <div class="modal-content">
            
            <div class="modal-body full-width-con addmoneywallet">
            <div class="success-message">
                <ul>
                    <li><img src="<?=base_url('');?>css/img/success.png"></li>
                    <li class='mynotify'>
                     <?php /*if($this->router->fetch_method()=='post_your_question') {?>	
                      Your Question is Posted Successfully.Its need Approval from Admin.
                       <?php }else if($this->router->fetch_method()=='addFunds') {?>	
                              Payment is Successful
					 <?php  }else{?> <?php }*/?>
                    </li>
                    <li class="success-text"><button type="button" class="ask-que-btn home-view-all" href="">Back to Home</button></li>
                </ul>
            </div>
            </div>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->  
    <script src="<?=base_url('');?>js/bootstrap.min.js"></script>
    <script src="<?=base_url('');?>js/Carousel.js"></script>
    <script src="<?=base_url('');?>js/custom.js"></script>
    <script src="<?=base_url('');?>js/common.js"></script>
	<script src="<?php echo base_url()?>js/jquery.validate.js"></script>
    <script src="<?php echo base_url()?>js/script.js"></script>
     <script type="text/javascript">
    <?php if($this->session->flashdata('message')!='') {?>
		 $('#notifyModal').find(".mynotify").html('<?php echo $this->session->flashdata('message');?>'); $('#notifyModal').modal('show'); 
	<?php }		?>
	</script>
 <script type="text/javascript" src="http://harshen.github.io/jquery-countdownTimer/jquery.countdownTimer.min.js"></script>

       
        <footer>
            <div class="container">
                <div class="col-md-3">
                    <div class="footer-left">
                        <img src="<?php echo base_url()?>css/img/logo2.png">
                        
                        <ul>
                            <li><a href="<?php echo base_url('post-your-question.html')?>"><?php echo $this->lang->line('post_your_questions'); ?></a></li>
                            <li><a href="#"><?php echo $this->lang->line('post_your_questions'); ?></a></li>
                            <li><a href="#"><?php echo $this->lang->line('post_your_questions'); ?></a></li>
                        </ul>
                        
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="footer-ul">
                                <li><a href="<?php echo base_url('main/about_us')?>"><?php echo $this->lang->line('about_us'); ?></a></li>
                                <li><a href="<?php echo base_url('main/contact_us2')?>"><?php echo $this->lang->line('contact_us'); ?></a></li>
                                <li><a href="#"><?php echo $this->lang->line('testimonials'); ?></a></li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <ul class="footer-ul">
                                <li><a href="<?php echo base_url('top-bidding-questions.html')?>"><?php echo $this->lang->line('top_bidded_questions'); ?></a></li>
                                <li><a href="<?php echo base_url('main/terms_conditions')?>"><?php echo $this->lang->line('Terms_and_conditions'); ?></a></li>
                                <li><a href="<?php echo base_url('main/refund_policy')?>"><?php echo $this->lang->line('refund_policy'); ?></a></li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <ul class="footer-ul">
                                <li><a href="<?php echo base_url('trending-questions.html')?>"><?php echo $this->lang->line('trending_questions'); ?></a></li>
                                <li><a href="<?php echo base_url('main/bid_policy')?>"><?php echo $this->lang->line('bid_policy'); ?></a></li>
                                <li><a href="<?php echo base_url('main/privacy_policy')?>"><?php echo $this->lang->line('privacy_policy'); ?></a></li>
                            </ul>
                        </div>
                    </div>
                    
                    
                </div>
                
            </div>
            
            
            <div class="footer-bottom-main">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <p>@2017 rockdtalk</p>
                    </div>
                    <div class="col-md-9">
                        <ul class="footer-social">
                            <li>
                                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
            
            
        </footer>
        
        

 
            
</body>
</html>

		