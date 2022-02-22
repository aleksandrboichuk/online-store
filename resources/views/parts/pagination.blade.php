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
</ul>