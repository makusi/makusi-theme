<?php

/**
 * Template Name: Remove user
 *
 * Allow users remove themselves from makusi.tv.
 *
 */
    
    /*Delete User*/
    $reassign = 1;
    if($userdata->ID != $reassign){
        require_once(ABSPATH.'wp-admin/includes/user.php' );
	$current_user = wp_get_current_user();
        $delete = wp_delete_user( $current_user->ID, $reassign );
    }
?>
<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class="content_author col-md-12" id="post-<?php the_ID(); ?>">
        <div class="entry-content entry">
            <h3><?php the_title(); ?></h3>
            <?php if($delete == TRUE) { 
                the_content(); 
            } else {   
                echo __('El usuario no ha sido borrado correctamente','makusi');
            }
            ?>
            
        </div><!-- .entry-content -->
    </div><!-- .hentry .post -->
    <?php endwhile; ?>
<?php else: ?>
    <p class="no-data">
        <?php _e('Lo sentimos, ninguna página coincide con tu criterio.', 'makusi'); ?>
    </p><!-- .no-data -->
<?php endif; ?>

<?php get_footer(); ?>