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
                            <table>
                            <tr>
                            <th>Transaction Id</th>
                             <th>Account Type</th>
                             <th>Transaction Type</th>
                             <th>Amount</th>
                              <th>Status</th>
                              <th>Transaction Date</th>
                            </tr>
                            <?php  if(!empty($transactionsList)){               
			                  foreach($transactionsList as $key=>$transaction)
			                 { ?>
                              <tr>
                             <td><?php echo $transaction['txn_uid']?></td>
                             <td><?php echo $transaction['user_type']?></td>
                             <td><?php echo $transaction['txn_type']?></td>
                             <td><?php echo $transaction['amount']?></td>
                              <td><?php echo $transaction['status']?></td>
                              <td><?php echo $transaction['created_at']?></td>
                            </tr>
                            <?php }} ?>
                            
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