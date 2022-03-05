@extends('layouts.admin')

@section('content')

    <section class="form-add">
        <div class="container">
            <div class="col-sm-2"></div>
            <div class="col-sm-9">
                <form action="{{route('save.edit.product')}}" method="post">
                    <input type="hidden" name="id" value="{{$product->id}}">
                    <div class="add-block">
                        <label for="name-field">Назва </label>
                        <input type="text" value="{{$product->name}}" name="name-field">
                    </div>
                    <div class="add-block">
                        <label for="seo-field">SEO </label>
                        <input type="text"  value="{{$product->seo_name}}" name="seo-field">
                    </div>
                    <div class="add-block">
                        <label for="image-field">Посилання на зображення </label>
                        <input type="text" value="{{$product->preview_img_url}}" name="image-field">
                    </div>
                    <div class="add-block">
                        <label for="description-field">Опис </label>
                        <input type="text" value="{{$product->description}}" name="description-field">
                    </div>
                    <div class="add-block">
                        <label for="price-field">Ціна </label>
                        <input type="text" value="{{$product->price}}" name="price-field">
                    </div>
                    <div class="add-block">
                        <label for="discount-field">Знижка (%) </label>
                        <input type="text" value="{{$product->discount ? $product->discount  : "0"}}" name="discount-field">
                    </div>
                    <div class="add-block">
                        <label for="banner-field">Акція(якщо є) </label>
                        <select size="4" name="banner-field" class="select-option">
                            @foreach($banners as $banner)
                                <option value="{{$banner->id}}" {{$banner->id == $product->banner_id ? "selected": ""}}>{{$banner->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="count-field">Кількість </label>
                        <input type="text" value="{{$product->count}}" name="count-field">
                    </div>
                    <div class="add-block">
                        <label for="active-field">Активність </label>
                        <input type="checkbox" name="active-field" {{$product->active ? "checked" : ""}}>
                    </div>
                    <div class="add-block">
                        <label for="cat-field">Група категорій </label>
                        <select size="4" name="cat-field" class="select-option">
                            @foreach($category_groups as $g)
                                <option value="{{$g->id}}" {{$g->id == $product->category_group_id ? "selected": ""}}>{{$g->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="category-field">Категорія </label>
                        <select size="7" name="category-field" class="select-option">
                            @foreach($categories as $c)
                                <option value="{{$c->id}}" {{$c->id == $product->category_id ? "selected": ""}}>{{$c->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="sub-category-field">Підкатегорія </label>
                        <select size="7" name="sub-category-field" class="select-option">
                            @foreach($sub_categories as $sc)
                                <option value="{{$sc->id}}" {{$sc->id == $product->category_sub_id ? "selected": ""}}>{{$sc->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="color-field">Колір </label>
                        <select size="7" name="color-field" class="select-option">
                            @foreach($colors as $col)
                                <option value="{{$col->id}}"  {{$col->id == $product->product_color_id ? "selected": ""}}>{{$col->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="season-field">Сезон </label>
                        <select size="7" name="season-field" class="select-option">
                            @foreach($seasons as $s)
                                <option value="{{$s->id}}"  {{$s->id == $product->product_season_id ? "selected": ""}}>{{$s->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="brand-field">Бренд </label>
                        <select size="7" name="brand-field" class="select-option">
                            @foreach($brands as $b)
                                <option value="{{$b->id}}" {{$b->id == $product->product_brand_id ? "selected": ""}}>{{$b->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="add-block add-materials">
                        <label for="">Матеріал </label>
                        <div class="inputs-block">
                            @foreach($materials as $m)
                                <div class="input-block-item">
                                    <input id="{{$m->seo_name}}" class="many-input" type="checkbox" name="materials[]" value="{{$m->id}}" {{in_array($m->id, $selectedMaterials) ? "checked" :""}}>
                                    <label class="many-input-label" for="{{$m->seo_name}}">{{$m->name}}</label>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="add-block add-sizes">
                        <label for="">Розмір </label>
                        <div class="inputs-block">

                            @foreach($sizes as $si)
                                <div class="input-block-item">
                                    <input id="{{$si->seo_name}}" name="sizes[]" type="checkbox" value="{{$si->id}}" class="many-input" {{in_array($si->id, $selectedSizes) ? "checked" :""}} >
                                    <label class="many-input-label" for="{{$si->seo_name}}">{{$si->name}}</label>
                                    <p class="input-count-p">Кількість (шт.): </p><input type="text" class="input-count" value="{{isset($count_sizes[$si->id]) ? $count_sizes[$si->id] : 0}}" name="size-count[]">
                                </div>

                            @endforeach
                        </div>
                    </div>


                    <button type="submit"  class="btn btn-default todo-btn">Зберегти</button>
                </form>
            </div>
            <div class="col-sm-2"></div>
        </div>


    </section>

@endsection