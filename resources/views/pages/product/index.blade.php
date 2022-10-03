@extends('layouts.main')
@section('custom-css')
    <link rel="stylesheet" href="/css/jquery.fancybox.min.css">
    @endsection
@section('content')

    <section class="product-card-section">
        @if(isset($breadcrumbs))
            @include('components.breadcrumbs')
        @endif
        <div class="product-container">
            <div class="row">
                {{--<div class="col-sm-3">--}}

                   {{--@include('components.sidebar')--}}

                {{--</div>--}}
                <div class="col-sm-12 padding-right product-main-info">
                    <div class="product-details">
                        <div class="col-sm-7 product-images">
                            <div class="view-product">
                                <a id="fancybox" data-caption="{{$product->name}}" data-fancybox="my-images-1" href="/images/products/{{$product->id}}/preview/{{$product->preview_img_url}}">
                                    <img class="main-product-img" src="/images/products/{{$product->id}}/preview/{{$product->preview_img_url}}" alt="" />
                                </a>
                            </div>
                            @if(count($product->images) > 0)
                            <div id="similar-product" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @if(count($product->images) < 5)
                                    <div class="item active">
                                            <a id="fancybox" data-caption="{{$product->name}}" data-fancybox="my-images-1" href="/images/products/{{$product->id}}/preview/{{$product->preview_img_url}}">
                                                <img class="product-img product-img-item" src="/images/products/{{$product->id}}/preview/{{$product->preview_img_url}}" alt="" />
                                            </a>
                                            @for($i = 0; $i < count($product->images); $i++)
                                            <a id="fancybox" data-caption="{{$product->name}}" data-fancybox="my-images-1" href="/images/products/{{$product->id}}/details/{{$product->images[$i]['url']}}">
                                                <img class="product-img product-img-item" src="/images/products/{{$product->id}}/details/{{$product->images[$i]['url']}}" alt="" />
                                            </a>
                                            @endfor
                                    </div>
                                    @else
                                        <div class="item active">
                                            <a id="fancybox" data-caption="{{$product->name}}" data-fancybox="my-images-1" href="/images/products/{{$product->id}}/preview/{{$product->preview_img_url}}">
                                                <img class="product-img product-img-item" src="/images/products/{{$product->id}}/preview/{{$product->preview_img_url}}" alt="" />
                                            </a>
                                            @for($i = 0; $i < 4; $i++)
                                                <a id="fancybox" data-caption="{{$product->name}}" data-fancybox="my-images-1" href="/images/products/{{$product->id}}/details/{{$product->images[$i]['url']}}">
                                                    <img class="product-img product-img-item" src="/images/products/{{$product->id}}/details/{{$product->images[$i]['url']}}" alt="" />
                                                </a>
                                            @endfor
                                        </div>
                                        <div class="item">
                                            @for($i = 4; $i < count($product->images); $i++)
                                                <a id="fancybox" data-caption="{{$product->name}}" data-fancybox="my-images-1" href="/images/products/{{$product->id}}/details/{{$product->images[$i]['url']}}">
                                                    <img class="product-img product-img-item" src="/images/products/{{$product->id}}/details/{{$product->images[$i]['url']}}" alt="" />
                                                </a>
                                            @endfor
                                        </div>
                                     @endif
                                </div>
                                @if(count($product->images) > 4)
                                    <a class="left item-control" href="#similar-product" data-slide="prev" >
                                        <i class="fa fa-angle-left"></i>
                                    </a>
                                    <a class="right item-control"  href="#similar-product" data-slide="next" >
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                 @endif
                            </div>
                            @endif
                        </div>
                        <div class="col-sm-5 product-info">
                            <div class="product-information">
                                @if($product->created_at > date('Y-m-d H:i:s', strtotime('-7 days')) )
                                <img
                                        src="/images/products/additional/new.jpg"
                                        class="newarrival"
                                        alt=""
                                />
                                @endif
                                <div></div>
                                 @if(!empty($product->rating))
                                        <div class="rating">
                                     @for($i = 0; $i < intval($product->rating); $i++)
                                        <i class="fa fa-star"></i>
                                     @endfor
                                         @if(intval($product->rating) < $product->rating)
                                             <i class="fa fa-star-half-empty"></i>
                                             @if(intval($product->rating) + 1  < 5)
                                                 @for($i = intval($product->rating) + 1; $i < 5; $i++)
                                                     <i class="glyphicon glyphicon-star-empty" style="font-size:20px"></i>
                                                 @endfor
                                             @endif
                                         @else
                                             @if(intval($product->rating) < 5)
                                                 @for($i = intval($product->rating); $i < 5; $i++)
                                                     <i class="glyphicon glyphicon-star-empty" style="font-size:20px"></i>
                                                 @endfor
                                             @endif
                                         @endif
                                   <b> ({{count($product->reviews)}})</b></div>
                                 @endif
                                <h2>{{$product->name}}</h2>
                                <p class="product-id" id="{{$product->id}}">ID: {{$product->id}}</p>
                               @if($product->discount != 0)
                                        <div class="prices">
                                            <span class="product-price-old">₴{{$product->price}}</span>
                                            <h4 class="product-price-discount">₴{{$product->price - (round($product->price * ($product->discount * 0.01)))}}</h4>
                                        </div>
                                   @else
                                        <div class="product-price">₴{{$product->price}}</div>
                                   @endif
                                <div class="product-characteristics">
                                    <b>Наявність:</b>
                                    <p class="stock-status {{$stockStatus[0]}}">
                                        {{$stockStatus[1]}}
                                    </p>

                                </div>
                                    <div class="product-characteristics">
                                        <b>Бренд: </b>
                                        <p>{{$product->brands['name']}}</p>
                                    </div>
                                    <div class="product-characteristics">
                                        <b>Колір: </b>
                                        <p>{{$product->colors['name']}}</p>
                                    </div>
                                    <div class="product-characteristics">
                                        <b>Сезон: </b>
                                        <p>{{$product->seasons['name']}}</p>
                                    </div>
                                    <div class="product-characteristics">
                                        <b>Матеріал: </b>
                                        <p>
                                            @foreach($product->materials as $key => $material)
                                                {{$material->name }}{{$key+1 != count($product->materials) ? "," : "."}}
                                            @endforeach
                                        </p>
                                    </div>
                                <p><b>Наявні розміри (укр): </b></p>
                                <div class="sizes">
                                    @foreach($product->sizes as $size)
                                    <div class="size-item">
                                        <p>{{$size->name}}</p>
                                    </div>
                                        @endforeach
                                </div>
                                <div class="product-characteristics">
                                    <label class="quantity-title">Кількість:</label>
                                    <span class="input-group">
                                        <input type="button" class="btn-minus" value="-">
                                         <input type="text" class="quantity" name="quantity"  value="1" readonly />
                                        <input type="button"  class="btn-plus" value="+">
                                    </span>

                                </div>
                                <button type="submit" class="btn btn-default cart"><i class="fa fa-shopping-cart" ></i> До кошику</button>
                                <h3 class="about-product">Про товар:</h3>
                                <p>{{$product->description}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="category-tab shop-details-tab">
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#reviews" data-toggle="tab">Відгуки ({{!empty($reviews) && count($reviews) > 0 ? count($reviews) : 0}})</a>
                                </li>
                                {{--<li><a href="#details" data-toggle="tab">Details</a></li>--}}
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="reviews">
                                <div class="col-sm-12">
                                    @if(!empty($reviews) && count($reviews) > 0)
                                       <div class="reviews">
                                           @foreach($reviews as $review)
                                               <ul>
                                                   <li>
                                                       <a><i class="fa fa-user"></i>{{$review->users['first_name'] . ' ' . $review->users['last_name']}}</a>
                                                   </li>
                                                   <li>
                                                       <a><i class="fa fa-calendar-o"></i>{{date("d.m.Y - H:i", strtotime($review->created_at))}}</a>
                                                   </li>
                                               </ul>
                                               <p>
                                                   @for($i = 0; $i < $review->grade; $i++)
                                                       <i class="fa fa-star"></i>
                                                   @endfor
                                                   @if($review->grade < 5)
                                                       @for($i = $review->grade; $i < 5; $i++)
                                                               <i class="glyphicon glyphicon-star-empty" style="font-size:20px"></i>
                                                       @endfor
                                                   @endif
                                               </p>
                                              <p>
                                                   {{$review->review}}
                                               </p>
                                           @endforeach
                                       </div>
                                        {{$reviews->appends(request()->query())->links('components.pagination')}}
                                    @else
                                        <div class="no-reviews">
                                                <p>
                                                    Відгуки відсутні.
                                                </p>
                                        </div>
                                    @endif

                                    @if($user)

                                        <div class="send-review">
                                            <p class="write-review-title"><b>Залишити відгук</b></p>
                                            <form action="{{route('send.review', [$product->id])}}" method="post">
                                                <div class="grade">
                                                   <i class="fa fa-star"></i>
                                                    <select name="grade" id="grade">
                                                        <option value="5">5</option>
                                                        <option value="4">4</option>
                                                        <option value="3">3</option>
                                                        <option value="2">2</option>
                                                        <option value="1">1</option>
                                                    </select>
                                                </div>
                                                <span>
                                                <input  type="text" value="{{$user->first_name}}" readonly>
                                                <input type="email"  value="{{$user->email}}" readonly>
                                              </span>
                                                <textarea name="review" placeholder="Відгук..." required></textarea>
                                                <button type="submit" class="btn btn-default review-btn">Відправити</button>
                                            </form>
                                        </div>

                                    @endif
                                </div>
                            </div>
                            {{--<div class="tab-pane fade" id="details">--}}
                                {{--<div class="col-sm-12">--}}
                                    {{--<p> {{$product->description}}</p>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                    </div>

                    <div class="recommended_items">
                        <h2 class="title text-center">Рекомендації</h2>
                        <div
                                id="recommended-item-carousel"
                                class="carousel slide"
                                data-ride="carousel"
                        >
                            <div class="carousel-inner">
                                <div class="item active">
                                    @foreach($recommended_products as $item)
                                        @include('components.product')
                                    @endforeach
                                </div>
                            </div>
                            {{--<a--}}
                                    {{--class="left recommended-item-control"--}}
                                    {{--href="#recommended-item-carousel"--}}
                                    {{--data-slide="prev"--}}
                            {{-->--}}
                                {{--<i class="fa fa-angle-left"></i>--}}
                            {{--</a>--}}
                            {{--<a--}}
                                    {{--class="right recommended-item-control"--}}
                                    {{--href="#recommended-item-carousel"--}}
                                    {{--data-slide="next"--}}
                            {{-->--}}
                                {{--<i class="fa fa-angle-right"></i>--}}
                            {{--</a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('custom-js')
    <script src="/js/jquery.fancybox.min.js"></script>
    <script src="/js/product-single.js"></script>
    <script>
        addToCart("{{route('product', [$group->seo_name, $category->seo_name, $sub_category->seo_name, $product->seo_name])}}");
        animatePreview()
    </script>
    @endsection
