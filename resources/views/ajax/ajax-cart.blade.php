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
        <td class="cart_price">
            <p>${{$item->price}}</p>
        </td>
        <td class="cart_quantity">
            <div class="cart_quantity_button">
                <input
                        onkeyup="this.value = this.value.replace(/[^\d]/g,'');"
                        class="cart_quantity_input"
                        type="text"
                        name="quantity"
                        value="{{$item->carts()->pluck('count')[0]}}"
                        autocomplete="off"
                        size="2"
                        id="{{$item->id}}"
                />
            </div>
        </td>
        <td class="cart_total">
            <p class="cart_total_price">${{$item->carts()->pluck('count')[0] * $item->price}}</p>
        </td>
        <td class="cart_delete">
            <button type="submit" class="btn btn-danger"><svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                    <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                </svg></button>

        </td>
    </tr>
@endforeach

@section('custom-js')
    <script>
        $('.btn-danger').click(function () {
            let deleteIdd = $('.cart_quantity_input').attr('id');

            if (( deleteIdd > 0 )){
                $.ajax({
                    url: "{{route('show.cart', [$user->id])}}"  ,
                    type: "GET",
                    data: {
                        deleteId: deleteIdd,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) =>{
                        $('.cart-table').html(data)
                    }

                });
            }
        })
    </script>
@endsection

