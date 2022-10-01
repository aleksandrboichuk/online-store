@extends('layouts.main')

@section('content')
    <section id="form">
        <div class="container">
            <div class="row">
                <div class="col-md-4">

                </div>
                <div class="col-md-8 justify-content-center forgot_password_form">
                    <div class="card">
                        <div class="card-header">{{ __('Введіть новий пароль') }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{route('reset.password')}}">
                                <div class="row mb-3">
                                    <input
                                        id="token"
                                        type="hidden"
                                        name="token"
                                        value="{{$token}}"
                                    >
                                    <div class="col-md-12">
                                        <input
                                            id="email"
                                            type="email"
                                            placeholder="E-mail"
                                            class="form-control"
                                            name="email"
                                            value="{{ request()->get('email') }}"
                                            required
                                            autocomplete="email"
                                            autofocus
                                        >
                                    </div>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="col-md-12">
                                        <input id="password" type="password" placeholder="Пароль" class="form-control"  name="password" value="{{ old('password') }}" required autocomplete="password" autofocus>
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="col-md-12">
                                        <input id="password-confirm" type="password" placeholder="Підтвердження паролю" class="form-control"  name="password_confirmation" value="{{ old('password-confirm') }}" required autocomplete="password-confirm" autofocus>
                                    </div>
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row mb-0">
                                    <div class="col-md-12 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Змінити пароль') }}
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
    </script>
@endsection
