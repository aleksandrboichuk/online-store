@extends('layouts.main')
@foreach($products as $item)
    <tr>
        <td class="cart_product">
            <a href=""><img src="/images/preview-images/{{$item->preview_img_url}}" alt="" /></a>
        </td>
        <td class="cart_description">
            <h4><a href="">{{$item->name}}</a></h4>
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
        @if($item->discount != 0 )
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


