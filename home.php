<?php get_header(); ?>
    <?php get_template_part('slideshow'); ?>
    <div class="clr"></div>
    </div>
    </div>
    <div class="container body-container">
        <div class="content col-xs-12 col-md-8">
            <section id="home-featured_first">
                <div class="row">
                    <?php mk_featured_first_loop(); /*Primeros dos videos bajo el slideshow*/ ?>
                </div>
            </section>
        </div>
        <aside class="col-xs-12 col-md-4">
            <!-- Search Form -->
            <form action="<?php echo home_url( '/' ); ?>" method="get">
                <input type="text" name="s" class="searchvideo" placeholder="<?php echo __('Busca Videos...','makusi'); ?>" />
            </form>
            <div class="clr"></div>
            <!-- End Search Form -->
            <?php 
                if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('home-right')) :
                endif;
            ?>
        <?php //get_sidebar(); ?>
    </aside>
<?php get_footer(); ?>
