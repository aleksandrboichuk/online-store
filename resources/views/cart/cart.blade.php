@extends('layouts.main')
@section('content')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ol>
            </div>
            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                    <tr class="cart_menu">
                        <td class="image"></td>
                        <td class="description"><b>Назва товару</b></td>
                        <td class="price"><b>Вартість</b></td>
                        <td class="select-size"><b>Розмір</b></td>
                        <td class="quantity"> <b>Кількість</b></td>
                        <td class="total"><b>Ціна</b></td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody class="cart-table">
        @if(isset($products) && !empty($products))
                    @foreach($products as $item)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="/images/preview-images/{{$item->preview_img_url}}" alt="" /></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$item->name}}</a></h4>
                            <p class="product-id">ID: {{$item->id}}</p>
                        </td>
                        <td class="cart_price">
                            <p>${{$item->price}}</p>
                        </td>
                        <td class="cart_size">
                            <p>{{$item->pivot->size}}</p>
                        </td>
                        <td class="cart_quantity">
                                 <input
                                        onkeyup="this.value = this.value.replace(/[^\d]/g,'');"
                                        class="cart_quantity_input"
                                        type="text"
                                        name="quantity"
                                        value="{{$item->pivot->count}}"
                                        autocomplete="off"
                                        size="2"
                                        id="{{$item->id}}"
                                />
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">₴{{$item->pivot->count * $item->price}}</p>
                        </td>
                        <td class="cart_delete">
                            <form action="{{route('delete.from.cart')}}" method="post">
                                <input type="hidden" name="delete-id" value="{{$item->id}}">
                                <button type="submit" class="btn btn-danger"><svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                        <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                    </svg></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
            @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section id="do_action">
        <div class="container">

            <div class="row">
                <div class="col-sm-6 make-order" style="float: right">
                    <div class="total_area">
                        <ul>
                            <li><b>Вартість товарів в кошику:</b><span class="total-cart"></span></li>
                            <li><b>Вартість доставки:</b><span class="delivery">₴12</span></li>
                            <li><b>Всього до сплати:</b><span class="total-price"></span></li>
                        </ul>
                        <button class="btn btn-default check_out"><a href="{{route('checkout', $user->id)}}">Оформити замовлення</a></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
@endsection

@section('custom-js')
    <script>
        $(document).ready(function () {
            let price = $('.cart_total_price').text().split('₴');
            let subtotal = 0;
            for (let i=1; i < price.length; i++) {
                subtotal = subtotal + parseInt(price[i]);
            }
            $('.total-cart').text("₴" + subtotal);
            let delivery = $('.delivery').text().split('₴');
            $('.total-price').text("₴" + (subtotal + parseInt(delivery[1])));

        });
        $(document.body).on("change",".cart_quantity_input", function () {


           let value = $(this).val();
           let updateId = $(this).attr('id');

            if ((value > 0)){
                $.ajax({
                    url: "{{route('show.cart', [$user->id])}}"  ,
                    type: "GET",
                    data: {
                        updateId: updateId,
                        value: value,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) =>{
                        $('.cart-table').html(data)
                    }

                });
            }

        });

    </script>
@endsection
