@include('user_app.theme.header')
@include('user_app.theme.sidebar', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details] )

    <!-- categories -->
    <div class="menu-list app-section app-section-ctm">
        <div class="container">
            <div class="content">
                @if(count($menu_items) > '0')

                        <div class="app-title">
                            <h4>Deserts</h4>
                        </div>

                        <div class="categories_items_tab">
                            <ul class="tabs">
                                <li class="tab"><a href="#c1">Top rated</a></li>
                                <li class="tab"><a href="#c2">Sweetest</a></li>
                                <li class="tab"><a href="#c3">Healthy</a></li>
                                <li class="tab"><a href="#c4">Lowcal</a></li>
                            </ul>
                            <div id="c1">
                                <div class="filter">
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Apple pie</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html">
                                                    </a>
                                                    <a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Carrot cake</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a>
                                                    <a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Crumble</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a>
                                                    <a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Fudge</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>    
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Mince pie</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>    
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Mince pie</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html">
                                                    </a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Trifle</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="c2">
                                <div class="filter spicy ">
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Apple crumble</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Crumble</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>    
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Mince pie</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Mince pie</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Trifle</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="c3">
                                <div class="filter">
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Fudge</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Mince pie</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Mince pie</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Trifle</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Apple pie</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html">
                                                    </a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Carrot cake</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html">
                                                    </a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="c4">
                                <div class="filter spicy ">
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Apple crumble</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Crumble</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Carrot cake</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Crumble</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Fudge</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Mince pie</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Mince pie</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="entry">
                                            <a href="product-details.html">
                                                <img src="{!! asset('theme/user_app/img/pizza1.png') !!}" alt="">
                                            </a>
                                            <div class="content content_new">
                                                <a href="product-details.html">
                                                    <div class="price price_cate">
                                                        <h6>Trifle</h6>
                                                        <h5>$15</h5>
                                                    </div>
                                                    <p class="new_dis">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                </a>
                                                <div class="likedislikerate">
                                                    <a href="product-details.html"></a><a hr thumbs_iconef="#"><i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;</a>104 &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;</a>10
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                @else
                    <div>
                        No Data Found
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- end categories -->

@include('user_app.theme.footer')
        