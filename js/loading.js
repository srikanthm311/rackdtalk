		function setCouponHeight()
		{
			var h2_offer_name_height = 0;
			$("#messages-list div.offer-name h2").each(function(index, element) {
				console.log($(this).height());
				if( h2_offer_name_height < $(this).height())
					h2_offer_name_height = $(this).height();
			});
			$("#messages-list div.offer-name h2").each(function(index, element) {
				$(this).height(h2_offer_name_height + 'px');
			});	
		}
	var total_pages	=	totalpages;
	//alert(total_pages);
	var contoller	=	'main';
	var method		=	'index';
	var param1		=	'BRANDED-FOOD';
	var param2		=	'0';
	var param3		=	pageKey;
    var param4		=	category_id;
	//alert(method);

	if(method== 'index' && param2 == 0){
		var callMethod = 'get_view_data';
	}
	
	//variable initialization 
	var current_page	=	1;
	var loading			=	false;
	var oldscroll		=	0;
	
	$(document).ready(function(){
		
		/* Get Category Records & Every First Call This Function Start Here*/		
		$.ajax({
			'url':base_url+contoller+'/'+callMethod,
			'type':'post',
			'data': 'p='+current_page+'&parameters='+param2+'&param3='+param3+'&param4='+param4,
			success:function(data){
				var data	=	$.parseJSON(data);
				$(data.html).hide().appendTo('#messages-list').fadeIn(1000);	
				if((total_pages ==1)) {
					$('#hidden_button_mobile').hide();
				}else{
					$('#hidden_button_mobile').show();
				}					
				current_page++;	
				setCouponHeight();
			}
		});
		/* Get Category Records & Every First Call This Function End Here*/		
		
		/* Scroll Down Category Data Div Load Start Here */
		$(window).scroll(function() {

			if( $(window).scrollTop() > oldscroll ){ //if we are scrolling down

			  if( ($(window).scrollTop() + $(window).height() >= $(document).height()-1000  ) && (current_page <= total_pages) && current_page <= 4) {

					  if( ! loading ){
						   
							loading = true;
							$('#messages-list').addClass('loading');

							$.ajax({
								'url':base_url+contoller+'/'+callMethod,
								'type':'post',
								'data': 'p='+current_page+'&parameters='+param2+'&param3='+param3+'&param4='+param4,
								success:function(data){
									var data	=	$.parseJSON(data);
									//alert(data);
									$(data.html).hide().appendTo('#messages-list').fadeIn(1000);
									current_page++;
									$('#messages-list').removeClass('loading');
									loading = false;
									setCouponHeight();
								}
							});	
							
					   }
				}
			  if( ($(window).scrollTop() + $(window).height() >= $(document).height()-1000  ) && (current_page <= total_pages) && current_page > 4) {

					  if( ! loading ){
						   
							loading = true;
							$('#hidden_button').show();
							$('#hidden_button_mobile').hide();
							hidden_button_id.onclick = function(){
								$('#messages-list').addClass('loading');
							$.ajax({
								'url':base_url+contoller+'/'+callMethod,
								'type':'post',
								'data': 'p='+current_page+'&parameters='+param2+'&param3='+param3+'&param4='+param4,
								success:function(data){
									var data	=	$.parseJSON(data);
									//alert(data);
									$(data.html).hide().appendTo('#messages-list').fadeIn(1000);
									current_page++;
									$('#messages-list').removeClass('loading');
									loading = false;
									setCouponHeight();
								}
							});	
							}
							
					   }
				}
			  if( ($(window).scrollTop() + $(window).height() >= $(document).height()-1000  ) && (current_page > total_pages)) {
					$('#hidden_button').hide();
			   }				
			}
		});	
			hidden_mobile_button_id.onclick = function(){
			  if((current_page <= total_pages)) {

					  if( ! loading ){
						   $('#hidden_button').hide();
							loading = true;
								$('#messages-list').addClass('loading');
							$.ajax({
								'url':base_url+contoller+'/'+callMethod,
								'type':'post',
								'data': 'p='+current_page+'&parameters='+param2,
								success:function(data){
									var data	=	$.parseJSON(data);
									//alert(data);
									$(data.html).hide().appendTo('#messages-list').fadeIn(1000);
									current_page++;
									$('#messages-list').removeClass('loading');
									  if((current_page > total_pages)) {
											$('#hidden_button_mobile').hide();
									   }										
									loading = false;
									setCouponHeight();
								}
							});
							
					   }
				}		
			}			
		
		/* Scroll Down Category Data Div Load Start Here */
	});	