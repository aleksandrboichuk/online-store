@extends('layouts.main')

@section('content')

    <section id="personal_area">
        @if(isset($breadcrumbs))
            @include('components.breadcrumbs')
        @endif
        <div class="container personal-area-container">
            <div class="col-sm-12 col-lg-3">
                @include('components.profile-sidebar')
            </div>
            <div class="col-sm-12 col-lg-9">
                <div class="title-page-personal"><h3>Деталі замовлення</h3></div>
                <div class="table-responsive general-table-index table-view-order">
                    <table class="table table-condensed">
                        <thead>
                        <tr class="general_menu">
                            <td class="image"></td>
                            <td class="description"><b>Назва товару</b></td>
                            <td class="price"><b>Вартість</b></td>
                            <td class="select-size"><b>Розмір</b></td>
                            <td class="quantity"> <b>Кількість</b></td>
                            <td class="total"><b>Загальна вартість</b></td>
                        </tr>
                        </thead>
                        <tbody class="cart-table">

                        @foreach($items as $i)

                            <tr>
                                <td class="cart_product">
                                    <a href="{{$item->url}}"><img src="/images/products/{{$i->product->id}}/preview/{{$i->product->preview_img_url}}" alt="" /></a>
                                </td>
                                <td class="cart_description">
                                    <h4><a href="{{$item->url}}">{{$i->name}}</a></h4>
                                    <p class="product-id">ID: {{$i->product->id}}</p>
                                </td>
                                @if($i->product->discount != 0)
                                    <td class="cart_price">
                                        <p><s>₴{{$i->product->price}}</s></p>
                                        <p>₴{{$i->product->getProductPriceWithDiscount()}}</p>
                                    </td>
                                @else
                                    <td class="cart_price">
                                        <p>₴{{$i->product->price}}</p>
                                    </td>
                                @endif
                                <td class="cart_size">
                                    <p>{{$i->size}}</p>
                                </td>
                                <td class="cart_quantity">
                                    <p>{{$i->count}}</p>
                                </td>
                                @if($i->discount != 0)
                                    <td class="cart_total">
                                        <p class="cart_total_price"><b>₴{{$i->getProductPriceWithDiscount()}}</b></p>
                                    </td>
                                @else
                                    <td class="cart_total">
                                        <p class="cart_total_price"><b>₴{{$i->count * $i->price}}</b></p>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="add-block">
                    <label for="status-field">Статус </label>
                    <input type="text" value="{{$status}}" name="status-field" readonly>
                </div>
                <div class="add-block">
                    <label for="id-field">ID користувача</label>
                    <input type="text" value="{{$order->user_id}}" name="id-field" readonly>
                </div>
                <div class="add-block">
                    <label for="name-field">Ім'я </label>
                    <input type="text" value="{{$order->name}}" name="name-field" readonly>
                </div>
                <div class="add-block">
                    <label for="phone-field">Телефон </label>
                    <input type="text" value="{{$order->phone}}" name="phone-field" readonly>
                </div>
                <div class="add-block">
                    <label for="city-field">Місто </label>
                    <input type="text" value="{{$order->city}}" name="city-field" readonly>
                </div>
                @if(!empty($order->address))
                    <div class="add-block">
                        <label for="address-field">Адреса доставки кур'єром</label>
                        <input type="text" value="{{$order->address}}" name="address-field" readonly>
                    </div>
                @endif
                @if(!empty($order->post_department))
                    <div class="add-block">
                        <label for="post-field">Номер поштового відділення</label>
                        <input type="text" value="{{$order->post_department}}" name="post-field" readonly>
                    </div>
                @endif
                <div class="add-block">
                    <label for="comment-field">Коментар </label>
                    <textarea  rows="6" name="comment-field" readonly>{{isset($order->comment) ? $order->comment : ""}}</textarea>
                </div>
                <div class="add-block">
                    <label for="sum-field">Сума </label>
                    <input type="text" value="₴{{$order->total_cost}}" name="sum-field" readonly>
                </div>
                <a href="/personal/orders"><button type="button" class="btn btn-default todo-btn">Назад</button></a>
            </div>
        </div>
    </section>
@endsection
