@include('user_app.theme.header')

@include('user_app.theme.sidebar')

<!-- login--> 

    <div class="login app-pages app-section">

        <div class="container">

            <div class="pages-title">

                <h3>Login</h3>

            </div>

            @if(session()->has('error'))

                <div class="alert alert-danger">

                    {{ session()->get('error') }}

                </div>

            @endif

            @if ($message = session('social_login_error'))

                <div class="alert alert-danger">

                <strong>{{ $message }}</strong>

                </div>

            @endif

            <?php //echo "<pre>"; print_r(Session::all()); echo "</pre>"; exit();?>

            <form method="post" name="login_form" action="{{ route('login') }}">

                {{ csrf_field() }}

                <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" autofocus>

                <input type="hidden" name="restaurant_id" value="{{ $restaurant_details->restaurant_id }}">

                @if ($errors->has('email'))

                    <span class="help-block">

                        <strong>{{ $errors->first('email') }}</strong>

                    </span>

                @endif

                <input type="password" placeholder="Password" name="password">

                @if ($errors->has('password'))

                    <span class="help-block">

                        <strong>{{ $errors->first('password') }}</strong>

                    </span>

                @endif

                <div><a href="{{ route('password.request') }}" class="forgot">Forgot Password?</a></div>

                <div class="chebox">

                    <input type="checkbox" id="checkbox" />

                    <label for="checkbox">Remember me</label>

                </div>

                <button class="button">Login</button>

                <div class="create-account create_account">Not Registered? <a href="{{ url('user_signup') }}/{{ $restaurant_details->restaurant_id }}">Create an account</a></div>

                
                <div class="create_account_new_btn">
                    <a href="{{ route('social.oauth', 'facebook') }}" class="btn btn-primary btn-block">

                    <i class="fa fa-facebook-f"></i>

                    </a>

                    <a href="{{ route('social.oauth', 'google') }}" class="btn btn-danger btn-block">

                    <i class="fa fa-google"></i>

                    </a>
                </div>

            </form>

        </div>

    </div>

    <!-- end login -->



@include('user_app.theme.footer')

        