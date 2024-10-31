<?php
/**
 * @version    1.2
 * @package    PopForms
 * @author     Themelooks <support@themelooks.com>
 *
 * Websites: http://www.themelooks.com
 *
 */


add_shortcode('popsubscribeform', 'popforms_subscribe_form');
function popforms_subscribe_form() {
    
if( isset( $_POST['subscribe_sub'] ) ) {
    
    popforms_subscribe_form_ajax( $POST ); 

}
ob_start();
?>
<div class="subscribeForm">
    <div class="mdl-card mdl-shadow--2dp">
        <?php 
        // logo
        popforms_logo();
        ?>
        <div class="mdl-card__supporting-text">
        <div class="alert-box"></div>
            <form action="#" method="post" id="subscribeForm">
                <div class="mdl-textfield mdl-js-textfield">
                    <input class="mdl-textfield__input" type="email" name="subscribeEmail" id="subscribeEmail">
                    <label class="mdl-textfield__label" for="subscribeEmail"><?php esc_html_e( 'E-mail Address', 'popforms' ); ?></label>
                </div>
                <input type="hidden" name="subscribe_sub" value="1" id="subscribe_sub" />
                <input type="hidden" id="subscribe-url" data-url="<?php echo admin_url('admin-ajax.php'); ?>"/>
                <button type="submit" class="subscribe-form-submit-btn mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"><?php esc_html_e( 'Subscribe', 'popforms' ); ?></button>
            </form>
        </div>
    </div>
</div>

<?php
return ob_get_clean();
}