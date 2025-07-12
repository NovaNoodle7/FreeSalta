
jQuery(document).ready(function($)
	{



		$(document).on('click', '#wcps_metabox .expandable .expand', function()
			{	
				if($(this).parent().parent().hasClass('active'))
					{
					$(this).parent().parent().removeClass('active');
					}
				else
					{
						$(this).parent().parent().addClass('active');
					}
				

			})




		$(document).on('click','.wcps_grid_items_reset',function(){
			
			if(confirm('Do you really want to reset ?')){
				wcps_id = jQuery(this).attr('wcps_id');
				
				//alert(wcps_id);
				
				
				jQuery.ajax(
					{
					type: 'POST',
					context:this,
					url: wcps_ajax.wcps_ajaxurl,
					data: {"action": "wcps_grid_items_reset","wcps_id":wcps_id},
					success: function(data)
							{	
								jQuery(this).html(data);
								window.location.reload();
							}
					});
				}

			

			})
			
			
			

		$(document).on('change', '#wcps_ribbon_name', function()
			{	
				value = $(this).val();
				
				if(value=='custom'){
					
					$('#wcps_ribbon_custom').css('display','block');
					}
				else{
					$('#wcps_ribbon_custom').css('display','none');
					
					}
				
	
				
			})





		$(document).on('click', '.wcps_content_source', function()
			{	
				var source = $(this).val();
				var source_id = $(this).attr("id");
				
				$(".content-source-box.active").removeClass("active");
				$(".content-source-box."+source_id).addClass("active");
				
			})

		
		$(".wcps_taxonomy").click(function()
			{
				
				

				var taxonomy = jQuery(this).val();
				
				$(".wcps_loading_taxonomy_category").css('display','block');

						jQuery.ajax(
							{
						type: 'POST',
						url: wcps_ajax.wcps_ajaxurl,
						data: {"action": "wcps_get_taxonomy_category","taxonomy":taxonomy},
						success: function(data)
								{	

									$(".wcps_taxonomy_category").html(data);
									$(".wcps_loading_taxonomy_category").fadeOut('slow');
								}
							});

		
			})
		
	
 		

	});	







