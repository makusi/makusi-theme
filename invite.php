<?php 
$random_number = mt_rand(1, 15);
?>
<style type="text/css">
    .blue-background-wrapper{
        background: white url('<?php echo get_template_directory_uri(); ?>/images/backgrounds/ganza<?php echo $random_number; ?>.jpg') no-repeat 50% 50%/100% auto;
    }
</style>
<div class="invite-container<?php if(!is_home()) { echo " hide"; } ?>">
    <a href="#" id="close-invite"><img alt="<?php echo __('Close this window' ,'makusi'); ?>" src="<?php echo get_template_directory_uri(); ?>/images/close-invite.png" /></a>
    <div class="container">
        <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invite-left">
            <!--h1><?php echo __('Bienvenid@ a makusi.tv','makusi'); ?></h1-->
            <h1><?php echo __('soñar. grabar. compartir','makusi'); ?></h1>
            <ul class="feature-list">
                <li><i class="fa fa-bicycle" style="font-size:1.8em;"></i>&nbsp;&nbsp;&nbsp;<?php echo __('Con autonomía digital' ,'makusi'); ?></li>
                <li><i class="fa fa-users" style="font-size:1.8em;"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Con tu comunidad' ,'makusi'); ?></li>
                <li><i class="fa fa-cc" style="font-size:1.8em;"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Con licencias libres y abiertas' ,'makusi'); ?></li>
                <li><i class="fa fa-umbrella" style="font-size:1.8em;"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo __('Sin publicidad' ,'makusi'); ?></li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-offset-3 col-sm-7 col-md-offset-1 col-md-5 col-lg-offset-1 col-lg-5  invite-right">
            
             <div class="vertical-text login-wizzard">
                <div class="wizzard-block wizzard-active" id="wizzard-register">
                    <a class="lateral-register-link" href="#"><?php echo __('Crea tu cuenta','makusi'); ?></a>
                </div>
                <div class="wizzard-block" id="wizzard-subscription">
                    <a class="lateral-subscription-link" href="#"><?php echo __('Suscribete','makusi'); ?></a>
                </div>
                <div class="wizzard-block" id="wizzard-security">
                    <a class="lateral-security-link" href="#"><?php echo __('Seguridad','makusi'); ?></a>
                </div>
                <div class="wizzard-block" id="wizzard-login">
                    <a class="lateral-login-link" href="#"><?php echo __('Entrar','makusi'); ?></a>
                </div>
            </div>
            <div class="invite-block-wrapper">
                <div id="invite-register" class="invite-block">
                    <div id="register-wrap">
                        <div class="title">
                            <h1><?php echo __('Crea tu Cuenta' ,'makusi'); ?></h1>
                            <p><span><?php echo __('4 pasos sencillos para entrar a makusi' ,'makusi'); ?></span></p>
                        </div>
                        <form action="" method="post" class="user-forms" id="register-form"> 
                            <div class="col-xs-12  col-sm-12 col-md-12 col-lg-12 nopadding">
                                <input type="text" name="first_name" placeholder="<?php echo __('Nombre','makusi'); ?>" class="user-input input-register-firstname" />
                            </div>
                            <div class="col-xs-12  col-sm-12 col-md-12 col-lg-12 nopadding">
                            <input type="text" name="last_name" placeholder="<?php echo __('Apellido','makusi'); ?>" class="user-input input-register-lastname" />
                            </div>
                            <div class="col-xs-12  col-sm-12 col-md-12 col-lg-12 nopadding">
                                <input type="text" name="user_email" placeholder="<?php echo __('Email','makusi'); ?> *"  class="user-input input-register-email" />
                            </div>
                            <div class="col-xs-12  col-sm-12 col-md-12 col-lg-12 nopadding">
                                <input type="text" name="user_login" placeholder="<?php echo __('Usuario','makusi'); ?> *" class="user-input input-register-username"/>
                            </div>
                            <div class="col-xs-12  col-sm-6 col-md-12 col-lg-12 nopadding register-password-wrapper">
                                <input type="password" name="user_pass" placeholder="<?php echo __('Contraseña','makusi'); ?> *" class="user-input input-register-password" />
                            </div>
                            <div class="col-xs-12  col-sm-6 col-md-12 col-lg-12 nopadding register-password-wrapper-2">
                                <input type="password" name="password_check" placeholder="<?php echo __('Comprueba Contraseña','makusi'); ?> *" class="user-input input-register-password2" />
                            </div>
                            <div class="clearfix"></div>
                            <a href="#" class="btn btn-primary btn-sm" id="change-to-subscription"><?php echo __('PROXIMO','makusi'); ?> &nbsp;&gt;</a>
                            <input type="hidden" name="task" value="register" />
                            <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            <div id="invite-subscriptions" class="invite-block">
                <h1><?php echo __('Suscripciones','makusi'); ?></h1>
                <p><?php echo __('Si todavía no estás seguro de utilizar este servicio o del tipo de suscripción selecciona "Lo decidiré más adelante"<br /> .','makusi'); ?> 
                    <a href="#" id="open-subscription-dialog2" class="osx">
                        [<?php echo __('más info','makusi'); ?>]
                    </a>
                </p>
                
                <div id="osx-modal-content" title="Basic dialog"> 
                    <div id="osx-modal-title"><?php echo __('Suscripciones','makusi'); ?></div>
                    <div class="close"><a href="#" class="simplemodal-close">x</a></div>
                    <div id="osx-modal-data">
                        <?php echo __('En este paso te solicitamos que nos indiques que espacio de almacenaje te gustaría contratar con makusi.tv.<br /> No es necesario que realizes ningún tipo de pago en este paso. El pago te se realizará en el momento en que desees subir tu video. Si todavía no te has decidido puedes seleccionar "Todavía no lo he decidido"','makusi'); ?> 
                        <br /><br />
                        <button class="simplemodal-close"><?php echo __("Close","makusi"); ?></button>
                        <br /><br />
                    </div>
                </div>
                
                
                <div class="radio">
                    <div class="package-line">
                        <label for="later">
                            <?php echo __('Lo decidiré mas adelante','makusi'); ?>
                        </label>
                        <span></span>
                        <input type="radio" name="package" value="later" checked />
                        <span></span>
                    </div>
                   <?php 
                    $subscriptions = WPUF_Subscription::get_subscription_packs();
                    foreach ($subscriptions as $subscription){ ?>
                    <div class="package-line">
                            <div class="col-xs-3 col-md-3 noleftpadding">
                                <label for="<?php echo $subscription->name; ?>">
                                    <?php echo $subscription->name; ?>
                                </label>
                            </div>
                            <div class="col-xs-3 col-md-3 noleftpadding">   
                                <?php echo $subscription->cost; ?> €/<?php echo __('año','makusi'); ?>
                            </div>
                            <div class="col-xs-6 col-md-6 norightpadding" style="text-alignt:right">
                                <span></span>
                                <input type="radio" name="package" value="<?php echo $subscription->id; ?>" />
                                <span></span>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    <?php } ?>
                    <?php echo __('Precios indicados sin IVA.','makusi'); ?>
                </p>
                <p></p>
                </div>
                <a href="#" class="btn btn-primary btn-sm" id="change-to-register">&lt;&nbsp;<?php echo __('ANTERIOR','makusi'); ?></a>
                <a href="#" class="btn btn-primary btn-sm" id="change-to-security"><?php echo __('PROXIMO','makusi'); ?>&nbsp;&gt;</a>
            </div>

                <div id="invite-security" class="invite-block">
                    <div id="register-warning"></div>
                    <!-- RECAPTCHA -->
                        <script type="text/javascript">
                            var RecaptchaOptions = {
                                theme : 'custom',
                                custom_theme_widget: 'recaptcha_widget'
                            };
                        </script>
                        <?php 
                        
                        //require_once(TEMPLATEPATH . '/includes/recaptcha/recaptchalib.php');
                        /*$publickey = "6LcMiPwSAAAAAL4af2IKD366QTG3HdJFDBXV1Gjd"; // you got this from the signup page
                        echo "1. recaptcha get html<br />";
                        echo recaptcha_get_html($publickey);
                        echo "2. recaptcha get html<br />";*/
                        ?>
                        
                        <div id="recaptcha_widget" style="display:none">

                            <div id="recaptcha_image"></div>
                            <div class="recaptcha_only_if_incorrect_sol" style="color:red"><?php echo __('Incorrecto, por favor, volver a intentarlo','makusi'); ?></div>
                            <br /><br />
                            <span class="recaptcha_only_if_image"><?php echo __('Introducir las palabras aquí:','makusi'); ?></span>
                            <span class="recaptcha_only_if_audio"><?php echo __('Introducir los números que has escuchado:','makusi'); ?></span>
                            <br /><br />
                            <input type="text" class="user-input" id="recaptcha_response_field" name="recaptcha_response_field" />
                            <br /><br />
                            <div class="row">
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                    <i class="fa fa-refresh"></i>
                                </div>
                                <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                    <a href="javascript:Recaptcha.reload()">
                                        <?php echo __('Obtener otro CAPTCHA','makusi'); ?>
                                    </a>
                                </div>
                            </div>
                            <div class="recaptcha_only_if_image row">
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                    <i class="fa fa-volume-off"></i>
                                </div>
                                <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                    <a href="javascript:Recaptcha.switch_type('audio')">
                                        <?php echo __('Obtener un CAPTCHA sonoro','makusi'); ?>
                                    </a>
                                </div>
                             </div>
                            <div class="recaptcha_only_if_audio row">
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                    <i class="fa fa-image"></i>
                                </div>
                                <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                    <a href="javascript:Recaptcha.switch_type('image')">
                                        <?php echo __('Obtener un CAPTCHA visual','makusi'); ?>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                    <i class="fa fa-question"></i>
                                </div>
                                <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">    
                                    <a href="javascript:Recaptcha.showhelp()">
                                        <?php echo __('Ayuda','makusi'); ?>
                                    </a>
                                </div>
                            </div>
                            <input type="hidden" name="recaptcha_challenge_field" value="6LcMiPwSAAAAAL4af2IKD366QTG3HdJFDBXV1Gjd" />
                            <br /><br />
                        </div>

                        
                        <script type="text/javascript"
                                src="https://www.google.com/recaptcha/api/challenge?k=6LcMiPwSAAAAAL4af2IKD366QTG3HdJFDBXV1Gjd">
                        </script>
                        <noscript>
                            <iframe src="https://www.google.com/recaptcha/api/noscript?k=6LcMiPwSAAAAAL4af2IKD366QTG3HdJFDBXV1Gjd"
                                    height="300" width="500" frameborder="0"></iframe><br>
                            <textarea name="recaptcha_challenge_field" rows="3" cols="40">
                            </textarea>
                            <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
                        </noscript>
                        <div class="clearfix"></div>
                        <!-- END RECAPTCHA -->
                    <a href="#" class="btn btn-primary btn-sm" id="change-back-to-subscriptions">&lt;&nbsp;<?php echo __('ANTERIOR','makusi'); ?></a>
                    <input type="submit" value="<?php echo __('CREA TU CUENTA','makusi'); ?>  >" class="btn btn-primary btn-sm" id="trigger_register" name="trigger_register" />
                </form>
                </div>
                
            <div id="invite-login" class="invite-block">
                <div class="title">
                    <h1><?php echo __('Entrar','makusi'); ?></h1>
                </div>
                <div id="login_warning"></div>
                    <form action="" method="post" class="user-forms" id="loginform">
                        <input type="text" name="log" id="log" placeholder="<?php echo __('Usuario','makusi'); ?>" class="user-input">
                        <input type="password" name="pwd" id="pwd" placeholder="<?php echo __('Contraseña','makusi'); ?>" class="user-input"><br />
                        <input type="submit" style="float:right;" value="<?php echo __('ENTRA','makusi'); ?>" id="trigger_login" class="btn btn-primary btn-sm" />
                        <input type="checkbox" name="rememberme" id="rememberme" /><?php echo __('Acuérdate de mí' , 'makusi'); ?>
                        <br /><br />
                        <!--div align="center">    
                            <a href="#" id="lost_password_link" class="btn btn-default btn-xs"><?php echo __('Forgot Password?','makusi'); ?></a>
                        </div-->
                    </form>
                    <hr />
                    <h3 style="color:white;margin-top:0;"><?php echo __('Recuperación contraseña','makusi'); ?></h3>
                <div id="password_warning"></div>
                    <form name="lost_password" id="lost_password" method="post" action="" class="user-forms">    
                        <input type="email" name="lost_email" id="lost_email" class="user-input" placeholder="<?php echo __('Escribe tu dirección email','makusi'); ?>" />
                        <div style="padding-left:0px;" class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <a href="#" class="btn btn-primary btn-sm" id="change-back-to-security">&lt;&nbsp;<?php echo __('ANTERIOR','makusi'); ?></a>
                        </div>
                        <div style="padding-right:0px;" class="col-xs-12 col-sm-6 col-md-6 col-lg-6" align="right">
                            <input type="submit" value="<?php echo __('ENVIAR','makusi'); ?>" id="trigger_lost" class="btn btn-primary btn-sm" /><br /><br />
                            <!--a href="#" id="login_link" class="btn btn-default btn-xs"><?php echo __('ENTRAR','makusi'); ?></a-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
</div>
