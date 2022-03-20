@if(preg_match("#^\/shop\/women\b#", request()->getRequestUri())
    || preg_match("#^\/shop\/men\b#", request()->getRequestUri())
    || preg_match("#^\/shop\/girls\b#", request()->getRequestUri())
    || preg_match("#^\/shop\/boys\b#", request()->getRequestUri()))
        @if(preg_match("#^\/shop\/women\b#", request()->getRequestUri()))
            <form action="{{route('search', ['women'])}}" method="get" ><input type="text" name="q" placeholder="Пошук по товарам для жінок..." value=""/></form>
        @elseif(preg_match("#^\/shop\/men\b#", request()->getRequestUri()))
            <form action="{{route('search', ['men'])}}" method="get" ><input type="text" name="q" placeholder="Пошук по товарам для чоловіків..." value=""/></form>
        @elseif(preg_match("#^\/shop\/boys\b#", request()->getRequestUri()))
            <form action="{{route('search', ['boys'])}}" method="get" ><input type="text" name="q" placeholder="Пошук по товарам для хлопчиків..." value=""/></form>
        @elseif(preg_match("#^\/shop\/girls\b#", request()->getRequestUri()))
            <form action="{{route('search', ['girls'])}}" method="get" ><input type="text" name="q" placeholder="Пошук по товарам для дівчаток..." value=""/></form>
        @endif
@else
        <form action="{{route('search', ['women'])}}" method="get" ><input type="text" name="q" placeholder="Пошук..." value=""/></form>
@endif
