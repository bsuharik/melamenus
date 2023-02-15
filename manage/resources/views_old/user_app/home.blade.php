@include('user_app.theme.header', ['restaurant_details' => $restaurant_details ])
@include('user_app.theme.sidebar', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_id' => $restaurant_details->restaurant_id ] ) 
<div class="slider-slick app-pages">
    <div class="slider-entry"> 
                @if(!empty($restaurant_details->restaurant_cover_image))   
                    <img src="../{{ config('images.restaurant_url') .$restaurant_details->restaurant_id.'/'. $restaurant_details->restaurant_cover_image}}">
                @else
                    @if(!empty($parent_restaurant_details->restaurant_cover_image))
                        <img src="../{{ config('images.restaurant_url') .$parent_restaurant_details->restaurant_id.'/'. $parent_restaurant_details->restaurant_cover_image}}">
                    @else
                        <img src="../{{ config('images.restaurant_default_banner_url')}}" alt="" />
                    @endif
                @endif
                <div class="overlay"></div>
                <div class="caption">
                    <div class="container"> 
                        <!-- <h2>Nini's Kitchen</h2> -->
                        <!-- <p>Find your need now</p>
                        <a class="button" href="#">View Menu</a> -->
                        <a href="javascript::void();" class="new_heart"> 
                             <?php 
                            if(!empty($fav_restaurant)){
                               $fav_icon ='<i class="fa fa-heart favs_icon" aria-hidden="true"></i>';
                            }else{
                                $fav_icon ='<i class="fa fa-heart-o favs_icon" aria-hidden="true"></i>';
                            }
                        ?> 
                            <a href="javascript::void()" id="fav_restaurant" class="new_heart">{!!$fav_icon !!}</a>
                            @if(!empty($restaurant_details->restaurant_logo))
                                <img src="../{{ config('images.restaurant_url') .$restaurant_details->restaurant_id.'/'. $restaurant_details->restaurant_logo }}" class="restaurent_logo" alt="{{ $restaurant_details->restaurant_name }}" />
                            @else
                                @if(!empty($parent_restaurant_details->restaurant_logo))
                                    <img src="../{{ config('images.restaurant_url') .$parent_restaurant_details->restaurant_id.'/'. $parent_restaurant_details->restaurant_logo}}" class="restaurent_logo">
                                @else
                                    <img src="../{{ config('images.default_image_url')}}" class="restaurent_logo" alt="">
                                @endif
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu app-section">
            <div class="">
                <!-- categories -->
                <div class="menu-list app-section app-section-home">
                    <div class="">
                        <div class="content">
                            <div id="t1">
                        @if(count($parent_categories) > '0')
                            @foreach($parent_categories as $parent_cat)
                                <div class="col-md-12">
                                    <a href="{{ url('main_categories') }}/{{ $parent_cat->category_id }}">
                                        <div class="entry">
                                           @if(!empty($parent_cat->category_icon))
                                            <img src="../{{config('images.category_url') .$parent_cat->restaurant_id.'/'.$parent_cat->category_icon}}" alt="img">
                                           @endif
                                            <h5> {{ $parent_cat->category_name }} </h5> 
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @else
                                <div class="col-md-12">
                                    No Data Found
                                </div>
                        @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end categories -->
                <!-- end menu list -->
            </div>
        </div>
@include('user_app.theme.footer')