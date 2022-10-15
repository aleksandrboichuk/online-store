$(document).ready(function () {
    $('.alert-btn-close').click(function () {
        $(this).parent().parent().removeClass('alert-active');
    });
});
