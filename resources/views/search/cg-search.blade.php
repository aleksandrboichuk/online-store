@extends('layouts.main')
@section('content')

    <section id="advertisement">
        <div class="container">
        </div>
    </section>

    <section class="products-section">
        <div class="container">
            <div class="row">

            <!--products-->
                <div class="col-sm-12">
                    <div class="features_items">
                        <h2 class="title text-center">Рузультати пошуку</h2>
                    </div>
                    <div class="products">
                        @if(isset($products) && !empty($products))
                        @foreach($products as $item)
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
                                                <a href="{{route('show.product.details',[$group->seo_name, $item->categories['seo_name'], $item->subCategories['seo_name'],$item->seo_name ])}}"><i class="fa fa-eye"></i> Переглянути</a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                        @else
                            <div class="col-sm-12 no-found">
                                Товари не знайдені
                            </div>
                            @endif
                        <div class="row">
                            <div class="col-sm-9">
                                {{--{{$products->appends(request()->query())->links('parts.pagination')}}--}}
                            </div>
                        </div>
                    </div>
                    <!--end products-->
                </div>
            </div>

        </div>
    </section>
@endsection
