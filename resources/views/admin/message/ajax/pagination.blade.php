@foreach($messages as $message)
    <tr>
        <td>
            <p>{{!empty($message->user_id) ? $message->user_id : ""}}</p>
        </td>
        <td>
            <p>{{$message->email}}</p>
        </td>
        <td>
            <p>{{$message->theme}}</p>
        </td>
        <td>
            <p>{{strlen($message->message) > 10 ? '...' : $message->message}}</p>
        </td>
        <td>
            <p>{{date("d.m.Y - H:i", strtotime($message->created_at))}}</p>
        </td>
        <td>
            <a href="{{route('messages.show', $message->id)}}" class="btn btn-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info" viewBox="0 0 16 16">
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg></a>
        </td>
        <td>
            <form action="{{route('messages.destroy',$message->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button id="{{$message->id}}" type="submit" class="btn btn-danger btn-danger-admin"><svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                        <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                    </svg></button>
            </form>
        </td>
    </tr>
@endforeach
