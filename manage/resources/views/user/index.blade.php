@include('theme.header')

<!--**********************************
    Header start
***********************************-->
<?php $user_type = Auth::user()->user_type; ?>
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">

                    @if($user_type == "0")
                        <div class="dashboard_bar">
                            APP Users
                        </div>
                    @else
                        <div class="dashboard_bar">
                            Restaurant Users
                        </div>
                    @endif
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
                <a href="{{ url('home') }}" id="back_button" class="btn btn-info btn-block back-btn-new">Back</a>
            </div>
        </div>
        <br>
        <div class="form-head d-flex mb-3 align-items-start">
            <div class="mr-auto d-none col-md-12 d-lg-block">
                <div class="welcome-text">
                    <h4>Manage Users</h4>
                    <div class="row">
                        <div class="col-md-9">
                            @if($user_type == "1")
                                <a data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-primary btn-block col-sm-12 col-md-3  mt-3" style="color:#fff!important;">Add User</a>
                           @endif
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
                                @if($user_type == "0")
                                <table id="example5" class="display mb-4 dataTablesCard results">
                                    <thead>
                                        <tr>
                                            <th><strong class="font-w600 wspace-no">First Name</strong></th>
                                            <th><strong class="font-w600 wspace-no">Last Name</strong></th>
                                            <th><strong class="font-w600 wspace-no">Email</strong></th>
                                            <th><strong class="font-w600 wspace-no">Gender</strong></th>
                                            <th><strong class="font-w600 wspace-no">Date Of Birth</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($users_list) > '0')
                                            @foreach ($users_list as $user)
                                                <tr>
                                                    <td> {{ $user->first_name }} </td>
                                                    <td> {{ $user->last_name }} </td>
                                                    <td> {{ $user->email }} </td>
                                                    <td> 
                                                        @if($user->gender != "")
                                                            @if($user->gender == "0")
                                                                Male
                                                            @elseif($user->gender == "1")
                                                                Female
                                                            @elseif($user->gender == "2")
                                                                Other
                                                            @endif
                                                        @else
                                                            -
                                                        @endif 
                                                    </td>
                                                    <td> 
                                                        @if($user->date_of_birth != "")
                                                            {{ date('d-m-Y',strtotime($user->date_of_birth)) }}
                                                        @else
                                                            -
                                                        @endif 
                                                    </td>
                                                </tr> 
                                            @endforeach
                                        @else
                                            <tr>
                                                <td></td>
                                                <td>No Data Found</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endif                          
                                    </tbody>
                                </table>
                                @else
                                    <table id="example5" class="display mb-4 dataTablesCard results">
                                        <thead>
                                            <tr>
                                                <th><strong class="font-w600 wspace-no">Restaurant Name</strong></th>
                                                <th><strong class="font-w600 wspace-no">Contact Person</strong></th>
                                                <th><strong class="font-w600 wspace-no">Email</strong></th>                                 
                                                <th><strong class="font-w600 wspace-no">Location</strong></th>
                                                <th><strong class="font-w600 wspace-no">Contact No.</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($restaurants as $restaurant)

                                            <tr onclick="window.location.href='restaurant-detail/{{ $restaurant->restaurant_id }}'" style="cursor:pointer;">
                                            <td style="text-align:center">
                                            <div class="profile-photo" style="margin-top: 0px;">
                                            <img src="{{ config('images.restaurant_url') .$restaurant->restaurant_id.'/'. $restaurant->restaurant_logo }}" class="img-fluid" style="max-width:90px;" alt="">
                                            </div>{{ $restaurant->restaurant_name }}
                                            </td>
                                            <td>{{ $restaurant->contact_person }}</td>
                                            <td>{{ $restaurant->email }}</td>                                               
                                            <td>{{ $restaurant->location }}</td>
                                            <td>{{ $restaurant->contact_number }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <!-- Add  Restaurant User Modal -->
        <div class="modal fade" id="exampleModalCenter">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add User</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="mainErrorMessage"></div>
                    <form method="POST" id="add_user" action="javascript:void(0)" enctype="multipart/form-data" files="true" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="restaurant_id" value="{{ Auth::user()->restaurant_id}}" />
                          
                        <div class="modal-body">
                            <div class="row">
                                <label class="col-md-12">Restaurant Name</label>
                                <div class="col-md-12 error_message_parent">
                                    <input type="text" class="form-control" name="restaurant_name" id="restaurant_name" placeholder="Enter Restaurant Name" />
                                    <span id="errorMessage"></span>
                                </div> 
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-md-12">First Name</label>
                                <div class="col-md-12 error_message_parent">
                                    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter First Name" />
                                    <span id="errorMessage"></span>
                                </div> 
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-md-12">Last Name</label>
                                <div class="col-md-12 error_message_parent">
                                    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter Last Name" />
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-md-12">Email</label>
                                <div class="col-md-12 error_message_parent">
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email Name" />
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-md-12">Contact Number</label>
                                <div class="col-md-12 error_message_parent">
                                    <input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Enter Contact Number" />
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-md-12">Contact Person</label>
                                <div class="col-md-12 error_message_parent">
                                    <input type="text" class="form-control" name="contact_person" id="contact_person" placeholder="Enter Contact Person" />
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                            
                            <br>
                            <div class="row">
                                <label class="col-md-12">Gender</label>
                                <div class="col-md-12 error_message_parent">
                                    <select name="gender" class="form-control" id="gender">
                                        <option value="">Select Gender</option>
                                        <option value="0">Male</option>
                                        <option value="1">Female</option>
                                        <option value="2">Other</option>
                                    </select>
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                             <br>
                            <div class="row">
                                <label class="col-md-12">Date Of Birth</label>
                                <div class="col-md-12 error_message_parent">
                                    <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" placeholder="Date Of Birth">
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-md-12">Select Country</label>
                                <div class="col-md-12 error_message_parent">
                                    <select name="country" class="form-control" id="country">
                                        <option value="">Select Country</option>
                                        @if(count($country_array) > '0')
                                            @foreach ($country_array as $value)
                                                <option value="{{ $value->country_id }}">{{ $value->country_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-md-12">Select Time Zone</label>
                                <div class="col-md-12 error_message_parent">
                                    <select name="time_zone" class="form-control" id="time_zone">
                                        <option value="">Select TimeZone</option>
                                        @if(count($country_array) > '0')
                                            @foreach ($country_array as $value)
                                                <option value="{{ $value->country_id }}">{{ $value->time_zone }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-md-12">Select Country</label>
                                <div class="col-md-12 error_message_parent">
                                    <select name="currency" class="form-control" id="currency">
                                        <option value="">Select Currency</option>
                                        @if(count($currency_list) > '0')
                                            @foreach ($currency_list as $value)
                                                <option value="{{ $value->currency_id }}">{{ $value->currency_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-md-12">Address </label>
                                <div class="col-md-12 error_message_parent">
                                    <textarea name="address" id="address" class="form-control"></textarea>
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-md-12">Password</label>
                                <div class="col-md-12 error_message_parent">
                                    <input type="password" class="form-control" name="password" id="password" Placeholder="Password">
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-md-12">Confirm Password</label>
                                <div class="col-md-12 error_message_parent">
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <input type="submit" name="submit" value="Add User" class="btn btn-primary">
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
<script>
    $(document).ready(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#add_user').submit(function(e) {

            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type:'POST',
                url: "{{ url('create_user')}}",
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
                        else if(key == 'success'){
                            var html = '<div class="alert alert-success background-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled text-white"></i></button><strong>Success!</strong> '+ value +'</div>';
                            $('.mainErrorMessage').html(html);
                            location.reload();
                        }
                    });
                },
                error: function(data){
                    var html = '<div class="alert alert-danger background-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled text-white"></i></button><strong>Error!</strong> Error while adding data</div>';
                    $('.mainErrorMessage').html(html);
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