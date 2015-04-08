<?php 
/**
 * Template Name: TPV Success Page
 *
 * Allow users to update their profiles from Frontend.
 *
 */

$makusi_options = get_option( 'theme_makusi_options' ); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head profile="http://gmpg.org/xfn/11"></head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <!-- Title, Keywords and Description -->
        <title><?php wp_title( '|', true, 'right' ); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
        
        <?php wp_head(); ?>

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
        <header>
            <div class="header">
                <div class="container">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <a href="<?php echo site_url(); ?>">
                            <img style="max-width:100%;" id="logo" src="<?php echo esc_url( $makusi_options['logo'] ); ?>" align="left" border="0" />
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>  
        </header>
        <div class="container"> 
        <div class="content col-md-12 page-<?php echo $post->post_name; ?>">
        <?php while (have_posts()) : the_post();
                the_title('<h2>', '</h2>');
                the_content(); 
            endwhile; ?>
        </div>
        </div>
        <footer class="footer-tpv">
            <div class="container"> 
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <span style="-moz-transform: scaleX(-1); -o-transform: scaleX(-1); -webkit-transform: scaleX(-1); transform: scaleX(-1); display: inline-block;">
                        ©
                    </span>
                    MAKUSI.TV<br /><br />
            </div>
            </div>
        </footer>
    </body>
</html>
