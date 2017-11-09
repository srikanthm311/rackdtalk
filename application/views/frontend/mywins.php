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
                            <th>Id</th>
                             <th>Comment</th>
                             <th>Question</th>
                             <th>Win As</th>
                              <th>Winning Poition</th>
                              <th>Winning Amount</th>
                              <th>Winning Date</th>
                            </tr>
                            <?php  $sno=0;if(!empty($mywins)){               
			                  foreach($mywins as $key=>$mywin)
			                 { ?>
                              <tr>
                             <td><?php echo ++$sno?></td>
                             <td><?php echo $mywin['comment']?></td>
                              <td><?php echo $mywin['question']?></td>
                             <td><?php echo ($mywin['winner_type']=='bid')?'Rocker':'Talker';?></td>
                             <td><?php echo $mywin['winning_position']?></td>
                             <td><?php echo $mywin['winning_amount']?></td>
                              <td><?php echo $mywin['created_at']?></td>
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