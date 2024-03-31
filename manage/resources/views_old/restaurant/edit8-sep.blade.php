    @include('theme.header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.css" />

    <!--**********************************
        Header start
    ***********************************-->
    <div class="header">
        <div class="header-content">
           <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">  
                            {{ $restaurant->restaurant_name }} - Edit Profile DetailsOLD3
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
            <form method="POST" enctype="multipart/form-data" id="update_restaurant_profile" action="javascript:void(0)" files="true">
                <!-- row -->
                <div class="row">                
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- row -->
                                <div class="row"> 
                                    <div class="col-sm-10"></div>
                                    <div class="col-sm-2 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                                        <input class="btn btn-primary btn-block" type="submit" name="save" value="Save">
                                        &nbsp;
                                        <a href="{{ url('restaurant-detail') }}/{{ $restaurant->restaurant_id }}" id="back_button" class="btn btn-info btn-block">Back</a>
                                    </div>
                                </div>
                                <br>
                                <div class="errorMessage"></div>
                                <div class="profile-tab">
                                    <div class="profile card card-body px-3 pt-3 pb-0" style="padding-top: 0px !important;">
                                        <div class="profile-head brand-cover-photo">
                                            <div class="brand-maincover-pic"> 
                                            @if(!empty($restaurant->restaurant_cover_image)) 
                                                <img src="../{{ config('images.restaurant_url') .$restaurant->restaurant_id.'/'. $restaurant->restaurant_cover_image }}" class="brand-banner-img banner_img" alt="Restaurant Cover Image">  

                                            @else
                                                <img  src="../{{ config('images.restaurant_default_banner_url')}}" class="brand-banner-img banner_img" alt="Restaurant Cover Image">
                                            @endif
                                            </div>
                                            <div class="profile-info">
                                                <div class="profile-photo error_message_parent" style="margin-top: 0px;">
                                                    @if(!empty($restaurant->restaurant_logo))
                                                    <img src="../{{ config('images.restaurant_url') .$restaurant->restaurant_id.'/'. $restaurant->restaurant_logo }}" class="img-fluid logo_img" alt="Restaurant Logo" >
                                                    @else
                                                         <img src="../{{ config('images.default_image_url')}}" class="img-fluid logo_img" alt="" >
                                                    @endif
                                                    <input name="restaurant_logo" class="file-upload" type="file" accept="image/*" id="restaurant_logo"/>
                                                   <span id="errorMessage"></span>
                                                    <div class="p-image">
                                                        <img src="{{URL::to('/theme/admin/images/pencil.png')}}">
                                                    </div> 
                                                </div> 
                                                <div class="profile-details">
                                                    <div class="profile-name px-3 pt-3">
                                                        <h4 class="text-primary mb-0 error_message_parent">
                                                            <input type="hidden" name="restaurant_id" id="restaurant_id" value="{{ $restaurant->restaurant_id }}"/>
                                                            <input type="text" class="form-control" name="restaurant_name" id="restaurant_name" placeholder="Enter Restaurant Name" value="{{ $restaurant->restaurant_name }}" maxlength="50"/>
                                                            <span id="errorMessage"></span>
                                                        </h4> 
                                                    </div>
                                                    <div class="advertisement-banner ml-auto">
                                                    <div class="error_message_parent" style="margin-top: 0px;">
                                                        <br>
                                                        <!-- <input type="file" name="restaurant_cover_image" id="restaurant_cover_image"> -->
                                                        <span id="errorMessage"></span>
                                                        <input name="restaurant_cover_image" class="file-upload profile_banner" type="file"  id="restaurant_cover_image"accept="image/*"/>
                                                        <div class="pbanner-image">
                                                            <a href="javascript:void(0);"onclick="$('#restaurant_cover_image').trigger('click');" id="upload_profile_banner" ><img src="{{URL::to('/theme/admin/images/pencil.png')}}" class="mr-2">Edit</a>
                                                        </div>

                                                    </div>
                                                    </div>

                                                    <div class="dropdown ml-auto">
                                                        
                                                    </div>                                 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="custom-tab-1">
                                        <div class="tab-content">
                                            <div id="my-posts" class="tab-pane fade active show">
                                                <div class="my-post-content pt-3">
                                                    <div class="profile-personal-info">
                                                        <h4 class="text-primary mb-4">Restaurant Information</h4>

                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label id="custom-label">First Name</label>
                                                            </div>
                                                            <div class="col-md-10 error_message_parent">
                                                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $restaurant->user_detail->first_name }}" maxlength="50" />
                                                                <span id="errorMessage"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label id="custom-label">Last Name</label>
                                                            </div>
                                                            <div class="col-md-10 error_message_parent">
                                                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $restaurant->user_detail->last_name }}" maxlength="50" />
                                                                <span id="errorMessage"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label id="custom-label">Email</label>
                                                            </div>
                                                            <div class="col-md-10 error_message_parent">
                                                                <input type="email" name="email" id="email" class="form-control" value="{{ $restaurant->email }}"/>
                                                                <span id="errorMessage"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label id="custom-label">Contact Number </label>
                                                            </div>
                                                            <div class="col-md-10 error_message_parent">
                                                                <input type="text" name="contact_number" id="contact_number" class="form-control" value="{{ $restaurant->contact_number }}"/>
                                                                <span id="errorMessage"></span>
                                                            </div>
                                                        </div>  
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label id="custom-label">Contact Person</label>
                                                            </div>
                                                            <div class="col-md-10 error_message_parent">
                                                                <input type="text" name="contact_person" id="contact_person" class="form-control" value="{{ $restaurant->contact_person }}" maxlength="50" />
                                                                <span id="errorMessage"></span>
                                                            </div>
                                                        </div>  
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label id="custom-label">Country </label>
                                                            </div>
                                                            <div class="col-md-10 error_message_parent">
                                                                <select name="country_id" class="form-control" id="country_id">
                                                                    <option value="">Select Country</option>
                                                                @if(count($country_list) > '0')
                                                                    @foreach ($country_list as $value)
                                                                        <option value="{{ $value->country_id }}" {{ ( $value->country_id == $restaurant->country_id) ? 'selected' : '' }} >{{ $value->country_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                                </select>
                                                                <span id="errorMessage"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label id="custom-label">TimeZone </label>
                                                            </div>
                                                            <div class="col-md-10 error_message_parent">
                                                                <select name="time_zone" class="form-control" id="time_zone">
                                                                    <option value="">Select TimeZone</option>
                                                                @if(count($country_list) > '0')
                                                                    @foreach ($country_list as $value)
                                                                        <option value="{{ $value->country_id }}" {{( $value->country_id == $restaurant->time_zone_id) ? 'selected' : '' }} >{{ $value->time_zone }}</option>
                                                                    @endforeach
                                                                @endif
                                                                </select>
                                                                <span id="errorMessage"></span>
                                                            </div>
                                                        </div>                                              
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label id="custom-label">Address </label>
                                                            </div>
                                                            <div class="col-md-10 error_message_parent">
                                                                <textarea name="location" id="location" class="form-control">{{ $restaurant->location }}</textarea>
                                                                <span id="errorMessage"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label id="custom-label">Currency </label>
                                                            </div>
                                                            <div class="col-md-10 error_message_parent">
                                                                <select name="currency_id" class="form-control" id="currency_id">
                                                                    <option value="">Select Currency</option>
                                                                @if(count($currency_list) > '0')
                                                                    @foreach ($currency_list as $value)
                                                                        <option value="{{ $value->currency_id }}" {{ ( $value->currency_id == $restaurant->currency_id) ? 'selected' : '' }} >{{ $value->currency_name }}</option>
                                                                    @endforeach
                                                                @endif
                                                                </select>
                                                                <span id="errorMessage"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label id="custom-label">Gender </label>
                                                            </div>
                                                            <div class="col-md-10 error_message_parent">
                                                                <select name="gender" class="form-control" id="gender">
                                                                    <option value="">Select Gender</option>
                                                                    <option value="0" {{ ( $restaurant->user_detail->gender == '0') ? 'selected' : '' }} >Male</option>
                                                                    <option value="1" {{ ( $restaurant->user_detail->gender == '1') ? 'selected' : '' }} >Female</option>
                                                                    <option value="2" {{ ( $restaurant->user_detail->gender == '2') ? 'selected' : '' }} >Other</option>
                                                                </select>
                                                                <span id="errorMessage"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label id="custom-label">Date Of Birth</label>
                                                            </div>
                                                            <div class="col-md-10 error_message_parent">
                                                                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ $restaurant->user_detail->date_of_birth }}"/>
                                                                <span id="errorMessage"></span>
                                                            </div>
                                                        </div> 
                                                        <div class="row form-group">
                                                            <div class="col">
                                                                <label id="custom-label">Texture Image </label>
                                                            </div> 
                                                            <div class="col "id="add_texture_image">
                                                                @if(!empty($restaurant->texture_id) && !empty($restaurant->texture_detail))
                                                                <div class="pip menu_image">
                                                                    <img class="imageThumb" src="../{{ config('images.texture_url') .$restaurant->texture_detail->image}}">
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <div class="col">
                                                               
                                                            </div>

                                                                <div class="col">

                                                                </div>  
                                                                <input type="hidden" name="texture_id" id="texture_id" value="@if(!empty($restaurant->texture_id)) {{$restaurant->texture_id}}@endif">                                                      
                                                            <div class="col">
                                                                <a data-toggle="modal" data-target="#select_texture" class="btn btn-primary btn-block" style="color:#fff!important;">Select Texture Image</a>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row form-group">
                                                            <div class="col">
                                                                <label id="custom-label">Select Theme  </label>
                                                            </div>
                                                            <div class="col">
                                                            </div>
                                                            <div class="col">
                                                            </div>

                                                                <div class="col">
                                                                </div>                                                        
                                                            <div class="col">
                                                                <a data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-primary btn-block" style="color:#fff!important;">Add Font</a>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col">
                                                                <label id="custom-label" class="mt-5">Color:  </label>
                                                            </div>
                                                            <div class="col">
                                                                <label id="custom-color-label">Header</label>
                                                                <input type="text" class="as_colorpicker form-control" value="{{ $restaurant->app_theme_color_1 }}" name="app_theme_color_1" autocomplete="off">
                                                                <span id="errorMessage"></span>
                                                            </div>
                                                            <div class="col">

                                                                <label id="custom-color-label">Main Title</label>
                                                                <input type="text" class="as_colorpicker form-control"  value="{{ $restaurant->app_theme_color_2 }}"name="app_theme_color_2" autocomplete="off">
                                                                <span id="errorMessage"></span>
                                                            </div>
                                                            <div class="col">
                                                                <label id="custom-color-label">Sub Title</label>
                                                                <input type="text" class="as_colorpicker form-control" value="{{ $restaurant->app_theme_color_3 }}" name="app_theme_color_3" autocomplete="off">
                                                                <span id="errorMessage"></span>
                                                            </div>
                                                            <div class="col">
                                                                <label id="custom-color-label">Description</label>
                                                                <input type="text" class="as_colorpicker form-control" value="{{ $restaurant->app_theme_color_4 }}" name="app_theme_color_4">
                                                                <span id="errorMessage"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                           
                                                            <div class="col-md-10 error_message_parent">
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col">
                                                                <label id="custom-label">Font Type:  </label>
                                                            </div>
                                                            <div class="col">  
                                                                
                                                               <select name="app_theme_font_type_1" class="form-control" id="app_theme_font_type_1">
                                                                    <option value="">Select</option>
                                                                    @if(count($restaurant->font_type_detail) > '0')
                                                                    @foreach ($restaurant->font_type_detail as $font)
                                                                        <option value="{{ $font->id }}" {{( $restaurant->app_theme_font_type_1 == $font->id) ? 'selected' : '' }} >{{ $font->name }}</option>
                                                                    @endforeach
                                                                    @endif
                                                                </select> 
                                                                
                                                            </div>
                                                            <div class="col">

                                                               
                                                                <select name="app_theme_font_type_2" class="form-control" id="app_theme_font_type_2">
                                                                    <option value="">Select</option>
                                                                    @if(count($restaurant->font_type_detail) > '0')
                                                                    @foreach ($restaurant->font_type_detail as $font)
                                                                        <option value="{{ $font->id }}" {{( $restaurant->app_theme_font_type_2 == $font->id) ? 'selected' : '' }} >{{ $font->name }}</option>
                                                                    @endforeach
                                                                    @endif
                                                                    
                                                                </select>
                                                            </div>
                                                            <div class="col">
                                                                <select name="app_theme_font_type_3" class="form-control" id="app_theme_font_type_3">
                                                                    <option value="">Select</option>
                                                                    @if(count($restaurant->font_type_detail) > '0')
                                                                    @foreach ($restaurant->font_type_detail as $font)
                                                                        <option value="{{ $font->id }}" {{( $restaurant->app_theme_font_type_3 == $font->id) ? 'selected' : '' }} >{{ $font->name }}</option>
                                                                    @endforeach
                                                                    @endif
                                                                    
                                                                </select>  
                                                            </div>
                                                            <div class="col">
                                                                <select name="app_theme_font_type_4" class="form-control" id="app_theme_font_type_4">
                                                                    <option value="">Select</option>
                                                                    @if(count($restaurant->font_type_detail) > '0')
                                                                    @foreach ($restaurant->font_type_detail as $font)
                                                                        <option value="{{ $font->id }}" {{( $restaurant->app_theme_font_type_4 == $font->id) ? 'selected' : '' }} >{{ $font->name }}</option>
                                                                    @endforeach
                                                                    @endif  
                                                                </select> 
                                                            </div> 
                                                        </div>

                                                        <div class="row form-group">
                                                            <div class="col">
                                                                <label id="custom-label">Font Style:  </label>
                                                            </div>
                                                            <div class="col">
                                                                
                                                               <select name="app_theme_font_style_1" class="form-control" id="app_theme_font_style_1">
                                                                    <option value="">Select</option>
                                                                    <option value="bold" {{ ( $restaurant->app_theme_font_style_1 == 'bold') ? 'selected' : '' }} >Bold</option>
                                                                    <option value="italic" {{ ( $restaurant->app_theme_font_style_1 == 'italic') ? 'selected' : '' }} >Italic</option>
                                                                    <option value="Underline " {{ ( $restaurant->app_theme_font_style_1 == 'Underline ') ? 'selected' : '' }}>Underline </option>
                                                                    
                                                                </select> 
                                                                
                                                            </div>
                                                            <div class="col">

                                                               
                                                                <select name="app_theme_font_style_2" class="form-control" id="app_theme_font_style_2">
                                                                    <option value="">Select</option>
                                                                    <option value="bold" {{ ( $restaurant->app_theme_font_style_2 == 'bold') ? 'selected' : '' }} >Bold</option>
                                                                    <option value="italic" {{ ( $restaurant->app_theme_font_style_2 == 'italic') ? 'selected' : '' }} >Italic</option>
                                                                    <option value="Underline " {{ ( $restaurant->app_theme_font_style_2 == 'Underline ') ? 'selected' : '' }}>Underline </option>
                                                                    
                                                                </select>
                                                            </div>
                                                            <div class="col">
                                                                <select name="app_theme_font_style_3" class="form-control" id="app_theme_font_style_3">
                                                                    <option value="">Select</option>
                                                                    <option value="bold" {{ ( $restaurant->app_theme_font_style_3 == 'bold') ? 'selected' : '' }} >Bold</option>
                                                                    <option value="italic" {{ ( $restaurant->app_theme_font_style_3 == 'italic') ? 'selected' : '' }} >Italic</option>
                                                                    <option value="Underline " {{ ( $restaurant->app_theme_font_style_3 == 'Underline ') ? 'selected' : '' }}>Underline </option>
                                                                    
                                                               </select>  
                                                            </div>
                                                            <div class="col">
                                                                 <select name="app_theme_font_style_4" class="form-control" id="app_theme_font_style_4">
                                                                    <option value="">Select</option>
                                                                    <option value="bold" {{ ( $restaurant->app_theme_font_style_4 == 'bold') ? 'selected' : '' }} >Bold</option>
                                                                    <option value="italic" {{ ( $restaurant->app_theme_font_style_4 == 'italic') ? 'selected' : '' }} >Italic</option>
                                                                    <option value="Underline " {{ ( $restaurant->app_theme_font_style_4 == 'Underline ') ? 'selected' : '' }}>Underline </option>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                       
                                                       
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
     <div class="modal fade" id="exampleModalCenter">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Font</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="fontErrorMessage"></div>
                <form method="POST" id="add_font" action="javascript:void(0)" enctype="multipart/form-data" files="true">
                    <input type="hidden" name="restaurant_id" value="{{ $restaurant->restaurant_id }}"/>
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-md-12">Name</label>
                            <div class="col-md-12 error_message_parent">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Font Name" />
                                <span id="errorMessage"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                        <input type="submit" name="submit" value="Add Font" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div> 
    <!-- Select Texture Image Start -->
    <div class="modal fade" id="select_texture">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Texture</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="fontErrorMessage"></div>
                <form method="POST" id="add_font" action="javascript:void(0)" enctype="multipart/form-data" files="true">
                    <input type="hidden" name="restaurant_id" value="{{ $restaurant->restaurant_id }}"/>
                    <div class="modal-body">
                        <div class=" col-md-12">
                            <div class="card">
                                <div class="card-body"> 
                                @if(!empty($texture_array))
                                    <a href="javascript::void()" class="change_texture_image" data-texture_id="0">
                                    <div class="pip menu_image">
                                    <img class="imageThumb" src="../{{ config('images.texture_url') . 'white_texture.jpg'}}">
                                    </div>
                                    </a>
                                    @foreach($texture_array as $texture_list)
                                    <a href="javascript::void()" class="change_texture_image" data-image_src="../{{ config('images.texture_url') . $texture_list->image}}" data-texture_id="{{$texture_list->id}}" data-image_name="{{$texture_list->image}}">
                                        <div class="pip menu_image">
                                            <img class="imageThumb" src="../{{ config('images.texture_url') . $texture_list->image}}"><br>
                                        </div>
                                    </a>
                                  @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                       
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                        <input type="submit" name="submit" value="Add Font" class="btn btn-primary">
                    </div> -->
                </form>
            </div>
        </div>
    </div>
    <!-- Select Texture Image End -->
    <!--**********************************
        Content body end
    ***********************************-->

    @include('theme.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.js"></script>
    <script type="text/javascript">
    $(document).ready(function (e){ 

        function custom_template(obj){
            var data = $(obj.element).data();
            var text = $(obj.element).text();
            if(data && data['img_src']){
                img_src = data['img_src'];
                template = $("<div><img src=\"" + img_src + "\" style=\"width:100%;height:150px;\"/><p style=\"font-weight: 700;font-size:14pt;text-align:center;\">" + text + "</p></div>");
                return template;
            }
        }
        var options = {
            'templateSelection': custom_template,
            'templateResult': custom_template,
        }
        $('#texture_image').select2(options);
        $('.select2-container--default .select2-selection--single').css({'height': '220px'});



        var readURL = function(input) {
            var name =input.name;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    if(name == "restaurant_logo"){
                        $('.logo_img').attr('src', e.target.result);
                    }else{
                        $('.banner_img').attr('src', e.target.result);
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".file-upload").on('change', function() {
            readURL(this);
        });
        // $(".upload-button").on('click', function() {
        //     $(".file-upload").click();
        // });
        $("#restaurant_cover_image").on('click', function() {
            readURL(this);
        });
        $('#errorMessage').html(" ");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#update_restaurant_profile').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            // console.log(formData);
            $.ajax({
                type:'POST',
                url: "{{ url('restaurant_profile')}}",
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
                                $('#'+key1).parent('.error_message_parent').find('#errorMessage').html(value1);
                            });
                        }
                        else if(key == 'errors') 
                        {
                            var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> '+ value +'\</div>';

                            $('.errorMessage').html(html);

                            location.reload(true);
                        }
                        else if(key == 'success')
                        {
                            var html = '<div class="alert alert-success background-success">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Success!</strong> '+ value +'\</div>';

                            $('.errorMessage').html(html);

                            window.location.href = '<?php echo url('restaurant-detail/'.$restaurant->restaurant_id);?>';
                        }
                    });
                },
                error: function(data){
                    var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> Error while updating data\</div>';

                    $('.errorMessage').html(html);

                    // location.reload(true);
                }
            });
        });
        // Add Main Category
        $('#add_font').submit(function(e) {

            e.preventDefault();
            var formData = new FormData(this);
            //console.log(formData); return false;
            $.ajax({
                type:'POST',
                url: "{{ url('add_font')}}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(data){

                    $.each(data, function(key, value) 
                    {                    
                        if(key == 'error'){
                            $.each(value, function(key1, value1){
                                $('#'+key1).addClass('is-invalid');
                                $("[name="+key1+"]").parent('.error_message_parent').find('#errorMessage').html(value1);
                            });
                        }
                        else if(key == 'errors'){
                            var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> '+ value +'\</div>';

                            $('.fontErrorMessage').html(html);
                        }
                        else if(key == 'success'){
                            var html = '<div class="alert alert-success background-success">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Success!</strong> '+ value +'\</div>';

                            $('.fontErrorMessage').html(html);
                        }
                        else if(key == 'font_list'){ 
                            $("#exampleModalCenter .close").click();
                            $('#add_font input[type=text]').val('');
                            $font_list = value;
                            $('#app_theme_font_type_1').html("<option value=''>Select</option>");
                            $('#app_theme_font_type_2').html("<option value=''>Select</option>");
                            $('#app_theme_font_type_3').html("<option value=''>Select</option>");
                            $('#app_theme_font_type_4').html("<option value=''>Select</option>");


                            $.each($font_list, function(key1, value1){
                                $('#app_theme_font_type_1').append("<option value='"+value1['id']+"'> "+value1['name']+" </option>");
                                $('#app_theme_font_type_2').append("<option value='"+value1['id']+"'> "+value1['name']+" </option>");
                                $('#app_theme_font_type_3').append("<option value='"+value1['id']+"'> "+value1['name']+" </option>");
                                $('#app_theme_font_type_4').append("<option value='"+value1['id']+"'> "+value1['name']+" </option>");
                            });
                        }
                        else if (key == 'already_exist'){
                            $('#name').addClass('is-invalid');
                            $("[name=name]").parent('.error_message_parent').find('#errorMessage').html(value);
                        }
                    });
                },
                error: function(data){

                     var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> Error while adding data\</div>';

                    $('.fontErrorMessage').html(html);
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

        // Select texture image Start 
         $(".change_texture_image").on('click', function() { 
            var texture_id=$(this).attr("data-texture_id");
            if(texture_id =='0'){
              $('#add_texture_image').html('');
              $("#texture_id").val('');
              $("#select_texture").modal('hide');
            }else{
                var texture_image='';
                var texture_id=$(this).attr("data-texture_id");
                var texture_image_name=$(this).attr("data-image_name");
                var image_src=$(this).attr("data-image_src");
                texture_image += '<div class="pip menu_image">';
                texture_image += '<img class="imageThumb" src="'+image_src+'">';
                texture_image +='</div>';
                $("#texture_id").val(texture_id);
                $('#add_texture_image').html(texture_image);
                $("#select_texture").modal('hide');
            }
            
        });

    });
    </script>