@extends('layouts.admin')

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
                                    <a href="{{route('show.product.details', [$i->product->categoryGroups->seo_name, $i->product->categories->seo_name, $i->product->subCategories->seo_name, $i->product->seo_name])}}"><img src="/images/preview-images/{{$i->product->preview_img_url}}" alt="" /></a>
                                </td>
                                <td class="cart_description">
                                    <h4><a href="{{route('show.product.details', [$i->product->categoryGroups->seo_name, $i->product->categories->seo_name, $i->product->subCategories->seo_name, $i->product->seo_name])}}">{{$i->name}}</a></h4>
                                    <p class="product-id">ID: {{$i->product->id}}</p>
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
                        <select size="6" name="status-field" class="select-option">
                            @foreach($statuses as $status)
                                <option value="{{$status->id}}" {{$status->id == $order->statuses[0]['id'] ? "selected" : "" }}>{{$status->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-default todo-btn">Зберегти</button>
                </form>
            </div>
            <div class="col-sm-1"></div>
        </div>
    </section>

@endsection