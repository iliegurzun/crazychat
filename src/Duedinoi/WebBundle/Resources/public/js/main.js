$(function () {
    if ($('.profile-picture').length) {
        setProfilePicture($('.profile-picture'));
    }
    if ($('#send-message').length) {
        submitMessage($('#send-message'));
    }
//    $(".secondary-photos").lightSlider({
//        loop: false,
//        keyPress: true
//    });
    $('.secondary-photos').lightSlider({
        gallery: true,
        item: 1,
        thumbItem: 9,
        slideMargin: 0,
        speed: 500,
        auto: false,
        loop: true,
        onSliderLoad: function () {
            $('.secondary-photos').removeClass('cS-hidden');
        },
        onBeforePrevSlide: function(data) {
            console.log(data);
        }
        
    });
    $('.jqtransform').jqTransform({});
});
$(window).load(function () {
    if ($('.carousel').length) {
        $('.carousel').carousel();
    }
});

var setProfilePicture = function ($link)
{
    $link.on('click', function (e) {
        var $theLink = $(this);
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        $.ajax({
            url: $theLink.attr('href'),
            type: 'POST'
        }).done(function (data) {
            if (data.success == true) {
                $('.profile-picture.active').removeClass('active');
                $theLink.addClass('active');
            }
        });
    });
}

var submitMessage = function ($form)
{
    $form.on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        var $theForm = $(this);
        $.ajax({
            url: $theForm.attr('action'),
            data: $theForm.serialize(),
            type: 'POST'
        }).done(function (data) {
            if (data.success == true) {
            }
        });
    })
}