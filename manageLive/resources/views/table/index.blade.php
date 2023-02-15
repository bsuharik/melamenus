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
                        {{ $restaurant_name }} - Tables
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
        <!-- row -->
        <div class="row"> 
            <!-- <div class="col-sm-11"></div> -->
            <div class="col-sm-12 text-right">
                <a href="{{ url('restaurant-detail') }}/{{$restaurant_id}}" id="back_button" class="btn btn-info btn-block back-btn-new">Back</a>
            </div>
        </div>
        <br>
        <div id="print_qr_code_div" style="display: none;"></div>
        <div class="form-head d-flex mb-3 mb-lg-5 align-items-start">
            <div class="mr-auto d-none col-md-12 d-lg-block">
                <div class="welcome-text">
                    <h4>Manage Table</h4>
                    <div class="row">
                        <div class="col-md-9">
                            <a data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-primary btn-block col-sm-3 mt-3" style="color:#fff!important;">Add Table</a>
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
             
        <!-- Add Table Modal -->
        <div class="modal fade" id="exampleModalCenter">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Table</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="mainErrorMessage"></div>
                    <form method="POST" id="add_table" action="javascript:void(0)">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-sm-7 error_message_parent">
                                    <label>Table Number</label>
                                    <input type="hidden" name="restaurant_id" value="{{ $restaurant_id }}" />
                                    <input type="number" class="form-control" name="table_number" id="table_number" placeholder="Table Number" min="1" />
                                    <span id="errorMessage"></span>
                                </div>
                                <div class="col mt-2 mt-sm-0 error_message_parent">
                                    <label>No of Chairs</label>
                                    <input type="number" class="form-control" name="chairs" id="chairs" placeholder="No of Chairs" min="1" />
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <input type="submit" name="submit" value="Add Table" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Import Table Modal -->
        <div class="modal fade" id="importTableModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Table</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="importErrorMessage"></div>
                    <form method="POST" id="import_table" action="javascript:void(0)">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-sm-12 error_message_parent">
                                    <label>CSV File</label>
                                    <input type="hidden" name="restaurant_id" value="{{ $restaurant_id }}" />
                                    <input type="file" class="form-control" name="csv_file" id="csv_file" />
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <input type="submit" name="submit" value="Import" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update Table Modal -->
        <div class="modal fade" id="updateTableModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Table Details</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="mainUpdateErrorMessage"></div>
                    <form method="POST" id="update_table" action="javascript:void(0)">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-sm-7 error_message_parent">
                                    <label>Table Number</label>
                                    <input type="hidden" name="table_id" id="update_table_id" />
                                    <input type="hidden" name="restaurant_id" id="update_restaurant_id" value="{{ $restaurant_id }}" />
                                    <input type="number" class="form-control" name="table_number" id="update_table_number" min="1" />
                                    <span id="errorMessage"></span>
                                </div>
                                <div class="col mt-2 mt-sm-0 error_message_parent">
                                    <label>No of Chairs</label>
                                    <input type="number" class="form-control" name="chairs" id="update_chairs" min="1" />
                                    <span id="errorMessage"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <input type="submit" name="submit" value="Update Table" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- QR modal popup -->              
        <div class="modal fade" id="qrModalCenter">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">QR Codes</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="mainQRCodesErrorMessage"></div>
                    <div class="modal-body">
                        <form>
                            <div class="form" style="text-align: center;">
                                <div class="qr_codes_list_html"></div>                                           
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
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
                                <table id="example5" class="display mb-4 dataTablesCard results">
                                    <thead>
                                        <tr>
                                            <th class="sorting_1 pl-0 pr-0 text-center no-data-img">
                                                <div class="custom-control custom-checkbox ml-2">
                                                    <input type="checkbox" class="custom-control-input" id="checkAll" required="">
                                                    <label class="custom-control-label" for="checkAll"></label>
                                                </div>
                                            </th>
                                            <th><strong class="font-w600 wspace-no">Table No.</strong></th>
                                            <th><strong class="font-w600 wspace-no">Chairs</strong></th>
                                            <th>QR Codes</th>                                               
                                            <th><strong class="font-w600 wspace-no">Action</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                @if(count($table_list) > '0')
                                    @foreach ($table_list as $table)
                                        <tr>
                                            <td class="sorting_1 p-0 text-center">
                                                <div class="custom-control custom-checkbox ml-2">
                                                    <input type="checkbox" class="custom-control-input" id="customCheckBox5" required="">
                                                    <label class="custom-control-label" for="customCheckBox5"></label>
                                                </div>
                                            </td>
                                            <td> {{ $table->table_number }} </td>
                                            <td> {{ $table->chairs }} </td>
                                            <td><a href="#" class="view_table_qr_codes" data-id="{{ $table->table_id}}" data-toggle="modal" data-target="#qrModalCenter">View</a>&nbsp;</td>
                                            <td>
                                                <a href="#" data-toggle="modal" data-target="#updateTableModal" data-id="{{ $table->table_id}}" data-number="{{ $table->table_number}}" data-chairs="{{ $table->chairs}}" class="edit-btn updateTable" style="float: none;"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                                                <a data-toggle="modal" data-target="#deleteTableModal" data-table="{{  $table->table_id }}" class="delete-btn deleteTable" style="float: none;"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            </td>
                                            </td>
                                        </tr> 
                                    @endforeach
                                @else
                                        <tr>
                                            <td></td>
                                            <td>No Data Found</td>
                                        </tr>
                                @endif                          
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Table Modal -->
        <div class="modal fade" id="deleteTableModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-row">
                            <span>Are you sure you want to delete this table details?</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                        <a href="" id="confirmDeleteTable" class="btn btn-primary" style="color:#fff!important; margin: 0;">Confirm Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->

@include('theme.footer')

<script type="text/javascript">
$(document).ready(function (e) {

    $restaurant_id = "{{ $restaurant_id }}";

    // $('.mainErrorMessage').html(' ');
    // $('.mainUpdateErrorMessage').html(' ');
    // $('.mainQRCodesErrorMessage').html(' ');

    // CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Add table
    $('#add_table').submit(function(e) {

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: "{{ url('add_table')}}",
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
                            $("[name="+key1+"]").parent('.error_message_parent').find('#errorMessage').html(value1);
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

                        $('.mainErrorMessage').html(html);
                    }
                    else if(key == 'success')
                    {
                        var html = '<div class="alert alert-success background-success">\
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <i class="icofont icofont-close-line-circled text-white"></i>\
                                        </button>\
                                        <strong>Success!</strong> '+ value +'\
                                    </div>';

                        $('.mainErrorMessage').html(html);

                        location.reload(true);
                    }
                    else if (key == 'table_number')
                    {
                        $('#table_number').addClass('is-invalid');
                        $("[name=table_number]").parent('.error_message_parent').find('#errorMessage').html(value);
                    }
                });
            },
            error: function(data){

                var html = '<div class="alert alert-danger background-danger">\
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                    <i class="icofont icofont-close-line-circled text-white"></i>\
                                </button>\
                                <strong>Error!</strong> Error while adding data\
                            </div>';

                $('.mainErrorMessage').html(html);
            }
        });
    });

    // Set data in update modal popup 
    $(".updateTable").click(function (e) {

        $table_id = $(this).attr("data-id");
        $table_number = $(this).attr("data-number");
        $chairs = $(this).attr("data-chairs");

        $('#update_table_id').val($table_id);
        $('#update_table_number').val($table_number);
        $('#update_chairs').val($chairs);
    });

    // Update table
    $('#update_table').submit(function(e) {

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: "{{ url('update_table')}}",
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
                            $('#update_'+key1).addClass('is-invalid');
                            $("[name=update_"+key1+"]").parent('.error_message_parent').find('#errorMessage').html(value);
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

                        $('.mainUpdateErrorMessage').html(html);
                    }
                    else if(key == 'success')
                    {
                        var html = '<div class="alert alert-success background-success">\
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <i class="icofont icofont-close-line-circled text-white"></i>\
                                        </button>\
                                        <strong>Success!</strong> '+ value +'\
                                    </div>';

                        $('.mainUpdateErrorMessage').html(html);

                        location.reload(true);
                    }
                    else if (key == 'table_number')
                    {
                        $('#update_table_number').addClass('is-invalid');
                        $("[name=table_number]").parent('.error_message_parent').find('#errorMessage').html(value);
                    }
                });
            },
            error: function(data){

                var html = '<div class="alert alert-danger background-danger">\
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                    <i class="icofont icofont-close-line-circled text-white"></i>\
                                </button>\
                                <strong>Error!</strong> Error while adding data\
                            </div>';

                $('.mainUpdateErrorMessage').html(html);
            }
        });
    });

    // Set data in update modal popup 
    $(".view_table_qr_codes").click(function (e) {

        var table_id = $(this).attr("data-id");

        $.ajax({
            type: "POST",
            url: "{{ url('get_table_qr_codes') }}", 
            data:  {table_id:table_id},
            dataType: "json",
            success: function(data){
                
                $.each(data, function(key, value) 
                {                    
                    if(key == 'error' && key == 'errors') 
                    {
                        var html = '<div class="alert alert-danger background-danger">\
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <i class="icofont icofont-close-line-circled text-white"></i>\
                                        </button>\
                                        <strong>Error!</strong> '+ value +'\
                                    </div>';

                        $('.mainQRCodesErrorMessage').html(html);
                    }
                    else if(key == 'success')
                    {
                        var html = '<div class="alert alert-success background-success">\
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <i class="icofont icofont-close-line-circled text-white"></i>\
                                        </button>\
                                        <strong>Success!</strong> '+ value +'\
                                    </div>';

                        // $('.mainQRCodesErrorMessage').html(html);

                        // location.reload(true);
                    }
                    else if (key == 'table_data')
                    {   
                        if (value.length === 0)
                        {    
                            var qr_codes_list_html = "No QR codes found";
                        }
                        else
                        {
                            var qr_codes_list_html = "";

                            $chairs       = value['chairs'];
                            $table_number = value['table_number'];
                            $qr_code_url  = "{{config('images.qr_code_url')}}";
                            $qr_codes     = value['qr_code'];

                            if ($qr_codes == "")
                            {
                                var qr_codes_list_html = "No QR codes found";
                            }
                            else
                            {
                                $qr_codes_array = $qr_codes.split(' ');
                                
                                for(var i = 1; i <= $chairs; i++)
                                {
                                    qr_codes_list_html += ' <div class="row"> <div class="col-sm-3 pt-3">\
                                                                <label style="font-size: 24px;font-weight: 500;">'+$table_number+':'+i+'</label>\
                                                            </div>\
                                                            <div class="col-sm-6 mx-auto">\
                                                                <img src="../'+$qr_code_url+$restaurant_id+'/'+$qr_codes_array[i-1]+'" height="100" width="100">\
                                                            </div>\
                                                            <div class="col-sm-3 pt-3">\
                                                                <a href="../'+$qr_code_url+$restaurant_id+'/'+$qr_codes_array[i-1]+'" download>\
                                                                    <i class="flaticon-381-download" style="color: #6742a8;font-size: 19px;font-weight: 500;"></i>\
                                                                </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\
                                                                <a href="#" data-id="../'+$qr_code_url+$restaurant_id+'/'+$qr_codes_array[i-1]+'" data-table="'+$table_number+'" data-chairs="'+i+'" class="print_qr_code">\
                                                                    <i class="flaticon-381-print"  style="color: #6742a8;font-size: 19px;font-weight: 500;"></i>\
                                                                </a>\
                                                            </div></div>';
                                }
                            }
                        }
                        
                        $('.qr_codes_list_html').html(qr_codes_list_html);
                    }
                });
            },
            error: function(data){

                var html = '<div class="alert alert-danger background-danger">\
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                    <i class="icofont icofont-close-line-circled text-white"></i>\
                                </button>\
                                <strong>Error!</strong> Error while adding data\
                            </div>';

                $('.mainQRCodesErrorMessage').html(html);
            }
        });
    });
    
    $app_name = "{{ config('app.name') }}";
    // Print qr code image 
    $('body').delegate('.print_qr_code','click', function(){

        $qr_code_image = $(this).attr("data-id");
        $table_number = $(this).attr("data-table");
        $chair_number = $(this).attr("data-chairs");

        var html = '<div style="text-align:center;"><img src="'+$qr_code_image+'" alt="qr_code"></br></br>\
                    <div>Table Number : '+$table_number+'&nbsp;&nbsp;&nbsp;\
                    Chair Number : '+$chair_number+'</div><br>\
                    <div>Powered By <b>'+$app_name+'</b> </div>\
                    </div>';

        $('#print_qr_code_div').html(html);

        var divContents = $("#print_qr_code_div").html();
        var a = window.open();
        a.document.write(divContents);
        a.document.close();
        a.print();

    });

    // Set data in delete modal popup 
    $(".deleteTable").click(function (e) {

        $table_id = $(this).attr("data-table");

        $href = "{{ url('table-delete') }}/"+$table_id;
        $('#confirmDeleteTable').attr("href",$href);
    });
});
</script>