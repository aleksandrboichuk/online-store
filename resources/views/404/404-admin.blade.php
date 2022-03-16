@extends('layouts.admin')

@section('content')
    <div class="container text-center">
        <div class="logo-404">
            <a href="/shop/women"><img src="/images/home/logo.png" alt="" /></a>
        </div>
        <div class="content-404">
            <img src="/images/404/404.png" class="img-responsive" alt="" />
            <h1><b>ОЙ!</b> Ми не змогли знайти цю сторінку </h1>
            <p> Так... Схоже, ви щось зламали. Сторінка, яку ви шукаєте - зникла. </p>
            <h2 class="return-back"><a href="/admin">Верни мене додому</a></h2>
        </div>
    </div>

@endsection