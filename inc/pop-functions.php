<?php
/**
 * @version    1.1
 * @package    PopForms
 * @author     Themelooks <support@themelooks.com>
 *
 * Websites: http://www.themelooks.com
 *
 */ 
 
// wp login redirect 
$logredi = get_option('popforms_option_name');
if( !empty( $logredi['poplogrediurl'] ) ) {
    add_action( 'login_redirect', 'popforms_login_redirect' );
}

function popforms_login_redirect( $redirect_to ) {
    $logredi = get_option('popforms_option_name');
    $redirect_to = home_url( $logredi["poplogrediurl"] );
    return $redirect_to;

}
function popforms_logo() {

    $logo = get_option('popforms_option_name');
    if( !empty( $logo['popform_logoup'] ) ):
?>
    <div class="mdl-card__title mdl-card--expand">
        <div class="modal--logo">
            <img src="<?php echo esc_url( $logo['popform_logoup'] ); ?>" alt="<?php esc_attr_e('logo','popforms'); ?>">
        </div>
    </div>
<?php
    endif; 
}

add_action('wp_head', 'popforms_color');
function popforms_color() {
    $color = get_option('popforms_option_name');
?>
    <style>
    /*------------------------------------*\
        COLOR
    \*------------------------------------*/
    #topNav2 a.navbar-brand span,
    .loginForm .mdl-card__actions a,
    .signupForm .mdl-card__actions a,
    .forgotForm .mdl-card__actions a,
    .mdl-button--accent.mdl-button--accent.mdl-button--fab, .mdl-button--accent.mdl-button--accent.mdl-button--raised {
        color: <?php echo !empty( $color['popforms_color'] ) ? $color['popforms_color'] : ''; ?>;
    }

    /*------------------------------------*\
        BACKGROUND COLOR
    \*------------------------------------*/
    #topNav2 .navbar-brand img,
    .banner-content a.mdl-button.mdl-button--accent,
    .loginForm .mdl-card__title .modal--logo,
    .signupForm .mdl-card__title .modal--logo,
    .forgotForm .mdl-card__title .modal--logo,
    .subscribeForm .mdl-card__title .modal--logo,
    .contactForm .mdl-card__title .modal--logo,
    .login-form-submit-btn.mdl-button.mdl-button--accent,
    .singup-form-submit-btn.mdl-button.mdl-button--accent,
    .forgot-form-submit-btn.mdl-button.mdl-button--accent,
    .subscribe-form-submit-btn.mdl-button.mdl-button--accent,
    .contact-form-submit-btn.mdl-button.mdl-button--accent,
    #loginForm input + label:after,
    #signupForm input + label:after,
    #forgotForm input + label:after,
    #subscribeForm input + label:after,
    #contactForm input + label:after,
    #contactForm textarea + label:after,
    #loginForm input.valid + label:after,
    #signupForm input.valid + label:after,
    #forgotForm input.valid + label:after,
    #subscribeForm input.valid + label:after,
    #contactForm input.valid + label:after,
    #contactForm textarea.valid + label:after,
    #open-switcher,
    #close-switcher,
    .mdl-button--accent.mdl-button--accent.mdl-button--fab, .mdl-button--accent.mdl-button--accent.mdl-button--raised {
        background-color: <?php echo !empty( $color['popforms_btncolor'] ) ? $color['popforms_btncolor'] : ''; ?> ;
    }

    /*------------------------------------*\
        BORDER COLOR
    \*------------------------------------*/
    #open-switcher,
    #close-switcher {
        border-color: <?php echo !empty( $color['popforms_btncolor'] ) ? $color['popforms_btncolor'] : ''; ?>;
    }
    </style>
<?php
}

// pop signup ajax
function popforms_ajax_signup(){

    $full_name = isset( $_POST['full_name'] ) ? sanitize_text_field( $_POST['full_name'] ) : '';
    $user_name = isset( $_POST['user_name'] ) ? sanitize_user( $_POST['user_name'] ) : '';
    $user_email = isset( $_POST['user_email'] ) ? sanitize_email( $_POST['user_email'] ) : '';
    $user_pass = isset( $_POST['user_pass'] ) ? sanitize_text_field( $_POST['user_pass'] ) : '';
    $retype_pass = isset( $_POST['retype_pass'] ) ? sanitize_text_field( $_POST['retype_pass'] ) : '';
    
    $error="";
    if( ! $full_name  ){
        $error .= esc_html__( 'Full name can not be empty.', 'popforms' ).'</br>';
    }
    if( ! $user_name  ){
        $error .= esc_html__( 'User name can not be empty.', 'popforms' ).'</br>';
    }
    if(! $user_email || !is_email( $user_email ) ){
        $error .= esc_html__( 'Please Input valid email address.', 'popforms' ).'</br>';
    }
    if( ! $user_pass  ){
        $error .= esc_html__( 'Password can not be empty.', 'popforms' ).'</br>';
    }
    
        $userdata = array(
            'user_login'    => apply_filters( 'pre_user_login', sanitize_user( $user_name ) ),
            'user_email'    => apply_filters( 'pre_user_email', sanitize_email( $user_email ) ),
            'user_pass'     => apply_filters( 'pre_user_pass', sanitize_text_field( $user_pass ) ),
            'first_name'    => apply_filters( 'pre_user_first_name', sanitize_text_field( $full_name ) ),
        );
    
    
    if( !$error ) {
		$insert = wp_insert_user( $userdata );		
    }
            
    if(!$insert){
        echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    }else{
		
		$option = get_option('popforms_option_name');

		if( !empty( $option['popforms_signupmailconf'] ) ){

			$to = $user_email;
			$sender = get_bloginfo('name');
			//
			if( !empty( $option['popforms_signupconfmess'] ) ){
				$message = $option['popforms_signupconfmess'];
			}else{
				$message = 'Your registration is successfully completed.';
			}
			//
			if( !empty( $option['popforms_signupmailfrom'] ) ){
				$frommail = $option['popforms_signupmailfrom'];
			}else{
				$frommail = 'Your registration is successfully completed.';
			}
			//
			if( !empty( $option['popforms_signupconfmailsub'] ) ){
				$subject = $option['popforms_signupconfmailsub'];
			}else{
				$subject = esc_html__( 'registration Confirmation', 'popforms' );
			}
			
			$headers[] = 'MIME-Version: 1.0' . "\r\n";
			$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers[] = "X-Mailer: PHP \r\n";
			$headers[] = 'From: '.$sender.' < '.$frommail.'>' . "\r\n";
			
			$mail = wp_mail( $to, $subject, $message, $headers );
		}
        echo '<div class="alert alert-success" role="alert">'.esc_html__( 'Your account has been created successfully.', 'popforms' ).'</div>';
    }

    die();
}
add_action( 'wp_ajax_pop_signup_form', 'popforms_ajax_signup' );
add_action( 'wp_ajax_nopriv_pop_signup_form', 'popforms_ajax_signup' );

// subscribe ajax function
function popforms_subscribe_form_ajax() {
    
    $mc_opt = get_option('popforms_option_name');
    $api = new POPMCAPIFORM( $mc_opt['popmcapi'] );
    
    $merge_vars = array('FNAME'=>'', 'LNAME'=>'');

    if( isset( $_POST['subscribe_sub'] ) ){
		
		if( !is_email( $_POST["subscribeEmail"] ) ) {
			echo '<div class="alert alert-danger" role="alert">'.esc_html__( 'Please set valid email address.', 'popforms' ).'</div>';
			die();
		}

        $retval = $api->listSubscribe( $mc_opt['popmclist'], sanitize_email( $_POST["subscribeEmail"] ), $merge_vars, 'html', false, true );

        if ($api->errorCode){
            echo '<div class="alert alert-danger" role="alert">'.esc_html__( 'Sorry something wrong. Please try again.', 'popforms' ).'</div>';

        }else {
            echo '<div class="alert alert-success" role="alert">'.esc_html__( 'Thank you, you have been added to our mailing list.', 'popforms' ).'</div>';
        }
        die();    
    }  
 
}

add_action('wp_ajax_popforms_subscribe_form_ajax', 'popforms_subscribe_form_ajax');
add_action('wp_ajax_nopriv_popforms_subscribe_form_ajax', 'popforms_subscribe_form_ajax');


// contact form function 
function popforms_contact_form_calback () {

    $obj = new pop_contact();

	$recap = get_option('popforms_option_name');
    
    $obj->popforms_toemail( $recap['poptoemail'] );
    
	if( isset( $_POST['popCont_sub'] ) ) {
        
        $is_ok = true;
        $error = "";
		if( empty( $_POST['contactName'] ) || empty( $_POST['contactEmail'] ) ){
			$error .= esc_html__( 'Name and email cannot be empty', 'popforms' ); 
			$error .= "</br>"; 
			$is_ok  = false;
        }
		if( !is_email( $_POST['contactEmail'] ) ){
			$is_ok  = false;
			$error .= esc_html__( 'Please set valid email address', 'popforms' ); 
		}
        if( !$_POST['g-recaptcha-response'] && $recap['captcha_active'] ){
          $is_ok  = false;
          $error .= esc_html__( 'Please check on captch', 'popforms' );          
        }
        
        if( $is_ok ){
            if( $recap['attachment_active'] ) {
                
                $file_name = $_FILES['contactFile'];
                if ( ! function_exists( 'wp_handle_upload' ) ) {
                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
                }
                
                $upload_overrides = array( 'test_form' => false );
                $file_url = wp_handle_upload( $file_name, $upload_overrides );
            
            }

            $form_data = array(
                'cont_name' 	=> isset( $_POST['contactName'] ) ?  sanitize_text_field( $_POST['contactName'] ) : '',
                'cont_email' 	=> isset( $_POST['contactEmail'] ) ? sanitize_email( $_POST['contactEmail'] ) : '',
                'cont_subject'  => isset( $_POST['contactSubject'] ) ? sanitize_text_field( $_POST['contactSubject'] ) : '',
                'cont_message'  => isset( $_POST['contactMessage'] ) ? sanitize_textarea_field( $_POST['contactMessage'] ) : '',
                'file_url'      => isset( $file_url['url'] ) ? esc_url_raw( $file_url['url'] ) : '',
            );
            
            
            $result = $obj->contact_form_data( $form_data  );

            if( $result == true ) {
               echo '<div class="alert alert-success" role="alert">'.esc_html__( 'Successfully Message send', 'popforms' ).'</div>';
               
            }else {
               echo '<div class="alert alert-danger" role="alert">'.esc_html__( 'Sorry Message send failed !!!. Try agin', 'popforms' ).'</div>';
            }
        }else{
            echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
        }     

		die();
	}
}

add_action('wp_ajax_popforms_contact_form_calback', 'popforms_contact_form_calback');
add_action('wp_ajax_nopriv_popforms_contact_form_calback', 'popforms_contact_form_calback');

// lost password
function popforms_lost_password() {
    
        global $wpdb;
        
        $error = '';
        $success = '';

          $email = isset( $_POST['user_login'] ) ?  sanitize_email( $_POST['user_login'] ) : '';
            
            if( empty( $email ) ) {
                $error = esc_html__( 'Enter a username or e-mail address..', 'popforms' );
            } elseif( ! is_email( $email )) {
                $error = esc_html__( 'Invalid username or e-mail address.', 'popforms' );
            } elseif( ! email_exists( $email ) ) {
                $error = esc_html__( 'There is no user registered with that email address.', 'popforms' );
            } else {
                
                $random_password = wp_generate_password( 12, false );
                $user = get_user_by( 'email', $email );
                
                $update_user = wp_update_user( array (
                        'ID' => $user->ID, 
                        'user_pass' => $random_password
                    )
                );
                
                // if  update user return true then lets send user an email containing the new password
                if( $update_user ) {
                    $to = $email;
                    $subject = esc_html__( 'Your new password', 'popforms' );
                    $sender = get_bloginfo('name');
					                    
                    $message = 'Your new password is: '.$random_password;
                    
                    $headers[] = 'MIME-Version: 1.0' . "\r\n";
                    $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers[] = "X-Mailer: PHP \r\n";
                    $headers[] = 'From: '.$sender.' < '.$email.'>' . "\r\n";
                    
                    $mail = wp_mail( $to, $subject, $message, $headers );
                    if( $mail )
                        $success = esc_html__( 'Check your email address for you new password.', 'popforms' );
                        
                } else {
                    $error = esc_html__( 'Oops something went wrong updaing your account.', 'popforms' );
                }
                
            }
            
            if( ! empty( $error ) )
                echo '<div class="alert alert-danger"><p class="error"><strong>'.esc_html__( 'ERROR:', 'popforms' ).'</strong> '. $error .'</p></div>';
            
            if( ! empty( $success ) )
                echo '<div class="alert alert-success"><p class="success">'. $success .'</p></div>';
            die();

}
add_action('wp_ajax_popforms_lost_password', 'popforms_lost_password');
add_action('wp_ajax_nopriv_popforms_lost_password', 'popforms_lost_password');
