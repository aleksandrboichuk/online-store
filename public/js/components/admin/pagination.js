$(document).ready(function () {
    $('.alert-btn-close').click(function () {
        $(this).parent().parent().removeClass('alert-active');
    });

    let countPage = 1;
    $('.next-page').click(function () {
        event.preventDefault();
        countPage += 1;
        let url = location.href;
        if (countPage <= $(this).attr('id')) {
            $.ajax({
                url: url.split('?page')[0] + '?page=' + countPage,
                type: "GET",
                success: function (data) {
                    $('.general-table').append(data)
                }
            });
        }

        if (countPage == $(this).attr('id')) {
            $(this).css('display', 'none');
        }
    });
});
