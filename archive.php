<?php get_header(); ?>
<div class="archive-wrapper">
    <section class="content col-xs-12 col-md-8">
        <h2><?php echo __('Mas Videos','makusi'); ?></h2>
    <?php mk_latest_archive_loop(); ?> 
    </section>
    <aside class="col-xs-12 col-md-4"> 
        <?php 
            if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('home-right')) :
            endif;
        ?>
        <?php //get_sidebar(); ?>
    </aside>
    <div class="clear"></div>
</div>
<?php get_footer(); ?>
