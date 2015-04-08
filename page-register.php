<?php 

/**
*  Template Name: Register
* 
*/
    $err = '';
    $success = '';
    //var_dump($_POST);
    global $wpdb, $PasswordHash, $current_user, $user_ID;
    
    if(isset($_POST['task']) && $_POST['task'] == 'register' ) {
        //2. VALIDATE
        $validates = true;
        // Check if username and email exist
        if ( !username_exists( $_POST['username'] ) and email_exists($_POST['email']) == false ) { 
            if( $_POST['user-name'] == '' ||  $_POST['user-email'] == '' || $_POST['user-pass'] == '' || $_POST['password-check'] == ''){ 
                   
                $err .= '<strong>'.__('CAMPOS VACIOS: ','makusi').'</strong><br /><br />';
                $err .=  '<ul>';
                    if ($_POST['user-name'] == '') {
                        $err .= '<li>'.__('Usuario','makusi').'</li>';
                    }
                    if ($_POST['user-email'] == '') {
                        $err .= '<li>'.__('Email','makusi').'</li>';
                    }
                    if ($_POST['user-pass'] == '') {
                        $err .= '<li>'.__('1ª Contraseña','makusi').'</li>';
                    }
                    if ($_POST['password-check'] == '') {
                        $err .= '<li>'.__('2ª Contraseña','makusi').'</li>';
                    }
                    $err .=  "</ul>";
                    $validates = false;
                } else { ?>                    
                <?php   
                    if(!is_email($_POST['user-email']) || $_post['user-pass'] != $_POST['password-check']){ ?>
                <?php   if(!is_email($_POST['user-email'])){
                            
                            $err .=  __('Tu email no es válido','makusi').'<br />';
                            $validates = false;
                        }
                        if ($_POST['user-pass'] != $_POST['password-check']){
                            
                            $err .=  __('Tus contraseñas no coinciden','makusi').'<br />';
                            $validates = false;
                        } 
                    }
                }
            } else {
                if(username_exists( $_POST['user-name']) || email_exists($_POST['user-email']) == true) { 
                    
                        if(username_exists( $_POST['user-name'] )){
                            $err .=  __('Este nombre de usuario ya ha sido creado. Por favor elige otro','makusi').'<br /><br />';
                            $validates = false;
                        }
                        if(email_exists($_POST['user-email']) == true){
                            $err .=  __('Una cuenta con esta dirección electrónica ya ha sido creada. Por favor, inserta otra.','makusi').'<br />';
                            $validates = false;
                        }
                    }
            } 
            
            ?>
            
            <?php
            //CREATE ACCOUNT
            if($validates == true) {
                $userdata = array( 
                    'user_login' => $_POST['user-name'],
                    'user_email' => $_POST['user_email'],
                    'first_name' => $_POST['first_name'],
                    'last_name' => $_POST['last_name'],
                    'user_pass' => $_POST['user_pass']
                );

                // Check if username and email exist
                       
                // Register into database
                $user_id=wp_insert_user($userdata);
                    
                update_user_meta( $user_id, 'wp_3_user_level', 2 );
                    
                // Send password to email
                $subject = get_bloginfo('name').__('Crear cuenta','makusi');
                $message = __('Hola y bienvenid@ a makusi.tv. ','makusi');
                $message .= __('Crear una contraseña: ','makusi').$_POST['password'];
                $header = 'from: Registration '.get_option('admin_email');
                $send_contact=mail($userdata['user_email'], $subject, $message, $header);	
                // Notify Success
                $success .= __('Tu cuenta ha sido creada con éxito.','makusi');    	
        }
    }
?>

<?php get_header(); ?>
    <div class="single-wrapper">
        <div class="content col-md-8 page-<?php echo $post->post_name; ?>">
            <?php
            while (have_posts()) : the_post();
                the_title('<h2>', '</h2>');
                the_content(); 
            endwhile; 
            echo "<br /><br />";
            if($err != ''){ ?>
                <div class="widget-register-error">
                <?php echo $err; ?>
                </div>
            <?php }
            if($success != ''){ ?>
            <div class="widget-register-success">
                <?php echo $success; ?>
            </div>    
            <?php } else { ?>
                 <form action="<?php echo site_url('registered') ?>" method="post" class="user-forms">
                    <div class="invite-row">
                        <input type="text" name="first-name" placeholder="<?php echo __('Nombre','makusi'); ?>" class="user-input input-register-firstname" />
                        <input type="text" name="last-name" placeholder="<?php echo __('Apellido','makusi'); ?>" class="user-input input-register-lastname" />
                        <div class="clear"></div>
                    </div>
                    <div class="invite-row">
                        <input type="text" name="user-name" placeholder="<?php echo __('Usuario','makusi'); ?>" class="user-input input-register-username"/>
                        <input type="text" name="user-email" placeholder="<?php echo __('Dirección Email','makusi'); ?>"  class="user-input input-register-email" />
                        <div class="clear"></div>
                    </div>
                    <div class="invite-row">
                        <input type="password" name="user-pass" placeholder="<?php echo __('Contraseña','makusi'); ?>" class="user-input input-register-password" />
                        <input type="password" name="password-check" placeholder="<?php echo __('Repetir Contraseña','makusi'); ?>" class="user-input input-register-password2" />
                        <div class="clear"></div>
                    </div>
                    <?php //do_action('register_form'); ?>
                    <p><input type="submit" value="Register" id="register" class="btn btn-primary btn-sm" /></p>
                    <input type="hidden" name="task" value="register" />
                </form>
           <?php } ?>
        </div>
        <aside class="col-md-4"> 
            <?php 
                if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('home-right')) :
                endif;
            ?>
            <?php //get_sidebar(); ?>
        </aside>
        <div class="clear"></div>
    </div>
<?php get_footer(); ?>
