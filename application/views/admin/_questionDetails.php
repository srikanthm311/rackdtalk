<?php if(is_array($question_detials) && count($question_detials)){ ?>

<h3>Question details</h3>

    <p>  Question :  <?=$question_detials['question'];?> </p>
     <p> Description : <?=$question_detials['description'];?></p>
   <p>  Comments  :<?php echo ($question_detials['question_comment_count'] != '')?$question_detials['question_comment_count']:'0';?></p>
    <p>  Likes  :   <?php echo ($question_detials['question_like_count'] != '')?$question_detials['question_like_count']:'0';?></p>
    <p> Dislikes : <?php echo ($question_detials['question_dislike_count'] != '')?$question_detials['question_dislike_count']:'0';?></p>
  <p>   Shares    : <?php echo ($question_detials['question_share_count'] != '')?$question_detials['question_share_count']:'0';?></p>
   <p>  Created At  : <?=$question_detials['created_at'];?></p>
     <h4> User Details : </h4>
    <p> User Name : <?=$question_detials['user_first_name'];?></p>
  <p> User Mobile : <?=$question_detials['user_mobile'];?></p>
   
    </tr>
  </tbody>
</table>
<?php }else{ ?>
<p>Invalid Question.</p>	
<?php } ?>
