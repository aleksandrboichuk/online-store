@extends('layouts.admin')
@section('content')
    @if(session()->has('success-message'))
        <div class="alert alert-success alert-active" role="alert">
            <h4 class="alert-heading">Виконано!</h4>
            <p>{{session('success-message')}}</p>
            <hr>
            <div class="mb-0"><button type="button" class="btn btn-danger alert-btn alert-btn-close">Закрити</button></div>
        </div>
        @php(session()->forget('success-message'))
    @endif
    <section id="table_items">
        @if(isset($breadcrumbs))
            @include('admin.components.breadcrumbs')
        @endif
        <div class="container">
            <div class="table-responsive general-table-index general-table-index-with-pagination">
                <table class="table table-condensed table-admin-with-pagination">
                    <thead>
                    <tr class="general_menu">
                        <td>ID користувача</td>
                        <td><b>Email</b></td>
                        <td><b>Тема</b></td>
                        <td><b>Повідомлення</b></td>
                        <td><b>Дата</b></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody class="general-table">

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
                                    @method('DELETE')
                                    <button id="{{$message->id}}" type="submit" class="btn btn-danger btn-danger-admin"><svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                            <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                        </svg></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$messages->appends(request()->query())->links('components.pagination')}}
            </div>
        </div>
    </section>

@endsection
@section('custom-js')
    <script>
        $(document).ready(function () {

            let countPage = 1;
            $('.next-page').click(function () {
                event.preventDefault();
                countPage += 1;
                let url = location.href;
                if (countPage <= $(this).attr('id')) {
                    $.ajax({
                        url: url.split('?page')[0] + '?page=' + countPage,
                        type: "GET",
                        success: function (data) {
                            $('.general-table').append(data)
                        }
                    });
                }

                if (countPage == $(this).attr('id')) {
                    $(this).css('display', 'none');
                }
            });
        });
    </script>
@endsection
