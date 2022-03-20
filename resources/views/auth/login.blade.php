@extends('layouts.main')

@section('content')
    <section id="form">
<div class="container">
    <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-md-8 justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Вхід') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{route('login')}}">
                        <div class="row mb-3">
                            {{--<label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>--}}
                            <div class="col-md-6">

                                <input id="email" type="email" placeholder="E-mail" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"  name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @if (session()->has('error'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ session()->get('error') }}</strong>
                                        @php(session()->forget('error'))
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            {{--<label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>--}}

                            <div class="col-md-6">
                                <input id="password" placeholder="Пароль" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Запам\'ятати мене') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Увійти') }}
                                </button>

                                    <a class="btn btn-link" href="/register">
                                        {{ __('Реєстрація') }}
                                    </a>
                            </div>
                        </div>

                                {{--@if (Route::has('password.request'))--}}
                                {{--<a class="btn btn-link" href="/forgot-password">--}}
                                {{--{{ __('Забули пароль?') }}--}}
                                {{--</a>--}}
                                {{--@endif--}}
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
    </script>
@endsection