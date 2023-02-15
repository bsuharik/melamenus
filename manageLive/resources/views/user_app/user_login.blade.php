@include('user_app.theme.header')
@include('user_app.theme.sidebar', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details] )

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
            <form method="post" name="login_form" action="{{ route('login') }}">
                {{ csrf_field() }}
                <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
                <input type="hidden" name="restaurant_id" value="{{ $restaurant_details->restaurant_id }}">
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                <input type="password" placeholder="Password" name="password" required>
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
                <div class="create-account">Not Registered? <a href="{{ url('user_signup') }}/{{ $restaurant_details->restaurant_id }}">Create an account</a></div>
            </form>
        </div>
    </div>
    <!-- end login -->

@include('user_app.theme.footer')
        