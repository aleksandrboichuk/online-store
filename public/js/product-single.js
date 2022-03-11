function addToCart(route) {
    $('.product-img-item').click(function () {
        $('.main-product-img').attr('src', $(this).attr('src'));
        $('#fancybox').attr('href', $(this).attr('src'));
    });


    $('.size-item').click(function () {
        $('.sizes').find('.active-size').removeClass("active-size");
        $('.sizes').find('p').css("color", "#696763");
        $(this).addClass("active-size");
        $(this).find('p').css("color", "#fff");
    });


    $('.btn-fefault').click(function () {
        let productId = $('.product-id').attr('id');
        let userId =  $('.quantity').attr('id');
        let productCount = $('.quantity').val();
        let productSize =  $('.sizes').find('.active-size').find('p').text();

        if(isNaN(parseInt(productSize))){
            productSize = $('.sizes').find('p').first().text();
        }

        $(this).text("Додано до кошику!");
        $(".cart").addClass("added");

        function btn() {
            $(".cart").removeClass("added");
            $('.btn-fefault').append('<i class="fa fa-shopping-cart" ></i>').text(" До кошику ")
        }

        setTimeout(btn, 1000);

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
                success: (data) =>{}
            });
        }
    })
}

function animatePreview() {
    $('.hidden-img').hover(function () {
        $(this).parent().css("background-image", "url('/images/product-details/" + $(this).attr('id') +  "')");
    });
    $('.hidden-img').mouseout(function () {
        $(this).parent().css("background-image", "url('/images/preview-images/" + $(this).parent().attr('id') +  "')");
    })
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