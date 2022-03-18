@extends('layouts.admin')

@section('content')
    <div class="breadcrumbs admin-bread">
        <ol class="breadcrumb">
            <li><a href="/admin">Панель Адміністратора</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
            <li><a href="/admin/products">Товари</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
            <li class="active">Додавання</li>
        </ol>
    </div>
    <section class="form-add">
        <div class="container">
            <div class="col-sm-2"></div>
            <div class="col-sm-9">
                {{--<h2>Додавання категорії</h2>--}}
                <form action="{{route('save.product')}}" method="post" enctype="multipart/form-data">
                    <div class="add-block">
                        <label for="name-field">Назва* </label>
                        <input type="text" name="name-field" required>
                    </div>
                    <div class="add-block">
                        <label for="seo-field" >SEO* </label>
                        <input type="text" name="seo-field" required>
                    </div>
                    {{--<div class="add-block">--}}
                        {{--<label for="image-field">Посилання на зображення* </label>--}}
                        {{--<input type="text" name="image-field" required>--}}
                    {{--</div>--}}
                    <div class="add-block">
                        <label for="main-image-field">Головне зображення* </label>
                        <input type="file" name="main-image-field" accept=".jpg, .jpeg, .png" required>
                    </div>

                    <div class="add-block button-add-block">
                        <a class="btn btn-default pull-right add-image-field">Додати детальне зображення</a>
                    </div>
                    <div class="add-block">
                        <label for="description-field">Опис* </label>
                        <textarea rows="10" name="description-field" required> </textarea>
                    </div>
                    <div class="add-block">
                        <label for="price-field">Ціна* </label>
                        <input type="text" name="price-field" required>
                    </div>
                    <div class="add-block">
                        <label for="discount-field">Знижка (%) </label>
                        <input type="text" name="discount-field">
                    </div>
                    <div class="add-block">
                        <label for="banner-field">Акція(якщо є)</label>
                        <select size="5" name="banner-field" class="select-option">
                            @foreach($banners as $banner)
                                <option value="{{$banner->id}}">{{$banner->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="count-field">Кількість </label>
                        <input type="text" name="count-field" readonly>
                    </div>
                    <div class="add-block">
                        <label for="active-field">Активність </label>
                        <input type="checkbox" name="active-field">
                    </div>
                    <div class="add-block">
                        <label for="cat-field">Група категорій* </label>
                        <select required size="4" name="cat-field" class="select-option">
                            @foreach($category_groups as $g)
                                <option value="{{$g->id}}">{{$g->name}}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="add-block">
                        <label for="category-field">Категорія* </label>
                        <select required size="3" name="category-field" class="select-option">

                        </select>
                    </div>
                    <div class="add-block">
                        <label for="sub-category-field">Підкатегорія* </label>
                        <select required size="7" name="sub-category-field" class="select-option">

                        </select>
                    </div>
                    <div class="add-block">
                        <label for="color-field">Колір* </label>
                        <select required size="7" name="color-field" class="select-option">
                            @foreach($colors as $col)
                                <option value="{{$col->id}}">{{$col->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="season-field">Сезон* </label>
                        <select required size="7" name="season-field" class="select-option">
                            @foreach($seasons as $s)
                                <option value="{{$s->id}}">{{$s->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="brand-field">Бренд* </label>
                        <select required size="7" name="brand-field" class="select-option">
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
                                        <p class="input-count-p">Кількість (шт.): </p><input type="text" class="input-count" value="" name="size-count[]">
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
    <script src="/js/ajax-product-admin.js"></script>
    <script>
        ajaxRequests("{{route('add.product')}}")
        $(document).ready(function () {
            var countImages = 1;
            $('.add-image-field').click(function () {
                $(this).parent().before(function () {
                    return '<div class="add-block">\n' +
                        '                <label for="image-field">Детальне зобр. №'+ countImages + '  </label>\n' +
                        '                   <input type="file" name="additional-image-field-'+ countImages +'" accept=".jpg, .jpeg, .png">\n' +
                        '                </div>'
                });
                countImages += 1;
                if(countImages == 7){
                    $(this).attr('disabled', 'disabled').css('background-color', '#6fa1f4');
                }
            });
        });
    </script>
@endsection