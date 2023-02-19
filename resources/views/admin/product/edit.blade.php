@extends('layouts.admin')

@section('content')
    @if(isset($breadcrumbs))
        @include('admin.components.breadcrumbs')
    @endif
    <section class="form-add">
        <div class="container">
            <div class="col-sm-2"></div>
            <div class="col-sm-9">
                <form action="{{route('products.update', $product->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="add-block">
                        <label for="name">Назва* </label>
                        <input type="text" value="{{$product->name}}" name="name" maxlength="25" required>
                    </div>
                    @if($errors->has('name'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="seo_name">SEO* </label>
                        <input type="text"  value="{{$product->seo_name}}" name="seo_name" maxlength="25" required>
                    </div>
                    @if($errors->has('seo_name'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('seo_name') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="preview_image">Головне зображення* </label>
                        <div class="add-image-block">
                            <input class="file" type="file" name="preview_image" accept="preview_image/png, preview_image/jpeg">
                            <img src="/images/products/{{$product->id}}/preview/{{$product->preview_img_url}}" class="product-img-admin-edit" alt="">
                        </div>
                    </div>
                    @if(isset($product->images) && !empty($product->images))
                        @foreach($product->images as $key => $img)
                                <div class="add-block">
                                    <label for="image">Детальне зобр. №{{$key+1}}</label>
                                    <div class="add-image-block">
                                        <input class="file detail-img-file" type="file" name="additional-image-{{$key}}" accept=".jpg, .jpeg, .png">
                                        <img src="/images/products/{{$product->id}}/details/{{$img->url}}" class="product-img-admin-edit" alt="">
                                        <a id="{{$product->id}}"  class="btn btn-danger btn-danger-admin"><svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
                                                <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
                                        </svg></a>
                                    </div>
                                </div>
                        @endforeach
                    @endif
                    <div class="add-block button-add-block">
                        <a class="btn btn-default pull-right add-image">Додати детальне зображення</a>
                    </div>
                    <div class="add-block">
                        <label for="description">Опис* </label>
                        <textarea  rows="10" name="description" required maxlength="700"> {{$product->description}}</textarea>
                    </div>
                    @if($errors->has('description'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="price">Ціна* </label>
                        <input type="text" value="{{$product->price}}" name="price" onkeyup="this.value = this.value.replace(/[^\d]/g,'');" required maxlength="5">
                    </div>
                    @if($errors->has('price'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('price') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="discount">Знижка (%) </label>
                        <input type="text" value="{{$product->discount ? $product->discount  : "0"}}" name="discount" onkeyup="this.value = this.value.replace(/[^\d]/g,'');" maxlength="2">
                    </div>
                    <div class="add-block">
                        <label for="banner">Акція(якщо є) </label>
                        <select size="4" name="banner" class="select-option">
                            @if(!empty($banners))
                            @foreach($banners as $banner)
                                <option value="{{$banner->id}}" {{$banner->id == $product->banner_id ? "selected": ""}}>{{$banner->title}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="count">Кількість </label>
                        <input type="text" value="{{$product->count}}" name="count" readonly>
                    </div>
                    <div class="add-block">
                        <label for="active">Активність </label>
                        <input type="checkbox" name="active" {{$product->active ? "checked" : ""}}>
                    </div>
                    <div class="add-block">
                        <label for="category_group_id">Група категорій </label>
                        <select required size="4" name="category_group_id" class="select-option">
                            @foreach($categoryGroups as $group)
                                <option value="{{$group->id}}" {{$group->id == $product->category_group_id ? "selected": ""}}>{{$group->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="category">Категорія </label>
                        <select required size="3" name="category" class="select-option" >
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" {{$category->id == $productCategory->parent_id ? "selected": ""}}>{{$category->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="category_id">Підкатегорія </label>
                        <select required size="7" name="category_id" class="select-option" >
                            @foreach($nestedCategories as $nestedCategory)
                                <option value="{{$nestedCategory->id}}" {{$nestedCategory->id == $product->category_id ? "selected": ""}}>{{$nestedCategory->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="color_id">Колір </label>
                        <select required size="7" name="color_id" class="select-option">
                            @foreach($colors as $col)
                                <option value="{{$col->id}}"  {{$col->id == $product->color_id ? "selected": ""}}>{{$col->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="season_id">Сезон </label>
                        <select required size="7" name="season_id" class="select-option">
                            @foreach($seasons as $s)
                                <option value="{{$s->id}}"  {{$s->id == $product->season_id ? "selected": ""}}>{{$s->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="add-block">
                        <label for="brand_id">Бренд </label>
                        <select required size="7" name="brand_id" class="select-option">
                            @foreach($brands as $b)
                                <option value="{{$b->id}}" {{$b->id == $product->brand_id ? "selected": ""}}>{{$b->name}}</option>
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
                                    <p class="input-count-p">Кількість (шт.): </p><input type="text" class="input-count" value="{{isset($count_sizes[$si->id]) ? $count_sizes[$si->id] : ""}}" name="size-count[]" onkeyup="this.value = this.value.replace(/[^\d]/g,'');">
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
           $('.add-image').click(function () {
               $(this).parent().before(function () {
                   return '<div class="add-block">\n' +
                       '                <label for="image">Детальне зобр. №'+ countImages + '  </label>\n' +
                       '                   <input type="file" class="file detail-img-file" name="additional-image-'+ countImages +'" accept=".jpg, .jpeg, .png">\n' +
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
                url: "{{route('products.edit', [$product->id])}}" ,
                type: "GET",
                data: {
                    imgUrl: imgUrl,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                   window.location = location.href
                }
            });
        });
       });
    </script>

    <script src="/js/admin/product/script.js"></script>
    <script>
        ajaxRequests("{{route('api.admin.getCategoriesOrSubcategoriesData')}}")
    </script>

@endsection
