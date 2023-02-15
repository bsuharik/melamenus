@include('theme.header')

<style>

    .container2 {
      position: relative;
      width: 100%;
      max-width: 400px;
    }

    .image {
      display: block;
      width: 100%;
      height: auto;
    }

    .overlay {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      height: 100%;
      width: 100%;
      opacity: 0;
      transition: .3s ease;
      background-color: rgba(103,66,168,0.8);
    }

    .container2:hover .overlay {
      opacity: 1;
    }

    .icon {
      color: white;
      font-size: 100px;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
      text-align: center;
    }

    .fa-user:hover {
      color: #eee;
    }
    .element {
      display: inline-flex;
      align-items: center;
    }
    i.fa-camera {
      margin: 10px;
      cursor: pointer;
      font-size: 30px;
    }
    i:hover {
      opacity: 0.6;
    }
    input {
      display: none;
    }
    .name{ font-size: 15px; }
    .dropdown{ padding:0px; }
</style>

<!--**********************************
    Header start
***********************************-->
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        {{ $restaurant_name }} - {{ $menu_detail->name }}
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
    <form method="POST" enctype="multipart/form-data" id="update_restaurant_menu" action="javascript:void(0)" >
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-10 p-md-0">
                    <div class="welcome-text">
                        <h4>Update Menu Item</h4>                           
                    </div>
                </div>
                <div class="col-sm-2 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <input type="submit" name="submit" value="Save" class="btn btn-primary btn-block" style="color:#fff!important;"> &nbsp;
                    <a href="{{ url('menu-detail') }}/{{ $menu_detail->menu_id }}" id="back_button" class="btn btn-info btn-block">Back</a>
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
                <div class=" col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="section-title bold">Menu Detail Update</h4>
                            <table class="table ms-profile-information">
                                <tbody>
                                    <tr>
                                        <th scope="row">Name</th>
                                        <td class="row">
                                            <input type="hidden" name="menu_id" value="{{ $menu_detail->menu_id }}" />
                                            <input type="hidden" name="restaurant_id" value="{{ $menu_detail->restaurant_id }}" />
                                            <input type="text" class="form-control" name="name" id="name" value="{{ $menu_detail->name }}" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Price</th>
                                        <td class="row">
                                            <input type="text" class="form-control" name="price" id="price" value="{{ $menu_detail->price }}" />
                                        </td> 
                                    </tr>
                                    <tr>
                                        <th scope="row">Parent Category</th>
                                        <td class="" style="margin-right: -33px;">
                                            <span class="row col-md-10" style="padding: 0px;float: left;">
                                                <select name="parent_category" id="parent_category" class="form-control">
                                                    <option value="">Select Parent Category</option>
                                                @if(count($parent_categories) > '0')
                                                    @foreach ($parent_categories as $category)
                                                        <option value="{{ $category->category_id }}" {{ ( $menu_detail->parent_category == $category->category_id) ? 'selected' : '' }} >{{ $category->category_name }}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </span>
                                            <span  class="col-md-2" style="padding: 0px;float: right;text-align: right;">
                                                <a data-toggle="modal" data-target="#parentCategoryModal" type="button" class="btn btn-primary" style="color:#fff;">+</a>
                                            </span>
                                        </td> 
                                    </tr>
                                    <tr>
                                        <th scope="row">Main Category</th>
                                        <td class="" style="margin-right: -33px;">
                                            <span class="row col-md-10" style="padding: 0px;float: left;">
                                                <select name="main_category" id="main_category" class="form-control">
                                                    <option value="">Select Main Category</option>
                                                @if(count($main_categories) > '0')
                                                    @foreach ($main_categories as $category)
                                                        <option value="{{ $category->category_id }}" {{ ( $menu_detail->main_category == $category->category_id) ? 'selected' : '' }} >{{ $category->category_name }}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </span>
                                            <span class="col-md-2" style="padding: 0px;float: right;text-align: right;">
                                                <a data-toggle="modal" data-target="#mainCategoryModal" type="button" class="btn btn-primary" style="color:#fff;">+</a>
                                            </span>
                                        </td> 
                                    </tr>
                                    <tr>
                                        <th scope="row">Sub Category</th>
                                        <td class="" style="margin-right: -33px;">
                                            <span class="row col-md-10" style="padding: 0px;float: left;">
                                                <select name="sub_category" id="sub_category" class="form-control">
                                                    <option value="">Select Sub Category</option>
                                                @if(count($sub_categories) > '0')
                                                    @foreach ($sub_categories as $category)
                                                        <option value="{{ $category->category_id }}" {{ ( $menu_detail->sub_category == $category->category_id) ? 'selected' : '' }} >{{ $category->category_name }}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </span>
                                            <span  class="col-md-2" style="padding: 0px;float: right;text-align: right;">
                                                <a data-toggle="modal" data-target="#subCategoryModal" type="button" class="btn btn-primary" style="color:#fff;">+</a>
                                            </span>
                                        </td> 
                                    </tr>
                                    <tr>
                                        <th scope="row">Availiblity</th>
                                        <td class="row">  
                                            <select name="availiblity" id="availiblity" class="form-control">
                                                <option value="">Select Availiblity</option>
                                                <option value="1" {{ ( $menu_detail->availiblity == '1') ? 'selected' : '' }} >Available</option>
                                                <option value="0" {{ ( $menu_detail->availiblity == '0') ? 'selected' : '' }}>Not Available</option>
                                            </select> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Ingredients</th>
                                        <td class="row">
                                            <input type="text" class="form-control" name="ingredients" id="ingredients" value="{{ $menu_detail->ingredients }}" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Allergies</th>
                                        <td class="row">
                                            <input type="text" class="form-control" name="allergies" id="allergies" value="{{ $menu_detail->allergies }}" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Calories</th>
                                        <td class="row">
                                            <input type="text" class="form-control" name="calories" id="calories" value="{{ $menu_detail->calories }}" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tag</th>
                                        <td class="row">
                                            <select name="tag_id" class="form-control" id="tag_id">
                                                <option value="">Select Tag</option>
                                            @if(count($tag_list) > '0')
                                                @foreach ($tag_list as $tag)
                                                    <option value="{{ $tag->tag_id }}" {{ ( $menu_detail->tag_id == $tag->tag_id) ? 'selected' : '' }} >{{ $tag->tag_name }}</option>
                                                @endforeach
                                            @endif
                                            </select>
                                        </td> 
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class=" col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="section-title bold">Description </h4>
                            <!-- <div class="col-md-12">
                                <br/>
                                <div class="element">                                    
                                    <img src="../{{ config('images.menu_url') .$menu_detail->restaurant_id.'/'. $menu_detail->menu_image }}" width="100%"/>
                                    <br>
                                    <i class="fa fa-camera"></i>
                                    <input type="file" class="form-control" name="menu_image" id="menu_image">
                                </div>
                            </div> -->
                            <div class=" col-md-12">
                                <br/>
                                <div class="container2">
                                    <img src="../{{ config('images.menu_url') .$menu_detail->restaurant_id.'/'. $menu_detail->menu_image }}" class="image" width="100%"/>
                                    <div class="overlay">
                                        <!--a href="#" class="icon" title="User Profile">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="#" class="icon" title="User Profile">
                                            <i class="fa fa-delete"></i>
                                        </a-->
                                        <div class="element icon">
                                            <i class="fa fa-camera"></i><span class="name">Change image</span>
                                            <input type="file" name="menu_image" id="menu_image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="description">
                                <br/>
                                <textarea type="text" name="description" id="description" class="form-control" style="height:150px;" />{{ $menu_detail->description }}</textarea>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="new"> </div>
        <div class=" col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="section-title bold">Chef's Questions   
                        <button id="clone_chef_questions_add" type="button" class="btn btn-primary mb-2" style="float:right;">&#x2B;</button> 
                    </h4>
                    <br>
                    <hr/>
                    <div class="form-row">
                    @if(count($chef_questions) > '0')
                        <div class="col-sm-12">
                            <div class="form-group  mb-0">
                                <div class="row">
                                    <input type="text" name="question0" class="form-control col-md-11 mt-0 my-3" value="{{ $chef_questions[0]->question}}" />
                                    <div class="col-md-1">
                                        <button id="remove_field" type="button" class="btn btn-primary" style="float:right;">-</button>
                                    </div>
                                    <br/>
                                    <input type="hidden" name="chef_question_id0" value="{{ $chef_questions[0]->chef_question_id }}" />
                                    <label class="radio-inline col-md-4"> 
                                        <input type="text" name="option_10" class="form-control col-md-12" value="{{ $chef_questions[0]->option_1 }}" />
                                    </label>
                                    <label class="radio-inline col-md-4"> 
                                        <input type="text" name="option_20" class="form-control col-md-12" value="{{ $chef_questions[0]->option_2 }}" />
                                    </label>
                                    <label class="radio-inline col-md-4"> 
                                        <input type="text" name="option_30" class="form-control col-md-12" value="{{ $chef_questions[0]->option_3 }}" />
                                    </label>
                                    <label class="radio-inline col-md-4"> 
                                        <input type="text" name="option_40" class="form-control col-md-12" value="{{ $chef_questions[0]->option_4 }}" />
                                    </label>
                                    <label class="radio-inline col-md-4"> 
                                        <input type="text" name="option_50" class="form-control col-md-12" value="{{ $chef_questions[0]->option_5 }}" />
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="cloned_chef_questions">
                            @php($i=0)
                            @foreach($chef_questions as $one_question)
                            @if($i != 0)
                                <div class="col-sm-12">
                                    <div class="form-group  mb-0">
                                        <div class="row">
                                            <input type="hidden" name="chef_question_id{{$i}}" value="{{ $one_question->chef_question_id }}" />
                                            <input type="text" name="question{{$i}}" class="form-control col-md-11 mt-0 my-3" value="{{ $one_question->question}}" />
                                            <div class="col-md-1">
                                                <button id="remove_field" type="button" class="btn btn-primary" style="float:right;">-</button>
                                            </div>
                                            <br/>
                                            <label class="radio-inline col-md-4"> 
                                                <input type="text" name="option_1{{$i}}" class="form-control col-md-12" value="{{ $one_question->option_1 }}" />
                                            </label>
                                            <label class="radio-inline col-md-4"> 
                                                <input type="text" name="option_2{{$i}}" class="form-control col-md-12" value="{{ $one_question->option_2 }}" />
                                            </label>
                                            <label class="radio-inline col-md-4"> 
                                                <input type="text" name="option_3{{$i}}" class="form-control col-md-12" value="{{ $one_question->option_3 }}" />
                                            </label>
                                            <label class="radio-inline col-md-4"> 
                                                <input type="text" name="option_4{{$i}}" class="form-control col-md-12" value="{{ $one_question->option_4 }}" />
                                            </label>
                                            <label class="radio-inline col-md-4"> 
                                                <input type="text" name="option_5{{$i}}" class="form-control col-md-12" value="{{ $one_question->option_5 }}" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @php($i++)
                            @endforeach
                        </div>
                    @else
                        <div class="col-sm-12">
                            <div class="form-group  mb-0">
                                <div class="row">
                                    <input type="text" name="question0" class="form-control col-md-12 mt-0 my-3" placeholder="Write own question here" /><br/>
                                    <label class="radio-inline col-md-4"> 
                                        <input type="text" name="option_10" class="form-control col-md-12" placeholder="Answer 1" />
                                    </label>
                                    <label class="radio-inline col-md-4"> 
                                        <input type="text" name="option_20" class="form-control col-md-12" placeholder="Answer 2" />
                                    </label>
                                    <label class="radio-inline col-md-4"> 
                                        <input type="text" name="option_30" class="form-control col-md-12" placeholder="Answer 3" />
                                    </label>
                                    <label class="radio-inline col-md-4"> 
                                        <input type="text" name="option_40" class="form-control col-md-12" placeholder="Answer 4" />
                                    </label>
                                    <label class="radio-inline col-md-4"> 
                                        <input type="text" name="option_50" class="form-control col-md-12" placeholder="Answer 5" />
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="cloned_chef_questions"></div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div> 

    <!-- parent category modal popup START -->
        <div class="modal fade" id="parentCategoryModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Parent Category</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="parentCategoryErrorMessage"></div>
                    <form method="POST" id="add_parent_category" action="javascript:void(0)" >
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label>Category Name</label>
                                    <input type="hidden" name="restaurant_id" value="{{ $menu_detail->restaurant_id }}" />
                                    <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter Category Name" />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <input type="submit" name="submit" value="Add Category" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- parent category modal popup END -->

    <!-- Main category modal popup START -->
        <div class="modal fade" id="mainCategoryModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Main Category</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="mainCategoryErrorMessage"></div>
                    <form method="POST" id="add_main_category" action="javascript:void(0)" >
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label>Category Name</label>
                                    <input type="hidden" name="restaurant_id" id="restaurant_id" value="{{ $menu_detail->restaurant_id }}" />
                                    <input type="hidden" name="parent_category_id" id="parent_category_id" value="{{ $menu_detail->parent_category }}" />
                                    <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Category Name" />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <input type="submit" name="submit" value="Add Category" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- Main category modal popup END -->

    <!-- Sub category modal popup START -->
        <div class="modal fade" id="subCategoryModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Sub Category</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="subCategoryErrorMessage"></div>
                    <form method="POST" id="add_sub_category" action="javascript:void(0)" >
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <label>Category Name</label>
                                    <input type="hidden" name="restaurant_id" id="restaurant_id" value="{{ $menu_detail->restaurant_id }}" />
                                    <input type="hidden" name="parent_category_id" id="parent_category_id_2" value="{{ $menu_detail->parent_category }}" />
                                    <input type="hidden" name="main_category_id" id="main_category_id" value="{{ $menu_detail->main_category }}" />
                                    <input type="text" class="form-control" name="category_name_2" id="category_name_2" placeholder="Category Name" />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <input type="submit" name="submit" value="Add Category" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- Sub category modal popup END -->

<!--**********************************
    Content body end
***********************************-->

@include('theme.footer')

<script>
$("i").click(function () {
  $("input[type='file']").trigger('click');
});

$('input[type="file"]').on('change', function() {
  var val = $(this).val();
  $(this).siblings('span').text(val);
})
</script>

<script type="text/javascript">
$(document).ready(function (e) {

    // multiple emails
    var ex = "<?php echo count($chef_questions); ?>";
    
    if(ex == 0)
    {
        var max_fields = 4; //maximum input boxes allowed
        var x = 0; //initlal text box count
    }
    else
    {   
        var x = ex; //initlal text box count
        var max_fields = 5; //maximum input boxes allowed
    }

    var wrapper    = $("#cloned_chef_questions"); //Fields wrapper
    var add_button = $("#clone_chef_questions_add"); //Add button ID
    
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields)
        { //max input box allowed
            $(wrapper).append('<div class="col-sm-12">\
                                <div class="form-group  mb-0">\
                                    <div class="row">\
                                        <input type="text" name="question'+x+'" class="form-control col-md-11 mt-0 my-3" placeholder="Write own question here" />\
                                        <div class="col-md-1">\
                                            <button id="remove_field" type="button" class="btn btn-primary" style="float:right;">-</button>\
                                        </div>\
                                        <br/>\
                                        <label class="radio-inline col-md-4"> \
                                            <input type="text" name="option_1'+x+'" class="form-control col-md-12" placeholder="Answer 1" />\
                                        </label>\
                                        <label class="radio-inline col-md-4"> \
                                            <input type="text" name="option_2'+x+'" class="form-control col-md-12" placeholder="Answer 2" />\
                                        </label>\
                                        <label class="radio-inline col-md-4"> \
                                            <input type="text" name="option_3'+x+'" class="form-control col-md-12" placeholder="Answer 3" />\
                                        </label>\
                                        <label class="radio-inline col-md-4"> \
                                            <input type="text" name="option_4'+x+'" class="form-control col-md-12" placeholder="Answer 4" />\
                                        </label>\
                                        <label class="radio-inline col-md-4"> \
                                            <input type="text" name="option_5'+x+'" class="form-control col-md-12" placeholder="Answer 5" />\
                                        </label>\
                                    </div>\
                                </div>\
                            </div>'); //add input box
            x++; //text box increment
        }
    });
    
    $(wrapper).on("click","#remove_field", function(e){ //user click on remove text
        e.preventDefault(); 
        $(this).parent('div').parent('div').parent('div').remove(); 
        x--;
    });

    // CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Update Menu
    $('#update_restaurant_menu').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            type:'POST',
            url: "{{ url('update_restaurant_menu')}}",
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

                        window.location.href = '<?php echo url('menu-detail/'.$menu_detail->menu_id);?>';
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

    // Add Parent Category
    $('#add_parent_category').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            type:'POST',
            url: "{{ url('add_parent_category')}}",
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

                        $('.parentCategoryErrorMessage').html(html);
                    }
                    else if(key == 'success')
                    {
                        var html = '<div class="alert alert-success background-success">\
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <i class="icofont icofont-close-line-circled text-white"></i>\
                                        </button>\
                                        <strong>Success!</strong> '+ value +'\
                                    </div>';

                        $('.parentCategoryErrorMessage').html(html);

                        location.reload(true);
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

                $('.parentCategoryErrorMessage').html(html);
            }
        });
    });

    //Get Main Category for selected Parent Category
    $( "#parent_category" ).change(function() {
        
        var parent_caregory = $('#parent_category :selected').val();
        $('#parent_category_id').val(parent_caregory);
        $('#parent_category_id_2').val(parent_caregory);

        var ids = $(this).val();
        var restaurant_id = "{{ $menu_detail->restaurant_id }}";

        $.ajax({
                type: "POST",
                url: "{{ url('select_main_category') }}", 
                data:  {id:parent_caregory, restaurant_id:restaurant_id},
                dataType: "json",
                success: function(data)
                {
                    $.each(data, function(key, value) 
                    {
                        if(key == 'success')
                        {
                            $main_category_list = value;

                            $('#main_category').html("<option value=''> Select Main Category </option>");

                            $.each($main_category_list, function(key1, value1) 
                            {
                                $('#main_category').append("<option value='"+value1['category_id']+"'> "+value1['category_name']+" </option>");
                            });
                        }
                        else
                        {
                            $('#main_category').html("<option value=''> Select Main Category </option>");
                        }
                    });
                }
            });
    });

    // Add Main Category
    $('#add_main_category').submit(function(e) {

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: "{{ url('add_main_category')}}",
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

                        $('.mainCategoryErrorMessage').html(html);
                    }
                    else if(key == 'success')
                    {
                        var html = '<div class="alert alert-success background-success">\
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <i class="icofont icofont-close-line-circled text-white"></i>\
                                        </button>\
                                        <strong>Success!</strong> '+ value +'\
                                    </div>';

                        $('.mainCategoryErrorMessage').html(html);

                        location.reload(true);
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

                $('.mainCategoryErrorMessage').html(html);
            }
        });
    });

    //Get Sub Category for selected Main Category
    $( "#main_category" ).change(function() {

        var parent_caregory = $('#parent_category_id_2').val();

        var main_caregory = $('#main_category :selected').val();
        $('#main_category_id').val(main_caregory);

        var ids = $(this).val();
        var restaurant_id = "{{ $menu_detail->restaurant_id }}";

        $.ajax({
                type: "POST",
                url: "{{ url('select_sub_category') }}", 
                data:  {id:main_caregory, restaurant_id:restaurant_id, parent_category:parent_caregory},
                dataType: "json",
                success: function(data)
                {
                    $.each(data, function(key, value) 
                    {
                        if(key == 'success')
                        {
                            $sub_category_list = value;
                            $('#sub_category').html("<option value=''> Select Sub Category </option>");

                            $.each($sub_category_list, function(key1, value1) 
                            {
                                $('#sub_category').append("<option value='"+value1['category_id']+"'> "+value1['category_name']+" </option>");
                            });
                        }
                        else
                        {
                            $('#sub_category').html("<option value=''> Select Sub Category </option>");
                        }
                    });
                }
            });
    });

    // Add Sub Category
    $('#add_sub_category').submit(function(e) {

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: "{{ url('add_sub_category')}}",
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

                        $('.subCategoryErrorMessage').html(html);
                    }
                    else if(key == 'success')
                    {
                        var html = '<div class="alert alert-success background-success">\
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                            <i class="icofont icofont-close-line-circled text-white"></i>\
                                        </button>\
                                        <strong>Success!</strong> '+ value +'\
                                    </div>';

                        $('.subCategoryErrorMessage').html(html);

                        location.reload(true);
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

                $('.subCategoryErrorMessage').html(html);
            }
        });
    });

    $('input').on('keyup', function () { 
        $(this).removeClass('is-invalid').addClass('is-valid');
    });

    $('textarea').on('keyup', function () { 
        $(this).removeClass('is-invalid').addClass('is-valid');
    });

    $('select').on('change', function () { 
        $(this).removeClass('is-invalid').addClass('is-valid');
    });
});
</script>