<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ config('app.name') }} </title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{!! asset('theme/images/favicon.png') !!}">
    <link href="{!! asset('theme/admin/css/jqvmap.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('theme/admin/css/jquery.dataTables.min.css') !!}" rel="stylesheet">
    <link rel="stylesheet" href="{!! asset('theme/admin/css/chartist.min.css') !!}">
    <!-- <link href="{!! asset('theme/admin/css/bootstrap-select.min.css') !!}" rel="stylesheet"> -->
    <link href="{!! asset('theme/admin/css/styles.css') !!}" rel="stylesheet">
    <link href="{!! asset('theme/admin/cdn/LineIcons.css') !!}" rel="stylesheet">
    <link href="{!! asset('theme/admin/css/lightgallery.min.css') !!}" rel="stylesheet">

    <!-- Clockpicker -->
    <!-- <link href="{!! asset('theme/admin/css/bootstrap-clockpicker.min.css') !!}" rel="stylesheet"> -->
    <!-- asColorpicker -->
    <link href="{!! asset('theme/admin/css/asColorPicker.min.css') !!}" rel="stylesheet">
</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper" class="show menu-toggle">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="{{ url('home') }}" class="brand-logo">
                <img class="logo-abbr" src="{!! asset('theme/admin/image/milamenu.png') !!}" alt="" />
                <!--img class="logo-compact" src="{!! asset('theme/admin/image/logo-text.png') !!}" alt="">
                <img class="brand-title" src="{!! asset('theme/admin/image/logo-text.png') !!}" alt=""-->
            </a>

            <div class="nav-control">
                <div class="hamburger is-active">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
        
        <!--**********************************
            Chat box start
        ***********************************-->
         
        <!--**********************************
            Chat box End
        ***********************************-->