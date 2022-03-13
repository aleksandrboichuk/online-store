<div class="pagination">
    {{--@foreach($elements as $e)--}}
        {{--@if (is_array($elements[0]))--}}
            {{--@foreach($e as $page => $url)--}}
                {{--@if($page != $paginator->currentPage())--}}
                    {{--@php--}}
                        {{--if(preg_match("#^\/\?#", $url)){--}}
                            {{--$requestUri = explode('?', request()->getUri());--}}
                            {{--$url = $requestUri[0] . str_replace('/',"", $url);--}}
                        {{--}--}}
                    {{--@endphp--}}
                    <button class="next-page btn btn-default" id="{{count($elements[0])}}">Load More</button>
                {{--@endif--}}
            {{--@endforeach--}}
        {{--@endif--}}
    {{--@endforeach--}}
</div>