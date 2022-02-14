
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
    <link href="/css/prettyPhoto.css" rel="stylesheet" />
    <link href="/css/price-range.css" rel="stylesheet" />
    <link href="/css/animate.css" rel="stylesheet" />
    <link href="/css/main.css" rel="stylesheet" />
    <link href="/css/responsive.css" rel="stylesheet" />

    <!--[if lt IE 9]>
    <script src="/js/html5shiv.js"></script>
    <script src="/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<!--start header-->

<header id="header">
    <div class="header-middle">
        <div class="container">
            <div class="row">
                <div class="col-md-4 clearfix">
                    <div class="logo pull-left">
                        <a href="/women"><img src="/images/home/logo.png" alt=""
                            /></a>
                    </div>

                </div>
                <div class="col-md-8 clearfix">
                    <div class="shop-menu clearfix pull-right">
                        <ul class="nav navbar-nav">
                            @if(isset($user) && !empty($user))
                                <li>
                                    <a href="/"><i class="fa fa-user"></i> Особистий кабінет</a>
                                </li>
                                <li>
                                    <a href="/"><i class="fa fa-star"></i> Обране</a>
                                </li>
                                @if($user->superuser)
                                    <li>
                                        <a href="/admin"><i class="fa fa-crosshairs"></i> Admin</a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{route('show.cart', $user->id)}}"><i class="fa fa-shopping-cart"></i> Кошик ({{count($user->cart->products)}})</a>
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
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
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
                            <li><a href="/admin/categories">Категорії</a></li>
                            <li><a href="/admin/products">Товари</a></li>
                            <li><a href="/admin/orders">Замовлення</a></li>
                            <li class="dropdown">
                                <a href="">Дітям<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="/girls">Дівчаткам</a></li>
                                    <li><a href="/boys">Хлопчикам</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3"></div>
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
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Service</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="/#">Online Help</a></li>
                            <li><a href="/#">Contact Us</a></li>
                            <li><a href="/#">Order Status</a></li>
                            <li><a href="/#">Change Location</a></li>
                            <li><a href="/#">FAQ’s</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Quock Shop</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="/#">T-Shirt</a></li>
                            <li><a href="/#">Mens</a></li>
                            <li><a href="/#">Womens</a></li>
                            <li><a href="/#">Gift Cards</a></li>
                            <li><a href="/#">Shoes</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Policies</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="/#">Terms of Use</a></li>
                            <li><a href="/#">Privecy Policy</a></li>
                            <li><a href="/#">Refund Policy</a></li>
                            <li><a href="/#">Billing System</a></li>
                            <li><a href="/#">Ticket System</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>About Shopper</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="/#">Company Information</a></li>
                            <li><a href="/#">Careers</a></li>
                            <li><a href="/#">Store Location</a></li>
                            <li><a href="/#">Affillate Program</a></li>
                            <li><a href="/#">Copyright</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-sm-offset-1">
                    <div class="single-widget">
                        <h2>About Shopper</h2>
                        <form action="#" class="searchform">
                            <input type="text" placeholder="Your email address" />
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-arrow-circle-o-right"></i>
                            </button>
                            <p>
                                Get the most recent updates from <br />our site and be
                                updated your self...
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">
                    Copyright © 2013 E-SHOPPER Inc. All rights reserved.
                </p>
                <p class="pull-right">
                    Designed by
                    <span><a target="_blank" href="/../../index.htm">Themeum</a></span>
                </p>
            </div>
        </div>
    </div>
</footer>

<!--end footer-->

<script src="/js/menu.js"></script>
<script src="/js/jquery.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.scrollUp.min.js"></script>
<script src="/js/price-range.js"></script>
<!--<script src="/js/jquery.prettyPhoto.js"></script>-->
<script src="/js/main.js"></script>
@yield('custom-js')
</body>
</html>
