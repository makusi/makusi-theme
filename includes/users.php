<?php

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
                    'user_pass' => $_POST['user_pass'],
                    'role' => 'author'
                );

                // Check if username and email exist
                       
                // Register into database
                $user_id=wp_insert_user($userdata);
                wp_update_user( array ('ID' => $id, 'role' => 'author' ) ) ;    
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

add_action('wp_ajax_nopriv_contact_sender', 'contact_sender_callback');
add_action('wp_ajax_contact_sender', 'contact_sender_callback');

function contact_sender_callback(){
    $nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'contact_sender-ajax-nonce' ) )
        die ( 'Este acceso no es permitido');
    load_scripts_users_ajax();
    if( $_POST['contactsenderemail'] != "" && is_email($_POST['contactsenderemail']) && $_POST['contactsendername'] != "" && $_POST['contactsendermessage'] != ""){
        
        $author = get_userdata($_POST['contactsenderid']);
        $to = $author->user_email;
        $headers[] = 'From: '.$_POST['contactsendername'].' <'.$_POST['contactsenderemail'].'>';
        $headers[] = "MIME-Version: 1.0";
        $headers[]= "Content-Type: text/html; charset=UTF-8";
       
        $subject = __('Mensaje enviado por ','makusi').$_POST['contactsendername'].__(' desde makusi.tv','makusi');
        $message = __('Este mensaje te llega desde la página web de makusi.tv.','makusi');
        $message .= '<br />';
        $message .= '<strong>';
        $message .= __('Enviado por: ','makusi');
        $message .= '</strong>';
        $message .= $_POST['contactsenderemail'];
        $message .='<br /> ';
        $message .= '<strong>';
        $message .= __('Mensaje: ','makusi');
        $message .= '</strong>';
        $message .='<br /> ';
        $message .= $_POST['contactsendermessage'];
        if(wp_mail($to, $subject, $message, $headers)) {
            //var_dump($author);
            echo __('Gracias ').'<strong>'. $_POST['contactsendername'] ."</strong>. ".__('Tu mensaje fué enviado a ','makusi').'<strong>'.$author->display_name .'<strong>';
            exit;
        } else {
            echo __('Tu mensaje a: ','makusi').$to.__(" no ha sido enviado correctamente.",'makusi');
            exit;
        }
    } else {
        echo '<div class="widget-register-error">';
        if($_POST['contactsenderemail'] == ""){
            echo __('No has rellenado el campo del email.','makusi');
            echo '<br />';
            
        }
        if($_POST['contactsendername'] == ""){
            echo __('No has rellenado el campo del Nombre.','makusi');
            echo '<br />';

        }
        if($_POST['contactsendermessage'] == ""){
            echo __('No has rellenado el campo del Mensaje.','makusi');
            echo '<br />';
        }
        if($_POST['contactsenderemail'] != "" && !is_email($_POST['contactsenderemail'])){
            echo __('No has introducido una dirección de correo electrónica válida.','makusi');
            echo '<br />';
        }
        echo '<a href="#" id="show_contactsender_form">'.__('Mostrar el formulario').'</a>';
        echo '</div>';
        exit;
    }
    
}



/*User Settings*/
/* Upload Local Avatar */
/* Save Settings into usermeta */

function upload_local_avatar($user_id){
    if(isset($_FILES)){
        if ( false !== strpos( $_FILES['avatar']['name'], '.php' ) ) {
            echo __('For security reasons, the extension ".php" cannot be in your file name.','makusi');
            return;
        }
        if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
            $uploaddir = wp_upload_dir();
 
            $uploadfile = $uploaddir['path'] ."/". basename($_FILES['avatar']['name']);
            $uploadurlfile = $uploaddir['url'] ."/". basename($_FILES['avatar']['name']);
            $upload_overrides = array(  'mimes' => array(
                                            'jpg|jpeg|jpe' => 'image/jpeg',
                                            'gif' => 'image/gif',
                                            'png' => 'image/png'
				),
                                    'test_form'	=> false );
            $upload_handle =  wp_handle_upload( $_FILES['avatar'], $upload_overrides );
        //var_dump($upload_handle);
        if($upload_handle != false){
            //$newimage = image_resize( $uploadfile, 80, 80, true, '_80x80', $uploaddir, 80 );
            $editor = wp_get_image_editor( $uploadfile );
            if ( ! is_wp_error( $editor ) ) {
                $editor->resize( 80, 80, true );
                $new_image_info = $editor->save( substr($uploadfile,0,strlen($uploadfile)-4).'_80x80.png' );
            }
            //var_dump($new_image_info);
            $array = explode('/',$new_image_info['path']);
            $array_reverse = array_reverse($array);
            $newuploadurlfile = $uploaddir['url'].'/'.$array_reverse[0];
            //echo "El archivo es válido y fue cargado exitosamente.\n";
            $avatar_data = array(
                            'full'=>$uploadurlfile,
                            '80'=>$newuploadurlfile);
            
            //var_dump($avatar_data);
            $update = update_user_meta( $user_id, 'avatar', $avatar_data );
            return true;
        } else {
            return false;
        }
    }
}

function show_avatar($user_id){
    $useravatar = get_user_meta($user_id, 'avatar', true);
    
    if($useravatar['80'] != ''){
        echo $useravatar['80'];
    } else {
        return false;
    }
    
}

function validate_gravatar($email) {
	// Craft a potential url and test its headers
	$hash = md5(strtolower(trim($email)));
	$uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
	$headers = @get_headers($uri);
	if (!preg_match("|200|", $headers[0])) {
		$has_valid_avatar = FALSE;
	} else {
		$has_valid_avatar = TRUE;
	}
	return $has_valid_avatar;
}
