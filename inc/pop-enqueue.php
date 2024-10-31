<?php 
/**
 * @version    1.2
 * @package    PopForms
 * @author     Themelooks <support@themelooks.com>
 *
 * Websites: http://www.themelooks.com
 *
 */
 
function popforms_enqueue_script() {

$recap = get_option('popforms_option_name');


wp_enqueue_style( 'font-awesome', plugins_url( '../css/font-awesome.min.css', __FILE__ ), array(), '1.1.1' );
wp_enqueue_style( 'pop-style', plugins_url( '../css/pop-style.css', __FILE__ ), array(), '1.1.1' );

if( isset( $recap['script_load_boots'] ) ){
    
wp_enqueue_style( 'bootstrap', plugins_url( '../css/bootstrap.min.css', __FILE__ ), array(), '4.4.1' ); 

wp_enqueue_script( 'bootstrap', plugins_url( '../js/bootstrap.min.js', __FILE__ ), array( 'jquery' ), '4.4.1', true ); 
}

if( isset( $recap['script_load_mate'] ) ) {
    
wp_enqueue_style( 'material', plugins_url( '../css/material.min.css', __FILE__ ), array(), '1.1.1' ); 

wp_enqueue_script( 'material', plugins_url( '../js/material.min.js', __FILE__ ), array( 'jquery' ), '1.1', true );
 
}

if( isset( $recap['captcha_active'] ) ){
 wp_enqueue_script( 'recaptcha', '//www.google.com/recaptcha/api.js' );
}	

wp_enqueue_script( 'ajaxchimp', plugins_url( '../js/jquery.ajaxchimp.js', __FILE__ ), array( 'jquery' ), '1.1', true );

wp_enqueue_script( 'jquery-form', plugins_url( '../js/jquery.form.js', __FILE__ ), array( 'jquery' ), true );

wp_enqueue_script( 'popforms', plugins_url( '../js/pop-main.js', __FILE__ ), array( 'jquery' ), '1.1', true );	
	

}

add_action( 'wp_enqueue_scripts', 'popforms_enqueue_script' );


function popforms_admin_enqueue_script( $hook ) {


	if( $hook == 'toplevel_page_popforms-setting-admin' ) {


		wp_enqueue_style( 'bootstrap', plugins_url( '../css/bootstrap.min.css', __FILE__ ), array(), '3.3.7' );

		wp_enqueue_script( 'bootstrap', plugins_url( '../js/bootstrap.min.js', __FILE__ ), array('jquery'), '3.3.7', true );

		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		wp_enqueue_script('media-upload');

		// wp-color-picker	
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker');

		wp_enqueue_script( 'popadmin', plugins_url( '../js/popadmin-min.js', __FILE__ ), array('jquery'), false, true );	

	}

}

add_action( 'admin_enqueue_scripts', 'popforms_admin_enqueue_script' );

