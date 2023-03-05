$(document).ready(function () {
    $('.alert-btn-close').click(function () {
        $(this).parent().parent().removeClass('alert-active');
    });


    let price = $('.total-col').text().split('₴');
    let subtotal = 0;
    for (let i=1; i < price.length; i++) {
        subtotal = subtotal + parseInt(price[i]);
    }
    $('.total-price').text("₴" + (subtotal));


    $(document).on('click','.quantity-minus', function () {
        let quantity = $(this).parent().find('.quantity');
        let quantityValue = parseInt(quantity.val());
        if((quantityValue - 1) < 1){
            quantity.val('1');
        }else{
            quantity.val((quantityValue - 1).toString());
        }
        let input = $(this).parent().find('.quantity');
        updatePrice("/api/public/cart/update", input);
    });

    $(document).on('click','.quantity-plus', function () {
        let quantity = $(this).parent().find('.quantity');
        let quantityValue = parseInt(quantity.val());

        if((quantityValue + 1) > 10){
            quantity.val('10');
        }else{
            quantity.val((quantityValue + 1).toString());
        }
        let input = $(this).parent().find('.quantity');
        updatePrice("/api/public/cart/update", input);
    });
});

function updatePrice(route, input) {
    let value = input.val();
    let updateId = input.attr('id');
    let updateSize = parseInt(input.parent().find('#size').val());
    if ((value > 0)){
        $.ajax({
            url: route,
            type: "POST",
            data: {
                updateId: updateId,
                updateSize:updateSize,
                value: value,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) =>{
                $('.cart_table').html(data);
                let price = $('.total-col').text().split('₴');
                let subtotal = 0;
                for (let i=1; i < price.length; i++) {
                    subtotal = subtotal + parseInt(price[i]);
                }
                $('.total-price').text("₴" + (subtotal));
            }
        });
    }
}
