@extends('layouts.main')
@section('content')

    <section id="advertisement">
        <div class="container">
            <img src="images/shop/advertisement.jpg" alt="" />
        </div>
    </section>

@dd($products)

    <section>
        <div class="container">
            <div class="row">

                <!--sidebar-->
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
                                                        {{--{{route('show.sub.category',[$group->seo_name, $category->seo_name,$single_sub_cat->seo->name])}}--}}
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

                <!--products-->
                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">{{$category->title}}</h2>
                        @foreach($category_products as $item)
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

                                                <a href="#"><i class="fa fa-eye"></i>До обраного</a>
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