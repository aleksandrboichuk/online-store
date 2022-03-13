@extends('layouts.main')
@section('content')


    <section class="products-section">
        <div class="main-container">
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
                    <li class="active">Пошук: "{{request('q')}}"</li>
                </ol>
            </div>
            <div class="row">

                <!--sidebar-->
            @include('parts.sidebar')

            <!--products-->
                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">Результати пошуку</h2>
                    </div>
                    <div class="row">
                        <div class="col-sm-9 select-order-by filters" >
                            <select name="order-by">
                                <option value="none" selected >За замовчуванням</option>
                                <option value="discount">За знижками</option>
                                <option value="created_at">За новинками</option>
                                <option value="count">За популярністю</option>
                                <option value="price-asc">За зростанням ціни</option>
                                <option value="price-desc">За спаданням ціни</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="products">
                            @if(isset($products) && !empty($products) && count($products) > 0)
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
                                    {{$products->appends(request()->query())->links('parts.pagination')}}
                                </div>
                            </div>
                            @else
                                <div class="col-sm-12 no-found">
                                    Товари не знайдені.
                                </div>
                            @endif
                        </div>
                        <!--end products-->
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('custom-js')
    {{--<script src="/js/ajax-filters.js"></script>--}}
    {{--<script>--}}
        {{--indexAjax("{{route('show.category', [$group->seo_name, $category->seo_name])}}");--}}
    {{--</script>--}}
    <script>
        $(document).ready(function() {
            $(document).on('mouseover','.hidden-img', function () {
                $(this).parent().css("background-image", "url('/images/product-details/" + $(this).attr('id') +  "')");
            });
            $(document).on('mouseout','.hidden-img',function () {
                $(this).parent().css("background-image", "url('/images/preview-images/" + $(this).parent().attr('id') +  "')");
            });

            // pagination
            let countPage = 1;
            $('.next-page').click(function () {
                event.preventDefault();
                countPage += 1;
                let url =  location.href;
                if(countPage <= $(this).attr('id')){
                    if(url.split('?page').length > 1){
                        $.ajax({
                            url: url.split('?page')[0] + '?page=' + countPage,
                            type: "GET",
                            success: function(data){
                                $('.products').append(data)
                            }
                        });

                    }else if(url.split('&page').length > 1){
                        $.ajax({
                            url: url.split('&page')[0] + '&page=' + countPage,
                            type: "GET",
                            success: function(data){
                                $('.products').append(data)
                            }
                        });
                    }else if(url.split('?').length > 1){
                        $.ajax({
                            url: url + "&page=" + countPage,
                            type: "GET",
                            success: function(data){
                                $('.products').append(data)
                            }
                        });

                    }else {
                        $.ajax({
                            url: url.split('?page')[0] + '?page=' + countPage,
                            type: "GET",
                            success: function(data){
                                $('.products').append(data)
                            }
                        });
                    }
                }

                if(countPage == $(this).attr('id')) {
                    $(this).attr('disabled', 'disabled').css('background-color', '#6fa1f4');
                }
            });

            let full_url = location.href.split('?');
            let url = full_url[0];

            if(full_url.length > 1){
                let params = full_url[1].split('&');
                for(let i = 0; i < params.length; i++){
                    var filterParams = params[i].split('=');
                    var filterValues = filterParams[1].split('+');
                    if (filterValues.length < 2){
                        filterValues = filterParams[1].split('%20');
                    }

                    if(filterParams[0] == 'orderBy'){
                        if(filterValues.length < 2){
                            if(filterValues[0] == 'count'){
                                $('select[name="order-by"]').find('option[value="count"]').prop('selected', true);
                            }else if(filterValues[0] == 'price-asc'){
                                $('select[name="order-by"]').find('option[value="price-asc"]').prop('selected', true);
                            }else if(filterValues[0] == 'price-desc'){
                                $('select[name="order-by"]').find('option[value="price-desc"]').prop('selected', true);
                            }else if(filterValues[0] == 'created_at'){
                                $('select[name="order-by"]').find('option[value="created_at"]').prop('selected', true);
                            }else if(filterValues[0] == 'discount'){
                                $('select[name="order-by"]').find('option[value="discount"]').prop('selected', true);
                            }
                        }
                    }
                    if(filterParams[0] == 'q'){
                        url += '?q=' + filterValues[0];
                    }
                }
            }

            $('select[name="order-by"]').find('option').mouseup( function() {

                if (url.split('?').length > 1) {
                    url += '&orderBy=' + $(this).val();
                } else {
                    url += '?orderBy=' + $(this).val();
                }

                window.location.href = url;
            });
        });
    </script>

@endsection



