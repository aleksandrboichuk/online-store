@extends('layouts.main')
@section('content')

    @if(session()->has('success-message'))
        <div class="alert alert-success alert-active" role="alert">
            <h4 class="alert-heading">Замовлення прийнято!</h4>
            <p>{{session('success-message')}}</p>
            <hr>
            <div class="mb-0"><button type="button" class="btn btn-danger alert-btn alert-btn-close">Закрити</button></div>
        </div>
        @php(session()->forget('success-message'))
    @elseif(session()->has('success-message-delete'))
        <div class="alert alert-success alert-active" role="alert">
            <h4 class="alert-heading">Виконано!</h4>
            <p>{{session('success-message-delete')}}</p>
            <hr>
            <div class="mb-0"><button type="button" class="btn btn-danger alert-btn alert-btn-close">Закрити</button></div>
        </div>
        @php(session()->forget('success-message-delete'))
    @elseif(session()->has('warning-message'))
        <div class="alert alert-warning alert-active" role="alert">
            <h4 class="alert-heading">Помилка!</h4>
            <p>{{session('warning-message')}}</p>
            <hr>
            <div class="mb-0"><button type="button" class="btn btn-danger alert-btn alert-btn-close">Закрити</button></div>
        </div>
        @php(session()->forget('warning-message'))
    @endif
    <!-- cart section end -->
    <section class="cart-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart_area">
                        <h3>Кошик</h3>
                        <div class="cart-table-warp">
                            <table>
                                <thead>
                                <tr>
                                    <th class="product-th">Товар</th>
                                    <th class="quy-th">Кількість</th>
                                    <th class="size-th">Розмір</th>
                                    <th class="total-th">Ціна</th>
                                    <th class="total-th"></th>
                                </tr>
                                </thead>
                                <tbody class="cart_table">
                                @if(isset($products) && !empty($products) && count($products) > 0 )
                                    @foreach($products as $item)
                                        <tr>
                                            <td class="product-col">
                                                <img src="/images/products/{{$item->id}}/preview/{{$item->preview_img_url}}" alt="">
                                                <div class="pc-title">
                                                    <h4><a href="{{route('product', [$item->categoryGroup->seo_name, $item->categories->seo_name, $item->subCategories->seo_name, $item->seo_name])}}">{{$item->name}}</a></h4>
                                                @if($item->discount != 0)
                                                        <s>₴{{$item->price}}</s>
                                                        <p>₴{{$item->price - (round($item->price * ($item->discount * 0.01)))}}</p>
                                                @else
                                                        <p>₴{{$item->price}}</p>
                                                @endif
                                                </div>
                                            </td>
                                            <td class="quy-col">
                                                <div class="quantity-group">
                                                    <input type="button" class="quantity-minus" value="-">
                                                        <input type="hidden" name="size" id="size" value="{{$item->pivot->size}}">
                                                        <input type="text" class="quantity" name="quantity"  value="{{$item->pivot->product_count}}" id="{{$item->id}}"  autocomplete="off" readonly />
                                                    <input type="button"  class="quantity-plus" value="+">
                                                </div>
                                            </td>
                                            <td class="size-col"><h4>{{$item->pivot->size}}</h4></td>
                                            <td class="total-col"><h4>
                                            @if($item->discount != 0)
                                                  ₴{{$item->pivot->product_count * ($item->price - (round($item->price * ($item->discount * 0.01))))}}
                                            @else
                                                  ₴{{$item->pivot->product_count * $item->price}}
                                            @endif
                                            </h4></td>
                                            <td class="del-col">
                                                <form action="{{route('delete.from.cart')}}" method="post">
                                                    <input type="hidden" name="delete-id" value="{{$item->id}}">
                                                    <input type="hidden" name="size" value="{{$item->pivot->size}}">
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
                        <div class="total-cost">
                            <h6>Усього <span class="total-price">₴0</span></h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 card-right">
                    <form action="{{route('checkout')}}" method="get">
                        @if(!empty($user))
                            <select name="promocode" id="promocode">
                                <option value="no">Без промокоду</option>
                                @if(!empty($promocodes) && count($promocodes) > 0)
                                    @foreach($promocodes as $promocode)
                                        <option value="{{$promocode->promocode}}">{{$promocode->title}}</option>
                                    @endforeach
                                @endif
                            </select>
                        @endif
                        <button  class="site-btn btn btn-default" {{!empty($products) && count($products) > 0 ? "type=submit": "disabled"}}>Оформити замовлення</button>
                    </form>

                    <a href="/shop/women" class="site-btn sb-dark">Продовжити покупки</a>
                </div>
            </div>
        </div>
    </section>
    <!-- cart section end -->

@endsection


@section('custom-js')
    <script>
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
                updatePrice("{{route('cart')}}", input);
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
                updatePrice("{{route('cart')}}", input);
            });
        });

        function updatePrice(route, input) {
            let value = input.val();
            let updateId = input.attr('id');
            let updateSize = parseInt(input.parent().find('#size').val());
            if ((value > 0)){
                $.ajax({
                    url: route,
                    type: "GET",
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
    </script>
@endsection
