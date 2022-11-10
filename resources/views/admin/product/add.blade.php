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
                <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="add-block">
                        <label for="name">Назва* </label>
                        <input type="text" name="name" required maxlength="25">
                    </div>
                    @if($errors->has('name'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="seo_name" >SEO* </label>
                        <input type="text" name="seo_name" required maxlength="30">
                    </div>
                    @if($errors->has('seo_name'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('seo_name') }}</strong>
                        </div>
                    @endif
                    {{--<div class="add-block">--}}
                        {{--<label for="image">Посилання на зображення* </label>--}}
                        {{--<input type="text" name="image" required>--}}
                    {{--</div>--}}
                    <div class="add-block">
                        <label for="preview_image">Головне зображення* </label>
                        <input type="file" name="preview_image" accept=".jpg, .jpeg, .png" required>
                    </div>

                    <div class="add-block button-add-block">
                        <a class="btn btn-default pull-right add-image">Додати детальне зображення</a>
                    </div>
                    <div class="add-block">
                        <label for="description">Опис* </label>
                        <textarea rows="10" name="description" required maxlength="700"> </textarea>
                    </div>
                    @if($errors->has('description'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="price">Ціна* </label>
                        <input type="text" name="price" required onkeyup="this.value = this.value.replace(/[^\d]/g,'');" maxlength="5">
                    </div>
                    @if($errors->has('price'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('price') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="discount">Знижка (%) </label>
                        <input type="text" name="discount" onkeyup="this.value = this.value.replace(/[^\d]/g,'');" maxlength="2">
                    </div>
                    <div class="add-block">
                        <label for="banner">Акція(якщо є)</label>
                        <select size="5" name="banner" class="select-option">
                            @foreach($banners as $banner)
                                <option value="{{$banner->id}}">{{$banner->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="active">Активність </label>
                        <input type="checkbox" name="active">
                    </div>
                    <div class="add-block">
                        <label for="category_group_id">Група категорій* </label>
                        <select required size="4" name="category_group_id" class="select-option">
                            @foreach($category_groups as $g)
                                <option value="{{$g->id}}">{{$g->name}}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="add-block">
                        <label for="category_id">Категорія* </label>
                        <select required size="3" name="category_id" class="select-option">

                        </select>
                    </div>
                    <div class="add-block">
                        <label for="category_sub_id">Підкатегорія* </label>
                        <select required size="7" name="category_sub_id" class="select-option">

                        </select>
                    </div>
                    <div class="add-block">
                        <label for="product_color_id">Колір* </label>
                        <select required size="7" name="product_color_id" class="select-option">
                            @foreach($colors as $col)
                                <option value="{{$col->id}}">{{$col->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="product_season_id">Сезон* </label>
                        <select required size="7" name="product_season_id" class="select-option">
                            @foreach($seasons as $s)
                                <option value="{{$s->id}}">{{$s->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="product_brand_id">Бренд* </label>
                        <select required size="7" name="product_brand_id" class="select-option">
                            @foreach($brands as $b)
                                <option value="{{$b->id}}">{{$b->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block add-materials">
                        <label for="">Матеріал* </label>
                        <div class="inputs-block">
                                @foreach($materials as $m)
                                <div class="input-block-item">
                                    <input id="{{$m->seo_name}}" name="materials[]" type="checkbox" value="{{$m->id}}" class="many-input">
                                    <label class="many-input-label" for="{{$m->seo_name}}">{{$m->name}}</label>
                                </div>
                                @endforeach
                        </div>
                    </div>
                    <div class="add-block add-sizes">
                        <label for="">Розмір* </label>
                        <div class="inputs-block">
                            @foreach($sizes as $si)
                                <div class="input-block-item">
                                        <input id="{{$si->seo_name}}" name="sizes[]" type="checkbox" value="{{$si->id}}" class="many-input">
                                        <label class="many-input-label" for="{{$si->seo_name}}">{{$si->name}}</label>
                                        <p class="input-count-p">Кількість (шт.): </p><input type="text" class="input-count" value="" name="size-count[]" onkeyup="this.value = this.value.replace(/[^\d]/g,'');">
                                </div>

                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-default todo-btn">Додати</button>

                </form>

            </div>
            <div class="col-sm-2"></div>
        </div>

    </section>

@endsection
@section('custom-js')
    <script src="/js/admin/product/script.js"></script>
    <script>
        ajaxRequests("{{route('products.create')}}")
    </script>
@endsection
