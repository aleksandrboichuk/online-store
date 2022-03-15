@php($seo_name = explode('/',request()->getRequestUri()))
@if(count(explode('?',request()->getRequestUri())) > 1)
    @if(isset($seo_name[2]))
        @php($seo_name[2] = explode('?',$seo_name[2])[0])
        @if(isset($seo_name[2]) && $seo_name[2] =='women')
            <form action="{{route('search', [$seo_name[2]])}}" method="get" ><input type="text" name="q" placeholder="Пошук по товарам для жінок..." value=""/></form>
        @elseif(isset($seo_name[2]) && $seo_name[2] =='men')
            <form action="{{route('search', [$seo_name[2]])}}" method="get" ><input type="text" name="q" placeholder="Пошук по товарам для чоловіків..." value=""/></form>
        @elseif(isset($seo_name[2]) && $seo_name[2] =='boys')
            <form action="{{route('search', [$seo_name[2]])}}" method="get" ><input type="text" name="q" placeholder="Пошук по товарам для хлопчиків..." value=""/></form>
        @elseif(isset($seo_name[2]) && $seo_name[2] =='girls')
            <form action="{{route('search', [$seo_name[2]])}}" method="get" ><input type="text" name="q" placeholder="Пошук по товарам для дівчаток..." value=""/></form>
        @else
            <form action="{{route('search', ['women'])}}" method="get" ><input type="text" name="q" placeholder="Пошук" value=""/></form>
        @endif
    @else
        <form action="{{route('search', ['women'])}}" method="get" ><input type="text" name="q" placeholder="Пошук..." value=""/></form>
    @endif
@else
    @if(isset($seo_name[2]) && $seo_name[2] =='women')
        <form action="{{route('search', [$seo_name[2]])}}" method="get" ><input type="text" name="q" placeholder="Пошук по товарам для жінок..." value=""/></form>
    @elseif(isset($seo_name[2]) && $seo_name[2] =='men')
        <form action="{{route('search', [$seo_name[2]])}}" method="get" ><input type="text" name="q" placeholder="Пошук по товарам для чоловіків..." value=""/></form>
    @elseif(isset($seo_name[2]) && $seo_name[2] =='boys')
        <form action="{{route('search', [$seo_name[2]])}}" method="get" ><input type="text" name="q" placeholder="Пошук по товарам для хлопчиків..." value=""/></form>
    @elseif(isset($seo_name[2]) && $seo_name[2] =='girls')
        <form action="{{route('search', [$seo_name[2]])}}" method="get" ><input type="text" name="q" placeholder="Пошук по товарам для дівчаток..." value=""/></form>
    @else
        <form action="{{route('search', ['women'])}}" method="get" ><input type="text" name="q" placeholder="Пошук..." value=""/></form>
    @endif
@endif