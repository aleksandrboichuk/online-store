@extends('layouts.main')

@section('content')


    <section class="form-add">
        <div class="container">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="review-payment">
                    <h2>Перегляд товарів замовлення</h2>
                </div>
                <div class="table-responsive admin-table-index">
                    <table class="table table-condensed">
                        <thead>
                        <tr class="admin_menu">
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
                                    <a href=""><img src="/images/preview-images/{{$i->product->preview_img_url}}" alt="" /></a>
                                </td>
                                <td class="cart_description">
                                    <h4><a href="">{{$i->name}}</a></h4>
                                    <p class="product-id">ID: {{$i->id}}</p>
                                </td>
                                @if(isset($i->product->discount) && !empty($i->product->discount))
                                    <td class="cart_price">
                                        <p><s>₴{{$i->product->price}}</s></p>
                                        <p>₴{{$i->product->price - (round($i->product->price * ($i->product->discount * 0.01)))}}</p>
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
                                @if(isset($i->discount) && !empty($i->discount))
                                    <td class="cart_total">
                                        <p class="cart_total_price"><b>₴{{$i->count * ($i->price - (round($i->price * ($i->discount * 0.01))))}}</b></p>
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
                    <input type="hidden" name="id" value="{{$order->id}}">
                    <div class="add-block">
                        <label for="id-field">ID користувача</label>
                        <p>{{$order->user_id}}</p>
                    </div>
                    <div class="add-block">
                        <label for="name-field">Ім'я </label>
                        <p>{{$order->name}}</p>
                    </div>
                    <div class="add-block">
                        <label for="email-field">Ел. пошта </label>
                        <p>{{$order->email}}</p>
                    </div>
                    <div class="add-block">
                        <label for="phone-field">Телефон </label>
                        <p>{{$order->phone}}</p>
                    </div>
                    <div class="add-block">
                        <label for="address-field">Адреса </label>
                        <p>{{$order->address}}</p>
                    </div>
                    <div class="add-block">
                        <label for="comment-field">Коментар </label>
                        <p>{{isset($order->comment) ? $order->comment : "-"}}</p>
                    </div>
                    <div class="add-block">
                        <label for="sum-field">Сума </label>
                        <p>₴{{$order->total_cost}}</p>
                    </div>
                    <div class="add-block">
                        <label for="status-field">Статус </label>
                        <p>{{$status}}</p>
                    </div>
                <a href="/personal/orders"><button type="button" class="btn btn-default todo-btn">Назад</button></a>
            </div>
            <div class="col-sm-1"></div>
        </div>
    </section>

@endsection