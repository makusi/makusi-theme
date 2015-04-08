<?php
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );
/*Hide admin bar*/
add_filter('show_admin_bar', '__return_false');

require_once( trailingslashit(get_template_directory()) . 'includes/options.php' );
//require_once( trailingslashit(get_template_directory()) . 'includes/options-upload.php' );
require_once( trailingslashit(get_template_directory()) . 'includes/metaboxes.php' );
require_once( trailingslashit(get_template_directory()) . 'includes/upload.php' );
require_once( trailingslashit(get_template_directory()) . 'includes/render_form.php' );
require_once( trailingslashit(get_template_directory()) . 'includes/users.php');
require_once( trailingslashit(get_template_directory()) . 'includes/donations.php');

add_theme_support( 'post-thumbnails' ); 

add_image_size('home-screen',1110,400);
add_image_size('home-carousel',260,135);
add_image_size('double-column',300,169);
add_image_size('triple-column',260,146);
add_image_size('single-column',730,260);
add_image_size('single-video',730,380);
add_image_size('sidebar',350,180);

/*Remove unnecessary tags*/
/* Really Simple Discovery */
remove_action('wp_head', 'rsd_link');
/* Windows Live Writer*/
remove_action('wp_head', 'wlwmanifest_link');
/*Wordpress Generator*/
remove_action('wp_head', 'wp_generator');
/*Post Relational Links*/
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link');

remove_filter( 'the_content', 'wpautop' );
if(is_home() || is_tag() || is_search() || is_author()){
    remove_filter( 'the_excerpt', 'wpautop' );
}


/* JAVASCRIPT AND CSS */

function load_scripts(){
    wp_register_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery') );
    wp_register_script( 'tabs',  get_template_directory_uri().'/js/tabs.js');
    wp_register_script( 'video',  get_template_directory_uri().'/js/video.js');
    wp_register_script( 'simplemodal',  get_template_directory_uri().'/js/jquery.simplemodal.js');
    wp_register_script( 'osx',  get_template_directory_uri().'/js/osx.js');
    wp_register_script( 'modernizr',  get_template_directory_uri().'/js/modernizr.js');
    wp_register_script( 'replacetext',  get_template_directory_uri().'/js/jquery.ba-replacetext.js', array('jquery'));
    wp_register_script( 'custom', get_template_directory_uri() .'/js/custom.js', array('jquery') );
    wp_register_script( 'easytabs', get_template_directory_uri() . '/js/easytabs.js', array('jquery') );
    wp_register_script( 'jcarousel', get_template_directory_uri() . '/js/jquery.jcarousel.js', array('jquery') );
    wp_register_script( 'slider', get_template_directory_uri() . '/js/slider.js', array('jquery') );
    wp_register_script( 'masonry', get_template_directory_uri() . '/js/jquery.masonry.min.js', array('jquery') );
    wp_register_script( 'makusi-upload', get_template_directory_uri() .'/js/upload.js', array('jquery', 'plupload-handlers') );
    wp_register_script( 'video_player', get_template_directory_uri() .'/js/video_player.js',array('jquery'));
    wp_register_script( 'videosub', get_template_directory_uri() .'/js/videosub.js',array('jquery'));
    
    wp_enqueue_script('bootstrap');
    if(is_single()){
        wp_enqueue_script('tabs');
        wp_enqueue_script('replacetext');
        wp_enqueue_script('video_player');
        wp_enqueue_script('videosub');
    }
    if(is_page('new-post') || 
            is_page('edit-video') || 
            is_page('igo-bideoa') || 
            is_page('pujar-video') || 
            is_page('enviar-video') || 
            is_page('upload-video') || 
            is_page('envoyer-une-video') || 
            is_page(312)){
        wp_enqueue_script('tabs');
        wp_enqueue_script( 'suggest' );
    }
     
    wp_enqueue_script( 'custom' );
    wp_enqueue_script( 'easytabs');
    wp_enqueue_script( 'modernizr');
    wp_enqueue_script( 'slider');
    wp_enqueue_script( 'masonry');
    wp_enqueue_script( 'simplemodal');
    wp_enqueue_script( 'osx');
    wp_enqueue_script( 'plupload-handlers' );
    wp_enqueue_script( 'makusi-upload' );
    wp_enqueue_script( 'makusi-frontend-form' );
    
    wp_localize_script( 'custom' , 'MyAjax' , array( 
                                                'url' => admin_url( 'admin-ajax.php' ), 
                                                'nonce' => wp_create_nonce( 'register-ajax-nonce' )) );
    wp_localize_script( 'custom' , 'LoginAjax' , array( 
                                                'url' => admin_url( 'admin-ajax.php' ), 
                                                'nonce' => wp_create_nonce( 'login-ajax-nonce' )) );
    wp_localize_script( 'custom' , 'LostPassword' , array( 
                                                'url' => admin_url( 'admin-ajax.php' ), 
                                                'nonce' => wp_create_nonce( 'lost_password-ajax-nonce' )) );
    wp_localize_script( 'custom' , 'ContactSender' , array( 
                                                'url' => admin_url( 'admin-ajax.php' ), 
                                                'nonce' => wp_create_nonce( 'contact_sender-ajax-nonce' )) );
    
    if(is_page('upload')){
    	//Localizes a registered script with data for a JavaScript variable. 
        wp_localize_script( 'makusi-frontend-form', 'wpuf_frontend', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'error_message' => __( 'Por favor corrige los errores para proceder', 'wpuf' ),
            'nonce' => wp_create_nonce( 'wpuf_nonce' )
        ) );
        
        wp_localize_script( 'makusi-upload', 'wpuf_frontend_upload', array(
            'confirmMsg' => __( 'Are you sure?', 'wpuf' ),
            'nonce' => wp_create_nonce( 'wpuf_nonce' ),
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'plupload' => array(
                    'url' => admin_url( 'admin-ajax.php' ) . '?nonce=' . wp_create_nonce( 'wpuf_featured_img' ),
                    'flash_swf_url' => includes_url( 'js/plupload/plupload.flash.swf' ),
                    'filters' => array(array('title' => __( 'Archivos permitidos' ), 'extensions' => '*')),
                    'multipart' => true,
                    'urlstream_upload' => true,
                )
            ) );    
    }
};
add_action('wp_enqueue_scripts','load_scripts');

function unload_scripts(){
  if(is_single() || is_home()){
      wp_deregister_script( 'contact-form-7' ); 
      wp_deregister_script( 'google-maps' );
      wp_deregister_script( 'jquery-ui-datepicker' );
      wp_deregister_script( 'jquery-ui-spinner' );
  }
  if(is_page('new-post')){
      wp_deregister_script( 'google-maps' );
      wp_deregister_script( 'makusi-upload' );
  }
};
add_action('wp_enqueue_scripts','unload_scripts');

function load_styles(){
    wp_register_style( 'reset' , get_template_directory_uri() . '/css/reset.css');
    wp_register_style( 'bootstrap' , get_template_directory_uri() . '/css/bootstrap/bootstrap.css');
    wp_register_style( 'topbar' , get_template_directory_uri() . '/css/topbar.css');
    wp_register_style( 'header' , get_template_directory_uri() . '/css/header.css');
    wp_register_style( 'tabs' ,  get_template_directory_uri().'/css/tabs.css');
    
    wp_register_style( 'twitter' ,  get_template_directory_uri().'/css/twitter.css');
    wp_register_style( 'easytabs' ,  get_template_directory_uri().'/css/easytabs.css');
    wp_register_style( 'fontawesome' , get_template_directory_uri() . '/css/font-awsome/css/font-awesome.css', array());
    wp_register_style( 'osx' ,  get_template_directory_uri().'/css/osx.css');
    
    wp_register_style( 'buddypress' , get_template_directory_uri() . '/css/buddypress-socialbuddy.css');
    wp_register_style( 'buddypress-sidebar' , get_template_directory_uri() . '/css/buddypress-sidebar.css');
    wp_register_style( 'buddypressactivityplus' , get_template_directory_uri() . '/css/bpfb_interface.css');
    
    wp_register_style( 'style' , get_template_directory_uri() . '/css/style.css');
    wp_register_style( 'wpuf-form' ,  get_template_directory_uri().'/css/wpuf-form.css');
    wp_register_style( 'jcarousel.basic' ,  get_template_directory_uri().'/css/jcarousel.basic.css');
    
    wp_register_style( 'home' ,  get_template_directory_uri().'/css/home.css');
    wp_register_style( 'invite' ,  get_template_directory_uri().'/css/invite.css');
    wp_register_style( 'single' ,  get_template_directory_uri().'/css/single.css');
    wp_register_style( 'page' ,  get_template_directory_uri().'/css/page.css');
    wp_register_style( 'archive' ,  get_template_directory_uri().'/css/archive.css');
    wp_register_style( 'category' ,  get_template_directory_uri().'/css/category.css');
    wp_register_style( 'tag' ,  get_template_directory_uri().'/css/tag.css');
    wp_register_style( 'search' ,  get_template_directory_uri().'/css/search.css');
    wp_register_style( 'author' ,  get_template_directory_uri().'/css/author.css');
    wp_register_style( 'responsive' ,  get_template_directory_uri().'/css/responsive.css');
    wp_register_style( 'tpv-success' , get_template_directory_uri() . '/css/tpv-success.css');
    wp_register_style( 'video_player' , get_template_directory_uri() . '/css/video_player.css');
    wp_register_style( 'cnaucler' , get_template_directory_uri() . '/css/cnaucler.css');
    wp_register_style( 'cnaucler-responsive' , get_template_directory_uri() . '/css/cnaucler-responsive.css');
    wp_enqueue_style( 'reset');
    wp_enqueue_style( 'bootstrap');
    
    if(is_single() || is_page('new-post') || is_page('edit-video') || is_page('igo-bideoa') || is_page('pujar-video') || is_page('enviar-video') || is_page('upload-video') || is_page('envoyer-une-video') || is_page(312)){
        wp_enqueue_style( 'tabs' );
        wp_enqueue_style( 'wpuf-form' );
    }
    if(is_single()){
    	wp_enqueue_style( 'single' );
        wp_enqueue_style( 'video_player' );
    }
    if(is_page()){
    	wp_enqueue_style( 'page' );
    }
    if(is_archive()){
    	wp_enqueue_style( 'archive' );
    }
    if(is_category()){
    	wp_enqueue_style( 'category' );
    }
    if(is_tag()){
    	wp_enqueue_style( 'tag' );
    }
    if(is_search()){
    	wp_enqueue_style( 'search' );
    }
    if(is_home()){
	wp_enqueue_style ('home');    
    }
    if(is_author() || is_page('user-profile')){
	wp_enqueue_style ('author');       
    }
    if(is_page('tpv-success')){
        wp_enqueue_style('tpv-success');
    }
    
    wp_enqueue_style( 'style' );
    wp_enqueue_style( 'fontawesome' );
    wp_enqueue_style( 'osx' );
    wp_enqueue_style( 'topbar' );
    wp_enqueue_style( 'header' );
    wp_enqueue_style( 'invite' );
    wp_enqueue_style( 'twitter' );
    wp_enqueue_style( 'easytabs' );
    wp_enqueue_style( 'jcarousel.basic' );
    wp_enqueue_style( 'responsive' );
    wp_enqueue_style( 'buddypressactivityplus' );
    wp_enqueue_style( 'buddypress' );
    wp_enqueue_style( 'buddypress-sidebar' );
    wp_enqueue_style( 'cnaucler' );
    wp_enqueue_style( 'cnaucler-responsive' );
};
add_action('wp_enqueue_scripts','load_styles');

function unload_styles(){
    if(is_single()){
      wp_deregister_style( 'contact-form-7' ); 
      wp_deregister_style( 'wpuf-css' );
  }
  wp_deregister_style( 'wpuf-css' );
}
add_action('wp_enqueue_scripts','unload_styles');

/**
 * add script to admin page
 */
//add_action('wp_head', 'add_script_config');
function add_script_config() {
?>
    <script type="text/javascript" >
    	// Function to add auto suggest
    	function setSuggest() {
            jQuery('#tags').suggest("<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php?action=ajax-tag-search&tax=post_tag", {multiple:true, multipleSep: ","});
    	}
    </script>
<?php
}
	
if(is_page('new-post')){
	add_action('wp_enqueue_scripts', 'add_script_config');
}

/* BLOCK USERS */
add_action( 'init', 'blockusers_init' );

function blockusers_init() {
    if ( is_admin() && !current_user_can( 'administrator' ) && !( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
	wp_redirect( home_url() );
	exit;
    }
}

/*MENUS*/
add_action( 'init', 'register_my_menus' );
function register_my_menus(){
    register_nav_menus( array(
	'footer_menu_3' => 'Menu for footer widget 3',
    ) );
}

/*WIDGETS*/
if ( function_exists('register_sidebar') ){
    register_sidebar(array(
                        'name'=>'home-right',
                        'description'=>'Home Right',
                        'id'=> 'home-right',
                        'before_widget' => '<div id="%1s" class="widget-item %2s panel panel-warning">',
                        'after_widget' => '<div class="clr"></div></div>',
                        'before_title' => '<div class="widget-title panel-heading">',
                        'after_title' => '</div>'
    ));
    register_sidebar(array(
                        'name'=>'top-user',
                        'description'=>'Top User',
                        'id'=>'top-user',
                        'before_widget' => '<div id="%1s" class="widget-item %2s">',
                        'after_widget' => '<div class="clr"></div></div>',
                        'before_title' => '<h6 class="widget-title">',
                        'after_title' => '</h6>'
    ));
    register_sidebar(array(
                        'name'=>'top-language',
                        'description'=>'Top Language',
                        'id'=>'top-language',
                        'before_widget' => '<div id="%1s" class="widget-item %2s">',
                        'after_widget' => '<div class="clr"></div></div>',
                        'before_title' => '<h6 class="widget-title">',
                        'after_title' => '</h6>'
    ));
    register_sidebar(array(
                        'name'=>'left-sidebar',
                        'description'=>'Left Sidebar',
                        'id'=>'left-sidebar',
                        'before_widget' => '<div id="%1s" class="widget-item %2s">',
                        'after_widget' => '<div class="clr"></div></div>',
                        'before_title' => '<h6 class="widget-title">',
                        'after_title' => '</h6>'
    ));
    register_sidebar(array(
                        'name'=>'right-sidebar',
                        'description'=>'Right Sidebar',
                        'id'=>'right-sidebar',
                        'before_widget' => '<div id="%1s" class="widget-item %2s">',
                        'after_widget' => '<div class="clr"></div></div>',
                        'before_title' => '<h6 class="widget-title">',
                        'after_title' => '</h6>'
    ));
    
    register_sidebar(array(
                        'name'=>'social-right',
                        'description'=>'Social Right',
                        'id'=> 'social-right',
                        'before_widget' => '<div id="%1s" class="widget-item %2s panel panel-default">',
                        'after_widget' => '<div class="clearfix"></div></div>',
                        'before_title' => '<h2 class="widget-title">',
                        'after_title' => '</h2>'
    ));
    
    register_sidebar(array(
                        'name'=>'social-left',
                        'description'=>'Social left',
                        'id'=> 'social-left',
                        'before_widget' => '<div id="%1s" class="widget widget-item %2s panel panel-default">',
                        'after_widget' => '<div class="clearfix"></div></div>',
                        'before_title' => '<h2 class="widget-title">',
                        'after_title' => '</h2>'
    ));
    register_sidebar(array(
                        'name'=>'single-sidebar',
                        'description' => 'Single Sidebar',
                        'id'=> 'single-sidebar',
                        'before_widget' => '<div id="%1s" class="widget widget-item %2s panel panel-default">',
                        'after_widget' => '<div class="clearfix"></div></div>',
                        'before_title' => '<h2 class="widget-title">',
                        'after_title' => '</h2>'
    ));
    register_sidebar(array(
                        'name'=> 'footer-1',
                        'description' => 'Footer 1',
                        'id'=>'footer-1',
                        'before_widget' => '<div id="%1s" class="widget-item %2s">',
                        'after_widget' => '<div class="clr"></div></div>',
                        'before_title' => '<h6 class="widget-title">',
                        'after_title' => '</h6>'
    ));
    register_sidebar(array(
                        'name'=> 'footer-2',
                        'description' => 'Footer 2',
                        'id'=>'footer-2',
                        'before_widget' => '<div id="%1s" class="widget-item %2s">',
                        'after_widget' => '<div class="clr"></div></div>',
                        'before_title' => '<h6 class="widget-title">',
                        'after_title' => '</h6>'
    ));
    register_sidebar(array(
                        'name'=> 'footer-3',
                        'description' => 'Footer 3',
                        'id'=>'footer-3',
                        'before_widget' => '<div id="%1s" class="widget-item %2s">',
                        'after_widget' => '<div class="clr"></div></div>',
                        'before_title' => '<h6 class="widget-title">',
                        'after_title' => '</h6>'
    ));
    register_sidebar(array(
                        'name'=> 'footer-4',
                        'description' => 'Footer 4',
                        'id'=>'footer-4',
                        'before_widget' => '<div id="%1s" class="widget-item %2s">',
                        'after_widget' => '<div class="clr"></div></div>',
                        'before_title' => '<h6 class="widget-title">',
                        'after_title' => '</h6>'
    ));
}
require_once('includes/widgets/users.php');
require_once('includes/widgets/user-info.php');
require_once('includes/widgets/user-info-mini.php');
function makusi_load_widgets(){
    register_widget("videopress_users");
    register_widget("makusi_user_info");
    register_widget("makusi_user_info_mini");
}
add_action( 'widgets_init', 'makusi_load_widgets' );

/*Create a video custom post*/
add_action('init' , 'video_custom_post');

function video_custom_post(){
    $labels = array(
        'name' => __('Videos', 'post type general name'),
        'singular_name' => __('Videos'),
        'add_new'            => __( 'Add New', 'video' ),
        'add_new_item'       => __( 'Add New Video' ),
        'edit_item'          => __( 'Edit Video' ),
        'new_item'           => __( 'New Video' ),
        'all_items'          => __( 'All Videos' ),
        'view_item'          => __( 'View Video' ),
        'search_items'       => __( 'Search Videos' ),
        'not_found'          => __( 'No videos found' ),
        'not_found_in_trash' => __( 'No videos found in the Trash' ), 
        'parent_item_colon'  => '',
        'menu_name'          => 'Videos',
        
    );
    $args = array(
        'labels' => $labels,
        'description'   => 'Holds our Videos and video specific data',
        'public'        => true,
        'menu_position' => null,
        'show_ui' => true,
        'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
        'taxonomies' => array('category','post_tag'),
        'has_archive'   => true
    );
    register_post_type('videos',$args);
}
define('ICL_LANGUAGE_CODE', true);

function show_languages_anterior(){
    $languages = icl_get_languages('skip_missing=0'); ?>
    <?php
    if(0 < count($languages)){
        $temp = array();
        ?>
    <ul>
        <?php 
        foreach($languages as $l1){
            if($l1['language_code'] == ICL_LANGUAGE_CODE){
                array_unshift($temp, $l1); // assign default language to first position of temp array
            } else {
                array_push($temp, $l1); // add other languages to temp
            }  
        }
        $languages = $temp;
        unset($temp);
        foreach($languages as $l){ ?>
            <li<?php if($l['active'] !=1){ } else { ?> class="active"<?php } ?>>
                <a href="<?php echo $l['url']; ?>"><?php echo $l['native_name']; ?></a>
            </li>
        <?php } ?>
        </ul>
   <?php }
}
function show_languages(){
    $languages = icl_get_languages('skip_missing=0'); 
	// Primero sacamos el item correspondiente al idioma actual
	$temp = array(); $curLang=NULL; $cadena="";
	if(0 < count($languages)){
		foreach($languages as $l1){
			if($l1['language_code'] == ICL_LANGUAGE_CODE){
				$curLang=$l1;
				break;
			}
		}
		$cadena.="<div class='dropdown'>";
		$cadena.='<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
		$cadena.=$curLang['native_name'];
		$cadena.="<span class='caret'></span></button>";
		$cadena.='<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">';
		foreach($languages as $l1){
			if($l1['language_code'] == ICL_LANGUAGE_CODE) continue;
			$cadena.="<li role='presentation'><a role='menuitem' tabindex='-1' href='{$l1['url']}'>{$l1['native_name']}</a></li>";
		}
		$cadena.="</ul>";
		$cadena.="</div>";
		echo $cadena;
	}
}


add_action( 'wpuf_add_post_after_insert', 'my_upload_file' );

function my_upload_file($post_id) {    
    $attachments = get_children( array(
                    'post_parent' => $post_id, 
                    'post_type' => 'attachment', 
                    'post_mime_type' =>'video') );

    $i=0;
    foreach ( $attachments as $attachment_id => $attachment ): 
        if($i==0){
            $video = wp_get_attachment_url( $attachment_id, 'medium' );
            $path = get_attached_file( $attachment_id );
            $i++;
            global $wpdb;
            $wpdb->insert($wpdb->postmeta, 
            array(
                'meta_key'=>'queue_status',
                'meta_value'=>'waiting',
                'post_id' => $post_id)); 
           } else {
               return false;
           }
     endforeach;
}

add_filter('upload_mimes', 'mqw_mas_extensiones');
function mqw_mas_extensiones ( $existing_mimes=array() ) {
 
    // Añadimos las nuevas extensiones al array junto con su mime type de la siguiente forma:
    //http://www.paulund.co.uk/change-wordpress-upload-mime-types
        $existing_mimes['flv'] = 'video/flv';
        $existing_mimes['mp4'] = 'video/mp4';
        $existing_mimes['m4v'] = 'video/m4v';
        $existing_mimes['avi'] = 'video/avi';
        $existing_mimes['divx'] = 'video/divx';
        $existing_mimes['flv'] = 'video/flv';
        $existing_mimes['mov'] = 'video/mov';
        $existing_mimes['ogv'] = 'video/ogv';
        $existing_mimes['mpg'] = 'video/mpg';
        $existing_mimes['mpeg'] = 'video/mpeg';
        $existing_mimes['mpe'] = 'video/mpe';
        $existing_mimes['srt'] = 'text/srt';
        
    //Añadimos todas las que queramos y devolvemos el array
	return $existing_mimes;
}
function mk_video_attachment($post_id){
    $attachments = get_posts( array(
        'post_type' => 'attachment',
	'posts_per_page' => 0,
	'post_parent' => $post_id
	) );
        if(count($attachments)>0){
            foreach($attachments as $attachment){
                if(strstr($attachment->post_mime_type,'/',true) == 'video') {
                    echo wp_get_attachment_url($attachment->ID);
                }
            }
        }
}

function mk_video_for_mobile($post_id){
    $attachments = get_posts( array(
        'post_type' => 'attachment',
	'posts_per_page' => 0,
	'post_parent' => $post_id
	) );
        if(count($attachments)>0){
            foreach($attachments as $attachment){
                if(strstr($attachment->post_mime_type,'/',true) == 'video') {
                    if(isFileUrl(path_without_extension(wp_get_attachment_url($attachment->ID)).".webm") == true){
                        return path_without_extension(wp_get_attachment_url($attachment->ID)).".webm";
                    } else {
                        return false;
                    }
                }
            }
        }
}

function mk_video($post_id){
    $attachments = get_posts( array(
        'post_type' => 'attachment',
	'posts_per_page' => 0,
	'post_parent' => $post_id
	) );
    $attachments2 = $attachments;
    if(count($attachments)>0){
        foreach($attachments as $attachment){
            if(strstr($attachment->post_mime_type,'/',true) == 'video') {
                $metadata = wp_get_attachment_metadata( $attachment->ID );
                
                $thumbnail = $metadata['sizes']['single-video']['url']; 
		$ratio=(int)$metadata['sizes']['single-video']['height'] / (int)$metadata['sizes']['single-video']['width'];
		?>
			<div id="video-container" style="display:block;">
                            <div id="loadbar"><div id="loadprogressbar"></div></div>
                        <video 
                            id="video" 
                            class="video-js vjs-default-skin"
                            poster="<?php echo $thumbnail; ?>" 
                            data-setup="{}" >
                            <source src="<?php echo wp_get_attachment_url($attachment->ID); ?>" type="video/mp4" />
                            <source src="<?php echo path_without_extension(wp_get_attachment_url($attachment->ID));?>.webm" type="video/webm; codecs=vp8,vorbis" />
                                <?php 
                                foreach($attachments2 as $attachment2){                                    
                                    $metadata2 = wp_get_attachment_metadata( $attachment2->ID );
                                    if($attachment2->post_mime_type == 'text/srt'){ ?>
                                        <track kind="subtitle" src='<?php echo wp_get_attachment_url($attachment2->ID); ?>' srclang="es" label="Castellano"></track>
                                        <!-- Tracks need an ending tag thanks to IE9 -->
                                    <?php } else {}  
                                }  ?>
                        </video>
                        <div id='video_controls_bar'>
                            <button id='playpausebtn'><i class='fa fa-play'></i></button>
                            <input id='seekslider' type='range' min='0' max='100' value='0' step='1'>
                            <span id="curtimetext">00:00</span> / <span id="durtimetext">00:00</span>
                            <button id="mutebtn"><i class='fa fa-volume-off'></i></button>
                            <input id="volumeslider" type="range" min="0" max="100" value="100" step="1">
                            <button id="fullscreenbtn"><i class='fa fa-expand'></i></button>
                        </div>    
						<div class="clr"></div>
						<script>
						function resizeport(){
							var ratio=<?php echo $ratio ?>;
							var h=document.getElementById('video-container').clientWidth * ratio;
							document.getElementById('video-container').style.height = h + 'px';
							document.getElementById('video').style.height = h + 'px';
						}
						window.onresize=resizeport;
						resizeport();
						</script>
                    </div>
                    <?php
            }
        }
    }
}

function mk_obtain_thumb($post_id){
     $attachments = get_posts( array(
        'post_type' => 'attachment',
	'posts_per_page' => 0,
	'post_parent' => $post_id
	) );
    // var_dump($attachments);
    if($attachments){
        foreach($attachments as $attachment){
            if($attachment->post_mime_type == "video/mp4"){
                //var_dump($attachment);
                //echo $attachment->ID;
                $metadata = wp_get_attachment_metadata( $attachment->ID );
                $data = get_metadata( 'post',$attachment->ID, '_wp_attachment_metadata', true );
                //echo "<!--";
                //var_dump($data);
                //echo "-->";
                //var_dump($metadata);
                $thumbnail = $metadata['sizes']['single-video']['url'];
            }
        }
    }
    return $thumbnail;
}

function mk_obtain_video($post_id){
    $attachments = get_posts( array(
        'post_type' => 'attachment',
	'posts_per_page' => 0,
	'post_parent' => $post_id
	) );
    $video="";
    if(count($attachments) > 0){
        foreach($attachments as $attachment){
            if($attachment->post_mime_type == "video/mp4"){
                $video = wp_get_attachment_url($attachment->ID);
            }
        }
    }
    return $video;
}



function isFileUrl($url){
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // don't want it rendered to browser
  curl_exec($ch);

  if(curl_errno($ch)){
    $isFile = false;
  }
  else {
    $isFile = true;
  }
  curl_close($ch);
  return $isFile;
}

function lang_category_id($id){
  if(function_exists('icl_object_id')) {
    return icl_object_id($id,'category',true);
  } else {
    return false;
  }
}

/*Loops*/
require_once('includes/loops.php');

/* END Loops*/

function fb_sdk(){
        echo '<div id="fb-root"></div>
                <script>
                    window.fbAsyncInit = function() {
                    FB.init({
                        appId      : \'297837730416708\',
                        xfbml      : true,
                        version    : \'v2.2\'
                    });
                }
                (function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&appId=297837730416708&version=v2.0";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, \'script\', \'facebook-jssdk\'));</script>';
    }
    
function fb_tag($id){
    echo '<div
            class="fb-like"
            data-share="true"
            data-width="450"
            data-show-faces="true">
        </div>';
    } 
    
function twitter_button(){
    echo "<a href='https://twitter.com/share' 
            class='twitter-share-button' 
            data-via='makusiTV' 
            data-lang='es' 
            data-size='large' 
            data-dnt='true'>".__('Twittear','makusi')."</a>
            <script>
                !function(d,s,id){
                    var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
                    if(!d.getElementById(id)){
                        js=d.createElement(s);
                        js.id=id;
                        js.src=p+'://platform.twitter.com/widgets.js';
                        fjs.parentNode.insertBefore(js,fjs);
                        }
                 }(document, 'script', 'twitter-wjs');
             </script>";
}
/*-----------------------------------------------------------------------------------*/
/*	Function for Views Count
/*-----------------------------------------------------------------------------------*/
function makusi_countviews( $postid ){
    $makusi_meta_key = 'popularity_count';
    $makusi_meta_value = get_post_meta( $postid, $makusi_meta_key, true );
	
    /* Update the value if on single page */
    if( is_single() ){
	update_post_meta( $postid, $makusi_meta_key, $makusi_meta_value+1 );
    }
	
    /* Determin Weather the topic is hot or not */
    if( $makusi_meta_value == '' ){
        echo "<i class='fa fa-eye'></i>&nbsp;&nbsp;0";
    }else{
        echo "<i class='fa fa-eye'></i>&nbsp;&nbsp;";
        echo number_format($makusi_meta_value); /*. __(' Views ','makusi');*/
    }
}
//ADD COLUMN IN VIDEOS POST MANAGEMENT

add_filter('manage_edit-videos_columns', 'my_columns');
function my_columns($columns) {
    $columns['status'] = 'Status';
    return $columns;
}

add_action('manage_posts_custom_column', 'my_show_columns');
function my_show_columns($name) {
    global $post;
    switch ($name) {
        case 'status':
            $status = get_post_meta($post->ID, 'queue_status', true); 
            echo $status;
        }
    }
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function new_excerpt_more( $more ) {
	return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' . __('Leer mas', 'makusi') . '</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

function the_excerpt_max_charlength($charlength) {
	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		echo '[...]';
	} else {
		echo $excerpt;
	}
}

function the_title_max_charlength($charlength) {
	$title = get_the_title();
	$charlength++;
	if ( mb_strlen( $title ) > $charlength ) {
		//$subex = mb_substr( $title, 0, $charlength - 5 );
                $subex = mb_substr( $title, 0, $charlength );
		/*$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {*/
			echo $subex;
		//}
		echo ' [...]';
	} else {
		echo $title;
	}
}

add_shortcode('video2','show_video');

function show_video($atts, $content=""){
    $content = substr($_SERVER['REQUEST_URI'],0,-1);
    $array = explode('/', $content);
    $array = array_reverse($array);
    $string ="";
    
    $attachments = get_posts( array(
         'post_type' => 'attachment',
			'posts_per_page' => 0,
			'post_parent' => $array[0]
	 ) );
    if($attachments){
        foreach($attachments as $attachment){
            $thumbs = wp_get_attachment_metadata( $attachment->ID );
            $thumbnail = $thumbs['sizes']['home-screen']['url'];
            $string .= '
                <video 
                    id="example_video_1" 
                    class="video-js vjs-default-skin" 
                    controls 
                    preload="none"
                    poster="'.$thumbnail.'" 
                    data-setup="{}">
                    <!--video  id="example_video_1" class="video-js vjs-default-skin" controls preload="none" width="640" height="264" data-setup="{}"-->
                    <!--video onerror="failed(event)" controls width="620" height="274"-->
                        <source src="'.wp_get_attachment_url($attachment->ID).'" type="video/mp4" />
                        <!--source src="'.wp_get_attachment_url($attachment->ID).'" type="video/flv" /--> 
                        <!--source src="http://video-js.zencoder.com/oceans-clip.webm" type="video/webm" /-->
                        <!--source src="http://video-js.zencoder.com/oceans-clip.ogv" type="video/ogg" /-->
                        <!--track kind="captions" src="demo.captions.vtt" srclang="en" label="English"--></track><!-- Tracks need an ending tag thanks to IE9 -->
                        <!--track kind="subtitles" src="demo.captions.vtt" srclang="en" label="English"--></track><!-- Tracks need an ending tag thanks to IE9 -->
                    </video>';
            $string .='<!-- Video Controls >
		<div id="video-controls">
			<button type="button" id="play-pause" class="play">Play</button>
			<input type="range" id="seek-bar" value="0">
			<button type="button" id="mute">Mute</button>
			<input type="range" id="volume-bar" min="0" max="1" step="0.1" value="1">
			<button type="button" id="full-screen">Full-Screen</button>
		</div-->';
        }
    }
    return $string;
}


function get_translated_category_name($cat_id){
    global $sitepress;
    return $sitepress->the_category_name_filter($sitepress->get_category_name($cat_id));
}

function path_without_extension($path){
	return $withoutExt = preg_replace("/\\.[^.\\s]{3,4}$/","", $path);
}

function url_without_extension($path){
	$pathArray = explode('/', $path);
	$pathArrayReverse = array_reverse($pathArray);
	$filename = $pathArrayReverse[0]; 
	$filenameArray = explode('.',$path);
	$filenameArrayReverse = $filenameArray;
	return $filenameArray[0];
}