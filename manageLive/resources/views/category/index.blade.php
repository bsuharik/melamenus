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
                    <form method="POST" enctype="multipart/form-data" id="filter_category" action="{{ url('filter_category') }}/{{ $restaurant_id }}" >
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 results">
                    <ul id="myUL">
                @if(count($parent_categories) > '0')
                    @foreach($parent_categories as $parent_cat)
                        <li>
                            <span class="caret">
                                <p>{{ $parent_cat->category_name}}
                                    <a data-toggle="modal" data-target="#deleteCategoryModal" data-category="{{ $parent_cat->category_id}}" class="delete-btn deleteCategory"><i class="fa fa-trash" aria-hidden="true"></i></a>

                                    <a href="#" class="edit-btn updateCategory" data-toggle="modal" data-target="#updateCategoryModal" data-id="{{ $parent_cat->category_id}}" data-name="{{ $parent_cat->category_name}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                </p>
                            </span>
                            <ul class="nested">
                    @if(count($main_categories) > '0')
                        @foreach($main_categories as $main_cat)
                            @if($main_cat->parent_category_id == $parent_cat->category_id)
                                <li>
                                    <span class="caret">
                                        <p>{{ $main_cat->category_name}}
                                            <a data-toggle="modal" data-target="#deleteCategoryModal" data-category="{{ $main_cat->category_id}}" class="delete-btn deleteCategory"><i class="fa fa-trash" aria-hidden="true"></i></a>

                                            <a href="#" class="edit-btn updateCategory" data-toggle="modal" data-target="#updateCategoryModal" data-id="{{ $main_cat->category_id}}" data-name="{{ $main_cat->category_name}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </p>
                                    </span>
                                    <ul class="nested">
                            @if(count($sub_categories) > '0')
                                @foreach($sub_categories as $sub_cat)
                                    @if($sub_cat->main_category_id == $main_cat->category_id)
                                        <li>
                                            <p>{{ $sub_cat->category_name}}
                                                <a data-toggle="modal" data-target="#deleteCategoryModal" data-category="{{ $sub_cat->category_id}}" class="delete-btn deleteCategory"><i class="fa fa-trash" aria-hidden="true"></i></a>

                                                <a href="#" class="edit-btn updateCategory" data-toggle="modal" data-target="#updateCategoryModal" data-id="{{ $sub_cat->category_id}}" data-name="{{ $sub_cat->category_name}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            </p>
                                        </li>
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
                            <div class="row" id="category_name_div" style="display: none;">
                                <br><label>Category Name</label>
                                <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter Category Name" maxlength="50" />
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
                            <input type="hidden" name="category_id" id="category_id" />
                            <div class="row" id="category_name">
                                <br><label>Category Name</label>
                                <input type="text" class="form-control" name="category_name" id="update_category_name" maxlength="50" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <input type="submit" name="submit" value="Update Category" class="btn btn-primary">
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

<script>
    var toggler = document.getElementsByClassName("caret");
    var i;

    for (i = 0; i < toggler.length; i++) {
      toggler[i].addEventListener("click", function() {
        this.parentElement.querySelector(".nested").classList.toggle("active");
        this.classList.toggle("caret-down");
      });
    }

$(document).ready(function (e) {

    // CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Category Type change event
    $( "#category_type" ).change(function() {
        $category_type = $(this).val();

        if ($category_type == "0") 
        {
            $('#category_name_div').show();
            $('#parent_category_id_div').hide();
            $('#main_category_id_div').hide();
        }
        else if ($category_type == "1") 
        {
            $('#category_name_div').show();
            $('#parent_category_id_div').show();
            $('#main_category_id_div').hide();
        }
        else if ($category_type == "2") 
        {
            $('#category_name_div').show();
            $('#parent_category_id_div').show();
            $('#main_category_id_div').show();
        }
        else
        {
            $('#category_name_div').hide();
            $('#parent_category_id_div').hide();
            $('#main_category_id_div').hide();
        }
    });

    //Get Main Category for selected Parent Category
    $( "#parent_category" ).change(function() {
        
        var parent_caregory = $('#parent_category :selected').val();

        var ids = $(this).val();
        var restaurant_id = "{{ $restaurant_id }}";

        $.ajax({
                type: "POST",
                url: "{{ url('select_main_category') }}", 
                data:  {id:parent_caregory, restaurant_id:restaurant_id},
                dataType: "json",
                success: function(data)
                {
                    console.log(data);
                    $.each(data, function(key, value) 
                    {
                        if(key == 'success')
                        {
                            $main_category_list = value;
                            $('#main_category').html("<option value=''> Select Main Category </option>");

                            $.each($main_category_list, function(key1, value1) 
                            {
                                $('#main_category').append("<option value='"+value1['category_id']+"'> "+value1['category_name']+" </option>");
                            });
                        }
                        else
                        {
                            $('#main_category').html("<option value=''> Select Main Category </option>");
                        }

                    });
                }
            });

    });

    // Add Category
    $('#add_category').submit(function(e) {

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: "{{ url('add_category')}}",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function(data){

                $.each(data, function(key, value) 
                {                    
                    if(key == 'error') 
                    {
                        $.each(value, function(key1, value1) 
                        {
                            $('#'+key1).addClass('is-invalid');
                        });
                    }
                    else if(key == 'errors') 
                    {
                        var html = '<div class="alert alert-danger background-danger">\
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <i class="icofont icofont-close-line-circled text-white"></i>\
                                        </button>\
                                        <strong>Error!</strong> '+ value +'\
                                    </div>';

                        $('.mainCategoryErrorMessage').html(html);
                    }
                    else if(key == 'success')
                    {
                        var html = '<div class="alert alert-success background-success">\
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <i class="icofont icofont-close-line-circled text-white"></i>\
                                        </button>\
                                        <strong>Success!</strong> '+ value +'\
                                    </div>';

                        $('.mainCategoryErrorMessage').html(html);

                        location.reload(true);
                    }
                });
            },
            error: function(data){

                var html = '<div class="alert alert-danger background-danger">\
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                    <i class="icofont icofont-close-line-circled text-white"></i>\
                                </button>\
                                <strong>Error!</strong> Error while adding data\
                            </div>';

                $('.mainCategoryErrorMessage').html(html);
            }
        });
    });

    // Set data in update modal popup 
    $(".updateCategory").click(function (e) {

        $category_id = $(this).attr("data-id");
        $category_name = $(this).attr("data-name");

        $('#category_id').val($category_id);
        $('#update_category_name').val($category_name);
    });

    // Update Category
    $('#update_category').submit(function(e) {

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: "{{ url('update_restaurant_category')}}",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function(data){

                $.each(data, function(key, value) 
                {                    
                    if(key == 'error') 
                    {
                        $.each(value, function(key1, value1) 
                        {
                            $('#update_'+key1).addClass('is-invalid');
                        });
                    }
                    else if(key == 'errors') 
                    {
                        var html = '<div class="alert alert-danger background-danger">\
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <i class="icofont icofont-close-line-circled text-white"></i>\
                                        </button>\
                                        <strong>Error!</strong> '+ value +'\
                                    </div>';

                        $('.editCategoryErrorMessage').html(html);
                    }
                    else if(key == 'success')
                    {
                        var html = '<div class="alert alert-success background-success">\
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <i class="icofont icofont-close-line-circled text-white"></i>\
                                        </button>\
                                        <strong>Success!</strong> '+ value +'\
                                    </div>';

                        $('.editCategoryErrorMessage').html(html);

                        location.reload(true);
                    }
                });
            },
            error: function(data){

                var html = '<div class="alert alert-danger background-danger">\
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                    <i class="icofont icofont-close-line-circled text-white"></i>\
                                </button>\
                                <strong>Error!</strong> Error while adding data\
                            </div>';

                $('.editCategoryErrorMessage').html(html);
            }
        });
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
                                $('#filter_main_category').append("<option value='"+value1['category_id']+"'> "+value1['category_name']+" </option>");
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
                                $('#filter_sub_category').append("<option value='"+value1['category_id']+"'> "+value1['category_name']+" </option>");
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
    $( "#show_category_filters" ).click(function() {
        $('#filters_div').show();
    });

    // Set data in delete modal popup 
    $(".deleteCategory").click(function (e) {

        $category_id = $(this).attr("data-category");

        $href = "{{ url('category-delete') }}/"+$category_id;
        $('#confirmDeleteCategory').attr("href",$href);
    });

});
</script>