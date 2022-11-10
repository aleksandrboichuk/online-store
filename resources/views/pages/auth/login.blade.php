@extends('layouts.main')

@section('content')
    @if(session()->has('success'))
        <div class="alert alert-success alert-active" role="alert">
            <h4 class="alert-heading">Успішно!</h4>
            <p>{{session('success')}}</p>
            <hr>
            <div class="mb-0"><button type="button" class="btn btn-danger alert-btn alert-btn-close">Закрити</button></div>
        </div>
        @php(session()->forget('success'))
    @elseif(session()->has('error'))
        <div class="alert alert-warning alert-active" role="alert">
            <h4 class="alert-heading">Помилка!</h4>
            <p>{{session('error')}}</p>
            <hr>
            <div class="mb-0"><button type="button" class="btn btn-danger alert-btn alert-btn-close">Закрити</button></div>
        </div>
        @php(session()->forget('error'))
    @endif

    <section id="form">
<div class="container">
    <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-md-8 auth-form">
            <div class="card">
                <div class="card-header">{{ __('Вхід') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{route('login')}}">
                        @csrf
                        <div class="row mb-3">
                            {{--<label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>--}}
                            <div class="col-md-12">
                                <input id="email" type="email" placeholder="E-mail" class="form-control"  name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>

                           @if($errors->has('error'))
                                <span class="invalid-feedback auth-feedback" role="alert">
                                     <strong>{{ $errors->first('error') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="row mb-3">
                            {{--<label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>--}}

                            <div class="col-md-12">
                                <input id="password" placeholder="Пароль" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            </div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Запам\'ятати мене') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Увійти') }}
                                </button>

                                 <div class="btns-login-inner">
                                     <a class="btn btn-link" href="/register">
                                         {{ __('Реєстрація') }}
                                     </a>
                                     <a class="btn btn-link" href="/forgot-password">
                                         {{ __('Забули пароль?') }}
                                     </a>
                                 </div>
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
