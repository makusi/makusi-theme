<?php get_header(); ?>
    <div class="single-wrapper">
        <div class="content col-md-8 page-<?php echo $post->post_name; ?>">
            <?php while (have_posts()) : the_post();
                the_title('<h2>', '</h2>');
                the_content(); 
            endwhile; ?>
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
