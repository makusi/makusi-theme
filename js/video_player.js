jQuery(window).load(function($){
    vid = jQuery("#video").get(0);
    var durmins = Math.floor(vid.duration / 60);
    var dursecs = Math.round(vid.duration - durmins * 60);
    if(dursecs < 10){ dursecs = "0"+dursecs;}
    if(durmins < 10){ durmins = "0"+durmins;}
    jQuery("#durtimetext").html(durmins+":"+dursecs);
    
    jQuery("#playpausebtn").click(function(){
        console.log(jQuery("#video").get(0));
        if(jQuery('#video').get(0).paused){
            jQuery("#playpausebtn").empty().append("<i class='fa fa-pause'></i>");
            jQuery('#video').get(0).play();	
        } else {
            jQuery("#playpausebtn").empty().append("<i class='fa fa-play'></i>");
            jQuery('#video').get(0).pause();
        }
    });
    
    jQuery("#seekslider").change(function(){
        jQuery("#video").get(0).currentTime = jQuery("#video").get(0).duration * (jQuery(this).val() /100 );
    });
    
    jQuery("#video").bind('timeupdate', function(){
        var vid = jQuery(this).get(0);
        var nt =  vid.currentTime * (100 / vid.duration);
	seekslider.value = nt;
	var curmins = Math.floor(vid.currentTime/60);
	var cursecs = Math.floor(vid.currentTime - curmins*60);
	var durmins = Math.floor(vid.duration / 60);
	var dursecs = Math.round(vid.duration - durmins * 60);
	if(cursecs < 10){ cursecs = "0"+cursecs;}
	if(dursecs < 10){ dursecs = "0"+dursecs;}
	if(curmins < 10){ curmins = "0"+curmins;}
	if(durmins < 10){ durmins = "0"+durmins;}
			
	jQuery("#curtimetext").html(curmins+":"+cursecs);
	jQuery("#durtimetext").html(durmins+":"+dursecs);
    });
    
    jQuery("#mutebtn").click(function(){
        var vid = jQuery("#video").get(0);
        if(vid.muted){
            vid.muted = false;
            jQuery(this).empty().append("<i class='fa fa-volume-up'></i>");
            vid.volume = 1;
        } else {
            vid.muted = true;
            jQuery(this).empty().append("<i class='fa fa-volume-off'></i>");
            vid.volume = 0;
        }
    });
    jQuery("#volumeslider").change(function(){
        jQuery("#video").get(0).volume = jQuery(this).val() / 100;
    });
    
    jQuery("#fullscreenbtn").bind("click",function(e){
        // var vid = jQuery("#video").get(0);
        var vid = document.getElementById('video');
		var fs=jQuery('#video_controls_bar').hasClass('fullscreenControls');
		if(fs==false){
			if(vid.requestFullScreen){
				vid.requestFullScreen();
			} else if(vid.webkitRequestFullScreen){
				vid.webkitRequestFullScreen();
			} else if(vid.mozRequestFullScreen){
				vid.mozRequestFullScreen();
			} else if(vid.msRequestFullscreen) {
				vid.msRequestFullscreen();
			}
		}else{
			if(document.exitFullscreen) {
				document.exitFullscreen();
			} else if(document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
			} else if(document.webkitExitFullscreen) {
				document.webkitExitFullscreen();
			}
		}
    });
	
	jQuery(document).on("fullscreenchange", function(){
		jQuery('#video_controls_bar').toggleClass('fullscreenControls');
	});
	jQuery(document).on("mozfullscreenchange", function(){
		jQuery('#video_controls_bar').toggleClass('fullscreenControls');
	});
	jQuery(document).on("webkitfullscreenchange", function(){
		jQuery('#video_controls_bar').toggleClass('fullscreenControls');
	});
	jQuery(document).on("msfullscreenchange", function(){
		jQuery('#video_controls_bar').toggleClass('fullscreenControls');
	});
    
    jQuery("#video-container").hover(function(){
        jQuery("#video_controls_bar").fadeIn('slow');
    },function(){
        jQuery("#video_controls_bar").fadeOut('slow');
    });
    
    jQuery(vid).click(function(){
        jQuery(this).play();
    });
    jQuery(vid).on('progress',function(){
        progress = (this.buffered.end(0)/this.duration)*100;
        jQuery('#loadbar').css('display','block');
        jQuery('#loadprogressbar').css('width', progress+'%');
        if(progress==100){
            jQuery('#loadbar').css('display','none');
        }
    });
    /*jQuery(vid).on('timeupdate',function(){
        progress = (this.currentTime/this.duration)*100;
        /*jQuery('#loadbar').css('display','block');
        
        jQuery('#loadprogressbar').css('width', progress+'%');
        console.log(progress);
    });*/
});

