@foreach($products as $item)
    <tr>
        <td class="product-col">
            <img src="/images/products/{{$item->id}}/preview/{{$item->preview_img_url}}" alt="">
            <div class="pc-title">
                <h4><a href="{{$item->url}}">{{$item->name}}</a></h4>
                @if($item->discount != 0)
                    <s>₴{{$item->price}}</s>
                    <p>₴{{$item->getProductPriceWithDiscount()}}</p>
                @else
                    <p>₴{{$item->price}}</p>
                @endif
            </div>
        </td>
        <td class="quy-col">
            <div class="quantity-group">
                <input type="button" class="quantity-minus" value="-">
                <input type="hidden" name="size" id="size" value="{{$item->pivot->size}}">
                <input type="text" class="quantity" name="quantity"  value="{{$item->pivot->product_count}}" id="{{$item->id}}"  autocomplete="off" readonly />
                <input type="button"  class="quantity-plus" value="+">
            </div>
        </td>
        <td class="size-col"><h4>{{$item->pivot->size}}</h4></td>
        <td class="total-col"><h4>
                @if($item->discount != 0)
                    ₴{{$item->pivot->product_count * $item->getProductPriceWithDiscount()}}
                @else
                    ₴{{$item->pivot->product_count * $item->price}}
                @endif
            </h4></td>
        <td class="del-col">
            <form action="{{route('delete.from.cart')}}" method="post">
                @csrf
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
