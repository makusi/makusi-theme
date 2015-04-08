<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// 1. Register donations' fields for a registered user who has bought a packet.
add_action('show_user_profile', 'UserDonation_add');
add_action('edit_user_profile', 'UserDonation_add');
add_action('edit_user_profile_update', 'UserDonation_update'); 
add_action('personal_options_update', 'UserDonation_update');

function UserDonation_add($user){ 
    $user_id = $user->ID;
    $bank_account_number = get_user_meta($user_id, "user_account_number",true);
    $country = get_user_meta($user_id, "user_account_country", true);
    $bic = get_user_meta($user_id, "user_account_bic", true); ?>
    <h3>Donation Fields</h3>
    <table class="form-table">
        <tr>
            <th><label for="user_account_number">Account Number</label></th>
            <td><input type="text" name="user_account_number" class="regular-text" value="<?php echo $bank_account_number; ?>" />
            <br />
            <span class="description">><?php echo __('Enter your Bank account here.','makusi'); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="user_bank_country">Country</label></th>
            <td><select name="user_bank_country">
                    <option value="ES" <?php if($country=="ES") echo "selected";?>>España</option>
                    <option value="FR" <?php if($country=="FR") echo "selected";?>>Francia</option>
                </select>
                <br />
            <span class="description">><?php echo __('Enter your country here.','makusi'); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="user_bank_bic">Bic</label></th>
            <td><input type="text" name="user_bank_bic" class="regular-text" value="<?php echo $bic; ?>" />
            <br />
            <span class="description">><?php echo __('Enter your bic here.','makusi'); ?></span>
            </td>
        </tr>
    </table>
    <?php
}
function UserDonation_update($user_id){
    update_user_meta($user_id, "user_bank_account_number",$_POST['user_account_number']);
    update_user_meta($user_id, "user_bank_country",$_POST['user_bank_country']);
    update_user_meta($user_id, "user_bank_bic",$_POST['user_bank_bic']);
}

// 2. Receive data from the user´s donation-recieve field.



// 3. Allow users who purchase a packet to add their bank account data.
// 4. Activate in admin area a section for statistics.

