$(document).ready(function() {
    $(document).on('mouseover','.hidden-img', function () {
        $(this).parent().css("background-image", "url('/images/product-details/" + $(this).attr('id') +  "')");
    });
    $(document).on('mouseout','.hidden-img',function () {
        $(this).parent().css("background-image", "url('/images/preview-images/" + $(this).parent().attr('id') +  "')");
    });

    // pagination
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

    let full_url = location.href.split('?');
    let url = full_url[0];

    if(full_url.length > 1){
        let params = full_url[1].split('&');
        for(let i = 0; i < params.length; i++){
            var filterParams = params[i].split('=');
            var filterValues = filterParams[1].split('+');
            if (filterValues.length < 2){
                filterValues = filterParams[1].split('%20');
            }

            if(filterParams[0] == 'orderBy'){
                if(filterValues.length < 2){
                    if(filterValues[0] == 'count'){
                        $('select[name="order-by"]').find('option[value="count"]').prop('selected', true);
                    }else if(filterValues[0] == 'price-asc'){
                        $('select[name="order-by"]').find('option[value="price-asc"]').prop('selected', true);
                    }else if(filterValues[0] == 'price-desc'){
                        $('select[name="order-by"]').find('option[value="price-desc"]').prop('selected', true);
                    }else if(filterValues[0] == 'created_at'){
                        $('select[name="order-by"]').find('option[value="created_at"]').prop('selected', true);
                    }else if(filterValues[0] == 'discount'){
                        $('select[name="order-by"]').find('option[value="discount"]').prop('selected', true);
                    }
                }
            }
            if(filterParams[0] == 'q'){
                url += '?q=' + filterValues[0];
            }
        }
    }

    $('select[name="order-by"]').find('option').mouseup( function() {

        if (url.split('?').length > 1) {
            url += '&orderBy=' + $(this).val();
        } else {
            url += '?orderBy=' + $(this).val();
        }

        window.location.href = url;
    });
});