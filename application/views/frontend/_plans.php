
<div class="site-wrapper login-main">

            <div class="site-wrapper-inner">

                <div class="cover-container login-cover price-main">

                    

                    <div class="inner cover price">
                     <?php $p=0;foreach($plansList as $list){ ?>
                      <form method="post" enctype="multipart/form-data" name="postqform" id='postqform' action="<?php echo base_url()?>plans.html">
                         <input type="hidden" value="<?php echo $list['id']; ?>" id="planId"  name="planId">
                       <div class="price-left <?php echo ($p==1)?'gold-in':''?>">
                           <div class="price-left-in">
                                <div class="pricestand <?php echo ($p==1)?'gold':''?>">
                                    <div class="pricestand-in">
                                        <h4> <?php echo $list['subscription_name']; ?></h4>
                                        <div class="line1"></div>
                                        <p>For those who working hard</p>
                                        
                                        <span><?php echo $list['subscription_price']; ?>Rs</span>
                                    </div>
                                    
                                    <div class="price-devider"></div>
                                    <div class="pricestand-in pricestand-in-bootm">
                                        
                                        <p>Lorem Ipsum is simply dummy </p>
                                         <div class="line1 line2"></div>
                                        <p>Lorem Ipsum is simply dummy </p>
                                         <div class="line1 line2"></div>
                                        <p>Lorem Ipsum is simply dummy </p>
                                         <div class="line1 line2"></div>
                                    </div>
                                    
                                    <div class="pricestand-in">
                                        <button type="submit">Select</button>
                                    </div>

                                </div>
                           </div>
                           
                        </div>
                        </form> 
                      <?php ++$p;}?>
                        
                  <?php /*?>      <div class="price-left gold-in">
                           <div class="">
                                <div class="pricestand gold">

                                            <div class="pricestand-in">
                                                <h4>Gold</h4>
                                                <div class="line1"></div>
                                                <p>For those who working hard</p>

                                                <span>200$</span>
                                            </div>

                                            <div class="price-devider"></div>
                                            <div class="pricestand-in pricestand-in-bootm">

                                                <p>Lorem Ipsum is simply dummy </p>
                                                 <div class="line1 line2"></div>
                                                <p>Lorem Ipsum is simply dummy </p>
                                                 <div class="line1 line2"></div>
                                                <p>Lorem Ipsum is simply dummy </p>
                                                 <div class="line1 line2"></div>
                                            </div>

                                            <div class="pricestand-in">
                                                <button type="button">Select</button>
                                            </div>

                                   </div>
                           </div>
                           
                        </div>
                        
                      <div class="price-left">
                           <div class="price-left-in">
                                <div class="pricestand">
                                    <div class="pricestand-in">
                                        <h4>Start</h4>
                                        <div class="line1"></div>
                                        <p>For those who working hard</p>
                                        
                                        <span>50$</span>
                                    </div>
                                    
                                    <div class="price-devider"></div>
                                    <div class="pricestand-in pricestand-in-bootm">
                                        
                                        <p>Lorem Ipsum is simply dummy </p>
                                         <div class="line1 line2"></div>
                                        <p>Lorem Ipsum is simply dummy </p>
                                         <div class="line1 line2"></div>
                                        <p>Lorem Ipsum is simply dummy </p>
                                         <div class="line1 line2"></div>
                                    </div>
                                    
                                    <div class="pricestand-in">
                                        <button type="button">Select</button>
                                    </div>

                                </div>
                           </div>
                           
                        </div><?php */?>
                        
                    </div>



                </div>

            </div>

        </div>