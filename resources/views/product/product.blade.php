@extends('layouts.main')

@section('content')

    <section>
        <div class="container product-container">
            <div class="row">
                <div class="col-sm-3">

                   @include('parts.sidebar')

                </div>
                <div class="col-sm-9 padding-right">
                    <div class="product-details">
                        <div class="col-sm-7 product-images">
                            <div class="view-product">
                                <img class="main-product-img" src="/images/preview-images/{{$product->preview_img_url}}" alt="" />
                            </div>
                            @if(count($product->images)> 0)
                            <div id="similar-product"class="carousel slide"data-ride="carousel">
                                <div class="carousel-inner">
                                    @if(count($product->images) < 5)
                                    <div class="item active">
                                            @for($i = 0; $i < count($product->images); $i++)
                                                <img class="product-img product-img-item" src="/images/product-details/{{$product->images[$i]['url']}}" alt=""/>
                                            @endfor
                                    </div>
                                    @else
                                        <div class="item active">
                                            @for($i = 0; $i < 4; $i++)
                                                <img class="product-img product-img-item" src="/images/product-details/{{$product->images[$i]['url']}}" alt=""/>
                                            @endfor
                                        </div>
                                        <div class="item">
                                            @for($i = 4; $i < count($product->images); $i++)
                                                <img class="product-img product-img-item" src="/images/product-details/{{$product->images[$i]['url']}}" alt=""/>
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
                                        src="/images/product-details/new.jpg"
                                        class="newarrival"
                                        alt=""
                                />
                                @endif
                                <h2><b>{{$product->name}}</b></h2>
                                <p class="product-id" id="{{$product->id}}">ID: {{$product->id}}</p>
                                <span class="product-price">₴{{$product->price}}</span>
                                <p><b>Наявність:</b>{{$product->in_stock ? " У наявності": "Немає у наявності"}}</p>
                                <p><b>Бренд: </b>{{$product->brands['name']}}</p>
                                <p><b>Колір: </b>{{$product->colors['name']}}</p>
                                    <p><b>Матеріал: </b>
                                    @foreach($product->materials as $material)
                                        {{$material->name}},
                                    @endforeach
                                    </p>
                                <p><b>Наявні розміри: </b></p>
                                <div class="sizes">
                                    @foreach($product->sizes as $size)
                                    <div class="size-item">
                                        <p>{{$size->name}}</p>
                                    </div>
                                        @endforeach
                                </div>
                                <span>
                                    <label class="quantity-title">Кількість:</label>
                                     <input type="text" class="quantity" name="quantity"  value="1"/>
                                        <button type="submit" class="btn btn-fefault cart" {{empty($product->sizes[0]['name']) || !isset($user) ? "disabled" : ""}}><i class="fa fa-shopping-cart" ></i> До кошику </button>
                                </span>

                            </div>
                        </div>
                    </div>

                    <div class="category-tab shop-details-tab">
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#details" data-toggle="tab">Опис</a></li>
                            </ul>
                        </div>


                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="details">
                                <div class="col-sm-12">
                                    <p> {{$product->description}}</p>
                                </div>
                            </div>
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
                                        <div class="col-sm-4">
                                            <div class="product-image-wrapper">
                                                <!--single product-->
                                                <div class="single-products">
                                                    <div class="productinfo text-center">
                                                        <a class="product-single" href="{{route('show.product.details',[$group->seo_name, $item->categories['seo_name'], $item->subCategories['seo_name'],$item->seo_name ])}}">
                                                            <img src="/images/preview-images/{{$item->preview_img_url}}" alt="" />
                                                            <h4>₴{{$item->price}}</h4>
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
    <script>
        $('.product-img-item').click(function () {
            $('.main-product-img').attr('src', $(this).attr('src'));
        });


        $('.size-item').click(function () {
            $('.sizes').find('.active-size').removeClass("active-size");
            $('.sizes').find('p').css("color", "#696763");
            $(this).addClass("active-size");
            $(this).find('p').css("color", "#fff");
        });


        $('.btn-fefault').click(function () {
            let productId = $('.product-id').attr('id');
            let userId =  $('.quantity').attr('id');
            let productCount = $('.quantity').val();
            let productSize =  $('.sizes').find('.active-size').find('p').text();

            if(isNaN(parseInt(productSize))){
                productSize = $('.sizes').find('p').text();
            }

            $(this).text("Додано до кошику!");
            $(".cart").addClass("added");

            function btn() {
                $(".cart").removeClass("added");
                $('.btn-fefault').append('<i class="fa fa-shopping-cart" ></i>').text(" До кошику ")
            }

            setTimeout(btn, 1000);

            if ( productId > 0 ){
                $.ajax({
                    url: "{{route('show.product.details', [$group->seo_name, $category->seo_name, $sub_category->seo_name, $product->seo_name])}}" ,
                    type: "GET",
                    data: {
                        productId: productId,
                        productCount: productCount,
                        productSize: parseInt(productSize)
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) =>{}
                });
            }
        })


    </script>
    @endsection