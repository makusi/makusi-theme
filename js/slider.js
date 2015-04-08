var durationtime1 = 16000000;
var fadetimedelete = 600;
var fadetimeshow = 800;
var gstop=0;
var sh=1;
var sha=1;
var myValue;
function setValue(){
    myValue = "1";
}
function getValue(){
    alert(window.myValue);
}

jQuery(document).ready(function($) {
    //$( selector ).hover( handlerIn, handlerOut )
    $('.tablink').click(
            //handlerIn
            function(e){
                e.preventDefault();
                var id = $(this).attr('id');
                for(var i=1; i<5; i++){
                    //alert('i = '+ i );
                    //alert('id = '+ id );
                    if(id != i){
                        //alert('Cycle '+i+': Not equal. We delete #tab'+i);
                        $('#tab'+i).fadeOut(fadetimedelete);
                    }else{ 
                        //alert('Cycle '+i+': EQUAL. We show #tab'+id);
                        $('#tab'+id).fadeIn(fadetimeshow);
                    }
                }
            });
    $(".screen > div:gt(0)").hide();

    setInterval(function() { 
        $('.screen > div:first')
        .fadeOut(3400)
        .next()
        .fadeIn(3400)
        .end()
        .appendTo('.screen');
    },  6000);

    

});