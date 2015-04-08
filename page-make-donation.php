<?php

/**
*  Template Name: Page Make Donation
* 
*/
$donation_post_id = $_GET['post_id'];
$post_values = get_post($_GET['post_id']);
$author_values = get_userdata( $post_values->post_author );


get_header(); ?>
    <div class="single-wrapper">
        <div class="content col-md-8 page-<?php echo $post->post_name; ?>">
            <?php while (have_posts()) : the_post();
                the_title('<h2>', '</h2>');
                the_content(); 
            endwhile;
            echo "<br />";
            ?>
            <strong><?php echo __('TITULO:','makusi'); ?></strong> <?php echo $post_values->post_title; ?><br />
            <strong><?php echo __('AUTOR:','makusi'); ?></strong> <?php echo $author_values->user_nicename; ?><br />
            <?php if($_GET['action'] != 'wpuf_tpv_success'){ ?>
            <form name='dona' action='<?php echo site_url();?>/procesar-donativo' method='post'>
                <input type="radio" value="5" name="amount">&nbsp;<label for="donation-to-video">5 €</label><br />
                <input type="radio" value="10" name="amount">&nbsp;<label for="donation-to-video">10 €</label><br />
                <input type="radio" value="25" name="amount">&nbsp;<label for="donation-to-video">25 €</label><br />
                <input type="radio" value="100" name="amount">&nbsp;<label for="donation-to-video">100 €</label><br />
                <input type="hidden" name="post_id" value="<?php echo $donation_post_id; ?>" />
                <input type="hidden" name="author_id" value="<?php echo $post_values->post_author ?>" />
                <input type="submit" name="submit" value="<?php echo __('Enviar','makusi'); ?>" />
            </form>
            <?php } else{ ?>
                <p><strong><?php echo __('Tu pago ha sido correcto. Muchas Gracias.','makusi'); ?></strong></p>
                <p><strong><?php echo __('ID de la Transacci&oacute;n','makusi'); ?></strong> :  <?php echo $_REQUEST['Ds_Order']; ?><br />
                <strong><?php echo __('Pago','makusi'); ?></strong>: <?php echo $Amount = $_REQUEST['Ds_Amount']/100 ?> &euro;<br />
                <strong><?php echo __('ID del Post','makusi'); ?></strong>:  <?php echo $_REQUEST['post_id']; ?><br />
                <strong><?php echo __('Fecha','makusi'); ?></strong>:  <?php echo $_REQUEST['Ds_Date']; ?><br />
                <strong><?php echo __('Time','makusi'); ?></strong>:  <?php echo $_REQUEST['Ds_Hour']; ?></p>
            <?php }  ?>
        </div>
        <aside class="col-md-4">
            <!-- Search Form -->
            <form action="<?php echo home_url( '/' ); ?>" method="get">
                <input type="text" name="s" class="searchvideo" placeholder="<?php echo __('Search Videos...','makusi'); ?>" />
            </form>
            <div class="clr"></div>
            <br /><br />
            <!-- End Search Form -->
            <?php 
                if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('home-right')) :
                endif;
            ?>
            <?php //get_sidebar(); ?>
        </aside>
        <div class="clear"></div>
    </div>
<?php get_footer(); ?>


