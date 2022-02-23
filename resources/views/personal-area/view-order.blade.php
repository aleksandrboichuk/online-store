@extends('layouts.main')

@section('content')


    <section class="form-add">
        <div class="container">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
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
                        </tr>
                        </thead>
                        <tbody class="cart-table">

                        @foreach($items as $i)
                            <tr>
                                <td class="cart_product">
                                    <a href=""><img src="/images/preview-images/{{$i->product->preview_img_url}}" alt="" /></a>
                                </td>
                                <td class="cart_description">
                                    <h4><a href="">{{$i->product->name}}</a></h4>
                                    <p class="product-id">ID: {{$i->product->id}}</p>
                                </td>
                                <td class="cart_price">
                                    <p><b>₴{{$i->product->price}}</b></p>
                                </td>
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
                        <p>{{$order->comment}}</p>
                    </div>
                    <div class="add-block">
                        <label for="sum-field">Сума </label>
                        <p>₴{{$order->total_cost}}</p>
                    </div>
                    <div class="add-block">
                        <label for="status-field">Статус </label>
                        <p>{{$status}}</p>
                    </div>
                <a href="/personal/orders"><button type="button" class="btn btn-warning">Назад</button></a>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </section>

@endsection