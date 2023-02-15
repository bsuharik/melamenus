<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title> {{ config('app.name') }} </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{!! asset('theme/admin/images/favicon.png') !!}">
    <link href="{!! asset('theme/admin/css/styles.css') !!}" rel="stylesheet">

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-4">
                                            <img class="logo-abbr" src="{!! asset('theme/admin/image/milamenu.png') !!}" alt="" height="50" />
                                        </div>
                                        <div class="col-md-4"></div>
                                    </div>
                                    <br>
                                    <h4 class="text-center mb-4">Reset Password</h4>
                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                                        {{ csrf_field() }}

                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                            @if ($errors->has('email'))
                                                <span id="errorMessage">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="submit" class="btn btn-primary btn-block">Send Password Reset Link</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Already have an account? <a class="text-primary" href="{{ url('login') }}">Login</a></p>
                                    </div>
                                    <div class="new-account mt-3">
                                        <p>Don't have an account? <a class="text-primary" href="{{ url('signup') }}">Sign Up</a></p>
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
    <script src="{!! asset('theme/admin/js/bootstrap-select.min.js') !!}"></script>
     
    <script src="{!! asset('theme/admin/js/custom.min.js') !!}"></script>
    <script src="{!! asset('theme/admin/js/deznav-init.js') !!}"></script>

</body>
</html>
