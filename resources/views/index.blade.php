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
                            <li
                                    data-target="#slider-carousel"
                                    data-slide-to="0"
                                    class="active"></li>
                            <li data-target="#slider-carousel" data-slide-to="1"></li>
                            <li data-target="#slider-carousel" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="col-sm-12">
                                    <img
                                            src="/images/home/slide1.jpg"
                                            class="girl img-responsive"
                                            alt=""
                                    />
                                    <img src="/images/home/pricing.png" class="pricing" alt="" />
                                    <div class="slider-text">
                                        <h3>Скидки</h3>
                                        <p>Lorem ipsum — классический текст-«рыба». Является искажённым отрывком из философского трактата Марка Туллия Цицерона «О пределах добра и зла», написанного в 45 году до н. э. на латинском языке, обнаружение сходства приписывается Ричарду МакКлинтоку</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-sm-12">
                                    <img
                                            src="/images/home/slide2.jpg"
                                            class="girl img-responsive"
                                            alt=""
                                    />
                                    <img src="/images/home/pricing.png" class="pricing" alt="" />
                                    <div class="slider-text">
                                        <h3>Скидки</h3>
                                        <p>Lorem ipsum — классический текст-«рыба». Является искажённым отрывком из философского трактата Марка Туллия Цицерона «О пределах добра и зла», написанного в 45 году до н. э. на латинском языке, обнаружение сходства приписывается Ричарду МакКлинтоку</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a
                                href="#slider-carousel"
                                class="left control-carousel hidden-xs"
                                data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a
                                href="#slider-carousel"
                                class="right control-carousel hidden-xs"
                                data-slide="next">
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
                    <h2>Fast Secure Payments</h2>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="feature-inner orange">
                    <div class="feature-icon">
                        <img src="/images/home/fitem2.png" alt="">
                    </div>
                    <h2>Premium Products</h2>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="feature-inner">
                    <div class="feature-icon">
                        <img class="pull-left" src="/images/home/fitem3.png" alt="">

                    </div>
                    <h2>Free & fast Delivery</h2>
                </div>
            </div>
        </div>
    </section>
    <!--start content-->

    <section>
        <div class="container">
            <div class="row">

                <!--start sidebar-->

                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Ціна</h2>
                        <div class="price-range">

                            <div class="well text-center">
                                <input
                                        type="text"
                                        class="span2"
                                        value=""
                                        data-slider-min="0"
                                        data-slider-max="600"
                                        data-slider-step="5"
                                        data-slider-value="[250,450]"
                                        id="sl2"
                                /><br />
                                <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
                            </div>
                        </div>
                        <h2>Category</h2>
                        <div class="panel-group category-products" id="accordian">

                            @foreach($group_categories as $group_category)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a
                                                data-toggle="collapse"
                                                data-parent="#accordian"
                                                href="#{{$group_category->name}}">
                                            @if(count($group_category->subCategories)>0)
                                                <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                                <a href="{{route('show.category',[$group->seo_name, $group_category->seo_name])}}"><strong>{{$group_category->name}}</strong></a>
                                                @else
                                              <s>{{$group_category->name}}</s>
                                            @endif
                                        </a>
                                    </h4>
                                </div>
                                @if(count($group_category->subCategories)>0)
                                <div id="{{$group_category->name}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul>
                                            @foreach($group_category->subCategories as $single_sub_cat)
                                               <li><a href="{{route('show.sub.category',[$group->seo_name, $group_category->seo_name,$single_sub_cat->seo_name])}}">{{$single_sub_cat->name}}<span class="pull-right">()</span></a></li>
                                             @endforeach
                                        </ul>
                                    </div>
                                </div>
                                 @endif
                            </div>
                            @endforeach


                        </div>
                        <div class="brands_products">
                            <h2>Brands</h2>
                            <div class="brands-name">
                                <ul class="nav nav-pills nav-stacked">
                                    @if(!empty($brands))
                                    @foreach($brands as $brand)
                                        <li>
                                            <a href="#"> <span class="pull-right">()</span><strong>{{$brand->name}}</strong></a>
                                        </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                <!--end sidebar-->



                <!-- start products-->

                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">Популярні товари</h2>
                        @foreach($group_products as $item)
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
                <!--end products-->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection