@foreach($reviews as $review)
    <ul>
        <li>
            <a><i class="fa fa-user"></i>{{$review->users['first_name'] . ' ' . $review->users['last_name']}}</a>
        </li>
        <li>
            <a><i class="fa fa-calendar-o"></i>{{date("d.m.Y - H:i", strtotime($review->created_at))}}</a>
        </li>
    </ul>
    <p>
        @for($i = 0; $i < $review->grade; $i++)
            <i class="fa fa-star"></i>
        @endfor
        @if($review->grade < 5)
            @for($i = $review->grade; $i < 5; $i++)
                <i class="glyphicon glyphicon-star-empty" style="font-size:20px"></i>
            @endfor
        @endif
    </p>
    <p>
        {{$review->review}}
    </p>
@endforeach