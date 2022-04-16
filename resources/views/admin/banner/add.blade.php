@extends('layouts.admin')

@section('content')
    <div class="breadcrumbs admin-bread">
        <ol class="breadcrumb">
            <li><a href="/admin">Панель Адміністратора</a> </li>
            <li><a href="/admin/banner">Банери</a> </li>
            <li class="active">Додавання</li>
        </ol>
    </div>
<section class="form-add">
    <div class="container">
        <div class="col-sm-2"></div>
        <div class="col-sm-9">
            {{--<h2>Додавання категорії</h2>--}}
            <form action="{{route('save.banner')}}" method="post" enctype="multipart/form-data">
                <div class="add-block">
                    <label for="title-field">Заголовок* </label>
                    <input type="text" name="title-field" maxlength="30">
                </div>
                @if($errors->has('title-field'))
                    <div class="invalid-feedback admin-feedback" role="alert">
                        <strong>{{ $errors->first('title-field') }}</strong>
                    </div>
                @endif
                <div class="add-block">
                    <label for="description-field">Опис* </label>
                    <textarea  name="description-field" id="" cols="30" rows="10" required maxlength="500"> </textarea>
                </div>
                @if($errors->has('description-field'))
                    <div class="invalid-feedback admin-feedback" role="alert">
                        <strong>{{ $errors->first('description-field') }}</strong>
                    </div>
                @endif
                <div class="add-block">
                    <label for="description-field">SEO* </label>
                    <input type="text" name="seo-field" maxlength="40">
                </div>
                @if($errors->has('seo-field'))
                    <div class="invalid-feedback admin-feedback" role="alert">
                        <strong>{{ $errors->first('seo-field') }}</strong>
                    </div>
                @endif
                <div class="add-block">
                    <label for="main-image-field">Головне зображення* </label>
                    <input type="file" name="main-image-field" accept=".jpg, .jpeg, .png" required>
                </div>
                {{--<div class="add-block">--}}
                    {{--<label for="mini-image-field">Міні-зображення (справа) </label>--}}
                    {{--<input type="file" name="mini-image-field" accept=".jpg, .jpeg, .png">--}}
                {{--</div>--}}
                <div class="add-block">
                    <label for="active-field">Активність </label>
                    <input type="checkbox" name="active-field">
                </div>
                <div class="add-block">
                    <label for="cat-field">Група категорій </label>
                    <select required size="5" name="cat-field" class="select-option">
                        @foreach($category_groups as $group)
                            <option value="{{$group->id}}">{{$group->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-default todo-btn">Додати</button>

            </form>
        </div>
        <div class="col-sm-1"></div>
    </div>


</section>

@endsection