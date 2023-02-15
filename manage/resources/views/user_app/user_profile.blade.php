@include('user_app.theme.header') 



@include('user_app.theme.sidebar', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details] )







<?php



$parent_category = ""; 



$main_category   = ""; 



$sub_category    = "";



$category_name   = "";







$currency_icon =$restaurant_details->currency_detail->currency_icon;



$birth_date=date('Y-m-d');







if(!empty(Auth::user()->date_of_birth)){



    $birth_date = Auth::user()->date_of_birth;







}



?>



<style type="text/css"> 



    #errorMessage {



    color: red;



    font-size: 12px;



}



</style> 











    <!-- categories -->



    <div class="menu-list categories-list-ctm app-section app-section-ctm app-section-category">



        <div class="container">



            <?php //echo Request::path(); exit();



?>



            @if(Request::is('my_profile/*'))



          



           <div class="errorMessage">



           </div>



            <div class="row ">



                <div class="details col s12">



                    <h5 class="main_color"></h5>



                    <div class="container">



                        <div class="col s12">



                            <form method="POST" enctype="multipart/form-data" id="update_user_profile" action="javascript:void(0)" files="true">



                                <div class="row">



                                    <div id="my-posts" class="tab-pane fade active show">



                                        <div class="my-post-content pt-3">



                                            <div class="profile-personal-info edit_profile_main">



                                               <div class=" form-group">



                                                    <div class="col-md-2">



                                                        <label id="custom-label">First Name</label>



                                                    </div>



                                                    <div class="col-md-10 error_message_parent">



                                                        <input type="text" name="first_name" id="first_name" class="form-control" value="{{Auth::user()->first_name}}" maxlength="50" />



                                                        <span id="errorMessage"></span>



                                                    </div>



                                                </div>



                                                <div class=" form-group">



                                                    <div class="col-md-2">



                                                        <label id="custom-label">Last Name</label>



                                                    </div>



                                                    <div class="col-md-10 error_message_parent">



                                                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{Auth::user()->last_name }}" maxlength="50" />



                                                        <span id="errorMessage"></span>



                                                    </div>



                                                </div>



                                                <div class=" form-group">



                                                    <div class="col-md-2">



                                                        <label id="custom-label">Email</label>



                                                    </div>



                                                    <div class="col-md-10 error_message_parent">



                                                        <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}"/>



                                                        <span id="errorMessage"></span>



                                                    </div>



                                                </div> 



                                                <!-- <div class="row form-group">



                                                    <div class="col-md-2">



                                                        <label id="custom-label">Date of Birth</label>



                                                    </div>



                                                    <div class="col-md-10 error_message_parent">



                                                        <input placeholder="Date Of Birth" type="text" value="" name="date_of_birth" id="date_of_birth"  value="{{Auth::user()->date_of_birth}}">



                    



                                                        <span id="errorMessage"></span>



                                                    </div>



                                                </div> --> 



                                                <div class="form-group">



                                                    <div class="col-md-2">



                                                        <label id="custom-label">Gender </label>



                                                    </div>



                                                    <div class="col-md-10 error_message_parent">



                                                        <select name="gender" id="gender" placeholder="Gender">



                                                            <option value="">Select Gender</option>



                                                            <option value="0" {{ ( Auth::user()->gender == '0') ? 'selected' : '' }} >Male</option>



                                                            <option value="1" {{ ( Auth::user()->gender == '1') ? 'selected' : '' }} >Female</option>



                                                            <option value="2" {{ ( Auth::user()->gender == '2') ? 'selected' : '' }} >Other</option>



                                                        </select>



                                                        <span id="errorMessage"></span>



                                                    </div>



                                                </div>



                                                <input class="btn btn-primary btn-block new_btn_ctm" type="submit" name="save" value="Save" id="save">



                                            </div> 



                                        </div>



                                    </div>



                                </div>



                            </form>



                        </div> 



                        <br/>



                    </div>



                </div>



            </div>



            <div class="row">



                <div class="details col s12">



                    <h5 class="main_color"></h5>



                    <div class="col s12">



                        



                    </div>



                    <br/>



                </div>



            </div>



            @endif



            @if(Request::is('allergies/*'))



               <div class="top_common">



                    <p class="title_common">Common</p>



                    @if(!empty($admin_allergy))



                        @foreach($admin_allergy as $adminAllergy)



                            @if(!empty($user_allergy_id_array))







                                @if (in_array($adminAllergy->allergy_id, $user_allergy_id_array))



                                    <a data-tag_type="allergy" data-tag_id="{{$adminAllergy->allergy_id}}" href="javascript::void(0);" class="admin_tag_click" data-click="1" data-tag_name="{{$adminAllergy->allergy_name}}"><span class="admin_tag is_used">{{$adminAllergy->allergy_name}}</span>&nbsp;</a>



                                @else



                                    <a data-tag_type="allergy" data-tag_id="{{$adminAllergy->allergy_id}}" href="javascript::void(0);" class="admin_tag_click " data-click="0" data-tag_name="{{$adminAllergy->allergy_name}}"><span class="admin_tag">{{$adminAllergy->allergy_name}}</span>&nbsp;</a>



                                @endif







                            @else



                            <a data-tag_type="allergy" data-tag_id="{{$adminAllergy->allergy_id}}" href="javascript::void(0);" class="admin_tag_click" data-click="0" data-tag_name="{{$adminAllergy->allergy_name}}"><span class="admin_tag">{{$adminAllergy->allergy_name}}</span>&nbsp;</a>



                            @endif



                            



                        @endforeach 



                    @endif



                </div>



               



                <div class="details col s12">



                    <h5 class="main_color"></h5>



                    <div class="col s12">



                        <form method="POST" id="update_allergy_and_tag"action="javascript:void(0)" files="true" onkeypress="return event.keyCode != 13;">



                            <input type="hidden" name="type" value="allergy">



                            <div class="errorMessage"></div>



                            <div class="keyword_main">



                                <div id="my-posts" class="tab-pane fade active show">



                                    <div class="my-post-content pt-3">



                                        <div class="profile-personal-info">



                                            <p class="title_common">By Keyword</p>



                                           <div class=" form-group">



                                                <div class="col-md-2">



                                                    <label id="custom-label">Enter key word</label>



                                                </div>



                                                <div class="col-md-5 error_message_parent">



                                                    <input type="text" name="allergy_name" id="allergy_name" class="form-control text_change" maxlength="50"  autocomplete="off" />



                                                    <span id="errorMessage"></span>



                                                </div>



                                                 <div class="col-md-5">



                                                         <a data-tag_type="allergy" class="btn btn-primary btn-block new_btn_ctm" id="add_btn" style="width: 100%; margin-bottom: 10px; display: none;"> Add</a>



                                                    </div>



                                            </div>



                                            @if(!empty($user_allergy) && count($user_allergy) > 0)



                                            



                                                @foreach($user_allergy as $userAllergy)



                                                    <div class="tag_div">



                                                        @if(!empty($userAllergy->allergy_id))



                                                            <a data-tag_type="allergy" data-tag_name="{{$userAllergy->allergy_detail->allergy_name}}" href="javascript::void(0);" data-allergy_id="{{$userAllergy->id}}" class="remove_tag"><span class="admin_tag">{{$userAllergy->allergy_detail->allergy_name}} <i class="fa fa-times"></i> </span></a><br>



                                                            <input type="hidden" name="allergy_name[]" value="{{$userAllergy->allergy_name}}">



                                                        @else



                                                        <a data-tag_type="allergy" data-tag_name="{{$userAllergy->allergy_name}}" href="javascript::void(0);" data-allergy_id="{{$userAllergy->id}}" class="remove_tag"><span class="admin_tag">{{$userAllergy->allergy_name}} <i class="fa fa-times"></i> </span></a><br>



                                                            <input type="hidden" name="allergy_name[]" value="{{$userAllergy->allergy_name}}">



                                                        @endif



                                                    </div>



                                                @endforeach 



                                            @else



                                                <div class="tag_div"></div>



                                            @endif



                                            



                                            <input class="btn btn-primary btn-block new_btn_ctm" type="submit" name="save" value="Save" id="save">



                                        </div> 



                                    </div>



                                </div>



                            </div>



                        </form>



                    </div> 



                    <br/>



                </div>



            @endif



            @if(Request::is('tags/*'))



                <div class="top_common">



    <p class="title_common">Common</p>



    @if(!empty($admin_tag))



    @foreach($admin_tag as $adminTag)



    @if(!empty($tag_id_array))







    @if (in_array($adminTag->tag_id, $tag_id_array))



    <a data-tag_type="tag" data-tag_id="{{$adminTag->tag_id}}" data-tag_name="{{$adminTag->tag_name}}" href="javascript::void(0);" class="admin_tag_click " data-click="1"><span class="admin_tag is_used">{{$adminTag->tag_name}}</span>&nbsp;</a>



    @else



    <a data-tag_type="tag" data-tag_id="{{$adminTag->tag_id}}" data-tag_name="{{$adminTag->tag_name}}" href="javascript::void(0);" class="admin_tag_click" data-click="0"><span class="admin_tag">{{$adminTag->tag_name}}</span>&nbsp;</a>



    @endif



    @else



    <a data-tag_type="tag" data-tag_id="{{$adminTag->tag_id}}" data-tag_name="{{$adminTag->tag_name}}" href="javascript::void(0);" class="admin_tag_click" data-click="0"><span class="admin_tag">{{$adminTag->tag_name}}</span>&nbsp;</a>



    @endif



    @endforeach



    @endif



</div>







<div class="details col s12">



    <h5 class="main_color"></h5>



    <div class="col s12">



        <form method="POST" id="update_allergy_and_tag"action="javascript:void(0)" files="true" onkeypress="return event.keyCode != 13;">



            <input type="hidden" name="type" value="tag">



            <div class="errorMessage"></div>



            <div class="keyword_main">



                <div id="my-posts" class="tab-pane fade active show">



                        <div class="my-post-content pt-3">



                            <div class="profile-personal-info">



                             <p class="title_common">By Keyword</p>



                            <div class=" form-group">



                                <div class="col-md-2">



                                    <label id="custom-label">Enter key word</label>



                                </div>



                                <div class="col-md-5 error_message_parent">



                                    <input type="text" name="allergy_name" id="allergy_name" class="form-control text_change" maxlength="50"  autocomplete="off" />



                                    <span id="errorMessage"></span>



                                </div>



                                <div class="col-md-5">



                                   <a data-tag_type="tag" class="btn btn-primary btn-block new_btn_ctm" id="add_btn" style="width: 100%; margin-bottom: 10px; display: none;"> Add</a>



                               </div>



                           </div>











                            @if(!empty($user_tag) && count($user_tag) > 0)



                            @foreach($user_tag as $userTag)



                            <div class="tag_div">



                               @if(!empty($userTag->tag_id))



                               <a data-tag_type="tag" data-tag_name="{{$userTag->tag_detail->tag_name}}" href="javascript::void(0);" data-tag_id="{{$userTag->id}}" class="remove_tag"><span class="admin_tag">{{$userTag->tag_detail->tag_name}} <i class="fa fa-times"></i> </span></a><br>



                               <input type="hidden" name="tag_name[]" value="{{$userTag->tag_name}}">



                               @else



                               <a data-tag_type="tag" data-tag_name="{{$userTag->tag_name}}" href="javascript::void(0);" data-tag_id="{{$userTag->id}}" class="remove_tag"><span class="admin_tag">{{$userTag->tag_name}} <i class="fa fa-times"></i> </span></a><br>



                               <input type="hidden" name="tag_name[]" value="{{$userTag->tag_name}}">



                               @endif



                           </div>



                           @endforeach 



                           @else



                           <div class="tag_div"></div>



                           @endif







                           <input class="btn btn-primary btn-block" type="submit" name="save" value="Save" id="save">



                       </div> 



                   </div>



               </div>



               <!-- </div> -->



           </div>



       </form>



       <div class="row">



       </div>



   </div> 



   <br/>



</div>















            @endif



            @if(Request::is('favourite/*')) 



            <div class="row">



                <ul class="tabs">



                    <li class="tab"><a href="#t1">Restaurant</a></li>



                    <li class="tab"><a href="#t2" id="all_items_tab">Menu Item</a></li>



                   



                </ul>



                <div id="t1">



                    <div class="app-title app_title_fav">



                        <p class="title_common">Favourite Restaurant</p>



                    </div> 



                    <div class="row mb0">



                        @if(!empty($fav_restaurant_list))



                            <div class="fav_restaurant_list_main">



                                <div class="col-md-12">



                                    <div class="filter">



                                        <div class="col-md-12">



                                            @foreach($fav_restaurant_list as $favRestaurantList)



                                            <?php //echo "<pre>"; print_r($favRestaurantList->restaurant_detail->restaurant_logo); echo "</pre>"; exit(); ?>



                                            <div class="entry">



                                                



                                                    @if(!empty($favRestaurantList->restaurant_detail->restaurant_logo)) 



                                                        



                                                         <img src="../{{ config('images.restaurant_url') .$favRestaurantList->restaurant_detail->restaurant_id.'/'. $favRestaurantList->restaurant_detail->restaurant_logo }}" alt="Restaurant logo">



                                                    @else



                                                        <img src="../{{  config('images.default_image_url')}}" alt="Restaurant logo" />



                                                    @endif 



                                                    <div class="content content_new">



                                                        <div class="price price_cate">



                                                            <p> {{ $favRestaurantList->restaurant_detail->restaurant_name }} </p>



                                                        </div>



                                                        



                                                    </div>



                                            </div>



                                            @endforeach



                                        </div>



                                    </div>



                                    <div id="tag_filters">



                                        <div class="col-md-12">



                                            



                                        </div>



                                    </div>



                                </div>



                            </div>



                        @endif



                    </div>



                </div>



                <div id="t2" class="filter">



                    <div class="app-title app_title_fav_items">



                        <p class="title_common">Favourite Items</p>



                    </div> 



                    <div class="app_fav_items_main">      



                        @if(!empty($fav_menu_list))



                            <div class="row">



                                <div class="col-md-12">



                                    <div class="filter">



                                        <div class="col-md-12">



                                            @foreach($fav_menu_list as $favMenuList)



                                                <?php $menu= $favMenuList->menu_detail;?>



                                            <div class="entry">



                                                <a href="{{ url('menu-details') }}/{{ $menu->menu_id }}">



                                                    @if(!empty($menu->menu_image    ))



                                                        <?php $menu_image_name=



                                                        $menu->menu_image;?>



                                                        <img src="../{{ config('images.menu_url')  .$menu->restaurant_id.'/'.$menu_image_name}}" alt="Menu image">



                                                    @else



                                                        <img src="../{{  config('images.default_image_url')}}" alt="Menu image" />



                                                    @endif 



                                                    <div class="content content_new">



                                                        <div class="price price_cate">



                                                            <p> {{$favMenuList->restaurant_detail->restaurant_name}} </p>



                                                        </div>



                                                        <p class="new_dis">{{ $menu->name }}</p>



                                                        



                                                        



                                                    </div>



                                                </a>



                                            </div>



                                            @endforeach



                                        </div>



                                    </div>



                                    <div id="tag_filters">



                                        <div class="col-md-12">



                                            



                                        </div>



                                    </div>



                                </div>



                            </div>



                        @endif



                    </div>



                </div>



            </div>



            @endif



        </div>



    </div>



    <!-- end categories -->







@include('user_app.theme.footer')







<script type="text/javascript">



$(document).ready(function (e) {



    var birth_date="{{$birth_date}}";



    



    // CSRF Token



    $.ajaxSetup({



        headers: {



            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')



        }



    });







    // var main_url = '{{ url("menu-details") }}';



    // var menu_url = '{{ config("images.menu_url") }}';



    // var tag_url = '{{ config("images.tag_url") }}';



    // var like_url = "{{ url('like_menu') }}";



    // var dislike_url = "{{ url('unlike_menu') }}";



   // Like Menu



    $('body').delegate('#like_menu_item','click', function(){







        var restaurant_id = "{{ $restaurant_details->restaurant_id }}";



        var menu_id       = $(this).attr("data-id");







        $.ajax({



            type: "POST",



            url: "{{ url('like_menu_item') }}", 



            data:  {menu_id:menu_id},



            dataType: "json",



            success: function(data){



                



                $.each(data, function(key, value) 



                {



                    // console.log(key);



                    // console.log(value);







                    if(key == 'success')



                    {



                        window.location.reload();



                    }



                    else if(key == 'login_error')



                    {



                        var redirect_url = "{{ url('user_login') }}/{{ $restaurant_details->restaurant_id }}";







                        window.location.href = redirect_url;



                    }



                });



            }



        });



    });







    // UnLike Menu



    $('body').delegate('#unlike_menu_item','click', function(){







        var restaurant_id = "{{ $restaurant_details->restaurant_id }}";



        var menu_id       = $(this).attr("data-id");







        $.ajax({



            type: "POST",



            url: "{{ url('unlike_menu_item') }}", 



            data:  {menu_id:menu_id},



            dataType: "json",



            success: function(data){



                



                $.each(data, function(key, value) 



                {



                    // console.log(key);



                    // console.log(value);







                    if(key == 'success')



                    {



                        window.location.reload();



                    }



                    else if(key == 'login_error')



                    {



                        var redirect_url = "{{ url('user_login') }}/{{ $restaurant_details->restaurant_id }}";







                        window.location.href = redirect_url;



                    }



                });



            }



        });



    });







    // favourite & UnFavourite Menu



    $('body').delegate('#fav_menu_item','click', function(){



        var restaurant_id = "{{ $restaurant_details->restaurant_id }}";



        var menu_id       = $(this).attr("data-id");



        $.ajax({



            type: "POST",



            url: "{{ url('fav_menu_item') }}", 



            data:  {menu_id:menu_id},



            dataType: "json",



            success: function(data){



                



                $.each(data, function(key, value) 



                {



                    if(key == 'success')



                    {



                        window.location.reload();



                    }



                    else if(key == 'login_error')



                    {



                        var redirect_url = "{{ url('user_login') }}/{{ $restaurant_details->restaurant_id }}";







                        window.location.href = redirect_url;



                    }



                });



            }



        });



    });



    // update user profile



    $('#update_user_profile').submit(function(e) {



        e.preventDefault();



        var formData = new FormData(this);



        $.ajax({



            type:'POST',



            url: "{{ url('update_user_profile')}}",



            data: formData,



            cache:false,



            contentType: false,   



            processData: false,



            success: function(data){



                $.each(data, function(key, value){                    



                    if(key == 'error'){



                        $.each(value, function(key1, value1){



                            $('#'+key1).addClass('is-invalid');



                            $('#'+key1).parent('.error_message_parent').find('#errorMessage').html(value1);



                        });



                    }



                    else if(key == 'errors'){



                        var html = '<div class="alert alert-danger background-danger"><strong>Error!</strong> '+ value +'</div>';



                        $('.errorMessage').html(html);



                        location.reload(true);



                    }



                    else if(key == 'success')



                    {



                        var html = '<div class="alert alert-success background-success"><strong>Success!</strong> '+ value +'</div>';



                        $('.errorMessage').html(html);



                        location.reload(true);







                    }



                });



            },



            error: function(data){



                var html = '<div class="alert alert-danger background-danger"><strong>Error!</strong> Error while updating data</div>';



                $('.errorMessage').html(html);



                //location.reload(true);



            }



        });



        



    });



    $('input').on('keyup', function () { 



        $(this).removeClass('is-invalid').addClass('is-valid');



    });



    // M.Datepicker.init(document.querySelectorAll('.datepicker'), {



    //     onClose: function() {



    //         $('.datepicker + label').addClass('active');



    //     }



    // });



    // $('.datepicker + label').addClass('active');



    // var from_$input = $('#date_of_birth').pickadate();



    // from_picker = from_$input.pickadate('picker');



    $('#date_of_birth').pickadate({



        today: new Date(birth_date),



          



                



    });



    $('#update_allergy_and_tag').submit(function(e) {



        $('.errorMessage').html('');



        e.preventDefault();



        var formData = new FormData(this);



        $.ajax({



            type:'POST',



            url: "{{ url('update_allergy_and_tag')}}",



            data: formData,



            cache:false,



            contentType: false,   



            processData: false,



            success: function(data){



                $.each(data, function(key, value){                    



                    if(key == 'error'){



                        $.each(value, function(key1, value1){



                            $('#'+key1).addClass('is-invalid');



                            $('#'+key1).parent('.error_message_parent').find('#errorMessage').html(value1);



                        });



                    }



                    else if(key == 'required_tag'){



                        var html = '<div class="alert alert-danger background-danger"><strong>Error! </strong>' +value+'</div>';



                        $('.errorMessage').html(html);



                        //location.reload(true);



                    }

                    else if(key == 'errors'){

                        var html = '<div class="alert alert-danger background-danger"><strong>Error!</strong> '+ value +'</div>';

                        $('.errorMessage').html(html);



                        location.reload(true);

                    }

                    else if(key == 'success'){

                        var html = '<div class="alert alert-success background-success"><strong>Success!</strong> '+ value +'</div>';

                        $('.errorMessage').html(html);

                        location.reload(true);

                    }



                });



            },



            error: function(data){



                var html = '<div class="alert alert-danger background-danger"><strong>Error!</strong> Error while updating data</div>';



                $('.errorMessage').html(html);



                //location.reload(true);



            }



        });



        



    });



    $('.text_change').keyup(function(){



       var name=$(this).val().trim();



        if(name !=='') {



           $("#add_btn").show();



        }else{



            $("#add_btn").hide();



        }



      



  });



  



  $('body').delegate('#add_btn','click', function(){



        var tag_type=$(this).attr('data-tag_type');



        if(tag_type =='tag'){



            var tagType='new_tag_name[]';



        }else{



            var tagType='new_allergy_name[]';



        }



        var tag_name = $(".text_change").val(); 



        var name=tag_name.trim();



        if(name !=='') {



            tag_html='';



            tag_html+='<div class="tag_div">';



            tag_html+='<a data-tag_type="'+tag_type+'" data-tag_name="'+tag_name+'" href="javascript::void(0);" data-tag_id="0" class="remove_tag">';



            tag_html+='<span class="admin_tag">'+tag_name+'<i class="fa fa-times"></i></span>';



            tag_html+='</a>';



            tag_html+='<input type="hidden" value="'+tag_name+'" name="'+tagType+'">';



            tag_html+='</div>';



            $('.tag_div:last').after(tag_html);



            $(".text_change").val(''); 



            $("#add_btn").hide();



        }



        $("#add_btn").hide();



  });



  



 



  $('body').delegate('.admin_tag_click','click', function(){



    var tag_name = $(this).attr("data-tag_name");



    var tag_id = $(this).attr("data-tag_id"); 



    var tag_type=$(this).attr('data-tag_type');



    click= $(this).attr("data-click");



    if(tag_type =='tag'){



            var tagType='new_tag_name[]';



        }else{



            var tagType='new_allergy_name[]';



        }



    if(click ==0){



        tag_html='';



        tag_html+='<div class="tag_div">';



        tag_html+='<a data-tag_type="'+tag_type+'" href="javascript::void(0);" data-tag_id="0" class="remove_tag" data-tag_name="'+tag_name+'">';



        tag_html+='<span class="admin_tag">'+tag_name+'<i class="fa fa-times"></i></span>';



        tag_html+='</a>';



        tag_html+='<input type="hidden" value="'+tag_id+'" name="'+tagType+'">';



        tag_html+='</div>';



        $('.tag_div:last').after(tag_html);



        $(this).attr('data-click','1');



        $(this).children('span').addClass('is_used');



    }







     



  });



  $('body').delegate('.remove_tag','click', function(){



    



    var tag_type=$(this).attr('data-tag_type');



    var remove_tag_name=$(this).attr('data-tag_name');



   //alert(remove_tag_name);



    if(tag_type =='tag'){



        var tag_id= $(this).attr("data-tag_id");



        var tagType='remove_tag_id[]';



    }else{



        var tag_id= $(this).attr("data-allergy_id"); 



        var tagType='remove_allergy_id[]';



    }







    if(tag_id > 0 && tag_id !='0'){



        tag_remove='';



        tag_remove+='<input type="hidden" value="'+tag_id+'" name="'+tagType+'">';



        $('#save').before(tag_remove);



        var admin_tag=$('.admin_tag_click[data-tag_name="'+remove_tag_name+'"]');



        admin_tag.attr("data-click",0);



        admin_tag.children('span').removeClass('is_used');



        $(this).parent('.tag_div').remove();







       if($('.remove_tag').length ==0){



        $("#save").before('<div class="tag_div"></div>')



       }



        // // var admin_tag=$('.admin_tag_click').find('[data-tag_name="'+remove_tag_name+'"]');



        // console.log(admin_tag.children('span'));



        



    }else{



        var admin_tag=$('.admin_tag_click[data-tag_name="'+remove_tag_name+'"]');



        admin_tag.attr("data-click",0);



        admin_tag.children('span').removeClass('is_used');



        $(this).parent('.tag_div').remove();



        



    }







     



  });



  







});



</script>



        