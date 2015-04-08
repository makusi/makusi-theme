<?php ob_start(); 

class makusi_user_info extends WP_Widget{
    function makusi_user_info(){
        $widget_ops = array(
            'classname' => 'makusi_user_info', 
            'description' => 'Displays information about users' );
        $this->WP_Widget('makusi_user_info', 'Makusi: User info', $widget_ops);
    }
    function form($instance){
        $instance = wp_parse_args( (array) $instance, array( 'widget_title' => '' ) );
	$widget_title = $instance['widget_title'];
    ?>
    <p>
        <label for="<?php echo $this->get_field_id('widget_title'); ?>">Widget Title: 
            <input class="widefat" id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" type="text" value="<?php echo esc_attr($widget_title); ?>" />
        </label>
    </p>
<?php
    }
    function update($new_instance, $old_instance){
        $instance = $old_instance;
	$instance['widget_title'] = $new_instance['widget_title'];
        return $instance;
    }
    
    function widget($args, $instance){
        extract($args, EXTR_SKIP);
        echo $before_widget;
	$widget_title = empty($instance['widget_title']) ? ' ' : apply_filters('widget_title', $instance['widget_title']);
 
        if (!empty($imageurl))
            echo $before_title . $widget_title . $after_title;

        // WIDGET CODE GOES HERE
        $this->makusi_user_info_widget();
 
        echo $after_widget;
    }
    
    function makusi_user_info_widget(){ 
        global $userdata;
        $userdata = get_userdata( $userdata->ID );
        global $current_user; 
        $sub_validity = ( $userdata->wpuf_sub_validity ) ? $userdata->wpuf_sub_validity : 0;
        $diff = strtotime( $sub_validity ) - time();
        $sub_validity_str = '';
        if ( $sub_validity === 0 ) {
            $sub_validity_str = 0;
        } elseif ( $sub_validity == 'unlimited' ) {
            $sub_validity_str = __( 'Duración ilimitada', 'wpuf' );
        } elseif ( $diff <= 0 ) {
            $sub_validity_str = __( 'Expira', 'wpuf' );
        } elseif ( $diff > 0 ) {
            $sub_validity_str = __( 'Hasta el ','wpuf'). date_i18n( 'd M, Y H:i', strtotime( $sub_validity ) );
        }
        $memcount = ( get_user_meta($current_user->ID, 'wpuf_sub_memcount', true) ) ? get_user_meta($current_user->ID, 'wpuf_sub_memcount', true) : 0;
        $mem_count_str = '';
        if ( $memcount === 0 ) {
            $mem_count_str = 0;
        } elseif ( $memcount == 'unlimited' ) {
            $mem_count_str = 'unlimited post';
        } else {
            $mem_count_str = $memcount;
        }
        $counter_array = count_attachments_by_user( $current_user->ID );
        $leftmemory = $memcount*1024*1024*1024 - $counter_array['attachments_memory_counter']; 
        $percentage = ($counter_array['attachments_memory_counter'] / ($memcount*1024*1024*1024))*100;
        $percentage = number_format($percentage,2);
        if( is_user_logged_in() ){ ?>
        <div class="panel-body">
            <?php if(validate_gravatar($current_user->user_email) == TRUE) { ?>
                <?php echo get_avatar( $current_user->ID, '80' ); ?>
            <?php } else { ?>
                <img src="<?php show_avatar($current_user->ID); ?>" align="left" style="margin-right:5px;" />
            <?php } ?>
            <div class="user-info-avatar-right">
                <p class="welcome">
                    <?php echo __('Bienvenid@', 'makusi'); ?>, 
                    <strong>
                        <a href="<?php site_url(); ?>/author/<?php echo $current_user->user_login; ?>">
                            <?php echo $current_user->user_login; ?>
                        </a>
                    </strong>
                </p>
                
                <div class="progress" style="width:100%;">
                    <div class="progress-bar progress-bar-<?php 
                        if( $percentage <= 30 ){ ?>info<?php } 
                        elseif($percentage > 30 & $percentage <= 60){ ?>success<?php } 
                        elseif($percentage > 60 & $percentage <= 90){ ?>warning<?php }
                        elseif( $percentage > 90 ){ ?>danger<?php } ?>" role="progressbar"
                        aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"
                        accesskey="" style="width: <?php echo $percentage; ?>%">
                        <span class="sr-only"><?php echo $percentage; ?>% completado (aviso)</span>
                    </div>
                </div>
                <a class="gravatar-notice" href="https://es.gravatar.com/" target="_blank">&lt;&lt; <?php echo __('Como conseguir tu "gravatar"','makusi'); ?></a>
                <a href="#" id="open-gravatar-dialog2"><i class="fa fa-question"></i></a>
                <div id="gravatar-dialog2" title="<?php echo __('¿Qué es un gravatar?','makusi'); ?>">
                    <?php echo __('<p>Un "avatar" es una imagen que te representa online —una pequeña imagen que aparece junto a tu nombre cuando interactuas con sitios web.</p>
<p>Un "gravatar" es un Avatar reconocido globalmente. Si lo subes y creas tu perfil una sola vez, y luego puedes usarlo en cualquier web habilitada para usar Gravatar, tu imagen Gravatar te seguirá allí donde vayas, dentro y fuera de makusi.tv.</p>
<p>Gravatar es un servicio gratuito para propietarios de web, desarrolladores y usuari@s. Está incluido automáticamente en cada cuenta de wordpress.com y tiene el soporte de Automattic. </p>','makusi'); ?>
                    <a class="gravatar-notice" href="https://es.gravatar.com/" target="_blank">&gt;&gt; <?php echo __('Haz clic aquí para cambiar tu imagen de usuario','makusi'); ?>&lt;&lt;</a>
                </div>
            </div>
            <div class="clr"></div>
            <br />
            <div class="table user-info-widget">
                <div class="row">
                    <div class="col-md-6">
                        <strong><?php _e( 'Validez:', 'wpuf' ); ?></strong>
                    </div>
                    <div class="col-md-6">
                        <?php echo $sub_validity_str; ?>
                    </div>
                </div>
                 <!--div class="row">
                    <div class="col-md-6">
                        <strong><?php echo __('Envíos:','makusi'); ?></strong> 
                    </div>
                    <div class="col-md-6">      
                        <?php echo count_user_posts_by_type( $current_user->ID ,'videos'); ?>
                    </div>
                </div-->
                 <div class="row">
                    <div class="col-md-6">
                        <strong><?php echo __('Vídeos:','makusi'); ?></strong> 
                    </div>
                    <div class="col-md-6">   
                        <?php echo $counter_array['attachments_counter']; ?>
                </div>
                </div>
                 <div class="row">
                    <div class="col-md-6">
                        <strong><?php _e( 'Tu suscripción:', 'wpuf' ); ?></strong> 
                    </div>
                    <div class="col-md-6"> 
                        <?php //echo byteFormat($mem_count_str*1024*1024, 'GB',2); ?>
                        <?php echo $mem_count_str; ?> Gb <br />
                        <a style="font-size:0.8em;" href="actualizar-memoria"><?php echo __('Aumentar capacidad','makusi'); ?></a>
                    </div>
                 </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong><?php echo __('Memoria utilizada:', 'wpuf'); ?></strong> 
                    </div>
                    <div class="col-md-6">
                        <?php echo byteFormat($counter_array['attachments_memory_counter'], 'Gb', 2) ; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong><?php _e( 'Memoria restante:', 'wpuf' ); ?></strong> 
                    </div>
                    <div class="col-md-6">
                        <?php echo byteFormat($leftmemory, 'Gb', 2) ; ?>
                    </div>
                </div>
                <!--div class="row">
                    <div class="col-md-6">
                        <strong>Available:</strong> 
                    </div>
                    <div class="col-md-6">
                        <?php echo unbyteFormat($memcount, 'Gb'); ?> <br />
                    </div>
                </div-->
                <div class="row">
                    <div class="col-md-6">
                        <strong><?php echo __( 'Porcentaje:', 'wpuf' ); ?></strong> 
                    </div>
                    <div class="col-md-6">
                         <?php echo $percentage; ?> %
                    </div>
                </div>
            </div>
            <!--ul class="widget-profile-controls">
                <!--li><a href="<?php echo get_author_posts_url( $current_user->ID ); ?>?activity=editprofile"><i class="fa fa-pencil"></i> <?php echo __('Actualizar cuenta', 'makusi'); ?></a></li-->
                <!--li><a href="<?php echo site_url();?>/user-profile/"><i class="fa fa-pencil"></i> <?php echo __('Actualizar cuenta', 'makusi'); ?></a></li>
                <li><a href="<?php echo site_url();?>/new-post/"><i class="fa fa-upload"></i> <?php echo __('Subir vídeo', 'makusi'); ?></a></li>
                <li><a href="<?php echo site_url();?>/user-dashboard/"><i class="fa fa-upload"></i> <?php echo __('Editar vídeo', 'makusi'); ?></a></li>
                <li><a href="<?php echo get_author_posts_url( $current_user->ID ); ?>"><i class="fa fa-user"></i> <?php echo __('Ver perfil', 'makusi'); ?></a></li>
                <li><a href="<?php echo wp_logout_url( site_url() ); ?>"><i class="fa fa-sign-in"></i> <?php echo __('Salir', 'makusi'); ?></a></li>
            </ul-->
            <div class="user-info-icons">
                <div class="user-info-icon col-md-4">
                    <a href="<?php echo site_url();?>/user-profile/">
                        <div class="user-icon-text"><?php echo __('Μi perfil','makusi'); ?></div>
                        <div class="fa fa-edit"></div>
                        
                    </a>
                </div>
                <div class="user-info-icon col-md-4">
                    <a href="<?php echo site_url();?>/user-dashboard/">
                        <div class="user-icon-text"><?php echo __('Μis vídeos','makusi'); ?></div>
                        <div class="fa fa-dashboard"></div>
                    </a>
                </div>
                <div class="user-info-icon col-md-4">
                    <a href="<?php echo site_url();?>/new-post/">
                        <div class="user-icon-text"><?php echo __('Subir un vídeo','makusi'); ?></div>
                        <div class="fa fa-upload"></div>
                    </a>
                </div>
                <div class="user-info-icon col-md-4">
                    <a href="<?php echo site_url();?>/upgrades/">
                        <div class="fa fa-arrow-circle-up"></div>
                        <?php echo __('Aumentar capacidad','makusi'); ?>
                    </a>
                </div>
                
                <div class="user-info-icon col-md-4">
                    <a href="<?php echo wp_logout_url( site_url() ); ?>">
                        <div class="fa fa-arrow-circle-right"></div>
                        <?php echo __('Salir','makusi'); ?>
                    </a>
                </div>
                <?php if($userdata->ID != 1){ ?>
                <div class="user-info-icon col-md-4">
                    <a id="remove_account" href="<?php echo site_url();?>/borrar-usuari@/">
                        <div class="fa fa-times"></div>
                        <?php echo __('Darse de baja','makusi'); ?>
                    </a>
                    <div id="remove_account_dialog" title="<?php echo __('Borrar cuenta','makusi'); ?>"><?php echo __('¿Estás segur@ de que quieres darte de baja y borrar tu cuenta? Al hacer click sobre "OK" tus datos y tus vídeos serán retirados','makusi'); ?></div>
                </div>
                <?php  } ?>
           </div>
            </div>
       <?php  } ?>
        
    <?php  }
}

ob_end_clean();