<?php
/**
*  Template Name: Upload 
* 
*/

 	get_header(); 
	render_open_form(); 
 ?>

<!--form class="wpuf-form-add" action="" method="post"-->
<?php  
	while (have_posts()) : the_post();
		$type ="videos"; 
		mk_file_upload( $post->ID, $type, 90000000 ); 
      mk_submit_button( );
   endwhile;
?>
<!--/form-->

<?php 
	render_close_form();
	get_footer(); 
?>