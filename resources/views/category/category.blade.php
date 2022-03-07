@extends('layouts.main')
@section('content')


    <section class="products-section">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    @if($group->name == "Жінки")
                        <li><a href="/shop/women">Жінкам</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                        @elseif($group->name == "Чоловіки")
                        <li><a href="/shop/men">Чоловікам</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                        @elseif($group->name == "Хлопчики")
                        <li><a href="/shop/boys">Хлопчикам</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                        @elseif($group->name == "Дівчатки")
                        <li><a href="/shop/girls">Дівчаткам</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                        @endif
                    <li class="active">{{$category->title}}</li>
                </ol>
            </div>
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
                            @foreach($products as $item)
                                <div class="col-xs-9 col-sm-9 col-md-6 col-lg-4 product">
                                    <div class="product-image-wrapper">

                                        <!--single product-->
                                        <div class="single-products">
                                            @if($item->created_at > date('Y-m-d H:i:s', strtotime('-7 days')) )
                                                <img
                                                        src="/images/product-details/new.jpg"
                                                        class="newarrival"
                                                        alt=""
                                                />
                                            @endif
                                            <div class="productinfo text-center">
                                                <a class="product-single" href="{{route('show.product.details',[$group->seo_name, $item->categories['seo_name'], $item->subCategories['seo_name'],$item->seo_name ])}}">
                                                    {{--<img src="/images/preview-images/{{$item->preview_img_url}}" alt="" />--}}
                                                    <div class="img" style="background-image: url('/images/preview-images/{{$item->preview_img_url}}')" id="{{$item->preview_img_url}}">
                                                        @foreach ($images as $img)
                                                            @if($img->product_id == $item->id)
                                                                <div class="hidden-img" id="{{$img->url}}"></div>
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
                                                    <a href="{{route('show.product.details',[$group->seo_name, $item->categories['seo_name'], $item->subCategories['seo_name'],$item->seo_name ])}}"><i class="fa fa-eye"></i> Переглянути</a>
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
    <script>
        $('.hidden-img').hover(function () {
            $(this).parent().css("background-image", "url('/images/product-details/" + $(this).attr('id') +  "')")
        });
        $('.hidden-img').mouseout(function () {
            $(this).parent().css("background-image", "url('/images/preview-images/" + $(this).parent().attr('id') +  "')");
        })
    </script>
@endsection