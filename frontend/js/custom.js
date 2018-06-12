/*
  Project Name : Donate
  Author Company : Ewebcraft
  Project Date: 4 May, 2016
  Author Website : http://www.ewebcraft.com
  Author Email : ewebcraft@gmail.com
*/

(function($) {
	"use strict";
	
	$(window).load(function(){
    	$('#loader-container').fadeOut("slow");
	});
	
	new WOW().init();

	$('.navbar-collapse a').click(function (e) {
        $('.navbar-collapse').collapse('toggle');
    });
	
	// pretty photo function call
	$("a[data-gal^='prettyPhoto']").prettyPhoto({
		hook: 'data-gal',
		social_tools:false
	});
	
	/*Progressbar*/
	jQuery('.skillbar').each(function(){
		jQuery(this).appear(function() {

		jQuery(this).find('.skillbar-bar').animate({
			width:jQuery(this).attr('data-percent')
		},1000);
		
		jQuery(this).find('.skill-bar-percent').animate({
			left:jQuery(this).attr('data-percent')
		},1000);
		});	
	});
	
	/*scroldown smothly*/
	// handle links with @href started with '#' only
	$(document).on('click', 'a[href^="#"]', function(e) {
		// target element id
		var id = $(this).attr('href');
	
		// target element
		var $id = $(id);
		if ($id.length === 0) {
			return;
		}
	
		// prevent standard hash navigation (avoid blinking in IE)
		e.preventDefault();
	
		// top position relative to the document
		var pos = $(id).offset().top;
	
		// animated top scrolling
		//$('body, html').animate({scrollTop: pos});
	});
	
	/* Stat Counter */
	$(".stat_counter").each(function() {
		  $(this).data('count', parseInt($(this).html(), 10));
		  $(this).html('0');
		  count($(this));
		  speed: 100 // how long it should take to count between the target numbers
	});
	function count($this){
		var current = parseInt($this.html(), 10);
		current = current + 1; /* Where 50 is increment */	
		$this.html(++current);
		if(current > $this.data('count')){
			$this.html($this.data('count'));
		} else {    
			setTimeout(function(){count($this)}, 10);
		}
	}
	
	$("#testimonial-slider").owlCarousel({
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:false,
		center: true,
		loop:true,
		pagination : true,
		responsiveClass:true,
		responsive:{
			0:{
				items:1,
			},
			767:{
				items:1,
			},
			800:{
				items:3,
			}
		}		
	});

	$("#help-carousel").owlCarousel({
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:false,
		margin:50,
		nav: true,
		navText: [
        "<i class='fa fa-chevron-left'></i>",
        "<i class='fa fa-chevron-right'></i>"],
		// center: true,
		// loop:true,
		pagination : false,
		dots: false,
		responsiveClass:true,
		responsive:{
			0:{
				items:1,
			},
			767:{
				items:1,
			},
			800:{
				items:5,
			}
		}		
	});
	$("#project-carousel").owlCarousel({
		autoplay:false,
		autoplayTimeout:5000,
		autoplayHoverPause:false,
		margin:50,
		nav: true,
		navText: [
         "<i class='fa fa-chevron-left'></i>",
        "<i class='fa fa-chevron-right'></i>"],
		// center: true,
		// loop:true,
		pagination : false,
		dots: false,
		responsiveClass:true,	
		responsive:{
			0:{
				items:1,
			},
			767:{
				items:1,
			},
			800:{
				items:5,
			}
		}		
	});
	
})(jQuery);