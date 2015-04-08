<?php get_header(); ?>
<div class="archive-wrapper">
    <section class="content col-xs-12 col-md-8">
        <h2><?php echo __('Error','makusi'); ?></h2>
        <p><?php echo __('Por algún motivo no escribiste correctamente tu dirección url y has llegado a esta página de error.','makusi'); ?></p>
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

