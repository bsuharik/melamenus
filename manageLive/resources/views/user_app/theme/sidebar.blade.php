<?php
$id = "";

if (Auth::user() !== NULL) 
{
    $id = Auth::user()->id;
    $first_name = Auth::user()->first_name;
    $last_name = Auth::user()->last_name;
}    
?>
        <div class="panel-control-left">
            <ul id="slide-out-left" class="side-nav side-nav-img collapsible" data-collapsible="accordion">
                <li class="logo_side_one">
                    <!-- <a href="{{ url('user_home') }}/{{ $restaurant_details->restaurant_id }}"><img src="../{{ config('images.restaurant_url') .$restaurant_details->restaurant_id.'/'. $restaurant_details->restaurant_logo }}" alt="Restaurant name" width="75px"/></a> -->

                    <img src="{!! asset('theme/user_app/img/logo.png') !!}" align="img" class="logo-img">
                    <br>
                    @if($id != "")
                        Welcome {{ $first_name }} {{ $last_name }}
                    @endif
                </li>
                @if($id == "")
                    <div class="login_btn_in_menu">
                        <button class="button sign_btn" id="redirect_user_login" data-id="{{ $restaurant_details->restaurant_id }}">Login</button>
                        <button class="button sign_btn" id="redirect_user_signup" data-id="{{ $restaurant_details->restaurant_id }}">Signup</button>
                    </div>
                <li class="first_li">
                @else
                    <div class="">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="button" id="logout_button">Logout
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                                <input type="hidden" name="restaurant_id" value="{{ $restaurant_details->restaurant_id }}">
                            </form>
                        </a>
                    </div>
                <li class="">
                @endif
                    <a href="{{ url('user_home') }}/{{ $restaurant_details->restaurant_id}}"><i class="fa fa-home"></i>Home</a>
                </li>
                <li>
                    <div class="collapsible-header"><i class="fa fa-indent"></i>Menu <span><i class="fa fa-chevron-right"></i></span></div>
                    <div class="collapsible-body">
                        <ul class="categories-in collapsible" data-collapsible="accordion">
                    @if(count($parent_categories) > '0')
                        @foreach($parent_categories as $parent_cat)
                            <li>
                                <div class="collapsible-header">
                                   <img src="{!! asset('theme/user_app/img/menu_icon_7.png') !!}" alt="img"><p id="sidebar_category"> {{ $parent_cat->category_name}} </p> <span><i class="fa fa-chevron-right"></i></span>
                                </div>
                                <div class="collapsible-body">
                                    <ul class="side-nav-panel">
                                        <li>
                                            <ul class="categories-in collapsible" data-collapsible="accordion">
                                    @if(count($main_categories) > '0')
                                        @foreach($main_categories as $main_cat)
                                            @if($main_cat->parent_category_id == $parent_cat->category_id)
                                                <li>
                                                    <div class="collapsible-header">
                                                    @if(count($sub_categories) > '0')
                                                        @php($i=0)
                                                        @foreach($sub_categories as $sub_cat)
                                                        @if($i < 1)
                                                            @if($sub_cat->main_category_id == $main_cat->category_id)
                                                                @php($i++)
                                                            @endif
                                                        @endif
                                                        @endforeach
                                                        @if($i == 1)
                                                            <img src="{!! asset('theme/user_app/img/menu_icon_2.png') !!}" alt="img"> <p id="sidebar_category"> {{ $main_cat->category_name}} </p> <span><i class="fa fa-chevron-right"></i></span>
                                                        @else
                                                            <a href="{{ url('sub_categories') }}/{{ $main_cat->category_id }}" style="padding: 0px;">
                                                                <img src="{!! asset('theme/user_app/img/menu_icon_2.png') !!}" alt="img"> <p id="sidebar_category"> {{ $main_cat->category_name}} </p>
                                                            </a>
                                                        @endif
                                                    @else
                                                        <a href="{{ url('sub_categories') }}/{{ $main_cat->category_id }}" style="padding: 0px;">
                                                            <img src="{!! asset('theme/user_app/img/menu_icon_2.png') !!}" alt="img"> <p id="sidebar_category"> {{ $main_cat->category_name}} </p>
                                                        </a>
                                                    @endif
                                                    </div>
                                                    <div class="collapsible-body">
                                                        <ul class="side-nav-panel">
                                                @if(count($sub_categories) > '0')
                                                    @foreach($sub_categories as $sub_cat)
                                                        @if($sub_cat->main_category_id == $main_cat->category_id)
                                                            <li>
                                                                <p id="sidebar_category">
                                                                    <a href="{{ url('menu_items') }}/{{ $sub_cat->category_id }}"> <img src="{!! asset('theme/user_app/img/menu_icon_13.png') !!}" alt="img">{{ $sub_cat->category_name}} </a>
                                                                </p>
                                                            </li>
                                                        @endif
                                                @endforeach
                                            @endif
                                                        </ul>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endforeach
                    @endif
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        