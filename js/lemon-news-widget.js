jQuery.noConflict();
jQuery(document).ready( function($){
	$(".lemon-news").on('submit', function(e) {
		e.preventDefault();

		var $email = $(this).children(".lemon-news-email");
		var $nonce = $(this).children(".lemon-news-nonce");
		var $feedback = $(this).siblings(".lemon-news-feedback");

		var data = {
			action: 'submit_lemon_news',
			email: $email.val(),
			nonce: $nonce.val()
		};

		$.post(ajax_object.ajax_url, data, function(response){

			var json = $.parseJSON(response);

			$feedback.addClass(json.cssClass).html(json.message);
			$email.val("");

			setTimeout(function() {
				$feedback.removeClass(json.cssClass).html('');
			}, 3000);

		});

	});
});