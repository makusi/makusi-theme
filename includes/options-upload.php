<?php

add_action( 'admin_init', 'upload_form_callback' );
function upload_form_callback(){ 
	/* add_settings_section( $id, $title, $callback, $page ); */
	$section_id = "makusi_settings_upload"; // String for use in the 'id' attribute of tags. 
	$section_title = __( 'Upload Options', 'makusi' ); // (required) Title of the section. 
	$section_callback = 'makusi_settings_upload_text'; // Function that fills the section with the desired content. The function should echo its output.
	$section_page = 'upload-form'; // The menu page on which to display this section. Should match $menu_slug from Function Reference/add theme page
	add_settings_section($section_id, $section_title, $section_callback, $section_page );
	
	/*add_settings_field( $id, $title, $callback, $page, $section, $args );*/
	$field_id = 'makusi_settings_upload';
	$field_title = __('TEST FIELD','makusi');
	$field_callback = 'test_field_upload';
	$field_page = 'upload-form';
	$field_args = '';
	add_settings_field($field_id, $field_title, $field_callback, $field_page, $field_args);
}


function makusi_settings_upload_text() {
    ?>
        <p><?php _e( 'Manage Uploads form for Makusi.tv.', 'makusi' ); ?></p>
    <?php
}

function pu_theme_page()
{
?>
    <div class="section panel">
      <h1>Makusi Upload Options</h1>
      <form method="post" enctype="multipart/form-data" action="options.php">
        <?php 
          settings_fields('makusi_upload_theme_options'); 
        
          do_settings_sections('upload-form');
        ?>
            <p class="submit">  
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />  
            </p>  
            
      </form>
      
      <p>Created by <a href="http://www.paulund.co.uk">Paulund</a>.</p>
    </div>
    <?php
}

function test_field_upload(){
	echo "Hello test";
}

function select_post_type(){
	echo _e( 'Post Type', 'makusi' ); ?>
	<select name="wpuf_settings[post_type]">
		<?php
			$post_type_selected = isset( $form_settings['post_type'] ) ? $form_settings['post_type'] : 'post';
						
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
<?php		
	}

?>

