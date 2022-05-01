@extends('layouts.admin')

@section('content')

    <div class="breadcrumbs admin-bread">
        <ol class="breadcrumb">
            <li><a href="/admin">Панель Адміністратора</a> </li>
            <li><a href="/admin/brands">Бренди</a> </li>
            <li class="active">Редагування</li>
        </ol>
    </div>
    <section class="form-add">
        <div class="container">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                {{--<h2>Додавання категорії</h2>--}}
                <form action="{{route('brands.update', $brand->id)}}" method="post">
                    @method('PUT')
                    <div class="add-block">
                        <label for="name-field">Назва </label>
                        <input type="text" value="{{$brand->name}}" name="name-field" required maxlength="15">
                    </div>
                    @if($errors->has('name-field'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('name-field') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="seo-field">SEO </label>
                        <input type="text" value="{{$brand->seo_name}}" name="seo-field" required maxlength="15">
                    </div>
                    @if($errors->has('seo-field'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('seo-field') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="active-field">Активність </label>
                        <input type="checkbox" name="active-field" {{$brand->active ? "checked" : ""}}>
                    </div>
                    <button type="submit" class="btn btn-default todo-btn">Зберегти</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </section>

@endsection