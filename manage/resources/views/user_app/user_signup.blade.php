@include('user_app.theme.header')



@include('user_app.theme.sidebar', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details] )

<style type="text/css">
    #errorMessage {

        color: red;

        font-size: 12px;

    }

    #message {

        display: none;

        background: #f1f1f1;

        color: #000;

        position: relative;

        padding: 20px;

        margin-top: 10px;

    }

    #message p {

        padding: 5px 35px;

        font-size: 16px;

    }

    .invalid:before {

        position: relative;

        left: -35px;

        content: "✖";

    }

    .invalid {

        color: red;

    }

    .valid {

        color: green;

    }

    .valid:before {

        position: relative;

        left: -35px;

        content: "✔";

    }
</style>





<!-- register-->

<div class="register app-pages app-section">

    <div class="container">

        <div class="pages-title">

            <h3>Register</h3>

        </div>

        <input type="hidden" id="register_url" value="{{url('/user_home/'.$restaurant_details->restaurant_id )}}">

        <div class="mainErrorMessage">



        </div>

        <form method="POST" enctype="multipart/form-data" id="create_user" action="javascript:void(0)">

            <input type="hidden" name="restaurant_id" value="{{ $restaurant_details->restaurant_id }}">

            <div class="error_message_parent">

                <input type="text" name="first_name" id="first_name" placeholder="First Name" class="" maxlength="50">

                <span id="errorMessage"></span>

            </div>

            <div class="error_message_parent">

                <input type="text" name="last_name" id="last_name" placeholder="Last Name" maxlength="50">

                <span id="errorMessage"></span>

            </div>

            <div class="error_message_parent">

                <input type="email" name="email" id="email" placeholder="Email">

                <span id="errorMessage"></span>

            </div>

            <div class="error_message_parent">

                <input type="password" name="password" id="password" placeholder="Password">

                <span id="errorMessage"></span>

            </div>

            <div id="message">

                <h3>Password must contain the following:</h3>

                <p id="letter" class="invalid">A <b>lowercase</b> letter</p>

                <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>

                <p id="number" class="invalid">A <b>number</b></p>

                <p id="length" class="invalid">Minimum <b>6 characters</b></p>

                <p id="specialChar" class="invalid">A <b>Special characters</b></p>

            </div>

            <div class="error_message_parent">

                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">

                <span id="errorMessage"></span>

            </div>

            <div class="error_message_parent">

                <select name="gender" id="gender" placeholder="Gender">

                    <option value="">Select Gender</option>

                    <option value="0">Male</option>

                    <option value="1">Female</option>

                    <option value="2">Other</option>

                </select>

                <span id="errorMessage"></span>

            </div>

            <div class="input-field error_message_parent">

                <input placeholder="Date Of Birth" type="text" value="" name="date_of_birth" id="date_of_birth" class="datepicker">

                <span id="errorMessage"></span>

            </div>

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
    $(document).ready(function(e) {



        var myInput = document.getElementById("password");

        var letter = document.getElementById("letter");

        var capital = document.getElementById("capital");

        var number = document.getElementById("number");
        $('#number').hide();
        var length = document.getElementById("length");

        var specialChar = document.getElementById("specialChar");
        $('#specialChar').hide();
        var btn = document.getElementById("submit");



        // When the user clicks on the password field, show the message box

        myInput.onfocus = function() {



            document.getElementById("message").style.display = "block";

            btn.disabled = true;

        }



        // When the user clicks outside of the password field, hide the message box

        myInput.onblur = function() {

            document.getElementById("message").style.display = "none";

        }

        // When the user starts to type something inside the password field

        myInput.onkeyup = function() {







            // Validate length



            if (myInput.value.length >= 6) {

                length.classList.remove("invalid");

                length.classList.add("valid");

                btn.disabled = false;

            } else {

                length.classList.remove("valid");

                length.classList.add("invalid");

                btn.disabled = true;

            }





            var lowerCaseLetters = /[a-z]/g;

            var upperCaseLetters = /[A-Z]/g;







            // Special Character

            var specialChars = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;

            if (myInput.value.match(specialChars)) {



                specialChar.classList.remove("invalid");

                specialChar.classList.add("valid");

                btn.disabled = false;



            } else {

                specialChar.classList.remove("valid");

                specialChar.classList.add("invalid");

                btn.disabled = true;

            }





            //Validate lowercase letters

            var lowerCaseLetters = /[a-z]/g;

            if (myInput.value.match(lowerCaseLetters)) {

                letter.classList.remove("invalid");

                letter.classList.add("valid");

                btn.disabled = false;

            } else {

                letter.classList.remove("valid");

                letter.classList.add("invalid");

                btn.disabled = true;

            }

            // Validate capital letters

            var upperCaseLetters = /[A-Z]/g;

            if (myInput.value.match(upperCaseLetters)) {

                capital.classList.remove("invalid");

                capital.classList.add("valid");

                btn.disabled = false;

            } else {

                capital.classList.remove("valid");

                capital.classList.add("invalid");

                btn.disabled = true;

            }

            // Validate numbers

            var numbers = /[0-9]/g;

            if (myInput.value.match(numbers)) {

                number.classList.remove("invalid");

                number.classList.add("valid");

                btn.disabled = false;

            } else {

                number.classList.remove("valid");

                number.classList.add("invalid");

                btn.disabled = true;

            }

        }

























        var get_url = $("#register_url").val();



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

                type: 'POST',

                url: "{{ url('user_register')}}",

                data: formData,

                cache: false,

                contentType: false,

                processData: false,

                success: function(data) {
                    var redirect_url = get_url;
                    $.each(data, function(key, value) {

                        if (key == 'redirect_url') {

                            redirect_url = value;

                        }
                        if (key == 'error') {

                            var html = '';

                            $.each(value, function(key1, value1) {

                                $('#' + key1).addClass('is-invalid').removeClass('is-valid');

                                $('#' + key1).parent('.error_message_parent').find('#errorMessage').html(value1);

                                //html += '<div class="alert alert-danger background-danger">\<strong>Error!</strong> '+ value1 +'\</div>';



                            });

                            $('.mainErrorMessage').html(html);

                        } else if (key == 'errors') {

                            var html = '<div class="alert alert-danger background-danger">\<strong>Error!</strong> ' + value + '\</div>';

                            $('.mainErrorMessage').html(html);

                            // location.reload(true);

                        } else if (key == 'success') {



                            var html = '<div class="alert alert-success background-success">\<strong>Success!</strong> ' + value + '\</div>';

                            $('.mainErrorMessage').html(html);

                            $("input").val('');

                            $("select").val('');

                            $("#submit").val('Register');

                            window.location.href = redirect_url;
                        }

                    });

                },

                error: function(data) {

                    var html = '<div class="alert alert-danger background-danger">\<strong>Error!</strong> Error while adding data\</div>';

                    $('.mainErrorMessage').html(html);

                    // location.reload(true);

                }

            });



        });

        $('input').on('keyup', function() {

            $(this).removeClass('is-invalid').addClass('is-valid');

        });

        // M.Datepicker.init(document.querySelectorAll('.datepicker'), {

        //     onClose: function() {

        //         $('.datepicker + label').addClass('active');

        //     }

        // });

        $('.datepicker + label').addClass('active');













    });
</script>