<?php
$id = "";

if (Auth::user() !== NULL) 
{
    $id = Auth::user()->id;
}    
?>
        <div class="panel-control-left">
            <ul id="slide-out-left" class="side-nav side-nav-img collapsible" data-collapsible="accordion">
                <li class="logo_side_one">
                    <!-- <a href="{{ url('user_home') }}/{{ $restaurant_details->restaurant_id }}"><img src="../{{ config('images.restaurant_url') .$restaurant_details->restaurant_id.'/'. $restaurant_details->restaurant_logo }}" alt="Restaurant name" width="75px"/></a> -->

                    <img src="{!! asset('theme/user_app/img/logo.png') !!}" align="img">
                </li>
                <div class="login_btn_in_menu">
                    @if($id == "")
                        <button class="button sign_btn" id="redirect_user_login" data-id="{{ $restaurant_details->restaurant_id }}">Login</button>
                        <button class="button sign_btn" id="redirect_user_signup" data-id="{{ $restaurant_details->restaurant_id }}">Signup</button>

                    @else
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="button" id="logout_button">Logout
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                                <input type="hidden" name="restaurant_id" value="{{ $restaurant_details->restaurant_id }}">
                            </form>
                        </a>
                    @endif
                </div>
                <li class="first_li">
                    <a href="{{ url('user_home') }}/{{ $restaurant_details->restaurant_id}}"><i class="fa fa-home"></i>Home</a>
                </li>
                <li>
                    <div class="collapsible-header"><i class="fa fa-indent"></i>Categories <span><i class="fa fa-chevron-right"></i></span></div>
                    <div class="collapsible-body">
                        <ul class="categories-in collapsible" data-collapsible="accordion">
                    @if(count($parent_categories) > '0')
                        @foreach($parent_categories as $parent_cat)
                            <li>
                                <div class="collapsible-header">
                                   <img src="{!! asset('theme/user_app/img/menu_icon_7.png') !!}" alt="img"> {{ $parent_cat->category_name}} <span><i class="fa fa-chevron-right"></i></span>
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
                                                        <img src="{!! asset('theme/user_app/img/menu_icon_2.png') !!}" alt="img"> {{ $main_cat->category_name}} <span><i class="fa fa-chevron-right"></i></span>
                                                    </div>
                                                    <div class="collapsible-body">
                                                        <ul class="side-nav-panel">
                                                @if(count($sub_categories) > '0')
                                                    @foreach($sub_categories as $sub_cat)
                                                        @if($sub_cat->main_category_id == $main_cat->category_id)
                                                            <li>
                                                                <a href="{{ url('menu_items') }}/{{ $sub_cat->category_id }}"> <img src="{!! asset('theme/user_app/img/menu_icon_13.png') !!}" alt="img"> {{ $sub_cat->category_name}} </a>
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