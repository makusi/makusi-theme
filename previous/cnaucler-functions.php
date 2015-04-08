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
remove_filter( 'the_excerpt', 'wpautop' );

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
function makusi_load_widgets(){
    register_widget("videopress_users");
    register_widget("makusi_user_info");
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

function show_languages(){
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
                
                $thumbnail = $metadata['sizes']['single-video']['url']; ?>
                
                    <div id="video-container">
                        <video 
                            id="video" 
                            class="video-js vjs-default-skin"
                            poster="<?php echo $thumbnail; ?>" 
                            data-setup="{}">
                            <source src="<?php echo wp_get_attachment_url($attachment->ID); ?>" type="video/mp4" />
                                <?php 
                                
                                foreach($attachments2 as $attachment2){
                                    //echo "<!--";
                                   //var_dump($attachment2);
                                    //echo "-->";
                                    $metadata2 = wp_get_attachment_metadata( $attachment2->ID );
                                    //echo "<!--";
                                    //var_dump($metadata2);
                                    //echo "-->";
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
    if($attachments){
        foreach($attachments as $attachment){
            if($attachment->post_mime_type == "video/mp4"){
                $metadata = wp_get_attachment_metadata( $attachment->ID );
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

/* USER FUNCTIONS */

/** 
 * Custom User Contact Methods
 */
add_filter( 'user_contactmethods', 'mk_custom_user_contactmethods');
function mk_custom_user_contactmethods($methods) {
	// Add custom contact methods
	$new_methods = array(
		'twitter' => __('Twitter', 'dp'),
		'facebook' => __('Facebook', 'dp'),
		'location' => __('Locación', 'dp')
	);
	
	return $new_methods + $methods;
}

// Get queried user id
function mk_get_queried_user_id() {
	global $authordata;
	if(isset( $authordata->ID )){
		$user_id = $authordata->ID;
	} else {
		$user = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
		$user_id = $user->ID;
	}
	return $user_id;
}

function count_attachments_by_user($user_id){
    
    $args = array(
            'author'=> $user_id,
            'post_status'=> 'publish',
            'post_type'=>'videos'
            );
     $query = new WP_Query($args);
     if ( $query->have_posts() ) {
         $attachments_counter = 0;
         $attachments_memory_counter = 0;
            while ($query->have_posts()){
                $query->the_post();
                $attachments = get_children( 
                                array(
                                    'post_type' => 'attachment',
                                    'posts_per_page' => -1,
                                    'post_parent' => $query->post->ID
                                    ) );
                
                if(count($attachments) > 0){
                    $attachments_counter ++;
                    foreach ($attachments as $attachment){ 
                        $attachment_data = wp_get_attachment_metadata( $attachment->ID );
                        $attachments_memory_counter = $attachments_memory_counter +  $attachment_data['filesize'];
                    }
                }    
            }
            $data['attachments_counter'] = $attachments_counter;
            $data['attachments_memory_counter'] = $attachments_memory_counter;
            return $data;           
       } 
}

function count_user_posts_by_type( $userid, $post_type = 'post' ) {
	global $wpdb;
	$where = get_posts_by_author_sql( $post_type, true, $userid );
	$count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts $where" );
  	return apply_filters( 'get_usernumposts', $count, $userid );
}

function byteFormat($bytes, $unit = "", $decimals = 2) {
	$units = array(
					'B' => 0, 
					'Kb' => 1, 
					'Mb' => 2, 
					'Gb' => 3, 
					'Tb' => 4, 
					'Pb' => 5, 
					'Eb' => 6, 
					'Zb' => 7, 
					'Yb' => 8);
	$value = 0;

	if ($bytes > 0) {           
		if (!array_key_exists($unit, $units)) {
                    $pow = floor(log($bytes)/log(1024));
                    $unit = array_search($pow, $units);
		}
                
		$value = ($bytes/pow(1024,floor($units[$unit])));
	}
 
	// If decimals is not numeric or decimals is less than 0 
	// then set default value
	if (!is_numeric($decimals) || $decimals < 0) {
		$decimals = 2;
	}
 
	// Format output
	return sprintf('%.' . $decimals . 'f '.$unit, $value);
  }

function unbyteFormat($value, $unit){
    $units = array(
		'b' => 0, 
		'Kb' => 1, 
		'Mb' => 2, 
		'Gb' => 3, 
		'Tb' => 4, 
		'Pb' => 5, 
		'Eb' => 6, 
		'Zb' => 7, 
		'Yb' => 8);
    $value = 0;
    if ($bytes > 0) {
        $bytes = ($value*pow(1024,floor($units[$unit])));
    }
    return $bytes;
}
  /*USER MANAGEMENT*/
  /* add_user_meta( $user_id, $meta_key, $meta_value, $unique ); */
  /* wp_usermeta: umeta_id user_id meta_key meta_value*/
  /* delete_user_meta( $user_id, $meta_key, $meta_value ) */
  /* get_user_meta($user_id, $key, $single); */
  /* update_user_meta( $user_id, $meta_key, $meta_value, $prev_value ) */
  /* get_user_option( $option, $user ) */
  /* delete_user_option( $user_id, $option_name, $global ); */
  
  /* register_new_user( $user_login, $user_email ); */
  
  /* wp_create_user( $username, $password, $email ); */
  /* wp_insert_user( $userdata ); 

   *    */
add_action('init', 'myStartSession', 1);

function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

add_action('show_user_profile', 'UserMemory_add');
add_action('edit_user_profile', 'UserMemory_add');
add_action('edit_user_profile_update', 'UserMemory_update'); 
add_action('personal_options_update', 'UserMemory_update');

function UserMemory_add($user){ 
    $user_id = $user->ID;
    //echo "<pre>";
    //var_dump(get_user_meta($user_id));
    //echo "</pre>";
    $memory_add = get_user_meta($user_id, "user_memory_txt",true);
    $user_prepaid = get_user_meta($user_id, "user_prepaid",true);
    $user_pack = get_user_meta($user_id, "wpuf_sub_pack",true);
    ?>
    <h3>Extra Fields</h3>
    <table class="form-table">
        <tr>
            <th><label for="user_memory_txt">Memory Limit</label></th>
            <td><select id="user_memory_txt" name="user_memory_txt">
                <?php $packs = WPUF_Subscription::get_subscription_packs(); ?>
                    <?php foreach($packs as $pack){ ?>
                        <option value="<?php echo $pack->id; ?>"<?php if($user_pack == $pack->id){ ?> selected<?php }?>>
                            <?php echo $pack->name; ?>
                        </option>    
                    <?php } ?>
                </select>
                <br />
                <span class="description">><?php echo __('Enter your Memory Limit here.','makusi'); ?></span>
            </td>
        </tr>
        <tr>
             <th><label for="user_prepaid_txt">Prepaid User</label></th>
             <td>
                 Yes <input type="radio" name="user_prepaid" value="Yes" <?php if($user_prepaid == "Yes"){ ?>checked<?php } ?> />
                 No<input type="radio" name="user_prepaid" value="No" <?php if($user_prepaid == "No"){ ?>checked<?php } ?> />
             </td>
        </tr>
    </table>
    <?php            
        }

function UserMemory_update($user_id){
    
    update_user_meta($user_id,"wpuf_sub_pack",$_POST['user_memory_txt']);
    $packs = WPUF_Subscription::get_subscription_packs();
    foreach($packs as $pack) {
        if($pack->id == $_POST['user_memory_txt']){
            update_user_meta($user_id,"wpuf_sub_memcount",$pack->memcount);
        }
    }
    update_user_meta($user_id, "wpuf_sub_validity",date( 'Y-m-d G:i:s', time()+(365*24*60*60)));
    update_user_meta($user_id, "user_memory_txt",$_POST['user_memory_txt']);
    update_user_meta($user_id, "user_prepaid",$_POST['user_prepaid']);
}


/* AJAX USER REGISTER */
add_action('wp_ajax_process_register', 'process_register_callback');
add_action('wp_ajax_nopriv_process_register', 'process_register_callback');

function process_register_callback(){
   
    $nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'register-ajax-nonce' ) )
        die ( 'Este acceso no es permitido');
    if(isset($_POST['trigger_register']) && !empty($_POST['trigger_register'])) {
        //1. LOAD SCRIPTS
        
        load_scripts_users_ajax();
        
        //2. VALIDATE
        $check_recaptcha = check_recaptcha();
        $validates = true;
        // Check if username and email exist
        if ( !username_exists( $_POST['user_login'] ) && email_exists($_POST['user_email']) == false ) { ?>
            <?php  
            if( $_POST['user_login'] == '' || 
                $_POST['user_email'] == '' || 
                $_POST['user_pass'] == '' || 
                $_POST['password_check'] == '' ||
                    !$check_recaptcha->is_valid){ ?>
                    <div class="widget-register-error">
                        <strong>'.<?php echo __('ERROR - CAMPOS VACIOS: ','makusi'); ?></strong><br /><br />
                        <ul>
                            <?php if ($_POST['user_login'] == '') {
                                echo '<li>'.__('Usuario','makusi').'</li>';
                            }
                            if ($_POST['user_email'] == '') {
                                echo '<li>'.__('Email','makusi').'</li>';
                            }
                            if ($_POST['user_pass'] == '') {
                                echo '<li>'.__('Contraseña','makusi').'</li>';
                            }
                            if ($_POST['password_check'] == '') {
                                echo '<li>'.__('Repite Contraseña','makusi').'</li>';
                            }
                            if (!$check_recaptcha->is_valid) {
                                echo '<li>'. __("El reCAPTCHA no ha sido introducido correctamente. Por favor, vuelve a intentarlo. ","makusi").$check_recaptcha->error.'</li>';
                            }
                            ?>
                        </ul>
                        <?php $validates = false;
            } else { ?>                    
                <?php   
                if(!is_email($_POST['user_email']) || $_post['user_pass'] != $_POST['password_check']){                        
                    if(!is_email($_POST['user_email'])){ ?>
                        <div class="widget-register-error"> <?php echo __('ERROR: ','makusi'); ?>
                            <?php echo __('Tu dirección de email no es válida','makusi').'<br />';
                                $validates = false;
                    }
                    if ($_POST['user_pass'] != $_POST['password_check']){ ?>
                        <div class="widget-register-error"> <?php echo __('ERROR: ','makusi'); ?>    
                            <?php echo __('Tus contraseñas no coinciden','makusi').'<br />';
                                $validates = false;
                    } 
                }
            }
        } else {
            if(username_exists( $_POST['user_login']) || email_exists($_POST['user_email']) == true) { ?>
                <div class="widget-register-error"> <?php echo __('ERROR: ','makusi'); ?>
                    <?php    
                    if(username_exists( $_POST['user_login'] )){
                        echo __('Este nombre de usuario ya ha sido creado. Por favor elige otro.','makusi').'<br /><br />';
                        $validates = false;
                    }
                    if(email_exists($_POST['user_email']) == true){
                        echo __('Una cuenta con esta dirección ha sido creada','makusi').'<br />';
                        $validates = false;
                    }
            } ?>
        </div>
        <?php } ?>
            <?php
            //CREATE ACCOUNT
            if($validates == true) {
                $userdata = array( 
                    'user_login' => $_POST['user_login'],
                    'user_email' => $_POST['user_email'],
                    'first_name' => $_POST['first_name'],
                    'last_name' => $_POST['last_name'],
                    'user_pass' => $_POST['user_pass']
                );

                // Check if username and email exist
                       
                // Register into database
                $user_id=wp_insert_user($userdata);
                    
                update_user_meta( $user_id, 'wp_3_user_level', 2 );
                if($_POST['package'] !=0 ){
                    $subscription = WPUF_Subscription::get_subscription($_POST['package']);
                    //update_user_meta( $user_id, 'wpuf_sub_memcount' , $subscription->memcount);
                    update_user_meta( $user_id, 'wpuf_sub_pack' , $_POST['package']);
                }
                // Send password to email
                $subject = get_bloginfo('name').__(' | Creación de cuenta en makusi.tv','makusi');
                $message = __('Hola y bienvenid@ a makusi.tv. Tu cuenta ha sido creada con éxito  ','makusi');
                $message .= __('Aquí tienes tu contraseña, para recordarla: ','makusi').$_POST['user_pass'];
                $header = 'MIME-Version: 1.0' . "\r\n".'Content-type: text/html; charset=utf-8' . "\r\n".'from: '.__('Creación de cuenta ','makusi') . get_option('admin_email');
                $send_contact=mail($userdata['user_email'], $subject, $message, $header);	
                // Notify Success
                echo '<div class="widget-register-success">'.__('Tu cuenta ha sido creada correctamente. La página se recargará en 3 segundos. Una vez recargada la página puedes entrar.','makusi').'</div>';    	
	}
  }
  die();
}

function check_recaptcha(){
    //require_once(trailingslashit(get_template_directory()) . '/includes/recaptcha/recaptchalib.php');
    $privatekey = "6LcMiPwSAAAAALNx9sQzbxiyCe6_-mEHKtKWnuTy";
    $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
    return $resp;
    /*if (!$resp->is_valid) {
        // What happens when the CAPTCHA was entered incorrectly
        /*die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
            "(reCAPTCHA said: " . $resp->error . ")");
        return false;
    } else {
        // Your code here to handle a successful verification
        /*return true;
    }*/
}

/* AJAX USER LOGIN */
add_action('wp_ajax_process_login', 'process_login_callback');
add_action('wp_ajax_nopriv_process_login', 'process_login_callback');

function process_login_callback(){
    $nonce = $_POST['nonce'];
        if ( ! wp_verify_nonce( $nonce, 'login-ajax-nonce' ) )
            die ( 'Este acceso no es permitido');
        
    if(isset($_POST['trigger_login']) && !empty($_POST['trigger_login'])) {
        $user = custom_login();
        $errors = $user->errors;
        $userdata = get_userdata( $user->ID ); //wp 3.3 fix
        load_scripts_users_ajax();
        $validate = true;
        //1. Validate
        if($_POST['log'] =='' || $_POST['pwd'] =='' || !username_exists( $_POST['log']) || $errors['incorrect_password'][0] !=""){
            $validate = false;
            echo '<div class="widget-register-error">';
            echo '<ul>';
            if($_POST['log'] =='' || $_POST['pwd'] ==''){
                $validate = false;
                if($_POST['log'] ==''){
                    echo "<li>".__('El campo de usuario está vacio','makusi')."</li>";
                }
                if($_POST['pwd'] ==''){
                    echo "<li>".__('El campo de contraseña está vacio','makusi')."</li>";
                }
            } elseif(!username_exists( $_POST['log']) || $errors['incorrect_password'][0] !=""){
                if(!username_exists( $_POST['log'])){
                    echo "<li>".__('Tu nombre de usuario no existe','makusi')."</li>";
                }
                if($errors['incorrect_password'][0] !=""){
                    echo "<li>".__('Tu contraseña no es correcta','makusi')."</li>";
                }
            } else {
                echo "<li>".__('La validación ha fallado','makusi')."</li>";
            }
            echo "<li>".__('Esta página se recargará en <span>3</span> segundos.','makusi')."</li>";
            echo '</ul>';
            echo '</div>';
        } elseif( $user->id !='' && $validate= true ){
            echo '<div class="widget-register-success">'.__('El usuario se ha conectado correctamente. Esta página va a recargarse en <span>3</span> segundos.','makusi').' </div>';
        }
    }
    die();
}

function load_scripts_users_ajax(){
    $result = '<script type="text/javascript">';
    $result .= 'var URL = "'.admin_url( 'admin-ajax.php' ).'";'; 
    $result .= 'var NONCE = "'. wp_create_nonce( 'lost_password-ajax-nonce' ) .'";';
    $result .= '</script>';
    $result .= '<script type="text/javascript" src="'. get_template_directory_uri() .'/js/ajax.js"></script>';
    echo $result;
}

function custom_login() {
    $creds                  = array();
    $creds['user_login']    = stripslashes( trim( $_POST['log'] ) );
    $creds['user_password'] = stripslashes( trim( $_POST['pwd'] ) );
    $creds['remember']      = isset( $_POST['remember'] ) ? sanitize_text_field( $_POST['remember'] ) : '';
    $secure_cookie          = null;
    // If the user inputs an email address instead of a username, try to convert it
	if ( is_email( $creds['user_login'] ) ) {
            if ( $user = get_user_by( 'email', $creds['user_login'] ) ) {
		$creds['user_login'] = $user->user_login;
            }
	}
        // If the user wants ssl but the session is not ssl, force a secure cookie.
	if ( ! force_ssl_admin() ) {
            $user_name = sanitize_user( $creds['user_login'] );
            if ( $user = get_user_by( 'login',  $user_name ) ) {
                if ( get_user_option( 'use_ssl', $user->ID ) ) {
                    $secure_cookie = true;
                    force_ssl_admin( true );
                }
            }
	}

	if ( force_ssl_admin() ) {
            $secure_cookie = true;
	}

	if ( is_null( $secure_cookie ) && force_ssl_login() ) {
            $secure_cookie = false;
	}
                
    $user = wp_signon($creds, $secure_cookie );
    $result = array();
    if ( ! is_wp_error( $user ) ) {
	$result['success']  = 1;
	$result['redirect'] = $redirect_to;
    } else {
	$result['success'] = 0;
	if ( $user->errors ) {
            foreach ( $user->errors as $error ) {
                $result['error'] = $error[0];
		break;
            }
	} else {
            $result['error'] = __( 'Por favor introduce tu nombre de usuario y contraseña para entrar.', 'sidebar-login' );
	}
    }
    return $user;
}
// run it before the headers and cookies are sent
//add_action( 'after_setup_theme', 'custom_login' );

/* AJAX USER LOGIN */
add_action('wp_ajax_process_lost_password', 'process_lost_password_callback');
add_action('wp_ajax_nopriv_process_lost_password', 'process_lost_password_callback');

function process_lost_password_callback(){
    $nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'lost_password-ajax-nonce' ) )
        die ( 'Este acceso no es permitido');
    
    if(isset($_POST['trigger_lost']) && !empty($_POST['trigger_lost'])) {
        // Check if valid email
        load_scripts_users_ajax();
        if( is_email($_POST['lost_email']) ){
            $user = get_user_by( 'email', $_POST['lost_email'] );
            $random_password = wp_generate_password( '12', false, false );
            $new_password = wp_set_password( $random_password, $user->ID );
		
            // Send password to email
            $subject = get_bloginfo('name'). __(" ¿Olvidaste tu contraseña?","makusi");
            $message = '<h3>'. __('Recuperación de la contraseña.','makusi').'</h3>';
            $message .= '<p>'.__('Esta es tu nueva contraseña: ','makusi').$random_password . '</p>';
            $message .= '<p>'.__('Este mensaje le ha sido enviado por la petición enviada por su parte a makusi.tv para la recuperación de su contraseña','makusi').'</p>';
            $header = 'MIME-Version: 1.0' . "\r\n".'Content-type: text/html; charset=utf-8' . "\r\n".'From: '.__('Creación de cuenta ','makusi').get_option('admin_email');
            $send_contact=mail($_POST['lost_email'], $subject, $message, $header);
            
            echo '<div class="widget-register-success">'. __('Te hemos enviado la contraseña por email.','makusi').' </div>';
            exit;
        } else { // If Email not valid
            echo '<div class="widget-register-error">'. __('Tu dirección de correo electrónico no se válida.','makusi').'</div>';
        } // End Email Validation
    }
}

add_action('wp_ajax_contact_sender', 'contact_sender_callback');
add_action('wp_ajax_nopriv_contact_sender', 'contact_sender_callback');

function contact_sender_callback(){
    $nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'contact_sender-nonce' ) )
        die ( 'Este acceso no es permitido');
    
    
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