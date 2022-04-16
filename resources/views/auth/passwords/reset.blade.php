@extends('layouts.main')

@section('content')
    <section id="form">
        <div class="container">
            <div class="row">
                <div class="col-md-4">

                </div>
                <div class="col-md-8 justify-content-center">
                    <div class="card">
                        <div class="card-header">{{ __('Введіть ваш логін (E-mail адресу)') }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{route('send.code')}}">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <input id="email" type="email" placeholder="E-mail" class="form-control"  name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    </div>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Відправити код підтвердження') }}
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