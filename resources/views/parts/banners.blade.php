<section id="slider">
    <div class="container-sm">
        <div class="row">
            <div class="col-sm-12">

                <div
                        id="slider-carousel"
                        class="carousel slide"
                        data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach($banners as $key => $value)
                            @if($key == 0)
                                <li data-target="#slider-carousel" data-slide-to="{{$value->id-1}}" class="active"></li>
                            @else
                                <li data-target="#slider-carousel" data-slide-to="{{$value->id-1}}"></li>
                            @endif
                        @endforeach
                        <li data-target="#slider-carousel" style="visibility: hidden" data-slide-to="{{isset($value) && !empty($value) ? $value->id : ""}}"></li>
                    </ol>
                    <div class="carousel-inner">
                        @foreach($banners as $key => $value)
                            @if($key == 0)
                                <div class="item active">
                                    <div class="col-sm-12 banner-column-block">
                                        <img src="/images/banners/{{$value->image_url}}" class="banner-img img-responsive" alt="" />
                                        @if(isset($value->mini_img_url) && !empty($value->mini_img_url))
                                            <img src="/images/banners/{{$value->mini_img_url}}" class="mini-banner-img" alt="" />
                                        @endif
                                        <div class="slider-text">
                                            <h4>{{$value->title}}</h4>
                                            <p>{{$value->description}}</p>
                                            <button type="button" class="btn btn-default "><a href="/promotions/{{$value->categoryGroups[0]->seo_name}}/{{$value->seo_name}}">Переглянути</a></button>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="item">
                                    <div class="col-sm-12 banner-column-block">
                                        <img src="/images/banners/{{$value->image_url}}" class="banner-img img-responsive" alt="" />
                                        @if(isset($value->mini_img_url) && !empty($value->mini_img_url))
                                            <img src="/images/banners/{{$value->mini_img_url}}" class="mini-banner-img" alt="" />
                                        @endif
                                        <div class="slider-text">
                                            <h4>{{$value->title}}</h4>
                                            <p>{{$value->description}}</p>
                                            <button type="button" class="btn btn-default "><a href="/promotions/{{$value->categoryGroups[0]->seo_name}}/{{$value->seo_name}}">Переглянути</a></button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>
                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>