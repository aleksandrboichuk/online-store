@extends('layouts.main')

@section('content')
    <section id="form">
        <div class="container">
            <div class="row">
                <div class="col-md-4">

                </div>
                <div class="col-md-8 justify-content-center">
                    <div class="card">
                        <div class="card-header">{{ __('Введіть новий пароль') }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{route('save.password')}}">
                                <div class="row mb-3">

                                    <div class="col-md-6">
                                        <input id="password" type="password" placeholder="Пароль" class="form-control"  name="password" value="{{ old('password') }}" required autocomplete="password" autofocus>
                                    </div>
                                    @if(isset($password_error))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{$password_error }}</strong>
                                    </span>
                                    @endif
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" placeholder="Підтвердження паролю" class="form-control"  name="password_confirmation" value="{{ old('password-confirm') }}" required autocomplete="password-confirm" autofocus>
                                    </div>
                                    @if(isset($password_confirm_error) && !empty($password_confirm_error))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{$password_confirm_error}}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
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