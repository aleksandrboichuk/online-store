@if(isset($products[0]) && !empty($products[0]))
    @foreach($products as $item)
        <div class="col-sm-4">
            <div class="product-image-wrapper">

                <!--single product-->
                <div class="single-products">
                    <div class="productinfo text-center">
                        <a class="product-single" href="{{route('show.product.details',[$group->seo_name, $item->categories['seo_name'], $item->subCategories['seo_name'],$item->seo_name ])}}">
                            <img src="/images/preview-images/{{$item->preview_img_url}}" alt="" />
                            <h4>${{$item->price}}</h4>
                            <h5><strong>{{$item->brands['name']}}</strong> / {{$item->name}}</h5>
                        </a>
                        <span class="sizes-info"><strong>Розміри:</strong>
                            @foreach($item->sizes as $s)
                                {{ $s->name}};
                            @endforeach
                        </span>
                    </div>
                </div>
                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                        <li>
                            <a href="{{route('show.product.details',[$group->seo_name, $item->categories['seo_name'], $item->subCategories['seo_name'],$item->seo_name ])}}"><i class="fa fa-star"></i> Переглянути</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    @endforeach
    <div class="row">
        <div class="col-sm-12">
            {{$products->appends(request()->query())->links('parts.pagination')}}
        </div>
    </div>
@else
    <div class="col-sm-9 no-found">
      Вибачте, за вашим запитом товари не знайдені.
    </div>
@endif
<!--end products-->