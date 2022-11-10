@extends('layouts.main')

@section('content')

    <div id="contact-page" class="container">
        <div class="bg">
            <div class="row">
                <div class="col-sm-12 title-contact">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <div class="contact-form">
                        <h2 class="title text-center">Залишити повідомлення</h2>
                        <div class="status alert alert-success" style="display: none" ></div>
                        <form id="main-contact-form" class="contact-form row" name="contact-form" method="post" action="{{route('send.message')}}" >
                            @csrf
                            <input type="hidden" name="id" value="{{!empty($user) ? $user->id : ""}}">
                            <div class="form-group col-md-6">
                                <input type="text" name="name" value="{{!empty($user) ? $user->first_name : ""}}" class="form-control" required="required" placeholder="Ім'я" />
                            </div>
                            <div class="form-group col-md-6">
                                <input type="email" name="email" value="{{!empty($user) ? $user->email : ""}}" class="form-control" placeholder="Ел. пошта" />
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" name="theme" class="form-control"  required="required" placeholder="Тема"  maxlength="20"/>
                            </div>
                            <div class="form-group col-md-12">
                                <textarea name="message" id="message" required="required" class="form-control"  rows="8" placeholder="Ваше повідомлення" maxlength="500"></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <input type="submit" name="submit" class="btn btn-primary pull-right" value="Відправити"  />
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="contact-info">
                        <h2 class="title text-center">Контактна Інформація</h2>
                        <address>
                            <p><b>Divisima inc.</b></p>
                            <p>просп. Ушакова 74</p>
                            <p>Херсон, Україна</p>
                            <p>Телефон: +380502654123</p>
                            <p>Факс: 1-714-252-0026</p>
                            <p>Ел. пошта: divisima@gmail.com</p>
                        </address>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
