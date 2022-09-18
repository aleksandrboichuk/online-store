@extends('layouts.admin')

@section('content')

    <div class="breadcrumbs admin-bread">
        <ol class="breadcrumb">
            <li><a href="/admin">Панель Адміністратора</a> </li>
            <li><a href="/admin/banners">Банери</a> </li>
            <li class="active">Редагування</li>
        </ol>
    </div>
    <section class="form-add">
        <div class="container">
            <div class="col-sm-2"></div>
            <div class="col-sm-9">
                {{--<h2>Додавання категорії</h2>--}}
                <form action="{{route('banners.update', $banner->id)}}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    <div class="add-block">
                        <label for="title">Заголовок* </label>
                        <input type="text" name="title" value="{{$banner->title}}" required maxlength="35">
                    </div>
                    @if($errors->has('title'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="description">Опис* </label>
                         <textarea  name="description" id="" cols="30" rows="10" required maxlength="500"> {{$banner->description}} </textarea>
                    </div>
                    @if($errors->has('description'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="seo_name">SEO name* </label>
                        <input type="text" name="seo_name" value="{{$banner->seo_name}}" required maxlength="40">
                    </div>
                    @if($errors->has('seo_name'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('seo_name') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="image">Головне зображення </label>
                        <div class="add-image-block">
                            <input class="file" type="file" name="image" accept="image/png, image/jpeg">
                            <img src="/images/banners/{{$banner->id}}/{{$banner->image_url}}" class="product-img-admin-edit" alt="">
                        </div>
                    </div>
                    {{--<div class="add-block">--}}
                        {{--<label for="main-image">Міні-зображення (справа)</label>--}}
                        {{--<div class="add-image-block">--}}
                            {{--<input class="file" type="file" name="mini-image" accept="main-image/png, main-image/jpeg">--}}
                            {{--<img src="/images/banners/{{$banner->id}}/{{$banner->mini_img_url}}" class="product-img-admin-edit" alt="">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="add-block">
                        <label for="active">Активність </label>
                        <input type="checkbox" name="active" {{$banner->active ? "checked" : ""}}>
                    </div>
                        <div class="add-block">
                            <label for="category_group_id">Група категорій </label>
                            <select required size="5" name="category_group_id" class="select-option">
                                @foreach($category_groups as $group)
                                    <option value="{{$group->id}}" {{$group->id == $banner->categoryGroup->id ? "selected" : "" }}>{{$group->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    <button type="submit" class="btn btn-default todo-btn">Зберегти</button>
                </form>
            </div>
            <div class="col-sm-1"></div>
        </div>
    </section>

@endsection
