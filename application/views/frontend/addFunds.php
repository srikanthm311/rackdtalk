
   <form class="addmoney_container" method="post" enctype="multipart/form-data" name="postqform" id='postqform' action="<?php echo base_url()?>main/addFunds">
<div class="addmoney addmoneyone">
                        <h2>Add Money to Wallet</h2>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                        
                        <div class="moneyinput">
                            <input type="text" class="form-control" placeholder="Enter Amount" name="amount" required onkeypress="return isNumber(event)">
                            <button class="ask-que-btn addmoney-btn" type="submit">Add Money</button>
                        </div>
                        
                    </div>
                    
                    </form>
                    
                    <script>
					function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
					</script>