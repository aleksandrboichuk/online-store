@extends('layouts.main')

@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/shop/women">Головна</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                    <li><a href="/cart">Кошик</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                    <li class="active">Оформлення замовлення</li>
                </ol>
            </div>

            <div class="review-payment">
                <h2>Перегляд товарів замовлення</h2>
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
                        <td class="total"><b>Загальна вартість</b></td>
                    </tr>
                    </thead>
                    <tbody class="cart-table">

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
                                <p>{{$item->pivot->count}}</p>
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
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td colspan="2">
                            <table class="table table-condensed total-result">
                                <tr>
                                    <td>Сума вартості товарів:</td>
                                    <td class="total-cart"></td>
                                </tr>
                                <tr>
                                    <td><b>Усього до сплати:</b></td>
                                    <td ><span class="total-price"></span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="shopper-information">
                <div class="row">
                    {{--<a class="btn btn-primary" href="">Get Quotes</a>--}}
                    <div class="col-sm-12 ">
                        <form action="{{route('save.order')}}" method="post" >
                            <div class="checkout-area">
                                <div class="bill-to">
                                    <p>Контактні дані користувача</p>
                                    <div class="total_area">
                                        @if(isset($user) && !empty($user))
                                        <ul class="total-area-user-data">
                                            <li><b>Ім'я:</b><span><input type="text" name="user-firstname" value="{{$user->first_name}}" required></span></li>
                                            <li><b>Прізвище:</b><span><input type="text" name="user-lastname" value="{{$user->last_name}}" required></span></li>
                                            <li><b>E-mail:</b><span><input type="text" name="user-email" value="{{$user->email}}" required></span></li>
                                            <li><b>Місто:</b><span><input type="text" name="user-city" value="{{$user->city}}" required></span></li>
                                            <li><b>Адреса:</b><span><input type="text" name="user-address" value="{{$user->address}}" required></span></li>
                                            <li><b>Телефон:</b><span><input type="text" name="user-phone" value="{{$user->phone}} " required onkeyup="this.value = this.value.replace(/[^\d]/g,'');"></span></li>
                                        </ul>
                                            @else
                                            <ul class="total-area-user-data">
                                                <li><b>Ім'я:</b><span><input type="text" name="user-firstname" value="" required></span></li>
                                                <li><b>Прізвище:</b><span><input type="text" name="user-lastname" value="" required></span></li>
                                                <li><b>E-mail:</b><span><input type="text" name="user-email" value="" required></span></li>
                                                <li><b>Місто:</b><span><input type="text" name="user-city" value="" required></span></li>
                                                <li><b>Адреса:</b><span><input type="text" name="user-address" value="" required></span></li>
                                                <li><b>Телефон:</b><span><input type="text" name="user-phone" value="" required onkeyup="this.value = this.value.replace(/[^\d]/g,'');"></span></li>
                                            </ul>
                                            @endif
                                    </div>
                                </div>
                                <div class="order-message">
                                    <p>Коментар (необов'язково)</p>
                                    <textarea
                                            name="comment"
                                            placeholder="Напишіть коментар стосовно доставки/замовлення...."
                                            rows="16"
                                    ></textarea>
                                </div>
                                </div>
                            <div class="btn-form"><button type="submit" class="btn btn-default check_out">Перейти до сплати</button></div>
                        </form>
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
            $('.total-price').text("₴" + subtotal);

        });
        </script>
    @endsection