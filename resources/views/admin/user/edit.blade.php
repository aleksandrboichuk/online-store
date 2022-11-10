@extends('layouts.admin')

@section('content')

    @if(isset($breadcrumbs))
        @include('admin.components.breadcrumbs')
    @endif
    <section class="form-add">
        <div class="container">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                {{--<h2>Додавання категорії</h2>--}}
                <form action="{{route('users.update', $selected_user->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="add-block">
                        <label for="first_name">Ім'я </label>
                        <input type="text" value="{{$selected_user->first_name}}" name="first_name" required maxlength="20">
                    </div>
                    @if($errors->has('first_name'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="last_name">Прізвище </label>
                        <input type="text" value="{{$selected_user->last_name}}" name="last_name" required maxlength="20">
                    </div>
                    @if($errors->has('last_name'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="email">Ел. пошта </label>
                        <input type="email" value="{{$selected_user->email}}" name="email" required maxlength="20">
                    </div>
                    @if($errors->has('email'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="phone">Телефон </label>
                        <input type="text" value="{{!empty($selected_user->phone) ? $selected_user->phone : ''}}" name="phone" onkeyup="this.value = this.value.replace(/[^\d]/g,'');">
                    </div>
                    @if($errors->has('phone'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="city">Місто </label>
                        <input type="text" value="{{$selected_user->city}}" name="city">
                    </div>

                    <div class="add-block">
                        <label for="active">Активність </label>
                        <input type="checkbox" name="active" {{$selected_user->active ? "checked" : ""}}>
                    </div>
                    <div class="add-block add-materials">
                        <label for="">Ролі* </label>
                        <div class="inputs-block">
                            @foreach($roles as $r)
                                <div class="input-block-item">
                                    <input
                                        id="{{$r->id}}"
                                        name="roles[]"
                                        type="checkbox"
                                        value="{{$r->name}}"
                                        class="many-input"
                                        {{!$selected_user->hasRole($r->name) ?: 'checked'}}
                                    >
                                    <label class="many-input-label" for="{{$r->id}}">{{$r->name}}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn btn-default todo-btn">Зберегти</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </section>

@endsection
