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
                <form action="{{route('subcategories.update', $subcategory->id)}}" method="post">
                   @method('PUT')
                    <div class="add-block">
                        <label for="title">Заголовок* </label>
                        <input type="text" value="{{$subcategory->title}}" name="title" required maxlength="30">
                    </div>
                    @if($errors->has('title'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="name">Назва* </label>
                        <input type="text" value="{{$subcategory->name}}" name="name" required maxlength="30">
                    </div>
                    @if($errors->has('name'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="seo_name">SEO* </label>
                        <input type="text" value="{{$subcategory->seo_name}}" name="seo_name" required maxlength="30">
                    </div>
                    @if($errors->has('seo_name'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('seo_name') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="category_id">Категорія </label>
                        <select required size="5" name="category_id" class="select-option">
                            @foreach($categories as $c)
                                <option value="{{$c->id}}" {{$c->id == $subcategory->categories->id ? "selected" : "" }}>{{$c->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="active">Активність </label>
                        <input type="checkbox" name="active" {{$subcategory->active ? "checked" : ""}}>
                    </div>
                    <button type="submit" class="btn btn-default todo-btn">Зберегти</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </section>

@endsection
