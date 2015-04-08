<?php get_header(); ?>
	<div class="content_author col-xs-12 col-md-8">
            <?php 
		$user_id = mk_get_queried_user_id();
                $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
                $author_id = $author->ID;
                $this_user_id = get_current_user_id( );
            ?>
            <div class="author_info col-xs-12 col-md-3 author_avatar">
                <?php echo get_avatar( get_the_author_meta('user_email'), $size = '150'); ?>
            </div>
            <div class="author_info col-xs-12 col-md-9">
                <h3><a href="<?php the_author_meta('user_url'); ?>"><?php the_author_meta( 'display_name', $author_id ); ?></a></h3>
                <p class="author_registered"><strong><?php the_author_meta('user_registered',$author_id); ?></strong></p>
                <?php if($this_user_id == $author_id) { ?>
                    <?php $counter_array = count_attachments_by_user( $author_id ); ?>
                    <strong><?php echo __('Envios','makusi'); ?></strong>: <?php echo count_user_posts( $author_id ); ?> <br />
                    <strong><?php echo __('Videos','makusi'); ?></strong>: <?php echo $counter_array['attachments_counter']; ?><br />
                    <strong><?php echo __('Memoria ocupada','makusi'); ?></strong>: <?php echo byteFormat($counter_array['attachments_memory_counter'], 'MB', 2) ; ?><br />
                    <?php 
                        //var_dump($userdata);
                        $memcount = ( get_user_meta($author_id, 'wpuf_sub_memcount', true) ) ? get_user_meta($author_id, 'wpuf_sub_memcount', true) : 0;
                        $leftmemory = $memcount*1024*1024*1024 - $counter_array['attachments_memory_counter']; 
                        $percentage = ($counter_array['attachments_memory_counter'] / ($memcount*1024*1024*1024))*100;
                        $percentage = number_format($percentage,2);
                    ?>  
                    <strong><?php echo __('Porcentaje','makusi'); ?></strong> <?php echo $percentage; ?>
                    <br /><br />
                    <div class="progress" style="width:95%;">
                        <div class="progress-bar progress-bar-<?php 
                            if( $percentage <= 30 ){ ?>info<?php } 
                            elseif($percentage > 30 & $percentage <= 60){ ?>success<?php } 
                            elseif($percentage > 60 & $percentage <= 90){ ?>warning<?php }
                            elseif( $percentage > 90 ){ ?>danger<?php } ?>" role="progressbar"
                            aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"
                            accesskey="" style="width: <?php echo $percentage; ?>%">
                            <span class="sr-only"><?php echo $percentage; ?>% <?php echo __('completado (aviso)','makusi'); ?></span>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="clearfix"></div>
            <?php mk_author_loop($author_id); ?>
            <!--pre>
                <?php 
                    //var_dump(get_userdata($user_id));
                ?>
            </pre>
            <pre>
                <?php 
                    //var_dump(get_user_meta($user_id));
                ?>
            </pre-->
	</div>
	<aside class="col-sx-12 col-md-4 author-side">
            <?php 
            if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('home-right')) :
            endif;
        ?>
	</aside>
<?php get_footer(); ?>