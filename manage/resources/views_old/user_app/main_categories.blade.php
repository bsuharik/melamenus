@include('user_app.theme.header')
@include('user_app.theme.sidebar', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details] )
<?php //echo "<pre>"; print_r($in_main_categories); echo "</pre>";  exit();?>
    <!-- categories -->
    <div class="menu-list categories-list-ctm app-section app-section-ctm app-section-category">
        <div class="container">
            <div class="row">
                <ul class="tabs">
                    <li class="tab"><a href="#t1">Categories</a></li>
                    <li class="tab"><a href="#t2" id="all_items_tab" data-parent="{{ $parent_category_id }}" >All Items</a></li>
                    <li class="tab"><a href="#t3" id="top_rated_items_tab" data-parent="{{ $parent_category_id }}" >Top Rated</a></li>
                </ul> 
                <div id="t1">
                    <input type="hidden" value='{{implode(",",$in_main_categories)}}' id="in_main_categories">
                    @if(count($parent_main_categories) > '0') 
                        @foreach($parent_main_categories as $main_cat)
                            <div class="col-md-12">
                                <a href="{{ url('sub_categories') }}/{{ $main_cat->category_id }}">
                                    <div class="entry"> 
                                        @if(!empty($main_cat->category_icon))
                                        <img src="../{{config('images.category_url') .$restaurant_details->restaurant_id.'/'.$main_cat->category_icon}}" alt="img">
                                        <?php 
                                        // @else
                                        // <img src="../{{config('images.default_image_url')}}" height="40" width="40" alt="img">
                                       ?> 
                                        @endif
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
    var in_main_categories=$("#in_main_categories").val();
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
    var default_image_url="{{config('images.default_image_url')}}";
    var main_category_id = "";
    // Get All Items data
    $('body').delegate('#all_items_tab','click', function(){
        var restaurant_id      = "{{ $restaurant_details->restaurant_id }}";
        var parent_category_id = $(this).attr("data-parent"); 
        $.ajax({
            type: "POST",
            url: "{{ url('select_parent_category_menus') }}", 
            data:  {restaurant_id:restaurant_id, parent_category_id:parent_category_id, main_category_id:main_category_id,currency_icon:currency_icon,in_main_categories:in_main_categories},
            dataType: "json",
            success: function(data){
                $.each(data, function(key, value) 
                {
                    if(key == 'success'){
                        $menu_list = value;
                        $('#t2').html("");
                        if($menu_list.length >0){
                            $.each($menu_list, function(key1, value1){
                                if(value1['availiblity'] !== '2'){
                                    if (value1['tag_id'].length === 0){
                                        $tag_icons = "";
                                    }
                                    else{
                                        $tag_icons = "";
                                        $.each(value1['tag_id'], function(key2, value2) 
                                        {
                                            $tag_icons += '<img src="../'+tag_url+value2+'" alt="Tag Icon" />';
                                        });
                                    }
                                    if (value1['menu_image'] != null){
                                        var menu_image_url = "../"+menu_url+restaurant_id+"/"+value1['menu_image']+"";
                                    }else{
                                        var menu_image_url = "../"+default_image_url;
                                    }
                                    if(value1['availiblity'] == '0'){
                                        var availibility_tag='<span class="not_available_tag">Not Available</span>';
                                    }else{
                                        var availibility_tag='';
                                    }
                                    var t2_html =''; 
                                   t2_html +='<div class="col-md-12">';
                                   if(value1['allergy_tag'] >0){
                                       t2_html +='<div class="entry disable_click">';
                                       t2_html +='<a href="'+main_url+'/'+value1['menu_id']+'" class="menu_item_count menu_item_count_img_fix" data-menu_id="'+value1['menu_id']+'" data-menu_count="'+value1['menu_click_count']+'">';
                                       
                                       t2_html +='<span class="allergy_red"></span>';

                                        t2_html +='<img src="'+menu_image_url+'" alt="Menu image">';
                                       t2_html +='<div class="content content_new">';
                                       t2_html +='<div class="price price_cate">';
                                       t2_html +='<h6>'+value1['name']+'&nbsp; &nbsp; '+availibility_tag+'&nbsp;<a href="#" data-id="'+value1['menu_id']+'" id="fav_menu_item" class="fav_menu_item" >'+value1['menu_fav_icon']+'&nbsp;</a></h6>';
                                       t2_html +='<h5> '+value1['price']+' </h5>';
                                        
                                        t2_html +='</a>';
                                    }else{
                                        t2_html +='<div class="entry">';
                                        t2_html +='<a href="'+main_url+'/'+value1['menu_id']+'" class="menu_item_count menu_item_count_img_fix" data-menu_id="'+value1['menu_id']+'" data-menu_count="'+value1['menu_click_count']+'">';
                                       t2_html +='<img src="'+menu_image_url+'" alt="Menu image">';
                                       t2_html +='<div class="content content_new">';
                                       t2_html +='<div class="price price_cate">';
                                       t2_html +='<h6>'+value1['name']+'&nbsp; &nbsp; '+availibility_tag+'&nbsp;<a href="#" data-id="'+value1['menu_id']+'" id="fav_menu_item" class="fav_menu_item" >'+value1['menu_fav_icon']+'&nbsp;</a></h6>';
                                       t2_html +='<h5> '+value1['price']+' </h5>';
                                       t2_html +='</a>';
                                    }
                                   t2_html +='</div>';
                                   t2_html +='<p class="new_dis"> '+value1['description']+' </p>';
                                   t2_html +='<div class="dtl_ctm_icon" id="menu_tag_icons">'+$tag_icons+'</div>';
                                   t2_html +='<div class="likedislikerate">';
                                   // t2_html +='<a href="'+main_url+'/'+value1['menu_id']+'"></a>';
                                   t2_html +='<a href="#" data-id="'+value1['menu_id']+'" id="like_menu_item">'+value1['menu_like_icon']+'&nbsp;</a>'+value1['total_like']+' &nbsp;';
                                   t2_html +='<a href="#" data-id="'+value1['menu_id']+'" id="unlike_menu_item">'+value1['menu_unlike_icon']+'&nbsp;</a>';
                                   t2_html += ''+value1['total_dislike'];
                                   t2_html +='</div>';
                                   t2_html +='</div>';
                                   t2_html +='</a>';
                                   t2_html +='</div>';
                                   t2_html +='</div>';
                                   $('#t2').append(t2_html);
                                }
                            });
                        }else{
                            $('#t2').html('<div id="no_data_found">No Data Found</div>');
                        }
                    }
                    else{
                        $('#t2').html('<div id="no_data_found">No Data Found</div>');
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
            data:  {restaurant_id:restaurant_id, parent_category_id:parent_category_id, main_category_id:main_category_id,currency_icon:currency_icon,in_main_categories:in_main_categories},
            dataType: "json",
            success: function(data){
                $.each(data, function(key, value){
                    if(key == 'success'){
                        $menu_list = value;
                        $('#t3').html("");
                        if($menu_list.length > 0){
                            $.each($menu_list, function(key1, value1){
                                if (value1['tag_id'].length === 0){
                                    $tag_icons = "";
                                }
                                else{
                                    $tag_icons = "";
                                    $.each(value1['tag_id'], function(key2, value2) 
                                    {
                                        $tag_icons += '<img src="../'+tag_url+value2+'" alt="Tag Icon" />';
                                    });
                                }
                                if (value1['menu_image'] != null){
                                    var menu_image_url = "../"+menu_url+restaurant_id+"/"+value1['menu_image']+"";
                                }else{
                                    var menu_image_url = "../"+default_image_url; 
                                }
                                if(value1['availiblity'] == '0'){
                                    var availibility_tag='<span class="not_available_tag">Not Available</span>';
                                }else{
                                    var availibility_tag='';
                                } 
                                var t3_html='';
                               t3_html +='<div class="col-md-12">';
                                if(value1['allergy_tag'] > 0){
                                   t3_html +='<div class="entry disable_click">';
                                   t3_html +='<a href="'+main_url+'/'+value1['menu_id']+'" class="menu_item_count menu_item_count_img_fix" data-menu_id="'+value1['menu_id']+'" data-menu_count="'+value1['menu_click_count']+'">';
                                   t3_html +='<span class="allergy_red"></span>';
                                   t3_html +='<img src="'+menu_image_url+'" alt="Menu image">';
                                   t3_html +='<div class="content content_new">';
                                   t3_html +='<div class="price price_cate">';
                                   t3_html +='<h6>'+value1['name']+'&nbsp; &nbsp; '+availibility_tag+'&nbsp;<a href="#" data-id="'+value1['menu_id']+'" id="fav_menu_item" class="fav_menu_item">'+value1['menu_fav_icon']+'&nbsp;</a></h6>';
                                   t3_html +='<h5> '+value1['price']+' </h5>';
                                   
                                   t3_html +='</a>';
                                }else{
                                   t3_html +='<div class="entry">';
                                   t3_html +='<a href="'+main_url+'/'+value1['menu_id']+'" class="menu_item_count menu_item_count_img_fix" data-menu_id="'+value1['menu_id']+'" data-menu_count="'+value1['menu_click_count']+'">';
                                   t3_html +='<img src="'+menu_image_url+'" alt="Menu image">';
                                   t3_html +='<div class="content content_new">';
                                   t3_html +='<div class="price price_cate">';
                                   t3_html +='<h6>'+value1['name']+'&nbsp; &nbsp; '+availibility_tag+'&nbsp;<a href="#" data-id="'+value1['menu_id']+'" id="fav_menu_item" class="fav_menu_item">'+value1['menu_fav_icon']+'&nbsp;</a></h6>';
                                    t3_html +='<h5> '+value1['price']+' </h5>';
                                    t3_html +='</a>';
                               }
                               t3_html +='</div>';
                               t3_html +='<p class="new_dis"> '+value1['description']+' </p>';
                               t3_html +='<div class="dtl_ctm_icon" id="menu_tag_icons">'+$tag_icons+'</div>';
                               t3_html +='<div class="likedislikerate">';
                               // t3_html +='<a href="'+main_url+'/'+value1['menu_id']+'"></a>';
                               t3_html +='<a href="#" data-id="'+value1['menu_id']+'" id="like_menu_item">'+value1['menu_like_icon']+'&nbsp;</a>'+value1['total_like']+' &nbsp;';
                               t3_html +='<a href="#" data-id="'+value1['menu_id']+'" id="unlike_menu_item">'+value1['menu_unlike_icon']+'&nbsp;</a>';
                               t3_html += ''+value1['total_dislike'];
                               t3_html +='</div>';
                               t3_html +='</div>';
                               t3_html +='</a>';
                               t3_html +='</div>';
                               t3_html +='</div>';
                                $('#t3').append(t3_html);
                            });
                        }else{
                            $('#t3').html('<div id="no_data_found">No Data Found</div>');
                        }
                    }
                    else{
                        $('#t3').html('<div id="no_data_found">No Data Found</div>');
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
                    if(key == 'success')
                    {
                        var redirect_url = "{{ url('menu-details') }}/"+menu_id;
                        window.location.href = redirect_url; 
                    }
                    else if(key == 'login_error'){
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
                        var redirect_url = "{{ url('menu-details') }}/"+menu_id;
                        window.location.href = redirect_url; 
                        //window.location.reload();
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
    // favourite & /UnFavourite Menu
    $('body').delegate('#fav_menu_item','click', function(){
        var restaurant_id = "{{ $restaurant_details->restaurant_id }}";
        var menu_id       = $(this).attr("data-id");
        $.ajax({
            type: "POST",
            url: "{{ url('fav_menu_item') }}", 
            data:  {menu_id:menu_id},
            dataType: "json",
            success: function(data){
                $.each(data, function(key, value) 
                {
                    if(key == 'success')
                    {
                        var redirect_url = "{{ url('menu-details') }}/"+menu_id;
                        window.location.href = redirect_url;    
                        // window.location.reload();
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