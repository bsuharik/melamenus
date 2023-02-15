@include('user_app.theme.header')
@include('user_app.theme.sidebar', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details] )

<?php
$parent_category = "";
$main_category   = "";
$sub_category    = "";
$category_name   = "";

if(count($main_sub_categories) == '0')
{
    if(count($menu_items) > '0')
    {
        $parent_category = $menu_items[0]->parent_category;
        $main_category   = $menu_items[0]->main_category;
        $sub_category    = $menu_items[0]->sub_category;

        foreach ($parent_categories as $key => $value) 
        {
            if ($value->category_id == $parent_category)
            {
               $category_name = $value->category_name;
            }
        }
    }
}
?>

    <!-- categories -->
    <div class="menu-list app-section app-section-ctm">
        <div class="container">
            <div class="content">
                @if(count($main_sub_categories) > '0')

                    <ul class="tabs">
                        <li class="tab"><a href="#t1">Categories</a></li>
                        <li class="tab"><a href="#t2" id="all_items_tab" data-parent="{{ $parent_category_id }}" data-main="{{ $main_category_id }}" >All Items</a></li>
                        <li class="tab"><a href="#t3" id="top_rated_items_tab" data-parent="{{ $parent_category_id }}" data-main="{{ $main_category_id }}" >Top Rated</a></li>
                    </ul>
                    <div id="t1">
                        @foreach($main_sub_categories as $main_cat)
                            <div class="col-md-12">
                                <a href="{{ url('menu_items') }}/{{ $main_cat->category_id }}">
                                    <div class="entry">
                                        <img src="{!! asset('theme/user_app/img/sushi1.png') !!}" alt="" />
                                        <h5> {{ $main_cat->category_name }} </h5>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div id="t2">
                        
                    </div>
                    <div id="t3">

                    </div>

                @elseif(count($menu_items) > '0')
                    
                    <div class="app-title">
                        <h4>{{ $category_name }}</h4>
                    </div>

                    <div class="categories_items_tab">
                        <ul class="tabs">
                            <li class="tab"><a href="#c1" id="all_tab">All</a></li>
                        @if(count($tags_array) > '0')
                                @php($i=2)
                            @foreach($tags_array as $tag)
                                <li class="tab"><a href="#" id="tag_id" data-id="{{ $tag->tag_id }}" data-parent="{{ $parent_category }}" data-main="{{ $main_category }}" data-sub="{{ $sub_category }}" >{{ $tag->tag_name }}</a></li>
                                @php($i++)
                            @endforeach
                        @endif
                        </ul>
                        <div id="c1">
                            <div class="filter">
                            @foreach($menu_items as $menu)
                                <div class="col-md-12">
                                    <div class="entry">
                                        <a href="{{ url('menu-details') }}/{{ $menu->menu_id }}">
                                            @if($menu->menu_image != "")
                                                <img src="../{{ config('images.menu_url') .$restaurant_details->restaurant_id.'/'. $menu->menu_image }}" alt="Menu image">
                                            @else
                                                <img src="../{{ config('images.menu_url') }}not_found.png" alt="Menu image" />
                                            @endif
                                        </a>
                                        <div class="content content_new">
                                            <a href="{{ url('menu-details') }}/{{ $menu->menu_id }}">
                                                <div class="price price_cate">
                                                    <h6>{{ $menu->name }}</h6>
                                                    <h5>{!! $currency_icon !!} {{ $menu->price }} </h5>
                                                </div>
                                                <p class="new_dis"> {{ $menu->description }} </p>
                                            </a>
                                            <div class="likedislikerate">
                                                <a href="{{ url('menu-details') }}/{{ $menu->menu_id }}"></a>
                                                <a href="#" data-id="{{ $menu->menu_id }}" id="like_menu_item">
                                                    <i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;
                                                </a>
                                                {{ $menu->total_like }} &nbsp;&nbsp;&nbsp;
                                                <a href="#" data-id="{{ $menu->menu_id }}" id="unlike_menu_item">
                                                    <i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;
                                                </a>
                                                {{ $menu->total_dislike }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                        <div class="tag_filters">
                            <div class="filter" id="tag_filters">
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

<script type="text/javascript">
$(document).ready(function (e) {

    var currency_icon = '{!! $currency_icon !!}';

    $('#tag_filters').html(" ");

    // CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var main_url = '{{ url("menu-details") }}';
    var menu_url = '{{ config("images.menu_url") }}';
    var like_url = "{{ url('like_menu') }}";
    var dislike_url = "{{ url('unlike_menu') }}";

    $("#all_tab").click(function (e) {
        $('#tag_filters').html(" ");
    });

    // Get Filters data
    $('body').delegate('#tag_id','click', function(){

        var restaurant_id      = "{{ $restaurant_details->restaurant_id }}";
        var tag_id             = $(this).attr("data-id");
        var parent_category_id = $(this).attr("data-parent");
        var main_category_id   = $(this).attr("data-main");
        var sub_category_id    = $(this).attr("data-sub");

        $.ajax({
            type: "POST",
            url: "{{ url('select_tag_menus') }}", 
            data:  {restaurant_id:restaurant_id, tag_id:tag_id, parent_category_id:parent_category_id, main_category_id:main_category_id, sub_category_id:sub_category_id},
            dataType: "json",
            success: function(data){
                
                $.each(data, function(key, value) 
                {
                    // console.log(key);
                    // console.log(value);

                    if(key == 'success')
                    {
                        $menu_list = value;
                        $('#tag_filters').html("");

                        $.each($menu_list, function(key1, value1) 
                        {
                            if (value1['menu_image'] != "") 
                            {
                                var menu_image_url = "../"+menu_url+restaurant_id+"/"+value1['menu_image']+"";
                            }
                            else
                            {
                                var menu_image_url = "../"+menu_url+"/not_found.png";
                            }

                            $('#tag_filters').append('<div class="col-md-12">\
                                    <div class="entry">\
                                        <a href="'+main_url+'/'+value1['menu_id']+'">\
                                            <img src="'+menu_image_url+'" alt="">\
                                        </a>\
                                        <div class="content content_new">\
                                            <a href="'+main_url+'/'+value1['menu_id']+'">\
                                                <div class="price price_cate">\
                                                    <h6>'+value1['name']+'</h6>\
                                                    <h5> ' + currency_icon + '&nbsp;' + value1['price'] +' </h5>\
                                                </div>\
                                                <p class="new_dis"> '+value1['description']+' </p>\
                                            </a>\
                                            <div class="likedislikerate">\
                                                <a href="'+main_url+'/'+value1['menu_id']+'"></a>\
                                                <a href="#" data-id="'+value1['menu_id']+'" id="like_menu_item">\
                                                    <i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;\
                                                </a>\
                                                '+value1['total_like']+' &nbsp;&nbsp;&nbsp;\
                                                <a href="#" data-id="'+value1['menu_id']+'" id="unlike_menu_item">\
                                                    <i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;\
                                                </a>\
                                                '+value1['total_dislike']+'\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>');
                        });
                    }
                    else
                    {
                        $('#tag_filters').html(value);
                    }
                });
            }
        });
    });

    // Like Menu
    $('body').delegate('#like_menu_item','click', function(){

        var restaurant_id = "{{ $restaurant_details->restaurant_id }}";
        var menu_id       = $(this).attr("data-id");

        $.ajax({
            type: "POST",
            url: "{{ url('like_menu_item') }}", 
            data:  {menu_id:menu_id},
            dataType: "json",
            success: function(data){
                
                $.each(data, function(key, value) 
                {
                    // console.log(key);
                    // console.log(value);

                    if(key == 'success')
                    {
                        window.location.reload();
                    }
                    else if(key == 'login_error')
                    {
                        var redirect_url = "{{ url('user_login') }}/{{ $restaurant_details->restaurant_id }}";

                        window.location.href = redirect_url;
                    }
                });
            }
        });
    });

    // UnLike Menu
    $('body').delegate('#unlike_menu_item','click', function(){

        var restaurant_id = "{{ $restaurant_details->restaurant_id }}";
        var menu_id       = $(this).attr("data-id");

        $.ajax({
            type: "POST",
            url: "{{ url('unlike_menu_item') }}", 
            data:  {menu_id:menu_id},
            dataType: "json",
            success: function(data){
                
                $.each(data, function(key, value) 
                {
                    // console.log(key);
                    // console.log(value);

                    if(key == 'success')
                    {
                        window.location.reload();
                    }
                    else if(key == 'login_error')
                    {
                        var redirect_url = "{{ url('user_login') }}/{{ $restaurant_details->restaurant_id }}";

                        window.location.href = redirect_url;
                    }
                });
            }
        });
    });

    // Get All Items data
    $('body').delegate('#all_items_tab','click', function(){

        var restaurant_id      = "{{ $restaurant_details->restaurant_id }}";
        var parent_category_id = $(this).attr("data-parent");
        var main_category_id   = $(this).attr("data-main");

        $.ajax({
            type: "POST",
            url: "{{ url('select_parent_category_menus') }}", 
            data:  {restaurant_id:restaurant_id, parent_category_id:parent_category_id, main_category_id:main_category_id},
            dataType: "json",
            success: function(data){
                
                $.each(data, function(key, value) 
                {
                    // console.log(key);
                    // console.log(value);

                    if(key == 'success')
                    {
                        $menu_list = value;
                        $('#t2').html("");

                        $.each($menu_list, function(key1, value1) 
                        {
                            if (value1['menu_image'] != "") 
                            {
                                var menu_image_url = "../"+menu_url+restaurant_id+"/"+value1['menu_image']+"";
                            }
                            else
                            {
                                var menu_image_url = "../"+menu_url+"/not_found.png";
                            }

                            $('#t2').append('<div class="col-md-12">\
                                    <div class="entry">\
                                        <a href="'+main_url+'/'+value1['menu_id']+'">\
                                            <img src="../'+menu_image_url+'" alt="">\
                                        </a>\
                                        <div class="content content_new">\
                                            <a href="'+main_url+'/'+value1['menu_id']+'">\
                                                <div class="price price_cate">\
                                                    <h6>'+value1['name']+'</h6>\
                                                    <h5> ' + currency_icon + '&nbsp;' + value1['price'] +' </h5>\
                                                </div>\
                                                <p class="new_dis"> '+value1['description']+' </p>\
                                            </a>\
                                            <div class="likedislikerate">\
                                                <a href="'+main_url+'/'+value1['menu_id']+'"></a>\
                                                <a href="#" data-id="'+value1['menu_id']+'" id="like_menu_item">\
                                                    <i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;\
                                                </a>\
                                                '+value1['total_like']+' &nbsp;&nbsp;&nbsp;\
                                                <a href="#" data-id="'+value1['menu_id']+'" id="unlike_menu_item">\
                                                    <i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;\
                                                </a>\
                                                '+value1['total_dislike']+'\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>');
                        });
                    }
                    else
                    {
                        $('#t2').html(value);
                    }
                });
            }
        });
    });

    // Get Top Rated Items data
    $('body').delegate('#top_rated_items_tab','click', function(){

        var restaurant_id      = "{{ $restaurant_details->restaurant_id }}";
        var parent_category_id = $(this).attr("data-parent");
        var main_category_id   = $(this).attr("data-main");

        $.ajax({
            type: "POST",
            url: "{{ url('select_top_rated_menus') }}", 
            data:  {restaurant_id:restaurant_id, parent_category_id:parent_category_id, main_category_id:main_category_id},
            dataType: "json",
            success: function(data){
                
                $.each(data, function(key, value) 
                {
                    // console.log(key);
                    // console.log(value);

                    if(key == 'success')
                    {
                        $menu_list = value;
                        $('#t3').html("");

                        $.each($menu_list, function(key1, value1) 
                        {
                            if (value1['menu_image'] != "") 
                            {
                                var menu_image_url = "../"+menu_url+restaurant_id+"/"+value1['menu_image']+"";
                            }
                            else
                            {
                                var menu_image_url = "../"+menu_url+"/not_found.png";
                            }

                            $('#t3').append('<div class="col-md-12">\
                                    <div class="entry">\
                                        <a href="'+main_url+'/'+value1['menu_id']+'">\
                                            <img src="'+menu_image_url+'" alt="">\
                                        </a>\
                                        <div class="content content_new">\
                                            <a href="'+main_url+'/'+value1['menu_id']+'">\
                                                <div class="price price_cate">\
                                                    <h6>'+value1['name']+'</h6>\
                                                    <h5> ' + currency_icon + '&nbsp;' + value1['price'] +' </h5>\
                                                </div>\
                                                <p class="new_dis"> '+value1['description']+' </p>\
                                            </a>\
                                            <div class="likedislikerate">\
                                                <a href="'+main_url+'/'+value1['menu_id']+'"></a>\
                                                <a href="#" data-id="'+value1['menu_id']+'" id="like_menu_item">\
                                                    <i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;\
                                                </a>\
                                                '+value1['total_like']+' &nbsp;&nbsp;&nbsp;\
                                                <a href="#" data-id="'+value1['menu_id']+'" id="unlike_menu_item">\
                                                    <i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;\
                                                </a>\
                                                '+value1['total_dislike']+'\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>');
                        });
                    }
                    else
                    {
                        $('#t3').html(value);
                    }
                });
            }
        });
    });

});
</script>
        