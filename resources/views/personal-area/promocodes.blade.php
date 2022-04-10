@extends('layouts.main')

@section('content')
    <section id="personal_area">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="/shop/women">Головна</a> </li>
                <li><a>Особистий кабінет</a> </li>
                <li class="active">Промокоди</li>
            </ol>
        </div>
        <div class="container personal-area-container">
            <div class="col-sm-12 col-lg-3">
                @include('parts.personal-sidebar')
            </div>
            <div class="col-sm-12 col-lg-9">
                <div class="title-page-personal"><h3>Промокоди</h3></div>
                <div class="table-responsive general-table-index">
                    <table class="table table-condensed">
                        <thead>
                        <tr class="general_menu">
                            <td><b>Назва</b></td>
                            <td><b>Опис</b></td>
                            <td><b>Промокод</b></td>
                        </tr>
                        </thead>
                        <tbody class="general-table">
                        @if(!empty($promocodes) && count($promocodes) > 0)
                            @foreach($promocodes as $item)
                                <tr>
                                    <td>
                                        <p>{{$item->title}}</p>
                                    </td>
                                    <td>
                                        <p>{{$item->description}}</p>
                                    </td>
                                    <td>
                                        <p><b><i>{{$item->promocode}}</i></b></p>
                                    </td>
                                </tr>

                            @endforeach
                        @else
                            <td></td>
                            <td>
                                <p>Промокоди відсутні.</p>
                            </td>
                            <td></td>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
@endsection