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
    if ($('.remove-comment').length) {
        removeComment($('.remove-comment'));
    }
    if (typeof getTokenUrl !=='undefined') {
        getVideoToken();
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

var removeComment = function($item)
{
    $item.on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        var $theBtn = $(this);
        if (confirm($theBtn.data('confirm-message'))) {
            $.ajax({
                url: $theBtn.data('remove-link'),
                type: 'POST'
            }).done(function(data)
            {
                if(data.success == true) {
                    $theBtn.parent().parent().fadeOut();
                    if (typeof updateChat !== 'undefined') {
                        updateChat();
                    }
                }
            });
        }
    });
}

var getVideoToken = function ()
{
    if (typeof block == 'undefined') {
        if (this.timer)
            clearTimeout(this.timer);
        $.ajax({
            url: getTokenUrl
        }).done(function(data)
        {
            if (typeof data.token !=='undefined') {
                var cookieExists = getCookie(data.token);
                if (cookieExists == '') {
                    document.cookie=data.token+'='+data.token;
                    if (confirm('User '+data.user + ' is trying to call you. Accept call?')) {
                        window.location.href = data.token;
                    }
                }
            }
        });
        this.timer = setTimeout('getVideoToken()', 10000);
    }
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}