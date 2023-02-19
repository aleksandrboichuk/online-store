<div class="row">
        <div class="filters-all">

            <div class="col-sm-2 col-xs-6 col-md-2 col-lg-1 filters ">
                <div class="filter-item">
                    <div class="filter-title">
                        <span id="price-title">Ціна</span>
                        <img class="filter-img" src="/images/home/arrow-down.png" alt="">
                    </div>
                    <div class="fil-params">
                        <div class="from-to-price">
                            <p class="from-price">Від</p><input class="from-size-input" type="text" name="from-price"  onkeyup="this.value = this.value.replace(/[^\d]/g,'');">
                            <p class="to-price">До</p><input  class="to-size-input"type="text" name="to-price"  onkeyup="this.value = this.value.replace(/[^\d]/g,'');">
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-2 col-xs-6 col-md-2 col-lg-1 filters">
                @if(isset($brands) && !empty($brands))
                    <div class="filter-item">
                        <div class="filter-title">
                            <span id="brand-title">Бренд</span>
                            <img class="filter-img" src="/images/home/arrow-down.png" alt="">
                        </div>
                        <div class="fil-params">
                            <ul>
                                @foreach($brands as $b)
                                    <li class="filter-check brand" data-filter="{{$b->seo_name}}-brand"><input class="filter-input" autocomplete="off" id="{{$b->seo_name}}" type="checkbox" name="Brand"><label for="{{$b->seo_name}}">{{$b->name}} </label> </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                @endif</div>

            <div class="col-sm-2 col-xs-6 col-md-2 col-lg-1 filters ">@if(isset($colors) && !empty($colors))
                    <div class="filter-item">
                        <div class="filter-title">
                            <span id="color-title">Колір</span>
                            <img class="filter-img" src="/images/home/arrow-down.png" alt="">
                        </div>
                        <div class="fil-params">
                            <ul>
                                @foreach($colors as $c)
                                    <li class="filter-check color" data-filter="{{$c->seo_name}}-color"><input class="filter-input" autocomplete="off" id="{{$c->seo_name}}" type="checkbox" name="Color"><label for="{{$c->seo_name}}">{{$c->name}}</label> </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                @endif</div>

            <div class="col-sm-2 col-xs-6 col-md-2 col-lg-1 filters ">
                @if(isset($materials) && !empty($materials))
                    <div class="filter-item">
                        <div class="filter-title">
                            <span id="material-title">Матеріал</span>
                            <img class="filter-img" src="/images/home/arrow-down.png" alt="">
                        </div>
                        <div class="fil-params fil-params-materials">
                            <ul>
                                @foreach($materials as $m)
                                    <li class="filter-check material" data-filter="{{$m->seo_name}}-material"><input class="filter-input" autocomplete="off" id="{{$m->seo_name}}" type="checkbox" name="Material"><label for="{{$m->seo_name}}">{{$m->name}}</label> </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif</div>

            <div class="col-sm-2 col-xs-6 col-md-2 col-lg-1 filters"> @if(isset($seasons) && !empty($seasons))
                    <div class="filter-item">
                        <div class="filter-title">
                            <span id="season-title">Сезон</span>
                            <img class="filter-img" src="/images/home/arrow-down.png" alt="">
                        </div>
                        <div class="fil-params">
                            <ul>
                                @foreach($seasons as $s)
                                    <li class="filter-check season" data-filter="{{$s->seo_name}}-season"><input class="filter-input" autocomplete="off" id="{{$s->seo_name}}" type="checkbox" name="Season"><label for="{{$s->seo_name}}">{{$s->name}}</label></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif</div>

            <div class="col-sm-2 col-xs-6 col-md-2 col-lg-1 filters ">
                @if(isset($sizes) && !empty($sizes))
                    <div class="filter-item">
                        <div class="filter-title">
                            <span id="size-title">Розмір</span>
                            <img class="filter-img" src="/images/home/arrow-down.png" alt="">
                        </div>
                        <div class="fil-params">
                            <ul>
                                @foreach($sizes as $si)
                                    <li class="filter-check size" data-filter="{{$si->seo_name}}-size"><input class="filter-input" autocomplete="off" id="{{$si->seo_name}}" type="checkbox" name="Size"><label for="{{$si->seo_name}}">{{$si->name}} </label></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif</div>

                <div class="col-sm-2 col-xs-6 col-md-2 col-lg-1 filters ">
                        <button type="button" class="btn btn-danger btn-danger-filters">Очистити фільтри</button>
                </div>
        </div>
        </div>

<div class="row">
    @include('components.sorting')
</div>
