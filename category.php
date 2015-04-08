<?php get_header(); ?>
<section class="content col-xs-12 col-md-8">
    <h2><?php single_cat_title( '', true ); ?></h2>
   <?php
   $cat_id = icl_object_id(get_queried_object_id(),'category', true,'es');
   mk_category_loop($cat_id);
   //mk_category_loop(get_queried_object_id());
   ?> 
</section>
<aside class="col-xs-12 col-md-4"> 
        <?php 
            if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('home-right')) :
            endif;
        ?>
        <?php //get_sidebar(); ?>
    </aside>
<?php get_footer(); ?>
