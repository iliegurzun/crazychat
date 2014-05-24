$(function() {
    
    removeCollectionElem($('.remove-attribute'));
  $('.add-another').click(function(e) {
    e.preventDefault();
    var another = $('#' + $(this).attr('data-form-name') + '_' + $(this).attr('data-rel'));
    var newAnother = another.attr('data-prototype');
    var anotherCount = $(this).attr('data-count');
    newAnother = newAnother.replace(/__name__/g, anotherCount);
    $(this).attr('data-count', ++anotherCount);
    
    another.append(newAnother);
//    tinymce.init({selector:'.tinymce'});
    removeCollectionElem($('.remove-attribute'));
  });
});

var removeCollectionElem = function($button)
{
    $button.on('click', function(e) {
    e.preventDefault();
    var id = $(e.currentTarget).parent().attr('id');
    $(this).parent().parent().remove();
  });
}