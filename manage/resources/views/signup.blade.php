<!DOCTYPE html>

<html lang="en" class="h-100">



<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ config('app.name') }} </title>

    <!-- Favicon icon -->

    <link rel="icon" type="image/png" sizes="16x16" href="{!! asset('theme/admin/images/favicon.png') !!}">

    <link href="{!! asset('theme/admin/css/styles.css') !!}" rel="stylesheet">



</head>



<body class="h-100">

    <div class="authincation h-100">

        <div class="container h-100">

            <div class="row justify-content-center h-100 align-items-center">

                <div class="col-md-12">

                    <div class="authincation-content login_main">

                        <div class="row no-gutters">

                            <div class="col-xl-12">

                                <div class="auth-form">

                                    <div class="row">

                                        <div class="col-md-4"></div>

                                        <div class="col-md-4" style="text-align: center;">

                                            <!--<img class="logo-abbr" src="{!! asset('theme/admin/image/milamenu_signup.png') !!}" alt="" height="50" />-->

                                            <img class="logo-abbr" src="{!! asset('theme/admin/image/milamenu_auth.png') !!}" alt="" height="50" />

                                            



                                        </div>

                                        <div class="col-md-4"></div>

                                    </div>

                                    <br>

                                    <h4 class="text-center mb-4">Sign up your account</h4>

                                    <!-- Loader -->

                                    <div class="loader-block text-center mb-4" id="loading-image" style="display: none;">

                                        <img src="{!! asset('theme/images/preloader.gif') !!}" alt="" />

                                    </div>

                                    <form method="POST" enctype="multipart/form-data" id="create_user" action="javascript:void(0)" >

                                        <div class="mainErrorMessage"></div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">

													<label class="mb-1"><strong>Restaurant Name</strong></label>

													<input type="text" class="form-control" name="restaurant_name" id="restaurant_name" placeholder="Restaurant Name" maxlength="50">

													<span id="errorMessage"></span>

												</div>

												<div class="form-group">

													<label class="mb-1"><strong>First Name</strong></label>

													<input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" maxlength="50">

													<span id="errorMessage"></span>

												</div>

												

												

												<div class="form-group">

													<label class="mb-1"><strong>Password</strong> <i class="fa fa-exclamation-circle" data-toggle="tooltip" data-placement="top" data-html="true" title="Minimum 6 character<br/>One Uppercase letter.<br/>One Lowercase letter."></i></label>
													<input type="password" class="form-control" name="password" id="password" Placeholder="Password">

													<span id="errorMessage"></span>

												</div>
												<div class="form-group">

													<label class="mb-1"><strong>Country</strong></label>

													<div class="selectdiv">

														<select name="country_id" class="form-control" id="country_id">

															<option value="">Select Country</option>

															@if(count($country_list) > '0')

															@foreach ($country_list as $value)

															<option value="{{ $value->country_id }}">{{ $value->country_name }}</option>

															@endforeach

															@endif

														</select>

														<span id="errorMessage"></span>

													</div>

												</div>
												
											</div>

											<div class="col-md-6">
												<div class="form-group">

													<label class="mb-1"><strong>Email</strong></label>

													<input type="email" class="form-control" name="email" id="email" placeholder="hello@example.com">

													<span id="errorMessage"></span>

												</div>
												<div class="form-group">
	
													<label class="mb-1"><strong>Last Name</strong></label>

													<input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" maxlength="50">

													<span id="errorMessage"></span>

												</div>
												<div class="form-group">

													<label class="mb-1"><strong>Confirm Password</strong> <i class="fa fa-exclamation-circle" data-toggle="tooltip" data-placement="top" data-html="true" title="Minimum 6 character<br/>One Uppercase letter.<br/>One Lowercase letter."></i></label>

													<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">

													<span id="errorMessage"></span>

												</div>
												

											

												<div class="form-group">

													<label class="mb-1"><strong>Currency</strong></label>

													<div class="selectdiv">

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
											</div>
										</div>
											<div class="form-group">

													<label class="mb-1"><strong>Address</strong></label>

													<textarea class="form-control" name="location" id="location" placeholder="Enter Address"></textarea>

													<span id="errorMessage"></span>

												</div>	  
											  

                                        <div class="text-center mt-4">

                                            <input type="submit" name="submit" value="Sign me up" id="submit" class="btn btn-primary btn-block" style="color:#fff!important;">

                                        </div>

                                    </form>
									
                                    <div class="new-account mt-3">

                                        <!--class="text-primary"-->

                                        <p>Already have an account? <a href="{{ url('login') }}">Sign in</a></p>

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

    Scripts

    ***********************************-->

    <!-- Required vendors -->

    <script src="{!! asset('theme/admin/js/global.min.js') !!}"></script>

    <!-- <script src="{!! asset('theme/admin/js/bootstrap-select.min.js') !!}"></script> -->



    <script src="{!! asset('theme/admin/js/custom.min.js') !!}"></script>

    <script src="{!! asset('theme/admin/js/deznav-init.js') !!}"></script>



    <script src="{!! asset('theme/admin/js/user_register.js') !!}"></script>



    <script type="text/javascript">

        $(document).ready(function (e) {

            $('[data-toggle="tooltip"]').tooltip()

            $('#errorMessage').html(" ");

            $('.mainErrorMessage').html(" ");



    // CSRF Token

    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });



    // Create New User

    $('#create_user').submit(function(e) {

        e.preventDefault();

        var formData = new FormData(this);

        

        $.ajax({

            type:'POST',

            url: "{{ url('register_user')}}",

            data: formData,

            cache:false,

            contentType: false,

            processData: false,

            beforeSend: function() {

                $("#loading-image").show();

            },

            success: function(data){



                $.each(data, function(key, value) 

                {                   

                    if(key == 'error') 

                    {

                        $("#loading-image").hide();

                        $.each(value, function(key1, value1) 

                        {

                            $('#'+key1).addClass('is-invalid');

                            $('#'+key1).parent('.form-group').find('#errorMessage').html(value1);

                        });

                    }

                    else if(key == 'errors'){

                        $("#loading-image").hide();

                        var html = '<div class="alert alert-danger background-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled text-white"></i></button><strong>Error!</strong> '+ value +'</div>';

                        $('.mainErrorMessage').html(html);

                    }

                    else if(key == 'success')

                    {

                        $("#loading-image").hide();

                        var html = '<div class="alert alert-success background-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled text-white"></i></button><strong>Success!</strong> '+ value +'</div>';



                        $('.mainErrorMessage').html(html);



                        $("input").val('');

                        $("input").removeClass('is-invalid').removeClass('is-valid');

                        $("input").parent('.form-group').find('#errorMessage').html(" ");

                        

                        $("select").val('');

                        $("select").removeClass('is-invalid').removeClass('is-valid');

                        $("select").parent('.form-group').find('#errorMessage').html(" ");

                        

                        $("textarea").val('');

                        $("textarea").removeClass('is-invalid').removeClass('is-valid');

                        $("textarea").parent('.form-group').find('#errorMessage').html(" ");



                        $("#submit").val('Sign me up');

                        

                         window.location.href = '/home';

                    }

                });

            },

            error: function(data){

                $("#loading-image").hide();

                var html = '<div class="alert alert-danger background-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled text-white"></i></button><strong>Error!</strong> Error while adding data</div>';

                $('.mainErrorMessage').html(html);

            }

        });

    });



    $('input').on('keyup', function () { 

        $(this).removeClass('is-invalid').addClass('is-valid');

        $(this).parent('.form-group').find('#errorMessage').html(" ");

    });



    $('textarea').on('keyup', function () { 

        $(this).removeClass('is-invalid').addClass('is-valid');

        $(this).parent('.form-group').find('#errorMessage').html(" ");

    });



    $('select').on('change', function () { 

        $(this).removeClass('is-invalid').addClass('is-valid');

        $(this).parent('.form-group').find('#errorMessage').html(" ");

    });



    $('#password_confirmation').on('change', function () { 

        var password = $('#password').val();

        var password_confirmation = $(this).val();



        if (password != password_confirmation) 

        {

            $(this).addClass('is-invalid').removeClass('is-valid');

            $(this).parent('.form-group').find('#errorMessage').html("Password Does not match.");

        }

        else

        {

            $(this).removeClass('is-invalid').addClass('is-valid');

            $(this).parent('.form-group').find('#errorMessage').html(" ");

        }

    });



});

</script>



</body>

</html>