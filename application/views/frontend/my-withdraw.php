<style type="text/css">

table {
color: #333;
font-family: Helvetica, Arial, sans-serif;
width: 640px;
border-collapse:
collapse; border-spacing: 0;
}

td, th {
border: 1px solid transparent; /* No more visible border */
height: 30px;
transition: all 0.3s; /* Simple transition for hover effect */
}

th {
background: #DFDFDF; /* Darken header a bit */
font-weight: bold;
}

td {
background: #FAFAFA;
text-align: center;
}

/* Cells in even rows (2,4,6...) are one color */
tr:nth-child(even) td { background: #F1F1F1; }

/* Cells in odd rows (1,3,5...) are another (excludes header cells) */
tr:nth-child(odd) td { background: #FEFEFE; }

tr td:hover { background: #666; color: #FFF; } /* Hover cell effect! */
</style>
<div class="container login-main profile_contianer">

            <div class="">

                <div class="cover-container login-cover myprofile">

                    

                    <div class="inner cover">
                       <div class="mp-left">
                        
                           <div class="user">
                                <div class="user-img">
                                    <img src="<?php echo base_url()?>css/img/avatar.png">
                                    
                                </div>
                               
                           </div>
                           
                           <div class="user">
                               <h4><?php echo $this->session->userdata['USER_NAME'] ?></h4>
                               <?php /*?> <span>UI/UX Developer</span><?php */?>
                           </div>
                           
                          <?php $this->load->view('frontend/includes/user-sidebar');?>
                           
                        </div>
                       <div class="mp-right">
                           <div id="my_questions" class="my_profile_quesstions">
                        <div class="col-md-12 trending-left-main">
                        <div class="trending-left">
                            <div class="trending-left-inner">
                                <p><?php echo $pageHeading?></p>
                            </div>
                            <div id='messages-lists' class="table-responsive">
                            <p>Add Money to your Accout</p>
                            <form action='' method="post" id="withdraw_form">
                           <?php /*?><?php  echo ($this->session->flashdata('message'))?$this->session->flashdata('message'):'';?><?php */?>
                            <div class="form-group">
                                <label class="col-lg-2 control-label"><?php echo $this->lang->line('amount'); ?>:</label>
                                <div class="col-lg-10">
                                  <input class="form-control" type="text" name="w_amount" id="w_amount" placeholder="<?php echo $this->lang->line('amount'); ?>" pattern= "\d+"  title= "enter valid amount" required >
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label class="col-lg-2 control-label"><?php echo $this->lang->line('wallet_type'); ?>:</label>
                                <div class="col-lg-10">
                                  <div class="ui-select">
                                    <select class="form-control cities_drop" name="wallet_type" id="wallet_type" required>
                                     <option value=""> select wallet</option>
                                     	<option value="talker">Talker Wallet</option>
                                        <option value="rocker">Rocker Wallet</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-10">
                                  <input type="submit" class="with_dra_btn submit_with col-sm-3"  value="<?php echo $this->lang->line('save_changes'); ?>">
                                  <span></span>
                                  <input type="reset" class="with_dra_btn cancel_with col-sm-3 " value="<?php echo $this->lang->line('cancel'); ?>">
                                </div>
                              </div>
                            </form>
                            
                            <table>
                            <tr>
                            <th>S.No</th>
                             <th>Amount</th>
                              <th>Status</th>
                              <th>Withdrawal Date</th>
                            </tr>
                            <?php  if(!empty($withdrawList)){    $i = 1;            
			                  foreach($withdrawList as $key=>$withdraw)
			                 { ?>
                              <tr>
                             <td><?php echo $i;?></td>
                             <td><?php echo $withdraw['amount']?></td>
                              <td><?php echo $withdraw['status']?></td>
                              <td><?php echo $withdraw['created_at']?></td>
                            </tr>
                            <?php $i++;}}else{?>

					 <tr ><td colspan="9" style="text-align:center">No withdrawals Found</td></tr>

				<?php  }

                 ?>
                            
                            </table>
                           </div>
                               
               
                    </div>
                           
                           
                           
                           
                           
                           </div>
                        </div>
                       
                    </div>



                </div>

            </div>

        </div>


 </div>
