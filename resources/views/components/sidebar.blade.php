<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Категорії</h2>
        <div class="panel-group category-products" id="accordian">

            @foreach($group_categories as $group_category)
                @php($subcategories = $group_category->getCategories())
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a
                                    data-toggle="collapse"
                                    data-parent="#accordian"
                                    href="#{{$group_category->name}}">
                                @if(!empty($subcategories))
                                    <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                    <a href="{{$group_category->url}}"><strong>{{$group_category->name}}</strong></a>
                                @else
                                    <a href="{{$group_category->url}}"><strong>{{$group_category->name}}</strong></a>
                                @endif
                            </a>
                        </h4>
                    </div>
                    @if(!empty($subcategories))
                        <div id="{{$group_category->name}}" class="panel-collapse in">
                            <div class="panel-body">
                                <ul>
                                    @foreach($subcategories as $subcategory)
                                        <li><a href="{{$subcategory->url}}">{{$subcategory->name}}</a></li>
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
