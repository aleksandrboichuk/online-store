@extends('layouts.main')
@section('content')
    @if(session()->has('success-message'))
        <div class="alert alert-success alert-active" role="alert">
            <h4 class="alert-heading">Замовлення прийнято!</h4>
            <p>{{session('success-message')}}</p>
            <hr>
            <div class="mb-0"><button type="button" class="btn btn-default alert-btn alert-btn-close">Закрити</button></div>
            <div class="mb-0"><a href="/shop/women"><button type="button" class="btn btn-default alert-btn">Повернутися на головну</button></a></div>
        </div>
        @php(session()->forget('success-message'))
    @elseif(session()->has('success-message-delete'))
            <div class="alert alert-success alert-active" role="alert">
                <h4 class="alert-heading">Виконано!</h4>
                <p>{{session('success-message-delete')}}</p>
                <hr>
                <div class="mb-0"><button type="button" class="btn btn-default alert-btn alert-btn-close">Закрити</button></div>
            </div>
            @php(session()->forget('success-message-delete'))
    @endif
    <section id="table_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/shop/women">Головна</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                    <li class="active">Кошик</li>
                </ol>
            </div>
            <div class="title-page"><h2>Кошик</h2></div>
            <div class="table-responsive cart_info {{isset($products) && !empty($products) && count($products) > 0 ? "" : "cart-table" }}">
                <table class="table table-condensed">
                    <thead>
                    <tr class="cart_menu">
                        <td class="image"></td>
                        <td class="description"><b>Назва товару</b></td>
                        <td class="price"><b>Ціна</b></td>
                        <td class="select-size"><b>Розмір</b></td>
                        <td class="quantity"> <b>Кількість</b></td>
                        <td class="total"><b>Усього</b></td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody class="cart-table">
        @if(isset($products) && !empty($products) && count($products) > 0 )
                    @foreach($products as $item)
                    <tr>
                        <td class="cart_product">
                            <a href="{{route('show.product.details', [$item->categoryGroups->seo_name, $item->categories->seo_name, $item->subCategories->seo_name, $item->seo_name])}}"><img src="/images/preview-images/{{$item->preview_img_url}}" alt="" /></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="{{route('show.product.details', [$item->categoryGroups->seo_name, $item->categories->seo_name, $item->subCategories->seo_name, $item->seo_name])}}">{{$item->name}}</a></h4>
                            <p class="product-id">ID: {{$item->id}}</p>
                        </td>
                        @if($item->discount != 0)
                            <td class="cart_price">
                                <p><s>₴{{$item->price}}</s></p>
                                <p><b>₴{{$item->price - (round($item->price * ($item->discount * 0.01)))}}</b></p>
                            </td>
                        @else
                            <td class="cart_price">
                                <p>₴{{$item->price}}</p>
                            </td>
                        @endif
                        <td class="cart_size">
                            <p>{{$item->pivot->size}}</p>
                        </td>
                        <td class="cart_quantity">
                            <input type="hidden" name="size" id="size" value="{{$item->pivot->size}}">
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
                        @if($item->discount != 0)
                            <td class="cart_total">
                                <p class="cart_total_price">₴{{$item->pivot->count * ($item->price - (round($item->price * ($item->discount * 0.01))))}}</p>
                            </td>
                        @else
                            <td class="cart_total">
                                <p class="cart_total_price">₴{{$item->pivot->count * $item->price}}</p>
                            </td>
                        @endif
                        <td class="cart_delete">
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
            @else
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><p style="font-size: 25px">Ваш кошик наразі порожній</p></td>
            </tr>

            @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section id="do_action">
        @if(isset($products) && count($products) > 0)

        <div class="container">
            <div class="row">
                <div class="col-sm-6 make-order" style="float: right">
                    <div class="total_area">
                        <ul>
                            <li><b>Усього до сплати:</b><span class="total-price"></span></li>
                        </ul>
                        <a href="{{route('checkout')}}"><button class="btn btn-default check_out">Оформити замовлення</button></a>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </section>

    
@endsection

@section('custom-js')
    <script>
        $(document).ready(function () {
            $('.alert-btn-close').click(function () {
                $(this).parent().parent().removeClass('alert-active');
            });


            let price = $('.cart_total_price').text().split('₴');
            let subtotal = 0;
            for (let i=1; i < price.length; i++) {
                subtotal = subtotal + parseInt(price[i]);
            }
            $('.total-price').text("₴" + (subtotal));

        });
        $(document.body).on("change",".cart_quantity_input", function () {


           let value = $(this).val();
           let updateId = $(this).attr('id');
           let updateSize = parseInt($(this).parent().find('#size').val());
            if ((value > 0)){
                $.ajax({
                    url: "{{route('show.cart')}}"  ,
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
                        $('.cart-table').html(data);
                        let price = $('.cart_total_price').text().split('₴');
                        let subtotal = 0;
                        for (let i=1; i < price.length; i++) {
                            subtotal = subtotal + parseInt(price[i]);
                        }
                        $('.total-price').text("₴" + (subtotal));
                    }

                });
            }

        });

    </script>
@endsection
