<?php ob_start(); ?>

<?php

class videopress_users extends WP_Widget
{
  function videopress_users()
  {
    $widget_ops = array(
        'classname' => 'videopress_users', 
        'description' => 'Displays a the login and registration form' );
    $this->WP_Widget('videopress_users', 'VideoPress: Users', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'widget_title' => '' ) );
	$widget_title = $instance['widget_title'];
?>

  <p><label for="<?php echo $this->get_field_id('widget_title'); ?>">Widget Title: <input class="widefat" id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" type="text" value="<?php echo esc_attr($widget_title); ?>" /></label></p>
  
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
	$instance['widget_title'] = $new_instance['widget_title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
	$widget_title = empty($instance['widget_title']) ? ' ' : apply_filters('widget_title', $instance['widget_title']);
 
    if (!empty($imageurl))
      echo $before_title . $widget_title . $after_title;
 
    // WIDGET CODE GOES HERE
    videopress_users_widget();
 
    echo $after_widget;
  }
 
}

?>

<?php function videopress_users_widget(){ ?>
	
  <?php 
  global $userdata;
  $userdata = get_userdata( $userdata->ID ); //wp 3.3 fix
  
    if( is_user_logged_in() ){ // If user is logged in ?>
        <!-- Logged In -->
        <div class="widget-user-profile">
  
        <div class="profile-header">
            <?php global $current_user; ?>
            <?php echo get_avatar( $current_user->ID, '40' ); ?>
            <div id="button_wrapper">
                <a class="open-user-window" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/open-user-tab.png"></a> 
                <a class="close-user-window" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/close-user-tab.png"></a>
            </div>
            <p class="welcome">
                <?php echo __('Welcome back', 'makusi'); ?>, 
                <strong><?php echo $current_user->user_login; ?></strong>
            </p> 
            <div class="clear"></div>
        </div>
  
        <ul class="widget-profile-controls">
            <!--li><a href="<?php echo get_author_posts_url( $current_user->ID ); ?>?activity=editprofile"><i class="fa fa-pencil"></i> <?php echo __('Update Account', 'makusi'); ?></a></li-->
            <li><a href="<?php echo site_url();?>/user-profile/"><i class="fa fa-pencil"></i> <?php echo __('Update Account', 'makusi'); ?></a></li>
            <li><a href="<?php echo site_url();?>/new-post/"><i class="fa fa-upload"></i> <?php echo __('Upload Video', 'makusi'); ?></a></li>
            <li><a href="<?php echo site_url();?>/user-dashboard/"><i class="fa fa-upload"></i> <?php echo __('Edit Videos', 'makusi'); ?></a></li>
            <li><a href="<?php echo get_author_posts_url( $current_user->ID ); ?>"><i class="fa fa-user"></i> <?php echo __('View Profile', 'makusi'); ?></a></li>
            <li><a href="<?php echo wp_logout_url( site_url() ); ?>"><i class="fa fa-sign-in"></i> <?php echo __('Logout', 'makusi'); ?></a></li>
        </ul>
        <div class="userdata">
            <?php $counter_array = count_attachments_by_user( $current_user->ID ); ?>
            <strong>Posts:</strong> <?php echo count_user_posts_by_type( $current_user->ID ,'videos'); ?> <br />
            <strong>Attachments:</strong> <?php echo $counter_array['attachments_counter']; ?><br />
            <strong>Memory Size:</strong> <?php echo byteFormat($counter_array['attachments_memory_counter'], 'MB', 2) ; ?>  <br />
            
            <?php 
            //var_dump($userdata);
                $memcount = ( get_user_meta($current_user->ID, 'wpuf_sub_memcount', true) ) ? get_user_meta($current_user->ID, 'wpuf_sub_memcount', true) : 0;
                
                $leftmemory = $memcount*1024*1024*1024 - $counter_array['attachments_memory_counter']; 
                $percentage = ($counter_array['attachments_memory_counter'] / ($memcount*1024*1024*1024))*100;
                $percentage = number_format($percentage,2);
            ?>
            <strong>Available:</strong> <?php echo $memcount; ?> Gb<br />
            <strong>Percentage:</strong> <?php echo $percentage; ?><br /><br />
            <div class="progress" style="width:95%;">
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
      </div>
      
  </div>
  <!-- End Logged In -->
  
  <?php } else { // Else if logged out ?>
  
            <div id="tab-container" class="tab-container">
                <ul class='etabs'>
                    <li class='tab'><a href="#login"><?php echo __('Login','makusi'); ?> <i class="fa fa-user"></i></a></li>
                    <li class='tab'><a href="#signup"><?php echo __('Register','makusi'); ?> <i class="fa fa-pencil"></i></a></li>
                </ul>
  
                <!-- Login Tab -->
                <div class="tab-content" id="login">
                    <div id="login-warning"></div>
                    <!--form name="loginform" method="post" action="<?php echo site_url(); ?>/wp-login.php?redirect_to=<?php echo site_url(); ?>" class="user-forms"-->
                    <!--form name="loginform" id="login_form" method="post" action="" class="user-forms">
                        <input type="text" name="log" id="username" placeholder="<?php echo __('Username','makusi'); ?>" class="user-input">
                        <input type="password" name="pwd" id="password" placeholder="<?php echo __('Password','makusi'); ?>" class="user-input"><br />
                        <input type="checkbox" name="rememberme" id="rememberme" /><?php echo __('Remember Me' , 'makusi'); ?> <span style="color:white;"><?php echo __('Remember me','makusi'); ?></span><br /><br />
                        <div align="center">
                            <input type="submit" value="<?php echo __('Login','makusi'); ?>" id="trigger_login" class="btn btn-primary btn-sm" /><br /><br />
                            <a href="#" id="lost_password_link" class="btn btn-default btn-xs"><?php echo __('Forgot Password?','makusi'); ?></a>
                        </div>
                    </form>
                    <form name="lost_password" id="lost_password" method="post" action="" class="user-forms">
                        <h6><?php echo __('PASSWORD RECOVERY','makusi'); ?></h6>
                        <input type="email" name="lost_email" id="lost_email" class="user-input" placeholder="<?php echo __('Write your email address','makusi'); ?>" />
                        <div align="center">
                            <input type="submit" value="<?php echo __('SEND','makusi'); ?>" id="trigger_lost" class="btn btn-primary btn-sm" /><br /><br />
                            <a href="#" id="login_link" class="btn btn-default btn-xs"><?php echo __('Login','makusi'); ?></a>
                        </div>
                    </form-->
                        
                </div>
                <!-- End Login Tab -->
                
                <!-- Password Tab -->
               
                <!-- End Password Tab -->
                
                <!-- Signin Tab -->
                <!--div class="tab-content" id="signup">
                    <!--div id="register-warning"></div-->
                    <!--form name="registerform" id="register_form" action="" class="user-forms">
                        <input type="text" id="firstname" name="firstname" placeholder="<?php echo __('First Name','makusi'); ?>" class="user-input" />
                        <input type="text" id="lastname" name="lastname" placeholder="<?php echo __('Last Name','makusi'); ?>" class="user-input" />
                        <input type="text" id="regusername" name="username" placeholder="<?php echo __('Username','makusi'); ?>" class="user-input" />
                        <input type="text" id="email" name="email" placeholder="<?php echo __('Email','makusi'); ?>" class="user-input" />
                        <input type="password" id="regpassword" name="password" placeholder="<?php echo __('Password','makusi'); ?>" class="user-input" />
                        <input type="password" id="regpassword2" name="password2" placeholder="<?php echo __('Password','makusi'); ?>" class="user-input" />
                        <input type="submit" value="<?php echo __('Register Account','makusi'); ?>" class="btn btn-primary btn-sm" id="trigger_register" name="trigger_register" />
                    </form>
                </div-->
  <!-- End Signin Tab -->
  
   </div>
   <?php } // End if ?>
    
<?php } // End Function ?>

<?php ob_end_clean(); ?>