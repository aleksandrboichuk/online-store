@extends('layouts.main')
@section('content')
    <section id="form">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">

        </div>
        <div class="col-md-8 auth-form">
            <div class="card">
                <div class="card-header">{{ __('Реєстрація') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        {!! csrf_field() !!}

                        <div class="row mb-3">
                            {{--<label for="firstname" class="col-md-4 col-form-label text-md-end">{{ __('Ім\'я') }}</label>--}}

                            <div class="col-md-12">
                                <input id="first_name" type="text" placeholder="Ім'я" class="form-control" name="first_name" value="{{ old('firstname') }}" required autocomplete="first_name" autofocus>
                            </div>

                            @error('firstname')
                            <span class="invalid-feedback auth-feedback"  role="alert">
                                        <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            {{--<label for="lastname" class="col-md-4 col-form-label text-md-end">{{ __('Прізвище') }}</label>--}}

                            <div class="col-md-12">
                                <input id="last_name" type="text" placeholder="Прізвище" class="form-control" name="last_name" value="{{ old('lastname') }}" required autocomplete="last_name">
                            </div>
                            @error('lastname')
                            <span class="invalid-feedback auth-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            {{--<label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email адреса') }}</label>--}}

                            <div class="col-md-12">

                                <input id="email" type="email" placeholder="E-mail" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email">

                            </div>
                            @error('email')
                            <span class="invalid-feedback auth-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            {{--<label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Пароль') }}</label>--}}
                            <div class="col-md-12">
                                <input id="password" type="password" placeholder="Пароль" class="form-control" name="password" required autocomplete="new-password">
                            </div>
                            @error('password')
                            <span class="invalid-feedback auth-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            {{--<label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Підтвердження паролю') }}</label>--}}
                            <div class="col-md-12">
                                <input id="password-confirm" placeholder="Підтвердження паролю" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 offset-md-4">
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
{{--@section('custom-js')--}}
    {{--<script>--}}
        {{--$('#email').click(function () {--}}
            {{--$('.invalid-feedback').css('display', 'none');--}}
        {{--});--}}
        {{--$('#password').click(function () {--}}
            {{--$('.invalid-feedback').css('display', 'none');--}}
        {{--});--}}
        {{--$('#phone').click(function () {--}}
            {{--$('.invalid-feedback').css('display', 'none');--}}
        {{--});--}}
    {{--</script>--}}
{{--@endsection--}}
