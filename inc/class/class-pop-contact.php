<?php 
/**
 * @version    1.2
 * @package    PopForms
 * @author     Themelooks <support@themelooks.com>
 *
 * Websites: http://www.themelooks.com
 *
 */


class pop_contact {
	
	public $to;	
	
	public function contact_form_data( $form_data ) {
		
		$name = $form_data['cont_name'];
		$form = $form_data['cont_email'];
		$subject = $form_data['cont_subject'];
		$message = $form_data['cont_message'];
		$file_url = $form_data['file_url'];
		
        
		$uploads_url = strstr( $file_url, 'uploads' );
		$attachments = array( WP_CONTENT_DIR .'/'.$uploads_url );
        
		

		$headers = "";
		$headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-Type: text/html; charset=UTF-8";
        $headers .= "From: " .$name.' <'.$form.'>';

		$mail = wp_mail( $this->to, $subject, $message, $headers, $attachments );

		
		if( $mail ) {
			return true;
		}else{
			return false;
		}
             

	}
    
    function popforms_toemail( $email ) {
        
        $this->to = $email;
        
    }


}