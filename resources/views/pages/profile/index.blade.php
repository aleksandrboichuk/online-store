@extends('layouts.main')

@section('content')
    @if(session()->has('success-message'))
        <div class="alert alert-success alert-active" role="alert">
            <h4 class="alert-heading">Замовлення прийнято!</h4>
            <p>{{session('success-message')}}</p>
            <hr>
            <div class="mb-0"><button type="button" class="btn btn-danger alert-btn alert-btn-close">Закрити</button></div>
        </div>
        @php(session()->forget('success-message'))
    @elseif(session()->has('settings-save-success'))
        <div class="alert alert-success alert-active" role="alert">
            <h4 class="alert-heading">Успішно!</h4>
            <p>{{session('settings-save-success')}}</p>
            <hr>
            <div class="mb-0"><button type="button" class="btn btn-danger alert-btn alert-btn-close">Закрити</button></div>
        </div>
        @php(session()->forget('settings-save-success'))
    @endif
    <section id="personal_area">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="/shop/women">Головна</a> </li>
                <li><a>Особистий кабінет</a> </li>
                <li class="active">{{$status_name}}</li>
            </ol>
        </div>
        <div class="container personal-area-container">
            <div class="col-sm-12 col-lg-3">
                @include('components.profile-sidebar')
            </div>
            <div class="col-sm-12 col-lg-9">
                <div class="title-page-personal"><h3>{{$status_name}}</h3></div>
                <div class="table-responsive general-table-index">
                    <table class="table table-condensed">
                        <thead>
                        <tr class="general_menu">
                            <td><b>Дата</b></td>
                            <td><b>Ім'я</b></td>
                            <td><b>Телефон</b></td>
                            <td> <b>Сума</b></td>
                            <td> <b>Статус</b></td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody class="general-table">
                     @if(!empty($orders) && count($orders) > 0)
                        @foreach($orders as $item)
                            <tr>
                                <td>
                                    <p>{{date("d.m.Y - H:i", strtotime($item->created_at))}}</p>
                                </td>
                                <td>
                                    <p class="product-id">{{$item->name}}</p>
                                </td>
                                <td>
                                    <p>{{$item->phone}}</p>
                                </td>
                                <td>
                                   <p><b>₴{{$item->total_cost}}</b></p>
                                </td>
                                <td>
                                    @foreach($statuses as $s)
                                        @if($s->id == $item->status)
                                            @if($s->name == 'Новий')
                                                <p class="new-status">{{$s->name}}</p>
                                            @elseif($s->name == 'Оброблений')
                                                <p class="processed-status">{{$s->name}}</p>
                                            @elseif($s->name == 'Оплачений')
                                                <p class="paid-status">{{$s->name}}</p>
                                            @elseif($s->name == 'Доставляється')
                                                <p class="delivering-status">{{$s->name}}</p>
                                            @elseif($s->name == 'Доставлений')
                                                <p class="delivered-status">{{$s->name}}</p>
                                            @elseif($s->name == 'Завершений')
                                                <p class="completed-status">{{$s->name}}</p>
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{route('view.order', $item->id)}}" class="btn btn-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info" viewBox="0 0 16 16">
                                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                        </svg></a>
                                </td>
                            </tr>

                        @endforeach
                     @else
                        <td></td>
                        <td></td>
                        <td>
                            <p>Наразі таких замовлень немає.</p>
                        </td>
                        <td></td>
                        <td></td>
                     @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
@endsection
@section('custom-js')
    <script>
        $(document).ready(function () {
            $('.alert-btn-close').click(function () {
                $(this).parent().parent().removeClass('alert-active');
            });

        });
    </script>
@endsection
