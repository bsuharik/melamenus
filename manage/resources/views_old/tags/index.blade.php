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
                        Tags
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
            <div class="col-sm-11"></div>
            <div class="col-sm-1">
                <a href="{{ url('home') }}" id="back_button" class="btn btn-info btn-block">Back</a>
            </div>
        </div>
        <br>
        <div class="form-head d-flex mb-3 mb-lg-5 align-items-start">
            <div class="mr-auto d-none col-md-12 d-lg-block">
                <div class="welcome-text">
                    <h4>Manage Tags</h4>
                    <div class="row">
                        <div class="col-md-9">
                            <a data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-primary btn-block col-sm-12 col-md-3 mt-3" style="color:#fff!important;">Add Tag</a>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group search-area ml-3 d-inline-flex mt-3">
                                <input type="text" class="search form-control" placeholder="Search here">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="flaticon-381-search-2"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                
        </div>
        <!-- Table -->
        <div class="col-xl-12 col-xxl-12 col-lg-12 col-sm-12">
            <div class="card">
                <!-- row -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <table id="example5" class="display mb-4 dataTablesCard results">
                                    <thead>
                                        <tr>
                                            <th><strong class="font-w600 wspace-no">Tag Name</strong></th>
                                            <th><strong class="font-w600 wspace-no">Tag Icon</strong></th>                
                                            <th><strong class="font-w600 wspace-no">Action</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                @if(count($tag_list) > '0')
                                    @foreach ($tag_list as $tag)
                                        <tr>
                                            <td> {{ $tag->tag_name }} </td>
                                            <td>
                                                <img src="{{ config('images.tag_url') . $tag->tag_icon }}" width="50" height="50" alt="Tag Icon" />&nbsp;
                                            </td>
                                            <td>
                                                <a href="#" data-toggle="modal" data-target="#updateTagModal" data-id="{{ $tag->tag_id}}" data-name="{{ $tag->tag_name}}" data-full-icon="{{ config('images.tag_url') . $tag->tag_icon }}" data-icon="{{ $tag->tag_icon }}" class="edit-btn updateTag" style="float: none;"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                                                <a data-toggle="modal" data-target="#deleteTagModal" data-tag="{{ $tag->tag_id }}" class="delete-btn deleteTag" style="float: none;"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            </td>
                                            </td>
                                        </tr> 
                                    @endforeach
                                @else
                                        <tr>
                                            <td></td>
                                            <td>No Data Found</td>
                                        </tr>
                                @endif                          
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
             
        <!-- Add Table Modal -->
        <div class="modal fade" id="exampleModalCenter">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Tag</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="mainErrorMessage"></div>
                    <form method="POST" id="add_tag" action="javascript:void(0)" enctype="multipart/form-data" files="true">
                        <div class="modal-body">
                            <div class="row">
                                <label class="col-md-12">Tag Name</label>
                                <div class="col-md-12 error_message_parent">
                                    <input type="text" class="form-control" name="tag_name" id="tag_name" placeholder="Enter Tag Name" />
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-md-12">Tag Icon</label>
                                <div class="col-md-12 error_message_parent">
                                    <input type="file" class="form-control" name="tag_icon" id="tag_icon">
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <input type="submit" name="submit" value="Add Tag" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update Tag Modal -->
        <div class="modal fade" id="updateTagModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Tag Details</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="mainUpdateErrorMessage"></div>
                    <form method="POST" id="update_tag" action="javascript:void(0)" enctype="multipart/form-data" files="true">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="modal-body">
                            <div class="row">
                                <label class="col-md-12">Tag Name</label>
                                <div class="col-md-12 ctm_input error_message_parent">
                                    <input type="hidden" name="tag_id" id="update_tag_id" />
                                    <input type="text" class="form-control" name="tag_name" id="update_tag_name" />
                                    <span id="errorMessage"></span>
                                    <div class="ctm_icon_input">
                                        <input type="hidden" name="current_tag_icon" id="current_tag_icon" />
                                        <img src="" width="50" height="50" alt="Tag Icon" id="update_tag_icon_image" />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-md-12">Tag Icon</label>
                                <div class="col-md-12 error_message_parent">
                                    <input type="file" class="form-control" name="tag_icon" id="update_tag_icon">
                                    <span id="errorMessage"></span>
                                </div>
                            </div> 
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <input type="submit" name="submit" value="Update Tag" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        

        <!-- Delete Tag Modal -->
        <div class="modal fade" id="deleteTagModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-row">
                            <span>Are you sure you want to delete this tag details?</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                        <a href="" id="confirmDeleteTag" class="btn btn-primary" style="color:#fff!important; margin: 0;">Confirm Delete</a>
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

<script type="text/javascript">
$(document).ready(function (e) {

    // CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Add Tag
    $('#add_tag').submit(function(e) {

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: "{{ url('add_tag')}}",
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
                            $('#'+key1).parent('.error_message_parent').find('#errorMessage').html(value1);
                        });
                    }
                    else if(key == 'errors') 
                    {
                        var html = '<div class="alert alert-danger background-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled text-white"></i></button><strong>Error!</strong> '+ value +'</div>';

                        $('.mainErrorMessage').html(html);
                    }
                    else if(key == 'success')
                    {
                        var html = '<div class="alert alert-success background-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled text-white"></i></button><strong>Success!</strong> '+ value +'</div>';

                        $('.mainErrorMessage').html(html);

                        window.location.href = "<?php echo url('tags'); ?>";
                    }
                });
            },
            error: function(data){

                var html = '<div class="alert alert-danger background-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled text-white"></i></button><strong>Error!</strong> Error while adding data</div>';

                $('.mainErrorMessage').html(html);
            }
        });
    });

    // Set data in update modal popup 
    $(".updateTag").click(function (e) {

        $tag_id = $(this).attr("data-id");
        $tag_name = $(this).attr("data-name");
        $tag_icon = $(this).attr("data-icon");
        $tag_full_icon = $(this).attr("data-full-icon");


        $('#update_tag_id').val($tag_id);
        $('#update_tag_name').val($tag_name);
        $('#current_tag_icon').val($tag_icon);
        $("#update_tag_icon_image").attr("src", $tag_full_icon);
    });

    // Update Tag
    $('#update_tag').submit(function(e) {

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: "{{ url('update_tag')}}",
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
                            $('#update_'+key1).parent('.error_message_parent').find('#errorMessage').html(value1);
                        });
                    }
                    else if(key == 'errors') 
                    {
                        var html = '<div class="alert alert-danger background-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled text-white"></i></button><strong>Error!</strong> '+ value +'</div>';

                        $('.mainUpdateErrorMessage').html(html);
                    }
                    else if(key == 'success')
                    {
                        var html = '<div class="alert alert-success background-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled text-white"></i></button><strong>Success!</strong> '+ value +'</div>';

                        $('.mainUpdateErrorMessage').html(html);

                        location.reload(true);
                    }
                });
            },
            error: function(data){

                var html = '<div class="alert alert-danger background-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled text-white"></i></button><strong>Error!</strong> Error while adding data</div>';

                $('.mainUpdateErrorMessage').html(html);
            }
        });
    });

    // Set data in delete modal popup 
    $(".deleteTag").click(function (e) {
        $tag_id = $(this).attr("data-tag");
        $href = "{{ url('tag-delete') }}/"+$tag_id;
        $('#confirmDeleteTag').attr("href",$href);
    });

    $('input').on('keyup', function () { 
        $(this).removeClass('is-invalid').addClass('is-valid');
        $(this).parent('.error_message_parent').find('#errorMessage').html(" ");
    });

    $('input').on('change', function () { 
        $(this).removeClass('is-invalid').addClass('is-valid');
        $(this).parent('.error_message_parent').find('#errorMessage').html(" ");
    });
});
</script>