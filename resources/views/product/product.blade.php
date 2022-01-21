@extends('layouts.main')

@section('content')

    <section>
        <div class="container product-container">
            <div class="row">
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
                        <h2>Категорії</h2>
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
                            <h2>Бренди</h2>
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
                        <div class="brands_products">
                            <h2>Кольори</h2>
                            <div class="brands-name">
                                <ul class="nav nav-pills nav-stacked">
                                    @if(!empty($colors))
                                        @foreach($colors as $color)
                                            <li>
                                                <a href="#"> <span class="pull-right">()</span><strong>{{$color->name}}</strong></a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-sm-9 padding-right">
                    <div class="product-details">
                        <div class="col-sm-5">
                            <div class="view-product">
                                <img src="/images/preview-images/{{$product->preview_img_url}}" alt="" />
                                <h3>ZOOM</h3>
                            </div>
                            <div
                                    id="similar-product"
                                    class="carousel slide"
                                    data-ride="carousel"
                            >
                                <div class="carousel-inner">
                                    <div class="item active">
                                        <a href=""
                                        ><img src="/images/product-details/similar1.jpg" alt=""
                                            /></a>
                                        <a href=""
                                        ><img src="/images/product-details/similar2.jpg" alt=""
                                            /></a>
                                        <a href=""
                                        ><img src="/images/product-details/similar3.jpg" alt=""
                                            /></a>
                                    </div>
                                    <div class="item">
                                        <a href=""
                                        ><img src="/images/product-details/similar1.jpg" alt=""
                                            /></a>
                                        <a href=""
                                        ><img src="/images/product-details/similar2.jpg" alt=""
                                            /></a>
                                        <a href=""
                                        ><img src="/images/product-details/similar3.jpg" alt=""
                                            /></a>
                                    </div>
                                    <div class="item">
                                        <a href=""
                                        ><img src="/images/product-details/similar1.jpg" alt=""
                                            /></a>
                                        <a href=""
                                        ><img src="/images/product-details/similar2.jpg" alt=""
                                            /></a>
                                        <a href=""
                                        ><img src="/images/product-details/similar3.jpg" alt=""
                                            /></a>
                                    </div>
                                </div>

                                <a
                                        class="left item-control"
                                        href="#similar-product"
                                        data-slide="prev"
                                >
                                    <i class="fa fa-angle-left"></i>
                                </a>
                                <a
                                        class="right item-control"
                                        href="#similar-product"
                                        data-slide="next"
                                >
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="product-information">
                                <img
                                        src="/images/product-details/new.jpg"
                                        class="newarrival"
                                        alt=""
                                />
                                <h2>{{$product->name}}</h2>
                                <p>Web ID: {{$product->id}}</p>
                                <img src="/images/product-details/rating.png" alt="" />
                                <span>
                    <span>${{$product->price}}</span>
                    <label>Quantity:</label>
                    <input type="text" value="3" />
                    <button type="button" class="btn btn-fefault cart">
                      <i class="fa fa-shopping-cart"></i>
                      Add to cart
                    </button>
                  </span>
                                <p><b>Availability:</b> In Stock</p>
                                <p><b>Condition:</b> New</p>
                                <p><b>Brand: </b>{{$product->brands['name']}}</p>
                                <p><b>Color: </b>{{$product->colors['name']}}</p>
                                <a href=""
                                ><img
                                            src="/images/product-details/share.png"
                                            class="share img-responsive"
                                            alt=""
                                    /></a>
                            </div>
                        </div>
                    </div>

                    {{--details/reviews--}}
                    <div class="category-tab shop-details-tab">
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <li><a href="#details" data-toggle="tab">Details</a></li>
                                <li class="active">
                                    <a href="#reviews" data-toggle="tab">Reviews (5)</a>
                                </li>
                            </ul>
                        </div>


                        <div class="tab-content">
                            <div class="tab-pane fade" id="details">
                                <div class="col-sm-12">
                                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                        sed do eiusmod tempor incididunt ut labore et dolore magna
                                        aliqua.Ut enim ad minim veniam, quis nostrud exercitation
                                        ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat.Duis aute irure dolor in reprehenderit in
                                        voluptate velit esse cillum dolore eu fugiat nulla
                                        pariatur.</p>
                                </div>
                            </div>




                            <div class="tab-pane fade active in" id="reviews">
                                <div class="col-sm-12">
                                    <ul>
                                        <li>
                                            <a href=""><i class="fa fa-user"></i>EUGEN</a>
                                        </li>
                                        <li>
                                            <a href=""><i class="fa fa-clock-o"></i>12:41 PM</a>
                                        </li>
                                        <li>
                                            <a href=""
                                            ><i class="fa fa-calendar-o"></i>31 DEC 2014</a
                                            >
                                        </li>
                                    </ul>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                        sed do eiusmod tempor incididunt ut labore et dolore magna
                                        aliqua.Ut enim ad minim veniam, quis nostrud exercitation
                                        ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat.Duis aute irure dolor in reprehenderit in
                                        voluptate velit esse cillum dolore eu fugiat nulla
                                        pariatur.
                                    </p>
                                    <p><b>Write Your Review</b></p>
                                    <form action="#">
                      <span>
                        <input type="text" placeholder="Your Name" />
                        <input type="email" placeholder="Email Address" />
                      </span>
                                        <textarea name=""></textarea>
                                        <b>Rating: </b>
                                        <img src="/images/product-details/rating.png" alt="" />
                                        <button type="button" class="btn btn-default pull-right">
                                            Submit
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="recommended_items">
                        <h2 class="title text-center">recommended items</h2>
                        <div
                                id="recommended-item-carousel"
                                class="carousel slide"
                                data-ride="carousel"
                        >
                            <div class="carousel-inner">
                                <div class="item active">

                                    @foreach($recommended_products as $item)
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
                                </div>
                            </div>
                            <a
                                    class="left recommended-item-control"
                                    href="#recommended-item-carousel"
                                    data-slide="prev"
                            >
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a
                                    class="right recommended-item-control"
                                    href="#recommended-item-carousel"
                                    data-slide="next"
                            >
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




@endsection
