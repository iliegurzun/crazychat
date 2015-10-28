$(function() {
    if ($('.profile-picture').length) {
        setProfilePicture($('.profile-picture'));
    }
});
$(window).load(function() {
    if ($('.carousel').length) {
        $('.carousel').carousel();
    }
});

var setProfilePicture = function($link)
{
    $link.on('click', function(e) {
        var $theLink = $(this);
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        $.ajax({
            url: $theLink.attr('href'),
            type: 'POST'
        }).done(function(data) {
            if(data.success == true) {
                $('.profile-picture.active').removeClass('active');
                $theLink.addClass('active');
            }
        });
    });
}