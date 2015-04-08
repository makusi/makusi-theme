<?php 
/**
*  Template Name: New Post 
* 
*/

get_header(); ?>
    <div class="content col-md-8">
    	<div class="formwrapper">
            <?php 
        	while (have_posts()) : the_post(); 
                    the_title('<h2>', '</h2>');
                    the_content(); 
                    endwhile; ?>
        </div>
    </div>
    <aside class="col-md-4"> 
        <!-- Search Form -->
        <form action="<?php echo home_url( '/' ); ?>" method="get">
            <input type="text" name="s" class="searchvideo" placeholder="<?php echo __('Buscar Videos...','makusi'); ?>" />
        </form>
        <br /><br />
        <div class="clr"></div>
        <br /><br />
        <!-- End Search Form -->
        <?php 
            if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('home-right')) :
            endif;
        ?>
        <?php //get_sidebar(); ?>
    </aside>
<?php get_footer(); ?>
