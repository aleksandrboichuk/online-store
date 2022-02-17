@extends('layouts.admin')

@section('content')


    <section class="form-add">
        <div class="container">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                {{--<h2>Додавання категорії</h2>--}}
                <form action="{{route('save.edit.category')}}" method="post">
                    <input type="hidden" name="id" value="{{$category->id}}">
                    <div class="add-block">
                        <label for="title-field">Заголовок </label>
                        <input type="text" value="{{$category->title}}" name="title-field">
                    </div>
                    <div class="add-block">
                        <label for="name-field">Назва </label>
                        <input type="text" value="{{$category->name}}" name="name-field">
                    </div>
                    <div class="add-block">
                        <label for="seo-field">SEO </label>
                        <input type="text" value="{{$category->seo_name}}" name="seo-field">
                    </div>
                    @if(isset($category->categoryGroups))
                    <div class="add-block">
                        <label for="cat-field">Група категорій </label>
                        <select size="5" name="cat-field" class="select-option">
                            @foreach($category_groups as $group)
                                <option value="{{$group->id}}" {{$group->id == $category->categoryGroups[0]['id'] ? "selected" : "" }}>{{$group->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="add-block">
                        <label for="active-field">Активність </label>
                        <input type="checkbox" name="active-field" {{$category->active ? "checked" : ""}}>
                    </div>
                    <button type="submit" class="btn btn-warning">Зберегти</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </section>

@endsection