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

                        {{ $restaurant->restaurant_name }} - Edit Profile DetailsLIVE

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

        <form method="POST" enctype="multipart/form-data" id="update_restaurant_profile" action="javascript:void(0)" files="true">

            <!-- row -->

            <div class="row">                

                <div class="col-xl-12">

                    <div class="card">

                        <div class="card-body">

                            <!-- row -->

                            <div class="row"> 

                                <div class="col-sm-10"></div>

                                <div class="col-sm-2 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">

                                    <input class="btn btn-primary btn-block" type="submit" name="save" value="Save">

                                    &nbsp;

                                    <a href="{{ url('restaurant-detail') }}/{{ $restaurant->restaurant_id }}" id="back_button" class="btn btn-info btn-block">Back</a>

                                </div>

                            </div>

                            <br>

                            <div class="errorMessage"></div>

                            <div class="profile-tab">

                                <div class="profile card card-body px-3 pt-3 pb-0" style="padding-top: 0px !important;">

                                    <div class="profile-head">                               

                                        <div class="profile-info">

                                            <div class="profile-photo error_message_parent" style="margin-top: 0px;">

                                                <img src="../{{ config('images.restaurant_url') .$restaurant->restaurant_id.'/'. $restaurant->restaurant_logo }}" class="img-fluid" alt="Restaurant Logo">

                                                <br>

                                                <br>

                                                <input type="file" name="restaurant_logo" id="restaurant_logo">

                                                <span id="errorMessage"></span>

                                            </div>

                                            <div class="profile-details">

                                                <div class="profile-name px-3 pt-3">

                                                    <h4 class="text-primary mb-0 error_message_parent">

                                                        <input type="hidden" name="restaurant_id" id="restaurant_id" value="{{ $restaurant->restaurant_id }}"/>

                                                        <input type="text" class="form-control" name="restaurant_name" id="restaurant_name" placeholder="Enter Restaurant Name" value="{{ $restaurant->restaurant_name }}" maxlength="50"/>

                                                        <span id="errorMessage"></span>

                                                    </h4>

                                                </div>

                                                <div class="dropdown ml-auto">

                                                    

                                                </div>                                 

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="custom-tab-1">

                                    <div class="tab-content">

                                        <div id="my-posts" class="tab-pane fade active show">

                                            <div class="my-post-content pt-3">

                                                <div class="profile-personal-info">

                                                    <h4 class="text-primary mb-4">Restaurant Information</h4>



                                                    <div class="row form-group">

                                                        <div class="col-md-2">

                                                            <label id="custom-label">First Name</label>

                                                        </div>

                                                        <div class="col-md-10 error_message_parent">

                                                            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $restaurant->first_name }}" maxlength="50" />

                                                            <span id="errorMessage"></span>

                                                        </div>

                                                    </div>

                                                    <div class="row form-group">

                                                        <div class="col-md-2">

                                                            <label id="custom-label">Last Name</label>

                                                        </div>

                                                        <div class="col-md-10 error_message_parent">

                                                            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $restaurant->last_name }}" maxlength="50" />

                                                            <span id="errorMessage"></span>

                                                        </div>

                                                    </div>

                                                    <div class="row form-group">

                                                        <div class="col-md-2">

                                                            <label id="custom-label">Email</label>

                                                        </div>

                                                        <div class="col-md-10 error_message_parent">

                                                            <input type="email" name="email" id="email" class="form-control" value="{{ $restaurant->email }}"/>

                                                            <span id="errorMessage"></span>

                                                        </div>

                                                    </div>

                                                    <div class="row form-group">

                                                        <div class="col-md-2">

                                                            <label id="custom-label">Contact Number </label>

                                                        </div>

                                                        <div class="col-md-10 error_message_parent">

                                                            <input type="text" name="contact_number" id="contact_number" class="form-control" value="{{ $restaurant->contact_number }}"/>

                                                            <span id="errorMessage"></span>

                                                        </div>

                                                    </div>  

                                                    <div class="row form-group">

                                                        <div class="col-md-2">

                                                            <label id="custom-label">Contact Person</label>

                                                        </div>

                                                        <div class="col-md-10 error_message_parent">

                                                            <input type="text" name="contact_person" id="contact_person" class="form-control" value="{{ $restaurant->contact_person }}" maxlength="50" />

                                                            <span id="errorMessage"></span>

                                                        </div>

                                                    </div>  

                                                    <div class="row form-group">

                                                        <div class="col-md-2">

                                                            <label id="custom-label">Country </label>

                                                        </div>

                                                        <div class="col-md-10 error_message_parent">

                                                            <select name="country_id" class="form-control" id="country_id">

                                                                <option value="">Select Country</option>

                                                            @if(count($country_list) > '0')

                                                                @foreach ($country_list as $value)

                                                                    <option value="{{ $value->country_id }}" {{ ( $value->country_id == $restaurant->country_id) ? 'selected' : '' }} >{{ $value->country_name }}</option>

                                                                @endforeach

                                                            @endif

                                                            </select>

                                                            <span id="errorMessage"></span>

                                                        </div>

                                                    </div>                                              

                                                    <div class="row form-group">

                                                        <div class="col-md-2">

                                                            <label id="custom-label">Address </label>

                                                        </div>

                                                        <div class="col-md-10 error_message_parent">

                                                            <textarea name="location" id="location" class="form-control">{{ $restaurant->location }}</textarea>

                                                            <span id="errorMessage"></span>

                                                        </div>

                                                    </div>

                                                    <div class="row form-group">

                                                        <div class="col-md-2">

                                                            <label id="custom-label">Currency </label>

                                                        </div>

                                                        <div class="col-md-10 error_message_parent">

                                                            <select name="currency_id" class="form-control" id="currency_id">

                                                                <option value="">Select Currency</option>

                                                            @if(count($currency_list) > '0')

                                                                @foreach ($currency_list as $value)

                                                                    <option value="{{ $value->currency_id }}" {{ ( $value->currency_id == $restaurant->currency_id) ? 'selected' : '' }} >{{ $value->currency_name }}</option>

                                                                @endforeach

                                                            @endif

                                                            </select>

                                                            <span id="errorMessage"></span>

                                                        </div>

                                                    </div>

                                                    <div class="row form-group">

                                                        <div class="col-md-2">

                                                            <label id="custom-label">Gender </label>

                                                        </div>

                                                        <div class="col-md-10 error_message_parent">

                                                            <select name="gender" class="form-control" id="gender">

                                                                <option value="">Select Gender</option>

                                                                <option value="0" {{ ( $restaurant->gender == '0') ? 'selected' : '' }} >Male</option>

                                                                <option value="1" {{ ( $restaurant->gender == '1') ? 'selected' : '' }} >Female</option>

                                                                <option value="2" {{ ( $restaurant->gender == '2') ? 'selected' : '' }} >Other</option>

                                                            </select>

                                                            <span id="errorMessage"></span>

                                                        </div>

                                                    </div>

                                                    <div class="row form-group">

                                                        <div class="col-md-2">

                                                            <label id="custom-label">Date Of Birth</label>

                                                        </div>

                                                        <div class="col-md-10 error_message_parent">

                                                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ $restaurant->date_of_birth }}"/>

                                                            <span id="errorMessage"></span>

                                                        </div>

                                                    </div>

                                                    <div class="row form-group">

                                                        <div class="col-md-2">

                                                            <label id="custom-label">Select Theme Colors </label>

                                                        </div>

                                                        <div class="col-md-10 error_message_parent">

                                                        </div>

                                                    </div>

                                                    <div class="row form-group">

                                                        <div class="col-md-3">

                                                            <label id="custom-color-label">Header color </label>

                                                            <input type="text" class="as_colorpicker form-control" value="{{ $restaurant->app_theme_color_1 }}" name="app_theme_color_1">

                                                            <span id="errorMessage"></span>

                                                        </div>

                                                        <div class="col-md-3">

                                                            <label id="custom-color-label">Main Title color </label>

                                                            <input type="text" class="form-control as_colorpicker"value="{{ $restaurant->app_theme_color_2}}" name="app_theme_color_2">

                                                            <span id="errorMessage"></span>

                                                        </div>

                                                        <div class="col-md-3">

                                                            <label id="custom-color-label">Sub Title color </label>

                                                            <input type="text" class="as_colorpicker form-control" value="{{ $restaurant->app_theme_color_3 }}" name="app_theme_color_3">

                                                            <span id="errorMessage"></span>

                                                        </div>

                                                        <div class="col-md-3">

                                                            <label id="custom-color-label">Description color </label>

                                                            <input type="text" class="as_colorpicker form-control" value="{{ $restaurant->app_theme_color_4 }}" name="app_theme_color_4">

                                                            <span id="errorMessage"></span>

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

        </form>

    </div>

</div>

<!--**********************************

    Content body end

***********************************-->



@include('theme.footer')



<script type="text/javascript">

$(document).ready(function (e) {



    $('#errorMessage').html(" ");



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

                            $('#'+key1).parent('.error_message_parent').find('#errorMessage').html(value1);

                        });

                    }

                    else if(key == 'errors') 

                    {

                        var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> '+ value +'\</div>';



                        $('.errorMessage').html(html);



                        location.reload(true);

                    }

                    else if(key == 'success')

                    {

                        var html = '<div class="alert alert-success background-success">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Success!</strong> '+ value +'\</div>';



                        $('.errorMessage').html(html);



                        window.location.href = '<?php echo url('restaurant-detail/'.$restaurant->restaurant_id);?>';

                    }

                });

            },

            error: function(data){

                var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> Error while updating data\div>';



                $('.errorMessage').html(html);



                // location.reload(true);

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



    $('textarea').on('keyup', function () { 

        $(this).removeClass('is-invalid').addClass('is-valid');

        $(this).parent('.error_message_parent').find('#errorMessage').html(" ");

    });



    $('select').on('change', function () { 

        $(this).removeClass('is-invalid').addClass('is-valid');

        $(this).parent('.error_message_parent').find('#errorMessage').html(" ");

    });



});

</script>