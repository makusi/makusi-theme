<?php
/*
 * 
 * http://www.paulund.co.uk/theme-options-page
    Add Menu - If you want to display the menu under the appearance menu or if you want to give the options page it's own menu.
    Add Sections - These are sections of settings you are adding to the options page.
    Register Settings - Settings are the different fields you are adding to the options page, they need to be registered with the settings API.
    Display Settings - The settings API will be used to call a function to display the setting.
    Validate Setting - When the user saves the settings field the input will need to be validated before stored in the options table.
    Feedback Messages - When the settings are saved you need to be able to feedback to the user if the settings were saved successfully or if there was an error during validation.

 */

/* 1. We add add_makusi_menu to admin_menu */
  add_action( 'admin_menu', 'add_makusi_menu' );
/* 2. admin_init is triggered before any other hook when a user accesses the admin area. 
 * This hook doesn't provide any parameters, so it can only be used to callback a specified function. */
  add_action( 'admin_init', 'makusi_options_init' );

//Escibe las opciones por defecto
function makusi_get_default_options() {
    $options = array(
        'logo' => '',
        'white_logo' => '',
        'google_analytics' => '',
        'stelios_css' =>'',
        'post_type' =>'',
        'post_status' =>''
    );
    return $options;
}
// Inicialización de la pagina de opciones de makusi
function makusi_options_init(){
    $makusi_options = get_option( 'theme_makusi_options' );

    // Are our options saved in the DB?
    if ( false === $makusi_options ) {
        // If not, we'll save our default options
        $makusi_options = makusi_get_default_options();
        add_option( 'theme_makusi_options', $makusi_options );
    }
    /*register_setting( $option_group, $nombre_de_opcion, $retrollamada_de_limpieza );
     *	$option_group A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()
     *	$option_name The name of an option to sanitize and save.  
     *	$sanitize_callback A callback function that sanitizes the option's value. 
     *
     */
    register_setting( 'makusi_general_options', 'theme_makusi_options' , 'makusi_options_validate');
    register_setting( 'makusi_upload_options', 'theme_makusi_upload_options', 'makusi_options_upload_validate');
} 

function add_makusi_menu(){
    $page_title = "Makusi Settings";
    $menu_title = "Makusi Theme";
    $capability = "manage_options";
    $menu_slug = "makusi_theme_settings";
    $function = "makusi_front_page_settings";
    $icon_url="";
    $position="3";
    add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
}

function makusi_options_general_init(){
	/*register_setting( $option_group, $nombre_de_opcion, $retrollamada_de_limpieza );
     *	$option_group A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()
     *	$option_name The name of an option to sanitize and save.  
     *	$sanitize_callback A callback function that sanitizes the option's value. 
     *
     */
    //register_setting( 'theme_makusi_options_group', 'theme_makusi_options', 'makusi_options_validate' );
 	 
 	 // Add a form section for the Logo
 	 // add_settings_section( $id, $title, $callback, $page );
 	 // $page The menu page on which to display this section. Should match $menu_slug from Function Reference/add theme page
 	 $section_general_id = 'makusi_settings_general'; // String for use in the 'id' attribute of tags. 
 	 $section_general_title = __( 'Logo Options', 'makusi' );//  Title of the section. 
 	 $section_general_callback = 'makusi_general_header_text';// Function that fills the section with the desired content. The function should echo its output. 
 	 $section_general_page = 'makusi';// The menu page on which to display this section. Should match $menu_slug from Function Reference/add theme page
 	 add_settings_section($section_general_id, $section_general_title, $section_general_callback, $section_general_page);
 	 
    // Add Logo uploader
    // add_settings_field( $id, $title, $callback, $page, $section, $args );
    // $id String for use in the 'id' attribute of tags. 
    // $title  Title of the field. 
    // $callback Function that fills the field with the desired inputs as part of the larger form. Passed a single argument, the $args array. 
    // Name and id of the input should match the $id given to this function. The function should echo its output.
    // $page The menu page on which to display this field. Should match $menu_slug from add_theme_page()
    // $section  The section of the settings page in which to show the box (default or a section you added 
    // with add_settings_section(), 
    // look at the page in the source to see what the existing ones are.)
    // $args Additional arguments that are passed to the $callback function. 
    // The 'label_for' key/value pair can be used to format the field title like so: <label for="value">$title</label>.  
    add_settings_field('makusi_general_logo',  __( 'Logo', 'makusi' ), 'makusi_general_logo', $section_general_page, $section_general_id);
    add_settings_field('makusi_general_logo_preview',  __( 'Logo Preview', 'makusi' ), 'makusi_general_logo_preview', $section_general_page, $section_general_id);
    add_settings_field('makusi_general_white_logo',  __( 'White Logo', 'makusi' ), 'makusi_general_white_logo', $section_general_page, $section_general_id);
    add_settings_field('makusi_general_white_logo_preview',  __( 'White Logo Preview', 'makusi' ), 'makusi_general_white_logo_preview', $section_general_page, $section_general_id);
    add_settings_field('makusi_general_google_analytics',  __( 'Google Analytics', 'makusi' ), 'makusi_general_google_analytics', $section_general_page, $section_general_id);
    add_settings_field('makusi_general_stelios_css',  __( 'Stelios CSS', 'makusi' ), 'makusi_general_stelios_css', $section_general_page, $section_general_id);
    
    $section_upload_id = 'makusi_settings_upload';
 	 $section_upload_title = __( 'Upload Options', 'makusi' );
 	 $section_upload_callback = 'makusi_upload_header_text';
 	 $section_upload_page = 'makusi';
 	 add_settings_section($section_upload_id, $section_upload_title, $section_upload_callback, $section_upload_page);
    
    /*add_settings_field( $id, $title, $callback, $page, $section, $args );*/
	 $field_id = 'makusi_settings_upload_type';
	 $field_title = __('Post Type','makusi');
	 $field_callback = 'mk_form_settings_posts_type';
	 $field_page = 'makusi';
	 $section_page = 'makusi_settings_upload';
	 $field_args = '';
	add_settings_field($field_id, $field_title, $field_callback, $field_page, $section_page, $field_args);
	/*add_settings_field( $id, $title, $callback, $page, $section, $args );*/
	 $field_id = 'makusi_settings_upload_status';
	 $field_title = __('Post Status','makusi');
	 $field_callback = 'mk_form_settings_posts_status';
	 $field_page = 'makusi';
	 $section_page = 'makusi_settings_upload';
	 $field_args = '';
	add_settings_field($field_id, $field_title, $field_callback, $field_page, $section_page, $field_args);
	$field_id = 'makusi_settings_upload_redirect_to';
	 $field_title = __('Redirect To','makusi');
	 $field_callback = 'mk_form_settings_posts_redirect_to';
	 $field_page = 'makusi';
	 $section_page = 'makusi_settings_upload';
	 $field_args = '';
	add_settings_field($field_id, $field_title, $field_callback, $field_page, $section_page, $field_args);
}
add_action( 'admin_init', 'makusi_options_general_init' );

function makusi_general_header_text() {
    ?>
        <p><?php _e( 'Manage Logo Options for Makusi Theme.', 'makusi' ); ?></p>
    <?php
}

function makusi_upload_header_text() {
    ?>
        <p><?php _e( 'Manage Upload Options for Makusi Theme.', 'makusi' ); ?></p>
    <?php
}

function makusi_general_logo() {
    $makusi_options = get_option( 'theme_makusi_options' );
    ?>
        <input type="hidden" id="logo_url" name="theme_makusi_options[logo]" value="<?php echo esc_url( $makusi_options['logo'] ); ?>" />
        <input id="upload_logo_button" type="button" class="button" value="<?php _e( 'Upload Logo', 'makusi' ); ?>" />
         <?php if ( '' != $makusi_options['logo'] ): ?>
            <input id="delete_logo_button" name="theme_makusi_options[delete_logo]" type="submit" class="button" value="<?php _e( 'Delete Logo', 'makusi' ); ?>" />
        <?php endif; ?>
        <span class="description"><?php _e('Upload an image for the logo.', 'makusi' ); ?></span>
    <?php
}

function makusi_general_logo_preview() {
    $makusi_options = get_option( 'theme_makusi_options' ); 
    ?>
    <div id="upload_logo_preview" style="min-height: 100px;"> 
    <?php if($makusi_options['logo'] != ""){ ?>
        <img style="max-width:100%;" src="<?php echo esc_url( $makusi_options['logo'] ); ?>" />
    <?php } ?>
    </div>
<?php }

function makusi_general_white_logo() {
    $makusi_options = get_option( 'theme_makusi_options' );
    ?>
        <input type="hidden" id="white_logo_url" name="theme_makusi_options[white_logo]" value="<?php echo esc_url( $makusi_options['white_logo'] ); ?>" />
        <input id="upload_white_logo_button" type="button" class="button" value="<?php _e( 'Upload Logo', 'makusi' ); ?>" />
         <?php if ( '' != $makusi_options['white_logo'] ): ?>
            <input id="delete_logo_button" name="theme_makusi_options[delete_white_logo]" type="submit" class="button" value="<?php _e( 'Delete White Logo', 'makusi' ); ?>" />
        <?php endif; ?>
        <span class="description"><?php _e('Upload an image for the logo.', 'makusi' ); ?></span>
    <?php
}

function makusi_general_white_logo_preview() {
    $makusi_options = get_option( 'theme_makusi_options' );
    //var_dump($makusi_options);
    ?>
    <div id="upload_white_logo_preview" style="min-height: 100px;"> 
    <?php if($makusi_options['white_logo'] != ""){ ?>
        <img style="max-width:100%;" src="<?php echo esc_url( $makusi_options['white_logo'] ); ?>" />
    <?php } ?>
    </div>
<?php }

function makusi_general_google_analytics(){
    $makusi_options = get_option( 'theme_makusi_options' );
    ?>
     <textarea 
               id="google_analytics" 
               name="theme_makusi_options[google_analytics]" 
               class="large-text" 
               cols="50" 
               rows="10"><?php echo $makusi_options['google_analytics']; ?></textarea>
        <span class="description"><?php _e('Insert your Google Analytics code here.', 'makusi' ); ?></span>
<?php }

function makusi_general_stelios_css(){
    $makusi_options = get_option( 'theme_makusi_options' );
    ?>
     <textarea 
               id="stelios_css" 
               name="theme_makusi_options[stelios_css]" 
               class="large-text" 
               cols="50" 
               rows="10"><?php echo $makusi_options['stelios_css']; ?></textarea>
        <span class="description"><?php _e('Dear Stelios feel like at home.', 'makusi' ); ?></span>
<?php }

function test_field_upload(){
	echo "Hello test";
}

function makusi_front_page_settings() { ?>
    <div class="wrap">
        <h2><?php echo __( 'Makusi Theme Options', 'makusitheme' ); ?></h2>
        
        <?php settings_errors( 'makusi-settings-errors' ); ?>
        <?php if (isset($_POST["theme_makusi_options"]["update_settings"])) {
            $makusi_options = $_POST["theme_makusi_options"];
            update_option("theme_makusi_options", $makusi_options);
        } else {
            $google_analytics = get_option("makusi_google_analytics");
            $stelios_css = get_option("makusi_stelios_css");
        } ?>
        
        <form id="form-makusi-options" action="" method="POST" enctype="multipart/form-data">
            <?php 
            // Output nonce, action, and option_page fields for a settings page. 
            // Please note that this function must be called inside of the form tag for the options page. 
            // settings_fields( $option_group )
            // $option_group A settings group name. This should match the group name used in register_setting(). 
                settings_fields( 'makusi_general_options' ); 
             // Prints out all settings sections added to a particular settings page. 
             // do_settings_sections( $page );
             // $page
             // The slug name of the page whose settings sections you want to output. 
             // This should match the page name used in add_settings_section(). 
                do_settings_sections('makusi');
            ?>
            <p class="submit">
                    <input name="theme_makusi_options[submit]" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'makusi'); ?>" />
                    <input name="theme_makusi_options[reset]" type="reset" class="button-secondary" value="<?php esc_attr_e('Reset Defaults', 'makusi'); ?>" />
            </p>
            <input type="hidden" name="theme_makusi_options[update_settings]" value="Y" />
        </form>
    </div>
    
<?php }

function makusi_options_validate( $input ) {
	//var_dump($input);
    $default_options = makusi_get_default_options();
    $valid_input = $default_options;
    $makusi_options = get_option('theme_makusi_options');
    
    $submit = ! empty($input['submit']) ? true : false;
    $reset = ! empty($input['reset']) ? true : false;
    $delete_logo = ! empty($input['delete_logo']) ? true : false;
    $delete_white_logo = ! empty($input['delete_white_logo']) ? true : false;
    
    if ( $submit ) {
        $valid_input['logo'] = $input['logo'];
        $valid_input['white_logo'] = $input['white_logo'];
        $valid_input['google_analytics'] = $input['google_analytics'];
        $valid_input['stelios_css'] = $input['stelios_css'];
        $valid_input['post_type'] = $input['post_type'];
        $valid_input['post_status'] = $input['post_status'];
        $valid_input['redirect_to'] = $input['redirect_to'];
    } elseif ( $reset ) {
        $valid_input['logo'] = $default_options['logo'];
        $valid_input['white_logo'] = $input['white_logo'];
        $valid_input['google_analytics'] = $default_options['google_analytics'];
        $valid_input['stelios_css'] = $default_options['stelios_css'];
        $valid_input['post_type'] = $default_options['post_type'];
        $valid_input['post_status'] = $default_options['post_status'];
        $valid_input['redirect_to'] = $default_options['redirect_to'];
    } elseif ( $delete_logo ) {
        delete_image( $makusi_options['logo'] );
        delete_image( $makusi_options['white_logo'] );
        $valid_input['logo'] = '';
        $valid_input['white_logo'] = '';
    }
    return $valid_input;
}

function delete_image( $image_url ) {
    global $wpdb;
 
    // We need to get the image's meta ID.
    $query = "SELECT ID FROM wp_posts where guid = '" . esc_url($image_url) . "' AND post_type = 'attachment'";
    $results = $wpdb->get_results($query);
 
    // And delete it
    foreach ( $results as $row ) {
        wp_delete_attachment( $row->ID );
    }
}

function makusi_options_enqueue_scripts() {
    wp_register_script( 'makusi-upload', get_template_directory_uri() .'/js/custom-admin.js', array('jquery','media-upload','thickbox') );
    
    if ( 'toplevel_page_makusi_theme_settings' == get_current_screen()->id ) {
        wp_enqueue_script('jquery');
 
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');
 
        wp_enqueue_script('media-upload');
        wp_enqueue_script('makusi-upload');
 
    }
 
}
add_action('admin_enqueue_scripts', 'makusi_options_enqueue_scripts');

function makusi_options_setup() {
    global $pagenow;
 
    if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
        // Now we'll replace the 'Insert into Post Button' inside Thickbox
        add_filter( 'gettext', 'replace_thickbox_text'  , 1, 3 );
    }
}
add_action( 'admin_init', 'makusi_options_setup' );

function replace_thickbox_text($translated_text, $text, $domain) {
    if ('Insert into Post' == $text) {
        $referer = strpos( wp_get_referer(), 'makusi-settings' );
        if ( $referer != '' ) {
            return __('I want this to be my logo!', 'makusi' );
        }
    }
    return $translated_text;
}
function mk_form_settings_posts_type() { 
    		//get_option( $option, $default );
    		// $option Matches $option_name in register_setting() for custom options. 
    		// update_option( $option, $new_value );
    		//$form_settings = get_post_meta( $post->ID, 'wpuf_form_settings', true );
    	 $form_settings = get_option( 'theme_makusi_options', '' );
    	 $post_type_selected = isset( $form_settings['post_type'] ) ? $form_settings['post_type'] : 'post';
    		?>
    		<select name="theme_makusi_options[post_type]">
         	<?php
            	$post_types = get_post_types();
               unset($post_types['attachment']);
               unset($post_types['revision']);
               unset($post_types['nav_menu_item']);
               unset($post_types['wpuf_forms']);
               unset($post_types['wpuf_profile']);

               foreach ($post_types as $post_type) {
               	printf('<option value="%s"%s>%s</option>', $post_type, selected( $post_type_selected, $post_type, false ), $post_type );
               }
            ?>
          </select> 
    <?php } 
    
function mk_form_settings_posts_status(){
	?>
	<select name="theme_makusi_options[post_status]">
		<?php
		$form_settings = get_option( 'theme_makusi_options', '' );
		$post_status_selected = isset( $form_settings['post_status'] ) ? $form_settings['post_status'] : 'publish';
		/* RETURN VALLUES
		* array(
		*	'draft'			=> __('Draft'),
		*	'pending'		=> __('Pending Review'),
		*	'private'		=> __('Private'),
		*	'publish'		=> __('Published')
		*	);	
		*/
		$statuses = get_post_statuses();
		foreach ($statuses as $status => $label) {
			printf('<option value="%s"%s>%s</option>', $status, selected( $post_status_selected, $status, false ), $label );
		}
	?>
	</select>	
	<?php
}    

function mk_form_settings_posts_redirect_to(){ ?>
	<select name="theme_makusi_options[redirect_to]">
      <?php
      	$form_settings = get_option( 'theme_makusi_options', '' );
      	$redirect_to = isset( $form_settings['redirect_to'] ) ? $form_settings['redirect_to'] : 'post';
         $redirect_options = array(
                            'post' => __( 'Newly created post', 'wpuf' ),
                            'same' => __( 'Same Page', 'wpuf' ),
                            'page' => __( 'To a page', 'wpuf' ),
                            'url' => __( 'To a custom URL', 'wpuf' )
                        );

           foreach ($redirect_options as $to => $label) {
           		printf('<option value="%s"%s>%s</option>', $to, selected( $redirect_to, $to, false ), $label );
           }
      ?>
  </select>
<?php } ?>