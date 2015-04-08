jQuery(document).ready(function($) { 
    
   // $('.jcarousel').jcarousel({
        // Configuration goes here
       // vertical: true
    //});
    $('#tab-container').easytabs();
    $('.radio input').click(function(){
        $(this).attr('checked','checked');
    });
    $('.radio_dimensions').click(function(){
        var content = $('#embed_code').val();
        var index = content.indexOf('src');
        var begin = index + 5;
        var contentLength = content.length;
        var finish = contentLength - begin - 11;
        var url = content.substr(begin,finish);
        
        if($(this).val() == "small"){
            $('#embed_code').val('<iframe width="200" height="120" frameborder="0" src="'+url+'"></iframe>');
        }
        if($(this).val() == "medium"){
            $('#embed_code').val('<iframe width="320" height="240" frameborder="0" src="'+url+'"></iframe>');
        }
        if($(this).val() == "large"){
            $('#embed_code').val('<iframe width="640" height="480" frameborder="0" src="'+url+'"></iframe>');
        }
    });
    
    $('.open-user-window').click(function(){
       $('.user-area').slideDown("slow", function(){
            $( this ).css( "height", "420px" );
            $('.open-user-window').hide('slow',function(){
                $('.close-user-window').show('slow');
            });
            
       }); 
    });
    $('.close-user-window').click(function(){
       $('.user-area').animate("slow", function(){
            $( this ).css( "height", "60px" );
            $('.close-user-window').hide('slow',function(){
                $('.open-user-window').show('slow');
            });
       }); 
    });
    $('.etabs > .tab > a').click(function(){
        $('.user-area').slideDown("slow", function(){
            $( this ).css( "height", "420px" );
            $( this ).css( "top", "0px" );
            $( this ).css( "right", "0px" );
       }); 
    });
    
    $('.language-area ul li.active a').toggle(function(event){
        event.preventDefault();
        $(this).parent().parent().children().show();
    }, function(event){
        event.preventDefault();
        $(this).parent().parent().children().css('display','none');
        $(this).parent().css('display','block');
        //$(this).parent().parent().children().not(this).hide();
    });
    
    //var $container = $('#container');
// initialize
    $('.masonry_container').masonry({
        columnWidth: 0, 
        itemSelector: '.col-md-3'
    });

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
    
    $('a#close-invite').click(function(event){
        event.preventDefault();
        $('.invite-container').slideUp('1000',function(){
            /*$('a#open-invite').show();*/  
        });
        $('.register-link-container').show();
    });
    
    $('a#open-invite').click(function(event){
        event.preventDefault();
        $('.invite-container').slideDown('1000', function(){
            $('a#open-invite').hide();
        });
    });
    
    $('a.register-link').click(function(event){
        event.preventDefault();
        $('.invite-container').removeClass('hide').slideDown('1000');
        $('.register-link-container').css('background-color','#6EA9C5');
        $('.login-link-container').css('background-color','#52849B');
        $('#invite-login').fadeOut('slow', function(){
                $('#invite-subscriptions').fadeOut('slow', function(){
                    $('#invite-register').show();
                });
            });
        /*$('#invite-register').fadeIn('slow', function(){
            
        });*/
        $('.register-link-container a').css('border-right','#6EA9C5');
        $('#wizzard-login').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-register').addClass('wizzard-active'); 
        $('#wizzard-subscription').removeClass('wizzard-active').addClass('wizzard-block'); 
    });
    
    $('a.login-link').click(function(event){
        event.preventDefault();
        $('#invite-register').fadeOut('slow', function(){
            $('#invite-subscriptions').fadeOut('slow', function(){
                $('#invite-login').show();
            });
        });
        
        $('.invite-container').removeClass('hide').slideDown('1000');
        $('.register-link-container').css('background-color','#52849B');
        $('.login-link-container').css('background-color','#6EA9C5');
        $('.register-link-container a').css('border-right','#6EA9C5');
        $('#wizzard-register').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-subscription').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-login').addClass('wizzard-active'); 
    });
    $('#change-to-subscription').click(function(event){
        $('#invite-register').fadeOut('slow', function(){
            $('#invite-subscriptions').fadeIn('slow');
        });
        $('#wizzard-register').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-subscription').addClass('wizzard-active'); 
    });
    $('#change-to-security').click(function(event){
        $('#invite-subscriptions').fadeOut('slow', function(){
            $('#invite-security').fadeIn('slow');
        });
        $('#wizzard-register').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-subscription').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-security').addClass('wizzard-active'); 
    });
    $('#change-back-to-subscriptions').click(function(event){
        $('#invite-security').fadeOut('slow', function(){
            $('#invite-subscriptions').fadeIn('slow');
        });
        $('#wizzard-register').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-security').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-subscription').addClass('wizzard-active'); 
    });
    
    $('#change-to-register').click(function(event){
        $('#invite-subscriptions').fadeOut('slow', function(){
            $('#invite-register').fadeIn('slow');
        });
        $('#register-warning').empty();
        $('#wizzard-subscription').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-security').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-register').addClass('wizzard-active'); 
    });
    
    $('.lateral-login-link').click(function(event){
        event.preventDefault();
        $('.invite-block').css('height','0px');
        $('#invite-register').fadeOut('slow', function(){
            $('#invite-subscriptions').fadeOut('slow', function(){
                $('#invite-security').fadeOut('slow', function(){
                    $('#invite-login').show();
                    //$('.invite-block').css('height','400px');
                });
            });
        });
        
        $('.register-link-container').css('background-color','#52849B');
        $('.login-link-container').css('background-color','#6EA9C5');
        $('#wizzard-register').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-subscription').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-security').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-login').addClass('wizzard-active'); 
    });
    $('.lateral-subscription-link').click(function(event){
        event.preventDefault();
        $('#invite-login').fadeOut('slow', function(){
            $('#invite-register').fadeOut('slow', function(){
                $('#invite-security').fadeOut('slow',function(){
                    $('#invite-subscriptions').show();
                });
            });
        });
        
        $('.register-link-container').css('background-color','#52849B');
        $('.login-link-container').css('background-color','#6EA9C5');
        $('#wizzard-login').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-register').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-security').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-subscription').addClass('wizzard-active'); 
    });
    $('.lateral-register-link').click(function(event){
        event.preventDefault();
        $('#invite-login').fadeOut('slow', function(){
             $('#invite-security').fadeOut('slow', function(){
                $('#invite-subscriptions').fadeOut('slow', function(){
                    $('#invite-register').show();
                });
            });
        });
        $('.subscription-link-container').css('background-color','#52849B');
        $('.login-link-container').css('background-color','#6EA9C5');
        $('#wizzard-login').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-subscription').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-security').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-register').addClass('wizzard-active'); 
    });
    
    $('.lateral-security-link').click(function(event){
        event.preventDefault();
        $('#invite-register').fadeOut('slow', function(){
            $('#invite-login').fadeOut('slow', function(){
                $('#invite-subscriptions').fadeOut('slow', function(){
                    $('#invite-security').show();
                });
            });
        });
        $('.subscription-link-container').css('background-color','#52849B');
        $('.login-link-container').css('background-color','#6EA9C5');
        $('#wizzard-login').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-subscription').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-register').removeClass('wizzard-active').addClass('wizzard-block'); 
        $('#wizzard-security').addClass('wizzard-active'); 
    });
    
    //http://www.masquewordpress.com/como-utilizar-ajax-correctamente-en-wordpress/
    $('#register-form').submit(function(event){
        event.preventDefault();
        jQuery.post(MyAjax.url, {
            nonce : MyAjax.nonce,
            action: 'process_register',
            trigger_register:$('#trigger_register').val(),
            user_login : $('input[name="user_login"]').val(),
            user_email: $('input[name="user_email"]').val(),
            first_name:$('input[name="first_name"]').val(),
            last_name:$('input[name="last_name"]').val(),
            user_pass: $('input[name="user_pass"]').val(),
            password_check: $('input[name="password_check"]').val(),
            package: $('input[name="package"]:checked').val(),
            recaptcha_response_field: $('input[name="recaptcha_response_field"]').val(),
            recaptcha_challenge_field: $('input[name="recaptcha_challenge_field"]').val()
        }, function(response){
            $(this).hide();
            $('#register-warning').html(response);
            $('.widget-register-error').prepend('<a href="#" id="close-error-warning"><i class="fa fa-close"></i></a>');
            $('#close-error-warning').click(function(){
                $('.widget-register-error').fadeOut('800');
            });
            var n = response.search("widget-register-error");
            if(n ==-1){
                $('#invite-register').fadeOut('slow');
                $('#invite-subscriptions').fadeOut('slow');
                $('#invite-security').delay('3000').fadeOut('slow',function(){
                    $('#invite-login').fadeIn('slow');
                });
                $('#wizzard-subscription').removeClass('wizzard-active').addClass('wizzard-block');
                $('#wizzard-security').removeClass('wizzard-active').addClass('wizzard-block');
                $('#wizzard-login').addClass('wizzard-active'); 
            }   
        });
    });
    
    $('#loginform').submit(function(event){
        event.preventDefault();
        jQuery.post(LoginAjax.url,{
            nonce : LoginAjax.nonce,
            action: 'process_login',
            remember: $('#rememberme').val(),
            trigger_login: $('#trigger_login').val(),
            log : $('input[name="log"]').val(),
            pwd: $('input[name="pwd"]').val()
        },function(response){
            $('#loginform').hide();
            $('#login_warning').html(response);
            window.setTimeout(function(){location.reload(true)},3000)
        });
    });
    
    $("#lost_password_link").click(function(event){
        event.preventDefault();
        $('#login_form').hide();
        $("#lost_password").show();
    });
    
    $("#lost_password").submit(function(event){
        event.preventDefault();
        jQuery.post(LostPassword.url,{
            nonce : LostPassword.nonce,
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
    
    $('#contact-sender').submit(function(event){
         event.preventDefault();
         jQuery.post(ContactSender.url,{
             nonce : ContactSender.nonce,
             action: 'contact_sender',
             contactsendername: $('#contact-sender-name').val(),
             contactsenderemail: $('#contact-sender-email').val(),
             contactsenderid: $('#contact-sender-id').val(),
             contactsendermessage: $('#contact-sender-message').val(),
             contactsenderuseremail:$('#contact-sender-useremail').val()
         },function(response){
             $(this).hide();
             $("#section-4").html(response);
         }); 
    });
    
    
    /*OVERLAY*/
    
    if (Modernizr.touch) {
        // show the close overlay button
        $(".close-overlay").removeClass("hidden");
        // handle the adding of hover class when clicked
        $(".image-holder").click(function(e){
            if (!$(this).hasClass("hover")) {
                $(this).addClass("hover");
            }
        });
        // handle the closing of the overlay
        $(".close-overlay").click(function(e){
            e.preventDefault();
            e.stopPropagation();
            if ($(this).closest(".img").hasClass("hover")) {
                $(this).closest(".img").removeClass("hover");
            }
        });
    } else {
        // handle the mouseenter functionality
        $(".image-holder").mouseenter(function(){
            $(this).addClass("hover");
        })
        // handle the mouseleave functionality
        .mouseleave(function(){
            $(this).removeClass("hover");
        });
   }
    
    $( "#gravatar-dialog" ).dialog({
           autoOpen: false,
           show: {
                   effect: "blind",
                   duration: 1000
          },
          hide: {
                  effect: "explode",
                  duration: 1000
         },
         dialogClass:'makusi_dialog'
    });
    $('#open-gravatar-dialog').click(function() {
       $('#gravatar-dialog').dialog("open");
    });
    $( "#gravatar-dialog2" ).dialog({
           autoOpen: false,
           show: {
                   effect: "blind",
                   duration: 1000
          },
          hide: {
                  effect: "explode",
                  duration: 1000
         },
         dialogClass:'makusi_dialog'
    });
    $('#open-gravatar-dialog2').click(function(e) {
        e.preventDefault();
       $('#gravatar-dialog2').dialog("open");
    });
    
    
    /* #remove_account_dialog */
    $("#remove_account_dialog").dialog({
      autoOpen: false,
      modal: true,
      show: { effect: "fadeIn", duration: 800 },
      dialogClass:'makusi_dialog'
    });
    /* #remove_account */
    $("#remove_account").click(function(e) {
        e.preventDefault();
        var targetUrl = $(this).attr("href");
        $("#remove_account_dialog").dialog({
            buttons : {
                "Confirm" : function() {
                    window.location.href = targetUrl;
                },
                "Cancel" : function() {
                    $(this).dialog("close");
                }
            },
            dialogClass:'makusi_dialog'
        });
        
    $("#remove_account_dialog").dialog("open");
  });
  $( "#subscription-dialog2" ).dialog({
        autoOpen: false,
        show: {
            effect: "blind",
            duration: 1000
        },
        hide: {
            effect: "explode",
            duration: 1000
        }
    });
    $('#open-subscription-dialog2').click(function(e){
        e.preventDefault();
        $('#subscription-dialog2').dialog("open");
    });
    
    $('.creative_commons_license .wpuf-fields label').each(
        function(index){
            //console.log($(this).html().indexOf('[CC BY]'));
            if($(this).html().indexOf('[CC BY]') !== -1){
                $(this).append(' <span class="cc">cb</a>');
            }
            if($(this).html().indexOf('[CC BY-NC]') !== -1){
                $(this).append(' <span class="cc">cbn</a>');
            }
            if($(this).html().indexOf('[CC BY-ND]') !== -1){
                $(this).append(' <span class="cc">cbd</a>');
            }
            if($(this).html().indexOf('[CC BY-NC-ND]') !== -1){
                $(this).append(' <span class="cc">cbnd</a>');
            }
            if($(this).html().indexOf('[CC BY-NC-SA]') !== -1){
                $(this).append(' <span class="cc">cban</a>');
            }
            if($(this).html().indexOf('[CC BY-SA]') !== -1){
                $(this).append(' <span class="cc">cba</a>');
            }
        });
        
        $('.wpuf-form .privacy_settings input').click(function(){
            if($(this).val() =='Oculto' || $(this).val() =='Ocult' || $(this).val() =='Ezkutatuta' || $(this).val() =='Hidden' || $(this).val() =='Caché'){
                $('.wpuf-form .password').show('slow');
            } else {
                $('.wpuf-form .password').hide('slow');
            }
        });
        
        $('#activate_international').toggle(function(){
            $('#international_wrapper').fadeIn('slow');
        }, function(){
            $('#international_wrapper').fadeOut('slow');
        });
});

function T(a,c,e){
    d=60;
    s=["sec","min","hrs"];
    return t=[a,(0|a/d)*d,(0|a/d/d)*d*d].map(
            function(a,b,f){
                p=(a-(0|f[b+1]))/Math.pow(d,b);
                return e&&1>b?"":c&&!p?"":p+s[b]+". "
            }).reverse().join("");
        }
        
/*Shadowbox.init({
    handleOversize: "drag",
    modal: true
});*/