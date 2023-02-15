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
                    
                    
                </li>
                <li>
                    <div class="collapsible-header"><i class="fa fa-indent"></i>Menu <span><i class="fa fa-chevron-right"></i></span></div>
                    <div class="collapsible-body">
                        <ul class="categories-in collapsible" data-collapsible="accordion">
                            @if(count($parent_categories) > '0')
                        @foreach($parent_categories as $parent_cat)
                            <li>
                                <div class="collapsible-header">
                                   
                                        @if(!empty($parent_cat->category_icon))
                                            <img src="../{{config('images.category_url') .$restaurant_details->restaurant_id.'/'.$parent_cat->category_icon}}" alt="img">
                                        @else
                                           <img src="../{{config('images.default_image_url')}}" height="40" width="40" alt="img">
                                        @endif
                                   
                                   <p id="sidebar_category">{{ $parent_cat->category_name}} </p> <span><i class="fa fa-chevron-right"></i></span>
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
                                                            @if(!empty($main_cat->category_icon))
                                                                <img src="../{{config('images.category_url') .$restaurant_details->restaurant_id.'/'.$main_cat->category_icon}}" alt="img">
                                                            @else
                                                                <img src="../{{config('images.default_image_url')}}" height="40" width="40" alt="img">
                                                            @endif
                                                            {{ $main_cat->category_name}} </p> <span><i class="fa fa-chevron-right"></i></span>
                                                        @else
                                                            <a href="{{ url('sub_categories') }}/{{ $main_cat->category_id }}" style="padding: 0px;">
                                                                @if(!empty($main_cat->category_icon))
                                                                <img src="../{{config('images.category_url') .$restaurant_details->restaurant_id.'/'.$main_cat->category_icon}}" alt="img">
                                                                @else
                                                                <img src="../{{config('images.default_image_url')}}" height="40" width="40" alt="img">
                                                                 @endif
                                                                 {{ $main_cat->category_name}} </p>
                                                            </a>
                                                        @endif
                                                    @else
                                                        <a href="{{ url('sub_categories') }}/{{ $main_cat->category_id }}" style="padding: 0px;">
                                                            @if(!empty($main_cat->category_icon))
                                                            <img src="../{{config('images.category_url') .$restaurant_details->restaurant_id.'/'.$main_cat->category_icon}}" alt="img">
                                                            @else
                                                            <img src="../{{config('images.default_image_url')}}" height="40" width="40" alt="img">
                                                            @endif{{ $main_cat->category_name}} </p>
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
                                                                    <a href="{{ url('menu_items') }}/{{ $sub_cat->category_id }}"> 
                                                                    @if(!empty($sub_cat->category_icon))
                                                                    <img src="../{{config('images.category_url') .$restaurant_details->restaurant_id.'/'.$sub_cat->category_icon}}" alt="img" style="max-width: 40px;">
                                                                    @else 
                                                                    <img src="../{{config('images.default_image_url')}}" height="40" width="40" alt="img">
                                                                    @endif
                                                                    {{ $sub_cat->category_name}} </a>
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
        <div class="panel-control-right">
            <div id="slide-out-right" class="side-nav">
                <div class="row entry">
                    <div class="col s4"><img src="{!! asset('theme/user_app/img/cart1.png') !!}" alt="" /></div>
                    <div class="col s6">
                        <div class="desc">
                            <h6>Food Title</h6>
                            <div class="rating">
                                <span class="active"><i class="fa fa-star"></i></span><span class="active"><i class="fa fa-star"></i></span><span class="active"><i class="fa fa-star"></i></span>
                                <span class="active"><i class="fa fa-star"></i></span><span class=""><i class="fa fa-star"></i></span>
                            </div>
                            <h6><span>$20.00</span></h6>
                        </div>
                    </div>
                    <div class="col s2">
                        <div class="action"><i class="fa fa-remove"></i></div>
                    </div>
                </div>
                <div class="row entry">
                    <div class="col s4"><img src="{!! asset('theme/user_app/img/cart2.png') !!}" alt="" /></div>
                    <div class="col s6">
                        <div class="desc">
                            <h6>Drink Title</h6>
                            <div class="rating">
                                <span class="active"><i class="fa fa-star"></i></span><span class="active"><i class="fa fa-star"></i></span><span class="active"><i class="fa fa-star"></i></span>
                                <span class=""><i class="fa fa-star"></i></span><span class=""><i class="fa fa-star"></i></span>
                            </div>
                            <h6><span>$10.00</span></h6>
                        </div>
                    </div>
                    <div class="col s2">
                        <div class="action"><i class="fa fa-remove"></i></div>
                    </div>
                </div>
                <div class="row price">
                    <div class="col s8">
                        <h6>Total</h6>
                    </div>
                    <div class="col s4">
                        <h6>$30.00</h6>
                    </div>
                </div>
                <ul>
                    <li><button class="button">Reservation</button></li>
                    <li><button class="button">View Cart</button></li>
                </ul>
            </div>
        </div>