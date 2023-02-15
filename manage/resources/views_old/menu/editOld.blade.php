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
    /*input {
      display: none;
    }*/
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
    <input type="hidden" value="{!! asset('theme/admin/image/') !!}" id="image_url">
    <form method="POST" enctype="multipart/form-data" id="update_restaurant_menu" action="javascript:void(0)" files="true">
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
                            <h4 class="section-title bold">Update Menu Details</h4>
                            <table class="table ms-profile-information">
                                <tbody>
                                    <tr>
                                        <input type="hidden" name="menu_id" value="{{ $menu_detail->menu_id }}" />
                                        <input type="hidden" name="restaurant_id" value="{{ $menu_detail->restaurant_id }}" />
                                        <th scope="row">Name</th>
                                        <td class="row error_message_parent">
                                            <input type="text" class="form-control" name="name" id="name" value="{{ $menu_detail->name }}" />
                                            <div id="errorMessage"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Price</th>
                                        <td class="row error_message_parent">
                                            <input type="text" class="form-control" name="price" id="price" value="{{ $menu_detail->price }}" />
                                            <div id="errorMessage"></div>
                                        </td> 
                                    </tr>
                                    <tr>
                                        <th scope="row">Parent Category</th>
                                        <td class="" style="margin-right: -33px;">
                                            <span class="row col-md-10 error_message_parent" style="padding: 0px;float: left;">
                                                <select name="parent_category" id="parent_category" class="form-control">
                                                    <option value="">Select Parent Category</option>
                                                @if(count($parent_categories) > '0')
                                                    @foreach ($parent_categories as $category)
                                                        <option value="{{ $category->category_id }}" {{ ( $menu_detail->parent_category == $category->category_id) ? 'selected' : '' }} >{{ $category->category_name }}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                                <div id="errorMessage"></div>
                                            </span>
                                            <span  class="col-md-2" style="padding: 0px;float: right;text-align: right;">
                                                <a data-toggle="modal" data-target="#parentCategoryModal" type="button" class="btn btn-primary" style="color:#fff;">+</a>
                                            </span>
                                        </td> 
                                    </tr>
                                    <tr>
                                        <th scope="row">Main Category</th>
                                        <td class="" style="margin-right: -33px;">
                                            <span class="row col-md-10 error_message_parent" style="padding: 0px;float: left;">
                                                <select name="main_category" id="main_category" class="form-control">
                                                    <option value="">Select Main Category</option>
                                                @if(count($main_categories) > '0')
                                                    @foreach ($main_categories as $category)
                                                        <option value="{{ $category->category_id }}" {{ ( $menu_detail->main_category == $category->category_id) ? 'selected' : '' }} >{{ $category->category_name }}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                                <div id="errorMessage"></div>
                                            </span>
                                            <span class="col-md-2" style="padding: 0px;float: right;text-align: right;">
                                                <a data-toggle="modal" data-target="#mainCategoryModal" type="button" class="btn btn-primary" style="color:#fff;">+</a>
                                            </span>
                                        </td> 
                                    </tr>
                                    <tr>
                                        <th scope="row">Sub Category</th>
                                        <td class="" style="margin-right: -33px;">
                                            <span class="row col-md-10 error_message_parent" style="padding: 0px;float: left;">
                                                <select name="sub_category" id="sub_category" class="form-control">
                                                    <option value="">Select Sub Category</option>
                                                @if(count($sub_categories) > '0')
                                                    @foreach ($sub_categories as $category)
                                                        <option value="{{ $category->category_id }}" {{ ( $menu_detail->sub_category == $category->category_id) ? 'selected' : '' }} >{{ $category->category_name }}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                                <div id="errorMessage"></div>
                                            </span>
                                            <span  class="col-md-2" style="padding: 0px;float: right;text-align: right;">
                                                <a data-toggle="modal" data-target="#subCategoryModal" type="button" class="btn btn-primary" style="color:#fff;">+</a>
                                            </span>
                                        </td> 
                                    </tr>
                                    <tr>
                                        <th scope="row">Availiblity</th>
                                        <td class="row error_message_parent">  
                                            <select name="availiblity" id="availiblity" class="form-control">
                                                <option value="">Select Availiblity</option>
                                                <option value="1" {{ ( $menu_detail->availiblity == '1') ? 'selected' : '' }} >Available</option>
                                                <option value="0" {{ ( $menu_detail->availiblity == '0') ? 'selected' : '' }}>Not Available</option>
                                                <option value="2" {{ ( $menu_detail->availiblity == '2') ? 'selected' : '' }}>Hide</option>
                                            </select> 
                                            <div id="errorMessage"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Ingredients</th>
                                        <td class="row error_message_parent">
                                            <input type="text" class="form-control" name="ingredients" id="ingredients" value="{{ $menu_detail->ingredients }}" maxlength="50"/>
                                            <div id="errorMessage"></div>
                                        </td>
                                    </tr>
                                    <tr> 
                                        <th scope="row">Allergies</th>
                                        <td class="row error_message_parent">
                                            <!-- <input type="text" class="form-control" name="allergies" id="allergies" value="{{ $menu_detail->allergies }}" /> -->
                                             <select name="allergies" id="allergies" class="form-control">
                                                <option value="">Select</option>
                                                @if(count($allergies_list) > '0')
                                                @foreach ($allergies_list as $allergies)
                                                    <option value="{{ $allergies->allergy_id }}" {{ ( $menu_detail->allergies == $allergies->allergy_id) ? 'selected' : '' }}>{{ $allergies->allergy_name }}</option>
                                                @endforeach
                                            @endif
                                            </select> 
                                            <div id="errorMessage"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Calories</th>
                                        <td class="row error_message_parent">
                                            <input type="text" class="form-control" name="calories" id="calories" value="{{ $menu_detail->calories }}" />
                                            <div id="errorMessage"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Link</th>
                                        <td class="row error_message_parent">
                                            <input type="text" class="form-control" name="link" id="link" value="{{ $menu_detail->link }}" placeholder="http://www.google.com/" />
                                            <div id="errorMessage"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tag</th>
                                        <td class="row error_message_parent">
                                            <select name="tag_id[]" class="form-control" id="tag_id" multiple data-placeholder="Select Tag">
                                            <?php $tag_ids = explode(",",$menu_detail->tag_id); ?>
                                            @if(count($tag_list) > '0')
                                                @foreach ($tag_list as $tag)
                                                    <option value="{{ $tag->tag_id }}" {{ in_array($tag->tag_id, $tag_ids) ? 'selected' : '' }} >{{ $tag->tag_name }}</option>
                                                @endforeach
                                            @endif
                                            </select>
                                            <div id="errorMessage"></div>
                                        </td> 
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>  
                <div class=" col-md-6"> 
                    <div class="card">
                        <div class="imageErrorMessage"></div> 

                        <div class="card-body">
                            
                            
                           <label><b>Menu  Image </b></label>
                            <button type="button" class="btn btn-primary error_message_parent">
                                <label for="files">Select menu Image</label>
                            </button>
                            <span style="display: none; color: red" id="five_image_uplode">You are only allowed to upload 5 menu image</span>
                            <span style="display: none; color: red" id="invalid_formate">Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF</span>
                            <span style="display: none; color: red" id="menu_image_error">menu image is required</span>
                            <input type="file" id="files" name="edit_files[]" multiple style="visibility:hidden;"/>
                            
                            <?php  
                                if(!empty($menu_detail->menu_image)){
                                    $menu_image = explode(',',$menu_detail->menu_image);
                                }
                            ?>
                            @if(isset($menu_image)&& !empty($menu_image))
                            <?php $i=1;?>
                            @foreach($menu_image as $menu_image_value)
                            @if($i==1)

                                <span class="pip menu_image first_image">
                                    <label for="files">Display image</label>
                                    <img class="imageThumb" src="../{{ config('images.menu_url') .$menu_detail->restaurant_id.'/'.$menu_image_value}}"><br>

                                   <span class="remove"><img class="close-icon" width="40px" src="{!! asset('theme/admin/image/close-cross.png') !!}"></span>
                                   <input type="hidden" name="save_menu_image[]" value="{{$menu_image_value}}">
                                </span>
                            @else
                                <span class="pip menu_image">
                                    <img class="imageThumb" src="../{{ config('images.menu_url') .$menu_detail->restaurant_id.'/'.$menu_image_value}}"><br>
                                   <span class="remove"><img class="close-icon" width="40px" src="{!! asset('theme/admin/image/close-cross.png') !!}"></span>
                                   <input type="hidden" name="save_menu_image[]" value="{{$menu_image_value}}">
                                </span>
                            @endif
                           <?php $i++;?>
                            @endforeach
                            @endif

                            

                            <label><b>Description </b></label>
                            <span class="description error_message_parent">
                                <br/>
                                <textarea type="text" name="description" id="description" class="form-control" style="height:150px;" />{{ $menu_detail->description }}</textarea>
                                <div id="errorMessage"></div>
                            </span>
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
                                <div class="row error_message_parent">
                                    <input type="text" name="question0" id="question0" class="form-control col-md-11 mt-0 my-3" value="{{ $chef_questions[0]->question}}" />
                                    <div class="col-md-1">
                                        <button id="remove_field" type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteQuestionModal" data-class="remove_field0" class="delete-btn" style="float:right;">-</button>
                                    </div>
                                    <div id="errorMessage" class="row col-md-12"></div>
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
                                        <div class="row error_message_parent">
                                            <input type="hidden" name="chef_question_id{{$i}}" value="{{ $one_question->chef_question_id }}" />
                                            <input type="text" name="question{{$i}}" id="question{{$i}}" class="form-control col-md-11 mt-0 my-3" value="{{ $one_question->question}}" />
                                            <div class="col-md-1">
                                                <button id="remove_field" type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteQuestionModal" data-class="remove_field{{$i}}" style="float:right;">-</button>
                                            </div>
                                            <div id="errorMessage" class="row col-md-12"></div>
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
                        <!-- <div class="col-sm-12">
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
                        </div> -->
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

    <!-- Delete question Modal START-->
        <div class="modal fade" id="deleteQuestionModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-row">
                            <span>Are you sure you want to delete this question?</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                        <a href="" id="confirmDeleteQuestion" class="btn btn-primary" style="color:#fff!important; margin: 0;">Confirm Delete</a>
                        <input type="hidden" name="delete_element" id="delete_element">
                    </div>
                </div>
            </div>
        </div>
    <!-- Delete question Modal END-->
    <!-- Delete Image Modal START-->
            <div class="modal fade" id="deleteImageModal">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="form-row">
                                <span>Are you sure you want to delete this Image?</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <a href="" id="confirmDeleteImage" class="btn btn-primary" style="color:#fff!important; margin: 0;">Confirm Delete</a>
                            <input type="hidden" name="delete_element_image" id="delete_element_image" data-img_type="">
                        </div>
                    </div>
                </div>
            </div>
        <!-- Delete Image Modal END-->

<!--**********************************
    Content body end
***********************************-->

@include('theme.footer')



<script type="text/javascript">
    $(document).on('change','input[type="file"]',function(){
        $('.imageErrorMessage').html('');
        var files=this.files[0];
        if ($.inArray(files['name'].split('.').pop().toLowerCase(), ['gif','png','jpg','jpeg']) == -1){
            $(this).val('');
            var html = '<div class="alert alert-danger background-danger">\
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">close\
            <i class="icofont icofont-close-line-circled text-white"></i>\
            </button>\
            <strong>Error! </strong>Invalid Formate Image file\
            </div>';

            $('.imageErrorMessage').html(html);
        }

});
$(document).ready(function (e) {

    $('#errorMessage').html(" ");

    // multiple emails
    var ex = "<?php echo count($chef_questions); ?>";
    
    if(ex == 0)
    {
        var max_fields = 5; //maximum input boxes allowed
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
                                    <div class="row error_message_parent">\
                                        <input type="text" name="question'+x+'" id="question'+x+'" class="form-control col-md-11 mt-0 my-3" placeholder="Write own question here" />\
                                        <div class="col-md-1">\
                                            <button id="remove_field" type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteQuestionModal" data-class="remove_field'+x+'" style="float:right;">-</button>\
                                        </div>\
                                        <div id="errorMessage" class="row col-md-12"></div>\
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
    
    // $(wrapper).on("click","#remove_field", function(e){ //user click on remove text
    //     e.preventDefault(); 
    //     $(this).parent('div').parent('div').parent('div').remove(); 
    //     x--;
    // });

    // $("#remove_field").click( function(e){ //user click on remove text
    $('body').delegate('#remove_field','click', function(e){
        e.preventDefault(); 
        $('#deleteQuestionModal').modal('show');

        $delete_element = $(this).attr('data-class');

        $('#delete_element').val($delete_element);
    });

    $("#confirmDeleteQuestion").click( function(e){ //user click on remove text
        e.preventDefault();   
        $delete_element = $('#delete_element').val();

        $('button[data-class='+$delete_element+']').parent('div').parent('div').parent('div').remove();
        x--;
        $('#deleteQuestionModal').modal('hide');
    });

    // Multiple Menu image file uplode Start
    var image_url=$("#image_url").val();
    var cross_img=image_url+"/close-cross.png"
    if (window.File && window.FileList && window.FileReader) {
        // $(document).on("change","#files",function(e) {
        $('#files').bind('change', function(event) {
        // $("#files").on("change", function(e) {
            $("#five_image_uplode").slideUp("slow");
             $("#invalid_formate").slideUp("slow");
            // var files = e.target.files;
             var ext = $('#files').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
              $("#invalid_formate").slideDown("slow");
            //   $("#invalid_formate").show();
               return false;
            }else{
                filesLength = files.length; 
                var total_file=document.getElementById("files").files.length;
                if(total_file > 5){
                    $("#five_image_uplode").slideDown("slow");
                    document.getElementById("files").value = "";
                    return false;
                }
                for(var i=0;i<total_file;i++){
                    var f = files[i]
                    var menu_images_length = $(".menu_image").length;
                    if(menu_images_length >= 5){
                        $("#five_image_uplode").slideDown("slow")
                        document.getElementById("files").value = "";
                        return false;
                    }
                    if(menu_images_length == 0){
                        
                        $('#files').after("<span class='pip menu_image first_image'><img class='imageThumb' src='"+ URL.createObjectURL(event.target.files[i])+"'><br/><span class='remove'><img class='close-icon' width='40px'src='"+cross_img+"'></span></span>");
                    }else{
                        $('.menu_image:last').after("<span class='pip menu_image'><img class='imageThumb' src='"+ URL.createObjectURL(event.target.files[i])+"'><br/><span class='remove'><img class='close-icon' width='40px'src='"+cross_img+"'></span></span>"); 
                    }
                    $(".remove").click(function(){
                        $(this).parent(".pip").remove();
                    });
                    $("#menu_image_error").hide();
                }
            }
        });
        } else {
            console.log("Your browser doesn't support to File API");
        }
    $(document).on("click",".remove",function() {
    $("#five_image_uplode").slideUp("slow");
    $("#invalid_formate").slideUp("slow");
      $(this).parent(".pip").remove();
    });

    // Multiple Menu image file uplode End



    // CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 

    // Update Menu
    $('#update_restaurant_menu').submit(function(e) {
        e.preventDefault();
        var menu_image= $(".menu_image").length;
        if(menu_image ==0){
            $("#menu_image_error").show();
            return false;
        }
        var formData = new FormData(this);
        
        $.ajax({
            type:'POST',
            url: "{{ url('update_restaurant_menu')}}",
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
                            $("[name="+key1+"]").addClass('is-invalid');
                            $('#'+key1).addClass('is-invalid');

                            $("[name="+key1+"]").parent('.error_message_parent').find('#errorMessage').html(value1);
                            $('#'+key1).parent('.error_message_parent').find('#errorMessage').html(value1);
                            
                        });
                    }
                    else if(key == 'option_error') 
                    {
                        $.each(value, function(key1, value1) 
                        {
                            $.each(value1, function(key2, value2) 
                            {
                                $.each(value2, function(key3, value3) 
                                {
                                    if (value3.length != 0) 
                                    {
                                        $('#'+key3).addClass('is-invalid');
                                        $('#'+key3).parent('.error_message_parent').find('#errorMessage').html(value3);
                                    }
                                    else
                                    {
                                        $('#'+key3).addClass('is-valid').removeClass('is-invalid');
                                        $('#'+key3).parent('.error_message_parent').find('#errorMessage').html(" ");
                                    }
                                });
                            });
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
        $(this).parent('.error_message_parent').find('#errorMessage').html(" ");
    });

    $('input').on('change', function () { 
        $(this).removeClass('is-invalid').addClass('is-valid');
        $(this).parent('.error_message_parent').find('#errorMessage').html(" ");
    });

    $('textarea').on('keyup', function () { 
        $(this).removeClass('is-invalid').addClass('is-valid');
        $(this).parent('.error_message_parent').find('#errorMessage').html(" ");
    });

    $('select').on('change', function () { 
        $(this).removeClass('is-invalid').addClass('is-valid');
        $(this).parent('.error_message_parent').find('#errorMessage').html(" ");
    });

    // Multiple select Box
    $(document).ready(function() {

        var select = $('select[multiple]');
        var options = select.find('option');

        var div = $('<div />').addClass('selectMultiple');
        var active = $('<div />');
        var list = $('<ul />');
        var placeholder = select.data('placeholder');

        var span = $('<span />').text(placeholder).appendTo(active);

        options.each(function() {
            var text = $(this).text();
            if($(this).is(':selected')) {
                active.append($('<a />').html('<em>' + text + '</em><i></i>'));
                span.addClass('hide');
            } else {
                list.append($('<li />').html(text));
            }
        });

        active.append($('<div />').addClass('arrow'));
        div.append(active).append(list);

        select.wrap(div);

        $(document).on('click', '.selectMultiple ul li', function(e) {
            var select = $(this).parent().parent();
            var li = $(this);
            if(!select.hasClass('clicked')) {
                select.addClass('clicked');
                li.prev().addClass('beforeRemove');
                li.next().addClass('afterRemove');
                li.addClass('remove');
                var a = $('<a />').addClass('notShown').html('<em>' + li.text() + '</em><i></i>').hide().appendTo(select.children('div'));
                a.slideDown(400, function() {
                    setTimeout(function() {
                        a.addClass('shown');
                        select.children('div').children('span').addClass('hide');
                        select.find('option:contains(' + li.text() + ')').prop('selected', true);
                    }, 500);
                });
                setTimeout(function() {
                    if(li.prev().is(':last-child')) {
                        li.prev().removeClass('beforeRemove');
                    }
                    if(li.next().is(':first-child')) {
                        li.next().removeClass('afterRemove');
                    }
                    setTimeout(function() {
                        li.prev().removeClass('beforeRemove');
                        li.next().removeClass('afterRemove');
                    }, 200);

                    li.slideUp(400, function() {
                        li.remove();
                        select.removeClass('clicked');
                    });
                }, 600);
            }
        });

        $(document).on('click', '.selectMultiple > div a', function(e) {
            var select = $(this).parent().parent();
            var self = $(this);
            self.removeClass().addClass('remove');
            select.addClass('open');
            setTimeout(function() {
                self.addClass('disappear');
                setTimeout(function() {
                    self.animate({
                        width: 0,
                        height: 0,
                        padding: 0,
                        margin: 0
                    }, 300, function() {
                        var li = $('<li />').text(self.children('em').text()).addClass('notShown').appendTo(select.find('ul'));
                        li.slideDown(400, function() {
                            li.addClass('show');
                            setTimeout(function() {
                                select.find('option:contains(' + self.children('em').text() + ')').prop('selected', false);
                                if(!select.find('option:selected').length) {
                                    select.children('div').children('span').removeClass('hide');
                                }
                                li.removeClass();
                            }, 400);
                        });
                        self.remove();
                    })
                }, 300);
            }, 400);
        });

        $(document).on('click', '.selectMultiple > div .arrow, .selectMultiple > div span', function(e) {
            $(this).parent().parent().toggleClass('open');
        });

    });
});

</script>