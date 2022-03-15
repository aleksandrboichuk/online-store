@foreach($categories as $c)
    <option value="{{$c->id}}">{{$c->title}}</option>
@endforeach