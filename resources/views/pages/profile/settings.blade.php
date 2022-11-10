@extends('layouts.main')

@section('content')
    <section id="personal_area">
        @if(isset($breadcrumbs))
            @include('components.breadcrumbs')
        @endif
        <div class="container personal-area-container">
            <div class="col-sm-12 col-lg-3">
                @include('components.profile-sidebar')
            </div>
            <div class="col-sm-12 col-lg-9">
                <div class="title-page-personal"><h3>Налаштування</h3></div>
                <form action="{{route('user.settings.save')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="add-block">
                        <label for="first_name">Ім'я </label>
                        <input type="text" value="{{$user->first_name}}" name="first_name">
                    </div>
                    @if($errors->has('first_name'))
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="last_name">Прізвище </label>
                        <input type="text" value="{{$user->last_name}}" name="last_name">
                    </div>
                    @if($errors->has('last_name'))
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="email">Ел. пошта </label>
                        <input type="email" value="{{$user->email}}" name="email">
                    </div>
                    @if($errors->has('email'))
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="phone">Телефон </label>
                        <input type="text" value="{{!empty($user->phone) ? $user->phone : ''}}" name="phone" onkeyup="this.value = this.value.replace(/[^\d]/g,'');">
                    </div>
                    @if($errors->has('phone'))
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="cit">Місто </label>
                        <input type="text" value="{{$user->city}}" name="city">
                    </div>
                    @if($errors->has('city'))
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('city') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="old-pass">Пароль* </label>
                        <input type="password"  name="old-pass" required>
                    </div>
                    @if(session()->has('old-pass-error'))
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ session('old-pass-error')}}</strong>
                        </div>
                        @php(session()->forget('old-pass-error'))
                    @endif
                    <div class="add-block block-passwords">
                        <label for="new-pass">Новий пароль </label>
                        <input type="password" name="password">
                    </div>
                    <div class="add-block">
                        <label for="confirm-new-pass">Підтвердження нового паролю </label>
                        <input type="password"  name="password_confirmation">
                    </div>
                    @if($errors->has('password'))
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
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
        $('input[name="old-pass"]').click(function () {
            $('.invalid-feedback').css('display', 'none');
        });
        $('input[name="confirm-new-pass"]').click(function () {
            $('.invalid-feedback').css('display', 'none');
        });
        $('input[name="phone"]').click(function () {
            $('.invalid-feedback').css('display', 'none');
        });
    </script>
@endsection
