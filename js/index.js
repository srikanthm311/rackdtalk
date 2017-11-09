

$(function(){
	
	
	 $(document).on("click", '.commentButton', function() { 
	    var question_id=$(this).attr('rel');
		var type=$(this).data('type');
        var commentid=$("."+type+"-"+question_id);
		if(commentid.val()!='')
		{
		     $.ajax({
			  url: insertCommentUrl,
			  type: 'POST',
			  data:  'q='+question_id+'&text='+commentid.val(),
			  dataType: "json",
			  success: function(response)
			  {
				   if(response.success=='success')
				   { 
					 // $(".commentSystem-"+type+'-'+question_id).append(response.message);
					  $(".newcommentSystem-"+type+'-'+question_id).append(response.html);
					 commentid.val('');	
					 $('#notifyModal').find(".mynotify").html(response.message); 
					 $('#notifyModal').modal('show'); 
					 
				   }else{alert(response.message); commentid.val('');	}
			  }
             });
		}
		
		
    }); 
	
     $(document).on("click", '.newcomm', function() { 
	    var val = parseInt($(this).text(), 10);
	    var com_id=$(this).attr('rel');
		var type=$(this).attr('rel1');var question=$(this).attr('rel2');
		var comID=$(this).attr('id');
		$.post(insertLikeUrl, {type:type,q:com_id,question:question},function(data)
        {
            if(data==1)
            {
               // $("#lstatus").html("Liked Sucessfully!!");
                val = val+1;
                $("#"+comID).text(val);
                $(this).attr("disabled", "disabled");
            }
            else
            {
               // $("#lstatus").html("Already Liked!!");
            }
        })
		
    }); 
	
 $(document).on("change", '#bidamount', function() {
	 
	 if(parseInt($(this).val())<parseInt($('#minval').val()))
	 $(this).val($('#minval').val());
	  
 }); 
 
 $(document).on("click", '.whatsapp', function() {
   // if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		var article = $(this).attr("data-text");
		var weburl = $(this).attr("data-link");
		var whats_app_message = encodeURIComponent(article)+" - "+encodeURIComponent(weburl);
		var whatsapp_url = "whatsapp://send?text="+whats_app_message;
		window.location.href= whatsapp_url;
   // }else{
	   // alert('you are not using mobile device.');
                   // }
 });
 
 
              
});	


function addBidonComment(cid)
{
	 var html='<form class="bid_amount_popip" method="post"><input type="hidden" name="minval" id="minvalf"/><input type="hidden" name="comment_id" value="'+cid+'"><div class="addmoney"> <h2>Bid On Comment</h2> <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is simply dummy text of the printing and typesetting industry</p><div class="moneyinput"><input type="text" class="form-control" placeholder="Bid Amount" name="amount" id="bidamountf" autocomplete="off"/> <button class="ask-que-btn addmoney-btn" type="submit">Bid</button> </div></div></form>';
	 
	 	 $.ajax({
			  url: getHighestBidAmountByCommentUrl,
			  type: 'POST',
			  data:  'q='+cid+'&pageKey='+pageKey,
			  dataType:'json',
			  success: function(response)
			  {
				   if(response.amount)
				   { 
					$('#notifyModal').find(".modal-body").html(html); console.log(response.amount);
					$('#bidamountf').val(response.amount);$('#minvalf').val(response.amount);
					$('#notifyModal').modal('show');
					
				   }
			  }
             }); 
}
 $(document).on("submit", '.bid_amount_popip', function(e) {
	e.preventDefault();
        $.ajax({url: addBidonCommentUrl, type: 'POST',data:$('.bid_amount_popip').serialize(),  dataType:'json',
			  success: function(response)
			  {
				   if(response.message)
				   { 
					  $('#notifyModal').modal('show'); $('#notifyModal').find(".modal-body").addClass('bidsuc').html(response.message);
				   }
			  }
             }); 	
}); 


function addReport(cid)
{
	   $.ajax({url: addReportOnCommentUrl, type: 'POST', data:  'q='+cid+'&pageKey='+pageKey, dataType:'json',
			  success: function(response)
			  {
				   if(response.success=='success')
				   { 
					  $('#notifyModal').modal('show'); $('#notifyModal').find(".modal-body").addClass('bidsuc').html(response.message);
					  $('#report-'+cid).text('Reported');$('#report-'+cid).prop('onclick',null).off('click');
				   }
			  }
             }); 	
}


function openPanel(id,type)
{
	 
	   
	  
	    //$(".commentSystem-"+type+'-'+qarr[1]).hide();
		if(!($('#'+id).hasClass('clickdone')))
		{
	        var qarr=id.split('-');
	        $(".newcommentSystem-"+type+'-'+qarr[1]).html('<span class="hidecomment" onclick="closePanel(\''+id+'\')">'+hidetxt+'</span>').addClass('cmloading');
			 var x = document.getElementById(id);
			 $('#'+id).show();$('#'+id).addClass('clickdone');
			 $.ajax({
			  url: getCommentsByQuestionUrl,
			  type: 'POST',
			  data:  'q='+qarr[1]+'&pageKey='+pageKey,
			  success: function(response)
			  {
				   if(response)
				   { 
					$(".newcommentSystem-"+type+'-'+qarr[1]).removeClass('cmloading'); $(".newcommentSystem-"+type+'-'+qarr[1]).append(response);
					// $(".commentSystem-"+type+'-'+qarr[1]).show();
				   }else
				   {
					   alert(response);
				   }
			  }
             }); 
		}
	   
}

function closePanel(id)
{
	 $('#'+id).removeClass('clickdone').hide();
}

function showpopup(id,type)
{
            
			 $.ajax({
			  url: commentFormUrl+'/'+id,
			  success: function(response)
			  {
				   if(response)
				   { 
					 $('#myModal1').find(".modal-body").html(response); $('#myModal1').modal('show'); $('.'+type+'-'+id).val("");
				   }else
				   {
					   alert(response);
				   }
			  }
             }); 
	
}

$(document).ready(function(){
	$('.mbltabs').click(function(){ 
	$('.mbltabs').removeClass('active');
	$(this).addClass('active');
	 var tab=$(this).attr('rel');	
	 $('.lign-left').hide();
	 $('.'+tab).show();
	});

	}); 
	
	