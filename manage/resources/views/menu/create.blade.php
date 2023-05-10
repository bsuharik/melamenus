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

                        {{ $restaurant_name }} - Add Menu Item

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

    

    <input type="hidden" value="../{{ config('images.menu_url') .$restaurant_id}}" id="menu_image_url">

    <input type="hidden" value="{!! asset('theme/admin/image/') !!}" id="image_url">

    <form method="POST" enctype="multipart/form-data" id="create_restaurant_menu" action="javascript:void(0)" files="true" >

        <div class="container-fluid">

            <div class="row page-titles mx-0">

                <div class="col-sm-10 p-md-0">

                    <div class="welcome-text">

                        <h4>Add Menu Item</h4>                           

                    </div>

                </div>

                <div class="col-sm-2 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">

                    <input type="submit" name="submit" value="Save" class="btn btn-primary btn-block" style="color:#fff!important;">

                    &nbsp;

                    <a href="{{ url('menu') }}/{{ $restaurant_id }}" id="back_button" class="btn btn-info btn-block">Back</a>

                </div>

            </div>

            <div class="mainErrorMessage"></div>

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

                            <h4 class="section-title bold">Add Menu Details</h4>

                            <table class="table ms-profile-information">

                                <tbody>

                                    <tr>

                                        <th scope="row">Name</th>

                                        <td class="row error_message_parent">

                                            <input type="hidden" name="restaurant_id" value="{{ $restaurant_id }}" />

                                            <input type="text" class="form-control" placeholder="Enter Name" name="name" id="name" />

                                            <div id="errorMessage"></div>

                                        </td>

                                    </tr>

                                    <tr>

                                        <th scope="row">Price</th>

                                        <td class="row error_message_parent price_box" >

                                            <span class="row col-md-10 error_message_parent" style="padding: 0px;float: left;">

                                                <div class="col-md-5">

                                                <input type="text" class="number-only form-control"  placeholder="Price" name="price[]"  />

                                                </div>

                                                <div class="col-md-6">

                                                <input type="text" class="form-control" placeholder="Description" name="price_des[]" />

                                                </div>

                                                

                                            </span>



                                            <span  class="col-md-2" style="padding: 0px;float: right;text-align: right;">

                                                 <button id="clone_price_type_add" type="button" class="btn btn-primary" style="color:#fff;">+</button>

                                            </span>

                                        </td>



                                        <!-- <div id="cloned_price_type"></div> 

                                        <div id="errorMessage" class="price_error_msg"></div> -->



                                    </tr>

                                    <tr>

                                        <th scope="row">Parent Category</th>

                                        <td class="" style="margin-right: -33px;">

                                            <span class="row col-md-10 error_message_parent" style="padding: 0px;float: left;">

                                                <select name="parent_category" class="form-control" id="parent_category">

                                                    <option value="">Select Parent Category</option>

                                                @if(count($parent_categories) > '0')

                                                    @foreach ($parent_categories as $category)

                                                        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>

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

                                                <select name="main_category" class="form-control" id="main_category">

                                                    <option value="">Select Main Category</option>

                                                </select>

                                                <div id="errorMessage"></div>

                                            </span>

                                            <span  class="col-md-2" style="padding: 0px;float: right;text-align: right;">

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

                                                <option value="">Select</option>

                                                <option value="1">Available</option>

                                                <option value="0">Not Available</option>

                                                <option value="2">Hide</option>

                                            </select> 

                                            <div id="errorMessage"></div>

                                        </td>

                                    </tr>

                                    <tr>

                                        <th scope="row">Ingredients</th>

                                        <td class="row error_message_parent">

                                            <input type="text" class="form-control" placeholder="Enter Ingredients" name="ingredients" id="ingredients" maxlength="50" />

                                            <div id="errorMessage"></div>

                                        </td>

                                    </tr>

                                    <tr>

                                        <th scope="row">Allergies</th>

                                        <td class="row error_message_parent">

                                           <select name="allergies[]" id="allergies" class="form-control multiple_allergies" multiple  allergies data-placeholder="Select Allergies">

                                                

                                                @if(count($allergies_list) > '0')

                                                @foreach ($allergies_list as $allergies)

                                                    <option value="{{ $allergies->allergy_id }}">{{ $allergies->allergy_name }}</option>

                                                @endforeach

                                            @endif

                                            </select>  

                                            <div id="errorMessage"></div>

                                        </td>

                                    </tr>

                                    <tr>

                                        <th scope="row">Calories</th>

                                        <td class="row error_message_parent">

                                            <input type="text" class="form-control" placeholder="Enter Calories" name="calories" id="calories"/>

                                            <div id="errorMessage"></div>

                                        </td>

                                    </tr>

                                    <tr>

                                        <th scope="row">Link</th>

                                        <td class="row error_message_parent">

                                            <input type="text" class="form-control" name="link" id="link" placeholder="http://www.google.com/" />

                                            <div id="errorMessage"></div>

                                        </td>

                                    </tr>

                                    <tr>

                                        <th scope="row">Tag</th>

                                        <td class="row error_message_parent">

                                            <select name="tag_id[]" class="form-control" id="tag_id" multiple data-placeholder="Select Tag">

                                            @if(count($tag_list) > '0')

                                                @foreach ($tag_list as $tag)

                                                    <option value="{{ $tag->tag_id }}">{{ $tag->tag_name }}</option>

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

                            <p><b>Menu Image </b></p>



                            <button type="button" class="btn btn-primary error_message_parent upload-btn">

                                <label for="files">Select menu Image</label> 

                            </button>



                            <span style="display: none; color: red" id="menu_image_error">Menu image is required</span>

                            <span style="display: none; color: red" id="five_image_uplode">You are only allowed to upload 6 menu image</span>

                            <span style="display: none; color: red" id="invalid_formate">Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF</span>

                            <input type="file" id="files" name="files[]" multiple style="visibility:hidden;"/>

                            <p id="display_image_lable" style="display:none"></p>

                             

                            <br/>

                            <div class="description_div">

                                <label><b>Description </b></label>

                                <span class="description error_message_parent">

                                    <textarea type="text" name="description" id="description" class="form-control" style="height:150px;" placeholder="Enter Description"/></textarea>

                                    <div id="errorMessage"></div>

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <div class="new"> </div>
		{{--
        <div class="col-md-12">

            <div class="card">

                <div class="card-body">

                    <h4 class="section-title bold">Chef's Questions

                        <button id="clone_chef_questions_add" type="button" class="btn btn-primary mb-2" style="float:right;">&#x2B;</button>

                    </h4>

                    <br>

                    <hr/>

                    <div class="form-row">

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

                    </div>

                </div>

            </div>

        </div>--}}

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

                                        <input type="hidden" name="restaurant_id" value="{{ $restaurant_id }}" />

                                        <input type="text" class="form-control" name="category_name" id="category_name0" placeholder="Enter Category Name" />

                                    </div>

                                    <br><label>Category icon</label>

                                        <input type="file" class="form-control" name="category_icon" id="category_icon0" />

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

                                        <input type="hidden" name="restaurant_id" id="restaurant_id" value="{{ $restaurant_id }}" />

                                        <input type="hidden" name="parent_category_id" id="parent_category_id" />

                                        <input type="text" class="form-control" name="category_name" id="category_name1" placeholder="Category Name" />

                                    </div>

                                    <div class="col-sm-12">

                                    <br><label>Category icon</label>

                                        <input type="file" class="form-control" name="category_icon" id="category_icon1" />

                                    </div>

                                    <div class="col-sm-12">

                                    <br><label>Display Type</label>

                                    <select name="display_type" class="form-control" id="display_type1">

                                        <option value="1">Always Display</option>

                                        <option value="2">Custome Display</option>

                                    </select>

                                    <span id="errorMessage"></span>

                                    </div>

                                    <div id="custome_type_div" style="display: none;" class="col-sm-12">

                                        <div class="row error_message_parent">

                                            <br><label>Days</label>

                                            <!-- <select name="display_days" class="form-control" id="display_days1"> 

                                                <option value="">Select Day</option>

                                                <option value="All">All</option>

                                                <option value="Sunday">Sunday</option>

                                                <option value="Monday">Monday</option>

                                                <option value="Tuesday">Tuesday</option>

                                                <option value="Wednesday">Wednesday</option>

                                                <option value="Thursday">Thursday</option>

                                                <option value="Friday">Friday</option>

                                                <option value="Saturday">Saturday</option>

                                            </select> 

                                            <span id="errorMessage"></span> -->

                                            <select name="display_days[]" id="display_days" class="form-control multiple_display_day" multiple  display_days data-placeholder="Select Day">

                                                <!-- <option value="All">All</option> -->

                                                <option value="Sunday">Sunday</option>

                                                <option value="Monday">Monday</option>

                                                <option value="Tuesday">Tuesday</option>

                                                <option value="Wednesday">Wednesday</option>

                                                <option value="Thursday">Thursday</option>

                                                <option value="Friday">Friday</option>

                                                <option value="Saturday">Saturday</option>



                                            </select>

                                            <div id="errorMessage" class="dayErrorMessage"></div>

                                        </div>

                                       <div class="row mt10">

                                            <div class="row">

                                                <div class="col-lg-6">

                                                    <label>Start Time</label>

                                                    <div class=" error_message_parent" >

                                                        <input id="start_time1" name="start_time" size="30" type="text" class="form-control" placeholder="Select Start Time"/>

                                                        <span id="errorMessage"></span>

                                                    </div>

                                                </div>

                                                <div class="col-lg-6">

                                                    <label>End Time</label>

                                                    <div class=" error_message_parent" >

                                                        <input id="end_time1" name="end_time"  size="30" type="text" class="form-control" placeholder="Select End Time" />

                                                        <span id="errorMessage"></span>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

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

                                        <input type="hidden" name="restaurant_id" id="restaurant_id" value="{{ $restaurant_id }}" />

                                        <input type="hidden" name="parent_category_id" id="parent_category_id_2" />

                                        <input type="hidden" name="main_category_id" id="main_category_id" />

                                        <input type="text" class="form-control" name="category_name" id="category_name2" placeholder="Category Name" />

                                        <br><label>Category icon</label>

                                        <input type="file" class="form-control" name="category_icon" id="category_icon2" />

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

        <!-- Delete price Modal START-->

            <div class="modal fade" id="deletepriceModal">

                <div class="modal-dialog modal-dialog-centered" role="document">

                    <div class="modal-content">

                        <div class="modal-body">

                            <div class="form-row">

                                <span>Are you sure you want to delete this Price?</span>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>

                            <a href="" id="confirmDeleteprice" class="btn btn-primary" style="color:#fff!important; margin: 0;">Confirm Delete</a>

                            <input type="hidden" name="delete_price_element" id="delete_price_element">

                        </div>

                    </div>

                </div>

            </div>

    <!-- Delete question Modal END-->



<!--**********************************

    Content body end

***********************************-->



@include('theme.footer')



<script type="text/javascript">

$(document).ready(function (e) {



    $("#display_type1" ).change(function(){

        $display_type = $(this).val();

        if ($display_type == "2"){

            $('#custome_type_div').show();

        }else{

            $('#custome_type_div').hide();

        }

    });

    $('#start_time1').timepicker({

        'step': '60',

    });

    $('#end_time1').timepicker({

        'minTime': '12:00am',

        'step': '60',

        'showDuration': true

    });

    $('#start_time1').on('changeTime', function() {

        $('#end_time1').timepicker('option', 'minTime', $(this).val());

    });









    $(function(){

        $('.number-only').keypress(function(e) {

            if(isNaN(this.value+""+String.fromCharCode(e.charCode))) return false;

        })

        .on("cut copy paste",function(e){

            e.preventDefault();

        });

    });



    $('#errorMessage').html(" ");



    // multiple chef questions

    var max_fields = 5; //maximum input boxes allowed

    var wrapper    = $("#cloned_chef_questions"); //Fields wrapper

    var add_button = $("#clone_chef_questions_add"); //Add button ID

    

    var x = 0; //initlal text box count

    $(add_button).click(function(e){ //on add input button click

        e.preventDefault();

        if(x < max_fields)

        { //max input box allowed

            chef_question_box='';

            chef_question_box+='<div class="col-sm-12">';

            chef_question_box+='<div class="form-group  mb-0">';

            chef_question_box+='<div class="row error_message_parent">';

            chef_question_box+='<input type="text" name="question'+x+'" id="question'+x+'" class="form-control col-md-11 mt-0 my-3" placeholder="Write own question here" />';

            chef_question_box+='<div class="col-md-1">';

            chef_question_box+='<button id="remove_field" type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteQuestionModal" data-class="remove_field'+x+'" style="float:right;">-</button>';

            chef_question_box+='</div>';

            chef_question_box+='<div id="errorMessage" class="row col-md-12"></div>';

            chef_question_box+='<label class="radio-inline col-md-4"> ';

            chef_question_box+='<input type="text" name="option_1'+x+'" class="form-control col-md-12" placeholder="Answer 1" />';

            chef_question_box+='</label>';

            chef_question_box+='<label class="radio-inline col-md-4"> ';

            chef_question_box+='<input type="text" name="option_2'+x+'" class="form-control col-md-12" placeholder="Answer 2" />';

            chef_question_box+='</label>';

            chef_question_box+='<label class="radio-inline col-md-4"> ';

            chef_question_box+='<input type="text" name="option_3'+x+'" class="form-control col-md-12" placeholder="Answer 3" />';

            chef_question_box+='</label>';

            chef_question_box+='<label class="radio-inline col-md-4"> ';

            chef_question_box+='<input type="text" name="option_4'+x+'" class="form-control col-md-12" placeholder="Answer 4" />';

            chef_question_box+='</label>';

            chef_question_box+='<label class="radio-inline col-md-4"> ';

            chef_question_box+='<input type="text" name="option_5'+x+'" class="form-control col-md-12" placeholder="Answer 5" />';

            chef_question_box+='</label>';

            chef_question_box+='</div>';

            chef_question_box+='</div>';

            chef_question_box+='</div>';

            $(wrapper).append(chef_question_box); //add input box

            x++; //text box increment

        }

    });



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



////////////////Multiple Price Start Here//////////////////////////////////////



    // multiple price

    var max_field = 5; //maximum input boxes allowed

    //var wrappers    = $("#cloned_price_type"); //Fields wrapper

    var add_price_type_button = $("#clone_price_type_add"); //Add button ID



    var price_x = 0; //initlal text box count

    $(add_price_type_button).click(function(e){ //on add input button click

        e.preventDefault();

            multiple_price_box='';

        if(price_x < max_field)

        { //max input box allowed

            multiple_price_box+= '<td class="row error_message_parent" >';

            multiple_price_box+='<span class="row col-md-10 error_message_parent" style="padding: 0px;float: left;">';

            multiple_price_box+='<div class="col-md-5">';

            multiple_price_box+='<input type="text" class="number-only form-control"  placeholder="Price" name="price[]"  />';

            multiple_price_box+='</div>';

            multiple_price_box+='<div class="col-md-6">';

            multiple_price_box+='<input type="text" class="form-control" placeholder="Description" name="price_des[]" />';

            multiple_price_box+='</div>';

            multiple_price_box+='</span>';

            multiple_price_box+='<span  class="col-md-2" style="padding: 0px;float: right;text-align: right;">';

            multiple_price_box+='<button id="remove_price_field" type="button" class="btn btn-primary" data-toggle="modal" data-target="#deletepriceModal" data-class="remove_price_field'+price_x+'"style="float:right; color:#fff;">-</button>';

            multiple_price_box+='</span>';

            multiple_price_box+='</td>';

            $('.price_box:last').after(multiple_price_box);

            // $(wrappers).append(multiple_price_box);//add input box

            price_x++; //text box increment

        }

    });





    $('body').delegate('#remove_price_field','click', function(e){

        e.preventDefault(); 

        $('#deletepriceModal').modal('show');

        $delete_price_element = $(this).attr('data-class');

        $('#delete_price_element').val($delete_price_element);

    });



    $("#confirmDeleteprice").click( function(e){ //user click on remove text

        e.preventDefault();   

        $delete_price_element = $('#delete_price_element').val();

        $('button[data-class='+$delete_price_element+']').parent('span').parent('td').remove();

        price_x--;

        $('#deletepriceModal').modal('hide');

    });

////////////////Multiple Price ENd Here//////////////////////////////////////







    // CSRF Token

    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });



    // Create New Menu

    $('#create_restaurant_menu').submit(function(e) {

        e.preventDefault();
        $('.mainErrorMessage').html('');
        $('input').removeClass('is-invalid');
        var menu_image= $(".menu_image").length;

        if(menu_image ==0){

            $("#menu_image_error").show();

            return false;

        }

        var formData = new FormData(this);

        

        $.ajax({

            type:'POST',

            url: "{{ url('add_restaurant_menu')}}",

            data: formData,

            cache:false,

            contentType: false,

            processData: false,

            success: function(data){

                $.each(data, function(key, value) 

                {

                 console.log(key);  

                     

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

                                    if (value3.length != 0){

                                        $('#'+key3).addClass('is-invalid');

                                        $('#'+key3).parent('.error_message_parent').find('#errorMessage').html(value3);

                                    }

                                    else{

                                        $('#'+key3).addClass('is-valid').removeClass('is-invalid');

                                        $('#'+key3).parent('.error_message_parent').find('#errorMessage').html(" ");

                                    }

                                });

                            });

                        });

                    }

                    else if(key == 'priceerror'){

                        $('.price_error_msg').html(value);

                        

                    }

                    else if(key == 'errors') 

                    {

                        var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> '+ value +'\</div>';



                        $('.mainErrorMessage').html(html);



                        // location.reload(true);

                    }

                    else if(key == 'success')

                    {

                        var html ='<div class="alert alert-success background-success">\<button type="button" class="close"  data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Success!</strong> '+ value +'\</div>';



                        $('.mainErrorMessage').html(html);



                        window.location.href = '<?php echo url('menu/'.$restaurant_id);?>';

                    }

                });

            }, 

            error: function(data){

                

                 var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> Error while adding data\</div>';



                $('.mainErrorMessage').html(html);



                //location.reload(true);

            }

        });

    });



    // Add Parent Category

    $('#add_parent_category').submit(function(e) {
        $('.parentCategoryErrorMessage').html('');
        $('input').removeClass('is-invalid');
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

                            $('#'+key1+'0').addClass('is-invalid');

                        });

                    }

                    else if(key == 'errors') 

                    {

                        var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> '+ value +'\</div>';



                        $('.parentCategoryErrorMessage').html(html);

                    }

                    else if(key == 'success')

                    {

                        var html ='<div class="alert alert-success background-success">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Success!</strong> '+ value +'\</div>';



                        $('.parentCategoryErrorMessage').html(html);

                    }

                    else if(key == 'parent_categories')

                    {

                        $("#parentCategoryModal .close").click();

                        $('#parentCategoryModal input[type=text]').val('');

                        $('#parentCategoryModal input[type=hidden]').val('');



                        $parent_category_list = value;

                        $('#parent_category').html("<option value=''> Select Parent Category </option>");



                        $.each($parent_category_list, function(key1, value1) 

                        {

                            $('#parent_category').append("<option value='"+value1['category_id']+"'> "+value1['category_name']+" </option>");

                        });

                    }

                });

            },

            error: function(data){



                var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> Error while adding data\</div>';



                $('.parentCategoryErrorMessage').html(html);

            }

        });

    });



    //Get Main Category for selected Parent Category

    $( "#parent_category" ).change(function() {

        $('.parentCategoryErrorMessage').html('');
        $('input').removeClass('is-invalid');

        var parent_caregory = $('#parent_category :selected').val();

        $('#parent_category_id').val(parent_caregory);

        $('#parent_category_id_2').val(parent_caregory);



        var ids = $(this).val();

        var restaurant_id = "{{ $restaurant_id }}";



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

                            $('#sub_category').html("<option value=''> Select Sub Category </option>");

                            $('#main_category').html("<option value=''> Select Main Category </option>");



                            $.each($main_category_list, function(key1, value1) 

                            {

                                $('#main_category').append("<option value='"+value1['category_id']+"'> "+value1['category_name']+" </option>");

                            });

                        }

                        else

                        {

                            $('#main_category').html("<option value=''> Select Main Category </option>");

                            $('#sub_category').html("<option value=''> Select Sub Category </option>");

                        }

                    });

                }

            });

    });



    // Add Main Category

    $('#add_main_category').submit(function(e) {

        $('.mainCategoryErrorMessage').html('');
        $('input').removeClass('is-invalid');

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

                            $('#'+key1+'1').addClass('is-invalid');

                        });

                    }

                    else if(key == 'days_required'){

                        $('.dayErrorMessage').html(value);

                        // $('#display_days').addClass('is-invalid');

                    }

                    else if(key == 'errors') 

                    {

                        var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> '+ value +'\</div>';



                        $('.mainCategoryErrorMessage').html(html);

                    }

                    else if(key == 'success')

                    {

                        var html = '<div class="alert alert-success background-success">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Success!</strong> '+ value +'\</div>';



                        $('.mainCategoryErrorMessage').html(html);

                    }

                    else if(key == 'main_categories')

                    {

                        $("#mainCategoryModal .close").click();

                        $('#mainCategoryModal input[type=text]').val('');

                        $('#mainCategoryModal input[type=hidden]').val('');



                        $main_category_list = value;



                        $('#main_category').html("<option value=''> Select Main Category </option>");



                        $.each($main_category_list, function(key1, value1) 

                        {

                            $('#main_category').append("<option value='"+value1['category_id']+"'> "+value1['category_name']+" </option>");

                        });

                    }

                });

            },

            error: function(data){



                 var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> Error while adding data\</div>';



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

        var restaurant_id = "{{ $restaurant_id }}";



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


        $('.subCategoryErrorMessage').html('');
        $('input').removeClass('is-invalid');
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

                            $('#'+key1+'2').addClass('is-invalid');

                        });

                    }

                    else if(key == 'errors') 

                    {

                        var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> '+ value +'\</div>';



                        $('.subCategoryErrorMessage').html(html);

                    }

                    else if(key == 'success')

                    {

                        var html = '<div class="alert alert-success background-success">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Success!</strong> '+ value +'\</div>';



                        $('.subCategoryErrorMessage').html(html);

                    }

                    else if(key == 'sub_categories')

                    {

                        $("#subCategoryModal .close").click();

                        $('#subCategoryModal input[type=text]').val('');

                        $('#subCategoryModal input[type=hidden]').val('');



                        $sub_category_list = value;



                        $('#sub_category').html("<option value=''> Select Sub Category </option>");



                        $.each($sub_category_list, function(key1, value1) 

                        {

                            $('#sub_category').append("<option value='"+value1['category_id']+"'> "+value1['category_name']+" </option>");

                        });

                    }

                });

            },

            error: function(data){



                var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> Error while adding data\</div>';



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

        // Select multiple Days Start

            var add_days_select = $('#display_days');

            var add_days_options = add_days_select.find('option');

            var add_days_div = $('<div />').addClass('selectMultiple');

            var add_days_active = $('<div />');

            var add_days_list = $('<ul />');

            var add_days_placeholder = add_days_select.data('placeholder');

            var add_days_span = $('<span />').text(add_days_placeholder).appendTo(add_days_active);

            add_days_options.each(function(){

                var add_days_text = $(this).text();

                if($(this).is(':selected')) {

                    add_days_active.append($('<a />').html('<em>' + add_days_text + '</em><i></i>'));

                    add_days_span.addClass('hide');

                } else {

                    add_days_list.append($('<li />').html(add_days_text));

                }

            });

            add_days_active.append($('<div />').addClass('arrow'));

            add_days_div.append(add_days_active).append(add_days_list);

            add_days_select.wrap(add_days_div);

        // Select multiple Days End



        

        //Select multiple Tag Start

            //var mul_select = $('select[multiple]');

            var tags_select = $('#tag_id');

            var tags_options = tags_select.find('option');

            var tags_div = $('<div />').addClass('selectMultiple');

            var tags_active = $('<div />');

            var tags_list = $('<ul />');

            var tags_placeholder = tags_select.data('placeholder');

            var tags_span = $('<span />').text(tags_placeholder).appendTo(tags_active);

            tags_options.each(function(){

                var tags_text = $(this).text();

                if($(this).is(':selected')) {

                    tags_active.append($('<a />').html('<em>' + tags_text + '</em><i></i>'));

                    tags_span.addClass('hide');

                } else {

                    tags_list.append($('<li />').html(tags_text));

                }

            }); 

            tags_active.append($('<div />').addClass('arrow'));

            tags_div.append(tags_active).append(tags_list);

            tags_select.wrap(tags_div); 

        // Select multiple Tag End

        //Select multiple Allergies Start

            var allergies_select = $('#allergies');

            var allergies_options = allergies_select.find('option');

            var allergies_div = $('<div />').addClass('selectMultiple');

            var allergies_active = $('<div />');

            var allergies_list = $('<ul />');

            var allergies_placeholder = allergies_select.data('placeholder');

            var allergies_span = $('<span />').text(allergies_placeholder).appendTo(allergies_active);

            allergies_options.each(function(){

                var allergies_text = $(this).text();

                if($(this).is(':selected')) {

                    allergies_active.append($('<a />').html('<em>' + allergies_text + '</em><i></i>'));

                    allergies_span.addClass('hide');

                } else {

                    allergies_list.append($('<li />').html(allergies_text));

                }

            });

            allergies_active.append($('<div />').addClass('arrow'));

            allergies_div.append(allergies_active).append(allergies_list);

            allergies_select.wrap(allergies_div);

        //Select multiple Allergies End

      

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



        $(document).on('click', '.selectMultiple > div .arrow, .selectMultiple > div span', function(e){



            $(this).parent().parent().toggleClass('open');

        });



    });

    // Multiple Menu image file uplode Start

    $(document).ready(function() {



        var image_url=$("#image_url").val();

        var cross_img=image_url+"/close-cross.png"

        if (window.File && window.FileList && window.FileReader) {

            // $(document).on("change","#files",function(e) {

            $('#files').bind('change', function(event) { 

                var file_detail = [];

                file_detail = this.files;



                var fd = new FormData();               

                 $("#five_image_uplode").slideUp("slow");

                 $("#invalid_formate").slideUp("slow");

                var ext = $('#files').val().split('.').pop().toLowerCase();

                if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){

                  $("#invalid_formate").slideDown("slow");

                   //   $("#invalid_formate").show();

                   return false;

                }else{

                    filesLength = files.length; 

                    var total_file=document.getElementById("files").files.length;

                    if(total_file > 6){

                        $("#five_image_uplode").slideDown("slow");

                        document.getElementById("files").value = "";

                        return false;

                    }



                    for(var i=0;i<total_file;i++){



                        var menu_images_length = $(".menu_image").length;



                        var restaurant_id = "{{ $restaurant_id }}";

                        fd.append('filename', file_detail[i]);

                        fd.append('restaurant_id',restaurant_id);

                        var f = files[i]

                        

                        var All_file= menu_images_length + total_file; 

                        if(All_file > 6){

                            $("#five_image_uplode").slideDown("slow")

                            document.getElementById("files").value = "";

                            return false;

                        }



                        $.ajax({

                            url: "{{ url('add_menu_image')}}",

                            type:'POST',

                            data:fd,

                            contentType: false,

                            cache: false,

                            processData: false,

                            success:function(data){ 



                                var menu_image_url=$("#menu_image_url").val();



                                $.each(data, function(key, value){

                                    if(menu_images_length == 0){

                                    

                                        $("#display_image_lable").show();

                                        $('#display_image_lable').after("<span class='pip menu_image first_image'><img class='imageThumb' src='"+menu_image_url+"/"+value.image_name+"'><br/><span class='remove'><img class='close-icon' width='40px'src='"+cross_img+"'></span></span><input type='hidden' value='"+value.id+"' name='menu_image_id[]'>");

                                    }else{

                                        

                                        $('.menu_image:last').after("<span class='pip menu_image'><img class='imageThumb' src='"+menu_image_url+"/"+value.image_name+"'><br/><span class='remove' data-menu_image_id='"+value.id+"'><img class='close-icon' width='40px'src='"+cross_img+"'></span></span><input type='hidden' value='"+value.id+"' name='menu_image_id[]'>"); 

                                    } 

                                    menu_images_length+=1;

                                    $(".remove").click(function(){

                                        var menu_images_length = $(".menu_image").length;

                                        

                                        if(menu_images_length == 0){

                                            $("#display_image_lable").hide();

                                        }

                                        $(this).parent(".pip").remove();

                                    });

                                    document.getElementById("files").value = "";

                                    

                                });

                            } 

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

            var menu_images_length = $(".menu_image").length;

            

            if(menu_images_length == 0){

            $("#display_image_lable").hide();

            } 



            // });

        });

    });

    // Multiple Menu image file uplode End





});

</script> 