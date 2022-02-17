<ul class="pagination">
    @foreach($elements as $e)
        @if(is_string($e))
        <li>{{$e}}</li>
        @endif

    @if (is_array($e))
        @foreach($e as $page => $url)
                @if($page == $paginator->currentPage())
                  <li class="active"><a href="#">{{$page}}</a></li>
                @else
                   <li><a href="{{$url}}">{{$page}}</a></li>
                @endif
            @endforeach

        @endif
    @endforeach
    {{--<li class="active"><a href="">1</a></li>--}}
    {{--<li><a href="">2</a></li>--}}
    {{--<li><a href="">3</a></li>--}}
    {{--<li><a href="">&raquo;</a></li>--}}
</ul>