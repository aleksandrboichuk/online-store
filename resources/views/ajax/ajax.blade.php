@if(isset($products) && !empty($products))
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
                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>До кошику</a>
                </div>
            </div>
            <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li>

                        <a href="#"><i class="fa fa-star"></i>До обраного</a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
@endforeach
@else
    <span>...</span>
    @endif
<!--end products-->