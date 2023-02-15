@include('user_app.theme.header') 



@include('user_app.theme.sidebar', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details] )







<?php



$parent_category = ""; 



$main_category   = "";



$sub_category    = "";



$category_name   = "";







$currency_icon =$restaurant_details->currency_detail->currency_icon;



$birth_date=date('Y-m-d');







if (Auth::user() !== NULL) 



{



    $id = Auth::user()->id;



    $first_name = Auth::user()->first_name; 



    $last_name = Auth::user()->last_name;



}   



if(!empty(Auth::user()->date_of_birth)){



    $birth_date = Auth::user()->date_of_birth;







}



?>



<!-- categories -->



    <div class="menu-list categories-list-ctm app-section app-section-ctm app-section-category">



       <div class="container">



                <!-- <div class="app-title"> 



            



                </div> -->



                <div class="row">

                  

                    <div class="welcome_text_profile">

                          <img src="{!! asset('theme/user_app/img/logo.png') !!}" align="img" class="logo-img welcome_logo_profile">

                        @if($id != "")



                        <a>Welcome {{ $first_name }} {{ $last_name }}</a>



                        @endif



                    </div>



                </div>



            <div class="profile_menu_new">



                <ul>



                    <li>



                        <i class="fa fa-user"></i>



                        <a href="{{ url('my_profile')}}/{{Auth::User()->id}}">My Profile</a>



                    </li>



                    <li>



                      <i> <img src="../{{ config('images.user_app_image_url').'allergy.png'}}"> </i> 



                        <a href="{{ url('allergies')}}/{{Auth::User()->id}}">Allergies</a>



                    </li>



                    <li>



                        <i class="fa fa-tags"></i>



                        <a href="{{ url('tags')}}/{{Auth::User()->id}}">Tags</a>



                    </li>



                    <li>



                        <i class="fa fa-heart"></i>



                        <a href="{{ url('favourite')}}/{{Auth::User()->id}}">Favorites</a>



                    </li>



                    <!-- <li>



                       <i> <img src="../{{ config('images.user_app_image_url').'banquet.png'}}">  </i>



                        <a href="#">The Feed</a>



                    </li> -->



                </ul>



            </div>



             



            



        </div>



    </div>



    <!-- end categories -->







@include('user_app.theme.footer')







<script type="text/javascript">



$(document).ready(function (e) {



    



});



</script>



        