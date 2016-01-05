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
        thumbItem: 4,
        slideMargin: 0,
        speed: 500,
        auto: false,
        loop: true,
        onSliderLoad: function () {
//            $('.secondary-photos').removeClass('cS-hidden');
        },
        onBeforePrevSlide: function(data) {
            console.log(data);
        }
        
    });
    $('.jqtransform').jqTransform({});
    if ($('.confirm-action').length) {
        confirmAction($('.confirm-action'));
    }
    if ($('.link-click').length) {
        $('.link-click').on('click', function(e) {
            if (typeof $(this).data('href') !== 'undefined') {
                window.location.href = $(this).data('href'); 
            }
        });
    }
    if (typeof $('.autosize') !=='undefined' && typeof autosize !=='undefined') {
        autosize($('.autosize'));
    }
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
                $('#header .header-picture').attr('src', data.src);
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

var confirmAction = function($link)
{
    $link.on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        var $theLink = $(this);
        if(confirm($theLink.data('confirm-message'))) {
            window.location.href = $theLink.attr('href');
        }
    });
}