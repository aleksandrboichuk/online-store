@extends('layouts.main')
@section('content')

    <section class="products-section">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    @if($group->name == "Жінки")
                        <li><a href="/shop/women">Жінкам</a><i class="fa fa-arrow-right"></i></li>
                        <li><a href="/shop/women/{{$category->seo_name}}">{{$category->title}}</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                    @elseif($group->name == "Чоловіки")
                        <li><a href="/shop/men">Чоловікам</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                        <li><a href="/shop/men/{{$category->seo_name}}">{{$category->title}}</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                    @elseif($group->name == "Хлопчики")
                        <li><a href="/shop/boys">Хлопчикам</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                        <li><a href="/shop/boys/{{$category->seo_name}}">{{$category->title}}</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                    @elseif($group->name == "Дівчатки")
                        <li><a href="/shop/girls">Дівчаткам</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                        <li><a href="/shop/girls/{{$category->seo_name}}">{{$category->title}}</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                    @endif

                        <li class="active">{{$sub_category->title}}</li>
                </ol>
            </div>
            <div class="row">

                <!--sidebar-->
                @include('parts.sidebar')

                <!--products-->

                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">{{$sub_category->title}}</h2>
                    </div>
                    @include('parts.filters')
                    <div class="row">

                        <div class="products">
                            @if(isset($products) && !empty($products) && count($products) > 0)
                                @foreach($products as $item)
                                    @include('parts.product-item')
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
        {{--indexAjax("{{route('show.sub.category', [$group->seo_name, $category->seo_name, $sub_category->seo_name])}}");--}}
    {{--</script>--}}
    <script>
        $('.hidden-img').hover(function () {
            $(this).parent().css("background-image", "url('/images/product-details/" + $(this).attr('id') +  "')")
        });
        $('.hidden-img').mouseout(function () {
            $(this).parent().css("background-image", "url('/images/preview-images/" + $(this).parent().attr('id') +  "')");
        })
    </script>
    <script src="/js/elastic-filters.js"></script>

@endsection