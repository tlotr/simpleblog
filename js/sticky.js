$(document).ready(function(){
	$(window).scroll(function(){
		var scrollTop = 100;
		if($(window).scrollTop() >= scrollTop){
			$('.nav').css({
				position : 'fixed',
				top : '0'
			});
		}
		if($(window).scrollTop() < scrollTop){
			$('.nav').removeAttr('style');	
		}
	})
})