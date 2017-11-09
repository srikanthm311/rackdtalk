<div class="site-wrapper login-main">

            <div class="site-wrapper-inner">

                <div class="cover-container login-cover">

                    

                    <div class="inner cover">
                       <div class="lign-left">
                        
                        </div>
                       <div class="lign-left">
                        
                           
                           <div class="row login-main-form">
                               
                               <div class="col-md-12">
                                <h4>Login to account</h4>
                               </div>
                               
                              <div class="col-md-12"><span id='login-error'></span>
                               <form class="form login_form auth_form" action="<?php echo base_url()?>main/checkuser" method="post" role="form" id='login_form' >
                                    <div class="form-group">
                                       <label class="sr-only" for="lemail">User</label><span  class="Errtg" id="Errlemail"></span>
                                       <input type="text" class="form-control" name="user_name"  id="lemail"  placeholder="User Name" >
                                    </div>
                                    <div class="form-group">
                                       <label class="sr-only" for="lpassword">Password</label><span  class="Errtg" id="Errlpassword"></span>
                                       <input type="password" class="form-control" name="password" id="lpassword"  placeholder="Password" >
                                    </div>
                                    
                                    <div class="form-group">
                                       <button type="submit" class="btn btn-success btn-block login">Sign in </button>
                                    </div>
                                     
                                     <a href="#">Forgot your password</a>
                                     
                                     <div class="or">
                                        <span>or</span>
                                         <div class="line"></div>
                                     </div>
                                     
                                     
                                 </form>
                              </div>
                               
                               <div class="col-md-12">
                                   <button class="btn google" type="button" onclick="location.href = '<?php echo base_url()?>sociallogin/handle_google_login';" >Google Plus <i class="fa fa-google-plus-official pull-right" aria-hidden="true"></i></button>
                                   <button class="btn facebbok" type="button" onclick="location.href = '<?php echo base_url()?>sociallogin/facebook';" >Connect with Facebook <i class="fa fa-facebook-square pull-right" aria-hidden="true"></i></button>
                               </div>
                               
                           </div>
                      
                       
                           
                     
                           
                        </div>
                       <div class="lign-left">
                            <div class="row login-main-form">
                               
                               <div class="col-md-12">
                                <h4>Create a new account</h4>
                                </div>
                                  <div class="col-md-12">
                                    <form class="form signup_form auth_form" action="<?php echo base_url()?>main/register" method="post" role="form">
                                        <div class="form-group">
                                           <label class="sr-only" for="name">Name</label><span  class="Errtg" id="Errname"></span>
                                           <input type="text" class="form-control" id="name" name="name" placeholder="Name" required="">
                                        </div>
                                        
                                         <div class="form-group">
                                           <label class="sr-only" for="email">Email</label><span  class="Errtg" id="Erremail"></span>
                                           <input type="text" class="form-control" id="email" name='email'  placeholder="Email" required="">
                                        </div>
                                        
                                        <div class="form-group">
                                           <label class="sr-only" for="mobile">Mobile</label><span  class="Errtg" id="Errmobile"></span>
                                           <input type="text" class="form-control" id="mobile" name='mobile' placeholder="Mobile" required="">
                                        </div>
                                         
                                         <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="sr-only" for="age">Age</label><span  class="Errtg" id="Errage"></span>
                                                   <input type="text" class="form-control" name='age' id="age" placeholder="Age" required="">
                                                </div>
                                             </div>
                                             
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="sr-only" for="acard">Adhar Card</label><span  class="Errtg" id="Erracard"></span>
                                                   <input type="text" class="form-control" id="acard"  name='acard' placeholder="Adhar Card" required="">
                                                </div>
                                             </div>
                                         </div>
                                         
                                         <div class="form-group">
                                           <label class="sr-only" for="password">Password</label><span  class="Errtg" id="Errpassword"></span>
                                           <input type="password" class="form-control" id="password"  name='password'  placeholder="Password" required="">
                                        </div>
                                         
                                         <div class="form-group">
                                           <label class="sr-only" for="cpassword">Confirm Password</label><span  class="Errtg" id="Errcpassword"></span>
                                           <input type="password" class="form-control" id="cpassword" name='cpassword' placeholder="Confirm Password" required="">
                                        </div>

                                        <div class="form-group">
<?php /*?>                                           <button type="submit" class="btn btn-success btn-block login" onclick="FnPostContinue(this)">Sign in </button>
<?php */?>                                           <input type="button" value="Create My Account" class="btn btn-success btn-block login" onclick="FnPostContinue(this)">
                                        </div>

                                         
                                     </form>
                                  </div>
                               
                              
                               
                           </div>
                        </div>
                    </div>



                </div>

            </div>

        </div>