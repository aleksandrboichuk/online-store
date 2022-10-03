@extends('layouts.admin')

@section('content')
    @if(isset($breadcrumbs))
        @include('admin.components.breadcrumbs')
    @endif

    <section class="form-add">
        <div class="container">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="review-payment">
                    <h2>Перегляд товарів замовлення</h2>
                </div>
                <div class="table-responsive general-table-index">
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
                                    <a href="{{route('product', [$i->product->categoryGroup->seo_name, $i->product->categories->seo_name, $i->product->subCategories->seo_name, $i->product->seo_name])}}"><img src="/images/products/{{$i->product->id}}/preview/{{$i->product->preview_img_url}}" alt="" /></a>
                                </td>
                                <td class="cart_description">
                                    <h4><a href="{{route('product', [$i->product->categoryGroup->seo_name, $i->product->categories->seo_name, $i->product->subCategories->seo_name, $i->product->seo_name])}}">{{$i->name}}</a></h4>
                                    <p class="product-id">ID: {{$i->product->id}}</p>
                                </td>
                                @if($i->product->discount != 0)
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
                                @if($i->discount != 0)
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
                <form action="{{route('orders.update',$order->id)}}" method="post">
                    @method('PUT')
                    <div class="add-block">
                        <label for="status">Статус </label>
                        <select required size="6" name="status" class="select-option">
                            @foreach($statuses as $status)
                                <option value="{{$status->id}}" {{$status->id == $order->status ? "selected" : "" }}>{{$status->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="id">ID користувача</label>
                        <input type="text" value="{{$order->user_id}}" name="id" readonly>
                    </div>
                    <div class="add-block">
                        <label for="name">Ім'я </label>
                        <input type="text" value="{{$order->name}}" name="name" required maxlength="20">
                    </div>
                    @if($errors->has('name'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="phone">Телефон </label>
                        <input type="text" value="{{$order->phone}}" name="phone" onkeyup="this.value = this.value.replace(/[^\d]/g,'');" required  maxlength="13">
                    </div>
                    @if($errors->has('phone'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </div>
                    @endif
                    @if(!empty($order->email))
                        <div class="add-block">
                            <label for="email">Телефон </label>
                            <input type="email" value="{{$order->email}}" name="email">
                        </div>
                        @if($errors->has('email'))
                            <div class="invalid-feedback admin-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    @endif
                    <div class="add-block">
                        <label for="city">Місто </label>
                        <input type="text" value="{{$order->city}}" name="city" required maxlength="20">
                    </div>
                    @if($errors->has('city'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('city') }}</strong>
                        </div>
                    @endif
                    @if(!empty($order->address))
                        <div class="add-block">
                            <label for="address">Адреса доставки кур'єром</label>
                            <input type="text" value="{{$order->address}}" name="address">
                        </div>
                        @if($errors->has('address'))
                            <div class="invalid-feedback admin-feedback" role="alert">
                                <strong>{{ $errors->first('address') }}</strong>
                            </div>
                        @endif
                    @endif
                    @if(!empty($order->post_department))
                        <div class="add-block">
                            <label for="post_department">Номер поштового відділення</label>
                            <input type="text" value="{{$order->post_department}}" name="post_department" maxlength="3">
                        </div>
                        @if($errors->has('post_department'))
                            <div class="invalid-feedback admin-feedback" role="alert">
                                <strong>{{ $errors->first('post_department') }}</strong>
                            </div>
                        @endif
                    @endif
                    <div class="add-block">
                        <label for="comment">Коментар </label>
                        <textarea  rows="6" name="comment" readonly>{{isset($order->comment) ? $order->comment : ""}}</textarea>
                    </div>
                    <div class="add-block">
                        <label for="total_cost">Сума (₴) </label>
                        <input type="text" value="{{$order->total_cost}}" name="total_cost" onkeyup="this.value = this.value.replace(/[^\d]/g,'');" readonly>
                    </div>
                    <button type="submit" class="btn btn-default todo-btn">Зберегти</button>
                </form>
            </div>
            <div class="col-sm-1"></div>
        </div>
    </section>

@endsection
