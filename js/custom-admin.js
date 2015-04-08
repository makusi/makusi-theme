jQuery(document).ready(function($) {
    $('#upload_logo_button').click(function() {
        tb_show('Upload a logo', 'media-upload.php?referer=makusi_theme_settings&type=image&TB_iframe=true&post_id=0', false);
        //window.restore_send_to_editor = window.send_to_editor;
        window.send_to_editor = function(html) {
    			var image_url = jQuery('img',html).attr('src');
    			jQuery('#logo_url').val(image_url);
    			tb_remove();
    			jQuery('#upload_logo_preview').append("<img />");
    			jQuery('#upload_logo_preview img').attr('src',image_url);
        }
        return false;
    });
    $('#upload_white_logo_button').click(function() {
        tb_show('Upload a logo', 'media-upload.php?referer=makusi_theme_settings&type=image&TB_iframe=true&post_id=0', false);
        //window.restore_send_to_editor = window.send_to_editor;
        window.send_to_editor = function(html) {
    			var image_url = jQuery('img',html).attr('src');
    			jQuery('#white_logo_url').val(image_url);
    			tb_remove();
    			jQuery('#upload_white_logo_preview').append("<img />");
    			jQuery('#upload_white_logo_preview img').attr('src',image_url);
    	  }
        return false;
    });
});

/*window.send_to_editor = function(html) {
    var image_url = jQuery('img',html).attr('src');
    var image_white_url = jQuery('#logo_white_preview',html).attr('src');
    jQuery('#logo_url').val(image_url);
    jQuery('#white_logo_url').val(image_white_url);
    tb_remove();
    jQuery('#upload_logo_preview').append("<img />");
    jQuery('#upload_logo_preview img').attr('id','logo_preview');
    jQuery('#upload_white_logo_preview').append("<img />");
    jQuery('#upload_white_logo_preview img').attr('id','logo_white_preview');
    jQuery('#upload_logo_preview img').attr('src',image_url);
    jQuery('#upload_white_logo_preview img').attr('src',image_white_url);
    //jQuery('#submit_options_form').trigger('click');
}*/