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
                        {{ $category_detail->category_name }} - Edit Category Details
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
    <form method="POST" enctype="multipart/form-data" id="update_restaurant_category" action="javascript:void(0)" >
        <div class="container-fluid">
            <!-- row -->
            <div class="row"> 
                <div class="col-sm-10"></div>
                <div class="col-sm-2">
                    <a href="{{ url()->previous() }}" id="back_button" class="btn btn-info btn-block">Back</a>
                </div>
            </div>
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Update Category Item</h4>                           
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <input type="submit" name="submit" value="Save" class="btn btn-primary btn-block" style="color:#fff!important;">
                        </li>
                    </ol>
                </div>
            </div>
            <div class="errorMessage"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="ms-panel">
                        <div class="ms-panel-body">
                        </div>
                    </div>
                </div>
                <div class=" col-md-10">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="section-title bold">Category Detail Update</h4>
                            <table class="table ms-profile-information">
                                <tbody>
                                    <tr>
                                        <th scope="row">Name</th>
                                        <td>
                                            <input type="hidden" name="category_id" value="{{ $category_detail->category_id }}" />
                                            <input type="text" class="form-control" name="name" id="name" value="{{ $category_detail->category_name }}" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!--**********************************
    Content body end
***********************************-->

@include('theme.footer')

<script type="text/javascript">
$(document).ready(function (e) {

    // CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Update Category
    $('#update_restaurant_category').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            type:'POST',
            url: "{{ url('update_restaurant_category')}}",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function(data){
                // console.log(data);
                $.each(data, function(key, value) 
                {                    
                    if(key == 'error') 
                    {
                        $.each(value, function(key1, value1) 
                        {
                            $("[name="+key1+"]").addClass('is-invalid');
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

                        window.location.href = '<?php echo url('category/'.$category_detail->restaurant_id);?>';
                    }
                });
            },
            error: function(data){
                // console.log(data);
                var html = '<div class="alert alert-danger background-danger">\
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                    <i class="icofont icofont-close-line-circled text-white"></i>\
                                </button>\
                                <strong>Error!</strong> Error while adding data\
                            </div>';

                $('.errorMessage').html(html);

                location.reload(true);
            }
        });
    });

});
</script>