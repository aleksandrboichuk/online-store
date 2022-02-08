

    <div class="row">
        <div class="col-sm-9 filters">
            <div class="filter-item">
                <div class="filter-title">
                    <span>Brands</span>
                    <img class="filter-img" src="/images/home/arrow-down.png" alt="">
                </div>
                <div class="fil-params">
                    <ul>
                        @foreach($brands as $b)
                            <li class="filter-check brand" data-filter="{{$b->seo_name}}-brand"><input class="filter-input" autocomplete="off" id="{{$b->seo_name}}" type="radio" name="Brand"><label for="{{$b->seo_name}}">{{$b->name}}</label> </li>
                        @endforeach
                    </ul>

                </div>
            </div>
            <div class="filter-item">
                <div class="filter-title">
                    <span>Colors</span>
                    <img class="filter-img" src="/images/home/arrow-down.png" alt="">
                </div>
                <div class="fil-params">
                    <ul>
                        @foreach($colors as $c)
                            <li class="filter-check color" data-filter="{{$c->seo_name}}-color"><input class="filter-input" autocomplete="off" id="{{$c->seo_name}}" type="radio" name="Color"><label for="{{$c->seo_name}}">{{$c->name}}</label> </li>
                        @endforeach
                    </ul>

                </div>
            </div>
            <div class="filter-item">
                <div class="filter-title">
                    <span>Materials</span>
                    <img class="filter-img" src="/images/home/arrow-down.png" alt="">
                </div>
                <div class="fil-params">
                    <ul>
                        @foreach($materials as $m)
                            <li class="filter-check material" data-filter="{{$m->seo_name}}-material"><input class="filter-input" autocomplete="off" id="{{$m->seo_name}}" type="radio" name="Material"><label for="{{$m->seo_name}}">{{$m->name}}</label> </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="filter-item">
                <div class="filter-title">
                    <span>Seasons</span>
                    <img class="filter-img" src="/images/home/arrow-down.png" alt="">
                </div>
                <div class="fil-params">
                    <ul>
                        @foreach($seasons as $s)
                            <li class="filter-check season" data-filter="{{$s->seo_name}}-season"><input class="filter-input" autocomplete="off" id="{{$s->seo_name}}" type="radio" name="Season"><label for="{{$s->seo_name}}">{{$s->name}}</label></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="filter-item">
                <div class="filter-title">
                    <span>Sizes</span>
                    <img class="filter-img" src="/images/home/arrow-down.png" alt="">
                </div>
                <div class="fil-params">
                    <ul>
                        @foreach($sizes as $si)
                            <li class="filter-check size" data-filter="{{$si->seo_name}}-size"><input class="filter-input" autocomplete="off" id="{{$si->seo_name}}" type="radio" name="Size"><label for="{{$si->seo_name}}">{{$si->name}}</label></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <button type="submit" class="btn btn-info aaa">Застосувати</button>
        </div>
    </div>