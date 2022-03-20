@extends('layouts.main')

@section('content')
    <section id="personal_area">
        <div class="container personal-area-container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/shop/women">Головна</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                    <li><a href="/personal/orders">Особистий кабінет</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                    <li class="active">Налаштування</li>
                </ol>
            </div>
            <div class="col-sm-12 col-lg-3">
                @include('parts.personal-sidebar')
            </div>
            <div class="col-sm-12 col-lg-9">
                <div class="title-page-personal"><h3>Налаштування</h3></div>
                <form action="{{route('user.settings.save')}}" method="post">
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="add-block">
                        <label for="firstname-field">Ім'я </label>
                        <input type="text" value="{{$user->first_name}}" name="firstname-field">
                    </div>
                    <div class="add-block">
                        <label for="lastname-field">Прізвище </label>
                        <input type="text" value="{{$user->last_name}}" name="lastname-field">
                    </div>
                    <div class="add-block">
                        <label for="email-field">Ел. пошта </label>
                        <input type="email" value="{{$user->email}}" name="email-field">
                    </div>
                    <div class="add-block">
                        <label for="phone-field">Телефон </label>
                        <input type="text" value="{{$user->phone}}" name="phone-field">
                    </div>
                    <div class="add-block">
                        <label for="address-field">Адреса </label>
                        <input type="text" value="{{$user->address}}" name="address-field">
                    </div>
                    <div class="add-block">
                        <label for="city-field">Місто </label>
                        <input type="text" value="{{$user->city}}" name="city-field">
                    </div>
                    <div class="add-block">
                        <label for="old-pass-field">Пароль* </label>
                        <input type="password"  name="old-pass-field" required>
                    </div>
                    @if (session()->has('old-pass-error'))
                        <div class="invalid-feedback invalid-feedback-personal" role="alert">
                            <strong>{{ session()->get('old-pass-error') }}</strong>
                            @php(session()->forget('old-pass-error'))
                        </div>
                    @endif
                    <div class="add-block block-passwords">
                        <label for="new-pass-field">Новий пароль </label>
                        <input type="password" name="new-pass-field">
                    </div>
                    <div class="add-block">
                        <label for="confirm-new-pass-field">Підтвердження нового паролю </label>
                        <input type="password"  name="confirm-new-pass-field">
                    </div>
                    @if (session()->has('confirm-new-pass-error'))
                        <div class="invalid-feedback invalid-feedback-personal" role="alert">
                            <strong>{{ session()->get('confirm-new-pass-error') }}</strong>
                            @php(session()->forget('confirm-new-pass-error'))
                        </div>
                    @endif
                    <button type="submit" class="btn btn-default todo-btn">Зберегти</button>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('custom-js')
    <script>
        $('input[name="old-pass-field"]').click(function () {
            $('.invalid-feedback').css('display', 'none');
        });
        $('input[name="confirm-new-pass-field"]').click(function () {
            $('.invalid-feedback').css('display', 'none');
        });
    </script>
@endsection