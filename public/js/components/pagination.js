$(document).ready(function (){
    let countPage = 1;
    $('.next-page').click(function () {
        event.preventDefault();
        countPage += 1;
        let url =  location.href;
        if(countPage <= $(this).attr('id')){
            if(url.split('?page').length > 1){
                $.ajax({
                    url: url.split('?page')[0] + '?page=' + countPage,
                    type: "GET",
                    success: function(data){
                        $('.products').append(data)
                    }
                });

            }else if(url.split('&page').length > 1){
                $.ajax({
                    url: url.split('&page')[0] + '&page=' + countPage,
                    type: "GET",
                    success: function(data){
                        $('.products').append(data)
                    }
                });
            }else if(url.split('?').length > 1){
                $.ajax({
                    url: url + "&page=" + countPage,
                    type: "GET",
                    success: function(data){
                        $('.products').append(data)
                    }
                });

            }else {
                $.ajax({
                    url: url.split('?page')[0] + '?page=' + countPage,
                    type: "GET",
                    success: function(data){
                        $('.products').append(data)
                    }
                });
            }
        }

        if(countPage == $(this).attr('id')) {
            $(this).attr('disabled', 'disabled').css('background-color', '#6fa1f4');
        }
    });
})
