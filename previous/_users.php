<?php ob_start(); ?>

<?php

class videopress_users extends WP_Widget
{
  function videopress_users()
  {
    $widget_ops = array('classname' => 'videopress_users', 'description' => 'Displays a the login and registration form' );
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
	
  <?php if( is_user_logged_in() ){ // If user is logged in ?>
  
  <!-- Logged In -->
  <div class="widget-user-profile">
  
  <div class="profile-header">
  <?php global $current_user; ?>
  <?php echo get_avatar( $current_user->ID, '50' ); ?>
  <p class="welcome">Welcome back, <strong><?php echo $current_user->user_login; ?></strong></p>
  <div class="clear"></div>
  </div>
  
  <ul class="widget-profile-controls">
  <li><a href="<?php echo get_author_posts_url( $current_user->ID ); ?>?activity=updateprofile"><i class="fa fa-pencil"></i> <?php echo __('Update Account','makusi'); ?></a></li>
  <li><a href="<?php echo site_url();?>/wp-admin/post-new.php"><i class="fa fa-upload"></i> <?php echo __('Upload Video','makusi'); ?></a></li>
  <li><a href="<?php echo get_author_posts_url( $current_user->ID ); ?>"><i class="fa fa-user"></i> <?php echo __('View Profile','makusi'); ?></a></li>
  <li><a href="<?php echo wp_logout_url( site_url() ); ?>"><i class="fa fa-sign-in"></i><?php echo __('Logout','makusi'); ?></a></li>
  </ul>
  
  </div>
  <!-- End Logged In -->
  
  <?php }else{ // Else if logged out ?>
  
  <div id="tab-container" class="tab-container">
  <ul class='etabs'>
    <li class='tab'><a href="#login"><?php echo __('Log-in','makusi'); ?> <i class="fa fa-user"></i></a></li>
    <li class='tab'><a href="#signup"><?php echo __('Sign-up','makusi'); ?> <i class="fa fa-pencil"></i></a></li>
  </ul>
  
  
  <!-- Login Tab -->
  <div class="tab-content" id="login">
  <form name="loginform" method="post" action="<?php echo site_url(); ?>/wp-login.php?redirect_to=<?php echo site_url(); ?>" class="user-forms">
  <input type="text" name="log" placeholder="Username" class="user-input">
  <input type="password" name="pwd" placeholder="password" class="user-input">
  <input type="submit" value="Sign-in" class="user-submit">
  <a href="<?php echo wp_lostpassword_url(); ?>"><?php echo __('Forgot Password?','makusi'); ?></a>
  </form>
  </div>
  <!-- End Login Tab -->
  
  
  <!-- Signin Tab -->
  <div class="tab-content" id="signup">
  <?php
  // When register button is triggered
  if(isset($_POST['trigger_register']) && !empty($_POST['trigger_register'])) {
  
  $user_name = $_POST['username'];
  $user_email = $_POST['email'];
  $random_password = wp_generate_password( '12', 'true', 'true' );
  
  // Check if username and email exist
  if ( !username_exists( $user_name ) and email_exists($user_email) == false ) {
	// Check Fields
  	if( $user_name == '' ||  $user_email == '' ){?>
		<div class="widget-register-error">
                    <?php echo __('Los campos no pueden quedar vacíos','makusi'); ?>
                </div>
	<?php }else{
	
		// Check if valid email
		if( is_email($user_email) ){
			// Register into database
			wp_create_user( $user_name, $random_password, $user_email );
			
			// Send password to email
			$subject = get_bloginfo('name').__(' creación de cuenta','makusi');
			$message = __('Password is: ','makusi').$random_password;
			$header = 'from: Registration '.get_option('admin_email');
			$send_contact=mail($user_email,$subject,$message,$header);
			
			// Notify Success
			echo '<div class="widget-register-success">'
                        . __('Tu cuenta se ha creado correctamente. Vas a recibir una contraseña por email.','makusi').'</div>';
			
		}else{ // If Email not valid
			echo '<div class="widget-register-error">'.__('Dirección email inválida','makusi').'</div>';
		} // End Email Validation
		
	} // End Checking of fields

	
  // Else username and email exist
  }else {
	
	echo '<ul class="widget-register-error">';
	
	// If Username Exist
	if( username_exists( $user_name ) != '' ){
		echo '<li>'.__('Ese usuario ya existe. Por favor elige otro','makusi').'</li>';
	} // End Username Exist
  	
	
	// If Email Exist
	if( email_exists($user_email) ){
		echo '<li>'.__('Ya hay una cuenta con esta dirección de email. Por favor elige otro.','makusi').'</li>';
	} // End Email Exist
	
	echo '</ul>';
	
  } // End if check exist username and password
  
  }// End trigger
  ?>
  
  <form name="loginform" method="post" action="#signup" class="user-forms">
  <input type="text" name="username" placeholder="Username" class="user-input">
  <input type="text" name="email" placeholder="Email" class="user-input">
  <input type="submit" value="Register Account" class="user-submit" name="trigger_register">
  </form>
  </div>
  <!-- End Signin Tab -->
  
   </div>
   <?php } // End if ?>
    
<?php } // End Function ?>

<?php ob_end_clean(); ?>