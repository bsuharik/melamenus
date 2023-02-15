@include('user_app.theme.header')
@include('user_app.theme.sidebar', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details] )
    <!-- register-->
    <div class="register app-pages app-section">
        <div class="container">
            <div class="pages-title">
                <h3>Register</h3>
            </div>
            <div class="mainErrorMessage"></div>
            <form method="POST" enctype="multipart/form-data" id="create_user" action="javascript:void(0)" >
                <input type="hidden" name="restaurant_id" value="{{ $restaurant_details->restaurant_id }}">
                <input type="text" name="first_name" id="first_name" placeholder="First Name" class="" maxlength="50">
                <input type="text" name="last_name" id="last_name" placeholder="Last Name" maxlength="50">
                <input type="email" name="email" id="email" placeholder="Email">
                <input type="password" name="password" id="password" placeholder="Password">
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                <select name="gender" id="gender" placeholder="Gender">
                    <option value="">Select Gender</option>
                    <option value="0">Male</option>
                    <option value="1">Female</option>
                    <option value="2">Other</option>
                </select>
                <div class="input-field"> <input placeholder="Date Of Birth" type="text" value="" name="date_of_birth" id="date_of_birth" class="datepicker"></div>
                <!--<input type="text" name="date_of_birth" id="date_of_birth" placeholder="Date Of Birth" onclick="(this.type='date')" >-->
                <input type="submit" name="submit" id="submit" value="Register" class="button">
                <br>
                <br>
                <strong class="login-now">You're already registered? <a href="{{ url('user_login') }}/{{ $restaurant_details->restaurant_id }}">Login now</a></strong>
            </form>
        </div>
    </div>
    <!-- end register -->
@include('user_app.theme.footer')
<script type="text/javascript">
$(document).ready(function (e) {
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
            url: "{{ url('user_register')}}",
            data: formData,
            cache:false,
            contentType:false,
            processData:false,
            success: function(data){
                $.each(data, function(key, value) 
                {               
                    // console.log(key);    
                    // console.log(value);
                    if(key == 'error') 
                    {
                        $.each(value, function(key1, value1) 
                        {
                            $('#'+key1).addClass('is-invalid').removeClass('is-valid');
                        });
                    }
                    else if(key == 'errors') 
                    {
                        var html = '<div class="alert alert-danger background-danger">\
                                        <strong>Error!</strong> '+ value +'\
                                    </div>';
                        $('.mainErrorMessage').html(html);
                        // location.reload(true);
                    }
                    else if(key == 'success')
                    {
                        var html = '<div class="alert alert-success background-success">\
                                        <strong>Success!</strong> '+ value +'\
                                    </div>';
                        $('.mainErrorMessage').html(html);
                        $("input").val('');
                        $("select").val('');
                        $("#submit").val('Register');
                        window.history.back();
                        // window.location.href = '<?php //echo url('signup');?>';
                    }
                });
            },
            error: function(data){
                var html = '<div class="alert alert-danger background-danger">\
                                <strong>Error!</strong> Error while adding data\
                            </div>';
                $('.mainErrorMessage').html(html);
                // location.reload(true);
            }
        });
    });
    $('input').on('keyup', function () { 
        $(this).removeClass('is-invalid').addClass('is-valid');
    });
    M.Datepicker.init(document.querySelectorAll('.datepicker'), {
        onClose: function() {
            $('.datepicker + label').addClass('active');
        }
    });
    $('.datepicker + label').addClass('active');
});
</script>