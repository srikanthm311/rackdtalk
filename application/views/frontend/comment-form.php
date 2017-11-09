<div class="full-width-con addmoneywallet">
            <div class="container">
                <div class="row">
                    <div class="addmoney add_test">
                        <h2>Post Your Comment</h2>
                        <?php if($this->session->flashdata('message')!='') echo  $this->session->flashdata('message');?>
                        <form method="post" enctype="multipart/form-data" name="postqform" id='postqform' action="<?php echo base_url()?>main/comment_form">
                            <input type="hidden" value="<?php echo $question_id; ?>" id="question_id"  name="question_id">
                            <div class="form-group">
                                <textarea class="form-control" rows="3" id="description" placeholder="Description" name="description" required></textarea>
                            </div>
                            <button class="ask-que-btn addmoney-btn add-testmon" type="submit">Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        

