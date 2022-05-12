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
    @endif
    <section id="form">
        <div class="container">
            <div class="row">
                <div class="col-md-4">

                </div>
                <div class="col-md-8 justify-content-center forgot_password_form">
                    <div class="card">
                        <div class="card-header">{{ __('Введіть 6-значний код, який надійшов на вашу E-mail адресу') }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{route('confirm.code')}}">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <input id="code" type="text" placeholder="000000" class="form-control"  name="code" value="{{ old('code') }}" required autocomplete="code" autofocus maxlength="6">
                                    </div>
                                    @if(isset($code))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$code}}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="row mb-0">
                                    <div class="col-md-12 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Відправити') }}
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