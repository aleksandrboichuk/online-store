@extends('layouts.admin')

@section('content')

    <div class="breadcrumbs admin-bread">
        <ol class="breadcrumb">
            <li><a href="/admin">Панель Адміністратора</a> </li>
            <li><a href="/admin/promocode">Промокоди</a> </li>
            <li class="active">Редагування</li>
        </ol>
    </div>
    <section class="form-add">
        <div class="container">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <form action="{{route('save.edit.promocode')}}" method="post">
                    <input type="hidden" name="id" value="{{$promocode->id}}">
                    <div class="add-block">
                        <label for="title-field">Назва*</label>
                        <input type="text" name="title-field" value="{{$promocode->title}}" required >
                    </div>
                    @if($errors->has('title-field'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('title-field') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="description-field">Опис* </label>
                        <textarea  name="description-field" cols="30"  rows="10" required maxlength="100">{{$promocode->description}}</textarea>
                    </div>
                    @if($errors->has('description-field'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('description-field') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="discount-field">Знижка на товари у кошику* </label>
                        <input type="text" name="discount-field"   value="{{$promocode->discount}}" required  onkeyup="this.value = this.value.replace(/[^\d]/g,'');" maxlength="2">
                    </div>
                    <div class="add-block">
                        <label for="promocode-field">Промокод* </label>
                        <input type="text" name="promocode-field"  value="{{$promocode->promocode}}"  maxlength="20" required>
                    </div>
                    @if($errors->has('promocode-field'))
                        <div class="invalid-feedback admin-feedback" role="alert">
                            <strong>{{ $errors->first('promocode-field') }}</strong>
                        </div>
                    @endif
                    <div class="add-block">
                        <label for="min-cart-products-field">Мінімальна кількість товарів у кошику </label>
                        <input type="text"  name="min-cart-products-field"   value="{{!empty($promocode->min_cart_products) ? $promocode->min_cart_products : '' }}" onkeyup="this.value = this.value.replace(/[^\d]/g,'');" placeholder="Без обмежень">
                    </div>
                    <div class="add-block">
                        <label for="min-cart-total-field">Мінімальна сума товарів у кошику (₴) </label>
                        <input type="text"  name="min-cart-total-field"   value="{{!empty($promocode->min_cart_total) ? $promocode->min_cart_total : '' }}" onkeyup="this.value = this.value.replace(/[^\d]/g,'');" placeholder="Без обмежень">
                    </div>
                    <div class="add-block">
                        <label for="active-field">Активність </label>
                        <input type="checkbox" name="active-field" {{$promocode->active ? 'checked' : ""}}>
                    </div>
                    <button type="submit" class="btn btn-default todo-btn">Зберегти</button>
                </form>
            </div>
            <div class="col-sm-1"></div>
        </div>
    </section>

@endsection