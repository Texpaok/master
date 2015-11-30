/* 
	Messages.js 
	Based on: Responsive Scroll Triggered Box
	jQuery plugin v1.3.2
*/

var joommark = jQuery.noConflict();

(function($) {

	/* jQuery Pageleave */
	!function(a){function c(){a(b.container).on("mousemove.pageleave",function(a){var c=(new Date).getTime()-start;a.clientY<=b.limitY&&a.clientX<=b.limitX&&c>=b.timeTillActive&&(times>0&&times--,"function"==typeof b.callback?b.callback.call(this):d())})}function d(){a(b.container).trigger("pageleave"),0==times&&a(b.container).off("mousemove.pageleave")}var b=times=start=null;a.fn.pageleave=function(d){b=a.extend({},a.fn.pageleave.defaultOptions,d),times=b.times,start=(new Date).getTime(),c()}}(jQuery),$.fn.pageleave.defaultOptions={container:document,limitX:screen.width,limitY:5,timeTillActive:100,times:1,callback:null};
	
	

	$(window).load(function() {
		
		function read_cookie(key)
		{
			var result;
			return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? (result[1]) : null;
		}

		// Get the percentage to which the window will be showed 
		var message = $(".joommark-percentage").last();
		var percentage = message.data("percentage");
		
		// Get the message id
		var message = $(".joommark-id").last();
		var id = message.data("id");
		var message_id = "joommark_message_" + id;
					
		// It should be shown on page load
		if ( percentage != 0 ) {
				
			// Let's get some needed Heights
			var windowHeight = $(window).height();
			var documentHeight = $(document).height();
				
			// Get the current percentage
			var triggerPercentage = parseInt(percentage, 10) / 100
			triggerHeight = (triggerPercentage * documentHeight);
				
			var timer = 0;
			// Check if the message has been shown. This will prevent to show the message every time the percentage is reached if the user close the window and still navigating in the page
			var launched = false;
						
			if (triggerHeight) {
					var scrollCheck = function() {
						if (timer) {
							clearTimeout(timer);						
							
						}
			
					timer = window.setTimeout(function () {
							var scrollY = $(window).scrollTop();
							var triggered = ((scrollY + windowHeight) >= triggerHeight);
							
							if (triggered && !launched) {
								//alert(triggered);
								// Check if the cookie exists
								var cookieExists = read_cookie(message_id);
								if ( !cookieExists ) {
									$("#Joommark_modal").modal('show');	
									launched = true;									
								}
								
							} 
						}, 100);
					};

					$(window).bind('scroll', scrollCheck);
			}		
		} else {
			// Show the message on page load
			$("#Joommark_modal").modal('show');
		}			
	});
}(joommark));