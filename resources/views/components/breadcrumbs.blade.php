<div class="breadcrumbs">
    <ol class="breadcrumb">
        @foreach($breadcrumbs as $breadcrumb)
            @if($breadcrumb['link'])
                <li><a href="{{$breadcrumb['link']}}">{{$breadcrumb['title']}}</a> </li>
            @else
                <li class="active">{{$breadcrumb['title']}}</li>
            @endif
        @endforeach
    </ol>
</div>
