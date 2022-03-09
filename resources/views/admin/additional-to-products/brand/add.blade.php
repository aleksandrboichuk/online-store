@extends('layouts.admin')

@section('content')
    <div class="breadcrumbs admin-bread">
        <ol class="breadcrumb">
            <li><a href="/admin">Адмін</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
            <li><a href="/admin/brands">Бренди</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
            <li class="active">Додавання</li>
        </ol>
    </div>
    <section class="form-add">
        <div class="container">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                {{--<h2>Додавання категорії</h2>--}}
                <form action="{{route('save.brand')}}" method="post">
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
                    <button type="submit" class="btn btn-default todo-btn">Додати</button>

                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>


    </section>

@endsection