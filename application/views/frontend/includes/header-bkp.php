<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $stitle?></title>
        <meta title="<?php echo $stitle?>">
        <meta description="<?php echo $sdesc?>">
        <meta lang="aa">
        <meta property="og:type" content="article">
        <meta property="og:title" content="<?php echo $stitle?>">
        <meta property="og:description" content="<?php echo $sdesc?>">
        <meta property="og:site_name" content="RockDTalk">
        <meta property="og:image" content="<?php echo ($simage!='')?$simage:base_url('css/img/logohome.png');?>">
        <meta property="og:url" content="<?=base_url('').'main/comment_page/'.$this->uri->segment(3).'/'.$this->uri->segment(4);?>">
        <meta property="fb:app_id" content="108283983076134" />
        
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:site" content="@RockDTalk" />
        <meta name="twitter:title" content="<?php echo $stitle?>" />
        <meta name="twitter:description" content="<?php echo $stitle?>" />
        <meta name="twitter:image" content="<?php echo $simage?>" />

       <!-- <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">-->
        <link href="<?=base_url('');?>css/stylesheets/styles.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.min.js"></script>
		<script type="text/javascript">
        var base_url='<?php echo base_url()?>';
        var insertLikeUrl='<?php echo base_url();?>main/insertLike';
        var insertCommentUrl='<?php echo base_url();?>main/insertComment';
        var getCommentsByQuestionUrl='<?php echo base_url('main/getCommentsByQuestion')?>';
        var category_id='<?php echo $category_id?>';
        var pageKey='<?php echo $pageKey?>';
        var commentFormUrl='<?php echo base_url()?>comment-form';
        var totalpages='<?php echo $total_pages?>';
        var getHighestBidAmountByCommentUrl='<?php echo base_url();?>main/getHighestBidAmountByComment';
        var addBidonCommentUrl='<?php echo base_url();?>main/addBidonComment';
		var addReportOnCommentUrl='<?php echo base_url();?>main/addReportOnComment';
		var hidetxt='<?php echo $this->lang->line('hide');?>';
        </script>
    </head>
    <body>
 <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '108283983076134',
      xfbml      : true,
      version    : 'v2.9'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));


 
</script>
        
   
        
        
        <nav class="navbar navbar-default navbar-fixed-top navmain postnav">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?=base_url('');?>"><img src="<?=base_url('');?>css/img/logo2.png"></a>
        </div>
          
          <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
          <ul class="nav navbar-nav navbar-right nav-main-inner">
                <li class=""><a href="<?=base_url('');?>"><?php echo $this->lang->line('home'); ?></a></li>
               <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="<?=base_url('');?>category.html"><?php echo $this->lang->line('segments'); ?><i class="fa fa-angle-down" aria-hidden="true"></i></a>
                <ul class="dropdown-menu">
                <?php  foreach($categoriesList as $list){ ?>
                  <li><a href="<?=base_url('');?>category.html/<?php echo $list['id']?>"><?php echo $list['category_name']?></a></li>
                   <?php }  ?> 
                </ul>
              </li>
                <li><a href="<?=base_url('');?>trending-questions.html"><?php echo $this->lang->line('trending_questions'); ?></a></li>
                <li><a href="<?=base_url('');?>about-to-close-questions.html"><?php echo $this->lang->line('about_to_close_questions'); ?></a></li>
                <?php if($this->session->userdata['USER_ID']==''){ ?>
                 <li><a data-toggle="modal" data-target=".bs-example-modal-lg"><?php echo $this->lang->line('post_your_questions'); ?></a></li>
                 <li><a data-toggle="modal" data-target=".bs-example-modal-lg" type="button" class="Register"><?php echo $this->lang->line('register'); ?></a></li>
                <li><a data-toggle="modal" data-target=".bs-example-modal-lg" type="button" class="Login"><?php echo $this->lang->line('login'); ?></a></li>
                <?php } else{ ?> 
                <li><a href="<?=base_url('');?>post-your-question.html"><?php echo $this->lang->line('post_your_questions'); ?></a></li>
                <li class="dropdown user-profle">
                    <span href="#" class="dropdown-toggle user_profleaa" data-toggle="dropdown">
                        <img src="<?php echo ($userpic['pic']!='')?base_url().$userpic['pic']:base_url('').'css/img/avatar.png';?>">
                        <span> <?php echo $this->session->userdata['USER_NAME'] ?></span>
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </span>
                    <ul class="dropdown-menu">
                         <li><a href="<?=base_url('');?>my-account.html"><?php echo $this->lang->line('my_account'); ?></a></li>
                        <li><a href="<?=base_url('');?>my-information.html"><?php echo $this->lang->line('my_information'); ?></a></li>
                        <li><a href="<?=base_url('');?>main/resetpassword"><?php echo $this->lang->line('change_password'); ?></a></li>
                        <li><a href="<?=base_url('');?>main/logout"><?php echo $this->lang->line('sign_out'); ?></a></li>
                        
                 </ul>
                </li>
                <?php }  ?> 
                <li>
               <select onchange="javascript:window.location.href='<?php echo base_url(); ?>LanguageSwitcher/switchLang/'+this.value;">
             <option value="english" <?php if($this->session->userdata('site_lang') != 'hindi') echo 'selected="selected"'; ?>>English</option>
             <option value="hindi" <?php if($this->session->userdata('site_lang') == 'hindi') echo 'selected="selected"'; ?>><?php echo $this->lang->line('hindi'); ?></option>
           </select>
           </li>
            </ul>
            
          </div>

        
      </div>
    </nav>
        
         <ul class="mobile">
            <li><a data-toggle="modal" data-target=".bs-example-modal-lg" type="button" class="Register"><?php echo $this->lang->line('register'); ?></a> <a data-toggle="modal" data-target=".bs-example-modal-lg" type="button" class="Login"><?php echo $this->lang->line('login'); ?></a></li>
        </ul>
        
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg login_popup_model" role="document">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="cover-container login-cover">

                    

                    <div class="inner cover desktop_login">
                        
                        <ul class="login_mobile_tabs">
                            <li><a class="active mbltabs" href="javascript:" rel='Login_to_account'>Login</a></li>
                            <li><a class="mbltabs" href="javascript:" rel='Create_a_new_account'>New account</a></li>
                        </ul>
                        
                       <div class="lign-left lign-left_img"></div>
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
        
        
       

<!-- forgot password -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<form method="post" name="forgotform" id="forgotform" onSubmit="">
  <div class="modal-dialog success_message_pop" role="document">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <div class="modal-content">
        <div class="modal-body full-width-con addmoneywallet"><form class="bid_amount_popip" method="post">
        <div class="addmoney"> 
            <h2><?php echo $this->lang->line('forgot_your_password'); ?></h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
            <div class="moneyinput">
                <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('email'); ?>" name="username" id="username" autocomplete="off"> 
                <button class="ask-que-btn addmoney-btn" type="submit"><?php echo $this->lang->line('reset_my_password'); ?></button> 
            </div>
            </div>
            </form>
        </div>
            
        </div>
  </div>
    </form>
</div>
          
    
    
    
    <!-- Winners Slider Model -->

<a class="winner_pop_main " href="#" data-toggle="modal" data-target="#myModal2" data-dismiss="modal">Winners</a>
<!--<a class="winner_pop_main_mob" href="winners.php" data-dismiss="modal">Winners</a>-->
        
        

    

    
    
<!-- forgot password -->
<div class="modal" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <?php if(!empty($winners['data'])){
	// reset($winners['data']); $first_key = key($winners['data']);
	  $latestWinner=$winners['data'];
//	echo '<pre>';print_r($winners['data'][$first_key]);exit;
  ?>

    
    <div class="modal-dialog winner_model_main" role="document">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <div class="modal-content container_main1    ">
       <div class="winners_slider">
 
    <div class="" id="container">
        <ul>
         <?php  $t=0; foreach($latestWinner as $key=>$winnersArr)  { ?> <?php foreach($winnersArr as $winner){?> 
            <li>
               <div class="winner_slider_avatar">
              <?php if($winner['user_pic']==''){?><img src="<?php echo base_url()?>css/img/avatar.jpg"><?php }else{?><img src="<?php echo base_url().$winner['user_pic']?>"><?php }?>
                </div>
                <div class="winner_silder_name">
                    <h4><?php echo $winner['winnername']?></h4>
                    <span><?php echo $winner['winning_position']?> Winner</span>
                </div>
                <div class="winner_says"><p><?php echo $winner['comment']?></p><input type="button" value="<?php echo $winner['winning_amount']?>"></div>
          </li>
            <?php $t++;} } ?>
            <img class="left control_winners" src="http://www.jqueryscript.net/demo/Simplest-3D-Image-Carousel-Plugin-For-jQuery-Carousel-js/img/left.png">
            <img class="right control_winners" src="http://www.jqueryscript.net/demo/Simplest-3D-Image-Carousel-Plugin-For-jQuery-Carousel-js/img/right.png">
        </ul>
    </div>
</div>
  <?php }  ?>
</div>
    </div>
        </div>
          
    
    
    
    
    
    
    
    