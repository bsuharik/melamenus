@include('user_app.theme.header', ['restaurant_details' => $restaurant_details ])
@include('user_app.theme.sidebar', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_id' => $restaurant_details->restaurant_id ] )

        <div class="slider-slick app-pages">
            <div class="slider-entry">
                <img src="{!! asset('theme/user_app/img/slider1.jpg') !!}" alt="" />
                <div class="overlay"></div>
                <div class="caption">
                    <div class="container">
                        <!-- <h2>Nini's Kitchen</h2> -->
                        <!-- <p>Find your need now</p>
                        <a class="button" href="#">View Menu</a> -->
                        <a href="#"><img src="../{{ config('images.restaurant_url') .$restaurant_details->restaurant_id.'/'. $restaurant_details->restaurant_logo }}" class="restaurent_logo" alt="{{ $restaurant_details->restaurant_name }}" /></a>
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
                                            <!-- <img src="{!! asset('theme/user_app/img/sushi1.png') !!}" alt="" /> -->
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