<?php
/**
 * @version    1.2
 * @package    PopForms
 * @author     Themelooks <support@themelooks.com>
 *
 * Websites: http://www.themelooks.com
 *
 */

add_shortcode('contactform', 'popforms_contact_form');
function popforms_contact_form() {
ob_start();
$recap = get_option('popforms_option_name');
  
if( isset( $_POST['popCont_sub'] ) ) {
    popforms_contact_form_calback( $_POST );  
}

?>
<div class="contactForm">
    <div class="mdl-card mdl-shadow--2dp">
        <?php 
        // logo
        popforms_logo();
        ?>
        <div class="mdl-card__supporting-text">
            <div class="alert-box"></div>
            <form action="#" method="post" id="contactForm" enctype="multipart/form-data" >
                <div class="row">
                    <div class="col-md-6">
                        <div class="mdl-textfield mdl-js-textfield">
                            <input class="mdl-textfield__input" type="text" name="contactName" id="contactName">
                            <label class="mdl-textfield__label" for="contactName"><?php esc_html_e( 'Full Name', 'popforms' ); ?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mdl-textfield mdl-js-textfield">
                            <input class="mdl-textfield__input" type="email" name="contactEmail" id="contactEmail">
                            <label class="mdl-textfield__label" for="contactEmail"><?php esc_html_e( 'E-mail Address', 'popforms' ); ?></label>
                        </div>
                    </div>
                </div>
                <div class="mdl-textfield mdl-js-textfield">
                    <input class="mdl-textfield__input" type="text" name="contactSubject" id="contactSubject">
                    <label class="mdl-textfield__label" for="contactSubject"><?php esc_html_e( 'Subject', 'popforms' ); ?></label>
                </div>
                <div class="mdl-textfield mdl-js-textfield">
                    <textarea class="mdl-textfield__input" name="contactMessage" id="contactMessage"></textarea>
                    <label class="mdl-textfield__label" for="contactMessage"><?php esc_html_e( 'Message', 'popforms' ); ?></label>
                </div>
                <?php 
                if( isset( $recap['attachment_active'] ) ):
                ?>
                <div class="pop-attachment mdl-textfield__input">
                    <input class="" type="file" name="contactFile" id="contactFile">
                </div>
                <?php
                endif;
                if( isset( $recap['captcha_active'] ) ):
                ?>
                <div class="pop-chaptch mdl-textfield__input">
                    <div class="g-recaptcha" data-sitekey="<?php echo $recap['captcha_sitekey']; ?>"></div>
                </div>
                <?php 
                endif;
                ?>
                
                <input type="hidden" name="popCont_sub" value="1" />
                <input type="hidden" name="action" value="popforms_contact_form_calback" />
                <input type="hidden" id="contact-ajax-url" data-url="<?php echo admin_url('admin-ajax.php'); ?>" />
                
                <input type="submit" class="contact-form-submit-btn btn-topmarg mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" value="<?php esc_html_e( 'Send', 'popforms' ); ?>">
                
            </form>
        
        </div>
    </div>
</div>
<?php
$html = ob_get_clean();
return $html;
}