<?php

function mk_screen_loop(){
     $args = array(
            'post_type' => 'videos',
            'showposts'=> 1,
            'post_status'=> 'publish'
            );
     $query = new WP_Query($args);
     
     if ( $query->have_posts() ) {
        $i=1;
        
        while ($query->have_posts()){
            $query->the_post();
            
            $attachments = get_children( array(
                            'post_type' => 'attachment',
                            'posts_per_page' => 0,
                            'post_parent' => $query->post->ID
                        ) );
           
            if(count($attachments) > 0){
                foreach($attachments as $attachment){
                    
                    $metadata = wp_get_attachment_metadata( $attachment->ID );
                    
                    if($metadata['fileformat'] == 'mp4'){
                        $thumbnail = $metadata['sizes']['home-screen']['url'];
                    }
                }
                
                if(isFileUrl($thumbnail) == true){
                   if(get_post_meta( $query->post->ID, 'privacy_settings', true )!='Oculto') : 
                ?>
                <div id="tab<?php echo $i; ?>" class="tabcontainer">
                    <article class="video_screen_item" id="video_screen_item_<?php echo $query->post->ID; ?>">
                        <div class="image-holder">
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo $thumbnail; ?>" />
                            </a>
                            <div class="video-title-holder">
                                <h6 class="layout-title">
                                    <?php the_title(); ?>
                                </h6>
                            </div>
                            <div class="overlay">
                                <a href="<?php the_permalink(); ?>" class="expand"><i class="fa fa-play"></i></a>
                                <a class="close-overlay hidden">x</a>
                            </div>
                            <div class="video-duration">
                                <?php echo $metadata['length_formatted']; ?>
                            </div>
                        </div>
                        <p class="video-description"><?php the_excerpt_max_charlength(200); ?></p>
                        <div class="clr"></div>
                    </article>
                </div>
                <?php endif; ?>
     <?php    }   ?>
     <?php $i++;
             }
        }
    }
}

function mk_carrousel_loop(){
    $args = array(
                'post_type' => 'videos',
                'showposts'=> 4,
                'post_status'=> 'publish',
                'meta_key' => 'queue_status',
                'meta_value' => 'uncompressed'
            );
    $query = new WP_Query($args);
    if ( $query->have_posts() ) {
        $i=1;
        ?>
        <ul>
       <?php if($i<5){ 
            while ($query->have_posts()){ 
                $query->the_post();
                $attachments = get_children( array(
                            'post_type' => 'attachment',
                            'posts_per_page' => 0,
                            'post_parent' => $query->post->ID
                        ) );
                if($attachments){
                    foreach($attachments as $attachment){
                        $metadata = wp_get_attachment_metadata( $attachment->ID );
                        $thumbs = wp_get_attachment_metadata( $attachment->ID );
                        $thumbnail = $thumbs['sizes']['home-carousel']['url'];
                    }
                } ?>
                <?php if(isFileUrl($thumbnail) != true){ 
                    
                } else { ?>
                    <li>
                        <article class="video_carrousel_item" id="video_carrousel_item_<?php echo $query->post->ID; ?>">
                            <div class="image-holder">
                                <a href="<?php the_permalink(); ?>" class="tablink" id="<?php echo $i; ?>">
                                    <img src="<?php echo $thumbnail; ?>" />
                                    <div class="clr"></div>
                                </a>
                                <div class="video-title-holder">
                                    <h6 class="layout-title">
                                       <?php the_title_max_charlength(70); ?>
                                    </h6>
                                    <!--p><?php //the_excerpt_max_charlength(10); ?></p-->
                                </div>
                                <div class="overlay">
                                    <a href="<?php the_permalink(); ?>" class="expand"><i class="fa fa-play"></i></a>
                                    <a class="close-overlay hidden">x</a>
                                </div>
                                <div class="video-duration">
                                    <?php echo $metadata['length_formatted']; ?>
                                </div>
                            </div>
                        </article> 
                    </li>
                <?php 
                }
                $i++;
        } 
    } ?>
        </ul>
       
    <?php }
    wp_reset_postdata();
}
    

function mk_featured_first_loop(){
    global $wp_query;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
            'post_type' => 'videos',
            'posts_per_page' => 12,
            'offset' => 1,
            'paged' => $paged
            );
    $i=1;
    $query = new WP_Query($args);
    if ( $query->have_posts() ) { ?>
	<div class="featured_first_container">
       <?php
        while ($query->have_posts()){ 
            $query->the_post();
            $attachments = get_children( array(
                            'post_type' => 'attachment',
                            'posts_per_page' => 0,
                            'post_parent' => $query->post->ID
                        ) );
            if($attachments){
            	foreach($attachments as $attachment){
                    $metadata = wp_get_attachment_metadata( $attachment->ID );
                    echo "<!-- METADATA";
                    var_dump($metadata);
                    echo "-->";
                    $thumbs = wp_get_attachment_metadata( $attachment->ID );
                    $thumbnail = $thumbs['sizes']['home-screen']['url'];
                }
            }       
            if(get_post_meta( $query->post->ID, 'privacy_settings', true ) != 'Oculto') : 
            if(isFileUrl($thumbnail) == true){ ?>
                <div class="col-xs-12 col-md-6">
                    <article class="video_feature_item" id="video_feature_item_<?php echo $query->post->ID; ?>">
                    <div class="image-holder">
                        <a href="<?php the_permalink(); ?>">
                            <img style="width:100%; height:auto;" src="<?php echo $thumbnail; ?>" />
                        </a>
                        <div class="overlay">
                            <a href="<?php the_permalink(); ?>" class="expand"><i class="fa fa-play"></i></a>
                            <a class="close-overlay hidden">x</a>
                        </div>
                        <div class="video-duration"><?php echo $metadata['length_formatted']; ?></div>
                    </div>
                    
                    <div class="clear"></div>
                    
                    <h6 class="layout-title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h6><p class="video-description">
                    <?php //the_excerpt();
                    the_excerpt_max_charlength(80);
                    ?></p>
                    <div class="clearfix"></div>
                    <ul class="stats">
                        <li><?php makusi_countviews( $query->post->ID ); ?></li>
                        <li>
                            <i class='fa fa-calendar'></i>
                            <?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) ; ?>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </article>
             </div>
            <?php if($i%2 == 0 && $i != 0){ ?>
           
                <div class="clearfix"></div> 
                <?php } 
                $i++; ?>
                    <?php 
                    
                    }
                    endif;
            } ?>
        </div>
<br />
      <div class="clearfix"></div>      
                <?php create_pagination(16); ?>
<br /><br />
     <div class="clearfix"></div>
        <?php
        }
        wp_reset_postdata();
}
function mk_featured_loop(){
    $args = array(
            'post_type' => 'videos',
            'posts_per_page' => 12
            );
    $query = new WP_Query($args);
    if ( $query->have_posts() ) { ?>
	<div class="masonry_container">
       <?php
        while ($query->have_posts()){ 
            $query->the_post();
            $attachments = get_children( array(
                            'post_type' => 'attachment',
                            'posts_per_page' => 0,
                            'post_parent' => $query->post->ID
                        ) );
            if($attachments){
            	foreach($attachments as $attachment){
               	$thumbs = wp_get_attachment_metadata( $attachment->ID );
                $thumbnail = $thumbs['sizes']['triple-column']['url'];
            }
        }       
        if(isFileUrl($thumbnail) == true){ ?>
            <div class="col-xs-12 col-md-3">
                <article class="video_feature_item" id="video_feature_item_<?php echo $query->post->ID; ?>">
                    <div class="image-holder">
                        <a href="<?php the_permalink(); ?>">
                            <img width="255" height="143" src="<?php echo $thumbnail; ?>" />
                        </a>
                        <div class="overlay">
                            <a href="<?php the_permalink(); ?>" class="expand"><i class="fa fa-play"></i></a>
                            <a class="close-overlay hidden">x</a>
                        </div>
                    </div>
                   
                    <div class="clear"></div>
                    <h6 class="layout-title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h6><p class="video-description">
                    <?php //the_excerpt();
                    the_excerpt_max_charlength(60);
                    ?></p>
                    
                    <div class="clr"></div>
                     <ul class="stats">
                        <li><?php makusi_countviews( $query->post->ID ); ?></li>
                        <li>
                            <i class='fa fa-calendar'></i>&nbsp;&nbsp;
                            <?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) ; ?>
                        </li>
                    </ul>
                </article>
             </div>
                <?php
                    }
                } ?>
        </div>
        <?php
        }
        wp_reset_postdata();
    }

function mk_latest_loop(){
    global $wp_query;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
            'post_type' => 'videos',
            'posts_per_page' => 16,
            'offset' => 7,
            'paged' => $paged
            );
    $wp_query = new WP_Query($args);
    $i=1;
    if ( $wp_query->have_posts() ) {
        while ($wp_query->have_posts()){ 
            $wp_query->the_post();
            $attachments = get_children( array(
                            'post_type' => 'attachment',
                            'posts_per_page' => 0,
                            'post_parent' => $wp_query->post->ID
                        ) );
            if($attachments){
                foreach($attachments as $attachment){
                    $metadata = wp_get_attachment_metadata( $attachment->ID );
                    $thumbs = wp_get_attachment_metadata( $attachment->ID );
                    $thumbnail = $thumbs['sizes']['triple-column']['url'];
                }
            }
            
            if(isFileUrl($thumbnail) == true){
            ?>
                <div class="col-xs-12 col-md-3">
                    <article class="video_latest_item" id="video_latest_item_<?php echo $wp_query->post->ID; ?>">
                        <div class="image-holder">
                            <a href="<?php the_permalink(); ?>">
                                <img style="width:100%; height:auto;" src="<?php echo $thumbnail; ?>" />
                            </a>
                            <div class="overlay">
                                <a href="<?php the_permalink(); ?>" class="expand"><i class="fa fa-play"></i></a>
                                <a class="close-overlay hidden">x</a>
                            </div>
                            <div class="video-duration">
                                <?php echo $metadata['length_formatted']; ?>
                            </div>
                        </div>
                        <div class="clr"></div>
                        <h6 class="layout-title media-heading">
                            <a href="<?php the_permalink(); ?>">
                                <?php //the_title(); ?>
                                <?php echo substr(the_title($before = '', $after = '', FALSE), 0, 50); ?>
                                <?php 
                                    if(strlen(the_title($before = '', $after = '', FALSE)) >= 50) echo "..."; ?>
                            </a>
                        </h6>
                            
                        <p class="video-description"><?php the_excerpt_max_charlength(50); ?></p>
                        <div class="clr"></div>
                    <ul class="stats">
                        <li><?php makusi_countviews( get_the_ID() ); ?></li>
                        <li><i class='fa fa-calendar'></i>&nbsp;&nbsp;<?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) ; ?></li>
                    </ul>
                </article>
                </div>
                <?php if($i%4 == 0 && $i != 0){ ?>
                <div class="clearfix"></div> 
                <?php }
                } 
                $i++;
                } ?>
            <div class="clr"></div>
            <br />
            <div class="col-md-12">
                <?php create_pagination(16); ?>
                <div class="clr"></div>
            </div>
     <div class="clr"></div>
    <?php    }
        wp_reset_postdata();
}

function mk_latest_archive_loop(){
    global $wp_query;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
            'post_type' => 'videos',
            'posts_per_page' => 16,
            'paged' => $paged
            );
    //$query = get_posts( $args );
    $wp_query = new WP_Query($args);
    $i=1;
    if ( $wp_query->have_posts() ) {
        while ($wp_query->have_posts()){ 
            $wp_query->the_post();
            $attachments = get_children( array(
                            'post_type' => 'attachment',
                            'posts_per_page' => 0,
                            'post_parent' => $wp_query->post->ID
                        ) );
            if($attachments){
                foreach($attachments as $attachment){
                    $metadata = wp_get_attachment_metadata( $attachment->ID );
                    $thumbs = wp_get_attachment_metadata( $attachment->ID );
                    $thumbnail = $thumbs['sizes']['single-column']['url'];
                }
            }
            //var_dump(isFileUrl($thumbnail));
            if(isFileUrl($thumbnail) == true){
            ?>
     <div class="col-xs-12 col-md-6">
                <article class="video_latest_archive_item" id="video_latest_archive_item_<?php echo $wp_query->post->ID; ?>">
                    <div class="image-holder">
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo $thumbnail; ?>" />
                        </a>
                        <div class="overlay">
                            <a href="<?php the_permalink(); ?>" class="expand"><i class="fa fa-play"></i></a>
                            <a class="close-overlay hidden">x</a>
                        </div>
                        <div class="video-duration">
                            <?php echo $metadata['length_formatted']; ?>
                        </div>
                    </div>
                    <div class="media-body">
                       
                        <div class="clr"></div>
                        <h6 class="layout-title media-heading">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h6>
                        
                        <p><?php the_excerpt_max_charlength(50); ?></p>
                        
                        <div class="clearfix"></div>
                         <ul class="stats">
                            <li><?php makusi_countviews( get_the_ID() ); ?></li>
                            <!--li><?php comments_number() ?></li-->
                            <li><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) ; ?></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </article>
         </div>
     <?php if($i%2 == 0 && $i != 0){ ?>
                <div class="clearfix"></div> 
                <?php } 
                $i++; ?>
                <?php
                } 
            } ?>
     <div class="clr"></div>
     <?php create_pagination(12); ?>
     <div class="clr"></div>
    <?php    }
        wp_reset_postdata();
}

function create_pagination($videos_per_page=4,$url){
    
    $content = substr($_SERVER['REQUEST_URI'],0,-1);
    $array = explode('/', $content);
    $array = array_reverse($array);
    $string ="";
    $actual_page = $array[0];
    if($actual_page !=''){
        $paginated = true;
    } else {
        $paginated = false;
        $actual_page = 1;
    }
    
    $previous_page = $actual_page - 1;
    $next_page = $actual_page + 1;
    $count_videos = wp_count_posts('videos');
    $count_pages = intval($count_videos->publish/$videos_per_page);
    if(($count_videos->publish/$videos_per_page)>$count_pages){
        $count_pages++;
    }
    $i=1;
    ?>
    <a class="page-numbers" href="<?php echo site_url() ;?>">«</a>
    <?php
    if($paginated !== false){ ?>
        <a class="page-numbers" href="<?php if($actual_page >= 2){ echo site_url('/videos/').'page/'. $previous_page; } else { echo site_url(); }; ?>">&lt;</a>
    <?php }
    for($i;$i<=$count_pages;$i++){
        if($actual_page == $i){ ?>
            <span class="page-numbers current"><?php echo $i; ?></span>
        <?php } else { ?> 
            <a class="page-numbers" href="<?php if($i != 1){echo site_url('/videos/') . 'page/'. $i;} else { echo site_url(); };?>"><?php echo $i; ?></a>
        <?php } 
        }
        if($actual_page != $count_pages){ ?>
                <a class="page-numbers" href="<?php if($i != 1){echo site_url('/videos/') . 'page/'. $next_page; } else { echo site_url(); };?>">&gt;</a>
        <?php } ?>
            <a class="page-numbers" href="<?php echo site_url('/videos/') . 'page/'.$count_pages ;?>">»</a>
<?php        
}

function mk_author_loop($user_id){
    global $userdata;
    $args = array(
                'post_type' =>'videos',
                'author' => $user_id);
    $query = new WP_Query($args);
    if ( $query->have_posts() ) {
        $i=1;
        while ($query->have_posts()){
            $query->the_post();
            $attachments = get_children( array(
                            'post_type' => 'attachment',
                            'posts_per_page' => 0,
                            'post_parent' => $query->post->ID
                        ) );
            if($attachments){
                foreach($attachments as $attachment){
                    $thumbs = wp_get_attachment_metadata( $attachment->ID );
                    $thumbnail = $thumbs['sizes']['home-carousel']['url'];
                }
            }
            if(isFileUrl($thumbnail) == true){ ?>
            <div class="col-xs-12 col-md-6">
                <article class="video_user_item" id="video_user_item_<?php echo $query->post->ID; ?>">
                    <div class="image-holder">
                        <a href="<?php the_permalink(); ?>" id="<?php echo $i; ?>">
                            <img style="width:100%; height:auto;" src="<?php echo $thumbnail; ?>" />
                        </a>
                    </div>
                    <h6 class="layout-title"><?php the_title(); ?></h6>
                        <p><?php the_excerpt_max_charlength(60); ?></p>
                        <?php if($userdata->ID == $user_id){ 
                                $edit_page = (int) get_option( 'wpuf_edit_page_url' );
                                $url = wp_nonce_url( get_permalink( $edit_page ) . '?pid=' . $post_id, 'wpuf_edit' );
                        ?>
                            <p><a href="<?php echo $url; ?>">Edit</a></p>
                        <?php } ?><p>
                </article>
                </div>
            <?php }
            $i++;
        }
    }
    wp_reset_postdata();
}

function mk_related_loop($cat_id){
    global $post;
    $tags = wp_get_post_tags($post->ID);
    //var_dump($tags);
    if($tags){
        $tag_ids = array();
        foreach ($tags as $tag){
            $tag_ids[] = $tag->term_taxonomy_id;
        }
        //var_dump($tag_ids);
        $args= array(
            'tag__in' => $tag_ids,
            'post__not_in' => $post->ID,
            'showposts'=> 5
        ); 
    } else {
        $args = array(
                'post_type' => 'videos',
                'showposts'=> 5,
                'cat' => $cat_id  
        );
    }
    $query = new WP_Query($args);
    if ( $query->have_posts() ) {
        $i=1;
        ?>
        <ul>
       <?php while ($query->have_posts()){ 
            $query->the_post();
                $attachments = get_children( array(
                            'post_type' => 'attachment',
                            'posts_per_page' => 0,
                            'post_parent' => $query->post->ID
                        ) );
                        if($attachments){
                            foreach($attachments as $attachment){
                                $thumbs = wp_get_attachment_metadata( $attachment->ID );
                                $thumbnail = $thumbs['sizes']['home-carousel']['url'];
                            }
                        }
                  //var_dump(isFileUrl($thumbnail));
                  if(isFileUrl($thumbnail) == true){ ?>
                    <li>
                        <article class="video_related_item" id="video_related_item_<?php echo $query->post->ID; ?>">
                            <div class="image-holder">
                                <a href="<?php the_permalink(); ?>" id="<?php echo $i; ?>">
                                    <img src="<?php echo $thumbnail; ?>" />
                                </a>
                            </div>
                            <h6 class="layout-title"><?php the_title(); ?></h6>
                            <p><?php the_excerpt_max_charlength(60); ?></p>
                        </article> 
                    </li>
                  <?php }
        $i++;
        } ?>
        </ul>
       
    <?php }
    wp_reset_postdata();
}

function mk_category_loop($cat_id){
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
                'post_type' => 'videos',
                'showposts'=> 5,
                'cat' => $cat_id  
            );
    $query = new WP_Query($args);
    if ( $query->have_posts() ) {
        $i=1;
         while ($query->have_posts()){
            $query->the_post();
            $attachments = get_children( array(
                            'post_type' => 'attachment',
                            'posts_per_page' => 0,
                            'post_parent' => $query->post->ID
                        ) );
            if($attachments){
                foreach($attachments as $attachment){
                    $thumbs = wp_get_attachment_metadata( $attachment->ID );
                    $thumbnail = $thumbs['sizes']['single-column']['url'];
                }
            }
            //var_dump(isFileUrl($thumbnail));
            if(isFileUrl($thumbnail) == true){
            ?>
                <article class="video_category_item" id="video_category_item_<?php echo $query->post->ID; ?>">
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php echo $thumbnail; ?>" />
                    </a>
                    <div class="media-body">
                        <h3 class="layout-title media-heading">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h6>
                        <ul class="stats">
                            <li><?php makusi_countviews( get_the_ID() ); ?></li>
                            <!--li><?php comments_number() ?></li-->
                            <li><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) ; ?></li>
                        </ul>
                        <?php the_excerpt_max_charlength(50); ?><br />
                        
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </article>
                <?php
                } 
         }
    }
}

function mk_tag_loop($tag){
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
                'post_type' => 'videos',
                'showposts'=> 5,
                'tag' => $tag  
            );
    $query = new WP_Query($args);
    if ( $query->have_posts() ) {
        $i=0;
         while ($query->have_posts()){
            $query->the_post();
            $attachments = get_children( array(
                            'post_type' => 'attachment',
                            'posts_per_page' => 0,
                            'post_parent' => $query->post->ID
                        ) );
            if($attachments){
                foreach($attachments as $attachment){
                    $thumbs = wp_get_attachment_metadata( $attachment->ID );
                    $thumbnail = $thumbs['sizes']['single-column']['url'];
                }
            }
            //var_dump(isFileUrl($thumbnail));
            if(isFileUrl($thumbnail) == true){
            ?>
                <div class="col-xs-12 col-md-6">
                <article class="video_tag_item" id="video_tag_item_<?php echo $query->post->ID; ?>">
                    <div class="image-holder">
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo $thumbnail; ?>" />
                        </a>
                        <div class="overlay">
                            <a href="<?php the_permalink(); ?>" class="expand"><i class="fa fa-play"></i></a>
                            <a class="close-overlay hidden">x</a>
                        </div>
                        <div class="video-duration">
                            <?php echo $metadata['length_formatted']; ?>
                        </div>
                    </div>
                    <div class="media-body">
                        
                        <h6 class="layout-title media-heading">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h6>
                        
                        <p><?php the_excerpt_max_charlength(70); ?></p>
                         <div class="clearfix"></div>
                         <ul class="stats">
                            <li><?php makusi_countviews( get_the_ID() ); ?></li>
                            <!--li><?php comments_number() ?></li-->
                            <li><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) ; ?></li>
                        </ul>
                        <div class="clearfix"></div>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </article>
                </div>
            
             <?php if($i%2 == 0 && $i != 0){ ?>
                <div class="clearfix"></div> 
                <?php } ?>
            <?php } ?>
        <?php    $i++;   
         }
         
    }
    wp_reset_postdata();
}

function mk_author_loop_sidebar($user_id){
    global $userdata;
    $args = array(
                'post_type' =>'videos',
                'author' => $user_id);
    $query = new WP_Query($args);
    if ( $query->have_posts() ) {
        $i=1;
        while ($query->have_posts()){
            $query->the_post();
            $attachments = get_children( array(
                            'post_type' => 'attachment',
                            'posts_per_page' => 0,
                            'post_parent' => $query->post->ID
                        ) );
            if($attachments){
                foreach($attachments as $attachment){
                    $thumbs = wp_get_attachment_metadata( $attachment->ID );
                    $thumbnail = $thumbs['sizes']['sidebar']['url'];
                }
            }
            if(isFileUrl($thumbnail) == true){ ?>
                <article class="video_user_item" id="video_user_item_<?php echo $query->post->ID; ?>">
                    <div class="image-holder">
                        <a href="<?php the_permalink(); ?>" id="<?php echo $i; ?>">
                            <img src="<?php echo $thumbnail; ?>" />
                        </a>
                    </div>
                    <h6 class="layout-title"><?php the_title(); ?></h6>
                        <p><?php the_excerpt_max_charlength(60); ?></p>
                        <?php if($userdata->ID == $user_id){ 
                                $edit_page = (int) get_option( 'wpuf_edit_page_url' );
                                $url = wp_nonce_url( get_permalink( $edit_page ) . '?pid=' . $post_id, 'wpuf_edit' );
                        ?>
                            <p><a href="<?php echo $url; ?>">Edit</a></p>
                        <?php } ?><p>
                </article>
            <?php }
            $i++;
        }
    }
    wp_reset_postdata();
}

function mk_search_loop(){
    $searchterm = $_REQUEST['s'];
    
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
                'post_type' => 'videos',
                'showposts'=> 5,
                's' => $_REQUEST['s']  
            );
    $query = new WP_Query($args);
    $count = count($query);
    if ( $query->have_posts() ) {
        echo "<p>";
        echo __('Tu búsqueda para el término ','makusi').'<strong>"'.$_REQUEST['s'].'"</strong>'.__(' dió los resultados siguientes ','makusi').$count;
        if($count == 1)
            echo __(' resultado','makusi');
        else 
            echo __(' resultados','makusi');
        echo "</p>";
        $i=1;
         while ($query->have_posts()){
            $query->the_post();
            $attachments = get_children( array(
                            'post_type' => 'attachment',
                            'posts_per_page' => 0,
                            'post_parent' => $query->post->ID
                        ) );
            if($attachments){
                foreach($attachments as $attachment){
                    $thumbs = wp_get_attachment_metadata( $attachment->ID );
                    $thumbnail = $thumbs['sizes']['single-column']['url'];
                }
            }
            //var_dump(isFileUrl($thumbnail));
            if(isFileUrl($thumbnail) == true){
            ?>
                <article class="video_tag_item" id="video_tag_item_<?php echo $query->post->ID; ?>">
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php echo $thumbnail; ?>" />
                    </a>
                    <div class="media-body">
                        
                        <h3 class="layout-title media-heading">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        
                        <?php the_excerpt_max_charlength(200); ?><br />

                        <div class="clr"></div>
                        <ul class="stats">
                            <li><?php makusi_countviews( get_the_ID() ); ?></li>
                            <li><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) ; ?></li>
                        </ul>
                    </div>
                    <div class="clr"></div>
                </article>
                <?php
                } 
         }
    } else {
        echo "<p>";
        echo __('Tu búsqueda para el término ','makusi').'"'.$_REQUEST['s'].__(' no dió resultados.','makusi');
        echo "</p>";
    }
}

function mk_loop($location = false, $thumb_type = false, $showposts = false, $offset = false, $posts_per_page = false, $paged = false, $author_loop = false, $user_id = false, $cat_id = false, $tag_id = false){
    // 1. ARGS
    // 1.1 MAIN QUERY ARGS
    $args = array('post_type'=>'videos','post_status'=>'publish' );
    // 1.2 CONDITIONAL QUERY ARGS
    if($position == 'carrousel'){
        $args['meta_key'] = 'queue_status';
        $args['meta_value'] = 'uncompressed';
    }
    if($showposts != false) 
	$args['showposts'] = $showposts;
    if($offset != false) 
        $args['offset'] = $offset;
    if($posts_per_page != false)
	$args['posts_per_page'] = $posts_per_page; 
    if($paged != false) {
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args['paged'] = $paged;
    }
    if($author_loop != false){
	global $userdata;
	if($user_id != false)
            $args['author'] = $user_id;
    }
    if($cat_id != false)
        $args['cat'] = $cat_id;
    if($tag_id != false)
	$args['tag'] = $tag_id;
	
    // 2. ARGS	
    $query = new WP_Query($args);
    $count = count($query);
	
    // 3. BEGIN LOOP
    if ( $query->have_posts() ) {
	$i=1;
	while ($query->have_posts()){
            $query->the_post();
	// 3. ATTACHMENT QUERY
            $attachments = get_children( array(
                            'post_type' => 'attachment',
                            'posts_per_page' => 0,
                            'post_parent' => $query->post->ID
                        ) );
            if(count($attachments) > 0){ ?>
		<?php if($location != 'feature'): ?>
                    <ul>
                <?php endif; ?>
		<?php if($attachments){
			foreach($attachments as $attachment){
                            $metadata = wp_get_attachment_metadata( $attachment->ID );
                            $thumbs = wp_get_attachment_metadata( $attachment->ID );
                            $thumbnail = $thumbs['sizes'][$thumb_type]['url'];
                    	}			
		}
	// 4. VIEW
		if(isFileUrl($thumbnail) == true){ 
                    if($location == 'feature' ) : ?>
			<div class="col-xs-12 col-md-6">
                    <?php elseif($location == 'latest' ) : ?>
			<div class="col-xs-12 col-md-3">
                    <?php elseif($location == 'screen'): ?>
			<div id="tab<?php echo $i; ?>" class="tabcontainer">
                    <?php else: ?>
			<li>
                    <?php endif; ?>
			<article class="video_<?php echo $location; ?>_item" id="video_<?php echo $location; ?>_item_<?php echo $query->post->ID; ?>">
                            <div class="image-holder">
				<a href="<?php the_permalink(); ?>"<?php if($location == 'carrousel'): ?> class="tablink" id="<?php echo $i; ?>"<?php endif;?>>
                                    <img src="<?php echo $thumbnail; ?>" />
                                    <div class="clr"></div>
                                </a>
				<?php if($location == 'screen' || $location == 'carousel'): ?>
                                    <div class="video-title-holder">
                                        <h6 class="layout-title">
                                            <?php the_title_max_charlength(70); ?>
                                        </h6>
                                        <?php if($location == 'screen'): ?>
                                            <p><?php the_excerpt_max_charlength(10); ?></p>
                                        <?php endif; ?>
                                    </div>
				<?php endif; ?>
				<div class="overlay">
                                    <a href="<?php the_permalink(); ?>" class="expand"><i class="fa fa-play"></i></a>
                                    <a class="close-overlay hidden">x</a>
                                </div>
                                <div class="video-duration">
                                    <?php echo $metadata['length_formatted']; ?>
                                </div>	
                            </div>
                            <div class="clear"></div>
                            <?php if($location != 'screen' || $location != 'carrousel') : ?>
				<h6 class="layout-title">
                                    <a href="<?php the_permalink(); ?>">
                            		<?php the_title(); ?>
                                    </a>
                    		</h6>
				<p class="video-description"><?php the_excerpt_max_charlength(60); ?></p>              
				<div class="clr"></div>
                     		<ul class="stats">
                                    <li><?php makusi_countviews( $query->post->ID ); ?></li>
                                    <li>
                            		<i class='fa fa-calendar'></i>&nbsp;&nbsp;
                            		<?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) ; ?>
                                    </li>
                    		</ul>
                            <?php endif; ?>
			</article>					
		<?php if($location == 'latest' || $location == 'screen') : ?>
                    </div>
		<?php else: ?>
                    </li>
		<?php endif; ?>							
		<?php	}
		$i++;	
		// FINISH MAIN LOOP
		} ?>
		<?php if($location != 'feature'): ?>
			</ul>
		<?php endif; ?>
    <?php   } ?>
<?php	} ?>
<?php if($paged != false): ?>
	<div class="clr"></div>
            <br />
            <div class="col-md-12">
                <?php create_pagination(16); ?>
                <div class="clr"></div>
            </div>
     	<div class="clr"></div>
<?php endif;
	wp_reset_postdata();
} ?>