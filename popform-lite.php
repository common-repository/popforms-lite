<?php 
/**
Plugin Name: PopForms Lite
Plugin URI: http://themelooks.com/popforms
Author: ThemeLooks
Author URI: http://themelooks.com/
Version:     1.5.1
Description: PopForms - Material Design WordPress Modal Forms Set Plugin
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: popforms
*/

// direct access block.
defined('ABSPATH') || exit;
	

// text domain
load_plugin_textdomain( 'popforms', false, basename( dirname( __FILE__ ) ). '/languages' );

// Default option save
function popform_default_set(){
    
    $option = get_option( 'popforms_option_name' );
    
    $default = array(
        'script_load_boots' => '',
        'script_load_mate'  => '',
        'captcha_active'    => '',
        'attachment_active' => '',
        'popform_logoup'    => '',
        'poplogrediurl'     => '',
        'captcha_sitekey'   => ''
    );
      
    if( $option === false  ){
        update_option( 'popforms_option_name', $default );
    }
    
} 
register_activation_hook( __FILE__ , 'popform_default_set' );

//include file
require_once dirname( __FILE__ ). '/admin/admin.php';
require_once dirname( __FILE__ ). '/inc/pop-enqueue.php';
require_once dirname( __FILE__ ). '/inc/class/class-pop-contact.php';
require_once dirname( __FILE__ ). '/inc/class/POPMCAPI.class.php';
require_once dirname( __FILE__ ). '/inc/pop-functions.php';
//contact form include
require_once dirname( __FILE__ ). '/inc/contact-form/pop-contact-button.php';
require_once dirname( __FILE__ ). '/inc/contact-form/pop-contact-form.php';
//subscribe form include
require_once dirname( __FILE__ ). '/inc/subscribe-form/pop-subscribe-button.php';
require_once dirname( __FILE__ ). '/inc/subscribe-form/pop-subscribe-form.php';
