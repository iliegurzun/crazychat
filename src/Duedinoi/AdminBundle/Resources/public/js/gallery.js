var fileUploadData = new Array();
var fadeOutTime = 1000;
var uploadSelectionNo = 1;
var transferInProgress = false;
$(function() {
    
    'use strict';
    if ($('#fileupload').length) {
        // Change this to the location of your server-side upload handler:
        var url = $('#trigger-upload').data('upload-url'),
                uploadButton = $('<button/>')
                .addClass('btn green upload')
                .prop('disabled', true)
                .text('Processing...')
                .on('click', function() {
                    var $this = $(this),
                            data = $this.data();
                    $this
                            .off('click')
                            .text('Abort')
                            .on('click', function() {
                                $this.closest('.image-upload-item').remove();
                                //$this.remove();
                                data.abort();
                                removeFromFileUploadData(data);
                            });
                    data.submit().always(function() {
                        $this.closest('.image-upload-item').remove();
                        //$this.remove();
                        data.abort();
                        removeFromFileUploadData(data);
                    });
                }),
                cancelButton = $('<button/>')
                .addClass('btn cancel btn-danger')
                .prop('disabled', true)
                .text('Processing...')
                .on('click', function() {
                    var $this = $(this),
                            data = $this.data();
                    $(this).closest('.image-upload-item').remove();
                    $this.remove();
                    data.abort();
                    removeFromFileUploadData(data);
                    if (fileUploadData.length == 0) {
                        $('#trigger-upload').hide();
                    }
                });
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 62914560, // 5 MB
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true,
            imageMaxWidth: 9999,
            // The maximum height of resized images:
            imageMaxHeight: 9999
        }).on('fileuploadadd', function(e, data) {
            $('#fileupload-start-all').show();
            fileUploadData.push(data);
            $('#trigger-upload').show();
            data.context = $('<div class="image-upload-item">').appendTo('#files');
            $.each(data.files, function(index, file) {
                var node = $('<p/>')
                        .append($('<span/>').text(file.name.substr(0, 20)));
                if (!index) {
                    //console.log(index, file, data, $.inArray(data.files[0], data.originalFiles));
                    //var specId = data.fileInput[0].value;
                    var specId = $.inArray(data.files[0], data.originalFiles);
                    specId = 'file-upload-selection-' + uploadSelectionNo + specId;
                    node
                            //.append('<br>')
                            .append('<div class="photo-desc-wrap col-lg-8"><div class="form-row"><label class="label-hide" for="' + specId + '">Add a description (optional)...</label><textarea id="' + specId + '" class="label-over form-control photo-description" /></div></div>')
                            .append(cancelButton.clone(true).data(data))
//                      .append('<div class="progress-bar"><div class="bar"></div><div class="progress"></div></div>');


                }
                node.appendTo(data.context);
                uploadSelectionNo++;
                labelify();
                //$(data.context).append('<div class="progress-bar"><div class="bar"></div><div class="progress"></div></div>');
            });
//          var is_safari = navigator.userAgent.indexOf("Safari") > -1;
            if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) { //Adrian S. #463
                $(".image-upload-item p .photo-desc-wrap").addClass("safari");
            }
            ;
        }).on('fileuploadprocessalways', function(e, data) {
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);
            if (file.preview) {
                node
                        .prepend(file.preview);
            }
            if (file.error) {
                node.find(".progress-bar").append($('<span class="text-danger"/>').text(file.error));
                node.delay(3000).fadeOut(function() {
                    data.abort();
                    removeFromFileUploadData(data);
                });
            }
            node.find('.btn').attr('disabled', false);
            if (index + 1 === data.files.length) {
                data.context.find('button.upload')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
                data.context.find('button.cancel')
                        .text('Remove')
                        .prop('', !!data.files.error);
            }
        }).on('fileuploadprogress', function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $(data.context.children()[0]).parent().find('.progress').html(progress + '%');
            $(data.context.children()[0]).parent().find('.bar').css('width', progress + '%');
        }).on('fileuploaddone', function(e, data) {
            $.each(data.result.files, function(index, file) {
                if (file.saved == true) {
                    $(data.context.children()[index]).parent().fadeOut(fadeOutTime);
                    removeFromFileUploadData(data);
                    if(fileUploadData.length == 0) {
                        $('#trigger-upload').hide();
                    }
                    $('#photo-upload-area').hide();
                    $('.image-collection').append(file.htmlTemplate);
                    activateGalleryModal();
                    removePicture();
                    updatePhotoDesc();
                    if ($("#images-area li p.no-img").length) {
                        $("#images-area li p.no-img").parent().remove();
                    }
                } else {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                            .append(error);
                }
            });
            transferInProgress = false;
        }).on('fileuploadsubmit', function(e, data) {
            var $desc = data.context.find('.photo-description');


            // The example input, doesn't have to be part of the upload form:
            data.formData = {description: $desc.val()};
        }).on('fileuploadfail', function(e, data) {
            $.each(data.files, function(index, file) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                        //     .append('<br>')
                        .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
        $('#fileupload-start-all').click(function() {
            //console.log(1);
            $(".image-upload-item .progress-bar").show();
            if (fileUploadData.length == 0) {
                return;
            }
            for (var it = 0; it <= fileUploadData.length - 1; it++) {
                fileUploadData[it].submit();
            }
            fileUploadData = new Array();
            $('#fileupload-start-all').fadeOut();
        });
        $('#fileupload-cancel-all').click(function() {
            for (var it = 0; it <= fileUploadData.length - 1; it++) {
                fileUploadData[it].abort();
                $('.image-upload-item').each(function(index, el) {
                    $(el).fadeOut(fadeOutTime, function() {
                        $(el).remove();
                    })
                })
            }
            fileUploadData = new Array();
        });
    }

    $('#trigger-upload').on('click', function(e) {
        e.preventDefault();
        if (fileUploadData.length == 0) {
            return;
        }
        for (var it = 0; it <= fileUploadData.length - 1; it++) {
            fileUploadData[it].submit();
        }
    });

    $('.form-group.image-collection').find('img').mouseover(function() {
        $(this).siblings('i').show();
    }).mouseout(function() {
        $(this).siblings('i').hide();
    });

//   $('.gallery-image-item').each(function() {
    $('.gallery-image-item').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).next('.modal').modal('show');
    });
    
    activateGalleryModal();
    removePicture();
    updatePhotoDesc();
});

$(window).bind('beforeunload', function(evt) {
    if (fileUploadData.length == 0) {
        return;
    }
    var message = 'Your photos have not been uploaded yet!';
    if (typeof evt == undefined) {
        evt = window.event;
    }
    if (evt) {
        evt.returnValue = message;
    }
    return message;
});

var removeFromFileUploadData = function(data) {
    if (fileUploadData.length == 0)
        return;
    for (it = 0; it <= fileUploadData.length - 1; it++) {
        fileUploadItem = fileUploadData[it];
        if (fileUploadItem.fileInput == data.fileInput) {
            removeFileUploadDataItem(it);
        }
    }
    if (fileUploadData.length == 0) {
        $('#photo-upload-area').hide();
    }
    ;
}

var removeFileUploadDataItem = function(pos) {
    if (pos > fileUploadData.length - 1)
        return;
    for (it = pos; it <= fileUploadData.length - 2; it++) {
        fileUploadData[it] = fileUploadData[it + 1];
    }
    fileUploadData.pop();
};

var activateGalleryModal = function() {
    $('.gallery-image-item').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).next('.modal').modal('show');
    });
}

var removePicture = function() {
    $('.modal').on('shown.bs.modal', function() {
        var modal = $(this);
        var $btn = $(this).find('.delete-img');
        $btn.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (confirm('are you sure you want to delete this image?')) {
                $.ajax({
                    url: $btn.data('image-remove-url'),
                    data: {
                        image_id: $btn.data('image-id'),
                        gallery_id: $btn.data('gallery-id')
                    },
                    type: 'post'
                }).done(function(data) {
                    if (data.success == true) {
                        $('.delete-img').closest('.modal').modal('hide');
                        modal.prev('.gallery-image-item').remove();
//                      modal.remove();
                    }
                });
            }
        });
    });
}

var updatePhotoDesc = function() {
    $('.edit-photo-btn').on('click', function(e) {
        var $btn = $(this);
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        $.ajax({
            url: $btn.data('url'),
            data: {
                description: $btn.parent().prev('.form-group').find('textarea').val()
            },
            type: 'post'
        }).done(function(data) {
            if(data.success == true) {
                $('#'+data.image_id).modal('hide');
            }
        });
    })
}