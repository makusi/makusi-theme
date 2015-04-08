jQuery(document).ready(function($) { 
    $('.open-categories').click(function(){
		$('.category-side').show().animate({
			width:"200px"
		}, 2000)
	}); 
	$('.open-user').click(function(){
		$('.user-side').show().animate({
			width:"200px"
		}, 2000)
	});  
	$('.close-side').click(function(){
		$('.sliding-side').hide();
	}); 
    
    $('.language-area ul li.active a').toggle(function(event){
        event.preventDefault();
        $(this).parent().parent().children().show();
    }, function(e){
        event.preventDefault();
        $(this).parent().parent().children().css('display','none');
        $(this).parent().css('display','block');
        //$(this).parent().parent().children().not(this).hide();
    });
    
    //http://www.masquewordpress.com/como-utilizar-ajax-correctamente-en-wordpress/
    $('#register_form').submit(function(event){
        event.preventDefault();
        jQuery.post(URL, {
            nonce : NONCE,
            action: 'process_register',
            trigger_register:$('#trigger_register').val(),
            user_login : $('input[name="user_login"]').val(),
            user_email: $('input[name="user_email"]').val(),
            first_name:$('input[name="first_name"]').val(),
            last_name:$('input[name="last_name"]').val(),
            user_pass: $('input[name="user_pass"]').val(),
            password_check: $('input[name="password_check"]').val()
        }, function(response){
            $('#register-warning').html(response);
            $(this).hide();
        });
    });
    
    $('#login_form').submit(function(event){
        event.preventDefault();
        jQuery.post(URL,{
            nonce : NONCE,
            action: 'process_login',
            rememberme: $('#rememberme').val(),
            trigger_login: $('#trigger_login').val(),
            log : $('#username').val(),
            pwd: $('#password').val()
        },function(response){
            $('#login_warning').html(response);
            window.setTimeout(function(){location.reload(true)},2000)
        });
    });
    
    $("#lost_password_link").click(function(event){
        event.preventDefault();
        $('#login_form').hide();
        $("#lost_password").show();
    });
    
    $("#lost_password").submit(function(event){
        event.preventDefault();
        jQuery.post(URL,{
            nonce : NONCE,
            action: 'process_lost_password',
            lost_email:$("#lost_email").val(),
            trigger_lost: $('#trigger_lost').val()
        }, function(response){
            $('#lost_password').html(response);
            $(this).hide();
        });
    });
    
    $("#login_link").click(function(event){
        event.preventDefault();
        $('#login_form').show();
        $("#lost_password").hide();
    });
    
    $('#show_contactsender_form').click(function(event){
        event.preventDefault();
        location.reload();
    });
    
    var sec = 3
    var timer = setInterval(function() { 
        $('.widget-register-success span').text(sec--);
        if (sec == -1) {
            /*$('.widget-register-error').fadeOut('fast');
            $('.widget-register-success').fadeOut('fast');*/
            clearInterval(timer);
        } 
    }, 1000);
    var sec2 = 3
    var timer2 = setInterval(function() { 
        $('.widget-register-error span').text(sec2--);
        if (sec2 == -1) {
            /*$('.widget-register-error').fadeOut('fast');
            $('.widget-register-success').fadeOut('fast');*/
            clearInterval(timer2);
        } 
    }, 1000);
});