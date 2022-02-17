<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Категорії</h2>
        <div class="panel-group category-products" id="accordian">

            @foreach($group_categories as $group_category)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a
                                    data-toggle="collapse"
                                    data-parent="#accordian"
                                    href="#{{$group_category->name}}">
                                @if(count($group_category->subCategories) > 0)
                                    <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                    <a href="{{route('show.category',[$group->seo_name, $group_category->seo_name])}}"><strong>{{$group_category->name}}</strong></a>
                                @else
                                    <a href="{{route('show.category',[$group->seo_name, $group_category->seo_name])}}"><strong>{{$group_category->name}}</strong></a>
                                @endif
                            </a>
                        </h4>
                    </div>
                    @if(count($group_category->subCategories)>0)
                        <div id="{{$group_category->name}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul>
                                    @foreach($group_category->subCategories as $single_sub_cat)
                                        <li><a href="{{route('show.sub.category',[$group->seo_name, $group_category->seo_name,$single_sub_cat->seo_name])}}">{{$single_sub_cat->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    </div>
</div>