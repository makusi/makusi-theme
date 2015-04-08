<?php 
/**
*  Template Name: Community
* 
*/

get_header(); ?>
<aside class="col-md-3"> 
        <?php 
            if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('social-left')) : 
            endif;
        ?>
        <?php //get_sidebar(); ?>
    </aside>
    <!--div class="single-wrapper"-->
        <div class="content col-md-6 page-<?php echo $post->post_name; ?>">
            <div class="panel home-panel">
                <img src="<?php echo get_template_directory_uri(); ?>/images/free-header-banner-2.png" />
                <div class="home-caption"><h3>soñar, grabar, compartir...</h3></div>
                <div class="clearfix"></div>
            </div>
            <?php while (have_posts()) : the_post(); ?>
            <div class="panel panel-default">
                <?php the_title('<h2 class="post-header">', '</h2>'); ?>
                <div class="clearfix"></div>
                <div class="panel-body">
                    <?php the_content();  ?>
                </div>
            </div>
            </div>
            <?php endwhile; ?>
        <!--/div-->
        <aside class="col-md-3">
            <!-- Search Form -->
            <form action="<?php echo home_url( '/' ); ?>" method="get">
                <input type="text" name="s" class="searchvideo" placeholder="<?php echo __('Search Videos...','makusi'); ?>" />
            </form>
            <div class="clr"></div>
            <br /><br />
            <!-- End Search Form -->
            <?php 
                if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('social-right')) : 
                endif;
            ?>
            <?php //get_sidebar(); ?>
        </aside>
        <div class="clear"></div>
    <!--/div-->
<?php get_footer(); ?>

