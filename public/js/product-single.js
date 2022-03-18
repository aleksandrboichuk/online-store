$(document).ready(function() {
    // pagination
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
                    $('.reviews').append(data)
                }
            });
        }

        if (countPage == $(this).attr('id')) {
            $(this).css('display', 'none');
        }
    });
});

function addToCart(route) {
    $('.product-img-item').click(function () {
        $('.main-product-img').attr('src', $(this).attr('src'));
        $('#fancybox').attr('href', $(this).attr('src'));
    });


    $('.size-item').click(function () {
        $('.sizes').find('.active-size').removeClass("active-size");
        $(this).addClass("active-size");
    });


    $('.btn-default').click(function () {
        let productId = $('.product-id').attr('id');
        let productCount = $('.quantity').val();
        let productSize =  $('.sizes').find('.active-size').find('p').text();

        if(isNaN(parseInt(productSize))){
            productSize = $('.sizes').find('p').first().text();
        }

        $(this).text("Додано до кошику!");
        $(".cart").addClass("added");

        function btn() {
            let button = $(".cart");
            button.removeClass("added");
            button.text(' До кошику ');
            button.prepend('<i class="fa fa-shopping-cart"></i>');
        }


        if ( productId > 0 ){
            $.ajax({
                url: route ,
                type: "GET",
                data: {
                    productId: productId,
                    productCount: productCount,
                    productSize: parseInt(productSize)
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) =>{
                    setTimeout(btn, 1000);
                }
            });
        }
    })
}

function animatePreview() {
    $(document).on('mouseover','.hidden-img', function () {
        $(this).parent().css("background-image", "url('/storage/product-images/" + $(this).attr('id') +  "')");
    });
    $(document).on('mouseout','.hidden-img',function () {
        $(this).parent().css("background-image", "url('/storage/product-images/" + $(this).parent().attr('id') +  "')");
    });
}

$('.btn-minus').click(function () {

    let quantity = $(this).parent().find('.quantity');
    let quantityValue = parseInt(quantity.val());

    if((quantityValue - 1) < 1){
        quantity.val('1');
    }else{
        quantity.val((quantityValue - 1).toString());
    }
});
$('.btn-plus').click(function () {
    let quantity = $(this).parent().find('.quantity');
    let quantityValue = parseInt(quantity.val());

    if((quantityValue + 1) > 10){
        quantity.val('10');
    }else{
        quantity.val((quantityValue + 1).toString());
    }
});