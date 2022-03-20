@extends('layouts.admin')

@section('content')

    <div class="breadcrumbs admin-bread">
        <ol class="breadcrumb">
            <li><a href="/admin">Адмін</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
            <li><a href="/admin/banner">Банери</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
            <li class="active">Редагування</li>
        </ol>
    </div>
    <section class="form-add">
        <div class="container">
            <div class="col-sm-2"></div>
            <div class="col-sm-9">
                {{--<h2>Додавання категорії</h2>--}}
                <form action="{{route('save.edit.banner')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{$banner->id}}">
                    <div class="add-block">
                        <label for="title-field">Заголовок </label>
                        <input type="text" name="title-field" value="{{$banner->title}}">
                    </div>
                    <div class="add-block">
                        <label for="description-field">Опис </label>
                        <input type="text" name="description-field" value="{{$banner->description}}">
                    </div>
                    <div class="add-block">
                        <label for="description-field">SEO </label>
                        <input type="text" name="seo-field" value="{{$banner->seo_name}}">
                    </div>
                    <div class="add-block">
                        <label for="main-image-field">Головне зображення </label>
                        <div class="add-image-block">
                            <input class="file" type="file" name="main-image-field" accept="main-image-field/png, main-image-field/jpeg">
                            <img src="/storage/banner-images/{{$banner->id}}/{{$banner->image_url}}" class="product-img-admin-edit" alt="">
                        </div>
                    </div>
                    <div class="add-block">
                        <label for="main-image-field">Міні-зображення (справа)</label>
                        <div class="add-image-block">
                            <input class="file" type="file" name="mini-image-field" accept="main-image-field/png, main-image-field/jpeg">
                            <img src="/storage/banner-images/{{$banner->id}}/{{$banner->mini_img_url}}" class="product-img-admin-edit" alt="">
                        </div>
                    </div>
                    <div class="add-block">
                        <label for="active-field">Активність </label>
                        <input type="checkbox" name="active-field" {{$banner->active ? "checked" : ""}}>
                    </div>
                        <div class="add-block">
                            <label for="cat-field">Група категорій </label>
                            <select required size="5" name="cat-field" class="select-option">
                                @foreach($category_groups as $group)
                                    <option value="{{$group->id}}" {{$group->id == $banner->categoryGroups[0]->id ? "selected" : "" }}>{{$group->name}}</option>
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