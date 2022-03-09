@extends('layouts.admin')

@section('content')

    <div class="breadcrumbs admin-bread">
        <ol class="breadcrumb">
            <li><a href="/admin">Адмін</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
            <li><a href="/admin/users">Користувачі</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
            <li class="active">Редагування</li>
        </ol>
    </div>
    <section class="form-add">
        <div class="container">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                {{--<h2>Додавання категорії</h2>--}}
                <form action="{{route('save.edit.user')}}" method="post">
                    <input type="hidden" name="id" value="{{$adm_user->id}}">
                    <div class="add-block">
                        <label for="firstname-field">Ім'я </label>
                        <input type="text" value="{{$adm_user->first_name}}" name="firstname-field">
                    </div>
                    <div class="add-block">
                        <label for="lastname-field">Прізвище </label>
                        <input type="text" value="{{$adm_user->last_name}}" name="lastname-field">
                    </div>
                    <div class="add-block">
                        <label for="admin-field">Адмін </label>
                        <input type="checkbox"  name="admin-field" {{$adm_user->superuser ? "checked" : ""}}>
                    </div>
                    <div class="add-block">
                        <label for="email-field">Ел. пошта </label>
                        <input type="email" value="{{$adm_user->email}}" name="email-field">
                    </div>
                    <div class="add-block">
                        <label for="phone-field">Телефон </label>
                        <input type="text" value="{{$adm_user->phone}}" name="phone-field">
                    </div>
                    <div class="add-block">
                        <label for="address-field">Адреса </label>
                        <input type="text" value="{{$adm_user->address}}" name="address-field">
                    </div>
                    <div class="add-block">
                        <label for="city-field">Місто </label>
                        <input type="text" value="{{$adm_user->city}}" name="city-field">
                    </div>

                    <div class="add-block">
                        <label for="active-field">Активність </label>
                        <input type="checkbox" name="active-field" {{$adm_user->active ? "checked" : ""}}>
                    </div>
                    <button type="submit" class="btn btn-default todo-btn">Зберегти</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </section>

@endsection