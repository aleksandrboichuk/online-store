@extends('layouts.main')
@section('content')

    <section class="products-section">
        @if(isset($breadcrumbs))
            @include('components.breadcrumbs')
        @endif
        <div class="main-container">
            <div class="row">

                <!--sidebar-->
                @include('components.sidebar')

                <!--products-->

                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">{{$sub_category->title}}</h2>
                    </div>
                    @include('components.filter')
                    {{--@include('components.ajax-filters')--}}
                    <div class="row">

                        <div class="products">
                            @if(isset($products) && !empty($products) && count($products) > 0)
                                @foreach($products as $item)
                                    @include('components.product')
                                @endforeach
                            @else
                                <div class="col-sm-12 no-found">
                                    Товари не знайдені.
                                </div>
                            @endif
                        </div>
                            {{$products->appends(request()->query())->links('components.pagination')}}
                    <!--end products-->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom-js')
    <script src="/js/components/images.js"></script>
    <script src="/js/search/filtration.js"></script>
    <script src="/js/components/pagination.js"></script>

@endsection
