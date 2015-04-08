<?php  
/* 
Template Name: Custom WordPress Registration 
*/

require_once(ABSPATH . WPINC . '/registration.php');  
global $wpdb, $user_ID;  
if (!$user_ID) {  
       if($_POST){  
            //We shall SQL escape all inputs  
            $username = $wpdb->escape($_REQUEST['username']);  
            if(empty($username)) {  
                echo "User name should not be empty.";  
                exit();  
            }  
            $email = $wpdb->escape($_REQUEST['email']);  
            if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email)) {  
                echo "Please enter a valid email.";  
                exit();  
            }  
  
            $random_password = wp_generate_password( 12, false ); 
            
            /*PAYPAL VERIFICATION*/
            // read the post from PayPal system and add 'cmd'
            $req = 'cmd=_notify-validate';
            foreach ($_POST as $key => $value) {
                $value = urlencode(stripslashes($value));
                $req .= "&$key=$value";
            }
            // post back to PayPal system to validate
            $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
            $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
 
            $fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
 
 
            if (!$fp) {
            // HTTP ERROR
            } else {
                fputs ($fp, $header . $req);
                while (!feof($fp)) {
                    $res = fgets ($fp, 1024);
                    if (strcmp ($res, "VERIFIED") == 0) {
			$valid_payment = TRUE;
                    }else if (strcmp ($res, "INVALID") == 0) {
			// PAYMENT INVALID & INVESTIGATE MANUALY!
                        $valid_payment = FALSE;
                    }
                }
                fclose ($fp);
            }
            if ($valid_payment == TRUE) {
                $status = wp_create_user( $username, $random_password, $email );  
                if ( is_wp_error($status) )  
                    echo "Username already exists. Please try another one.";  
                else {  
                    $from = get_option('admin_email');  
                    $headers = 'From: '.$from . "\r\n";  
                    $subject = "Registration successful";  
                    $msg = "Registration successful.\nYour login details\nUsername: $username\nPassword: $random_password";  
                    wp_mail( $email, $subject, $msg, $headers );  
                    echo "Please check your email for login details.";  
                }
                exit();
            } else {
                echo "Your payment has not been properly executed.";
            }
              
        } else { 
            get_header(); ?>
            
        <?php    if(get_option('users_can_register')) {  
            //Check whether user registration is enabled by the administrator  
        ?>  
                    <h1><?php the_title(); ?></h1>  
                    <div id="result"></div> <!-- To hold validation results -->  
                    <form id="wp_signup_form">  
                        <label>Username</label>  
                        <input type="text" name="username" class="text form-control" value="" /><br />  
                        <label>Email address</label>  
                        <input type="text" name="email" class="text form-control" value="" /> <br />  
                        <label>Payment</label>
                        <select  class="form-control" id="ammount_charge" name="payment">
                            <option value="Select">Select Account</option>
                            <option value="30">30 &euro;</option>
                            <option value="50">50 &euro;</option>
                            <option value="100">100 &euro;</option>
                            <option value="200">200 &euro;</option>
                        </select><br />  
                        <div id="ammount_charge_container"></div>
                        <input type="submit" id="submitbtn" name="submit" class="btn btn-default" value="SignUp" />  <br /><br />
                    </form>  
      
                    <script type="text/javascript">  
                    //<![CDATA[ 
                        jQuery('#ammount_charge').change(function(){
                            alert("Ammount Was Changed");
                            jQuery('#wp_signup_form').attr('action','POST').attr('method','https://www.sandbox.paypal.com/cgi-bin/webscr');
                            var htmlContent='';
                            htmlContent += 'You have selected ';
                            htmlContent += jQuery(this).val();
                            htmlContent += 'Euros<br />';
                            htmlContent += 'Please submit your payment <a href="#" target="_blank">here</a>';
                            htmlContent += '<img src="https://www.paypal.com/es_XC/i/btn/btn_xpressCheckout.gif" align="left" style="margin-right:7px;">.<br />';
                            htmlContent += '<input type="text" class="text form-control" name="first_name" placeholder="First Name" value="" /><br />';
                            htmlContent += '<input type="text" class="text form-control" name="last_name" placeholder="Last Name" value="" /><br />';
                            htmlContent += '<input type="text" class="text form-control" name="email" placeholder="Email" value="" /><br />';
                            htmlContent += '<input type="text" class="text form-control" name="address1" placeholder="Address" value="" /><br />';
                            htmlContent += '<input type="text" class="text form-control" name="address2" placeholder="Address 2" value="" /><br />';
                            htmlContent += '<input type="text" class="text form-control" name="city" placeholder="City" value="" /><br />';
                            htmlContent += '<input type="text" class="text form-control" name="zip" placeholder="Zip" value="" /><br />';
                            htmlContent += '<input type="text" class="text form-control" name="day_phone_a" placeholder="Home Phone" value="" /><br />';
                            htmlContent += '<input type="text" class="text form-control" name="day_phone_b" placeholder="Mobile Phone" value="" /><br />';
                            htmlContent += '<input type="hidden" name="cmd" value="_xclick" />';
                            htmlContent += '<input type="hidden" name="business" value="paypal@email.com" />';
                            htmlContent += '<input type="hidden" name="cbt" value="Return to Your Business Name" />';
                            htmlContent += '<input type="hidden" name="currency_code" value="EUR" />';
                            htmlContent += '<input type="hidden" name="quantity" value="1" />';
                            htmlContent += '<input type="hidden" name="item_name" value="Name of Item" />';
                            htmlContent += '<input type="hidden" name="custom" value="<?php echo session_id(); ?>" />';
                            htmlContent += '<input type="hidden" name="shipping" value="0" />';
                            /*htmlContent += '<input type="hidden" name="invoice" value="<?php //echo $invoice_id ?>" />';
                            htmlContent += '<input type="hidden" name="amount" value="<?php //echo $total_order_price; ?>" />';*/
                            htmlContent += '<input type="hidden" name="return" value="http://<?php echo $_SERVER['SERVER_NAME']?>/register"/>';
                            htmlContent += '<input type="hidden" name="cancel_return" value="http://<?php echo $_SERVER['SERVER_NAME']?>/cancelled" />';
                            htmlContent += '<input type="hidden" name="notify_url" value="http://<?php echo $_SERVER['SERVER_NAME']?>/register" />';
                            htmlContent += '<div class="clearfix"></div>';
                            
                            jQuery('#ammount_charge_container').html(htmlContent);
                            jQuery("#submitbtn").show('slow');
                        });
                        jQuery("#submitbtn").click(function($) { 
                            jQuery('#result').html('<img src="<?php bloginfo('template_url') ?>/images/loader.png" class="loader" />').fadeIn(); 
                            var input_data = jQuery('#wp_signup_form').serialize(); 
                            console.log(input_data);
                            jQuery.ajax({ 
                                type: "POST", 
                                url:  "", 
                                data: input_data, 
                                success: function(msg){ 
                                    jQuery('.loader').remove(); 
                                    jQuery('<div class="text-warning">').html(msg).appendTo('div#result').hide().fadeIn('slow'); 
                                } 
                            }); 
                            return false;
                        }); 
                    //]]>  
                    </script>  
                <?php  
                    } else 
                        echo "Registration is currently disabled. Please try again later.";
                ?>
        </div>  
    </div>  
<?php
    get_footer();  
            } //end of if($_post)
        }  else {  
    wp_redirect( home_url() ); exit;  
}  

?>  

