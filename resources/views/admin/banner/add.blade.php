@extends('layouts.admin')

@section('content')
    @if(isset($breadcrumbs))
        @include('admin.components.breadcrumbs')
    @endif
<section class="form-add">
    <div class="container">
        <div class="col-sm-2"></div>
        <div class="col-sm-9">
            {{--<h2>Додавання категорії</h2>--}}
            <form action="{{route('banners.store')}}" method="post" enctype="multipart/form-data">
                <div class="add-block">
                    <label for="title">Заголовок* </label>
                    <input type="text" name="title" maxlength="35">
                </div>
                @if($errors->has('title'))
                    <div class="invalid-feedback admin-feedback" role="alert">
                        <strong>{{ $errors->first('title') }}</strong>
                    </div>
                @endif
                <div class="add-block">
                    <label for="description">Опис* </label>
                    <textarea  name="description" id="" cols="30" rows="10" required maxlength="500"> </textarea>
                </div>
                @if($errors->has('description'))
                    <div class="invalid-feedback admin-feedback" role="alert">
                        <strong>{{ $errors->first('description') }}</strong>
                    </div>
                @endif
                <div class="add-block">
                    <label for="description">SEO name* </label>
                    <input type="text" name="seo" maxlength="40">
                </div>
                @if($errors->has('seo_name'))
                    <div class="invalid-feedback admin-feedback" role="alert">
                        <strong>{{ $errors->first('seo_name') }}</strong>
                    </div>
                @endif
                <div class="add-block">
                    <label for="image">Головне зображення* </label>
                    <input type="file" name="image" accept=".jpg, .jpeg, .png" required>
                </div>
                {{--<div class="add-block">--}}
                    {{--<label for="mini-image">Міні-зображення (справа) </label>--}}
                    {{--<input type="file" name="mini-image" accept=".jpg, .jpeg, .png">--}}
                {{--</div>--}}
                <div class="add-block">
                    <label for="active">Активність </label>
                    <input type="checkbox" name="active">
                </div>
                <div class="add-block">
                    <label for="category_group_id">Група категорій </label>
                    <select required size="5" name="category_group_id" class="select-option">
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
