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
                        Restaurant Owner
                    </div>
                </div>

                <ul class="navbar-nav header-right">
                   
                </ul>
            </div>
        </nav>
    </div>
</div>
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
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <div class="tab-content">
                                    <div id="my-posts" class="tab-pane fade active show">
                                        <div class="my-post-content pt-3">
                                            <div class="row">
                                                <div class="col-md-10"></div>
                                                <div class="col-md-2">
                                                    <a href="{{ url('/restaurant-detail/') }}/{{ $restaurant->restaurant_id }}" class="btn btn-primary btn-block" style="color:#fff!important;">Back</a>
                                                </div>
                                            </div>
                                            <div class="profile-personal-info">
                                                <h4 class="text-primary mb-4">Restaurant Information</h4>
                                                <br>
                                                <div class="errorMessage"></div>
                                                <br>
                                                <form method="POST" enctype="multipart/form-data" id="update_restaurant_profile" action="javascript:void(0)" >
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <h5 class="f-w-500">Restaurant Name <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <span>
                                                                <input type="hidden" name="restaurant_id" id="restaurant_id" value="{{ $restaurant->restaurant_id }}"/>
                                                                <input type="text" class="form-control" name="restaurant_name" id="restaurant_name" placeholder="Enter Restaurant Name" value="{{ $restaurant->restaurant_name }}"/>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <h5 class="f-w-500">Restaurant Logo <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <span>
                                                                <div class="profile-photo" style="margin-top: 0px;">
                                                                    <img src="{{ asset('theme/images/restaurant/' . $restaurant->restaurant_logo) }}" class="img-fluid" style="max-width:90px;" alt="">
                                                                </div>
                                                                <input type="file" name="restaurant_logo" id="restaurant_logo" class="form-control"/>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <h5 class="f-w-500">Contact Person <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <span>
                                                                <input type="text" name="contact_person" id="contact_person" class="form-control" placeholder="Enter Contact Person" value="{{ $restaurant->contact_person }}"/>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <h5 class="f-w-500">Email <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" value="{{ $restaurant->email }}"/>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <h5 class="f-w-500">Contact Number <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="contact_number" id="contact_number" class="form-control" placeholder="Enter Contact Number" value="{{ $restaurant->contact_number }}"/>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <h5 class="f-w-500">Location <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="location" id="location" class="form-control" placeholder="Enter Location" value="{{ $restaurant->location }}"/>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <h5 class="f-w-500">Theme Color <span class="pull-right">:</span>
                                                            </h5>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" name="app_theme_color" id="app_theme_color" class="form-control" placeholder="Enter There Color" value="{{ $restaurant->app_theme_color }}"/>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <input class="btn btn-primary btn-block" type="submit" name="save">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#update_restaurant_profile').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        // console.log(formData);
        $.ajax({
            type:'POST',
            url: "{{ url('restaurant_profile')}}",
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

                        $('.errorMessage').html(html);

                        location.reload(true);
                    }
                    else if(key == 'success')
                    {
                        var html = '<div class="alert alert-success background-success">\
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <i class="icofont icofont-close-line-circled text-white"></i>\
                                        </button>\
                                        <strong>Success!</strong> '+ value +'\
                                    </div>';

                        $('.errorMessage').html(html);

                        location.reload(true);
                    }
                });
            },
            error: function(data){
                var html = '<div class="alert alert-danger background-danger">\
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                    <i class="icofont icofont-close-line-circled text-white"></i>\
                                </button>\
                                <strong>Error!</strong> Error while updating data\
                            </div>';

                $('.errorMessage').html(html);

                // location.reload(true);
            }
        });
    });

});
</script>