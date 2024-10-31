<?php
/**
 * @version    1.2
 * @package    PopForms
 * @author     Themelooks <support@themelooks.com>
 *
 * Websites: http://www.themelooks.com
 *
 */

add_shortcode('popsubscribebtn', 'popforms_subscribe_button');
function popforms_subscribe_button() {
ob_start();
?>

<a href="#" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" data-toggle="modal" data-target="#subscribeFormModal"><i class="fa fa-paper-plane"></i><?php esc_html_e( 'Subscribe', 'popforms' ); ?></a>

<?php
return ob_get_clean();
}


add_action( 'wp_footer', 'pop_subscribe_modal' );
function pop_subscribe_modal(){
    ?>
    <div class="modal fade" id="subscribeFormModal" tabindex="-1" role="dialog" aria-labelledby="subscribeFormModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php 
            // subscribe form
            echo popforms_subscribe_form();
            ?>
        </div>
	</div>
    </div>
    <?php 
}