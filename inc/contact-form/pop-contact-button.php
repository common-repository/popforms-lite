<?php
/**
 * @version    1.2
 * @package    PopForms
 * @author     Themelooks <support@themelooks.com>
 *
 * Websites: http://www.themelooks.com
 *
 */


add_shortcode('contactbutton', 'popforms_contact_button');
function popforms_contact_button() {
ob_start();
?>

<a href="#" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" data-toggle="modal" data-target="#contactFormModal"><i class="fa fa-envelope"></i><?php esc_html_e( 'Contact', 'popforms' ); ?></a>

<?php
return ob_get_clean();
}

add_action( 'wp_footer', 'popforms_contact_modal' );
function popforms_contact_modal(){
    ?>
    <div class="modal fade" id="contactFormModal" tabindex="-1" role="dialog" aria-labelledby="contactFormModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php 
            //contact form
           echo popforms_contact_form();
            ?>
		</div>
	</div>
    </div>
    <?php
}