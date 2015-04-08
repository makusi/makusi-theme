<?php 
/**
 * Template Name: TPV Page
 *
 * Allow users to update their profiles from Frontend.
 *
 */
// Posted data

// Valores constantes del comercio
$url_tpvv = 'https://sis.redsys.es/sis/realizarPago';
$clave = 'baw85h1f2aB3Qrqw935a';
$name = 'ANAFI SOC COOP MAKUSI.TV';
$code = '058077918';
$terminal = '1';
$order = date('ymdHis');
$amount = $_REQUEST['amount']*121;
$currency = '978';
$transactionType='0';
$urlMerchant = add_query_arg( array('action'=> 'wpuf_tpv_success','pack_id'=>$_REQUEST['pack_id']), home_url( '/tpv' ) );
//$urlOk = home_url('/ok');
//$urlKo = home_url('/ko');
$producto='';

get_header(); ?>
    <script language=JavaScript>
    function calc() { 
        vent=window.open('','tpv','width=725,height=600,scrollbars=no,resizable=yes,status=yes,menubar=no,location=no');
        document.forms[0].submit();
    }
    </script>
    <div class="single-wrapper">
        <div class="content col-md-8 page-<?php echo $post->post_name; ?>">
            <?php while (have_posts()) : the_post();
                the_title('<h2>', '</h2>');
                the_content(); 
            endwhile; ?>
            <?php if($_GET['action'] != 'wpuf_tpv_success'){ ?>
                <form name='compra' action='<?php echo $url_tpvv; ?>' method='post' target='tpv'>
                <p><strong><?php echo __('PRECIO','makusi'); ?>:</strong> <?php echo $_REQUEST['amount']; ?> &euro;<br />
                <strong><?php echo __('IVA','makusi'); ?>:</strong> <?php echo $_REQUEST['amount']*0.21; ?> &euro;<br />
                <strong><?php echo __('Precio (IVA incl.)','makusi'); ?>:</strong> <?php echo $_REQUEST['amount']*1.21; ?> &euro;<br />
                <strong><?php echo __('Nombre del Paquete','makusi'); ?>:</strong> <?php echo $_REQUEST['item_name']; ?></p>
                <h4><?php echo __('Datos de Facturación','makusi'); ?></h4>
                <p><strong><?php echo __('CIF/DNI','makusi'); ?>:</strong> <input type="text" name="cif" /></p>
                <p><strong><?php echo __('Dirección','makusi'); ?>:</strong> <input type="text" name="address" /></p>
                <p><strong><?php echo __('Código Postal','makusi'); ?>:</strong> <input type="text" name="postcode"  /></p>
                <p><strong><?php echo __('Ciudad','makusi'); ?>:</strong> <input type="text" name="ciudad" /></p>
                <p><strong><?php echo __('Area','makusi'); ?>:</strong> <input type="text" name="area" /></p>
                <p><strong><?php echo __('País','makusi'); ?>:</strong> <input type="text" name="pais" /></p>
                
                <input type="hidden" name="Ds_Merchant_Amount" value='<?php echo $amount; ?>' />
                <input type="hidden" name="Ds_Merchant_Currency" value='<?php echo $currency; ?>' />
                <input type="hidden" name="Ds_Merchant_Order"  value='<?php echo $order; ?>' />
                <input type="hidden" name="Ds_Merchant_MerchantCode" value='<?php echo $code; ?>' />
                <input type="hidden" name="Ds_Merchant_Terminal" value='<?php echo $terminal; ?>' />
                <input type="hidden" name="Ds_Merchant_TransactionType" value='<?php echo $transactionType; ?>' />
                <input type="hidden" name="Ds_Merchant_MerchantURL" value='<?php echo $urlMerchant; ?>' />
                <input type="hidden" name="Ds_Merchant_UrlOK" value='<?php echo $urlMerchant; ?>' />
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
                    </a>
                </center>
                </form>
            <?php } else{ ?>
                <p><strong><?php echo __('Tu pago ha sido correcto. Muchas Gracias.','makusi'); ?></strong></p>
                <p><strong><?php echo __('ID de la Transacci&oacute;n','makusi'); ?></strong> :  <?php echo $_REQUEST['Ds_Order']; ?><br />
                <strong><?php echo __('Pago','makusi'); ?></strong>: <?php echo $Amount = $_REQUEST['Ds_Amount']/100 ?> &euro;<br />
                <strong><?php echo __('ID del Paquete','makusi'); ?></strong>:  <?php echo $_REQUEST['pack_id']; ?><br />
                <strong><?php echo __('Fecha','makusi'); ?></strong>:  <?php echo $_REQUEST['Ds_Date']; ?><br />
                <strong><?php echo __('Time','makusi'); ?></strong>:  <?php echo $_REQUEST['Ds_Hour']; ?></p>
            <?php }  ?>
        </div>
        <?php if($_GET['action'] != 'wpuf_tpv_success'){ ?>
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
        <?php } ?>
        <div class="clear"></div>
    </div>
<?php get_footer(); ?>
