$(function() {
    
    $('#main-menu').find('li').mouseover(function() {
       var $elem =  $(this);
       
       if($elem.find('ol').length) {
           $elem.find('ol').show();
       }
    }).mouseleave(function() {
        if($(this).find('ol').length) {
            $(this).find('ol').hide();
        }
    })
    
});
$(window).load(function() {
    if ($('.carousel').length) {
        $('.carousel').carousel();
    }
});