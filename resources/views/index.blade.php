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

    <section>
        <div class="container">
            <div class="row">

                <!--start sidebar-->

                @include('parts.sidebar')

                <!--end sidebar-->

                <!-- start products-->

                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">Популярні товари @if($group->name == "Women") для жінок@elseif($group->name == "Men") для чоловіків@else для дітей@endif
                        </h2>
                    </div>
                    @include('parts.filters')
                    <div class="products">
                        @foreach($group_products as $item)
                            <div class="col-sm-4 product">
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
                            <div class="row">
                                <div class="col-sm-9">
                                    {{$group_products->appends(request()->query())->links('parts.pagination')}}
                                </div>
                            </div>
                    </div>
                    </div>
                </div>

            </div>
    </section>
@endsection

@section('custom-js')
    <script>
        $(document).ready(function() {

            $(document).mouseup( function(e){
                var div = $( ".filter-item" );
                if ( !div.is(e.target)
                    && div.has(e.target).length === 0 ) {
                    div.find('.fil-params').removeClass('fil-active');
                }
            });

            let color = document.querySelectorAll('.color');
            let brand = document.querySelectorAll('.brand');
            let material = document.querySelectorAll('.material');
            let season = document.querySelectorAll('.season');
            let size = document.querySelectorAll('.size');
            var brands  = "" , colors  = "" , materials  = "", seasons  = "", sizes  = "";

            $('.color').find('input[type="checkbox"]').change(function () {
                $('.color').find('input[type="checkbox"]').not(this).prop('checked', false);
            });

            $('.brand').find('input[type="checkbox"]').change(function () {
                $('.brand').find('input[type="checkbox"]').not(this).prop('checked', false);
            });

            $('.material').find('input[type="checkbox"]').change(function () {
                $('.material').find('input[type="checkbox"]').not(this).prop('checked', false);
            });
            $('.season').find('input[type="checkbox"]').change(function () {
                $('.season').find('input[type="checkbox"]').not(this).prop('checked', false);
            });
            $('.size').find('input[type="checkbox"]').change(function () {
                $('.size').find('input[type="checkbox"]').not(this).prop('checked', false);
            });

            $('.btn-info').click(function () {
                /* colors array */
                for (let i = 0; i < color.length; i++) {
                    if (color[i].firstChild.checked) {
                        colors = color[i].textContent;
                    }
                }
                /* brands array */

                for (let i = 0; i < brand.length; i++) {
                    if (brand[i].firstChild.checked) {
                        brands = brand[i].textContent;
                    }
                }

                /* materials array */
                for (let i = 0; i < material.length; i++) {
                    if (material[i].firstChild.checked) {
                        materials = material[i].textContent;
                    }
                }

                /* sizes array */
                for (let i = 0; i < size.length; i++) {
                    if (size[i].firstChild.checked) {
                        sizes = size[i].textContent;
                    }
                }
                /* seasons array */
                for (let i = 0; i < season.length; i++) {
                    if (season[i].firstChild.checked) {
                        seasons = season[i].textContent;
                    }
                }

                if ((colors != "") || (brands != "") || (materials != "")  || (seasons != "")  || (sizes != "") ){
                    $.ajax({
                        url: "{{route('index', $group->seo_name)}}"  ,
                        type: "GET",
                        data: {
                            colors: colors,
                            brands: brands,
                            materials: materials,
                            seasons: seasons,
                            sizes: sizes,
                            // countries: countries
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: (data) =>{
                            $('.products').html(data)
                        }

                    });
                }

            })
        })
    </script>
@endsection