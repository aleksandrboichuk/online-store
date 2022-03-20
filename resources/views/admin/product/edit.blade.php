@extends('layouts.admin')

@section('content')
    <div class="breadcrumbs admin-bread">
        <ol class="breadcrumb">
            <li><a href="/admin">Панель Адміністратора</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
            <li><a href="/admin/products">Товари</a><i class="fa fa-arrow-right" aria-hidden="true"></i></li>
            <li class="active">Редагування</li>
        </ol>
    </div>
    <section class="form-add">
        <div class="container">
            <div class="col-sm-2"></div>
            <div class="col-sm-9">
                <form action="{{route('save.edit.product')}}" method="post" enctype="multipart/form-data">
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
                        <label for="main-image-field">Головне зображення* </label>
                        <div class="add-image-block">
                            <input class="file" type="file" name="main-image-field" accept="main-image-field/png, main-image-field/jpeg">
                            <img src="/storage/product-images/{{$product->id}}/preview/{{$product->preview_img_url}}" class="product-img-admin-edit" alt="">
                        </div>
                    </div>
                    @if(isset($product->images) && !empty($product->images))
                        @foreach($product->images as $key => $img)
                            @if($img->url != $product->preview_img_url)
                                <div class="add-block">
                                    <label for="image-field">Детальне зобр. №{{$key}}</label>
                                    <div class="add-image-block">
                                        <input class="file detail-img-file" type="file" name="additional-image-field-{{$key}}" accept=".jpg, .jpeg, .png">
                                        <img src="/storage/product-images/{{$product->id}}/details/{{$img->url}}" class="product-img-admin-edit" alt="">
                                        <a id="{{$product->id}}"  class="btn btn-danger btn-danger-admin"><svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                                <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                        </svg></a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                    <div class="add-block button-add-block">
                        <a class="btn btn-default pull-right add-image-field">Додати детальне зображення</a>
                    </div>
                    <div class="add-block">
                        <label for="image-field">Посилання на зображення </label>
                        <input type="text" value="{{$product->preview_img_url}}" name="image-field">
                    </div>
                    <div class="add-block">
                        <label for="description-field">Опис </label>
                        <textarea  rows="10" name="description-field" > {{$product->description}}</textarea>
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
                            @if(!empty($banners))
                            @foreach($banners as $banner)
                                <option value="{{$banner->id}}" {{$banner->id == $product->banner_id ? "selected": ""}}>{{$banner->title}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="count-field">Кількість </label>
                        <input type="text" value="{{$product->count}}" name="count-field" readonly>
                    </div>
                    <div class="add-block">
                        <label for="active-field">Активність </label>
                        <input type="checkbox" name="active-field" {{$product->active ? "checked" : ""}}>
                    </div>
                    <div class="add-block">
                        <label for="cat-field">Група категорій </label>
                        <select required size="4" name="cat-field" class="select-option">
                            @foreach($category_groups as $g)
                                <option value="{{$g->id}}" {{$g->id == $product->category_group_id ? "selected": ""}}>{{$g->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="category-field">Категорія </label>
                        <select required size="3" name="category-field" class="select-option" >
                            @foreach($categories as $c)
                                <option value="{{$c->id}}" {{$c->id == $product->category_id ? "selected": ""}}>{{$c->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="sub-category-field">Підкатегорія </label>
                        <select required size="7" name="sub-category-field" class="select-option" >
                            @foreach($sub_categories as $sc)
                                <option value="{{$sc->id}}" {{$sc->id == $product->category_sub_id ? "selected": ""}}>{{$sc->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="color-field">Колір </label>
                        <select required size="7" name="color-field" class="select-option">
                            @foreach($colors as $col)
                                <option value="{{$col->id}}"  {{$col->id == $product->product_color_id ? "selected": ""}}>{{$col->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="season-field">Сезон </label>
                        <select required size="7" name="season-field" class="select-option">
                            @foreach($seasons as $s)
                                <option value="{{$s->id}}"  {{$s->id == $product->product_season_id ? "selected": ""}}>{{$s->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="brand-field">Бренд </label>
                        <select required size="7" name="brand-field" class="select-option">
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
                                    <p class="input-count-p">Кількість (шт.): </p><input type="text" class="input-count" value="{{isset($count_sizes[$si->id]) ? $count_sizes[$si->id] : ""}}" name="size-count[]">
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
@section('custom-js')

    <script>
       $(document).ready(function () {
           var countImages = 1;
           var detailImgs = document.querySelectorAll('.detail-img-file');
           if(detailImgs !== 'undefined'){
               countImages = detailImgs.length + 1;
           }
           $('.add-image-field').click(function () {
               $(this).parent().before(function () {
                   return '<div class="add-block">\n' +
                       '                <label for="image-field">Детальне зобр. №'+ countImages + '  </label>\n' +
                       '                   <input type="file" class="file detail-img-file" name="additional-image-field-'+ countImages +'" accept=".jpg, .jpeg, .png">\n' +
                       '                </div>'
               });
               countImages += 1;
               if(countImages == 7){
                   $(this).attr('disabled', 'disabled').css('background-color', '#6fa1f4');
               }
           });

           $('.btn-danger-admin').click(function () {
            let imageSrcArr = $(this).parent().find('img').attr('src').split('/');
            let imgUrl = imageSrcArr[imageSrcArr.length - 1];
            $.ajax({
                url: "{{route('edit.product', [$product->id])}}" ,
                type: "GET",
                data: {
                    imgUrl: imgUrl,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    location.reload();
                }
            });
        });
       });
    </script>
    @endsection