<?php 
$app_theme_color_1 = "#6742a8";
$app_theme_color_2 = "#000000";
$app_theme_color_3 = "#343434";
$app_theme_color_4 = "#a2a2a2";
$app_theme_font_type_1 = ""; 
$app_theme_font_type_2 = "";
$app_theme_font_type_3 = "";
$app_theme_font_type_4 = "";
$app_theme_font_style_1 = "";
$app_theme_font_style_2 = "";
$app_theme_font_style_3 = "";
$app_theme_font_style_4 = ""; 
//echo "<pre>";  print_r($country_details);echo "</pre>"; exit();
//echo "<pre>";print_r(Session::all()); echo "</pre>"; exit();
if ($restaurant_details->app_theme_color_1 != ""){
    $app_theme_color_1 = $restaurant_details->app_theme_color_1;
}
if ($restaurant_details->app_theme_color_2 != ""){
    $app_theme_color_2 = $restaurant_details->app_theme_color_2;
}
if ($restaurant_details->app_theme_color_3 != ""){
    $app_theme_color_3 = $restaurant_details->app_theme_color_3;
}
if ($restaurant_details->app_theme_color_4 != ""){
    $app_theme_color_4 = $restaurant_details->app_theme_color_4;
}
    // font style in restaurant
if ($restaurant_details->app_theme_font_style_1 != ""){
    $app_theme_font_style_1 = $restaurant_details->app_theme_font_style_1;
	if( $app_theme_font_style_1 == 'Standard'){
		$app_theme_font_style_1 = 'normal';
	}
}
if ($restaurant_details->app_theme_font_style_2 != ""){
    $app_theme_font_style_2 = $restaurant_details->app_theme_font_style_2;
	if( $app_theme_font_style_2 == 'Standard'){
		$app_theme_font_style_2 = 'normal';
	}
}
if ($restaurant_details->app_theme_font_style_3 != ""){
    $app_theme_font_style_3 = $restaurant_details->app_theme_font_style_3;
	if( $app_theme_font_style_3 == 'Standard'){
		$app_theme_font_style_3 = 'normal';
	}
}
if ($restaurant_details->app_theme_font_style_4 != ""){
    $app_theme_font_style_4 = $restaurant_details->app_theme_font_style_4;
	if( $app_theme_font_style_4 == 'Standard'){
		$app_theme_font_style_4 = 'normal';
	}
}
    // font Type  in restaurant
if (!empty($restaurant_details->get_app_theme_font_type_1->name)){
    $app_theme_font_type_1 = $restaurant_details->get_app_theme_font_type_1->name;
    $app_theme_font_type_1_tff = config("images.font_file_url").$restaurant_details->get_app_theme_font_type_1->font_file;
}
if (!empty($restaurant_details->get_app_theme_font_type_2->name)){
    $app_theme_font_type_2 = $restaurant_details->get_app_theme_font_type_2->name;
    $app_theme_font_type_2_tff = config("images.font_file_url").$restaurant_details->get_app_theme_font_type_2->font_file;
}
if (!empty($restaurant_details->get_app_theme_font_type_3->name)){
    $app_theme_font_type_3 = $restaurant_details->get_app_theme_font_type_3->name;
    $app_theme_font_type_3_tff = config("images.font_file_url").$restaurant_details->get_app_theme_font_type_3->font_file;
}
if (!empty($restaurant_details->get_app_theme_font_type_4->name)){
    $app_theme_font_type_4 = $restaurant_details->get_app_theme_font_type_4->name; 
    $app_theme_font_type_4_tff = config("images.font_file_url").$restaurant_details->get_app_theme_font_type_4->font_file;
}
$country_name='';
if(Session::has('country_name')){
    $country_name=Session::get('country_name'); 
}
$language_id='';
if(Session::has('language_id')){
    $language_id=Session::get('language_id');  
}
 //echo "<pre>"; print_r(Cookie::get()); echo "</pre>"; exit();
?>
<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
    <head>
        <meta charset="UTF-8" />
        <title>{{ config('app.name') }} - {{ $restaurant_details->restaurant_name }} - UserApp</title>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1 user-scalable=no" />
        <meta name="mobile-web-app-capable" content="yes" />
        <meta name="HandheldFriendly" content="True" />

        <meta name="title" content="<?php echo isset($meta_title)  ? $meta_title : '';?>">
        <meta name="description" content="">
        <meta name="keywords" content="mela menu">
        <meta name="author" content="mela menu">    

        <meta property="og:image" content="<?php echo isset($meta_image)  ? $meta_image : '';?>">
        <meta property="og:description" content="">
        <meta property="og:url" content="">
        <meta property="og:title" content="<?php echo isset($meta_title)  ? $meta_title : '';?>">
        <meta property="og:type" content="website">
        
        <meta property="twitter:image" content="<?php echo isset($meta_image)  ? $meta_image : '';?>">
        <meta property="twitter:description" content="">
        <meta property="twitter:url" content="">
        <meta property="twitter:title" content="<?php echo isset($meta_title)  ? $meta_title : '';?>">
        <meta property="twitter:card" content="summary_large_image">

        <link rel="shortcut icon" href="{!! asset('theme/user_app/img/favicon.png') !!}" />
        <link rel="stylesheet" href="{!! asset('theme/user_app/css/font-awesome.min.css') !!}" />
        <link rel="stylesheet" href="{!! asset('theme/user_app/css/materialize.min.css') !!}" />
        <link rel="stylesheet" href="{!! asset('theme/user_app/css/slick.css') !!}" />
        <link rel="stylesheet" href="{!! asset('theme/user_app/css/slick-theme.css') !!}" />
        <link rel="stylesheet" href="{!! asset('theme/user_app/css/owl.carousel.css') !!}" />
        <link rel="stylesheet" href="{!! asset('theme/user_app/css/owl.theme.css') !!}" />
        <link rel="stylesheet" href="{!! asset('theme/user_app/css/owl.transitions.css') !!}" />
        <link rel="stylesheet" href="{!! asset('theme/user_app/css/style.css?v=6') !!}" />
		
        <style type="text/css">
 
            @font-face {
                font-family: {{$app_theme_font_type_1}}; 
                src: url('../{{$app_theme_font_type_1_tff}}');
            }
            @font-face {
                font-family: {{$app_theme_font_type_2}}; 
                src: url('../{{$app_theme_font_type_2_tff}}');
            } 
            @font-face {
                font-family: {{$app_theme_font_type_3}}; 
                src: url('../{{$app_theme_font_type_3_tff}}');
            }
            @font-face {
                font-family: {{$app_theme_font_type_4}}; 
                src: url('../{{$app_theme_font_type_4_tff}}');
            }





        /*popup open close css START */
        /*popup open close css END */
        .ct-topbar {
            text-align: right;
            background: #eee;
        }
        .ct-topbar__list {
            margin-bottom: 0px;
        }
        .ct-language__dropdown{
            padding-top: 8px;
            max-height: 0;
            overflow: hidden;
            position: absolute;
            top: 110%;
            left: -3px;
            -webkit-transition: all 0.25s ease-in-out;
            transition: all 0.25s ease-in-out;
            width: 100px;
            text-align: center;
            padding-top: 0;
            z-index:200;
        }
        .ct-language__dropdown li{
            background: #222;
            /*padding: 5px;*/
        }
        .ct-language__dropdown li a{
            display: block;
        }
        .ct-language__dropdown li:first-child{
            padding-top: 10px;
            border-radius: 3px 3px 0 0;
        }
        .ct-language__dropdown li:last-child{
            padding-bottom: 10px;
            border-radius: 0 0 3px 3px;
        }
        .ct-language__dropdown li:hover{
            background: #444;
        }
        .ct-language__dropdown:before{
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            margin: auto;
            width: 8px;
            height: 0;
            border: 0 solid transparent;
            border-right-width: 8px;
            border-left-width: 8px;
            border-bottom: 8px solid #222;
        }
        .ct-language{
            position: relative;
            background: #00aced;
            color: #fff;
            padding: 10px 0;
        }
        .ct-language:hover .ct-language__dropdown{
            max-height: 200px;
            padding-top: 8px;
        }
        .list-unstyled {
            padding-left: 0;
            list-style: none;
        }
            .goog-te-banner-frame.skiptranslate {display: none !important;} 
            .goog-tooltip:hover {
                display: none !important;
            }
            .goog-text-highlight {
                background-color: transparent !important;
                border: none !important; 
                box-shadow: none !important;
            }
            .goog-te-combo{
                display: block;
            }
            .goog-logo-link{
                display: none;
            }
            .earth_class {
                background-image: url(../{{config("images.earth_image_url")}});
               /* width: 15px;
                height: 15px;
                position: absolute;
                top: 28px;
                background-size: 13px;
                background-repeat: no-repeat;
                margin-left: 5px;*/
            }
            .goog-te-gadget .goog-te-combo {
                padding-left: 18px;
            }
           .goog-te-gadget {
               color: transparent !important;
            }
            .goog-te-gadget .goog-te-combo {
               color: black !important;
            }
            .navbar{
                background: {{ $app_theme_color_1 }};
                border-bottom: 2px solid {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
            }
            body {
                font-style:{{$app_theme_font_style_4}};
                font-family:{{$app_theme_font_type_4}};
            }
            .footer_new ul li a {
                font-style:{{$app_theme_font_style_2}};
                font-family:{{$app_theme_font_type_2}};
            }
            footer {
                background: {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
            }
            .button {
                background: {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
            }
            .panel-control-left .side-nav li a i {
                color: {{ $app_theme_color_1 }};
            }
            .panel-control-left .side-nav .collapsible-header i {
                color: {{ $app_theme_color_1 }};
            }
            .panel-control-right .sidenav-control-right span {
                background: {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
            }
            .panel-control-right .desc h6 span {
                color: {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
            }
            .slider-slick .slick-dots li.slick-active button {
                background: {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
            }
            .app-title .line li i {
                color: {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
            }
            .product-details .entry .tabs a.active {
                border: 1px solid {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
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
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
            }
            .login .or h5,
            .picker__nav--next:hover,
            form .picker__nav--prev:hover {
                background: {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
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
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
            }
            .login [type="checkbox"]:checked + label::before {
                border-right: 2px solid {{ $app_theme_color_1 }};
                border-bottom: 2px solid {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
            }
            .register .or h5 {
                background: {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
            }
            .page-404 h3 span {
                color: {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
            }
            .entry h5 a {
                color: {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
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
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
            }
            .tabs .tab a.active{
                color: {{ $app_theme_color_1 }} !important;
                border-bottom: 3px solid {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                /*font-family:{{$app_theme_font_type_1}};*/
            }
            .categories_items_tab .tabs .tab a.active{
                color: {{ $app_theme_color_1 }} !important;
                border-bottom: 3px solid {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
				text-decoration:{{$app_theme_font_style_1}};
                font-weight:{{$app_theme_font_style_1}};
            }
            .filter-button:focus{
                color: {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
				text-decoration:{{$app_theme_font_style_1}};
                font-weight:{{$app_theme_font_style_1}};
            }
            .section-title-new{
                color: {{ $app_theme_color_1 }} !important;
                font-style:{{$app_theme_font_style_1}} !important;
                font-family:{{$app_theme_font_type_1}} !important;
				text-decoration:{{$app_theme_font_style_1}} !important;
                font-weight:{{$app_theme_font_style_1}} !important;
            }
            .review .post-review h6{
                color: {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
				text-decoration:{{$app_theme_font_style_1}};
                font-weight:{{$app_theme_font_style_1}};
            }
            .login_btn_in_menu .button {
                background: {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_2}};
                font-family:{{$app_theme_font_type_2}};
				text-decoration:{{$app_theme_font_style_2}};
                font-weight:{{$app_theme_font_style_2}};
            }
            #logout_button {
                background: {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
				text-decoration:{{$app_theme_font_style_1}};
                font-weight:{{$app_theme_font_style_1}};
            }
            .logo_text{
                color: {{ $app_theme_color_2 }};
                font-style:{{$app_theme_font_style_2}};
                font-family:{{$app_theme_font_type_2}};
				text-decoration:{{$app_theme_font_style_2}};
                font-weight:{{$app_theme_font_style_2}};
            }
            .ft-bottomf{
                color: {{ $app_theme_color_2 }};
                font-style:{{$app_theme_font_style_2}};
                font-family:{{$app_theme_font_type_2}};
				text-decoration:{{$app_theme_font_style_2}};
                font-weight:{{$app_theme_font_style_2}};
            }
            .button, .panel-control-left .sidenav-control-left i{
                color: {{ $app_theme_color_2 }};
            }
            h1,
            h2,
            h3,
            h4,
            h6 {
                color: {{ $app_theme_color_2 }};
                font-style:{{$app_theme_font_style_2}};
                font-family:{{$app_theme_font_type_2}};
				text-decoration:{{$app_theme_font_style_2}};
                font-weight:{{$app_theme_font_style_2}};
            }
            a.logo.logo_text{
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};    
				text-decoration:{{$app_theme_font_style_1}};

            }
            a.menu_item_count, .details h5.main_color, .ms-profile-information th{
                font-style:{{$app_theme_font_style_3}};
                font-family:{{$app_theme_font_type_3}};   
				text-decoration:{{$app_theme_font_style_3}};
                font-weight:{{$app_theme_font_style_3}};
            }
			.price_new_ctm_in span{
				color: {{ $app_theme_color_3 }};
                font-style:{{$app_theme_font_style_3}};
                font-family:{{$app_theme_font_type_3}};   
				text-decoration:{{$app_theme_font_style_3}};
                font-weight:{{$app_theme_font_style_3}};
            }
			
            .tabs-new .tab a{
                color: {{ $app_theme_color_2 }};
                font-style:{{$app_theme_font_style_2}};
                font-family:{{$app_theme_font_type_2}};
				text-decoration:{{$app_theme_font_style_2}};
                font-weight:{{$app_theme_font_style_2}};
            }
            .price-new h4{
                color:{{ $app_theme_color_3 }};
                font-style:{{$app_theme_font_style_3}};
                font-family:{{$app_theme_font_type_3}};
				text-decoration:{{$app_theme_font_style_3}};
                font-weight:{{$app_theme_font_style_3}};
            }
            .main_color{
                color: {{ $app_theme_color_3 }};
                font-style:{{$app_theme_font_style_3}};
                font-family:{{$app_theme_font_type_3}};
				text-decoration:{{$app_theme_font_style_3}};
                font-weight:{{$app_theme_font_style_3}};
            }
            .content a h6{
                color: {{ $app_theme_color_3 }};
                font-style:{{$app_theme_font_style_3}};
                font-family:{{$app_theme_font_type_3}};
				text-decoration:{{$app_theme_font_style_3}};
                font-weight:{{$app_theme_font_style_3}};
            }
            h5 {
                color: {{ $app_theme_color_3 }};
                font-style:{{$app_theme_font_style_3}};
                font-family:{{$app_theme_font_type_3}};
				text-decoration:{{$app_theme_font_style_3}};
                font-weight:{{$app_theme_font_style_3}};
            }
            /*.tabs .tab a{
                border-bottom: 3px solid {{ $app_theme_color_3 }};
                color: {{ $app_theme_color_3 }} !important;
            }*/
            .menu .content {
                color: {{ $app_theme_color_3 }};
                font-style:{{$app_theme_font_style_3}};
                font-family:{{$app_theme_font_type_3}};
				text-decoration:{{$app_theme_font_style_3}};
                font-weight:{{$app_theme_font_style_3}};
            }
            .ms-profile-information th{
                color: {{ $app_theme_color_1 }};
                font-style:{{$app_theme_font_style_1}};
                font-family:{{$app_theme_font_type_1}};
				text-decoration:{{$app_theme_font_style_1}};
                font-weight:{{$app_theme_font_style_1}};
            }
            .new_dis{
                color: {{ $app_theme_color_4 }};
                font-style:{{$app_theme_font_style_4}};
                text-decoration:{{$app_theme_font_style_4}};
                font-weight:{{$app_theme_font_style_4}};
                font-family:{{$app_theme_font_type_4}};
            }
            p, a, li{
                color: {{ $app_theme_color_3 }};
                font-style:{{$app_theme_font_style_3}};
                font-family:{{$app_theme_font_type_3}};
				text-decoration:{{$app_theme_font_style_3}};
                font-weight:{{$app_theme_font_style_3}};
            }
			.desc-review p{
				color: {{ $app_theme_color_4 }};
                font-style:{{$app_theme_font_style_4}};
                font-family:{{$app_theme_font_type_4}};   
				text-decoration:{{$app_theme_font_style_4}};
                font-weight:{{$app_theme_font_style_4}};
            }
            body {
                top: 0 !important;
            }
            /*popup open dishplay*/
            /* Button used to open the contact form - fixed at the bottom of the page */
.open-button {
  background-color: #555;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
  position: fixed;
  bottom: 23px;
  right: 28px;
  width: 280px;
}
/* The popup form - hidden by default */
.form-popup {
  display: none;
  position: fixed;
  bottom: 0;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}
/* Add styles to the form container */
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}
/* Full-width input fields */
.form-container input[type=text], .form-container input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}
/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}
/* Set a style for the submit/login button */
.form-container .btn {
  /*color: white;*/
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}
/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}
/* Add some hover effects to buttons */
/*.form-container .btn:hover, .open-button:hover {*/
/*  opacity: 1;*/
/*}*/

        </style>
    </head>
    <?php 
    if(isset($restaurant_details->texture_detail->image))  {
        $background_image = config("images.texture_url").$restaurant_details->texture_detail->image;
    } else {
        $background_image = '';
    }
    ?>
    <body style=" background-image: url(../{{$background_image}});";>
        <input type="hidden" value="{{url()->current()}}" id="currenct_url"> 
        <div class="page-wrap">
            @if(!empty($background_image))
            <div class="navbar texture_image" style=" background-image: url(../{{config("images.texture_url").$restaurant_details->texture_detail->image}});"; >
            @else
              <div class="navbar">
            @endif
                <div class="container"> 
                    <div class="panel-control-left">
                        <a href="#" data-activates="slide-out-left" class="sidenav-control-left"><i class="fa fa-bars"></i></a>
                    </div> 
                    <div class="site-title">
                         <?php 
                            if(!empty($fav_restaurant)){
                               $fav_icon ='<i class="fa fa-heart favs_icon" aria-hidden="true"></i>';
                            }else{
                                $fav_icon ='<i class="fa fa-heart-o favs_icon" aria-hidden="true"></i>';
                            }
                        ?> 
                            <!-- <a href="javascript::void()" id="fav_restaurant">{!!$fav_icon !!}</a>&nbsp;&nbsp; -->
                        <a href="{{ url('user_home') }}/{{ $restaurant_details->restaurant_id }}" class="logo logo_text">
                            {{$restaurant_details->restaurant_name}} 
                        </a>
                    </div>
                    <div class="panel-control-right panel-control-right_main drop_new_lag_cry"> 
                        <!-- Language Change -->
                        <a href="javascript::void();" id="open_popup"><i class="fa fa-globe" id="fa_globe"  style='color: {{ $app_theme_color_2 }} !important;'></i></a>
                    </div>
                </div>
            </div> 
            <div class="form-popup new_popup " id="myForm">
                <div class="modal-header">
                    <a href="javascript::void(0);" id="close_popup"><i class="fa fa-times"></i></a>
                </div>
                <form method="POST" enctype="multipart/form-data" id="change_language_currency" action="javascript:void(0)" files="true" class="form-container">
                    <div class="row mb0">
                        <div class="errorMessage"></div>
                        <div class="form-control">
                        <label for="email"><b>Change Currency</b></label>
                        <select class="form-control" id="change_currency" name="change_currency">
                        <option value=" ">Select</option>
                        @if(!empty($country_details)) 
                            @foreach($country_details as $country_detail)
                                <option data-icon_value="{{$country_detail->symbol}}"data-currency_code="{{$country_detail->code}}" value="{{$country_detail->country_id}}" <?php echo $country_name == $country_detail->country_name ? ' selected' : '';?>>{{$country_detail->code}}</option>
                            @endforeach
                        @endif   
                        </select>
                        </div>
                        <div class="form-control">
                        <label for="email"><b>Change Language</b></label>
                        <select class="form-control notranslate" id="change_language" name="change_language">
                        <option value="">Select</option>
                            @if(!empty($language_list)) 
                                @foreach($language_list as $language)
                                    <option data-lang="{{$language->short_name}}" data-href="#googtrans(en|{{$language->short_name}})" value="{{$language->id}}" class="notranslate"
                                        <?php echo $language_id == $language->id ? ' selected' : '';?>>{{$language->name}}</option>
                                @endforeach
                            @endif   
                        </select>
                        </div>
                        <div class="form-control">
                            <a href="javascript::void()" id="default_language_currency" class="btn button notranslate">Default</a>
                        </div>
                         <input type="submit" value="Go" class="btn button">
                         <p>(Disclaimer: Currency not being necessarily exact.)</p>
                    </div>
                </form>
            </div>
            <div class="form-popup new_popup search_model" id="searchForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <a href="javascript::void(0);" id="close_search_popup"><i class="fa fa-times"></i></a>
                    </div>
                    <form method="POST" enctype="multipart/form-data" id="serach" action="{{url('search')}}/{{ $restaurant_details->restaurant_id }}" class="form-container search_form">
                        {{ csrf_field() }}
                        <div class="row mb0">
                            <div class="form-control">
                                 <label for="email"><b>Enter Keyword</b></label>
                                @if(Session::has('search_name'))
                                    <input type="text" name="search" placeholder="Keyword...." value="{{Session::get('search_name')}}">
                                @else
                                    <input type="text" name="search" placeholder="Keyword....">
                                @endif
                            </div>
                            <input type="submit" value="search" class="btn button">
                        </div>
                    </form>
                </div>
            </div>
