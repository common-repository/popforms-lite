/*

[Core Script]

Project: PopForms - Material Design Modal Forms
Version: 1.1
Author : themelooks.com

*/

(function ($) {
	"use strict"; // this function is executed in strict mode
	
	$(document).ready(function () {
		 
		// upload image
        $('#upload_logo_button').click(function() {
            tb_show('Upload a logo', 'media-upload.php?referer=popforms-setting-admin&type=image&TB_iframe=true&post_id=0', false);
            return false;
        });
        
        window.send_to_editor = function(html) {
            var image_url = $('img',html).attr('src');
            $('#logo_url').val(image_url);
            tb_remove();
        }
		// color picker
		
	});
$('#popforms_btncolor,#popforms_color').wpColorPicker();
	
})(jQuery);