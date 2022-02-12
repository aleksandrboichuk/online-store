@extends('layouts.admin')

@section('content')

<section class="form-add">
    <div class="container">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            {{--<h2>Додавання категорії</h2>--}}
            <form action="{{route('save.category')}}" method="post">
                <div class="title-add">
                    <label for="title-field">Заголовок </label>
                    <input type="text" name="title-field">
                </div>
                <div class="name-add">
                    <label for="name-field">Назва </label>
                    <input type="text" name="name-field">
                </div>
                <div class="seo-name-add">
                    <label for="seo-field">SEO </label>
                    <input type="text" name="seo-field">
                </div>
                <div class="category-group">
                    <label for="cat-field">ID групи категорій </label>
                    <input type="text" name="cat-field">
                </div>
                <div class="active-add">
                    <label for="active-field">Активність </label>
                    <input type="checkbox" name="active-field">
                </div>
                <button type="submit" class="btn btn-warning">Додати</button>

            </form>
        </div>
        <div class="col-sm-2"></div>
    </div>


</section>

@endsection