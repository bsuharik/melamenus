@include('user_app.theme.header', ['restaurant_details' => $restaurant_details ])
@include('user_app.theme.sidebar', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_id' => $restaurant_details->restaurant_id ] ) 
<!-- <div class="slider-slick app-pages">
    <div>
    </div>
</div> -->
<!-- categories -->
<div class="menu-list categories-list-ctm app-section app-section-ctm app-section-category">
    <div class="container">
        <div class="app-title">
        </div>
        <div class="row">
            @if(count($menu_items) > '0')
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
                                if(!empty($menu->menu_image)){
                                    $menu_img_src="../".config('images.menu_url')."".$restaurant_details->restaurant_id."/".$menu->menu_image;
                                }else{
                                    $menu_img_src="../".config('images.menu_url')."not_found.png";
                                }
                                $fav_menu_icon = '<i class="fa fa-heart-o" aria-hidden="true"></i>';
                                if($menu->menu_fav > 0){
                                    $fav_menu_icon = '<i class="fa fa-heart" aria-hidden="true"></i>';
                                }
                            ?>
                            @if($menu->allergy_tag > 0 && !empty($menu->allergy_tag))
                                <div class="entry product-listing-search disable_click">
                                    <a href="{{ url('menu-details') }}/{{ $menu->menu_id }}" class="menu_item_count menu_item_count_img_fix" data-menu_id="{{ $menu->menu_id }}" data-menu_count="{{$menu->menu_click_count}}">
                                    <img src="{{$menu_img_src}}" alt="Menu image">
                                    <div class="content content_new">
                                    <div class="price price_cate">
                                        <h6> {{ $menu->name }}&nbsp;&nbsp;
                                            @if($menu->availiblity == '0')
                                            <span class="not_available_tag">Not Available</span>@endif
                                            <a href="#" data-id="{{$menu->menu_id}}" class="fav_menu_item"id="fav_menu_item">
                                            {!! $fav_menu_icon !!}</a>
                                        </h6>
                                        <h5>{{$menu->price}}</h5>
                                        <a href="{{ url('menu-details') }}/{{ $menu->menu_id }}" class="menu_item_count menu_item_count_img_fix" data-menu_id="{{ $menu->menu_id }}" data-menu_count="{{$menu->menu_click_count}}">
                                        <span class="allergy_red">Allergy!</span></a>
                                    </div>
                            @else
                                <div class="entry product-listing-search">
                                    <a href="{{ url('menu-details') }}/{{ $menu->menu_id }}" class="menu_item_count menu_item_count_img_fix" data-menu_id="{{ $menu->menu_id }}" data-menu_count="{{$menu->menu_click_count}}">
                                    <img src="{{$menu_img_src}}" alt="Menu image">
                                    <div class="content content_new">
                                        <div class="price price_cate">
                                            <h6> {{ $menu->name }}&nbsp;&nbsp;
                                                @if($menu->availiblity == '0')
                                                <span class="not_available_tag">Not Available</span>@endif
                                                <a href="#" data-id="{{$menu->menu_id}}" class="fav_menu_item"id="fav_menu_item">
                                                {!! $fav_menu_icon !!}</a>
                                            </h6>
                                            <h5>{{$menu->price}}</h5>
                                        </div>
                            @endif
                                <p class="new_dis">{{ $menu->description }}</p></a>
                                <div class="listion-icons">
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
                                            <a href="#" data-id="{{ $menu->menu_id }}" id="like_menu_item">{!! $menu_like_icon !!}&nbsp;</a>{{ $menu->total_like }} &nbsp;
                                            <a href="#" data-id="{{ $menu->menu_id }}" id="unlike_menu_item">{!! $menu_unlike_icon !!}&nbsp;
                                            </a>{{ $menu->total_dislike }}
                                        </div>
                                </div>
                                </div>
                            </div>
                        @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div id="no_data_found">
                    Menu Item Not Found
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
            var main_url = '{{ url("menu-details") }}';
            var menu_url = '{{ config("images.menu_url") }}';
            var tag_url = '{{ config("images.tag_url") }}';
            var like_url = "{{ url('like_menu') }}";
            var dislike_url = "{{ url('unlike_menu') }}";
            var default_image_url="{{config('images.default_image_url')}}";
            $.ajaxSetup({ 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }); 
    // Serch function Start
    $('#search').on('keyup',function(){
        $value=$(this).val();
        var search_name=$value.trim();
        if(search_name.length > 0){
            var restaurant_id = "{{ $restaurant_details->restaurant_id }}";
            $.ajax({
                type : 'POST',
                url : "{{ url('serch_menu_item')}}",
                // data:{'search':$value},
                data:  {'search':search_name,restaurant_id:restaurant_id,currency_icon:currency_icon},
                success:function(data){
                    $.each(data, function(key, value) 
                    {
                        if(key == 'success')
                        {
                            $menu_list = value;
                            $('#menu_search_item').html("");
                            if($menu_list.length > 0){
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
                                    if (value1['menu_image'] != null){
                                        var menu_image_url = "../"+menu_url+restaurant_id+"/"+value1['menu_image']+"";
                                    }else{
                                        var menu_image_url = "../"+default_image_url;
                                    }
                                    var search_menu_item_html =''; 
                                    if(value1['availiblity'] == '0'){
                                        var availibility_tag='<span class="not_available_tag">Not Available</span>';
                                    }else{
                                        var availibility_tag='';
                                    }
                                    search_menu_item_html +='<div class="col-md-12">';
                                    if(value1['allergy_tag'] >0){
                                        search_menu_item_html +='<div class="entry disable_click">';
                                        search_menu_item_html +='<span>! Allergy !</span>';
                                    }else{
                                        search_menu_item_html +='<div class="entry">';
                                    }
                                    search_menu_item_html +='<a href="'+main_url+'/'+value1['menu_id']+'" class="menu_item_count menu_item_count_img_fix" data-menu_id="'+value1['menu_id']+'" data-menu_count="'+value1['menu_click_count']+'" >';
                                    search_menu_item_html +='<img src="'+menu_image_url+'" alt="Menu image">';
                                    search_menu_item_html +='<div class="content content_new">';
                                    search_menu_item_html +='<div class="price price_cate">';
                                    search_menu_item_html +='<h6>'+value1['name']+'&nbsp; &nbsp; '+availibility_tag+'&nbsp;<a href="#" data-id="'+value1['menu_id']+'" class="fav_menu_item"id="fav_menu_item" class="fav_menu_item">'+value1['menu_fav_icon']+'&nbsp;</a></h6>';
                                    search_menu_item_html +='<h5> '+value1['price']+' </h5>'; 
                                    search_menu_item_html +='</a>';
                                    search_menu_item_html +='</div>';
                                    search_menu_item_html +='<p class="new_dis"> '+value1['description']+' </p>';
                                    search_menu_item_html +='<div class="dtl_ctm_icon" id="menu_tag_icons">'+$tag_icons+'</div>';
                                    search_menu_item_html +='<div class="likedislikerate">';
                                   // search_menu_item_html +='<a href="'+main_url+'/'+value1['menu_id']+'"></a>';
                                   search_menu_item_html +='<a href="#" data-id="'+value1['menu_id']+'" id="like_menu_item">'+value1['menu_like_icon']+'&nbsp;</a>'+value1['total_like']+' &nbsp;';
                                   search_menu_item_html +='<a href="#" data-id="'+value1['menu_id']+'" id="unlike_menu_item">'+value1['menu_unlike_icon']+'&nbsp;</a>';
                                   search_menu_item_html += ''+value1['total_dislike'];
                                   search_menu_item_html +='</div>';
                                   search_menu_item_html +='</div>';
                                   search_menu_item_html +='</div>';
                                   search_menu_item_html +='</div>';
                                   $('#menu_search_item').append(search_menu_item_html);
                               });
}else{
    $('#menu_search_item').html('<div id="no_data_found">Menu Item not found</div>');
}
}
else
{
    $('#menu_search_item').html('<div id="no_data_found">'+value+'</div>');
}
});
}
});
}else{
    $('#menu_search_item').html('');
}
}); 
    // Serch function Ends
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