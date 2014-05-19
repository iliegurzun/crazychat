/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {

    labelify();
    if ($('.calendar').length > 0) {
        $('.calendar').datepicker({
            startView: 2,
            endDate: new Date(),
            format: 'dd/mm/yyyy',
            autoclose: true
        });
    }

    if ($('.jqtransform').length) {
        $('.jqtransform').jqTransform();
    }

    $('#menu-sortable').nestedSortable({
        handle: 'div',
        items: 'li',
        toleranceElement: '> div'
    });

    if ($('.update-menu').length) {
        updateMenu($('.update-menu'));
    }
    
    if($('.sidebar-handle').length) {
        toggleSidebar();
    }
    $('.main-menu > ul').find('li').on('mouseover', function() {
        $(this).addClass('active');
    }).on('mouseout', function() {
        $(this).removeClass('active');
    });
    
    
    if($('#add-menu-item').length) {
        addMenuItem($('#add-menu-item'));
    }
    
    if($('#update-form').length) {
        updateMenu($('#update-form'));
    }
    
//    if($('.tinymce').length) {
//        tinymce.init({selector:'.tinymce'});
//
//    }
    toggleMenuItemActions();
    removeMenuItem($('.icon-remove'));
    editMenuItemModal($('.icon-edit'));
});

/* labelify */
$(window).load(function() {
    labelify();
    setTimeout("$('.label-over').each(refreshLabels)", 50);
});
var refreshLabels = function() {
    if ($(this).val() != '') {
        $('label[for="' + $(this).attr('id') + '"]:not(.error)').hide();
    }
}
var labelify = function() {
    $('.label-over').each(refreshLabels).focus(function() {
        $('label[for="' + $(this)[0].id + '"]:not(.error)').hide();
    }).blur(function() {
        if ($(this).val() == '') {
            $('label[for="' + $(this)[0].id + '"]:not(.error)').show();
        }
    }).change(function() {
        if ($(this).val() != '') {
            $('label[for="' + $(this)[0].id + '"]:not(.error)').hide();
        }
    }).listenForChange();
}
/* end labelify */

var getToPreviousPage = function(object) {
    object.on('click', function() {
        history.go(-1);
    });
}

// var addElastic = function(object) {
// object.elastic({});
// }

/* for labelify */
$.fn.listenForChange = function(options) {
    settings = $.extend({
        interval: 100 // in microseconds
    }, options);

    var jquery_object = this;
    var current_focus = null;

    jquery_object.filter(":input").add(":input", jquery_object).focus(function() {
        current_focus = this;
    }).blur(function() {
        current_focus = null;
    });

    setInterval(function() {
        // allow
        jquery_object.filter(":input").add(":input", jquery_object).each(function() {
            // set data cache on element to input value if not yet set
            if ($(this).data('change_listener') == undefined) {
                $(this).data('change_listener', $(this).val());
                return;
            }
            // return if the value matches the cache
            if ($(this).data('change_listener') == $(this).val()) {
                return;
            }
            // ignore if element is in focus (since change event will fire on blur)
            if (this == current_focus) {
                return;
            }
            // if we make it here, manually fire the change event and set the new value
            $(this).trigger('change');
            $(this).data('change_listener', $(this).val());
        });
    }, settings.interval);
    return this;
};

var addDisabledClass = function()
{
    $('.disabled').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
}

var updateMenu = function($button) {
    $button.on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $.ajax({
            url: $button.data('url'),
            data: {
                menu: $('#iog_adminbundle_menu_name').val(),
                menu_items: $('#menu-sortable').nestedSortable('toHierarchy', {startDepthCount: 0})
            },
            type: 'post'
        }).done(function(data) {

        });
    });
}

var toggleSidebar = function()
{
    $('.sidebar-handle').on('click', function(e) {
        if($('.sidebar').hasClass('extended')) {
            $('.sidebar').removeClass('extended').addClass('retracted');
            $('.wrapper').addClass('extended retracted');
        } else {
            $('.sidebar').removeClass('retracted').addClass('extended');
            $('.wrapper').removeClass('extended retracted');
        }
    })
}

var addMenuItem = function($button)
{
    $button.on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $.ajax({
           url: $button.data('href'),
           data: {
               menu_item: $('#menu_item').val()
           },
           type: 'post'
        }).done(function(data) {
           if(data.success == true) {
               location.reload();
           }
        });
    })
}
var toggleMenuItemActions = function() {
    $('#menu-sortable').find('li').on('mouseover', function() {
        $(this).find('i').removeClass('hide');
    }).on('mouseleave', function() {
       $(this).find('i').addClass('hide'); 
    });
}

var removeMenuItem = function($btn)
{
    $btn.on('click', function(e) {
        if(confirm('Are you sure you want to delete this menu item?')) {
            e.preventDefault();
            e.stopPropagation();
            $.ajax({
                url: MenuItemRemoveUrl,
                data: {
                    menu_item_id: $btn.parent().data('item-id')
                },
                type: 'POST'
                
            }).done(function(data) {
                if(data.success == true) {
                    location.reload();
                } else {
                    alert('Something went wrong!');
                }
            });
        }
        
    });
    
}

var editMenuItemModal = function($btn) {
    $btn.on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $.ajax({
            url: getEditModalUrl,
            data: {
                menu_item_id: $btn.parent().data('item-id')
            },
            type: 'post'
            
        }).done(function(data) {
            $('#append-edit-modal').html(data.content);
            $('#edit-menu-item').modal('show');
            
            updateMenuItem($('#update-menu-item'));
            
        });  
    })
}

var updateMenuItem = function($form)
{
    $form.on('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        $.ajax({
            url: $form.attr('action'),
            data: { 
                form_data: $form.serialize()
            },
            type: 'post'
            
        }).done(function(data) {
            
        });
        
    });
}