<?php get_header(); ?>
<div class="single-wrapper">
    <section class="content-single col-xs-12 col-md-8">
        <?php while (have_posts()) : the_post(); global $post;
        global $wp_query;
        $thePostID = $wp_query->post->ID;
        $postdata = get_post($thePostID, ARRAY_A);
        $author_id = $postdata['post_author'];
        $author = get_userdata($author_id);
        $privacy_settings = get_post_meta( get_the_ID(),'privacy_settings',true );
        $password = get_post_meta( get_the_ID(),'password',true );
        if(($privacy_settings == "Oculto" 
                || $privacy_settings == "Hidden" 
                || $privacy_settings == "Ezkutatuta"
                || $privacy_settings == "Ocult"
                || $privacy_settings == "Caché"
                ) && $password != $_REQUEST['password']){ ?>
            <form action="http://<?php echo $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];?>" method="POST">
                <h2><?php echo __('Página Protegida', 'makusi'); ?></h2> 
                <p><?php echo __('Esta es una página protegida. Por favor introduce la contraseña.','makusi'); ?></p>
                <input type="password" name="password" /><br /><br />
                <input type="submit" name="submit_password" value="<?php echo __('Enviar Contraseña','makusi'); ?>" />
            </form>
        <?php  } else {
        mk_video($post->ID); ?>
        <?php the_title('<h1 class="video-title">','</h1>'); ?>
        
        <br />  
        <div class="single-author">
            <div class="visitscounter">
                <?php makusi_countviews( $post->ID ); ?>
            </div>
            <?php 
            global $userdata;
            if ( is_super_admin($userdata->ID) ) { ?>
            <div class="donateiconwrapper">
                <a href="<?php echo site_url();?>/hacer-donativo/?post_id=<?php echo $post->ID; ?>">
                    <i class="fa fa-asterisk"></i> <?php echo __('DONAR','makusi'); ?>
                    <!--img src="<?php echo get_template_directory_uri(); ?>/images/donate.png" /-->
                </a>
            </div>
        <?php } ?>
            <?php if(mk_video_for_mobile($post->ID) != false) { ?>
            <div class="mobiledownloadicon">
                <a href="<?php echo mk_video_for_mobile($post->ID); ?>" title="<?php echo __('Descarga para móvil','makusi'); ?> "><i class="fa fa-mobile"></i></a>
            </div>
            <?php } ?>
            <div class="downloadicon">
                <a href="<?php mk_video_attachment($post->ID); ?>" title="<?php echo __('Descarga','makusi'); ?> "><i class="fa fa-download"></i></a>
            </div>
            <div class="licences">
                <?php $creative_commons_license = get_post_meta( get_the_ID(),'creative_commons_license',true ); ?>
                <?php if($creative_commons_license != ''){
                    echo '<span class="cc">';
                    switch(strstr($creative_commons_license,'[')){
                        /*a: SA, b: BY, c: CC Circle, d: ND, n: NC, m: Sampling, s: Share, r: Remix, C: CC Full Logo*/
                    case '[CC BY]':
                        echo "<div class='cc-spacer'>c</div><div class='cc-spacer'>b</div></span>";
                        //echo __('Atribución','makusi'); // Share Alike
                        break;
                    case '[CC BY-ND]':
                        echo "<div class='cc-spacer'>c</div><div class='cc-spacer'>b</div><div class='cc-spacer'>d</div></span>";
                        //echo __('Atribución No Derivadas','makusi'); // Share Alike
                        break;
                    case '[CC BY-NC]':
                        echo "<div class='cc-spacer'>c</div><div class='cc-spacer'>b</div><div class='cc-spacer'>n</div></span>";
                        //echo __('Atribución No Comercial','makusi'); // Share Alike
                        break;
                    case '[CC BY-NC-ND]':
                        echo "<div class='cc-spacer'>c</div><div class='cc-spacer'>b</div><div class='cc-spacer'>n</div><div class='cc-spacer'>d</div></span>";
                        //echo __('Atribución No Comercial No Derivadas','makusi'); // Share Alike
                        break;
                    case '[CC BY-NC-SA]':
                        echo "<div class='cc-spacer'>c</div><div class='cc-spacer'>b</div><div class='cc-spacer'>a</div><div class='cc-spacer'>n</div></span>";
                        //echo __('Atribución Compartir Igual No Comercial','makusi'); // Share Alike
                        break;
                    case '[CC BY-SA]':
                        echo "<div class='cc-spacer'>c</div><div class='cc-spacer'>b</div><div class='cc-spacer'>a</div></span>";
                        //echo __('Atribución Compartir Igual','makusi'); // Share Alike
                        break;
                    default:
                        echo "</span>";
                        break;
                    }
                } else { ?>
                    <span class="cc">a</span> <?php echo __('Compatir Igual','makusi'); ?> 
                    <span class="cc">b</span> <?php echo __('Reconocimiento al creador','makusi'); ?> 
                    <span class="cc">c</span> <?php echo __('Creative Commons','makusi'); ?> 
                    <span class="cc">d</span> <?php echo __('Sin obras Derivadas','makusi'); ?> <br />
                    <span class="cc">n</span> <?php echo __('Prohibe el uso comercial','makusi'); ?> 
                    <span class="cc">s</span> <?php echo __('Share','makusi'); ?>
            <?php } ?>
            <br />
            </div>
            <a href="<?php site_url(); ?>/author/<?php the_author(); ?>">
                <?php the_author(); ?>
            </a>
            <div class="clearfix"></div>
        </div>
        <br />
        <?php the_excerpt(); ?>
        <?php if(get_the_tags() != null) { ?>
            <div class="single-tags">
            <?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>
            </div>
            <br />
        <?php } ?>
        
        
            
        <?php $children_protection = get_post_meta( get_the_ID(),'children_protection',true ); ?>
        <?php if($children_protection != ''){ 
            echo $children_protection;
            echo '<br />';
        } ?>
        <!-- TABBED CONTENT -->
        <div id="tabs">
            <nav>
                <ul class="tabs">
                    <li class="tab-current">
                        <a href="#section-1">
                            <span><?php echo __('Compartir','makusi'); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#section-2">
                            <span><?php echo __('Inserción','makusi'); ?></span>
                        </a>
                    </li>
                    <!--li>
                        <a href="#section-3">
                            <span><?php //echo __('Descarga','makusi'); ?></span>
                        </a>
                    </li-->
                    <li>
                        <a href="#section-4">
                            <span><?php echo __('Contactar Usuari@','makusi'); ?></span>
                        </a>
                    </li>
                    <!--li>
                        <a href="#section-5">
                            <span><?php echo __('Donar','makusi'); ?></span>
                        </a>
                    </li-->
                </ul>
            </nav>
            <!--div class="content"-->
            <section id="section-1">
                <div class="mediabox">
                    <?php fb_tag($post->ID); ?><br /><br />
                    <?php twitter_button(); ?>
                    <!--script type="text/javascript" src="http://meneame.net/api/check_url.js.php"></script>
                    <a href="http://www.meneame.net/submit.php?url=<?php the_permalink(); ?>" target="_blank">menéame</a-->
         	</div>
            </section>
            <section id="section-2">
         	<div class="embed-left">
                    <label for="dimensions"><?php echo __('Dimensiones','makusi'); ?></label><br />
                    <input type="radio" class="radio_dimensions" name="dimensions" value="small" /> 200x120 (<?php echo __('Columna lateral','makusi'); ?>)<br />
                    <input type="radio" class="radio_dimensions" name="dimensions" value="medium" /> 320x240 (<?php echo __('Medio','makusi'); ?>)<br />
                    <input type="radio" class="radio_dimensions" name="dimensions" value="large" /> 640x480 (<?php echo __('Ancho','makusi'); ?>)<br />
                </div>
                <div class="embed-right"> 
                    <textarea id="embed_code" name="embed_code"><iframe width="200" height="120" frameborder="0" src="<?php echo get_site_url(); ?>/view/<?php echo $post->ID; ?>"></iframe></textarea>
                    <p><?php echo __('Este código puedes insertarlo en tu blog o página web y se mostrará correctamente.','makusi'); ?></p>
                </div>        	
            </section>
            <!--section id="section-3">
                <a href="<?php mk_video_attachment($post->ID); ?>"><?php echo __('Descarga','makusi');?></a>
            </section-->
            <section id="section-4">
                <form id="contact-sender">
                    <input type="text" name="contact-sender-name" id="contact-sender-name" placeholder="<?php echo __('Tu nombre','makusi'); ?>" />
                    <br /><br />
                    <input type="text" name="contact-sender-email" id="contact-sender-email" placeholder="<?php echo __('Tu email','makusi'); ?>">                    
                    <br /><br />
                    <textarea name="contact-sender-message" id="contact-sender-message" placeholder="<?php echo __('Tu mensaje','makusi'); ?>"></textarea>
                    <br /><br />
                    <input type="hidden" name="contact-sender-useremail" id="contact-sender-useremail" value="<?php echo $author->user_email; ?>">
                    <input type="hidden" name="contact-sender-id" id="contact-sender-id" value="<?php echo $author_id; ?>">
                    <input type="submit" />
                </form>
            </section>
            <!--section id="section-5">
                <div id="donate_contaier">
                    <h3><?php echo __('Donar','makusi'); ?></h3>
                    <form type="GET" action="<?php echo home_url( '/donar' ); ?>">
                        <input type="radio" name="donation_value" value="5" /> 5&euro;&nbsp;&nbsp;
                        <input type="radio" name="donation_value" value="10" /> 10&euro;&nbsp;&nbsp;
                        <input type="radio" name="donation_value" value="50" /> 50&euro;&nbsp;&nbsp;
                        <input type="radio" name="donation_value" value="100" /> 100&euro;<br /><br />
                        <input type="hidden" name="post_id" value="<?php echo $post->ID ;?>" />
                        <input type="hidden" name="author" value="<?php the_author(); ?>" />
                        <input type="hidden" name="author_id" value="<?php the_author_meta( 'ID' ); ?>" />
                        <input type="submit" name="donation_submit" value="<?php echo __('Donar','makusi'); ?>" />
                    </form>
                </div>
            </section-->
	</div><!-- /tabs -->
        <?php } ?>
        <span class="cc">C</span> <a href="http://es.wikipedia.org/wiki/Licencias_Creative_Commons" target="_blank"><?php echo __('Sobre las licencias Creative Commons: ','makusi'); ?> [Wikipedia]</a>
      <?php //comments_template(); ?>
    <!-- END TABBED CONTENT -->
    </section>
    
    <aside class="related-videos col-md-4 col-xs-12 ">
        <div class="widget-item panel panel-warning">
            <div class="widget-title panel-heading">
                <?php echo __('Subido por','makusi'); ?>
            </div>
            <div class="author-panel-content">
        <?php echo get_avatar( $author_id, '80' ); ?>
                <strong><?php the_author(); ?></strong>
                
        <br />
        <?php $usermeta = get_user_meta($author_id); ?>
        <!--
        <?php var_dump($usermeta); ?>
        -->
        <?php 
        if($usermeta['showemail'][0] == 'yes')
            echo $author->user_email; ?>
        <br />
        
        <!--pre>
        <?php //var_dump($usermeta['twitter']); ?>
        </pre-->
        <?php 
        if($usermeta['twitter'][0] != ''){
            echo "<i class='fa fa-twitter'></i> <a href='http://www.twitter.com/".$usermeta['twitter'][0]."'>@".$usermeta['twitter'][0]."</a><br />";
        }
        if($usermeta['facebook'][0] != ''){
            echo "<i class='fa fa-facebook'></i> <a href='".$usermeta['facebook'][0]."'>".$usermeta['facebook'][0]."</a><br />";
        }
        if($usermeta['googleplus'][0] != ''){
            echo "<i class='fa fa-google-plus'></i> <a href='".$usermeta['googleplus'][0]."'>".$usermeta['googleplus'][0]."</a><br />";
        }
        ?>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
         <?php 
                if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('single-sidebar')) :
                endif;
            ?>
        <?php mk_author_loop_sidebar($author_id); ?>
    </aside>
    <div class="clear"></div>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>