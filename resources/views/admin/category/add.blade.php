@extends('layouts.admin')

@section('content')

<section class="form-add">
    <div class="container">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            {{--<h2>Додавання категорії</h2>--}}
            <form action="{{route('save.category')}}" method="post">
                <div class="add-block">
                    <label for="title-field">Заголовок </label>
                    <input type="text" name="title-field">
                </div>
                <div class="add-block">
                    <label for="name-field">Назва </label>
                    <input type="text" name="name-field">
                </div>
                <div class="add-block">
                    <label for="seo-field">SEO </label>
                    <input type="text" name="seo-field">
                </div>
                <div class="add-block">
                    <label for="active-field">Активність </label>
                    <input type="checkbox" name="active-field">
                </div>
                <div class="add-block">
                    <label for="cat-field">Група категорій </label>
                    <select size="5" name="cat-field" class="select-option">
                        @foreach($category_groups as $group)
                            <option value="{{$group->id}}">{{$group->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-default todo-btn">Додати</button>

            </form>
        </div>
        <div class="col-sm-2"></div>
    </div>


</section>

@endsection