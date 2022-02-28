@extends('layouts.main')

@section('content')
    <section id="slider">
        <div class="container-sm">
            <div class="row">
                <div class="col-sm-12">

                    <div
                            id="slider-carousel"
                            class="carousel slide"
                            data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach($banners as $key => $value)
                                @if($key == 0)
                                <li data-target="#slider-carousel" data-slide-to="{{$value->id-1}}" class="active"></li>
                                @else
                                 <li data-target="#slider-carousel" data-slide-to="{{$value->id-1}}"></li>
                                @endif
                            @endforeach
                                <li data-target="#slider-carousel" style="visibility: hidden" data-slide-to="{{$value->id}}"></li>
                        </ol>
                        <div class="carousel-inner">
                            @foreach($banners as $key => $value)
                                @if($key == 0)
                                    <div class="item active">
                                        <div class="col-sm-12">
                                            <img src="/images/home/{{$value->image_url}}" class="girl img-responsive" alt="" />
                                            @if(isset($value->mini_img_url) && !empty($value->mini_img_url))
                                            <img src="/images/home/{{$value->mini_img_url}}" class="pricing" alt="" />
                                            @endif
                                            <div class="slider-text">
                                                <h3>{{$value->title}}</h3>
                                                <p>{{$value->description}}</p>
                                                {{--<button type="button" class="btn btn-warning"><a href="{{$value->details_url}}">Додати</a></button>--}}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="item">
                                        <div class="col-sm-12">
                                            <img src="/images/home/{{$value->image_url}}" class="girl img-responsive" alt="" />
                                            @if(isset($value->mini_img_url) && !empty($value->mini_img_url))
                                                <img src="/images/home/{{$value->mini_img_url}}" class="pricing" alt="" />
                                            @endif
                                            <div class="slider-text">
                                                <h3>{{$value->title}}</h3>
                                                <p>{{$value->description}}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!--end slider-->
    <section class="features-section">
        <div class="row">
            <div class="col-sm-4">
                <div class="feature-inner">
                    <div class="feature-icon">
                        <img src="/images/home/fitem1.png" alt="">
                    </div>
                    <h2>Швидкі та безпечні платежі</h2>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="feature-inner orange">
                    <div class="feature-icon">
                        <img src="/images/home/fitem2.png" alt="">
                    </div>
                    <h2><b>Преміум товари</b></h2>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="feature-inner">
                    <div class="feature-icon">
                        <img class="pull-left" src="/images/home/fitem3.png" alt="">

                    </div>
                    <h2>Безкоштовна доставка</h2>
                </div>
            </div>
        </div>
    </section>
    <!--start content-->

    <section class="products-section">
        <div class="container">
            <div class="row">

                <!--start sidebar-->

                @include('parts.sidebar')

                <!--end sidebar-->

                <!-- start products-->

                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">Популярні товари @if($group->seo_name == "women") для жінок@elseif($group->seo_name == "men") для чоловіків@elseif($group->seo_name == "girls") для дівчаток@else для хлопчиків@endif
                        </h2>
                    </div>
                    @include('parts.filters')
                    <div class="row">
                        <div class="products">
                            @foreach($group_products as $item)
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
                                                    <a href="{{route('show.product.details',[$group->seo_name, $item->categories['seo_name'], $item->subCategories['seo_name'],$item->seo_name ])}}"><i class="fa fa-eye"></i> Переглянути</a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                                <div class="row pagination-block">
                                    <div class="col-sm-9">
                                        {{$group_products->appends(request()->query())->links('parts.pagination')}}
                                    </div>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>

            </div>
    </section>
@endsection

@section('custom-js')
    <script src="/js/ajax-filters.js"></script>
    <script>
        indexAjax("{{route('index', $group->seo_name)}}");
    </script>
@endsection