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
                        Allergies
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
                    <h4>Manage Allergies</h4>
                    <div class="row">
                        <div class="col-md-9">
                            <a data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-primary btn-block col-sm-12 col-md-3  mt-3" style="color:#fff!important;">Add Allergy</a>
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
             
        <!-- Add Table Modal -->
        <div class="modal fade" id="exampleModalCenter">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Allergy</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="mainErrorMessage"></div>
                    <form method="POST" id="add_allergy" action="javascript:void(0)" enctype="multipart/form-data" files="true" >
                        <div class="modal-body">
                            <div class="row">
                                <label class="col-md-12">Allergy Name</label>
                                <div class="col-md-12 error_message_parent">
                                    <input type="text" class="form-control" name="allergy_name" id="allergy_name" placeholder="Enter Allergy Name" />
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-md-12">Allergy Icon</label>
                                <div class="col-md-12 error_message_parent">
                                    <input type="file" class="form-control" name="allergy_icon" id="allergy_icon">
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <input type="submit" name="submit" value="Add Allergy" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update allergy Modal -->
        <div class="modal fade" id="updateAllergyModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Allergy Details</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="mainUpdateErrorMessage"></div>
                    <form method="POST" id="update_allergy" action="javascript:void(0)" enctype="multipart/form-data" files="true" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="modal-body"> 
                            <div class="row">
                                <label class="col-md-12">Allergy Name</label>
                                <div class="col-md-12 ctm_input error_message_parent">
                                    <input type="hidden" name="allergy_id" id="update_allergy_id" />
                                    <input type="text" class="form-control" name="allergy_name" id="update_allergy_name" />
                                    <span id="errorMessage"></span>
                                    <div class="ctm_icon_input">
                                        <input type="hidden" name="current_allergy_icon" id="current_allergy_icon" />
                                        <img src="" width="50" height="50" alt="Allergy Icon" id="update_allergy_icon_image" />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-md-12">Allergy Icon</label>
                                <div class="col-md-12 error_message_parent">
                                    <input type="file" class="form-control" name="allergy_icon" id="update_allergy_icon">
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <input type="submit" name="submit" value="Update Allergy" class="btn btn-primary">
                        </div>
                    </form>
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
                                            <th><strong class="font-w600 wspace-no">Allergy Name</strong></th>
                                            <th><strong class="font-w600 wspace-no">Allergy Icon</strong></th>
                                            <th><strong class="font-w600 wspace-no">Action</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                @if(count($allergy_list) > '0')
                                    @foreach ($allergy_list as $allergy)
                                        <tr>
                                            <td> {{ $allergy->allergy_name }} </td>
                                            <td>
                                                <img src="{{ config('images.allergy_url') . $allergy->allergy_icon }}" width="50" height="50" alt="Allergy Icon" />&nbsp;
                                            </td>
                                            <td>
                                                <a href="#" data-toggle="modal" data-target="#updateAllergyModal" data-id="{{ $allergy->allergy_id}}" data-name="{{ $allergy->allergy_name}}" data-full-icon="{{ config('images.allergy_url') . $allergy->allergy_icon }}" data-icon="{{ $allergy->allergy_icon }}" class="edit-btn updateAllergy" style="float: none;"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                                                <!-- <a href="{{ url('allergy-delete') }}/{{ $allergy->allergy_id }}" class="delete-btn" style="float: none;"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                                                 <a data-toggle="modal" data-target="#deleteAllergyModal" data-allergy="{{ $allergy->allergy_id }}" class="delete-btn deleteAllergy" style="float: none;"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
         <!-- Delete Allergy Modal -->
        <div class="modal fade" id="deleteAllergyModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-row">
                            <span>Are you sure you want to delete this allergy details?</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                        <a href="" id="confirmDeleteAllergy" class="btn btn-primary" style="color:#fff!important; margin: 0;">Confirm Delete</a>
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

    // Add allergy
    $('#add_allergy').submit(function(e) {

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: "{{ url('add_allergy')}}",
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
                        var html = '<div class="alert alert-danger background-danger">\
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <i class="icofont icofont-close-line-circled text-white"></i>\
                                        </button>\
                                        <strong>Error!</strong> '+ value +'\
                                    </div>';

                        $('.mainErrorMessage').html(html);
                    }
                    else if(key == 'success')
                    {
                        var html = '<div class="alert alert-success background-success">\
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <i class="icofont icofont-close-line-circled text-white"></i>\
                                        </button>\
                                        <strong>Success!</strong> '+ value +'\
                                    </div>';

                        $('.mainErrorMessage').html(html);

                        window.location.href = "<?php echo url('allergies'); ?>";
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

                $('.mainErrorMessage').html(html);
            }
        });
    });

    // Set data in update modal popup 
    $(".updateAllergy").click(function (e) {

        $allergy_id = $(this).attr("data-id");
        $allergy_name = $(this).attr("data-name");
        $allergy_icon = $(this).attr("data-icon");
        $allergy_full_icon = $(this).attr("data-full-icon");


        $('#update_allergy_id').val($allergy_id);
        $('#update_allergy_name').val($allergy_name);
        $('#current_allergy_icon').val($allergy_icon);
        $("#update_allergy_icon_image").attr("src", $allergy_full_icon);
    });

    // Update allergy
    $('#update_allergy').submit(function(e) {

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: "{{ url('update_allergy')}}",
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
                        var html = '<div class="alert alert-danger background-danger">\
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <i class="icofont icofont-close-line-circled text-white"></i>\
                                        </button>\
                                        <strong>Error!</strong> '+ value +'\
                                    </div>';

                        $('.mainUpdateErrorMessage').html(html);
                    }
                    else if(key == 'success')
                    {
                        var html = '<div class="alert alert-success background-success">\
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <i class="icofont icofont-close-line-circled text-white"></i>\
                                        </button>\
                                        <strong>Success!</strong> '+ value +'\
                                    </div>';

                        $('.mainUpdateErrorMessage').html(html);

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

                $('.mainUpdateErrorMessage').html(html);
            }
        });
    });

    $('input').on('keyup', function () { 
        $(this).removeClass('is-invalid').addClass('is-valid');
        $(this).parent('.error_message_parent').find('#errorMessage').html(" ");
    });

    $('input').on('change', function () { 
        $(this).removeClass('is-invalid').addClass('is-valid');
        $(this).parent('.error_message_parent').find('#errorMessage').html(" ");
    });

    // Set data in delete modal popup 
    $(".deleteAllergy").click(function (e) {

        $allergy_id = $(this).attr("data-allergy");

        $href = "{{ url('allergy-delete') }}/"+$allergy_id;
        $('#confirmDeleteAllergy').attr("href",$href);
    });
});
</script>