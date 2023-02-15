@include('user_app.theme.header')
@include('user_app.theme.sidebar', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details] )

    <!-- categories -->
    <div class="menu-list categories-list-ctm app-section app-section-ctm app-section-category">
        <div class="container">
            <div class="app-title">
            </div>
            <div class="row">
                <ul class="tabs">
                    <li class="tab"><a href="#t1">Categories</a></li>
                    <li class="tab"><a href="#t2" id="all_items_tab" data-parent="{{ $parent_category_id }}" >All Items</a></li>
                    <li class="tab"><a href="#t3" id="top_rated_items_tab" data-parent="{{ $parent_category_id }}" >Top Rated</a></li>
                </ul>
                <div id="t1">
            @if(count($parent_main_categories) > '0')
                @foreach($parent_main_categories as $main_cat)
                    <div class="col-md-12">
                        <a href="{{ url('sub_categories') }}/{{ $main_cat->category_id }}">
                            <div class="entry">
                                <!-- <img src="{!! asset('theme/user_app/img/sushi1.png') !!}" alt="" /> -->
                                <h5> {{ $main_cat->category_name }} </h5>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                    <div class="col-md-12" id="no_data_found">
                        No Data Found
                    </div>
            @endif
                </div>
                <div id="t2" class="filter">
            
                </div>
                <div id="t3" class="filter">
                    
                </div>
            </div>
        </div>
    </div>
    <!-- end categories -->

@include('user_app.theme.footer')

<script type="text/javascript">
$(document).ready(function (e) {

    var currency_icon = '{!! $currency_icon !!}';

    $('#t2').html(" ");
    $('#t3').html(" ");

    // CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var main_url = '{{ url("menu-details") }}';
    var menu_url = '{{ config("images.menu_url") }}';
    var tag_url = '{{ config("images.tag_url") }}';
    var like_url = "{{ url('like_menu') }}";
    var dislike_url = "{{ url('unlike_menu') }}";
    var main_category_id = "";

    // Get All Items data
    $('body').delegate('#all_items_tab','click', function(){

        var restaurant_id      = "{{ $restaurant_details->restaurant_id }}";
        var parent_category_id = $(this).attr("data-parent");

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
                            if (value1['tag_id'].length === 0) 
                            {
                                $tag_icons = "";
                            }
                            else
                            {
                                $tag_icons = "";

                                $.each(value1['tag_id'], function(key2, value2) 
                                {
                                    $tag_icons += '<img src="../'+tag_url+value2+'" alt="Tag Icon" />';
                                });
                            }

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
                                                        <img src="'+menu_image_url+'" alt="Menu image">\
                                                        <div class="content content_new">\
                                                            <div class="price price_cate">\
                                                                <h6> '+value1['name']+' </h6>\
                                                                <h5> ' + currency_icon + '&nbsp;' + value1['price'] +' </h5>\
                                                            </div>\
                                                            <p class="new_dis"> '+value1['description']+' </p>\
                                                            <div class="dtl_ctm_icon" id="menu_tag_icons">\
                                                            '+$tag_icons+'\
                                                            </div>\
                                                            <div class="likedislikerate">\
                                                                <a href="'+main_url+'/'+value1['menu_id']+'"></a>\
                                                                <a href="#" data-id="'+value1['menu_id']+'" id="like_menu_item">\
                                                                    <i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;\
                                                                </a>'+value1['total_like']+' &nbsp;\
                                                                <a href="#" data-id="'+value1['menu_id']+'" id="unlike_menu_item">\
                                                                    <i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;\
                                                                </a>'+value1['total_dislike']+'\
                                                            </div>\
                                                        </div>\
                                                    </a>\
                                                </div>\
                                            </div>');
                        });
                    }
                    else
                    {
                        $('#t2').html('<div id="no_data_found">'+value+'</div>');
                    }
                });
            }
        });
    });

    // Get Top Rated Items data
    $('body').delegate('#top_rated_items_tab','click', function(){

        var restaurant_id      = "{{ $restaurant_details->restaurant_id }}";
        var parent_category_id = $(this).attr("data-parent");

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
                            if (value1['tag_id'].length === 0) 
                            {
                                $tag_icons = "";
                            }
                            else
                            {
                                $tag_icons = "";

                                $.each(value1['tag_id'], function(key2, value2) 
                                {
                                    $tag_icons += '<img src="../'+tag_url+value2+'" alt="Tag Icon" />';
                                });
                            }

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
                                                        <img src="'+menu_image_url+'" alt="Menu image">\
                                                        <div class="content content_new">\
                                                            <div class="price price_cate">\
                                                                <h6> '+value1['name']+' </h6>\
                                                                <h5> ' + currency_icon + '&nbsp;' + value1['price'] +' </h5>\
                                                            </div>\
                                                            <p class="new_dis"> '+value1['description']+' </p>\
                                                            <div class="dtl_ctm_icon" id="menu_tag_icons">\
                                                            '+$tag_icons+'\
                                                            </div>\
                                                            <div class="likedislikerate">\
                                                                <a href="'+main_url+'/'+value1['menu_id']+'"></a>\
                                                                <a href="#" data-id="'+value1['menu_id']+'" id="like_menu_item">\
                                                                    <i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;\
                                                                </a>'+value1['total_like']+' &nbsp;\
                                                                <a href="#" data-id="'+value1['menu_id']+'" id="unlike_menu_item">\
                                                                    <i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;\
                                                                </a>'+value1['total_dislike']+'\
                                                            </div>\
                                                        </div>\
                                                    </a>\
                                                </div>\
                                            </div>');
                        });
                    }
                    else
                    {
                        $('#t3').html('<div id="no_data_found">'+value+'</div>');
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

});
</script>