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
            <div class="col-xs-12 col-sm-offset-6 col-sm-5 col-md-4 col-lg-offset-7 col-lg-4 ">
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
                <!--nav class="header-menu">
                            <ul>
                                <li>
                                    <a class="social-link" href="http://www.makusi.tv/social"><?php echo __('Comunidad','makusi'); ?></a>
                                </li>
                                <?php if(!is_user_logged_in()){ ?>
                                <!--li class="register-link-container"><a class="register-link" href="#"><?php echo __('Registrar','makusi'); ?></a></li>
                                <li class="login-link-container"><a class="login-link" href="#"><?php echo __('Entrar','makusi'); ?></a></li-->
                                <?php } else { ?>
                                <!--li class="logout-link-container"><a class="logout-link" href="<?php echo wp_logout_url( site_url() ); ?>"><?php echo __('Salir','makusi'); ?></a></li-->
                                <?php } ?>
                                <!--li>
                                    <a class="faq_link"><?php echo __('FAQ','makusi');?></a>
                                </li>
                                <li>
                                    <a class="contact-link" href="<?php echo site_url(); ?>/contacto"><?php echo __('Contacto','makusi'); ?></a>
                                </li>
                            </ul>
                        </nav-->
                
            </div>
            <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 language-wrapper">
                <!--div id="language-title"><?php echo __('Idiomas: ','makusi');?></div-->
				<!--div class="dropdown"--> 
                <div class="language-area"> 
                    <?php show_languages(); ?>
                </div>
                
            </div>
        </div>
</div><div class="clearfix" style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0.8);"></div>

