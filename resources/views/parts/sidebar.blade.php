<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Ціна</h2>
        <div class="price-range">

            <div class="well text-center">
                <input
                        type="text"
                        class="span2"
                        value=""
                        data-slider-min="0"
                        data-slider-max="600"
                        data-slider-step="5"
                        data-slider-value="[250,450]"
                        id="sl2"
                /><br />
                <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
            </div>
        </div>
        <h2>Category</h2>
        <div class="panel-group category-products" id="accordian">

            @foreach($group_categories as $group_category)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a
                                    data-toggle="collapse"
                                    data-parent="#accordian"
                                    href="#{{$group_category->name}}">
                                @if(count($group_category->subCategories)>0)
                                    <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                    <a href="{{route('show.category',[$group->seo_name, $group_category->seo_name])}}"><strong>{{$group_category->name}}</strong></a>
                                @else
                                    <s>{{$group_category->name}}</s>
                                @endif
                            </a>
                        </h4>
                    </div>
                    @if(count($group_category->subCategories)>0)
                        <div id="{{$group_category->name}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul>
                                    @foreach($group_category->subCategories as $single_sub_cat)
                                        <li><a href="{{route('show.sub.category',[$group->seo_name, $group_category->seo_name,$single_sub_cat->seo_name])}}">{{$single_sub_cat->name}}<span class="pull-right">()</span></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        @if(!empty($brands))
        <div class="brands_products">
            <h2>Brands</h2>
            <div class="brands-name">
                <ul class="nav nav-pills nav-stacked">
                        @foreach($brands as $brand)
                            <li>
                                <a href="#"> <span class="pull-right">()</span><strong>{{$brand->name}}</strong></a>
                            </li>
                        @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>
</div>