<div class="clear"></div>
    </div>
    <footer>
        <div class="container">
            <div class="col-xs-12 col-sm-3 col-md-3">
                <span style="-moz-transform: scaleX(-1); -o-transform: scaleX(-1); -webkit-transform: scaleX(-1); transform: scaleX(-1); display: inline-block;">
                    ©
                </span>
            MAKUSI.TV
            <?php 
                     if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-1')) :
                     endif; 
                ?>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-3">
                <?php 
                     if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-2')) :
                     endif; 
                ?>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-3">
                <?php 
                     if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-3')) :
                     endif; 
                ?>
            </div>
            <div class="col-xs-12 col-sm-3 col-md-3">
                <?php 
                     if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-4')) :
                     endif; 
                ?>
            </div>
        </div>
        
    </footer>
<?php wp_footer(); ?>

</body>
</html>