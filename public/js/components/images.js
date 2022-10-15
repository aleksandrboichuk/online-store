$(document).on('mouseover','.hidden-img', function () {
    $(this).parent().css("background-image", "url('/images/products/" + $(this).attr('id') +  "')");
});
$(document).on('mouseout','.hidden-img',function () {
    $(this).parent().css("background-image", "url('/images/products/" + $(this).parent().attr('id') +  "')");
});
