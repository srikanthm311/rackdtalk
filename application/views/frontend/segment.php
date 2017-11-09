<div class="container login-main profile_contianer">

            <div class="site-wrapper-inner">
              <form method="post" >
                <div class="cover-container login-cover myprofile segment">
                  <? foreach(array_chunk($categoryList, 6) as $category ) { ?>
                    
                    <div class="row">
                     <?php foreach($category as $list){ ?>
                        <div class="col-md-3">
                            <div class="segment_main_con">
                                <div class="segment_img"> <a href="<?php echo base_url().'main/segment/'.$list['id']?>"><img src="<?php echo ($list['image']!='')?base_url().$list['image']:''?>" /></a></div>
                                <div class="segment_content">
                                   <h5> <a href="<?php echo base_url().'main/segment/'.$list['id']?>"><?php echo $list['category_name']?></a></h5>
                                </div>
                            </div>
                            
                        </div>
                     <?php }?>       
                        
                    </div>
                    
                  <div class="devider"></div>
                    
               <?php }?>     
                    

            </div>
             </form>
        </div>



 <script type="text/javascript">

$(document).ready(function(){
$('input[type=radio]').on('change', function() {
    $(this).closest("form").submit();
});
});
</script>	
	