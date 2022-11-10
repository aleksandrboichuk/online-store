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
                <form action="{{route('materials.store')}}" method="post">
                    @csrf
                    <div class="add-block">
                        <label for="name">Назва* </label>
                        <input type="text" name="name" required maxlength="20">
                    </div>
                    @if($errors->has('name'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="seo_name">SEO* </label>
                        <input type="text" name="seo_name" required maxlength="20">
                    </div>
                    @if($errors->has('seo_name'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('seo_name') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="active">Активність </label>
                        <input type="checkbox" name="active">
                    </div>
                    <button type="submit" class="btn btn-default todo-btn">Додати</button>

                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>


    </section>

@endsection
