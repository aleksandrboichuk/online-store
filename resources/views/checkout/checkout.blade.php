@extends('layouts.main')

@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                {{--<ol class="breadcrumb">--}}
                    {{--<li><a href="#">Home</a></li>--}}
                    {{--<li class="active">Check out</li>--}}
                {{--</ol>--}}
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
                                <p>{{$item->pivot->count}}</p>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">₴{{$item->pivot->count * $item->price}}</p>
                            </td>
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
                                <tr class="shipping-cost">
                                    <td>Вартість доставки:</td>
                                    <td class="delivery">₴15</td>
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
            <div class="shopper-informations">
                <div class="row">
                    {{--<a class="btn btn-primary" href="">Get Quotes</a>--}}
                    <div class="col-sm-6 clearfix">
                        <div class="bill-to">
                            <p>Контактні дані користувача</p>
                            <div class="total_area">
                                <ul>
                                    <li><b>Ім'я:</b><span>{{$user->first_name}}</span></li>
                                    <li><b>Прізвище:</b><span>{{$user->last_name}}</span></li>
                                    <li><b>E-mail:</b><span>{{$user->email}}</span></li>
                                    <li><b>Місто:</b><span>{{$user->city}}</span></li>
                                    <li><b>Адреса:</b><span>{{$user->address}}</span></li>
                                    <li><b>Телефон:</b><span>{{$user->phone}}</span></li>
                                </ul>
                            </div>
                            {{--<div class="form-two">--}}
                            {{--<form>--}}
                            {{--<input type="text" placeholder="Zip / Postal Code *" />--}}
                            {{--<select>--}}
                            {{--<option>-- Country --</option>--}}
                            {{--<option>United States</option>--}}
                            {{--<option>Bangladesh</option>--}}
                            {{--<option>UK</option>--}}
                            {{--<option>India</option>--}}
                            {{--<option>Pakistan</option>--}}
                            {{--<option>Ucrane</option>--}}
                            {{--<option>Canada</option>--}}
                            {{--<option>Dubai</option>--}}
                            {{--</select>--}}
                            {{--<select>--}}
                            {{--<option>-- State / Province / Region --</option>--}}
                            {{--<option>United States</option>--}}
                            {{--<option>Bangladesh</option>--}}
                            {{--<option>UK</option>--}}
                            {{--<option>India</option>--}}
                            {{--<option>Pakistan</option>--}}
                            {{--<option>Ucrane</option>--}}
                            {{--<option>Canada</option>--}}
                            {{--<option>Dubai</option>--}}
                            {{--</select>--}}
                            {{--<input type="password" placeholder="Confirm password" />--}}
                            {{--<input type="text" placeholder="Phone *" />--}}
                            {{--<input type="text" placeholder="Mobile Phone" />--}}
                            {{--<input type="text" placeholder="Fax" />--}}
                            {{--</form>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <form action="{{route('save.order')}}" method="post">
                            <div class="order-message">
                                <p>Коментар (необов'язково)</p>
                                <textarea
                                        name="comment"
                                        placeholder="Напишіть коментар стосовно доставки/замовлення...."
                                        rows="16"
                                ></textarea>
                            </div>
                            <button type="submit" class="btn btn-default check_out">Перейти до сплати</button>
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
            let delivery = $('.delivery').text().split('₴');
            $('.total-price').text("₴" + (subtotal + parseInt(delivery[1])));

        });
        </script>
    @endsection