<?php $makusi_options = get_option( 'theme_makusi_options' ); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head profile="http://gmpg.org/xfn/11">
        
        <?php if(is_single()){
            while (have_posts()) : the_post(); global $post; 
                $privacy_settings = get_post_meta( get_the_ID(),'privacy_settings',true );
                if(($privacy_settings == "Oculto" 
                    || $privacy_settings == "Hidden" 
                    || $privacy_settings == "Ezkutatuta"
                    || $privacy_settings == "Ocult"
                    || $privacy_settings == "Caché")
                        && $password != $_REQUEST['password']){ ?>
                    <meta name="robots" content="noindex" />
                <?php } ?>
                <meta property="og:title" content="<?php the_title(); ?>" />
                <!--meta property="og:url" content="<?php the_permalink(); ?>/" /-->
                <meta property="og:url" content="<?php bloginfo('url'); ?>/videos/<?php echo $post->ID; ?>/" />
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
                    <link rel="canonical" href="<?php bloginfo('url'); ?>/videos/<?php echo $post->ID; ?>/" />
            <?php endwhile; ?>   
        <?php } ?>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <!-- Title, Keywords and Description -->
        <title><?php wp_title( '|', true, 'right' ); ?> <?php bloginfo('name'); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <style type="text/css">
            <?php echo $makusi_options['stelios_css'] ; ?>        
        </style>
        <?php wp_head(); ?>
        <?php //bloginfo('rss2_url'); ?>
    </head>
    <body>
        <!-- GOOGLE ANALYTICS -->
         <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                ga('create', 'UA-49680741-1', 'auto');
                ga('send', 'pageview');

        </script>
        <!-- END GOOGLE ANALYTICS -->
        
        <?php fb_sdk(); ?>
        
        <?php get_template_part('dynamic-sidebars'); ?>
        
        <header>
            <div class="blue-background-wrapper">
                
            <?php get_template_part('topbar'); ?>
            <div class="header">
                <div class="container">
                    <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <a href="<?php echo site_url(); ?>">
                            <img style="max-width:100%;" id="logo" src="<?php echo esc_url( $makusi_options['logo'] ); ?>" align="left" border="0" />
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"> 
                        <?php if(!is_user_logged_in()){ ?>
                            <div class="register-link-wrapper">
                                <a class="register-link" href="#">
                                    <?php echo __('Crea tu cuenta','makusi'); ?>
                                </a>
                            </div>
                            <div class="login-link-wrapper">
                                <a class="login-link" href="#">
                                    <?php echo __('Entra','makusi'); ?>
                                </a>
                            </div>
                        <?php } else { ?>
                            <div class="upload-link-wrapper">
                                <a class="logout-link" href="<?php echo wp_logout_url( site_url() ); ?>">
                                    <?php echo __('Salida','makusi'); ?>
                                </a>
                            </div>
                        <?php } ?>    
                        <div class="upload-link-wrapper">
                            <?php if(is_user_logged_in()){ 
                                    icl_link_to_element(312,'page',__('Sube tu video','makusi'));
                                } else { 
                                    icl_link_to_element(1801,'page',__('Tus videos aquí','makusi'));        
                                }
                            ?>
                        </div>
                        
                    </div>
                </div>
                    </div>
                <div class="clearfix"></div>
            </div>
        <?php if(!is_user_logged_in()){
            get_template_part('invite');
        } ?>
        <div class="clr"></div>
       

        </div>
        </header>
        <?php if(is_home){ ?>
        <div class="fullwidth">
        <?php }?>
            <div class="container<?php if(is_category()) echo " category-container"; if(is_tag()) echo " tag-container"; if(is_search()) echo " search-container"; ?> body-container">
        
