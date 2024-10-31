/*


Project: PopForms - Material Design Modal Forms
Version: 1.2
Author : themelooks.com

*/

(function ($) {
	"use strict"; // this function is executed in strict mode
	
	$(document).ready( function () {
		/* -------------------------------------------------------------------------*
		 * FORM VALIDATION
		 * -------------------------------------------------------------------------*/
         
		// ajax signup 
		
		$('#signupForm').on('submit', function(e){
			e.preventDefault();
            
			var $t = $(this),
                $abox = $t.siblings('.alert-box');
            
			var full_name= $('#singupName').val(),
				user_name= $('#singupUsername').val(),
				user_email= $('#singupEmail').val(),
				user_pass= $('#singupPassword').val(),
				conuser_pass= $('#singupPasswordAgain').val(),
                ajax_url = $('#popsingup-url').data('url');
			
			$.ajax({
				type: 'POST',
				url: ajax_url,
				data: {
					full_name:full_name,
					user_name:user_name,
					user_email:user_email,
					user_pass:user_pass,
					conuser_pass:conuser_pass,
					action:'pop_signup_form'
				},
				success: function (data) {
					$abox.html(data);
				},
				error: function (XMLHttpRequest,textstatus,errorThrown) {
					$abox.html( errorThrown );
				}
			});
		});
		
        
        // match password
        
        $('#singupPasswordAgain').keyup( function() {
            
            if($(this).val() == $('#singupPassword').val())
            {
                $('#error-show_tf').html('<div class="alert alert-success" role="alert">Passowrd Match</div>');
                
            }else{
                $('#error-show_tf').html('<div class="alert alert-danger" role="alert">Passowrd not match</div>');
            }
            
        });
        
        // ajax subscribe
		$('#subscribeForm').on('submit', function(e){
			e.preventDefault();
			
			var email = $('#subscribeEmail').val(),
                subscribe_sub = $('#subscribe_sub').val(),
                ajax_url = $('#subscribe-url').data('url');
            var $t = $(this),
               $abox = $t.siblings('.alert-box');
               
			$.ajax({
				type: 'POST',
				url: ajax_url,
				data: {
					subscribeEmail: email,
					subscribe_sub: subscribe_sub,
					action: 'popforms_subscribe_form_ajax'
				},
				success: function (data) {
                    $abox.html(data); 
				}
			});
		});
        
        // ajax lost password
		$('#forgotForm').on('submit', function(e){
			e.preventDefault();
			
			var email = $('#forgotEmail').val(),
            ajax_url = $('#forgot-ajax-url').data('url');

               
			$.ajax({
				type: 'POST',
				url: ajax_url,
				data: {
					user_login: email,
					action: 'popforms_lost_password'
				},
				success: function (data) {
                    $('.message').html(data); 
				}
			});
		});
        
        
        // ajax contactform
        $('#contactForm').on('submit', function (e) {
            e.preventDefault(); // prevent native submit
            
            var $t = $(this),
                $abox = $t.siblings('.alert-box'),
                ajax_url = $('#contact-ajax-url').data('url');
            
            $t.ajaxSubmit({
                url: ajax_url,
                type: 'POST',
                target: $abox
            });
        });
		
	});
    
})(jQuery);