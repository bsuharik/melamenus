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

<?php 
use App\Models\TagModel;
?>

    <!-- categories -->
    <div class="menu-list categories-list-ctm app-section app-section-ctm app-section-category">
        <div class="container">
            <div class="app-title">
               <!-- <h4>Deserts</h4> -->
               <!--ul class="line">
                  <li><i class="fa fa-snowflake-o"></i></li>
                  <li class="line-center"><i class="fa fa-snowflake-o"></i></li>
                  <li><i class="fa fa-snowflake-o"></i></li>
               </ul-->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="filters">
                        <button class="filter-button" type="button" data-filter="filter-0" id="tag_id" data-id="0" data-parent="{{ $parent_category }}" data-main="{{ $main_category }}" data-sub="{{ $sub_category }}" >Top rated</button>
                        @if(count($tags_array) > '0')
                                @php($i=2)
                            @foreach($tags_array as $tag)
                                <button class="filter-button" type="button" data-filter="filter-{{ $tag->tag_id }}" id="tag_id" data-id="{{ $tag->tag_id }}" data-parent="{{ $parent_category }}" data-main="{{ $main_category }}" data-sub="{{ $sub_category }}" >
                                    {{ $tag->tag_name }}
                                </button>
                                @php($i++)
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="filter">
                    @if(count($main_sub_categories) > '0')
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
                    @elseif(count($menu_items) > '0')
                            <div class="col-md-12">
                                @foreach($menu_items as $menu)
                                <div class="entry">
                                    <a href="{{ url('menu-details') }}/{{ $menu->menu_id }}">
                                        @if($menu->menu_image != "")
                                            <img src="../{{ config('images.menu_url') .$restaurant_details->restaurant_id.'/'. $menu->menu_image }}" alt="Menu image">
                                        @else
                                            <img src="../{{ config('images.menu_url') }}not_found.png" alt="Menu image" />
                                        @endif
                                        <div class="content content_new">
                                            <div class="price price_cate">
                                                <h6> {{ $menu->name }} </h6>
                                                <h5> {!! $currency_icon !!} {{ $menu->price }} </h5>
                                            </div>
                                            <p class="new_dis">{{ $menu->description }}</p>
                                            <div class="dtl_ctm_icon">  
                                        <?php 
                                        $tag_icon = "";
                                        if ($menu->tag_id != "") 
                                        {
                                            $tag_details = TagModel::get_multiple_tag_details($menu->tag_id);
                                            if ($tag_details) 
                                            {
                                                foreach ($tag_details as $key => $value) 
                                                {
                                                    $tag_icon .= '<img src="../'.config("images.tag_url") . $value->tag_icon.'" alt="Tag Icon" />';
                                                }
                                            }
                                        }
                                        ?>    
                                                {!! $tag_icon !!}    
                                            </div>
                                            <div class="likedislikerate">
                                                <a href="{{ url('menu-details') }}/{{ $menu->menu_id }}"></a>
                                                <a href="#" data-id="{{ $menu->menu_id }}" id="like_menu_item">
                                                    <i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>&nbsp;
                                                </a>{{ $menu->total_like }} &nbsp;
                                                <a href="#" data-id="{{ $menu->menu_id }}" id="unlike_menu_item">
                                                    <i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;
                                                </a>{{ $menu->total_dislike }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                    @else
                        <div>
                            No Data Found
                        </div>
                    @endif
                    </div>
                    <div id="tag_filters">
                        <div class="col-md-12">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end categories -->

@include('user_app.theme.footer')

<script type="text/javascript">
$(document).ready(function (e) {

    var currency_icon = '{!! $currency_icon !!}';

    // $('#tag_filters').html(" ");

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

    $(document).ready(function(){
        var targets = $('.filter'), 
        buttons = $('.filter-button').click(function(){
            var value = $(this).data('filter');
            // alert(value);
            if(value == "all")
                buttons.removeClass('checked'); 
            else
                $(this).toggleClass('checked'); 
            
            var checkedClasses = buttons.filter('.checked').toArray().map(function(btn){return $(btn).data('filter');}); //create array of filters

            if(checkedClasses.length === 0)
            {
                targets.show('1000');  
                $('#tag_filters').html("");
            }
            else
            {   
                $tag_icons = "";
                
                var selector = '.' + checkedClasses.join('.'), //create selector of the combined classes
                show = targets.filter(selector);      
                targets.not(show).hide('3000');
                show.show('3000');

                var tag_ids_array = [];
                $.each(checkedClasses, function(key, value) 
                {
                    var tag_id_value = value.split('-');
                    tag_ids_array.push(tag_id_value[1]);
                });

                var tag_ids = tag_ids_array.toString();
                
                if (tag_ids.length === 0)
                {
                    $('#tag_filters').html("");
                }
                else
                {
                    var restaurant_id      = "{{ $restaurant_details->restaurant_id }}";
                    var one_tag_id = $(this).attr("data-id");
                    var parent_category_id = $(this).attr("data-parent");
                    var main_category_id   = $(this).attr("data-main");
                    var sub_category_id    = $(this).attr("data-sub");

                    $.ajax({
                        type: "POST",
                        url: "{{ url('select_tag_menus') }}", 
                        data:  {restaurant_id:restaurant_id,one_tag_id:one_tag_id, tag_id:tag_ids, parent_category_id:parent_category_id, main_category_id:main_category_id, sub_category_id:sub_category_id},
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

                                        $('#tag_filters').append('<div class="entry">\
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
                }   
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
        