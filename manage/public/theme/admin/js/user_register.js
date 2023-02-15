$(document).ready(function (){

$('#errorMessage').html(" ");
    $('.mainErrorMessage').html(" ");

    // CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

var register_url=$("#register_url").val();

// Create New User
$("#create_user").submit(function(e) {
        e.preventDefault(e);
        var formData = new FormData(this);
        var html='';
        $.ajax({
            type:'POST',
            url: register_url,
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $("#loading-image").show();
            },
            success: function(data){
                
                $.each(data, function(key, value){                   
                    if(key == 'error'){
                        $("#loading-image").hide();
                        $.each(value, function(key1, value1) 
                        {
                            $('#'+key1).addClass('is-invalid');
                            $('#'+key1).parent('.form-group').find('#errorMessage').html(value1);
                        });
                    }
                    else if(key == 'errors') 
                    {
                        $("#loading-image").hide();
                        html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> '+ value +'\ </div>';
                                   

                        $('.mainErrorMessage').html(html);

                        // location.reload(true);
                    }
                    else if(key == 'success'){
                        $("#loading-image").hide();
                        html = '<div class="alert alert-success background-success">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Success!</strong> '+ value +'\</div>';

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
                        
                        // window.location.href = '<?php //echo url('signup');?>';
                    }
                });
            },
            error: function(data){
                // $("#loading-image").hide();
                // html = '<div class="alert alert-danger background-danger">\
                //                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                //                     <i class="icofont icofont-close-line-circled text-white"></i>\
                //                 </button>\
                //                 <strong>Error!</strong> Error while adding data\
                //             </div>';

                // $('.mainErrorMessage').html(html);

                // location.reload(true);
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
