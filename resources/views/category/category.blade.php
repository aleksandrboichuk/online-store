@extends('layouts.main')
@section('content')

    <section id="advertisement">
        <div class="container">
        </div>
    </section>

    <section class="products-section">
        <div class="container">
            <div class="row">

                <!--sidebar-->
              @include('parts.sidebar')

                <!--products-->
                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">{{$category->title}}</h2>
                    </div>
                    @include('parts.filters')
                    <div class="row">
                        <div class="products">
                            @foreach($category_products as $item)
                                <div class="col-xs-9 col-sm-9 col-md-6 col-lg-4 product">
                                    <div class="product-image-wrapper">

                                        <!--single product-->
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <a class="product-single" href="{{route('show.product.details',[$group->seo_name, $item->categories['seo_name'], $item->subCategories['seo_name'],$item->seo_name ])}}">
                                                    <img src="/images/preview-images/{{$item->preview_img_url}}" alt="" />
                                                    @if(isset($item->discount) && !empty($item->discount))
                                                        <div class="product-single-prices">
                                                            <span class="product-single-old-price">₴{{$item->price}}</span>
                                                            <span class="product-single-discount">₴{{$item->price - (round($item->price * ($item->discount * 0.01)))}}</span>
                                                        </div>
                                                    @else
                                                        <h4>₴{{$item->price}}</h4>
                                                    @endif
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
                                    <div class="col-sm-9">
                                        {{$category_products->appends(request()->query())->links('parts.pagination')}}
                                    </div>
                                </div>
                        </div>
                    <!--end products-->
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('custom-js')
    <script src="/js/ajax-filters.js"></script>
    <script>
        indexAjax("{{route('show.category', [$group->seo_name, $category->seo_name])}}");
    </script>
@endsection