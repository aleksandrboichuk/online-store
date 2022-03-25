@extends('layouts.main')
@section('content')
    <section id="form">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">

        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Реєстрація') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        {!! csrf_field() !!}

                        <div class="row mb-3">
                            {{--<label for="firstname" class="col-md-4 col-form-label text-md-end">{{ __('Ім\'я') }}</label>--}}

                            <div class="col-md-6">
                                <input id="firstname" type="text" placeholder="Ім'я" class="form-control" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            {{--<label for="lastname" class="col-md-4 col-form-label text-md-end">{{ __('Прізвище') }}</label>--}}

                            <div class="col-md-6">
                                <input id="lastname" type="text" placeholder="Прізвище" class="form-control" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname">
                            </div>
                        </div>
                        <div class="row mb-3">
                            {{--<label for="city" class="col-md-4 col-form-label text-md-end">{{ __('Місто') }}</label>--}}

                            <div class="col-md-6">
                                <input id="city" type="text" placeholder="Місто" class="form-control" name="city" value="{{ old('city') }}" required autocomplete="city">
                            </div>
                        </div>
                        <div class="row mb-3">
                            {{--<label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Телефон') }}</label>--}}

                            <div class="col-md-6">
                                @if (session()->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ session()->get('phone') }}</strong>
                                        @php(session()->forget('phone'))
                                    </span>
                                @endif
                                <input id="phone" type="text" placeholder="Номер телефону" class="form-control" name="phone" value="{{ old('phone') }}" required autocomplete="phone">
                            </div>
                        </div>

                        <div class="row mb-3">
                            {{--<label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email адреса') }}</label>--}}

                            <div class="col-md-6">
                                @if (session()->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ session()->get('email') }}</strong>
                                        @php(session()->forget('email'))
                                    </span>
                                @endif
                                <input id="email" type="email" placeholder="E-mail" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email">

                            </div>
                        </div>

                        <div class="row mb-3">
                            {{--<label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Пароль') }}</label>--}}
                            <div class="col-md-6">

                                <input id="password" type="password" placeholder="Пароль" class="form-control" name="password" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            {{--<label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Підтвердження паролю') }}</label>--}}
                            @if (session()->has('new-pass'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ session()->get('new-pass') }}</strong>
                                        @php(session()->forget('new-pass'))
                                    </span>
                            @endif
                            <div class="col-md-6">
                                <input id="password-confirm" placeholder="Підтвердження паролю" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Зареєструватися') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    </section>
@endsection
@section('custom-js')
    <script>
        $('#email').click(function () {
            $('.invalid-feedback').css('display', 'none');
        });
        $('#password').click(function () {
            $('.invalid-feedback').css('display', 'none');
        });
        $('#phone').click(function () {
            $('.invalid-feedback').css('display', 'none');
        });
    </script>
@endsection