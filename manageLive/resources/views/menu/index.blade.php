@include('theme.header')
<?php 
use App\Models\TagModel;
?>
<!--**********************************
    Header start
***********************************-->
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        {{ $restaurant_name }} - Menus
                    </div>
                </div>

@include('theme.common_header')
<!--**********************************
    Header end ti-comment-alt
***********************************-->

@include('theme.sidebar')

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <!-- row -->
        <div class="row"> 
            <!-- <div class="col-sm-11"></div> -->
            <div class="col-sm-12 text-right">
                <a href="{{ url('restaurant-detail') }}/{{ $restaurant_id }}" id="back_button" class="btn btn-info btn-block back-btn-new">Back</a>
            </div>
        </div>
        <br>
        <div class="form-head d-flex mb-3 mb-lg-5 align-items-start">
        <!-- <div class="form-head d-flex align-items-start"> -->
            <div class="mr-auto col-md-12  d-none d-lg-block">
                <div class="welcome-text">
                    <h4>Manage Menu</h4>
                    <div class="row">
                        <div class="col-md-9">
                            <a href="{{ url('new_menu/')}}/{{ $restaurant_id }}" class="btn btn-primary btn-block col-sm-12 col-md-3 mt-3" style="color:#fff!important;">Add Menu Item</a>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group search-area ml-3 d-inline-flex mt-3">
                                <input type="text" class="menu_search form-control" placeholder="Search here">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="flaticon-381-search-2"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- row -->
        <div class="mb-3 mb-lg-5" id="filters_div">
            <div class="row">
                <div class="col-xl-12">
                    <h4>Menu Filters</h4>
                    <form method="POST" enctype="multipart/form-data" id="filter_menu" action="{{ url('filter_menu') }}/{{ $restaurant_id }}" >
                        <div class="row">
                            <div class="col-md-3">
                                {{ csrf_field() }}
                                <input type="hidden" name="restaurant_id" value="{{ $restaurant_id }}" />
                                <select name="filter_parent_category" class="form-control" id="filter_parent_category">
                                    <option value="">Select Parent Category</option>
                            @if(count($parent_categories_array) > '0')
                                @foreach($parent_categories_array as $parent_category)
                                    <option value="{{ $parent_category->category_id }}" {{ ( $filter_parent_category == $parent_category->category_id) ? 'selected' : '' }} >{{ $parent_category->category_name }}</option>
                                @endforeach
                            @endif
                                </select>
                                <div id="errorMessage"></div>
                            </div>
                            <div class="col-md-3">
                                <select name="filter_main_category" class="form-control" id="filter_main_category">
                                    <option value="">Select Main Category</option>
                            @if(count($main_categories_array) > '0')
                                @foreach($main_categories_array as $main_category)
                                    <option value="{{ $main_category->category_id }}" {{ ( $filter_main_category == $main_category->category_id) ? 'selected' : '' }} >{{ $main_category->category_name }}</option>
                                @endforeach
                            @endif
                                </select>
                                <div id="errorMessage"></div>
                            </div>
                            <div class="col-md-3">
                                <select name="filter_sub_category" class="form-control" id="filter_sub_category">
                                    <option value="">Select Sub Category</option>
                            @if(count($sub_categories_array) > '0')
                                @foreach($sub_categories_array as $sub_category)
                                    <option value="{{ $sub_category->category_id }}" {{ ( $filter_sub_category == $sub_category->category_id) ? 'selected' : '' }} >{{ $sub_category->category_name }}</option>
                                @endforeach
                            @endif
                                </select>
                                <div id="errorMessage"></div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary btn-block" style="color:#fff!important;">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- row -->
        <div class="row">
    @if(count($menu_list) > '0')
        @foreach ($menu_list as $menu)
            <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6 results">
                <div class="card">
                    <div>
                        <a href="{{ url('menu-detail').'/'.$menu->menu_id }}" class="text-black">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    @if($menu->menu_image != "")
                                        <img class="img-fluid meu_view_img" src="../{{ config('images.menu_url') .$restaurant_id.'/'. $menu->menu_image }}" alt="Menu Image" >
                                    @else
                                        <img class="img-fluid meu_view_img" src="../{{ config('images.menu_url') }}not_found.png" alt="Menu Image" >
                                    @endif
                                </div>
                                <div class="new-arrival-content text-center mt-3">
                                    <h4  class="text-black">{{ $menu->name }}</h4>
                                    <ul class="star-rating">
                                        <li>{{ $menu->total_like }} <i class="fa fa-thumbs-o-up thumbs_down_icon" aria-hidden="true"></i></li>
                                        <li>{{ $menu->total_dislike }} <i class="fa fa-thumbs-o-down thumbs_icon" aria-hidden="true"></i></li>
                                    </ul>   

                                    <?php 
                                    $tag_icon = "";
                                    if ($menu->tag_id != "") 
                                    {
                                        $tag_details = TagModel::get_multiple_tag_details($menu->tag_id);
                                        if ($tag_details) 
                                        {
                                            foreach ($tag_details as $key => $value) 
                                            {
                                                $tag_icon .= '<img src="../'.config("images.tag_url") . $value->tag_icon.'" width="20" height="20" alt="Tag Icon" /> &nbsp;';
                                            }
                                        }
                                    }
                                    ?>

                                    <span class="price">{!! $currency_icon !!} {{ $menu->price }} &nbsp;&nbsp;&nbsp; {!! $tag_icon !!} </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
            <div class="card">
                <div>
                    <h4>No Menus Found</h4>
                </div>
            </div>
        </div>
    @endif
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->

@include('theme.footer')

<script>

$(document).ready(function (e) {

    var filter_main_category = "{{ $filter_main_category }}";
    var filter_sub_category = "{{ $filter_sub_category }}";

    // CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Filters: Get Main Category for selected Parent Category
    $( "#filter_parent_category" ).change(function() {
        
        var parent_caregory = $('#filter_parent_category :selected').val();
        $('#filter_parent_category_id').val(parent_caregory);
        
        var ids = $(this).val();
        var restaurant_id = "{{ $restaurant_id }}";

        $.ajax({
                type: "POST",
                url: "{{ url('select_main_category') }}", 
                data:  {id:parent_caregory, restaurant_id:restaurant_id},
                dataType: "json",
                success: function(data)
                {
                    $.each(data, function(key, value) 
                    {
                        if(key == 'success')
                        {
                            $main_category_list = value;
                            $('#filter_main_category').html("<option value=''> Select Main Category </option>");

                            $.each($main_category_list, function(key1, value1) 
                            {
                                $('#filter_main_category').append("<option value='"+value1['category_id']+"' "+ ( filter_main_category == value1['category_id'])+" ? 'selected' : '' "+" > "+value1['category_name']+" </option>");
                            });
                        }
                        else
                        {
                            $('#filter_main_category').html("<option value=''> Select Main Category </option>");
                            $('#filter_sub_category').html("<option value=''> Select Sub Category </option>");
                        }
                    });
                }
            });
    });

    // Filters: Get Sub Category for selected Main Category
    $( "#filter_main_category" ).change(function() {

        var parent_caregory = $('#filter_parent_category :selected').val();

        var main_caregory = $('#filter_main_category :selected').val();

        var ids = $(this).val();
        var restaurant_id = "{{ $restaurant_id }}";

        $.ajax({
                type: "POST",
                url: "{{ url('select_sub_category') }}", 
                data:  {id:main_caregory, restaurant_id:restaurant_id, parent_category:parent_caregory},
                dataType: "json",
                success: function(data)
                {
                    $.each(data, function(key, value) 
                    {
                        if(key == 'success')
                        {
                            $sub_category_list = value;
                            $('#filter_sub_category').html("<option value=''> Select Sub Category </option>");

                            $.each($sub_category_list, function(key1, value1) 
                            {
                                $('#filter_sub_category').append("<option value='"+value1['category_id']+"' "+ ( filter_sub_category == value1['category_id'])+" ? 'selected' : '' "+" > "+value1['category_name']+" </option>");
                            });
                        }
                        else
                        {
                            $('#filter_sub_category').html("<option value=''> Select Sub Category </option>");
                        }
                    });
                }
            });
    });

    // Show filters
    $( "#show_menu_filters" ).click(function() {
        $('#filters_div').show();
    });

});
</script>