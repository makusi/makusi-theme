<?php get_header(); ?>
        <section class="content col-md-8 page-<?php echo $post->post_name; ?>">
            <h1><strong><?php echo __('Resultados de búsqueda: ','makusi'); ?></strong>"<?php echo $_REQUEST['s']; ?>"</h1>
            <?php mk_search_loop(); ?>
        </section>
        <aside class="col-md-4"> 
            <?php 
                if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('home-right')) :
                endif;
            ?>           
        </aside>
<?php get_footer(); ?>
