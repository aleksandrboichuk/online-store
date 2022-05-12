<div class="col-xs-9 col-sm-9 col-md-6 col-lg-3 product">
    <div class="product-image-wrapper">

        <!--single product-->
        <div class="single-products">
            @if($item->created_at > date('Y-m-d H:i:s', strtotime('-7 days')) )
                <img
                        src="/storage/product-images/additional/new.jpg"
                        class="newarrival"
                        alt=""
                />
            @endif
            <div class="productinfo text-center">
                <a class="product-single" href="{{route('show.product.details',[$group->seo_name, $item->categories['seo_name'], $item->subCategories['seo_name'],$item->seo_name ])}}">
                    {{--<img src="/storage/product-images/preview/{{$item->preview_img_url}}" alt="" />--}}
                    <div class="img" style="background-image: url('{{'/storage/product-images/' . $item->id . '/preview/' . $item->preview_img_url}}')" id="{{$item->id .'/preview/'. $item->preview_img_url}}">
                        @foreach ($images as $img)
                            @if($img->product_id == $item->id)
                                <div class="hidden-img" id="{{$item->id .'/details/'. $img->url}}"></div>
                            @endif
                        @endforeach
                    </div>
                    @if($item->discount != 0)
                        <div class="product-single-prices">
                            <span class="product-single-old-price">₴{{$item->price}}</span>
                            <span class="product-single-discount">₴{{$item->price - (round($item->price * ($item->discount * 0.01)))}}</span>
                        </div>
                    @else
                        <h4>₴{{$item->price}}</h4>
                    @endif
                    <h5><strong>{{$item->brands['name']}}</strong> / {{$item->name}}</h5>
                </a>
                {{--<span class="sizes-info"><strong>Розміри:</strong>--}}
                    {{--@foreach($item->sizes as $key => $s)--}}
                        {{--{{ $s->name}}{{$key+1 != count($item->sizes) ? "," : "."}}--}}
                    {{--@endforeach--}}
                {{--</span>--}}
            </div>
        </div>
        <div class="choose">
            <ul class="nav nav-pills nav-justified">
                <li>
                    <a href="{{route('show.product.details',[$group->seo_name, $item->categories['seo_name'], $item->subCategories['seo_name'],$item->seo_name ])}}"><i class="fa fa-eye"></i> Детальніше</a>
                </li>
            </ul>
        </div>

    </div>
</div>