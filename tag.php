<?php get_header(); ?>
<section class="content col-md-8">
    <h2><?php echo __('<strong>Etiqueta:</strong> '); ?><?php single_tag_title( '', true ); ?></h2>
   <?php
   mk_tag_loop(single_tag_title( '', false )) ?> 
</section>
<aside class="col-md-4"> 
        <?php 
            if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('home-right')) :
            endif;
        ?>
        <?php //get_sidebar(); ?>
    </aside>
<?php get_footer(); ?>
