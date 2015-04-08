<?php 
/**
*  Template Name: Embed Video
* 
*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <?php //if(is_single()){
            while (have_posts()) : the_post(); global $post; ?>
                <meta property="og:title" content="<?php the_title(); ?>" />
                <meta property="og:url" content="<?php the_permalink(); ?>" />
                <meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
                <meta property="og:description" content="<?php the_excerpt(); ?>" />
                <meta property="og:type" content="video.movie" />
                <?php if( has_post_thumbnail()) {
                    //$thumbnail = the_post_thumbnail();
                    $thumbnail = mk_obtain_thumb($post->ID);
                    $video = mk_obtain_video($post->ID);
                    ?>
                    <meta property="og:image" content="<?php echo $thumbnail; ?>" />
                    <meta property="og:image:type" content="image/png" />
                    <meta property="og:image:width" content="730" />
                    <meta property="og:image:height" content="380" />
                    <meta property="og:video" content="<?php echo $video; ?>" />
                    <meta property="og:video:type" content="application/mp4" />
                    <meta property="og:video:width" content="640" />
                    <meta property="og:video:height" content="360" />  
                <?php } ?>
                    
            <?php endwhile; ?>   
        <?php //} ?>
        <style type="text/css">
            video {
                width: 87.5%    !important;
                height: auto   !important;
            }
        </style>
        
    </head>
    <body style="margin:0; padding:0;">
        <?php   while (have_posts()) : the_post();
                    the_content();
                endwhile; ?>
    </body>
</html>

