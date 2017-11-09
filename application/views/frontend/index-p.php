<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>RockDTalk</title>
        <meta title="RockDTalk">
        <meta lang="aa">
        <meta property="og:type" content="article">
        <meta property="og:title" content="<?php echo $stitle?>">
        <meta property="og:description" content="<?php echo $sdesc?>">
        <meta property="og:site_name" content="RockDTalk">
        <meta property="og:image" content="<?=base_url('');?>css/img/logohome.png">
        <meta property="og:url" content="<?=base_url('').'main/comment_page/'.$this->uri->segment(3).'/'.$this->uri->segment(4);?>">
        <meta property="fb:app_id" content="108283983076134" />
        
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:site" content="@RockDTalk" />
        <meta name="twitter:title" content="<?php echo $stitle?>" />
        <meta name="twitter:description" content="<?php echo $stitle?>" />
        <meta name="twitter:image" content="<?php echo $stitle?>" />
        <meta property="fb:app_id" content="108283983076134" />
        <link href="<?=base_url('');?>css/stylesheets/styles.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script> var base_url='<?=base_url('');?>';</script>
    </head>
    <body>
 
        
        <nav class="navbar navbar-fixed-top navmain  postnav main-home-nav-bar home-navbar">
      <div class="container">
        
          <a class="navbar-brand landing_pagemenu" href="<?=base_url('');?>"><img src="<?=base_url('');?>css/img/logo2.png"></a>
          
          <ul class="nav navbar-nav navbar-right nav-main-inner">
               <?php /*?> <li class="active"><a href="<?=base_url('');?>">Home</a></li>
                <li><a href="#">Segments</a></li>
                <li><a href="<?=base_url('');?>trending-questions.html">Trending Questions</a></li>
                <li><a href="<?=base_url('');?>about-to-close-questions.html">About to Close Questions</a></li>
             <?php */?>   <?php if($this->session->userdata['USER_ID']==''){ ?>
                 <li><a data-toggle="modal" data-target=".bs-example-modal-lg" type="button" class="Register">Register</a></li>
                <li><a data-toggle="modal" data-target=".bs-example-modal-lg" type="button" class="Login">Login</a></li>
                <?php } else{ ?> 
                <li><a href="<?=base_url('');?>post-your-question.html">Post your Questions</a></li>
                <li class="dropdown user-profle">
                    <span href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?=base_url('');?>css/img/avatar.png">
                        <span> <?php echo $this->session->userdata['USER_NAME'] ?></span>
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </span>
                    <ul class="dropdown-menu">
                         <li><a href="<?=base_url('');?>profile.html">Account Settings </a></li>
                        <li class="divider"></li>
                        <li><a href="#">User stats </a></li>
                        <li class="divider"></li>
                        <li><a href="#">Messages </a></li>
                        <li class="divider"></li>
                        <li><a href="#">Favourites Snippets </a></li>
                        <li class="divider"></li>
                        <li><a href="<?=base_url('');?>main/logout">Sign Out </a></li>
                 </ul>
                </li>
                <?php }  ?> 
            </ul>

        
      </div>
    </nav>
        
       <!-- <ul class="mobile">
        
            <li>
                <a data-toggle="modal" data-target=".bs-example-modal-lg" type="button" class="Register">Register</a> 
                <a data-toggle="modal" data-target=".bs-example-modal-lg" type="button" class="Login">Login</a>
             </li>
            
        </ul>-->
        
        
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg login_popup_model" role="document">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="cover-container login-cover">

                    

                    <div class="inner cover desktop_login">
                        
                        <ul class="login_mobile_tabs">
                            <li><a class="active" href="#">Login</a></li>
                            <li><a href="#">New account</a></li>
                        </ul>
                        
                       <div class="lign-left lign-left_img">
                        
                        </div>
                       <div id="login_to_account" class="lign-left Login_to_account">
                        
                           
                           <div class="row login-main-form">
                               
                               <div class="col-md-12">
                                <h4><?php echo $this->lang->line('Login_to_account'); ?></h4>
                               </div>
                               
                              <div class="col-md-12">
                                  <span id='login-error'></span>
                                     <form class="form login_form auth_form" action="<?php echo base_url()?>main/checkuser" method="post" role="form" id='login_form' >
                                    <div class="form-group">
                                       <label class="sr-only" for="lemail"><?php echo $this->lang->line('user_name'); ?></label><span  class="Errtg" id="Errlemail"></span>
                                       <input type="text" class="form-control" name="user_name"  id="lemail"  placeholder="<?php echo $this->lang->line('user_name'); ?>" >
                                    </div>
                                    <div class="form-group">
                                       <label class="sr-only" for="lpassword"><?php echo $this->lang->line('password'); ?></label><span  class="Errtg" id="Errlpassword"></span>
                                       <input type="password" class="form-control" name="password" id="lpassword"  placeholder="<?php echo $this->lang->line('password'); ?>" >
                                    </div>
                                    
                                    <div class="form-group">
                                       <button type="submit" class="btn btn-success btn-block login"><?php echo $this->lang->line('sign_in'); ?> </button>
                                    </div>
                                     
                                     <a href="#" data-toggle="modal" data-target="#myModal1" data-dismiss="modal"><?php echo $this->lang->line('forgot_your_password'); ?></a>
                                         
                                         
                                         
                        
                                         
                                         
                                         
                                     
                                     <div class="or">
                                         <div class="line"></div>
                                     </div>
                                     
                                     
                                 </form>
                              </div>
                               
                               <div class="col-md-12">
                                   <button class="btn google" type="button" onclick="location.href = '<?php echo base_url()?>sociallogin/handle_google_login';">Google Plus <i class="fa fa-google-plus-official pull-right" aria-hidden="true"></i></button>
                                   <button class="btn facebbok" type="button" onclick="location.href = '<?php echo base_url()?>sociallogin/facebook';"> Facebook <i class="fa fa-facebook-square pull-right" aria-hidden="true"></i></button>
                               </div>
                               
                           </div>
                      
                       
                           
                     
                           
                        </div>
                       <div id="create_a_new_account" class="lign-left Create_a_new_account">
                            <div class="row login-main-form">
                               
                               <div class="col-md-12">
                                <h4><?php echo $this->lang->line('Create_a_new_account'); ?></h4><span class='server-error'></span>
                                </div>
                                  <div class="col-md-12">
                                     <span id='login-error'></span>
                                     <form class="form signup_form auth_form" action="<?php echo base_url()?>main/register" method="post" role="form">
                                        <div class="form-group">
                                           <label class="sr-only" for="name"><?php echo $this->lang->line('name'); ?></label><span  class="Errtg" id="Errname"></span>
                                           <input type="text" class="form-control" id="name" name="name" placeholder="<?php echo $this->lang->line('name'); ?>" required="">
                                        </div>
                                        
                                         <div class="form-group">
                                           <label class="sr-only" for="email"><?php echo $this->lang->line('email'); ?></label><span  class="Errtg" id="Erremail"></span>
                                           <input type="text" class="form-control chk" id="email" name='email'  placeholder="<?php echo $this->lang->line('email'); ?>" required="" data-role='1'>
                                        </div>
                                        
                                        <div class="form-group">
                                           <label class="sr-only" for="mobile"><?php echo $this->lang->line('mobile'); ?></label><span  class="Errtg" id="Errmobile"></span>
                                           <input type="text" class="form-control chk" id="mobile" name='mobile' placeholder="<?php echo $this->lang->line('mobile'); ?>" required=""  data-role='2'>
                                        </div>
                                         
                                         <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="sr-only" for="age"><?php echo $this->lang->line('age'); ?></label><span  class="Errtg" id="Errage"></span>
                                                   <input type="text" class="form-control" name='age' id="age" placeholder="<?php echo $this->lang->line('age'); ?>" required="">
                                                </div>
                                             </div>
                                             
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="sr-only" for="acard"><?php echo $this->lang->line('adhar_card'); ?></label><span  class="Errtg" id="Erracard"></span>
                                                   <input type="text" class="form-control" id="acard"  name='acard' placeholder="<?php echo $this->lang->line('adhar_card'); ?>" required="">
                                                </div>
                                             </div>
                                         </div>
                                         
                                         <div class="form-group">
                                           <label class="sr-only" for="password"><?php echo $this->lang->line('password'); ?></label><span  class="Errtg" id="Errpassword"></span>
                                           <input type="password" class="form-control" id="password"  name='password'  placeholder="<?php echo $this->lang->line('password'); ?>" required="">
                                        </div>
                                         
                                         <div class="form-group">
                                           <label class="sr-only" for="cpassword"><?php echo $this->lang->line('confirm_password'); ?></label><span  class="Errtg" id="Errcpassword"></span>
                                           <input type="password" class="form-control" id="cpassword" name='cpassword' placeholder="<?php echo $this->lang->line('confirm_password'); ?>" required="">
                                        </div>

                                        <div class="form-group">
                                          <input type="button" value="<?php echo $this->lang->line('create_my_account'); ?>" class="btn btn-success btn-block login" onclick="FnPostContinue(this)">
                                        </div>

                                         
                                     </form>
                                  </div>
                               
                              
                               
                           </div>
                        </div>
                    </div>
                    
                   



                </div>
    </div>
  </div>
</div>

        
        
        
        
        <div class="site-wrapper login-main post">

            <div class="site-wrapper-inner home-main-post">

                <div class="cover-container post-cover">

                    

                    <div class="inner cover">
                       <div class="home-main">
                            <img src="<?=base_url('');?>css/img/home1.png">
                        </div>
                        
                        
                        <div class="middle-post">
                            <div class="middle-post-inner">
                                
                            </div>
                        </div>
                        
                       <div class="home-main">
                        <div class="leftmain">
                            <uL>
                               
                                <li> <?php if($this->session->userdata['USER_ID']==''){ ?>
                                <a data-toggle="modal" data-target=".bs-example-modal-lg" class="btn icon-btn btn-muted">Post your quession<i class="fa fa-paper-plane-o pull-right" aria-hidden="true"></i></a>      <?php } else{ ?> 
                                      <a class="btn icon-btn btn-muted" href="<?=base_url('');?>post-your-question.html">Post your quession<i class="fa fa-paper-plane-o pull-right" aria-hidden="true"></i></a>
                                <?php } ?> 
                                </li>
                                <li>
                                    <a class="btn icon-btn btn-muted" href="<?=base_url('');?>">Comment on the existing quession<i class="fa fa-commenting-o pull-right" aria-hidden="true"></i></a> 
                                </li>
                                <li>
                                    <a class="btn icon-btn btn-muted" href="<?=base_url('');?>">Bid on quession<i class="fa fa-question-circle-o pull-right" aria-hidden="true"></i></a> 
                                </li>
                            </uL>
                        </div>
                        </div>
                       
                    </div>



                </div>

            </div>

        </div>
        
        
    <script src="<?=base_url('');?>js/bootstrap.min.js"></script>
    <script src="<?=base_url('');?>js/custom.js"></script>
    <script src="<?=base_url('');?>js/common.js"></script>
  
 
            
    </body>
</html>

