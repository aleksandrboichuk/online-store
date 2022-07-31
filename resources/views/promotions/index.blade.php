@extends('layouts.main')
@section('content')
    <section class="products-section">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                @if($group->name == "Жінки")
                    <li><a href="/shop/women">Жінкам</a> </li>
                @elseif($group->name == "Чоловіки")
                    <li><a href="/shop/men">Чоловікам</a> </li>
                @elseif($group->name == "Хлопчики")
                    <li><a href="/shop/boys">Хлопчикам</a> </li>
                @elseif($group->name == "Дівчатки")
                    <li><a href="/shop/girls">Дівчаткам</a> </li>
                @endif
                <li class="active">{{$banner->title}}</li>
            </ol>
        </div>
        <div class="main-container">
            <div class="row">

                <!--sidebar-->
            @include('parts.sidebar')

            <!--products-->
                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">{{$banner->title}}</h2>
                    </div>
                    @include('parts.filters')
                    <div class="row">
                        <div class="products">
                            @if(isset($products) && !empty($products) && count($products) > 0)
                                @foreach($products as $item)
                                    @include('parts.product-item')
                                @endforeach
                            @else
                                <div class="col-sm-12 no-found">
                                    Товари не знайдені.
                                </div>
                            @endif
                        </div>
                        {{$products->appends(request()->query())->links('parts.pagination')}}
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('custom-js')
    {{--<script src="/js/ajax-filters.js"></script>--}}
    {{--<script>--}}
        {{--indexAjax("{{route('show.promotion.details', [$group->seo_name, $banner->seo_name])}}");--}}
    {{--</script>--}}
    <script>
        $('.hidden-img').hover(function () {
            $(this).parent().css("background-image", "url('/images/products/" + $(this).attr('id') +  "')")
        });
        $('.hidden-img').mouseout(function () {
            $(this).parent().css("background-image", "url('/images/products/" + $(this).parent().attr('id') +  "')");
        })
    </script>
    <script src="/js/elastic-filters.js"></script>
@endsection