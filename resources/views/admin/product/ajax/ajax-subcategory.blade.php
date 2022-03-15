@foreach($sub_categories as $sc)
    <option value="{{$sc->id}}">{{$sc->title}}</option>
@endforeach