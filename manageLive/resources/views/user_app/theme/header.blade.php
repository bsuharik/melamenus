<?php 

$app_theme_color_1 = "#6742a8";

$app_theme_color_2 = "#000000";

$app_theme_color_3 = "#343434";

$app_theme_color_4 = "#a2a2a2";



if ($restaurant_details->app_theme_color_1 != "") 

{

    $app_theme_color_1 = $restaurant_details->app_theme_color_1;

}



if ($restaurant_details->app_theme_color_2 != "") 

{

    $app_theme_color_2 =$restaurant_details->app_theme_color_2;

}



if ($restaurant_details->app_theme_color_3 != "") 

{

    $app_theme_color_3 = $restaurant_details->app_theme_color_3;

}



if ($restaurant_details->app_theme_color_4 != "") 

{

    $app_theme_color_4 = $restaurant_details->app_theme_color_4;

}



?>



<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

    <head>

        <meta charset="UTF-8" />

        <title>{{ config('app.name') }} - {{ $restaurant_details->restaurant_name }} - UserApp</title>



        <!-- CSRF Token -->

        <meta name="csrf-token" content="{{ csrf_token() }}">



        <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1 user-scalable=no" />

        <meta name="mobile-web-app-capable" content="yes" />

        <meta name="HandheldFriendly" content="True" />

        <link rel="shortcut icon" href="{!! asset('theme/user_app/img/favicon.png') !!}" />

        <link rel="stylesheet" href="{!! asset('theme/user_app/css/font-awesome.min.css') !!}" />

        <link rel="stylesheet" href="{!! asset('theme/user_app/css/materialize.min.css') !!}" />

        <link rel="stylesheet" href="{!! asset('theme/user_app/css/slick.css') !!}" />

        <link rel="stylesheet" href="{!! asset('theme/user_app/css/slick-theme.css') !!}" />

        <link rel="stylesheet" href="{!! asset('theme/user_app/css/owl.carousel.css') !!}" />

        <link rel="stylesheet" href="{!! asset('theme/user_app/css/owl.theme.css') !!}" />

        <link rel="stylesheet" href="{!! asset('theme/user_app/css/owl.transitions.css') !!}" />

        <link rel="stylesheet" href="{!! asset('theme/user_app/css/style.css') !!}" />

        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->

        <!-- <style>

            .menu-list .entry {

                border-bottom: 1px solid #ddd;

            }

            .likedislikerate {

                margin-top: 10px;

            }

        </style> -->



        <style type="text/css">

            .navbar{

                background: {{ $app_theme_color_1 }};

                border-bottom: 2px solid {{ $app_theme_color_1 }};

            }

            footer {

                background: {{ $app_theme_color_1 }};

            }

            .button {

                background: {{ $app_theme_color_1 }};

            }

            .panel-control-left .side-nav li a i {

                color: {{ $app_theme_color_1 }};

            }

            .panel-control-left .side-nav .collapsible-header i {

                color: {{ $app_theme_color_1 }};

            }

            .panel-control-right .sidenav-control-right span {

                background: {{ $app_theme_color_1 }};

            }

            .panel-control-right .desc h6 span {

                color: {{ $app_theme_color_1 }};

            }

            .slider-slick .slick-dots li.slick-active button {

                background: {{ $app_theme_color_1 }};

            }

            .app-title .line li i {

                color: {{ $app_theme_color_1 }};

            }

            .product-details .entry .tabs a.active {

                border: 1px solid {{ $app_theme_color_1 }};

            }

            .blog .entry .user-date ul li a i {

                color: {{ $app_theme_color_1 }};

            }

            .picker--focused .picker__day--selected,

            .picker__day--selected:hover,

            form .picker__date-display,

            form .picker__day--selected,

            form .picker__weekday-display {

                background-color: {{ $app_theme_color_1 }};

            }

            .login .or h5,

            .picker__nav--next:hover,

            form .picker__nav--prev:hover {

                background: {{ $app_theme_color_1 }};

            }

            .blog .pagination ul .active {

                background: {{ $app_theme_color_1 }};

                border-color: {{ $app_theme_color_1 }};

            }

            .blog-single .entry .user-date ul li a i {

                color: {{ $app_theme_color_1 }};

            }

            form .picker__day.picker__day--today {

                color: {{ $app_theme_color_1 }};

            }

            .login [type="checkbox"]:checked + label::before {

                border-right: 2px solid {{ $app_theme_color_1 }};

                border-bottom: 2px solid {{ $app_theme_color_1 }};

            }

            .register .or h5 {

                background: {{ $app_theme_color_1 }};

            }

            .page-404 h3 span {

                color: {{ $app_theme_color_1 }};

            }

            .entry h5 a {

                color: {{ $app_theme_color_1 }};

            }

            /*.tabs .tab a:hover,

            .tabs .tab a.active {

                background-color: {{ $app_theme_color_1 }};

            }*/

            /*.filter-button.checked {

                background-color: {{ $app_theme_color_1 }};

            }*/

            .filter-button.checked{

                color: {{ $app_theme_color_1 }} !important;

                border-bottom: 4px solid {{ $app_theme_color_1 }};

            }

            .tabs .tab a.active{

                color: {{ $app_theme_color_1 }} !important;

                border-bottom: 3px solid {{ $app_theme_color_1 }};

            }

            .categories_items_tab .tabs .tab a.active{

                color: {{ $app_theme_color_1 }} !important;

                border-bottom: 3px solid {{ $app_theme_color_1 }};

            }

            .filter-button:focus{

                color: {{ $app_theme_color_1 }};

            }

            .section-title-new{

                color: {{ $app_theme_color_1 }};

            }

            .review .post-review h6{

                color: {{ $app_theme_color_1 }};

            }

            .login_btn_in_menu .button {

                background: {{ $app_theme_color_1 }};

            }

            #logout_button {

                background: {{ $app_theme_color_1 }};

            }

            .logo_text{

                color: {{ $app_theme_color_2 }};

            }

            .ft-bottomf{

                color: {{ $app_theme_color_2 }};

            }

            .button, .panel-control-left .sidenav-control-left i{

                color: {{ $app_theme_color_2 }};

            }

            h1,

            h2,

            h3,

            h4,

            h6 {

                color: #000000;

            }

            .tabs-new .tab a{

                color: {{ $app_theme_color_2 }};

            }

            .price-new h4{

                color:{{ $app_theme_color_3 }};

            }

            .main_color{

                color: {{ $app_theme_color_3 }};

            }

            .content a h6{

                color: {{ $app_theme_color_3 }};

            }

            h5 {

                color: {{ $app_theme_color_3 }};

            }

            /*.tabs .tab a{

                border-bottom: 3px solid {{ $app_theme_color_3 }};

                color: {{ $app_theme_color_3 }} !important;

            }*/

            .menu .content {

                color: {{ $app_theme_color_3 }};

            }

            .ms-profile-information th{

                color: {{ $app_theme_color_3 }};

            }

            .new_dis{

                color: {{ $app_theme_color_4 }};

            }

            p{

                color: {{ $app_theme_color_4 }};

            }

        </style>

    </head>

    <body>

        <div class="page-wrap">

            <div class="navbar">

                <div class="container">

                    <div class="panel-control-left">

                        <a href="#" data-activates="slide-out-left" class="sidenav-control-left"><i class="fa fa-bars"></i></a>

                    </div>

                    <div class="site-title">

                        <a href="{{ url('user_home') }}/{{ $restaurant_details->restaurant_id }}" class="logo logo_text">

                            <!-- <img src="{!! asset('theme/user_app/img/logo.png') !!}" align="img" height="40"> -->

                           {{ $restaurant_details->restaurant_name }}

                        </a>

                    </div>

                    <div class="panel-control-right">

                        <a href="#" data-activates="slide-out-right" class="sidenav-control-right"><i class="fa fa-shopping-bag"></i><span>2</span></a>

                    </div>

                </div>

            </div>