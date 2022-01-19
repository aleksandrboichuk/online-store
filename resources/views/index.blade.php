@extends('layouts.main')
@section('content')
    <section id="slider">
        <div class="container">
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
                                <div class="col-sm-6">
                                    <h1><span>E</span>-SHOPPER</h1>
                                    <h2>Free E-Commerce Template</h2>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                        sed do eiusmod tempor incididunt ut labore et dolore magna
                                        aliqua.
                                    </p>
                                    <button type="button" class="btn btn-default get">
                                        Get it now
                                    </button>
                                </div>
                                <div class="col-sm-6">
                                    <img
                                            src="/images/home/girl1.jpg"
                                            class="girl img-responsive"
                                            alt=""
                                    />
                                    <img src="/images/home/pricing.png" class="pricing" alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-sm-6">
                                    <h1><span>E</span>-SHOPPER</h1>
                                    <h2>100% Responsive Design</h2>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                        sed do eiusmod tempor incididunt ut labore et dolore magna
                                        aliqua.
                                    </p>
                                    <button type="button" class="btn btn-default get">
                                        Get it now
                                    </button>
                                </div>
                                <div class="col-sm-6">
                                    <img
                                            src="/images/home/girl2.jpg"
                                            class="girl img-responsive"
                                            alt=""
                                    />
                                    <img src="/images/home/pricing.png" class="pricing" alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-sm-6">
                                    <h1><span>E</span>-SHOPPER</h1>
                                    <h2>Free Ecommerce Template</h2>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                        sed do eiusmod tempor incididunt ut labore et dolore magna
                                        aliqua.
                                    </p>
                                    <button type="button" class="btn btn-default get">
                                        Get it now
                                    </button>
                                </div>
                                <div class="col-sm-6">
                                    <img
                                            src="/images/home/girl3.jpg"
                                            class="girl img-responsive"
                                            alt=""
                                    />
                                    <img src="/images/home/pricing.png" class="pricing" alt="" />
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

    <!--start content-->

    <section>
        <div class="container">
            <div class="row">

                <!--start sidebar-->

                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <div class="price-range">
                            <h2>Ціна</h2>
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
                            @foreach($group_categories as $category)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a
                                                data-toggle="collapse"
                                                data-parent="#accordian"
                                                href="#{{$category->name}}">
                                            @if(count($category->subCategories)>0) <span class="badge pull-right"><i class="fa fa-plus"></i></span> @endif
                                            {{$category->name}}
                                        </a>
                                    </h4>
                                </div>
                                @if(count($category->subCategories)>0)
                                <div id="{{$category->name}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul>
                                            @foreach($category->subCategories as $single_sub_cat)
                                               <li><a href="#">{{$single_sub_cat->name}}</a></li>
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
                                            <a href="#"> <span class="pull-right">()</span>{{$brand->name}}</a>
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
                                        <img src="/images/home/{{$item->preview_img_url}}" alt="" />
                                        <h2>${{$item->price}}</h2>
                                        <h4>{{$item->name}}</h4>
                                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Додати до кошику</a>
                                    </div>
                                </div>
                                <div class="choose">
                                    <ul class="nav nav-pills nav-justified">
                                        <li>
                                            <a href="#"><i class="fa fa-plus-square"></i>Додати до обраного</a>
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