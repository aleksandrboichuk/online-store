@extends('layouts.admin')

@section('content')

    <div class="breadcrumbs admin-bread">
        <ol class="breadcrumb">
            <li><a href="/admin">Панель Адміністратора</a> </li>
            <li><a href="/admin/promocode">Промокоди</a> </li>
            <li class="active">Додавання</li>
        </ol>
    </div>
    <section class="form-add">
        <div class="container">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <form action="{{route('save.promocode')}}" method="post">
                    <input type="hidden" name="id">
                    <div class="add-block">
                        <label for="title-field">Назва*</label>
                        <input type="text" name="title-field" required>
                    </div>
                    <div class="add-block">
                        <label for="description-field">Опис* </label>
                        <textarea  name="description-field" cols="30"  rows="10" required></textarea>
                    </div>
                    <div class="add-block">
                        <label for="discount-field">Знижка на товари у кошику* </label>
                        <input type="text" name="discount-field" required  onkeyup="this.value = this.value.replace(/[^\d]/g,'');">
                    </div>
                    <div class="add-block">
                        <label for="promocode-field">Промокод* </label>
                        <input type="text" name="promocode-field" required maxlength="20">
                    </div>
                    <div class="add-block">
                        <label for="min-cart-products-field">Мінімальна кількість товарів у кошику </label>
                        <input type="text"  name="min-cart-products-field" onkeyup="this.value = this.value.replace(/[^\d]/g,'');" placeholder="0 - без обмежень">
                    </div>
                    <div class="add-block">
                        <label for="min-cart-total-field">Мінімальна сума товарів у кошику (₴) </label>
                        <input type="text"  name="min-cart-total-field" onkeyup="this.value = this.value.replace(/[^\d]/g,'');" placeholder="0 - без обмежень">
                    </div>
                    <div class="add-block">
                        <label for="active-field">Активність </label>
                        <input type="checkbox" name="active-field" checked>
                    </div>
                    <button type="submit" class="btn btn-default todo-btn">Зберегти</button>
                </form>
            </div>
            <div class="col-sm-1"></div>
        </div>
    </section>

@endsection