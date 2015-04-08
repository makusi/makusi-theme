<?php

/**
 * Template Name: Donate Success Page
 *
 * Allow users to update their profiles from Frontend.
 *
 */

$donation_post_id = $_REQUEST['post_id'];
$post_values = get_post($donation_post_id);
$author_values = get_userdata( $post_values->post_author );

//1. store donation in db
add_post_meta($donation_post_id, '_donation_'.$_REQUEST['order'], $_REQUEST['amount']/100, true);
//2. thank person for storing donation.

get_header(); ?>
<div class="single-wrapper">
    <div class="content col-md-12 page-<?php echo $post->post_name; ?>">
        <?php while (have_posts()) : the_post();
                the_title('<h2>', '</h2>');
                the_content(); 
            endwhile; ?>
        <p><?php echo __('ID TRANSACCION:','makusi'); ?>: <?php echo $_REQUEST['order']; ?></p>
        <p><?php echo __('VALOR','makusi'); ?>: <?php echo $_REQUEST['amount']/100; ?></p>
    </div>
</div>
<?php get_footer(); ?>
