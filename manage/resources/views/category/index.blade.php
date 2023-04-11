@include('theme.header')
<!--**********************************
    Header start
***********************************-->
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        {{ $restaurant_name }} - Category Management
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
                        <!-- <div class="form-head d-flex mb-3 mb-lg-5 align-items-start"> -->
                        <div class="form-head d-flex mb-3 align-items-start">
                            <div class="mr-auto d-none  col-md-12 d-lg-block">
                                <div class="welcome-text">
                                    <h4>Manage Category</h4>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <a data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-primary btn-block col-sm-12 col-md-3  mt-3" style="color:#fff!important;">Add Category</a>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group search-area ml-3 d-inline-flex mt-3">
                                                <input type="text" class="category_search form-control" placeholder="Search here">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="flaticon-381-search-2"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="app">
                                @include('theme.flash-message')
                                @yield('content')
                            </div>
                        </div>
                        <!-- row -->
                        <div class="container-fluid" id="filters_div">
                            <div class="row">
                                <div class="col-xl-12">
                                    <h4>Category Filters</h4>
                                    <form method="POST" enctype="multipart/form-data" id="filter_category" action="{{ url('filter_category') }}/{{ $restaurant_id }}">
                                        <div class="row">
                                            <div class="col-md-3">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="restaurant_id" value="{{ $restaurant_id }}" />
                                                <select name="filter_parent_category" class="form-control" id="filter_parent_category">
                                                    <option value="">Select Parent Category</option>
                                                    @if(count($parent_categories_array) > '0')
                                                    @foreach($parent_categories_array as $parent_category)
                                                    <option value="{{ $parent_category->category_id }}" {{ ( $filter_parent_category == $parent_category->category_id) ? 'selected' : '' }}>{{ $parent_category->category_name }}</option>
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
                                                    <option value="{{ $main_category->category_id }}" {{ ( $filter_main_category == $main_category->category_id) ? 'selected' : '' }}>{{ $main_category->category_name }}</option>
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
                                                    <option value="{{ $sub_category->category_id }}" {{ ( $filter_sub_category == $sub_category->category_id) ? 'selected' : '' }}>{{ $sub_category->category_name }}</option>
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
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xl-12 results">
                                    <ul id="myUL" class="sortable_paraent_cat">
                                        @if(count($parent_categories) > '0')
                                        @foreach($parent_categories as $parent_cat)
                                        <li class="ui-state-default sortable_paraent_li" data-cat_id="{{$parent_cat->category_id}}">
                                            <span class="caret">
                                                <?php
                                                if (!empty($parent_cat->category_icon)) {
                                                    $parent_cat_icon = config('images.category_url') . $restaurant_id . '/' . $parent_cat->category_icon;
                                                } else {
                                                    $parent_cat_icon = config('images.default_image_url');
                                                }
                                                ?>
                                                <p><img src="../{{$parent_cat_icon}}" width="40" height="40" alt="Category Icon" id= /> {{ $parent_cat->category_name}}
                                                    <a data-toggle="modal" data-target="#deleteCategoryModal" data-category="{{ $parent_cat->category_id}}" class="delete-btn deleteCategory"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    <a href="#" class="edit-btn updateCategory" data-toggle="modal" data-target="#updateCategoryModal" data-id="{{ $parent_cat->category_id}}" data-name="{{ $parent_cat->category_name}}" data-full-icon="../{{config('images.category_url') .$restaurant_id.'/'.$parent_cat->category_icon }}" data-icon="{{ $parent_cat->category_icon }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                </p>
                                            </span>
                                            <ul class="sortable_main_cat nested" data-cat_id="{{$parent_cat->category_id}}">
                                                @if(count($main_categories) > '0')
                                                @foreach($main_categories as $main_cat)
                                                @if($main_cat->parent_category_id == $parent_cat->category_id)
                                                <li class="ui-state-default sortable_main_li{{$parent_cat->category_id}}" data-cat_id="{{$main_cat->category_id}}">
                                                    <span class="caret">
                                                        <?php
                                                        if (!empty($main_cat->category_icon)) {
                                                            $main_cat_icon = config('images.category_url') . $restaurant_id . '/' . $main_cat->category_icon;
                                                        } else {
                                                            $main_cat_icon = config('images.default_image_url');
                                                        }
                                                        ?>
                                                        <p><img src="../{{$main_cat_icon}}" width="40" height="40" alt="Category Icon" id= /> {{ $main_cat->category_name}}
                                                            <a data-toggle="modal" data-target="#deleteCategoryModal" data-category="{{ $main_cat->category_id}}" class="delete-btn deleteCategory"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                            <a href="#" class="edit-btn updateCategory" data-toggle="modal" data-target="#updateCategoryModal" data-id="{{ $main_cat->category_id}}" data-name="{{ $main_cat->category_name}}" data-full-icon="../{{config('images.category_url') .$restaurant_id.'/'.$main_cat->category_icon }}" data-icon="{{ $main_cat->category_icon }}" data-display_type="{{ $main_cat->display_type}}" data-day="{{$main_cat->day}}" data-start_time="{{ $main_cat->start_time}}" data-end_time="{{ $main_cat->end_time}}" data-category_main="1"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                        </p>
                                                    </span>
                                                    <ul class="nested sortable_sub_cat" data-cat_id="{{$main_cat->category_id}}" data-parent_id="{{$parent_cat->category_id}}">
                                                        <?php
                                                        $menu_item_found = false;
                                                        $shown_menus = array();
                                                        ?>
                                                        @if(count($sub_categories) > '0')
                                                        @foreach($sub_categories as $sub_cat)
                                                        @if($sub_cat->main_category_id == $main_cat->category_id)
                                                        <li class="ui-state-default sortable_sub_li{{$main_cat->category_id}}" data-cat_id="{{$sub_cat->category_id}}">
                                                            <span class="caret">
                                                                <?php
                                                                if (!empty($sub_cat->category_icon)) {
                                                                    $sub_cat_icon = config('images.category_url') . $restaurant_id . '/' . $sub_cat->category_icon;
                                                                } else {
                                                                    $sub_cat_icon = config('images.default_image_url');
                                                                }
                                                                ?>
                                                                <p><img src="../{{$sub_cat_icon}}" width="40" height="40" alt="Category Icon" id= /> {{ $sub_cat->category_name}}
                                                                    <a data-toggle="modal" data-target="#deleteCategoryModal" data-category="{{ $sub_cat->category_id}}" class="delete-btn deleteCategory"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                                    <a href="#" class="edit-btn updateCategory" data-toggle="modal" data-target="#updateCategoryModal" data-id="{{ $sub_cat->category_id}}" data-name="{{ $sub_cat->category_name}}" data-full-icon="../{{config('images.category_url') .$restaurant_id.'/'.$sub_cat->category_icon }}" data-icon="{{ $sub_cat->category_icon }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                                </p>
                                                            </span>
                                                            <ul class="nested sortable_menu_item" data-cat_id="{{$main_cat->category_id}}" data-parent_id="{{$parent_cat->category_id}}" data-sub_id="{{$sub_cat->category_id}}">
                                                                <!-- <ul class="nested"> -->
                                                                @if(count($menu_items) > '0')
                                                                <?php
                                                                $menu_item_found = true;
                                                                ?>
                                                                @foreach($menu_items as $menuItem)
                                                                @if($menuItem->sub_category == $sub_cat->category_id)
                                                                @php
                                                                $shown_menus[] = $menuItem->menu_id;
                                                                @endphp
                                                                <li class="ui-state-default sortable_menu_item_li{{$sub_cat->category_id}}" data-menu_id="{{$menuItem->menu_id}}">
                                                                    <a href="{{url('/menu-detail/'.$menuItem->menu_id)}}">
                                                                        <p>{{ $menuItem->name}}
                                                                            <a href="{{url('/menu-update/'.$menuItem->menu_id)}}" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                                @endif
                                                                @endforeach
                                                                @endif
                                                            </ul>
                                                        </li>
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                        
                                                        <?php /* <ul class="nested sortable_menu_item" data-cat_id="{{$main_cat->category_id}}" data-parent_id="{{$parent_cat->category_id}}" data-sub_id="">  */ ?>
                                                        <!-- <ul class="nested"> -->
                                                        @if(count($menu_items_main_category) > '0')
                                                        @foreach($menu_items_main_category as $menuItem)
                                                        @if($menuItem->main_category == $main_cat->category_id)
                                                        @if(!in_array($menuItem->menu_id,$shown_menus))
                                                        <li class="ui-state-default sortable_menu_item_li{{$main_cat->category_id}}" data-menu_id="{{$menuItem->menu_id}}">
                                                            <a href="{{url('/menu-detail/'.$menuItem->menu_id)}}">
                                                                <p>{{ $menuItem->name}}
                                                                    <a href="{{url('/menu-update/'.$menuItem->menu_id)}}" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                                </p>
                                                            </a>
                                                        </li>
                                                        @endif
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                        <?php /* </ul> */ ?>
                                                        
                                                        @if(count($menu_items_sub_category) > '0')
                                                        @foreach($menu_items_sub_category as $menuItem)                                                        
                                                        @if($menuItem->main_category == $main_cat->category_id)                                                       
                                                        @if(!in_array($menuItem->menu_id,$shown_menus))
                                                        <li class="ui-state-default sortable_menu_item_li{{$main_cat->category_id}}" data-menu_id="{{$menuItem->menu_id}}">
                                                            <a href="{{url('/menu-detail/'.$menuItem->menu_id)}}">
                                                                <p>{{ $menuItem->name}}
                                                                    <a href="{{url('/menu-update/'.$menuItem->menu_id)}}" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                                </p>
                                                            </a>
                                                        </li>
                                                        @endif
                                                        @endif
                                                        @endforeach
                                                        
                                                        @endif
                                                    </ul>
                                                </li>
                                                @endif
                                                @endforeach
                                                @endif
                                            </ul>
                                        </li>
                                        @endforeach
                                        @else
                                        <li>
                                            No Data Found
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Add Category Modal -->
                        <div class="modal fade" id="exampleModalCenter">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Category</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="mainCategoryErrorMessage"></div>
                                    <form method="POST" id="add_category" action="javascript:void(0)">
                                        <div class="modal-body">
                                            <meta name="csrf-token" content="{{ csrf_token() }}">
                                            <input type="hidden" name="restaurant_id" value="{{ $restaurant_id }}" />
                                            <div class="row">
                                                <label>Category Type</label>
                                                <select name="category_type" class="form-control" id="category_type" required>
                                                    <option value="">Select Category Type</option>
                                                    <option value="0">Parent Category</option>
                                                    <option value="1">Main Category</option>
                                                    <option value="2">Sub Category</option>
                                                </select>
                                            </div>
                                            <div class="row" id="parent_category_id_div" style="display: none;">
                                                <br><label>Parent Category</label>
                                                <select name="parent_category" class="form-control" id="parent_category">
                                                    <option value="">Select Parent Category</option>
                                                    @if(count($parent_categories) > '0')
                                                    @foreach ($parent_categories as $category)
                                                    <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="row" id="main_category_id_div" style="display: none;">
                                                <br><label>Main Category</label>
                                                <select name="main_category" class="form-control" id="main_category">
                                                    <option value="">Select Main Category</option>
                                                </select>
                                            </div>
                                            <div class="row" id="category_name_div" style="display: none;" style="width: 100%">
                                                <br><label>Category Name</label>
                                                <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter Category Name" maxlength="50" />
                                                <br><label>Category icon</label>
                                                <input type="file" class="form-control" name="category_icon" id="category_icon" style="width: 466px" />
                                                <span></span>
                                            </div>
                                            <div class="row error_message_parent" id="display_type_div" style="display: none;">
                                                <br><label>Display Type</label>
                                                <select name="display_type" class="form-control" id="display_type">
                                                    <option value="1">Always Display</option>
                                                    <option value="2">Custom Display</option>
                                                </select>
                                                <span id="errorMessage"></span>
                                            </div>
                                            <div id="custome_type_div" style="display: none;">
                                                <div class="row error_message_parent">
                                                    <br><label>Days</label>
                                                    <!-- <select name="display_days" class="form-control" id="display_days">
                                        <option value="">Select Day</option>
                                        <option value="All">All</option>
                                        <option value="Sunday">Sunday</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                    </select> -->
                                                    <select name="display_days[]" id="display_days" class="form-control multiple_display_day" multiple display_days data-placeholder="Select Day">
                                                        <!-- <option value="All">All</option> -->
                                                        <option value="Sunday">Sunday</option>
                                                        <option value="Monday">Monday</option>
                                                        <option value="Tuesday">Tuesday</option>
                                                        <option value="Wednesday">Wednesday</option>
                                                        <option value="Thursday">Thursday</option>
                                                        <option value="Friday">Friday</option>
                                                        <option value="Saturday">Saturday</option>
                                                    </select>
                                                    <div class="dayErrorMessage" id="errorMessage"></div>
                                                </div>
                                                <!--<div class="row mt10">-->
                                                <!--    <div class="row">-->
                                                <!--    <div class="col-lg-6">-->
                                                <!--        <label>Start Time</label>-->
                                                <!--        <div class="row error_message_parent" >-->
                                                <!--            <input id="start_time" name="start_time" size="30" type="text" class="form-control" placeholder="Select Start Time"/>-->
                                                <!--            <span id="errorMessage"></span>-->
                                                <!--        </div>-->
                                                <!--    </div>-->
                                                <!--    <div class="col-lg-6">-->
                                                <!--        <label>End Time</label>-->
                                                <!--        <div class="row error_message_parent" >-->
                                                <!--            <input id="end_time" name="end_time"  size="30" type="text" class="form-control" placeholder="Select End Time" />-->
                                                <!--            <span id="errorMessage"></span>-->
                                                <!--        </div>-->
                                                <!--    </div>-->
                                                <!--</div>-->
                                                <!--</div>-->
                                                <div class="row mt10">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label>Start Time</label>
                                                            <div class=" error_message_parent">
                                                                <input id="start_time" name="start_time" size="30" type="text" class="form-control" placeholder="Select Start Time" />
                                                                <span id="errorMessage"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label>End Time</label>
                                                            <div class=" error_message_parent">
                                                                <input id="end_time" name="end_time" size="30" type="text" class="form-control" placeholder="Select End Time" />
                                                                <span id="errorMessage"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                            <input type="submit" name="submit" value="Add Category" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Update Category Modal -->
                        <div class="modal fade" id="updateCategoryModal">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Update Category</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="editCategoryErrorMessage"></div>
                                    <form method="POST" id="update_category" action="javascript:void(0)">
                                        <div class="modal-body">
                                            <meta name="csrf-token" content="{{ csrf_token() }}">
                                            <input type="hidden" name="main_category" id="main_category_text" value='' />
                                            <div class="col-md-12 ctm_input error_message_parent">
                                                <div class="w100 ">
                                                    <div class=" row">
                                                        <label class="w100">Category Name</label>
                                                        <div class="w100 ctm_input ctm_input_relt error_message_parent">
                                                            <input type="hidden" name="category_id" id="update_category_id" />
                                                            <input type="text" class="form-control" name="category_name" id="update_category_name" />
                                                            <span id="errorMessage"></span>
                                                            <div class="ctm_icon_input">
                                                                <input type="hidden" name="current_category_icon" id="current_category_icon" />
                                                                <img src="" width="50" height="50" id="update_category_icon_image" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="javascript:void(0)" class="remove_icon_link" id="category_icon_remove" style='display: none;'>Remove Icon</a>



                                                <div class="row ">
                                                    <div class="row mt10">
                                                        <label class="col-md-12">Category Icon</label>
                                                        <div class="col-md-12 error_message_parent" style="width: 100%">
                                                            <input type="file" class="form-control" name="category_icon" id="update_category_icon" style="width: 440px" />
                                                            <span id="errorMessage"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt10 error_message_parent" id="update_display_type_div" style="display: block;">
                                                    <br><label>Display Type</label>
                                                    <select name="display_type" class="form-control" id="update_display_type">
                                                        <option value="1">Always Display</option>
                                                        <option value="2">Custom Display</option>
                                                    </select>
                                                    <span id="errorMessage"></span>
                                                </div>
                                                <div id="update_custome_type_div" style="display: none;">
                                                    <div class="row mt10 error_message_parent">
                                                        <br><label>Days</label>
                                                        <!-- <select name="display_days[]" class="form-control multiple_day" id="update_display_days"  multiple="multiple">
                                        <option value="Sunday">Sunday</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                    </select>  -->
                                                        <select name="display_days[]" id="update_display_days" class="form-control multiple_display_day" multiple display_days data-placeholder="Select Day">
                                                            <option value="Sunday">Sunday</option>
                                                            <option value="Monday">Monday</option>
                                                            <option value="Tuesday">Tuesday</option>
                                                            <option value="Wednesday">Wednesday</option>
                                                            <option value="Thursday">Thursday</option>
                                                            <option value="Friday">Friday</option>
                                                            <option value="Saturday">Saturday</option>
                                                        </select>
                                                        <div id="errorMessage" class="dayErrorMessage"></div>
                                                    </div>
                                                    <div class="row mt10">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <label>Start Time</label>
                                                                <div class=" error_message_parent">
                                                                    <input id="update_start_time" name="start_time" size="30" type="text" class="form-control" placeholder="Select Start Time" />
                                                                    <span id="errorMessage"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label>End Time</label>
                                                                <div class=" error_message_parent">
                                                                    <input id="update_end_time" name="end_time" size="30" type="text" class="form-control" placeholder="Select End Time" />
                                                                    <span id="errorMessage"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer mt10">
                                                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                                <input type="submit" name="submit" value="Update Category" class="btn btn-primary">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Delete Category Modal -->
                        <div class="modal fade" id="deleteCategoryModal">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="form-row">
                                            <span>Are you sure you want to delete this category item?</span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                        <a href="" id="confirmDeleteCategory" class="btn btn-primary" style="color:#fff!important; margin: 0;">Confirm Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--**********************************
    Content body end
***********************************-->
                @include('theme.footer')
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                <script>
                    var toggler = document.getElementsByClassName("caret");
                    var i;
                    for (i = 0; i < toggler.length; i++) {
                        toggler[i].addEventListener("click", function() {
                            this.parentElement.querySelector(".nested").classList.toggle("active");
                            this.classList.toggle("caret-down");
                        });
                    }
                    $(document).ready(function(e) {
                        // Multi Select Days Start
                        var add_days_select = $('#display_days');
                        var add_days_options = add_days_select.find('option');
                        var add_days_div = $('<div />').addClass('selectMultiple');
                        var add_days_active = $('<div />');
                        var add_days_list = $('<ul />');
                        var add_days_placeholder = add_days_select.data('placeholder');
                        var add_days_span = $('<span />').text(add_days_placeholder).appendTo(add_days_active);
                        add_days_options.each(function() {
                            var add_days_text = $(this).text();
                            if ($(this).is(':selected')) {
                                add_days_active.append($('<a />').html('<em>' + add_days_text + '</em><i></i>'));
                                add_days_span.addClass('hide');
                            } else {
                                add_days_list.append($('<li />').html(add_days_text));
                            }
                        });
                        add_days_active.append($('<div />').addClass('arrow'));
                        add_days_div.append(add_days_active).append(add_days_list);
                        add_days_select.wrap(add_days_div);
                        //Select multiple add_days END
                        $(document).on('click', '.selectMultiple ul li', function(e) {
                            var select = $(this).parent().parent();
                            var li = $(this);
                            if (!select.hasClass('clicked')) {
                                select.addClass('clicked');
                                li.prev().addClass('beforeRemove');
                                li.next().addClass('afterRemove');
                                li.addClass('remove');
                                var a = $('<a />').addClass('notShown').html('<em>' + li.text() + '</em><i></i>').hide().appendTo(select.children('div'));
                                a.slideDown(400, function() {
                                    setTimeout(function() {
                                        a.addClass('shown');
                                        select.children('div').children('span').addClass('hide');
                                        select.find('option:contains(' + li.text() + ')').prop('selected', true);
                                    }, 500);
                                });
                                console.log(li)
                                setTimeout(function() {
                                    if (li.prev().is(':last-child')) {
                                        li.prev().removeClass('beforeRemove');
                                    }
                                    if (li.next().is(':first-child')) {
                                        li.next().removeClass('afterRemove');
                                    }
                                    setTimeout(function() {
                                        li.prev().removeClass('beforeRemove');
                                        li.next().removeClass('afterRemove');
                                    }, 200);
                                    li.slideUp(400, function() {
                                        li.remove();
                                        select.removeClass('clicked');
                                    });
                                }, 600);
                            }
                        });
                        $(document).on('click', '.selectMultiple > div a', function(e) {
                            var select = $(this).parent().parent();
                            var self = $(this);
                            self.removeClass().addClass('remove');
                            select.addClass('open');
                            setTimeout(function() {
                                self.addClass('disappear');
                                setTimeout(function() {
                                    self.animate({
                                        width: 0,
                                        height: 0,
                                        padding: 0,
                                        margin: 0
                                    }, 300, function() {
                                        var li = $('<li />').text(self.children('em').text()).addClass('notShown').appendTo(select.find('ul'));
                                        li.slideDown(400, function() {
                                            li.addClass('show');
                                            setTimeout(function() {
                                                select.find('option:contains(' + self.children('em').text() + ')').prop('selected', false);
                                                if (!select.find('option:selected').length) {
                                                    select.children('div').children('span').removeClass('hide');
                                                }
                                                li.removeClass();
                                            }, 400);
                                        });
                                        self.remove();
                                    })
                                }, 300);
                            }, 400);
                        });
                        $(document).on('click', '.selectMultiple > div .arrow, .selectMultiple > div span', function(e) {
                            $(this).parent().parent().toggleClass('open');
                        });
                        // Multi Select Days End 
                        $('#start_time').timepicker({
                            'step': '60',
                        });
                        $('#end_time').timepicker({
                            'minTime': '12:00am',
                            'step': '60',
                            'showDuration': true
                        });
                        $('#start_time').on('changeTime', function() {
                            $('#end_time').timepicker('option', 'minTime', $(this).val());
                        });
                        $('#update_start_time').timepicker({
                            'step': '60',
                        });
                        $('#update_end_time').timepicker({
                            'minTime': '12:00am',
                            'step': '60',
                            'showDuration': true
                        });
                        $('#update_start_time').on('changeTime', function() {
                            $('#update_end_time').timepicker('option', 'minTime', $(this).val());
                        });
                        // CSRF Token
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        // Category Type change event
                        $("#category_type").change(function() {

                            $category_type = $(this).val();
							console.log($category_type);
                            if ($category_type == "0") {
                                $('#category_name_div').show();
                                $('#parent_category_id_div').hide();
                                $('#main_category_id_div').hide();
                                $('#display_type_div').hide();
                                $('#custome_type_div').hide();
                            } else if ($category_type == "1") {
                                $('#category_name_div').show();
                                $('#parent_category_id_div').show();
                                $('#main_category_id_div').hide();
                                $('#display_type_div').show();
                                $('#custome_type_div').hide();
                            } else if ($category_type == "2") {
                                $('#category_name_div').show();
                                $('#parent_category_id_div').show();
                                $('#main_category_id_div').show();
                                $('#display_type_div').hide();
                                $('#custome_type_div').hide();
                            } else {
                                $('#category_name_div').hide();
                                $('#parent_category_id_div').hide();
                                $('#main_category_id_div').hide();
                                $('#display_type_div').hide();
                                $('#custome_type_div').hide();
                            }
                        });
                        $("#display_type").change(function() {
                            $display_type = $(this).val();
                            if ($display_type == "2") {
                                $('#custome_type_div').show();
                            } else {
                                $('#custome_type_div').hide();
                            }
                        });
                        $("#update_display_type").change(function() {
                            $update_display_type = $(this).val();
                            if ($update_display_type == "2") {
                                $('#update_custome_type_div').show();
                            } else {
                                $('#update_custome_type_div').hide();
                            }
                        });
                        //Get Main Category for selected Parent Category
                        $("#parent_category").change(function() {
                            var parent_caregory = $('#parent_category :selected').val();
                            var ids = $(this).val();
                            var restaurant_id = "{{ $restaurant_id }}";
                            $.ajax({
                                type: "POST",
                                url: "{{ url('select_main_category') }}",
                                data: {
                                    id: parent_caregory,
                                    restaurant_id: restaurant_id
                                },
                                dataType: "json",
                                success: function(data) {
                                    console.log(data);
                                    $.each(data, function(key, value) {
                                        if (key == 'success') {
                                            $main_category_list = value;
                                            $('#main_category').html("<option value=''> Select Main Category </option>");
                                            $.each($main_category_list, function(key1, value1) {
                                                $('#main_category').append("<option value='" + value1['category_id'] + "'> " + value1['category_name'] + " </option>");
                                            });
                                        } else {
                                            $('#main_category').html("<option value=''> Select Main Category </option>");
                                        }
                                    });
                                }
                            });
                        });
                        // Add Category
                        $('#add_category').submit(function(e) {
                            $('input').removeClass('is-invalid');
                            e.preventDefault();
                            $('input').removeClass('is-invalid');
                            var formData = new FormData(this);
                            $.ajax({
                                type: 'POST',
                                url: "{{ url('add_category')}}",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(data) {
                                    $.each(data, function(key, value) {
                                        if (key == 'error') {
                                            $.each(value, function(key1, value1) {
                                                $('#' + key1).addClass('is-invalid');
                                            });
                                        } else if (key == 'days_required') {
                                            $('.dayErrorMessage').html(value);
                                            // $('#display_days').addClass('is-invalid');
                                        } else if (key == 'errors') {
                                            var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> ' + value + '\</div>';
                                            $('.mainCategoryErrorMessage').html(html);
                                        } else if (key == 'success') {
                                            var html = '<div class="alert alert-success background-success">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Success!</strong> ' + value + '\</div>';
                                            $('.mainCategoryErrorMessage').html(html);
                                            location.reload(true);
                                        }
                                    });
                                },
                                error: function(data) {
                                    var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> Error while adding data\</div>';
                                    $('.mainCategoryErrorMessage').html(html);
                                }
                            });
                        });
                        // Set data in update modal popup 
                        $(".updateCategory").click(function(e) {
                            $("#update_display_type_div").show();
                            $('#update_custome_type_div').hide();
                            $('#update_start_time').val('');
                            $('#update_end_time').val('');
                            $('#main_category_text').val('');
                            $category_id = $(this).attr("data-id");
                            $category_name = $(this).attr("data-name");
                            $category_icon = $(this).attr("data-icon");
                            $category_full_icon = $(this).attr("data-full-icon");
                            $('#update_category_id').val($category_id);
                            $('#update_category_name').val($category_name);
                            $('#current_category_icon').val($category_icon);

                            if ($category_icon !== '' && $category_icon !== "undefined") {
                                $('#update_category_icon_image').show();
                                $("#update_category_icon_image").attr("src", $category_full_icon);
                                $("#category_icon_remove").show();
                            } else {
                                $('#update_category_icon_image').hide();
                                // $('#update_category_icon_image').removeAttr('src');
                                // $("#update_category_icon_image").attr('src', '');
                                $("#category_icon_remove").hide();
                            }

                            $main_category = $(this).attr("data-category_main");
                            if (typeof $main_category !== "undefined") {
                                $display_type = $(this).attr("data-display_type");
                                $day = $(this).attr("data-day");
                                // $day = $(this).attr("data-day");
                                $('#main_category_text').val('1');
                                var days = $day;
                                var daysArr = days.split(',');
                                var days_html = '';
                                $.each(daysArr, function(key, value) {
                                    days_html += '<a class="notShown shown" style=""><em>' + value + '</em><i></i></a>'
                                    $('#update_display_days option[value="' + value + '"]').attr('selected', true);
                                });
                                var update_days_select = $('#update_display_days');
                                var update_days_options = update_days_select.find('option');
                                var update_days_div = $('<div />').addClass('selectMultiple');
                                var update_days_active = $('<div />');
                                var update_days_list = $('<ul />');
                                var update_days_placeholder = update_days_select.data('placeholder');
                                var update_days_span = $('<span />').text(update_days_placeholder).appendTo(update_days_active);
                                update_days_options.each(function() {
                                    var update_days_text = $(this).text();
                                    if ($(this).is(':selected')) {
                                        update_days_active.append($('<a />').html('<em>' + update_days_text + '</em><i></i>'));
                                        update_days_span.addClass('hide');
                                    } else {
                                        update_days_list.append($('<li />').html(update_days_text));
                                    }
                                });
                                update_days_active.append($('<div />').addClass('arrow'));
                                update_days_div.append(update_days_active).append(update_days_list);
                                update_days_select.wrap(update_days_div);
                                $('#update_display_type option[value="' + $display_type + '"]').attr('selected', true);
                                $("#update_display_type_div").show();
                                if ($display_type == "2" && $display_type !== '') {
                                    $start_time = $(this).attr("data-start_time");
                                    $end_time = $(this).attr("data-end_time");
                                    $("#update_custome_type_div").show();
                                    $('#update_start_time').val($start_time);
                                    $('#update_end_time').val($end_time);
                                } else {
                                    $("#update_custome_type_div").hide();
                                }
                            }
                        });
                        // Update Category
                        $('#update_category').submit(function(e) {
                            $('input').removeClass('is-invalid');
                            $('.editCategoryErrorMessage').html('');
                            e.preventDefault();
                            var formData = new FormData(this);
                            $.ajax({
                                type: 'POST',
                                url: "{{ url('update_restaurant_category')}}",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(data) {
                                    $.each(data, function(key, value) {
                                        console.log(key);
                                        console.log(value);
                                        if (key == 'error') {
                                            $.each(value, function(key1, value1) {
                                                $('#update_' + key1).addClass('is-invalid');
                                            });
                                        } else if (key == 'days_required') {
                                            $('.dayErrorMessage').html(value);
                                        } else if (key == 'errors') {
                                            var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> ' + value + '\</div>';
                                            $('.editCategoryErrorMessage').html(html);
                                        } else if (key == 'success') {
                                            var html = '<div class="alert alert-success background-success">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Success!</strong> ' + value + '\</div>';
                                            $('.editCategoryErrorMessage').html(html);
                                            location.reload(true);
                                        }
                                    });
                                },
                                error: function(data) {
                                    var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> Error while adding data\</div>';
                                    $('.editCategoryErrorMessage').html(html);
                                }
                            });
                        });
                        // Filters: Get Main Category for selected Parent Category
                        $("#filter_parent_category").change(function() {
                            var parent_caregory = $('#filter_parent_category :selected').val();
                            $('#filter_parent_category_id').val(parent_caregory);
                            var ids = $(this).val();
                            var restaurant_id = "{{ $restaurant_id }}";
                            $.ajax({
                                type: "POST",
                                url: "{{ url('select_main_category') }}",
                                data: {
                                    id: parent_caregory,
                                    restaurant_id: restaurant_id
                                },
                                dataType: "json",
                                success: function(data) {
                                    $.each(data, function(key, value) {
                                        if (key == 'success') {
                                            $main_category_list = value;
                                            $('#filter_main_category').html("<option value=''> Select Main Category </option>");
                                            $.each($main_category_list, function(key1, value1) {
                                                $('#filter_main_category').append("<option value='" + value1['category_id'] + "'> " + value1['category_name'] + " </option>");
                                            });
                                        } else {
                                            $('#filter_main_category').html("<option value=''> Select Main Category </option>");
                                            $('#filter_sub_category').html("<option value=''> Select Sub Category </option>");
                                        }
                                    });
                                }
                            });
                        });
                        // Filters: Get Sub Category for selected Main Category
                        $("#filter_main_category").change(function() {
                            var parent_caregory = $('#filter_parent_category :selected').val();
                            var main_caregory = $('#filter_main_category :selected').val();
                            var ids = $(this).val();
                            var restaurant_id = "{{ $restaurant_id }}";
                            $.ajax({
                                type: "POST",
                                url: "{{ url('select_sub_category') }}",
                                data: {
                                    id: main_caregory,
                                    restaurant_id: restaurant_id,
                                    parent_category: parent_caregory
                                },
                                dataType: "json",
                                success: function(data) {
                                    $.each(data, function(key, value) {
                                        if (key == 'success') {
                                            $sub_category_list = value;
                                            $('#filter_sub_category').html("<option value=''> Select Sub Category </option>");
                                            $.each($sub_category_list, function(key1, value1) {
                                                $('#filter_sub_category').append("<option value='" + value1['category_id'] + "'> " + value1['category_name'] + " </option>");
                                            });
                                        } else {
                                            $('#filter_sub_category').html("<option value=''> Select Sub Category </option>");
                                        }
                                    });
                                }
                            });
                        });
                        // Show filters
                        $("#show_category_filters").click(function() {
                            $('#filters_div').show();
                        });
                        // Set data in delete modal popup 
                        $(".deleteCategory").click(function(e) {
                            $category_id = $(this).attr("data-category");
                            $href = "{{ url('category-delete') }}/" + $category_id;
                            $('#confirmDeleteCategory').attr("href", $href);
                        });
                        // drag function and save order in data base
                        $(function() {
                            $('.sortable_paraent_cat').sortable({
                                stop: function(e, ui) {
                                    var mylist = [];
                                    var catgory_id = [];
                                    $(".sortable_paraent_cat > li").each(function() {
                                        mylist.push({});
                                        var self = mylist[mylist.length - 1];
                                        catgory_id.push($(this).attr("data-cat_id"));
                                    });
                                    var restaurant_id = "{{ $restaurant_id }}";
                                    $.ajax({
                                        url: "{{ url('save_category_order')}}",
                                        type: 'POST',
                                        data: {
                                            category_id: catgory_id,
                                            restaurant_id: restaurant_id,
                                            category_type: '0'
                                        },
                                        dataType: "json",
                                        success: function(data) {
                                            console.log("sucss")
                                        }
                                    });
                                }
                            });
                            $('.sortable_main_cat').sortable({
                                stop: function(e, ui) {
                                    var parent_cat_id = $(this).data('cat_id');
                                    var catgory_id = [];
                                    var class_name = '.sortable_main_li' + parent_cat_id;
                                    $('.sortable_main_cat').find(class_name).each(function() {
                                        catgory_id.push($(this).data('cat_id'));
                                    });
                                    var restaurant_id = "{{ $restaurant_id }}";
                                    $.ajax({
                                        url: "{{ url('save_category_order')}}",
                                        type: 'POST',
                                        data: {
                                            category_id: catgory_id,
                                            restaurant_id: restaurant_id,
                                            category_type: '1',
                                            parent_caregory_id: parent_cat_id
                                        },
                                        dataType: "json",
                                        success: function(data) {
                                            console.log("sucss")
                                        }
                                    });
                                }
                            });
                            $('.sortable_sub_cat').sortable({
                                stop: function(e, ui) {
                                    var main_cat_id = $(this).data('cat_id');
                                    var parent_cat_id = $(this).data('parent_id');
                                    var catgory_id = [];
                                    var class_name = '.sortable_sub_li' + main_cat_id;
                                    $('.sortable_sub_cat').find(class_name).each(function() {
                                        catgory_id.push($(this).data('cat_id'));
                                    });
                                    var restaurant_id = "{{ $restaurant_id }}";
                                    $.ajax({
                                        url: "{{ url('save_category_order')}}",
                                        type: 'POST',
                                        data: {
                                            category_id: catgory_id,
                                            restaurant_id: restaurant_id,
                                            category_type: '2',
                                            parent_caregory_id: parent_cat_id,
                                            main_category_id: main_cat_id
                                        },
                                        dataType: "json",
                                        success: function(data) {
                                            console.log("sucss")
                                        }
                                    });
                                }
                            });
                            $('.sortable_menu_item').sortable({
                                stop: function(e, ui) {
                                    var main_cat_id = $(this).data('cat_id');
                                    var parent_cat_id = $(this).data('parent_id');
                                    var sub_cat_id = $(this).data('sub_id');
                                    var menu_id = [];
                                    var class_name = '.sortable_menu_item_li' + sub_cat_id;
                                    console.log("class_name =>" + class_name + " main_cat_id => " + main_cat_id + " parent_cat_id => " + parent_cat_id + " sub_cat_id =>" + sub_cat_id);

                                    $('.sortable_menu_item').find(class_name).each(function() {
                                        menu_id.push($(this).data('menu_id'));
                                    });
                                    var restaurant_id = "{{ $restaurant_id }}";
                                    $.ajax({
                                        url: "{{ url('save_menu_order')}}",
                                        type: 'POST',
                                        data: {
                                            menu_id: menu_id,
                                            restaurant_id: restaurant_id,
                                            parent_caregory_id: parent_cat_id,
                                            main_category_id: main_cat_id,
                                            sub_category_id: sub_cat_id
                                        },
                                        dataType: "json",
                                        success: function(data) {
                                            console.log("sucss")
                                        }
                                    });
                                }
                            });
                            console.log($(".sortable_paraent_cat").children('li').find('ul').find('.active'));
                        });
                        // categoyr icon remove js
                        $("#category_icon_remove").click(function(e) {
                            $('#update_category_icon_image').hide();
                            $('#current_category_icon').val('');
                            $("#category_icon_remove").hide();
                        });

                    });
                </script>