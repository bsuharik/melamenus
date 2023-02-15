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
                        Texture
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
                    <h4>Manage Texture</h4>
                    <div class="row">
                        <div class="col-md-9">
                            <a data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-primary btn-block col-sm-12 col-md-3 mt-3" style="color:#fff!important;">Add Texture</a>
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
                                            
                                            <th><strong class="font-w600 wspace-no">Texture Image</strong></th>                
                                            <th><strong class="font-w600 wspace-no">Action</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                @if(count($texture_list) > '0')
                                    @foreach ($texture_list as $texture)
                                        <tr>
                                            <td>
                                                <img src="{{ config('images.texture_url') . $texture->image }}" width="50" height="50" alt="Texture Icon" />&nbsp;
                                            </td> 
                                            <td>
                                                <a href="#" data-toggle="modal" data-target="#updateTextureModal" data-id="{{ $texture->id}}" data-full-icon="{{ config('images.texture_url') . $texture->image }}" data-icon="{{ $texture->image }}" class="edit-btn updateTexture" style="float: none;"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                                                <a data-toggle="modal" data-target="#deletetextureModal" data-id="{{ $texture->id }}" class="delete-btn deletetexture" style="float: none;"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
             
        <!-- Add Texture Modal -->
        <div class="modal fade" id="exampleModalCenter">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Texture</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="mainErrorMessage"></div>
                    <form method="POST" id="add_texture" action="javascript:void(0)" enctype="multipart/form-data" files="true">
                        <div class="modal-body">
                           <div class="row">
                                <label class="col-md-12">Texture Image</label>
                                <div class="col-md-12 error_message_parent">
                                    <input type="file" class="form-control" name="image" id="image">
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <input type="submit" name="submit" value="Add Texture" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
         <!-- Delete Texture Modal -->
        <div class="modal fade" id="deletetextureModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-row">
                            <span>Are you sure you want to delete this Texure Image?</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                        <a href="" id="confirmDeletetexture" class="btn btn-primary" style="color:#fff!important; margin: 0;">Confirm Delete</a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Update Texture Modal -->
        <div class="modal fade" id="updateTextureModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Texture Details</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="mainUpdateErrorMessage"></div>
                    <form method="POST" id="update_texture" action="javascript:void(0)" enctype="multipart/form-data" files="true">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="modal-body">
                            <div class="row">
                               
                                <div class="col-md-12 ctm_input error_message_parent">
                                    <input type="hidden" name="id" id="update_id" />
                                    <div class="ctm_icon_input">
                                        <img src="" width="80" height="80" alt="Texture  Image" id="update_image" />
                                        <input type="hidden" name="current_image" id="current_image" />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-md-12">Texture Image</label>
                                <div class="col-md-12 error_message_parent">
                                    <input type="file" class="form-control" name="image" id="edit_image">
                                    <span id="errorMessage"></span>
                                </div>
                            </div> 
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <input type="submit" name="submit" value="Update Texture" class="btn btn-primary">
                        </div>
                    </form>
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

    // Add Texture
    $('#add_texture').submit(function(e) {

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: "{{ url('add_texture')}}",
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
                        var html ='<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> '+ value +'\</div>';

                        $('.mainErrorMessage').html(html);
                    }
                    else if(key == 'success')
                    {
                        var html = '<div class="alert alert-success background-success">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Success!</strong> '+ value +'\</div>';

                        $('.mainErrorMessage').html(html);

                        window.location.href = "<?php echo url('textures'); ?>";
                    }
                });
            },
            error: function(data){

                var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> Error while adding data</div>';

                $('.mainErrorMessage').html(html);
            }
        });
    });

    // Set data in update modal popup 
    $(".updateTexture").click(function (e) {

        $texture_id = $(this).attr("data-id");
        $texture_image = $(this).attr("data-icon");
        $texture_full_image = $(this).attr("data-full-icon");


        $('#update_id').val($texture_id);
        $('#current_image').val($texture_image);
        $("#update_image").attr("src", $texture_full_image);
    });

    // Update Texture
    $('#update_texture').submit(function(e) {

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: "{{ url('update_texture')}}",
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
                            $('#edit_'+key1).addClass('is-invalid');
                            $('#edit_'+key1).parent('.error_message_parent').find('#errorMessage').html(value1);
                        });
                    }
                    else if(key == 'errors') 
                    {
                        var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> '+ value +'\</div>';

                        $('.mainUpdateErrorMessage').html(html);
                    }
                    else if(key == 'success')
                    {
                        var html = '<div class="alert alert-success background-success">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Success!</strong> '+ value +'\</div>';

                        $('.mainUpdateErrorMessage').html(html); 

                        location.reload(true);
                    }
                });
            },
            error: function(data){ 

                var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> Error while adding data</div>';
                $('.mainUpdateErrorMessage').html(html);
            } 
        });
    });

    // Set data in delete modal popup 
    $(".deletetexture").click(function (e) {
        $tag_id = $(this).attr("data-id");
        $href = "{{ url('texture-delete') }}/"+$tag_id;
        $('#confirmDeletetexture').attr("href",$href);

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