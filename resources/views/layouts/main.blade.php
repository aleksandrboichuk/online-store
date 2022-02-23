<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Divisima</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/css/font-awesome.min.css" rel="stylesheet" />
    <link href="/css/price-range.css" rel="stylesheet" />
    <link href="/css/animate.css" rel="stylesheet" />
    <link href="/css/main.css" rel="stylesheet" />
    <link href="/css/responsive.css" rel="stylesheet" />
    @yield('custom-css')
</head>
<body>
<!--start header-->

<header id="header">
    <div class="header-middle">
        <div class="container">
            <div class="row">
                <div class="col-md-4 clearfix">
                    <div class="logo pull-left">
                        <a href="/shop/women"><img src="/images/home/logo.png" alt=""
                            /></a>
                    </div>

                </div>
                <div class="col-md-8 clearfix">
                    <div class="shop-menu clearfix pull-right">
                        <ul class="nav navbar-nav">
                            @if(isset($user) && !empty($user))
                            <li>
                                <a href="/personal/orders"><i class="fa fa-user"></i> Мої замовлення</a>
                            </li>
                            {{--<li>--}}
                                {{--<a href="/"><i class="fa fa-star"></i> Обране</a>--}}
                            {{--</li>--}}
                            @if($user->superuser)
                            <li>
                                <a href="/admin"><i class="fa fa-crosshairs"></i> Панель Адміністратора</a>
                            </li>
                             @endif
                            <li>
                                <a href="{{route('show.cart', $user->id)}}"><i class="fa fa-shopping-cart"></i> Кошик ({{isset($user->cart->products) ? count($user->cart->products) : "0"}})</a>
                            </li>
                                <li>
                                    <a href="/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Вихід</a>
                                </li>
                            @else
                            <li>
                                <a href="/login"><i class="fa fa-lock"></i> Увійти</a>
                            </li>
                            <li class="or-a">
                                <a href="#">або</a>
                            </li>
                                <li>
                                    <a  href="/register"><i class="fa fa-user"></i> Зареєструватися</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="navbar-header">
                        <button
                                type="button"
                                class="navbar-toggle"
                                data-toggle="collapse"
                                data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="/shop/women" class="women">Жінкам</a></li>
                            <li><a href="/shop/men" class="men">Чоловікам</a></li>
                            <li class="dropdown">
                                <a href="#" class="kids">Дітям<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="/shop/girls">Дівчаткам</a></li>
                                    <li><a href="/shop/boys">Хлопчикам</a></li>
                                </ul>
                            </li>
                            <li><a href="/contact">Контакти</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="search_box pull-right">
                        <form action="{{route('search', [request()->getRequestUri()])}}" method="get" ><input type="text" name="q" placeholder="Пошук" value=""/></form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- end header-->



<!--start content-->
@yield('content')
<!--end content-->

<!--start footer-->

<footer id="footer">

    <div class="footer-widget">
        <div class="container">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-3">
                    <div class="single-widget">
                        <h2><b>Про нас</b></h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li>
                                <b>Divisima</b> - це український онлайн-магазин шопінгу. Тут представлені тисячі товарів одягу, аксесуарів та взуття для чоловіків, жінок та навіть дітей.
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="single-widget">
                        <h2><b>Контактна інформація</b></h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li>Divisima inc.</li>
                            <li>просп. Ушакова 74</li>
                            <li>Херсон, Україна</li>
                            <li>Телефон: +380502654123</li>
                            <li>Факс: 1-714-252-0026</li>
                            <li>Ел. пошта: divisima@gmail.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="single-widget">
                        <img src="/images/home/logo.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="col-sm-12">
                <p> Copyright &#169;2022 Всі права захищені</p>
            </div>
        </div>
    </div>
</footer>

<!--end footer-->

<script src="/js/menu.js"></script>
<script src="/js/jquery.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.scrollUp.min.js"></script>>
<script src="/js/main.js"></script>
<script>
    var url = window.location.href;
    var uri = url.split(",");
    if(uri[1] === "men"){
        $('.navbar-collapse').find('.men').addClass("active");
    }else if(uri[1] === "women"){
        $('.navbar-collapse').find('.women').addClass("active");
    }else if(uri[1] === "girls" || uri[1] === "boys" ){
        $('.navbar-collapse').find('.kids').addClass("active");
    }
</script>
@yield('custom-js')
</body>
</html>
