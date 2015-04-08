<?php
/**
 * Template Name: User Profile
 *
 * Allow users to update their profiles from Frontend.
 *
 */

/* Get user info. */
global $current_user, $wp_roles;
get_currentuserinfo();

require_once( ABSPATH . WPINC . '/registration.php' );
$error = array();  

$upload_ok = upload_local_avatar($current_user->ID);       
/* If profile was saved, update profile. */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {

    /* Update user password. */
    if ( !empty($_POST['pass'] ) && !empty( $_POST['pass2'] ) ) {
        if ( $_POST['pass'] == $_POST['pass2'] ){
            wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['pass'] ) ) );
            $password_update = "true";
        } else {
            $error[] = __('Las contraseñas no coinciden. Por favor inténtalo de nuevo.', 'makusi');
            $password_update = "false";   
        }
    }

    /* Update user information. */
    if ( !empty( $_POST['url'] ) )
        update_user_meta( $current_user->ID, 'user_url', esc_url( $_POST['url'] ) );
    if ( !empty( $_POST['email'] ) ){
        if (!is_email(esc_attr( $_POST['email'] )))
            $error[] = __('La dirección que has introducido no es correcta. Por favor inténtalo de nuevo.', 'makusi');
        elseif(email_exists(esc_attr( $_POST['email'] )) != $current_user->id )
            $error[] = __('Esta dirección de email ya está siendo utilizada por otro usuario. Inténta con otra dirección.', 'makusi');
        else{
            wp_update_user( array ('ID' => $current_user->ID, 'user_email' => esc_attr( $_POST['email'] )));
            if ( !empty( $_POST['showemail'] ) ){
                update_user_meta( $current_user->ID, 'showemail', esc_attr( $_POST['showemail'] ) );
            } else {
                update_user_meta( $current_user->ID, 'showemail', 'no' );
            }
        }
    }

    if ( !empty( $_POST['first-name'] ) )
        update_user_meta( $current_user->ID, 'first_name', esc_attr( $_POST['first-name'] ) );
    if ( !empty( $_POST['last-name'] ) )
        update_user_meta($current_user->ID, 'last_name', esc_attr( $_POST['last-name'] ) );
    if ( !empty( $_POST['description'] ) )
        update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['description'] ) );
    if ( !empty( $_POST['twitter'] ) )
        update_user_meta( $current_user->ID, 'twitter', $_POST['twitter'] );
    if ( !empty( $_POST['facebook'] ) )
        update_user_meta( $current_user->ID, 'facebook', $_POST['facebook'] );
    if ( !empty( $_POST['google-plus'] ) )
        update_user_meta( $current_user->ID, 'google-plus', $_POST['google-plus'] );
    /*if( !empty ($_POST['avatar'])){
        $simple_local_avatars->edit_user_profile_update($current_user->ID);
    }*/

    /* Redirect so the page will show updated info.*/
  /*I am not Author of this Code- i dont know why but it worked for me after changing below line to if ( count($error) == 0 ){ */
    /*if ( count($error) == 0 ) {
        //action hook for plugins and extra fields saving
        do_action('edit_user_profile_update', $current_user->ID);
        wp_redirect( get_permalink() );
        exit;
    }*/
}
?>
<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class="content_author col-md-8" id="post-<?php the_ID(); ?>">
        <div class="entry-content entry">
            <h3><?php the_title(); ?></h3>
            <?php if($password_update == "false"){ ?>
            <div class="alert alert-danger">
                <?php _e('<strong>ERROR!</strong> Las contraseñas introducidas no coinciden. Tu contraseña no ha sido actualizada.', 'makusi'); ?>
            </div>
            <?php } elseif($password_update == "true") { ?>
            <div class="alert alert-success">
                <?php _e('<strong>CORRECTO!</strong> Has actualizado tu contraseña correctamente.', 'makusi'); ?>
            </div>
            <?php } ?>
            <?php //if($upload_ok == "false"){ ?>
                <!--div class="alert alert-danger"-->
                     <?php //_e('<strong>ERROR!</strong> El archivo de foto no ha sido subido correctamente','makusi'); ?>
                <!--/div-->
            <?php //}elseif($upload_ok == "true"){ ?>
                <!--div class="alert alert-success"-->
                        <?php //_e('<strong>CORRECTO!</strong> El archivo se ha subido correctamente.', 'makusi'); ?>
                <!--/div-->       
            <?php //}?>
            <?php the_content(); ?>
            
            <?php if ( !is_user_logged_in() ) : ?>
                    <div class="alert alert-danger">.
                        <?php _e('Tienes que estar conectado para poder editar este perfil.', 'makusi'); ?>
                    </div>
                    <!-- .warning -->
            <?php else : ?>
                    
                <?php if ( count($error) > 0 ) echo '<p class="error">' . implode("<br />", $error) . '</p>'; ?>
                <form method="post" id="adduser" action="<?php the_permalink(); ?>" enctype="multipart/form-data">
                    <div class="form-username">
                        <label for="first-name" class="col-lg-3"><?php _e('Avatar', 'makusi'); ?></label>
                        <div class="col-lg-5">
                            <?php if(validate_gravatar($current_user->user_email) == TRUE) { ?>
                                <a class="gravatar-notice" href="https://es.gravatar.com/" target="_blank"><?php echo get_avatar( $current_user->ID, '80' ); ?>
                                <!--img src="<?php show_avatar($current_user->ID); ?>" /-->
                        &lt;&lt; <?php echo __('Click here to change your user image. "Gravatar"','makusi'); ?></a>
                        <a href="#" id="open-gravatar-dialog"><i class="fa fa-question"></i></a>
                        <div id="gravatar-dialog" title="<?php echo __('¿Qué es un gravatar?','makusi'); ?>">
                            <?php echo __('<p>Un "avatar" es una imagen que te representa online —una pequeña imagen que aparece junto a tu nombre cuando interactuas con sitios web.</p>
<p>Un "gravatar" es un Avatar reconocido globalmente. Si lo subes y creas tu perfil una sola vez, y luego puedes usarlo en cualquier web habilitada para usar Gravatar, tu imagen Gravatar te seguirá allí donde vayas, dentro y fuera de makusi.tv.</p>
<p>Gravatar es un servicio gratuito para propietarios de web, desarrolladores y usuarios. Está incluido automáticamente en cada cuenta de wordpress.com y tiene el soporte de Automattic. </p>','makusi'); ?>
                            <a class="gravatar-notice" href="https://es.gravatar.com/" target="_blank">&gt;&gt; <?php echo __('Haz clic aquí para cambiar tu imagen de usuario','makusi'); ?>&lt;&lt;</a>
                        </div>
                        <div class="clearfix"></div>
                    <?php } else { ?>
                            <img src="<?php show_avatar($current_user->ID); ?>" />
                            <input type="file" name="avatar" id="avatar" class="standard-text" />
                    <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- .form-avatar -->
                    <div class="form-username">
                        <label for="first-name" class="col-lg-3"><?php _e('Nombre', 'makusi'); ?></label>
                        <div class="col-lg-5">
                            <input placeholder="<?php _e('Nombre', 'makusi'); ?>" class="text-input form-control col-lg-4" name="first-name" type="text" id="first-name" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- .form-username -->
                    <div class="clearfix"></div>
                    <div class="form-username">
                        <label for="last-name" class="col-lg-3"><?php _e('Apellido', 'makusi'); ?></label>
                        <div class="col-lg-5">
                            <input placeholder="<?php _e('Apellido', 'makusi'); ?>" class="text-input form-control" name="last-name" type="text" id="last-name" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" />
                        </div>    
                        <div class="clearfix"></div>
                    </div>
                    <!-- .form-username -->
                    <div class="clearfix"></div>
                    <div class="form-email">
                        <label for="email" class="col-lg-3"><?php _e('E-mail *', 'makusi'); ?></label>
                        <div class="col-lg-5"> 
                            <input placeholder="<?php _e('E-mail', 'makusi'); ?>" class="text-input form-control" name="email" type="text" id="email" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" />
                        </div>
                        <div class="col-lg-4">
                            <span style="font-size:0.7em;"><?php _e('Allow users to see your email address', 'makusi'); ?></span>
                            <input type="checkbox" name="showemail" value="yes" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- .form-email -->
                    <div class="clearfix"></div>
                    <div class="form-url">
                        <label for="url" class="col-lg-3"><?php _e('Sitio web', 'makusi'); ?></label>
                        <div class="col-lg-5">
                            <input  placeholder="<?php _e('Sitio web', 'makusi'); ?>" class="text-input form-control" name="url" type="text" id="url" value="<?php the_author_meta( 'user_url', $current_user->ID ); ?>" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- .form-url -->
                    <div class="clearfix"></div>
                    <div class="form-password">
                        <label for="twitter" class="col-lg-3"><?php _e('Twitter Alias', 'makusi'); ?> </label>
                        <div class="col-lg-5">
                            <input placeholder="<?php _e('Twitter alias', 'makusi'); ?>" class="text-input form-control" name="twitter" type="text" id="twitter" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- .form-twitter -->
                    <div class="clearfix"></div>
                    <div class="form-facebook">
                        <label for="facebook" class="col-lg-3"><?php _e('Facebook url', 'makusi'); ?> </label>
                        <div class="col-lg-5">
                            <input placeholder="<?php _e('Facebook url', 'makusi'); ?>" class="text-input form-control" name="twitter" type="text" id="facebook" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- .form-facebook -->
                    
                    <div class="clearfix"></div>
                    <div class="form-google-plus">
                        <label for="google-plus" class="col-lg-3"><?php _e('Google + url', 'makusi'); ?> </label>
                        <div class="col-lg-5">
                            <input placeholder="<?php _e('Google + url', 'makusi'); ?>" class="text-input form-control" name="google-plus" type="text" id="google-plus" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- .form-password -->
                    <div class="clearfix"></div>
                    <div class="form-password">
                        <label for="pass" class="col-lg-3"><?php _e('Escribir Contraseña', 'makusi'); ?></label>
                        <div class="col-lg-5">
                            <input placeholder="<?php _e('Escribir Contraseña', 'makusi'); ?>" class="text-input form-control" name="pass" type="password" id="pass" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-password">
                        <label for="pass2" class="col-lg-3"><?php _e('Repetir Contraseña', 'makusi'); ?></label>
                        <div class="col-lg-5">
                            <input placeholder="<?php _e('Repetir Contraseña', 'makusi'); ?>" class="text-input form-control" name="pass2" type="password" id="pass2" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- .form-password -->
                    <div class="clearfix"></div>
                    <div class="form-textarea">
                        <label for="description" class="col-lg-3"><?php _e('Información Biographica', 'makusi') ?></label>
                        <div class="col-lg-5">
                            <textarea placeholder="<?php _e('Información Biographica', 'makusi'); ?>" class="form-control" name="description" id="description" rows="3" cols="50"><?php the_author_meta( 'description', $current_user->ID ); ?></textarea>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- .form-textarea -->
                    <div class="clearfix"></div>
                    <div class="form-twitter">
                        <label for="twitter-widget" class="col-lg-3"><?php _e('Código de widget de Twitter', 'profile') ?></label>
                        <div class="col-lg-5">
                            <textarea placeholder="<?php _e('Código de widget de Twitter', 'profile'); ?>" class="form-control" name="twitter-widget" id="twitter-widget" /><?php the_author_meta( 'twitter', $current_user->ID ); ?></textarea>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- .form-textarea -->
                    <?php 
                        //action hook for plugin and extra fields
                        //do_action('edit_user_profile',$current_user); 
                    ?>
                    <div class="clearfix"></div>
                    <div class="form-submit">
                        <?php echo $referer; ?>
                        <input name="updateuser" type="submit" id="updateuser" class="submit button btn btn-default" value="<?php _e('Actualizar', 'profile'); ?>" />
                        <?php wp_nonce_field( 'update-user' ) ?>
                        <input name="action" type="hidden" id="action" value="update-user" />
                    </div><!-- .form-submit -->
                </form><!-- #adduser -->
                <br />
            <?php endif; ?>
        </div><!-- .entry-content -->
    </div><!-- .hentry .post -->
    <?php endwhile; ?>
<?php else: ?>
    <p class="no-data">
        <?php _e('Lo sentimos, no hay página que responda a estos criterios.', 'makusi'); ?>
    </p><!-- .no-data -->
<?php endif; ?>

    <aside class="col-md-4 author-side">
            <?php 
            if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('home-right')) :
            endif;
        ?>
	</aside>
<?php get_footer(); ?>
