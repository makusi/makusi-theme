<div class="top">
         <!--div class="open-categories open-button">
            <img src="<?php echo get_template_directory_uri(); ?>/images/sideopen_small.png" align="left" /> 
                <?php echo __('CATEGORIAS','makusi'); ?>
         </div-->
        
            <?php if(!is_user_logged_in()): ?>
                <!--div id="login-button">
                    <img class="login_arrow" src="<?php echo get_template_directory_uri(); ?>/images/arrow_login.png" />
                    <br /><?php echo __('Accede a tu cuenta','makusi'); ?>
                </div-->
            <?php endif; ?>
            <?php if(is_user_logged_in()): ?> 
                <!--div class="open-user open-button">
                <div id="login-button">
                    <img class="login_arrow" src="<?php echo get_template_directory_uri(); ?>/images/arrow_login.png" />
                    <br /><?php echo __('Accede a tu cuenta','makusi'); ?>
                </div>
                <img src="<?php echo get_template_directory_uri(); ?>/images/sideopen_small.png" align="right" />
                <?php $current_user = wp_get_current_user(); echo $current_user->user_login; ?>
                </div--> 
            <?php endif; ?>
         
         <div class="container social_container">
			<div class="col-xs-12 social_container-inner">
                <nav class="social_menu">
                    <ul>
                        <li><a href="https://www.facebook.com/makusiTV" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://twitter.com/makusiTV" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="contacto" target="_blank"><i class="fa fa-envelope" title="<?php echo __('Contacto','makusi'); ?>"></i></a></li>
                        <li><a href="social" target="_blank"><i class="fa fa-users" title="<?php echo __('Comunidad','makusi'); ?>"></i></a></li>
                        <li><a href="faq" target="_blank" title="<?php echo __('F.A.Q.','makusi'); ?>"><i class="fa fa-question-circle"></i></a></li>
                        <!--li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="http://www.makusi.tv/feed/rss2/" target="_blank"><i class="fa fa-rss"></i></a></li-->
                    </ul>
                </nav>
				
                <div class="language-area"> 
                    <?php show_languages(); ?>
                </div>
            </div>
        </div>
</div><div class="clearfix" style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0.8);"></div>

