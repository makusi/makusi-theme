<?php

/**
*  Template Name: Page Process Donation
* 
*/
$donation_post_id = $_POST['post_id'];
$post_values = get_post($donation_post_id);
$author_values = get_userdata( $post_values->post_author );

// Valores constantes del comercio
$url_tpvv = 'https://sis.redsys.es/sis/realizarPago';
$clave = 'baw85h1f2aB3Qrqw935a';
$name = 'ANAFI SOC COOP MAKUSI.TV';
$code = '058077918';
$terminal = '1';
$order = date('ymdHis');
$amount = $_REQUEST['amount']*100;
$currency = '978';
$transactionType='0';
$urlMerchant = add_query_arg( array('action'=> 'donate_tpv_success','post_id'=>$donation_post_id,'order'=>$order,'amount'=>$amount), home_url( '/donativo-procesado' ) );
//$urlOk = home_url('/ok');
//$urlKo = home_url('/ko');
$producto='Donation';
get_header(); ?>
<script language=JavaScript>
    function calc() { 
        vent=window.open('','donate','width=725,height=600,scrollbars=no,resizable=yes,status=yes,menubar=no,location=no');
        document.forms[0].submit();
    }
    </script>
    <div class="single-wrapper">
        <div class="content col-md-8 page-<?php echo $post->post_name; ?>">
            <?php while (have_posts()) : the_post();
                the_title('<h2>', '</h2>');
                the_content(); 
            endwhile;
            echo "<br />";
            ?>
            <strong><?php echo __('TITULO:','makusi'); ?></strong> <?php echo $post_values->post_title; ?><br />
            <strong><?php echo __('AUTOR:','makusi'); ?></strong> <?php echo $author_values->user_nicename; ?><br />
            <strong><?php echo __('APORTACIÓN:', 'makusi'); ?></strong> <?php echo $_POST['amount']; ?> €
            <?php if($_GET['action'] != 'wpuf_tpv_success'){ ?>
            <form name='dona' action='<?php echo $url_tpvv; ?>' method='post' target='donate'>
                <input type="hidden" name="Ds_Merchant_Amount" value='<?php echo $amount; ?>' />
                <input type="hidden" name="Ds_Merchant_Currency" value='<?php echo $currency; ?>' />
                <input type="hidden" name="Ds_Merchant_Order"  value='<?php echo $order; ?>' />
                <input type="hidden" name="Ds_Merchant_MerchantCode" value='<?php echo $code; ?>' />
                <input type="hidden" name="Ds_Merchant_Terminal" value='<?php echo $terminal; ?>' />
                <input type="hidden" name="Ds_Merchant_TransactionType" value='<?php echo $transactionType; ?>' />
                <input type="hidden" name="Ds_Merchant_MerchantURL" value='<?php echo $urlMerchant; ?>' />
                <input type="hidden" name="Ds_Merchant_UrlOK" value='<?php echo $urlMerchant; ?>' />
                <input type="hidden" name="Ds_Merchant_ProductionDescription" value="ID VIDEO:<?php echo $_REQUEST['post_id']; ?> - Autor:<?php echo $author_values->user_nicename; ?>" />
                <!--input type=hidden name="Ds_Merchant_UrlKO" value='<?php //echo $urlKo; ?>' /-->
                <?php
                    // Compute hash to sign form data
                    // $signature=sha1_hex($amount,$order,$code,$currency,$clave);
                    $message = $amount.$order.$code.$currency.$transactionType.$urlMerchant.$clave;
                    $signature = strtoupper(sha1($message));
                ?>
                <input type="hidden" name="Ds_Merchant_MerchantSignature" value='<?php echo $signature; ?>' />
                 <center>
                    <a class="paymentButton" href='javascript:calc()'>
                        <?php echo __('Acceder a la pasarela de pago','makusi'); ?>
                        <!--img src='/tpvirtual.jpg' border=0 ALT='TPV Virtual'-->
                    </a>
                </center>
            </form>
            <?php } else{ ?>
                <p><strong><?php echo __('Tu pago ha sido correcto. Muchas Gracias.','makusi'); ?></strong></p>
                <p><strong><?php echo __('ID de la Transacci&oacute;n','makusi'); ?></strong> :  <?php echo $_REQUEST['Ds_Order']; ?><br />
                <strong><?php echo __('Pago','makusi'); ?></strong>: <?php echo $Amount = $_REQUEST['Ds_Amount']/100 ?> &euro;<br />
                <strong><?php echo __('ID del Post','makusi'); ?></strong>:  <?php echo $_REQUEST['post_id']; ?><br />
                <strong><?php echo __('Fecha','makusi'); ?></strong>:  <?php echo $_REQUEST['Ds_Date']; ?><br />
                <strong><?php echo __('Time','makusi'); ?></strong>:  <?php echo $_REQUEST['Ds_Hour']; ?></p>
            <?php }  ?>
        </div>
        <aside class="col-md-4">
            <!-- Search Form -->
            <form action="<?php echo home_url( '/' ); ?>" method="get">
                <input type="text" name="s" class="searchvideo" placeholder="<?php echo __('Search Videos...','makusi'); ?>" />
            </form>
            <div class="clr"></div>
            <br /><br />
            <!-- End Search Form -->
            <?php 
                if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('home-right')) :
                endif;
            ?>
            <?php //get_sidebar(); ?>
        </aside>
        <div class="clear"></div>
    </div>
<?php get_footer(); ?>




