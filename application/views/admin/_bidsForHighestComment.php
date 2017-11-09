<div class="bidding_form_div">
<h2>Total bid Amount: <?php echo $totalBidAmt;?></h2>
<h3> Biddding Form</h3>
<form name="bidding_form" action="<?php echo base_url()?>adminquestions/bidding_update" method="post">
<input type="hidden" value="<?php  echo $comment_id;?>" name="comment_id"/>
<input type="hidden" name="qid" value="<?php echo $question_id?>" ID="qid">

<table>
  <tr>
    <th>Name</th>
    <th>Amount</th>
    <th>Position</th>
      <th>Winning Prize</th>
  </tr>
  <?php if(!empty($bids))

				 {?>
  <?php $i = 1; foreach($bids as $bid){ ?>
  <tr>
  <input type="hidden" name="user_id[<?php echo $bid['user_id'];?>][user_id]" value="<?php echo $bid['user_id'];?>" />
    <td><?php echo $bid['useremail'];?></td>
    <td><?php echo $bid['amount'];?></td>
    <td>
    <select name="user_id[<?php echo $bid['user_id']?>][position]" id="bidding_select_<?php echo $i;?>">
    <option value='' >Selete Position</option>
    <?php $i = 1; while($i<=$bids_count){?>
  	<option value="<?php echo $i;?>" <?php echo ($bid_winners[$bid['user_id']]['winning_position'] == $i)?'selected':''?>><?php echo $i;?> position</option>
    <?php $i++; }?>
    </select></td><td>
    <input type="text" class="form-control form-shadow" name="user_id[<?php echo $bid['user_id']?>][wng_amt]" id="winning_amt" placeholder="Enter prize Amount" value="<?php echo $bid_winners[$bid['user_id']]['winning_amount']?>"></td>
  </tr>
  <?php $i++;}?>
</table>
<input class="btn-style-rev" type="submit" value="submit" class="btn btn-success">
</form>
<?php }else{?>
					 <tr ><td colspan="9" style="text-align:center">No records found</td></tr>

				<?php  }

                 ?>
</div>