@extends('layouts.main')

@section('content')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ol>
            </div>

            <div class="table-responsive admin-table-index">
                <table class="table table-condensed">
                    <thead>
                    <tr class="admin_menu">
                        <td>ID користувача</td>
                        <td><b>Ім'я</b></td>
                        <td><b>Телефон</b></td>
                        <td><b>Адреса</b></td>
                        <td> <b>Сума</b></td>
                        <td> <b>Статус</b></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody class="admin-table">

                    @foreach($orders as $item)
                        <tr>
                            <td>
                                <p>{{$item->user_id}}</p>
                            </td>
                            <td>
                                <p class="product-id">{{$item->name}}</p>
                            </td>
                            <td>
                                <p>{{$item->phone}}</p>
                            </td>
                            <td>
                                <p>{{$item->address}}</p>
                            </td>
                            <td>
                                <p>₴{{$item->total_cost}}</p>
                            </td>
                            <td>
                                @foreach($statuses as $s)
                                    @if($s->id == $item->status)
                                        <p>{{$s->name}}</p>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <form action="{{route('delete.order',$item->id)}}" method="post">
                                    <button id="{{$item->id}}" type="submit" class="btn btn-danger"><svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                            <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                        </svg></button>
                                </form>
                            </td>
                            <td>
                                <a href="{{route('view.order', $item->id)}}" class="btn btn-secondary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info" viewBox="0 0 16 16">
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection