@extends('layouts.main')

@section('content')
    <section id="table_items">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="/shop/women">Головна</a> </li>
                <li><a href="/cart">Кошик</a> </li>
                <li class="active">Оформлення замовлення</li>
            </ol>
        </div>
        <div class="container">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
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
                                    <a href="{{route('show.product.details', [$item->categoryGroups->seo_name, $item->categories->seo_name, $item->subCategories->seo_name, $item->seo_name])}}"><img src="/storage/product-images/{{$item->id}}/preview/{{$item->preview_img_url}}" alt="" /></a>
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
                            <td colspan="3">&nbsp;</td>
                            <td colspan="3">
                                <table class="table table-condensed total-result">
                                    <tr>
                                        <td>Сума вартості товарів:</td>
                                        <td class="total-cart">₴{{$totalSum}}</td>
                                    </tr>
                                    <tr>
                                        <td>Доставка</td>
                                        <td> ₴0</td>
                                    </tr>
                                    @if(!empty($promocode))
                                        <tr>
                                            <td><b>Знижка (промокод)</b> </td>
                                            <td><b>-₴{{(round($totalSum * ($promocode->discount * 0.01)))}} ({{$promocode->discount}}%)</b></td>
                                        </tr>
                                        <tr>
                                            <td><b class="total-price-title">Усього до сплати:</b></td>
                                            <td><span class="total-price">₴{{$totalSum - (round($totalSum * ($promocode->discount * 0.01)))}}</span></td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td><b class="total-price-title">Усього до сплати:</b></td>
                                            <td><span class="total-price">₴{{$totalSum}}</span></td>
                                        </tr>
                                    @endif

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
                                                    <li><b>Телефон:</b><span><input type="text" name="user-phone" value="{{$user->phone}} " required onkeyup="this.value = this.value.replace(/[^\d]/g,'');"></span></li>
                                                </ul>
                                            @else
                                                <ul class="total-area-user-data">
                                                    <li><b>Ім'я:</b><span><input type="text" name="user-firstname" value="" required></span></li>
                                                    <li><b>Прізвище:</b><span><input type="text" name="user-lastname" value="" required></span></li>
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
                                                maxlength="150"
                                        ></textarea>
                                    </div>
                                </div>
                                <div class="delivery-area">
                                    <div class="bill-to">
                                        <p>Доставка</p>
                                        <select name="user-city" id="user-city">
                                            @foreach($cities as $city)
                                                <option value="{{$city->name}}" {{!empty($user) && $city->name == $user->city ? "selected" : ""}}>{{$city->name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="delivery-input">
                                            <input type="radio" name="delivery-field" id="post" checked >
                                            <label for="post">Самовивіз з відділення Нова Пошта</label>
                                        </div>
                                        <div class="post-department-field">
                                            <label for="post-department">Відділення №</label>
                                            <input type="text" name="post-department-field" id="post-department" onkeyup="this.value = this.value.replace(/[^\d]/g,'');">
                                        </div>
                                        <div class="delivery-input">
                                            <input type="radio" name="delivery-field" id="courier">
                                            <label for="courier">Доставка кур'єром за адресою</label>
                                        </div>
                                        <div class="address-field">
                                            <label for="address-field">Адреса: </label>
                                            <input type="text" name="address-field" id="address-field">
                                        </div>

                                    </div>
                                </div>
                                <div class="pay-area">
                                    <div class="bill-to">
                                        <p>Оплата</p>
                                        <div class="total-sum-info">
                                            <h4>Сума до сплати:</h4>
                                            @if(!empty($promocode))
                                                <input type="text" value="₴{{$totalSum - (round($totalSum * ($promocode->discount * 0.01)))}}" name="total-sum" readonly="readonly">
                                                <input type="hidden" value="{{$promocode->promocode}}" name="promocode" readonly="readonly">
                                             @else
                                                <input type="text" value="₴{{$totalSum}}" name="total-sum" readonly="readonly">
                                            @endif
                                        </div>
                                        <div class="later-pay">
                                            <input type="radio" name="pay-field" id="later-pay" checked>
                                            <label for="later-pay">Оплата при отриманні товару</label>
                                        </div>
                                        <div class="now-pay">
                                            <input type="radio" name="pay-field" id="now-pay">
                                            <label for="now-pay">Оплата карткою зараз</label>
                                        </div>
                                        <div class="email-field">
                                            <label for="email-field">Електронна пошта: </label>
                                            <input type="email" name="email-field" id="email-field">
                                        </div>

                                    </div>
                                </div>
                                <div class="btn-form"><button type="submit" class="btn btn-default check_out" {{empty($cart->products) || count($cart->products) < 1 ? "disabled" : ""}}>Перейти до сплати</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-1"></div>
        </div>
    </section>
    @endsection

@section('custom-js')
    <script>
        $(document).ready(function () {
            // let price = $('.cart_total_price').text().split('₴');
            // let subtotal = 0;
            // for (let i=1; i < price.length; i++) {
            //     subtotal = subtotal + parseInt(price[i]);
            // }
            // $('.total-cart').text("₴" + subtotal);
            // $('.total-price').text("₴" + subtotal);

           if($('#courier').prop('checked')){
                $('.address-field').css('display', 'block');
                $('.post-department-field').css('display', 'none').find('input').val('');
            }
            if( $('#now-pay').prop('checked')){
                $('.email-field').css('display', 'block');
            }

            $('#courier').change(function () {
                if($(this).prop('checked')){
                   $('.address-field').css('display', 'block');
                   $('.post-department-field').css('display', 'none').find('input').val('');
                }
            });
            $('#post').change(function () {
                if($(this).prop('checked')){
                    $('.address-field').css('display', 'none').find('input').val('');
                    $('.post-department-field').css('display', 'block');
                }
            });
            $('#later-pay').change(function () {
                if($(this).prop('checked')){
                    $('.email-field').css('display', 'none').find('input').val('');
                }
            });

            $('#now-pay').change(function () {
                if($(this).prop('checked')){
                    $('.email-field').css('display', 'block');
                }
            });

        });
        </script>
    @endsection