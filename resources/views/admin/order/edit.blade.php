@extends('layouts.admin')

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
                                    <p>${{$i->product->price}}</p>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <form action="{{route('save.edit.order')}}" method="post">
                    <input type="hidden" name="id" value="{{$order->id}}">
                    <div class="add-block">
                        <label for="id-field">ID користувача</label>
                        <input type="text" value="{{$order->user_id}}" name="id-field">
                    </div>
                    <div class="add-block">
                        <label for="name-field">Ім'я </label>
                        <input type="text" value="{{$order->name}}" name="name-field">
                    </div>
                    <div class="add-block">
                        <label for="email-field">Ел. пошта </label>
                        <input type="text" value="{{$order->email}}" name="email-field">
                    </div>
                    <div class="add-block">
                        <label for="phone-field">Телефон </label>
                        <input type="text" value="{{$order->phone}}" name="phone-field">
                    </div>
                    <div class="add-block">
                        <label for="address-field">Адреса </label>
                        <input type="text" value="{{$order->address}}" name="address-field">
                    </div>
                    <div class="add-block">
                        <label for="comment-field">Коментар </label>
                        <input type="text" value="{{$order->comment}}" name="comment-field">
                    </div>
                    <div class="add-block">
                        <label for="sum-field">Сума </label>
                        <input type="text" value="₴{{$order->total_cost}}" name="sum-field">
                    </div>
                    <div class="add-block">
                        <label for="status-field">Статус </label>
                        <select size="5" name="status-field" class="select-option">
                            @foreach($statuses as $status)
                                <option value="{{$status->id}}" {{$status->id == $order->statuses[0]['id'] ? "selected" : "" }}>{{$status->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning">Зберегти</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </section>

@endsection