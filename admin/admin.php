<?php
/**
 * @version    1.0
 * @package    PopForms
 * @author     Themelooks <support@themelooks.com>
 *
 * Websites: http://www.themelooks.com
 *
 */

class popformsSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be show admin menu
        add_menu_page(
            'Settings Admin', 
            esc_html__( 'PopForms Settings', 'popforms' ), 
            'manage_options', 
            'popforms-setting-admin', 
            array( $this, 'create_admin_page' )
        );
        add_submenu_page( 'popforms-setting-admin', esc_html__( 'Settings', 'popforms' ), esc_html__( 'Settings', 'popforms' ),'manage_options', 'popforms-setting-admin');
        add_submenu_page(
            'popforms-setting-admin',
            esc_html__( 'Recommended Plugins', 'popforms' ), //page title
            esc_html__( 'Recommended Plugins', 'popforms' ), //menu title
            'manage_options', //capability,
            'popforms-recommended-plugin', //menu slug
            [ $this, 'recommended_plugin_submenu_page' ] //callback function
            
        );
    }

    /**
     * [recommended_plugin_submenu_page description]
     * @return [type] [description]
     */
    public function recommended_plugin_submenu_page() {
        echo '<div class="dl-main-wrapper" style="margin-top: 50px;">';
            \Quicknav\Orgaddons\Org_Addons::getOrgItems();
        echo '</div>';
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'popforms_option_name' );
        ?>
        <style>
            .popforms-tabs {
                margin-bottom: 30px;
            }
            .popforms-tabs li {
                margin-right: 15px; 
            }
        </style>
        <div class="wrap">
			<h2><?php esc_html_e( 'Pop Forms Settings', 'popforms' ); ?></h2>  
			<ul class="nav nav-tabs popforms-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#general" aria-controls="home" role="tab" data-toggle="tab"><?php esc_html_e('General', 'popforms'); ?></a></li>
				<li role="presentation"><a href="#login" aria-controls="profile" role="tab" data-toggle="tab"><?php esc_html_e('Login/subscribe','popforms'); ?></a></li>
				<li role="presentation"><a href="#contact" aria-controls="profile" role="tab" data-toggle="tab"><?php esc_html_e('Contact', 'popforms'); ?></a></li>
				<li role="presentation"><a href="#script" aria-controls="profile" role="tab" data-toggle="tab"><?php esc_html_e('Scripts Load', 'popforms'); ?></a></li>
			</ul>			
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
				settings_fields( 'popforms_option_group' );
				echo '<div class="tab-content">';
				echo '<div role="tabpanel" class="tab-pane active" id="general">';
                do_settings_sections( 'popforms-setting-admin-general' ); 
				echo "</div>";
				echo '<div role="tabpanel" class="tab-pane" id="login">';
                do_settings_sections( 'popforms-setting-admin-login' );
				echo "</div>";
				echo '<div role="tabpanel" class="tab-pane" id="contact">';
                do_settings_sections( 'popforms-setting-admin-contact' );
				echo "</div>";
				echo '<div role="tabpanel" class="tab-pane" id="script">';
                do_settings_sections( 'popforms-setting-admin-script' );
				echo "</div>";
				echo '</div>';
               submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {   

        register_setting(
            'popforms_option_group', // Option group
            'popforms_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
        add_settings_section(
            'setting_section_id', // ID
            esc_html__( 'General Settings', 'popforms' ),// Title
            array( $this, 'print_section_info' ), // Callback
            'popforms-setting-admin-general' // Page
        );
        add_settings_section(
            'setting_section_id', // ID
            esc_html__( 'Login Settings', 'popforms' ),// Title
            array(), // Callback
            'popforms-setting-admin-login' // Page
        );
        add_settings_section(
            'setting_section_id', // ID
            esc_html__( 'Contact Settings', 'popforms' ),// Title
            array(), // Callback
            'popforms-setting-admin-contact' // Page
        );
        add_settings_section(
            'setting_section_id', // ID
            esc_html__( 'Scripts Settings', 'popforms' ),// Title
            array($this, 'print_script_section_info'), // Callback
            'popforms-setting-admin-script' // Page
        );
        add_settings_section(
            'setting_section_id', // ID
            esc_html__( 'Read Me', 'popforms' ),// Title
            array(), // Callback
            'popforms-setting-admin-readme' // Page
        ); 
		
		// General field Settings
		
		add_settings_field(
			'popform_logoup',
            esc_html__( 'Logo Upload', 'popforms' ),// Title
			array($this, 'popform_logoup_callback'),
			'popforms-setting-admin-general',
			'setting_section_id'
		);
		add_settings_field(
			'popforms_color',
            esc_html__( 'Color', 'popforms' ),// Title
			array($this, 'popforms_color_callback'),
			'popforms-setting-admin-general',
			'setting_section_id'
		);
		add_settings_field(
			'popforms_btncolor',
            esc_html__( 'Button Color', 'popforms' ),// Title
			array($this, 'popforms_btncolor_callback'),
			'popforms-setting-admin-general',
			'setting_section_id'
		);
		add_settings_field(
			'popforms_signupmailconf',
            esc_html__( 'Signup Mail Confirmation', 'popforms' ),// Title
			array($this, 'popforms_signupmailconf_callback'),
			'popforms-setting-admin-general',
			'setting_section_id'
		);
		add_settings_field(
			'popforms_signupmailfrom',
            esc_html__( 'Signup Mail From', 'popforms' ),// Title
			array($this, 'popforms_signupmailfrom_callback'),
			'popforms-setting-admin-general',
			'setting_section_id'
		);
		add_settings_field(
			'popforms_signupconfmailsub',
            esc_html__( 'Signup Confirmation Mail Subject', 'popforms' ),// Title
			array($this, 'popforms_signupconfmailsub_callback'),
			'popforms-setting-admin-general',
			'setting_section_id'
		);
		add_settings_field(
			'popforms_signupconfmess',
            esc_html__( 'Signup Confirmation Message', 'popforms' ),// Title
			array($this, 'popforms_signupconfmess_callback'),
			'popforms-setting-admin-general',
			'setting_section_id'
		);
		
		// Login field Settings
		add_settings_field(
			'login_redirect', // ID
            esc_html__( 'Login Redirect Page', 'popforms' ),// Title 
			array( $this, 'login_redirect_callback' ), // Callback
			'popforms-setting-admin-login', // Page
			'setting_section_id' // Section           
        ); 
		add_settings_field(
			'popmcapi', // ID
            esc_html__( 'Mailchimp API', 'popforms' ),// Title 
			array( $this, 'popmcapi_callback' ), // Callback
			'popforms-setting-admin-login', // Page
			'setting_section_id' // Section           
        );  
		add_settings_field(
			'popmclist', // ID
            esc_html__( 'Mailchimp List ID', 'popforms' ),// Title 
			array( $this, 'popmclist_callback' ), // Callback
			'popforms-setting-admin-login', // Page
			'setting_section_id' // Section           
        ); 
    
		// Contact form field Settings
        add_settings_field(
            'poptoemail', 
            esc_html__( 'Email To', 'popforms' ),// Title
            array( $this, 'poptoemail_callback' ), 
            'popforms-setting-admin-contact', 
            'setting_section_id'
        );
        add_settings_field(
            'attachment_active', 
            esc_html__( 'Active Attachment', 'popforms' ),// Title
            array( $this, 'attachment_active_callback' ), 
            'popforms-setting-admin-contact', 
            'setting_section_id'
        );
        add_settings_field(
            'captcha_active', 
            esc_html__( 'Active Captcha', 'popforms' ),// Title
            array( $this, 'captcha_active_callback' ), 
            'popforms-setting-admin-contact', 
            'setting_section_id'
        );
        add_settings_field(
            'captcha_sitekey', 
            esc_html__( 'Captcha Site key', 'popforms' ),// Title
            array( $this, 'captcha_sitekey_callback' ), 
            'popforms-setting-admin-contact', 
            'setting_section_id'
        );
        // scripts Load
        add_settings_field(
            'script_load_boots', 
            esc_html__( 'Bootstrap Load', 'popforms' ),// Title
            array( $this, 'script_load_boots_callback' ), 
            'popforms-setting-admin-script', 
            'setting_section_id'
        );
        add_settings_field(
            'script_load_mate', 
            esc_html__( 'Material Load', 'popforms' ),// Title
            array( $this, 'script_load_mate_callback' ), 
            'popforms-setting-admin-script', 
            'setting_section_id'
        );
		
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
		// General settings input sanitize
        if( isset( $input['popform_logoup'] ) )
            $new_input['popform_logoup'] = sanitize_text_field( $input['popform_logoup'] );
		
        if( isset( $input['popforms_color'] ) )
            $new_input['popforms_color'] = sanitize_text_field( $input['popforms_color'] );
		
        if( isset( $input['popforms_btncolor'] ) )
            $new_input['popforms_btncolor'] = sanitize_text_field( $input['popforms_btncolor'] );
       
	   if( isset( $input['popforms_signupmailconf'] ) )
            $new_input['popforms_signupmailconf'] = sanitize_text_field( $input['popforms_signupmailconf'] );
		
	   if( isset( $input['popforms_signupmailfrom'] ) )
            $new_input['popforms_signupmailfrom'] = sanitize_text_field( $input['popforms_signupmailfrom'] );
		
	   if( isset( $input['popforms_signupconfmailsub'] ) )
            $new_input['popforms_signupconfmailsub'] = sanitize_text_field( $input['popforms_signupconfmailsub'] );
		
	   if( isset( $input['popforms_signupconfmess'] ) )
            $new_input['popforms_signupconfmess'] = sanitize_text_field( $input['popforms_signupconfmess'] );
		
		// login settings input  sanitize
		
		if( isset( $input['poplogrediurl'] ) )
			$new_input['poplogrediurl'] = sanitize_text_field( $input['poplogrediurl'] );
		
		if( isset( $input['popmcapi'] ) )
			$new_input['popmcapi'] = sanitize_text_field( $input['popmcapi'] );
		
		if( isset( $input['popmclist'] ) )
			$new_input['popmclist'] = sanitize_text_field( $input['popmclist'] );
		
		// contact settings input sanitize
		
		if( isset( $input['poptoemail'] ) )
			$new_input['poptoemail'] = sanitize_text_field( $input['poptoemail'] );
		
		if( isset( $input['attachment_active'] ) )
			$new_input['attachment_active'] = sanitize_text_field( $input['attachment_active'] );
		
		if( isset( $input['captcha_active'] ) )
			$new_input['captcha_active'] = sanitize_text_field( $input['captcha_active'] );
		
		if( isset( $input['captcha_sitekey'] ) )
			$new_input['captcha_sitekey'] = sanitize_text_field( $input['captcha_sitekey'] );
		
		if( isset( $input['script_load_boots'] ) )
			$new_input['script_load_boots'] = sanitize_text_field( $input['script_load_boots'] );
		
		if( isset( $input['script_load_mate'] ) )
			$new_input['script_load_mate'] = sanitize_text_field( $input['script_load_mate'] );
		
	
        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
    ?>
    <style>
        .protag{
            color: #fff;
            position: absolute;
            top: -9px;
            background: #f70202;
            border-radius: 85px;
            padding: 5px;
            font-size: 11px;
        }
        h5 {
            position: relative;
        }
        .shortcode-list-area {
            margin-bottom: 15px;
        }
    </style>
    <!-- Button trigger modal -->
    <p><?php esc_html_e( 'Click read me button to see shortcode list', 'popforms' ); ?></p>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#readme">
    <?php esc_html_e( 'Read Me', 'popforms' ); ?>
    </button>
    <a target="_blank" href="https://codecanyon.net/item/popforms-material-design-wordpress-modal-forms-set/18065357?s_rank=5" class="btn btn-primary btn-sm"><?php esc_html_e( 'Get The Pro Version', 'popforms' ); ?></a>

    <!-- Modal -->
    <div class="modal fade" id="readme" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><?php esc_html_e( 'Shortcode and function list', 'popforms' ); ?></h4>
          </div>
          <div class="modal-body">
            <p><?php esc_html_e( 'You could use these form set anywhere using shortcode or anywhere to call the function in your template. There are two shortcode and function for each form. One for button and another for form.', 'popforms' ); ?> </p>
            <p><?php esc_html_e( 'If you want to use the form as a pop up modal form then use the button shortcode or if you want to use the form in a page then use the form shortcode.', 'popforms' ); ?></p>
            <h4><?php esc_html_e( 'Shortcode List:', 'popforms' ); ?> </h4>
            <div class="shortcode-list-area">
                <h5><?php esc_html_e( 'Contact form and button shortcode', 'popforms' ); ?></h5>
                <code>[contactbutton]</code>
                <br>
                <code>[contactform]</code>
            </div>
            <div class="shortcode-list-area">

                <h5><?php esc_html_e( 'Forgot password form and button shortcode', 'popforms' ); ?><span class="protag">Pro</span></h5>
                <code>[popforgotbtn]</code>
                <br>
                <code>[popforgotform]</code>
            </div>
            <div class="shortcode-list-area">
                <h5><?php esc_html_e( 'Subscribe form and button shortcode', 'popforms' ); ?></h5>
                <code>[popsubscribebtn]</code>
                <br>
                <code>[popsubscribeform]</code>
            </div>
            <div class="shortcode-list-area">
                <h5><?php esc_html_e( 'Signup form and button shortcode', 'popforms' ); ?><span class="protag">Pro</span></h5>
                <code>[popsingupbtn]</code>
                <br>
                <code>[popsingupform]</code>
            </div>
            <div class="shortcode-list-area">
                <h5><?php esc_html_e( 'Login form and button shortcode', 'popforms' ); ?><span class="protag">Pro</span></h5>
                <code>[poploginbtn]</code>
                <br>
                <code>[poploginform]</code>
            </div>
             <br>
            <hr>
            <h4><?php esc_html_e( 'Function List:', 'popforms' ); ?></h4>
            
            <div class="shortcode-list-area">
             <h5><?php esc_html_e( 'Contact form and button code', 'popforms' ); ?></h5>
               <code>&lt;?php echo popforms_contact_button(); ?></code>
               <br>
               <code>&lt;?php echo popforms_contact_form(); ?></code>
            </div>
           
            <div class="shortcode-list-area">
            <h5><?php esc_html_e( 'Forgot password form and button code', 'popforms' ); ?> <span class="protag">Pro</span></h5>
               <code>&lt;?php echo popforms_forgot_button(); ?></code>
               <br>
               <code>&lt;?php echo popforms_forgot_form(); ?></code>
            </div>
           
            <div class="shortcode-list-area">
            <h5><?php esc_html_e( 'Subscribe form and button code', 'popforms' ); ?></h5>
               <code>&lt;?php echo popforms_subscribe_form(); ?></code>
               <br>
               <code>&lt;?php echo popforms_subscribe_button(); ?></code>
            </div>
           
            <div class="shortcode-list-area">
            <h5><?php esc_html_e( 'Signup form and button code', 'popforms' ); ?> <span class="protag">Pro</span></h5>
               <code>&lt;?php echo popforms_signupForm(); ?></code>
               <br>
               <code>&lt;?php echo popforms_singup_button(); ?></code>
            </div>
            
            <div class="shortcode-list-area">
            <h5><?php esc_html_e( 'Login form and button code', 'popforms' ); ?> <span class="protag">Pro</span></h5>
               <code>&lt;?php echo popforms_login_form(); ?></code>
               <br>
               <code>&lt;?php echo popforms_login_button(); ?></code>
            </div>
           
          </div>
        </div>
      </div>
    </div>
    <?php
    }
    
    function print_script_section_info() {
        echo esc_html__( 'PopForms loads Bootstrap and Material Design Lite scripts by default. If your theme already loaded Bootstrap and Material Design Lite then please uncheck the checkbox and save to unload the scripts', 'popforms' );
    }
	
	/**
	* Get the general fields settings
	*/
	
	public function popform_logoup_callback()
    {
	?>
		<input type="text" id="logo_url" name="popforms_option_name[popform_logoup]" value="<?php echo esc_url( $this->options['popform_logoup'] ); ?>" />
        <input id="upload_logo_button" type="button" class="button" value="<?php _e( 'Upload Logo', 'popforms' ); ?>" />
		<br>
		<img width="100" height="100" src="<?php echo esc_url( $this->options['popform_logoup'] ); ?>" />
	<?php
	   
    }
	
	public function popforms_color_callback()
    {
       printf(
	   '<input type="text" id="popforms_color" name="popforms_option_name[popforms_color]" value="%s" />',
	    isset( $this->options['popforms_color'] ) ? $this->options['popforms_color'] :''
	   );
    }
	public function popforms_btncolor_callback()
    {
       printf(
	   '<input type="text" id="popforms_btncolor" name="popforms_option_name[popforms_btncolor]" value="%s" />',
	   isset( $this->options['popforms_btncolor'] ) ? $this->options['popforms_btncolor'] :''
	   );

    }

	public function popforms_signupmailconf_callback()
    {
		printf(
            '<input type="checkbox" id="attachment_active" name="popforms_option_name[popforms_signupmailconf]" value="true" %s />',
            isset( $this->options['popforms_signupmailconf'] ) ? 'checked' : ''
        );
		
    }

	public function popforms_signupmailfrom_callback()
    {
		printf(
            '<input type="text" id="popmcapi" name="popforms_option_name[popforms_signupmailfrom]" value="%s"  />',
            isset( $this->options['popforms_signupmailfrom'] ) ? $this->options['popforms_signupmailfrom'] : ''
        );
		
    }

	public function popforms_signupconfmailsub_callback()
    {
		printf(
            '<input type="text" id="popmcapi" name="popforms_option_name[popforms_signupconfmailsub]" value="%s"  />',
            isset( $this->options['popforms_signupconfmailsub'] ) ? $this->options['popforms_signupconfmailsub'] : ''
        );
		
    }

	public function popforms_signupconfmess_callback()
    {
		printf(
            '<input type="text" id="popmcapi" name="popforms_option_name[popforms_signupconfmess]" value="%s"  />',
            isset( $this->options['popforms_signupconfmess'] ) ? $this->options['popforms_signupconfmess'] : ''
        );
		
    }
    /** 
     * Get the Login fields settings
     */
	
	public function login_redirect_callback()
    {
		$pages = get_pages();

	?>
		<select name="popforms_option_name[poplogrediurl]"  disabled="true">
			<option value=""><?php esc_html_e('Select Page','popforms'); ?></option>
			<?php
			foreach( $pages as $page ):
			?>
				<option value="<?php echo esc_html( $page->post_name ); ?>" <?php selected( $this->options['poplogrediurl'] , esc_html( $page->post_name ) ); ?> ><?php echo esc_html( $page->post_title ); ?></option>
			<?php 
			 endforeach;
			?>
		</select>
	<?php
    }
	
	public function popmcapi_callback()
    {
		printf(
            '<input type="text" id="popmcapi" name="popforms_option_name[popmcapi]" value="%s"  />',
            isset( $this->options['popmcapi'] ) ? $this->options['popmcapi'] : ''
        );
		
    }
	public function popmclist_callback()
    {
		printf(
            '<input type="text" id="popmclist"  name="popforms_option_name[popmclist]" value="%s"  />',
            isset( $this->options['popmclist'] ) ? $this->options['popmclist'] : ''
        );
		
    }

    /** 
     * Get the contact form field settings
     */
	 
    public function poptoemail_callback()
    {
		printf(
            '<input type="email" id="poptoemail" placeholder="example@example.com" name="popforms_option_name[poptoemail]" value="%s"  />',
            isset( $this->options['poptoemail'] ) ? $this->options['poptoemail'] : ''
        );
		
    }
	
    public function attachment_active_callback()
    {
		printf(
            '<input type="checkbox" id="attachment_active" name="popforms_option_name[attachment_active]" value="true" %s />',
            isset( $this->options['attachment_active'] ) ? 'checked' : ''
        );
		
    }
    public function captcha_active_callback()
    {
		printf(
            '<input type="checkbox" id="captcha_active" name="popforms_option_name[captcha_active]" value="true" %s />',
            isset( $this->options['captcha_active'] ) ? 'checked' : ''
        );
		
    }
    public function captcha_sitekey_callback()
    {
        printf(
            '<input type="text" id="captcha_sitekey" name="popforms_option_name[captcha_sitekey]" value="%s"  />',
            isset( $this->options['captcha_sitekey'] ) ? $this->options['captcha_sitekey'] : ''
        );
		
    }
    
    /** 
    * Get the Script form field settings
    */
    public function script_load_boots_callback()
    {
		printf(
            '<input type="checkbox" id="script_load_boots" name="popforms_option_name[script_load_boots]"  %s />',
            isset( $this->options['script_load_boots'] ) ? 'checked' : ''
        );
		
    }
    public function script_load_mate_callback()
    {
		printf(
            '<input type="checkbox" id="script_load_mate" name="popforms_option_name[script_load_mate]" %s />',
            isset( $this->options['script_load_mate'] ) ? 'checked' : ''
        );
		
    }
	
}

if( is_admin() ) {
    $popforms_settings_page = new popformsSettingsPage();
}
