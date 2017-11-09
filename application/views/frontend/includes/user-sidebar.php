<div class="user bnt-my">      
    <a href="<?php echo base_url()?>main/addFunds" class="<?php echo ($this->router->fetch_method()=='addFunds')?'active':'';?>"><?php echo $this->lang->line('add_money'); ?></a>
    <a href="<?php echo base_url()?>my-account.html" class="<?php echo ($this->router->fetch_method()=='profile')?'active':'';?>"><?php echo $this->lang->line('my_questions'); ?></a>
    <a href="<?php echo base_url()?>my-commented-questions.html" class="<?php echo ($this->router->fetch_method()=='my_comments')?'active':'';?>"><?php echo $this->lang->line('my_commented_questions'); ?></a>
    <a href="<?php echo base_url()?>my-bidded-questions.html" class="<?php echo ($this->router->fetch_method()=='my_bidding')?'active':'';?>"><?php echo $this->lang->line('my_bidded_questions'); ?></a>
    <a href="<?php echo base_url()?>my-transactions.html" class="<?php echo ($this->router->fetch_method()=='my_transactions')?'active':'';?>"><?php echo $this->lang->line('my_transactions'); ?></a>
    <a href="<?php echo base_url()?>my-withdraw.html" class="<?php echo ($this->router->fetch_method()=='my_withdraw')?'active':'';?>"><?php echo $this->lang->line('money_withdraw'); ?></a>
    <?php if(!empty($mywins)) { ?>
     <a href="<?php echo base_url()?>my-wins.html" class="<?php echo ($this->router->fetch_method()=='mywins')?'active':'';?>">My Wins</a>
    <?php } ?>
</div>