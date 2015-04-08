    <!--aside class="sliding-side category-side">
        <div class="side-close-container">
            <a href="#" class="close-side">
        	<img src="<?php echo get_template_directory_uri(); ?>/images/sideopen_small.png" align="left" />
		<?php echo __('CERRAR','makusi'); ?>        		
            </a>
        </div>
        <nav>
            <ul class="category-list">
            <!-- menu -->
            <?php
                /*$args = array(
                            'show_option_all'    => '',
                            'orderby'            => 'name',
                            'order'              => 'ASC',
                            'style'              => 'list',
                            'show_count'         => 0,
                            'hide_empty'         => 0,
                            'use_desc_for_title' => 1,
                            'child_of'           => 0,
                            'feed'               => '',
                            'feed_type'          => '',
                            'feed_image'         => '',
                            'exclude'            => '',
                            'exclude_tree'       => '',
                            'include'            => '',
                            'hierarchical'       => 1,
                            'title_li'           => '',
                            'show_option_none'   => __( 'No categories' ),
                            'number'             => null,
                            'echo'               => 1,
                            'depth'              => 0,
                            'current_category'   => 0,
                            'pad_counts'         => 0,
                            'taxonomy'           => 'category',
                            'walker'             => null
			);
                  wp_list_categories( $args );*/
				?>
				<!--/ul>
				</nav>
				<div class="clr"></div>
				<?php 
                                    /*if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('left-sidebar')) :
                                    endif;*/
                                ?>			
        </aside-->
	<aside class="sliding-side user-side">
		<!-- user area -->
                <!--div class="user-area"-->
                <div class="side-close-container">
                    <a href="#" class="close-side">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/sideopen_small.png" align="left" />
                        <?php echo __('CERRAR','makusi'); ?>       		
                    </a>
        	</div>
        	<div class="clr"></div>
                <?php 
                        if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('top-user')) :
                        endif;
                ?>
                <!--/div-->
                <div class="clr"></div>
                <?php 
            		if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('right-sidebar')) :
            		endif;
        	?>		
	</aside>  
