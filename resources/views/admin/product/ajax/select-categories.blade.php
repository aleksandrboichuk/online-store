@foreach($items as $item)
    <option value="{{$item->id}}">{{$item->title}}</option>
@endforeach
