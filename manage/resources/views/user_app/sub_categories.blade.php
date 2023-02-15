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
            <div class="row" style="margin-left: 0;margin-right: 0;">
                @if(count($main_sub_categories) > '0')
                    <div class="col-md-12">
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
                        </div>
                        <div id="t2">
                        </div>
                        <div id="t3">
                        </div>
                    </div>
                @elseif(count($menu_items) > '0')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="filters">
                                <button class="filter-button" type="button" data-filter="filter-0" id="tag_id" data-id="0" data-parent="{{ $parent_category }}" data-main="{{ $main_category }}" data-sub="{{ $sub_category }}" >TOP RATED</button>
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
                                <div class="col-md-12">
                                <?php 
                                   if(Auth::check()){
                                     $menu_data=$menu_items;
                                   }else{
                                        $menu_data=$menu_items;
                                   }
                                ?>  
                                @foreach($menu_data as $menu)
                                    <?php
                                        $menu_img_src="../".config('images.menu_url')."not_found.png";
                                        if($menu->menu_image != ""){
                                            $menu_img_src="../".config('images.menu_url')."".$restaurant_details->restaurant_id."/".$menu->menu_image;
                                        }
                                        $fav_menu_icon = '<i class="fa fa-heart-o" aria-hidden="true"></i>';
                                        if($menu->menu_fav > 0){
                                            $fav_menu_icon = '<i class="fa fa-heart" aria-hidden="true"></i>';
                                        }
                                    ?>
                                    @if($menu->allergy_tag > 0 && !empty($menu->allergy_tag))
                                     
                                        <div class="entry disable_click">
                                            <a href="{{ url('menu-details') }}/{{ $menu->menu_id }}" class="menu_item_count menu_item_count_img_fix" data-menu_id="{{ $menu->menu_id }}" data-menu_count="{{$menu->menu_click_count}}"></a>
                                            <img src="{{$menu_img_src}}" alt="Menu image" style="opacity:0.3;">
											<span class="allergy_red" style="opacity:1;"></span>
                                            <div class="content content_new">
                                            <div class="price price_cate">
                                                <a href="{{ url('menu-details') }}/{{ $menu->menu_id }}" class="menu_item_count menu_item_count_img_fix" data-menu_id="{{ $menu->menu_id }}" data-menu_count="{{$menu->menu_click_count}}">
                                                    <h6> {{ $menu->name }}&nbsp;&nbsp;
                                                        @if($menu->availiblity == '0')
                                                        <span class="not_available_tag">Not Available</span>@endif
                                                        <a href="#" data-id="{{$menu->menu_id}}" class="fav_menu_item"id="fav_menu_item">
                                                        {!! $fav_menu_icon !!}</a>
                                                    </h6>
                                                </a>
                                                <h5>{{$menu->price}}</h5>
                                                <a href="{{ url('menu-details') }}/{{ $menu->menu_id }}" class="menu_item_count menu_item_count_img_fix" data-menu_id="{{ $menu->menu_id }}" data-menu_count="{{$menu->menu_click_count}}">
                                                </a>
                                            </div>
                                            
                                    @else 
                                        <div class="entry">
                                            <a href="{{ url('menu-details') }}/{{ $menu->menu_id }}" class="menu_item_count menu_item_count_img_fix" data-menu_id="{{ $menu->menu_id }}" data-menu_count="{{$menu->menu_click_count}}">
                                            <img src="{{$menu_img_src}}" alt="Menu image"></a>
                                            <div class="content content_new">
                                                <div class="price price_cate">
                                                    <a href="{{ url('menu-details') }}/{{ $menu->menu_id }}" class="menu_item_count menu_item_count_img_fix" data-menu_id="{{ $menu->menu_id }}" data-menu_count="{{$menu->menu_click_count}}">
                                                        <h6> {{ $menu->name }}&nbsp;&nbsp;
                                                            @if($menu->availiblity == '0')
                                                            <span class="not_available_tag">Not Available</span>@endif
                                                            <a href="#" data-id="{{$menu->menu_id}}" class="fav_menu_item"id="fav_menu_item">
                                                            {!! $fav_menu_icon !!}</a>
                                                        </h6>
                                                    </a>
                                                    <h5>{{$menu->price}}</h5>
                                                </div>
                                            
                                    @endif
                                    <p class="new_dis">{{ $menu->description }}</p>
                                    <div class="dtl_ctm_icon">  
                                        <?php 
                                        $tag_icon = "";
                                        if (!empty($menu->tag_detail)){
                                            foreach ($menu->tag_detail as $key => $value) 
                                            {
                                                $tag_icon .= '<img src="../'.config("images.tag_url") . $value->tag_icon.'" alt="Tag Icon" />';
                                            }
                                        }
                                        ?>    
                                                {!! $tag_icon !!}    
                                    </div>
                                    <?php 
                                        $menu_like_icon = '<i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>';
                                        $menu_unlike_icon = '<i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>';
                                        $fav_menu_icon = '<i class="fa fa-heart-o" aria-hidden="true"></i>';
                                        if (!empty($menu->user_menu_votes) && isset($menu->user_menu_votes)){
                                            $user_menu_vote = $menu->user_menu_votes->vote;
                                            if ($user_menu_vote == "1"){
                                                $menu_like_icon = '<i class="fa fa-thumbs-up thumbs_icon" aria-hidden="true"></i>';
                                            }
                                            else if($user_menu_vote == "0"){
                                                $menu_unlike_icon = '<i class="fa fa-thumbs-down thumbs_down_icon" aria-hidden="true"></i>';
                                            }
                                        } 
                                    ?>
                                    <div class="likedislikerate">
                                        <a href="#" data-id="{{ $menu->menu_id }}" id="like_menu_item">
                                            {!! $menu_like_icon !!}&nbsp;
                                        </a>{{ $menu->total_like }} &nbsp;
                                        <a href="#" data-id="{{ $menu->menu_id }}" id="unlike_menu_item">
                                            {!! $menu_unlike_icon !!}&nbsp;
                                        </a>{{ $menu->total_dislike }}
                                    </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            </div>
                            <div id="tag_filters">
                                <div class="col-md-12">
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row fefar4">
                        <div class="col-md-12">
                            <div class="filters">
                                <button class="filter-button" type="button" data-filter="filter-0" id="tag_id" data-id="0" data-parent="{{ $parent_category }}" data-main="{{ $main_category }}" data-sub="{{ $sub_category }}" >TOP RATED</button>
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
                    <div id="no_data_found">
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
    // CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // $('#tag_filters').html(" ");
    var main_url = '{{ url("menu-details") }}';
    var menu_url = '{{ config("images.menu_url") }}';
    var tag_url = '{{ config("images.tag_url") }}';
    var like_url = "{{ url('like_menu') }}";
    var dislike_url = "{{ url('unlike_menu') }}";
    var default_image_url="{{config('images.default_image_url')}}";
    // Get All Items data
    $('body').delegate('#all_items_tab','click', function(){
        var restaurant_id      = "{{ $restaurant_details->restaurant_id }}";
        var parent_category_id = $(this).attr("data-parent");
        var main_category_id   = $(this).attr("data-main");
        $.ajax({
            type: "POST",
            url: "{{ url('select_parent_category_menus') }}", 
            data:  {restaurant_id:restaurant_id, parent_category_id:parent_category_id, main_category_id:main_category_id,currency_icon:currency_icon},
            dataType: "json",
            success: function(data){
                $.each(data, function(key, value) 
                {
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
                            if (value1['menu_image'] != null && value1['menu_image'].length >0 && value1['menu_image'] !=''){
                                var menu_image_url = "../"+menu_url+restaurant_id+"/"+value1['menu_image']+"";
                            }else{
                                var menu_image_url = "../"+default_image_url;
                            }
                            var t2_html =''; 
                            if(value1['availiblity'] == '0'){
                                var availibility_tag='<span class="not_available_tag">Not Available</span>';
                            }else{
                                var availibility_tag='';
                            }
                           t2_html +='<div class="col-md-12">';
                            if(value1['allergy_tag'] >0){
                               t2_html +='<div class="entry disable_click">';
                               t2_html +='<a href="'+main_url+'/'+value1['menu_id']+'" class="menu_item_count menu_item_count_img_fix" data-menu_id="'+value1['menu_id']+'" data-menu_count="'+value1['menu_click_count']+'">';
                                t2_html +='<img src="'+menu_image_url+'" alt="Menu image">';
                               t2_html +='<div class="content content_new">';
                               t2_html +='<div class="price price_cate">';
                               t2_html +='<h6>'+value1['name']+'&nbsp; &nbsp; '+availibility_tag+'&nbsp;<a href="#" data-id="'+value1['menu_id']+'" id="fav_menu_item" class="fav_menu_item" >'+value1['menu_fav_icon']+'&nbsp;</a></h6>';
                               t2_html +='<h5> '+value1['price']+' </h5>';
                               t2_html +='<a href="'+main_url+'/'+value1['menu_id']+'" class="menu_item_count menu_item_count_img_fix" data-menu_id="'+value1['menu_id']+'" data-menu_count="'+value1['menu_click_count']+'">';
                                t2_html +='<span class="allergy_red">Allergy!</span>';
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
                           t2_html +='</div>';
                           t2_html +='</div>';
                           $('#t2').append(t2_html);
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
        var main_category_id   = $(this).attr("data-main");
        $.ajax({
            type: "POST",
            url: "{{ url('select_top_rated_menus') }}", 
            data:  {restaurant_id:restaurant_id, parent_category_id:parent_category_id, main_category_id:main_category_id,currency_icon:currency_icon},
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
                            if (value1['menu_image'] != null && value1['menu_image'].length >0 && value1['menu_image'] !=''){
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
                            if(value1['allergy_tag'] >0){
                                t3_html +='<div class="entry disable_click">';
                                t3_html +='<a href="'+main_url+'/'+value1['menu_id']+'" class="menu_item_count menu_item_count_img_fix" data-menu_id="'+value1['menu_id']+'" data-menu_count="'+value1['menu_click_count']+'">';
                               t3_html +='<img src="'+menu_image_url+'" alt="Menu image">';
                               t3_html +='<div class="content content_new">';
                               t3_html +='<div class="price price_cate">';
                               t3_html +='<h6>'+value1['name']+'&nbsp; &nbsp; '+availibility_tag+'&nbsp;<a href="#" data-id="'+value1['menu_id']+'" id="fav_menu_item" class="fav_menu_item">'+value1['menu_fav_icon']+'&nbsp;</a></h6>';
                               t3_html +='<h5> '+value1['price']+' </h5>';
                               t3_html +='<a href="'+main_url+'/'+value1['menu_id']+'" class="menu_item_count menu_item_count_img_fix" data-menu_id="'+value1['menu_id']+'" data-menu_count="'+value1['menu_click_count']+'">';
                               t3_html +='<span class="allergy_red">Allergy!</span>';
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
                           t3_html +='</div>';
                           t3_html +='</div>';
                            $('#t3').append(t3_html);
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
    $(document).ready(function(){
        var targets = $('.filter'), 
        buttons = $('.filter-button').click(function(){
            var value = $(this).data('filter');
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
                        data:  {restaurant_id:restaurant_id,one_tag_id:one_tag_id, tag_id:tag_ids, parent_category_id:parent_category_id, main_category_id:main_category_id, sub_category_id:sub_category_id,currency_icon:currency_icon},
                        dataType: "json",
                        success: function(data){ 
                            $.each(data, function(key, value) 
                            {
                                 // console.log(key);
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
                                        if (value1['menu_image'] != null && value1['menu_image'].length >0 && value1['menu_image'] !=''){
                                            var menu_image_url = "../"+menu_url+restaurant_id+"/"+value1['menu_image']+"";
                                        }else{
                                            var menu_image_url = "../"+default_image_url;
                                        }
                                        if(value1['availiblity'] == '0'){
                                            var availibility_tag='<span class="not_available_tag">Not Available</span>';
                                        }else{
                                            var availibility_tag='';
                                        }
                                        if(sub_category_id ==""){
                                            var tag_filters='';
                                            tag_filters +='<div class="col-md-12">';
                                            if(value1['allergy_tag'] >0){
                                                tag_filters +='<div class="entry disable_click">';
                                                tag_filters +='<a href="'+main_url+'/'+value1['menu_id']+'" class="menu_item_count menu_item_count_img_fix" data-menu_id="'+value1['menu_id']+'" data-menu_count="'+value1['menu_click_count']+'">';
                                                tag_filters +='<img src="'+menu_image_url+'" alt="Menu image">';
                                                tag_filters +='<div class="content content_new">';
                                                tag_filters +='<div class="price price_cate">';
                                                tag_filters +='<h6>'+value1['name']+'&nbsp; &nbsp; '+availibility_tag+'&nbsp;<a href="#" data-id="'+value1['menu_id']+'" id="fav_menu_item" class="fav_menu_item">'+value1['menu_fav_icon']+'&nbsp;</a></h6>';
                                                tag_filters +='<h5> '+value1['price']+' </h5>';
                                                tag_filters +='<a href="'+main_url+'/'+value1['menu_id']+'" class="menu_item_count menu_item_count_img_fix" data-menu_id="'+value1['menu_id']+'" data-menu_count="'+value1['menu_click_count']+'">';
                                                tag_filters +='<span class="allergy_red">Allergy!</span>';
                                                tag_filters +='</a>';
                                            }else{
                                                tag_filters +='<div class="entry">';
                                                tag_filters +='<a href="'+main_url+'/'+value1['menu_id']+'" class="menu_item_count menu_item_count_img_fix" data-menu_id="'+value1['menu_id']+'" data-menu_count="'+value1['menu_click_count']+'">';
                                                tag_filters +='<img src="'+menu_image_url+'" alt="Menu image">';
                                                tag_filters +='<div class="content content_new">';
                                                tag_filters +='<div class="price price_cate">';
                                                tag_filters +='<h6>'+value1['name']+'&nbsp; &nbsp; '+availibility_tag+'&nbsp;<a href="#" data-id="'+value1['menu_id']+'" id="fav_menu_item" class="fav_menu_item">'+value1['menu_fav_icon']+'&nbsp;</a></h6>';
                                                tag_filters +='<h5> '+value1['price']+' </h5>';
                                                tag_filters +='</a>';
                                            }
                                            tag_filters+='</div>';
                                            tag_filters+=' <p class="new_dis"> '+value1['description']+' </p>';
                                            tag_filters+='<div class="dtl_ctm_icon" id="menu_tag_icons">'+$tag_icons+'</div>';
                                            tag_filters+='<div class="likedislikerate">';
                                            // tag_filters+='<a href="'+main_url+'/'+value1['menu_id']+'"></a>';
                                            tag_filters+='<a href="#" data-id="'+value1['menu_id']+'" id="like_menu_item">'+value1['menu_like_icon']+'&nbsp;</a>'+value1['total_like']+' &nbsp;';
                                            tag_filters+='<a href="#" data-id="'+value1['menu_id']+'" id="unlike_menu_item">'+value1['menu_unlike_icon']+'&nbsp;</a>';
                                            tag_filters+= ''+value1['total_dislike'];
                                            tag_filters+='</div>';
                                            tag_filters+='</div>'; 
                                            tag_filters+='</div>';
                                            tag_filters+='</div>'
                                            $('#tag_filters').append(tag_filters);
                                        }else{
                                            if(value1['menu_sub_category'] ==sub_category_id){
                                                var tag_filters='';
                                                tag_filters +='<div class="col-md-12">';
                                                if(value1['allergy_tag'] >0){
                                                    tag_filters+='<div class="entry disable_click">';
                                                    tag_filters +='<a href="'+main_url+'/'+value1['menu_id']+'" class="menu_item_count menu_item_count_img_fix" data-menu_id="'+value1['menu_id']+'" data-menu_count="'+value1['menu_click_count']+'">';
                                                    tag_filters +='<div class="allergy_tag_main"><span class="allergy_tag">! Allergy !</span></div>';
                                                    tag_filters +='</a>';
                                                }else{
                                                    tag_filters+='<div class="entry">';
                                                }
                                                tag_filters+='<a href="'+main_url+'/'+value1['menu_id']+'" class="menu_item_count menu_item_count_img_fix" data-menu_id="'+value1['menu_id']+'" data-menu_count="'+value1['menu_click_count']+'" >';
                                                tag_filters+='<img src="'+menu_image_url+'" alt="Menu image">';
                                                tag_filters+='<div class="content content_new">';
                                                tag_filters+='<div class="price price_cate">';
                                                tag_filters+='<h6> '+value1['name']+'&nbsp;&nbsp; '+availibility_tag+'&nbsp;<a href="#" data-id="'+value1['menu_id']+'" class="fav_menu_item"id="fav_menu_item" class="fav_menu_item">'+value1['menu_fav_icon']+'</a> </h6>';
                                                tag_filters+='<h5> ' +value1['price']+' </h5>';
                                                tag_filters+='</a>';
                                                tag_filters+='</div>';
                                                tag_filters+=' <p class="new_dis"> '+value1['description']+' </p>';
                                                tag_filters+='<div class="dtl_ctm_icon" id="menu_tag_icons">'+$tag_icons+'</div>';
                                                tag_filters+='<div class="likedislikerate">';
                                                // tag_filters+='<a href="'+main_url+'/'+value1['menu_id']+'"></a>';
                                                tag_filters+='<a href="#" data-id="'+value1['menu_id']+'" id="like_menu_item">'+value1['menu_like_icon']+'&nbsp;</a>'+value1['total_like']+' &nbsp;';
                                                tag_filters+='<a href="#" data-id="'+value1['menu_id']+'" id="unlike_menu_item">'+value1['menu_unlike_icon']+'&nbsp;</a>';
                                                tag_filters+= ''+value1['total_dislike'];
                                                tag_filters+='</div>';
                                                tag_filters+='</div>';
                                                tag_filters+='</div>';
                                                tag_filters+='</div>';
                                                $('#tag_filters').append(tag_filters);
                                            }
                                        }
                                    });
                                }
                                else
                                {
                                    $('#tag_filters').html('<div id="no_data_found">'+value+'</div>');
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
                    if(key == 'success'){
                         var redirect_url = "{{ url('menu-details') }}/"+menu_id;
                        window.location.href = redirect_url; 
                    }else if(key == 'login_error'){
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
                $.each(data, function(key, value) {
                    if(key == 'success'){
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
    // favourite & UnFavourite Menu
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
});
    </script>