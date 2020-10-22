function updatePageStyle(){
	var mainNavHeight = $('#mainNav').height();
	var mainNavOuterHeight = $('#mainNav').outerHeight();

	$('body').attr('style', 'padding-top:'+mainNavOuterHeight+'px');

	//$('#headline-slide').ready();
	var headlineSlideHeight = $('#headline-slide').height();
	///$('#headline1').attr('style', 'height:'+headlineSlideHeight+'px');
}
$(function(){
	updatePageStyle();
	$(window).resize(function(){ updatePageStyle(); });

	//$('#headline-slide .carousel-indicators li').on('mouseover', function(){ $(this).trigger('click'); });

	$(document).on('click', function(e){
		if(!$(e.target).is("#mobileSearchBoxInput")){
			$('#mobileSearchBox').removeClass('d-flex').addClass('d-none');
		}
	});

	$('a#mobileSearchButton').on('click', function(){
		if($('#mobileSearchBox').hasClass('d-none')){
			$('#mobileSearchBox').removeClass('d-none').addClass('d-flex');
			$('#mobileSearchBox input').focus();
		}else{
			$('#mobileSearchBox').removeClass('d-flex').addClass('d-none');
			//$('#mobileSearchBox input').focus();
		}
		return false;
	});

	var mobileMenuOpen = false;
	$('a#mobileMenuButton').on('click', function(){
		if(mobileMenuOpen){
			$('#mobileMenu').stop().fadeOut(250);
			mobileMenuOpen = false;
		}else{
			$('#mobileMenu').stop().fadeIn(250);
			mobileMenuOpen = true;
		}
		return false;
	});
});

/*
$('.carousel').carousel({
  interval: 2000
})*/
