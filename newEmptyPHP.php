<?php

/**
*  Template Name: Page Activate Donation
* 
*/

get_header();
global $current_user, $wp_roles;
get_currentuserinfo();
require_once( ABSPATH . WPINC . '/registration.php' );
$error="";


if($_POST['submit_bank_details'] != "" ){
    if(strlen($_POST['bank_entity']) < 4 || strlen($_POST['bank_office']) < 4 || strlen($_POST['bank_control']) < 2 || strlen($_POST['bank_account']) < 10){
        $error .= __('ERROR','makusi');
        if(strlen($_POST['bank_entity']) < 4){
            $error .= '<br />'.__('Entidad del banco no está completa (4 caracteres)','makusi');
        }
        if(strlen($_POST['bank_office']) < 4){
            $error .= '<br />'.__('Número de la oficina del banco no está completa (4 caracteres)','makusi');
        }
        if(strlen($_POST['bank_control']) < 2){
            $error .= '<br />'.__('Número de control del banco no está completa (2 caracteres)','makusi');
        }
        if(strlen($_POST['bank_account']) < 10){
            $error .= '<br />'.__('Número de cuenta del banco no está completa (10 caracteres)','makusi');
        }
    }
    $full_bank_account_number = $_POST['bank_entity'].'-'.$_POST['bank_office'].'-'.$_POST['bank_control'].'-'.$_POST['bank_account'];
    update_user_meta($current_user->ID, "user_bank_account_number", $full_bank_account_number);
    if($_POST['bank_account_country'] != ''){
        update_user_meta($current_user->ID, "user_bank_number", $_POST['bank_account_country']);
    }
    if($_POST['bank_account_bic'] != ''){
        update_user_meta($current_user->ID, "user_bank_bic", $_POST['bank_account_bic']);
    }
}
?>
    <div class="content col-md-8">
        <div class="formwrapper">
            <?php 
                while (have_posts()) : the_post(); 
                    the_title('<h2>', '</h2>');
                    the_content(); 
                endwhile; ?>
            
            <?php if ( !is_user_logged_in() ) : ?>
                    <div class="alert alert-danger">.
                        <?php _e('Tienes que estar conectado para poder editar este perfil.', 'makusi'); ?>
                    </div>
                    <!-- .warning -->
            <?php else : ?>
                <?php if($error != ''){ ?>
                    <div class="widget-register-error"><?php echo $error; ?></div>
                <?php } else { ?>
                <form>
                    <table>
                        <tr>
                            <th>
                                <label><?php echo __('Entidad','makusi'); ?></label>
                            </th>
                            <th>
                                <label><?php echo __('Oficina','makusi'); ?></label>
                            </th>
                            <th>
                                <label><?php echo __('Control','makusi'); ?></label>
                            </th>
                            <th>
                                <label><?php echo __('Número de Cuenta','makusi'); ?></label>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="bank_entity" size="4" />
                            </td>
                            <td>
                                <input type="text" name="bank_office" size="4" />
                            </td>
                            <td>
                                <input type="text" name="bank_control" size="2" />
                            </td>
                            <td>
                                <input type="text" name="bank_account" size="10" />
                            </td>
                        </tr>
                    </table>
                    <br />
                    <input type="checkbox" name="activate_international" id="activate_international" />
                    <div id="international_wrapper">
                        <label><?php echo __('País/Estado' , 'makusi'); ?></label>
                        <select name="bank_account_country">
                            <option value="ES"><?php echo __('España','makusi'); ?></option>
                            <option value="FR"><?php echo __('Francia','makusi'); ?></option>
                        </select>
                        <br />
                        <label><?php echo __('BIC' , 'makusi'); ?></label>
                        <input type="text" name="bank_account_bic" />
                        <input type="submit" name="submit_bank_details" value="<?php echo __('Enviar','makusi'); ?>" />
                    </div>
                </form>
                <?php } ?>
            <?php endif; ?>
        </div>
    </div>
    <aside class="col-md-4"> 
        <!-- Search Form -->
        <form action="<?php echo home_url( '/' ); ?>" method="get">
            <input type="text" name="s" class="searchvideo" placeholder="<?php echo __('Buscar Videos...','makusi'); ?>" />
        </form>
        <br /><br />
        <div class="clr"></div>
        <br /><br />
        <!-- End Search Form -->
        <?php 
            if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('home-right')) :
            endif;
        ?>
        <?php //get_sidebar(); ?>
    </aside>
<?php get_footer(); ?>

