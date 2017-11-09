<div class="full-width-con addmoneywallet">
            <div class="container">
                <div class="row">
                    <div class="addmoney add_test">
                        <h2>Add Testimonial</h2>
                      
                        <form action="" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $this->session->userdata('USER_NAME')?>" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" required>
                            </div>
                            <?php /*?><div class="form-group">
                                <input type="upload" class="form-control" id="exampleInputPassword1" placeholder="File Upload">
                            </div><?php */?>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Message" id="message" name="message" required></textarea>
                            </div>
                            <button class="ask-que-btn addmoney-btn add-testmon" type="submit">SEND</button>
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>