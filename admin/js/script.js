function showValue(newValue)
{
	document.getElementById("rangevalue").innerHTML=newValue;
}

function confirmDelete(link) {
	if (confirm("Are you sure?")) {
		doAjax(link.href, "POST"); // doAjax needs to send the "confirm" field
	}
	return false;
}


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
	


