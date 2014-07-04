$(document).ready(function(){ 
	
	$(".extra_info").hide();
	
	$('.link_skill').bind('click', function(){
		var currentId = $(this).attr('id');
		$("#info_number_"+currentId).toggle();
	});

			
	$(function() {
		$(".meter > span").each(function() {
			$(this)
				.data("origWidth", $(this).width())
				.width(0)
				.animate({
					width: $(this).data("origWidth")
				}, 1000);
		});

	function increase() {
		 $('.progress_bar').each(function() {
			var number=Number($(this).find('.hidden_value').val());
		
			$({someValue: 0}).animate({someValue: number}, {
				duration: 1000,
				easing:'swing', 
				step: function() { 
					$('.span_'+number).text(Math.ceil(this.someValue) + "%");
				}
			});
		});
		
		}
	increase();

	});
	
});
