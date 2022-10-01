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
                @include('components.profile-sidebar')
            </div>
            <div class="col-sm-12 col-lg-9">
                <div class="title-page-personal"><h3>Промокоди</h3></div>
                @if(!empty($promocodes) && count($promocodes) > 0)
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
                        </tbody>
                    </table>
                </div>
                @else

                    <div class="promocodes-info">
                        <p class="title">Наразі у Вас <b>відсутні</b> промокоди.</p>
                        <p>Промокоди використовуються <i><b>для отримання знижки на суму вартості товарів у кошику.</b></i> <br> <u>Їх можна отримати за умов: </u></p>
                        <ul>
                            <li>Якщо Ви новий користувач - промокод на знижку у розмірі <b>15% </b> від вартості товарів у кошику.</li>
                            <li>Якщо Ви виконали 10 замовлень на загальну суму більше, ніж <i>₴7000</i>  - промокод на знижку <b>23%</b>.</li>
                            <li>Якщо Ви приймаєте участь у спеціальній акції, за яку надається можливість отримати промокод.</li>
                        </ul>

                    </div>

                @endif
            </div>

        </div>
    </section>
@endsection
