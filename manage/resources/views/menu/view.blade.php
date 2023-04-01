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
    <div class="container-fluid">
        <!-- row -->
        <div class="row page-titles mx-0">
            <div class="col-sm-9 p-md-0">
                <div class="welcome-text">
                    <h4  class="welcome-text-h4">Menu Item Details</h4>
                </div>
            </div>
            <div class="col-sm-3 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <a href="{{ url('menu-update').'/'.$menu_detail->menu_id }}" class="btn btn-primary btn-block" style="color:#fff!important;">Edit</a>
                &nbsp;
                <a data-toggle="modal" data-target="#deleteMenuModal" class="btn btn-danger btn-block" style="color:#fff!important; margin: 0;">Delete</a>
                &nbsp;
                <a href="{{ url('menu') }}/{{ $menu_detail->restaurant_id}}" id="back_button" class="btn btn-info btn-block">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-body">
                        <div id="app">
                            @include('theme.flash-message')

                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
            <div class=" col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="section-title bold">Menu Info</h4>
                        <table class="table ms-profile-information">
                            <tbody>
                                <tr>
                                    <th scope="row">Name</th>
                                    <td>{{ $menu_detail->name }}</td>
                                </tr>
                                <!-- <tr>
                                    <th scope="row">Price</th>
                                    <td>{!! $currency_icon !!} {{ $menu_detail->price }}</td>
                                </tr> -->
                                <tr>
                                    <?php
                                            $priceArray=array();
                                            $priceDescArray=array();
                                            $price_display='';
                                            if(!empty($menu_detail->price)) {
                                                $priceArray=explode(',',$menu_detail->price);
                                                $priceDescArray=explode(',',$menu_detail->price_description);
                                            } 
                                            $i=0;
                                        ?>
                                    <th scope="row">Price</th>
                                    <td>
                                        

                                   @if(!empty($priceArray))
                                     @foreach($priceArray as $price_value)
                                        @if(!empty($priceDescArray[$i]))
                                            {{$priceDescArray[$i]}}-{!! $currency_icon !!}{{$price_value}}
                                        @else
                                            {!! $currency_icon !!}{{$price_value}}
                                        @endif
                                        
                                       
                                    <?php $i++;?>
                                    @endforeach
                                    @endif
                                    </td>   
                                </tr>
                                <tr>
                                    <th scope="row">Parent Category</th>
                                    <td>{{ $parent_category_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Main Category</th>
                                    <td>{{ $main_category_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Sub Category</th>
                                    <td>{{ $sub_category_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Availiblity</th>
                                    <td>
                                        @if($menu_detail->availiblity == '1')
                                            <span class="badge badge-pill badge-success">Available</span>
                                        @elseif($menu_detail->availiblity == '0')
                                            <span class="badge badge-pill badge-warning">Not Available</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">Hide</span>
                                        @endif
                                    </td>
                                </tr> 
                                <tr>
                                    <th scope="row">Ingredients</th>
                                    <td>{{ $menu_detail->ingredients }}</td>
                                </tr> 
                                <tr>
                                    <th scope="row">Allergies</th>
                                    <td>{{ $allergy_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Calories</th>
                                    <td>{{ $menu_detail->calories }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Link</th>
                                    <td>{{$menu_detail->link }}</td>
                                </tr>
                                <tr>
                                <tr>

                                    <th scope="row">Tag</th> 
                                    <td>{{ $tag_name }}</td>
                                </tr>
                           </tbody>
                        </table>
                        <div class="new"> </div>
                    </div>
                </div>
            </div>
            <div class=" col-md-6">
                <div class="card">
                    <div class="card-body"> 
                                   @if(!empty($menu_detail->menu_image))
                                        <!-- <p><b>Display Images</b> </p> -->
                                        <div class="pip menu_image first_image">
                                            <img class="imageThumb" src="../{{ config('images.menu_url') .$menu_detail->restaurant_id.'/'.$menu_detail->menu_image}}"><br>
                                        </div>
                                    @endif
                                    @if(!empty($menu_detail->menu_image_detail) && count($menu_detail->menu_image_detail) >0)
                                        @foreach($menu_detail->menu_image_detail as $menu_image_value)
                                        <div class="pip menu_image">
                                            <img class="imageThumb" src="../{{ config('images.menu_url') .$menu_detail->restaurant_id.'/'. $menu_image_value->image_name}}"><br>
                                        </div>
                                        @endforeach
                                    @endif 
                                    <div class="description_div">
                                    <label><b>Description</b> </label>
                                    <p class="description"><br/>{{ $menu_detail->description }}</p>
                                    </div>
                    </div>
                </div>
            </div>
			{{--          <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="section-title bold">Chef's Questions
                        </h4>
                        <br>
                        <hr/>
                    @if(count($chef_questions) > '0')
                        @php($i=1)
                        @foreach($chef_questions as $one_question)
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <div class="form-group  mb-0">
                                        <div class="row">
                                            <h6 class="col-md-12"><b>{{ $i }}.</b> {{ $one_question->question }}</h6>
                                            <br/>
                                            <label class="radio-inline col-md-4">
                                                <span class="col-md-12">{{ $one_question->option_1 }}</span>
                                            </label>
                                            <label class="radio-inline col-md-4">
                                                <span class="col-md-12">{{ $one_question->option_2 }}</span>
                                            </label>
                                            <label class="radio-inline col-md-4">
                                                <span class="col-md-12">{{ $one_question->option_3 }}</span>
                                            </label>
                                            <label class="radio-inline col-md-4">
                                                <span class="col-md-12">{{ $one_question->option_4 }}</span>
                                            </label>
                                            <label class="radio-inline col-md-4">
                                                <span class="col-md-12">{{ $one_question->option_5 }}</span>
                                            </label>
                                            <br>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                                <div id="cloned_chef_questions"></div>
                            </div>
                        @php($i++)
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>			--}}
            <div class="modal fade" id="exampleModalCenter">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Question</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-row">
                                    <div class="col-sm-12">
                                        <!--input type="text" class="form-control" placeholder="Write here" /-->
                                        <div class="form-group  mb-0">
                                            <div class="row">
                                                <input type="text" class="form-control col-md-12 mt-0 my-3" placeholder="Write own question here" /><br/>
                                                <label class="radio-inline col-md-6"> 
                                                    <input type="text" class="form-control col-md-12" placeholder="Question 1" />
                                                </label>
                                                <label class="radio-inline col-md-6"> 
                                                    <input type="text" class="form-control col-md-12" placeholder="Question 2" />
                                                </label>
                                                <label class="radio-inline col-md-6"> 
                                                    <input type="text" class="form-control col-md-12" placeholder="Question 3" />
                                                </label>
                                                <label class="radio-inline col-md-6"> 
                                                    <input type="text" class="form-control col-md-12" placeholder="Question 4" />
                                                </label>
                                                <label class="radio-inline col-md-6"> 
                                                    <input type="text" class="form-control col-md-12" placeholder="Question 5" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Menu Rating Start -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="section-title bold">Menu Reviews & Ratings</h4>
                        <table id="example5" class="display mb-4 dataTablesCard results">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                        @if(!empty($menu_ratings))
                            @foreach ($menu_ratings as $rating)
                            <?php //echo "<pre>"; print_r($rating->user_detail); echo "</pre>"; exit();?>
                                <tr>

                                    <td> {{!empty($rating->user_detail->first_name) ? $rating->user_detail->first_name :''}} {{!empty($rating->user_detail->last_name) ? $rating->user_detail->last_name :''}}</td>
                                    <td> {{!empty($rating->user_detail->email) ? $rating->user_detail->email :''}} </td>
                                    <td> {{ $rating->review }} </td>
                                    <td> 
                                        @if($rating->vote == "1")
                                            <i class="fa fa-thumbs-o-up thumbs_down_icon" aria-hidden="true"></i>
                                        @elseif($rating->vote == "0")
                                            <i class="fa fa-thumbs-o-down thumbs_icon" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                </tr> 
                            @endforeach
                        @else
                                <tr>
                                    <td>No Data Found</td>
                                    <td></td>
                                </tr>
                        @endif                          
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Menu Rating End -->
        </div>

        <!-- Delete Menu Modal -->
        <div class="modal fade" id="deleteMenuModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-row">
                            <span>Are you sure you want to delete this menu item?</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                        <a href="{{ url('menu-delete').'/'.$menu_detail->menu_id }}" class="btn btn-primary" style="color:#fff!important; margin: 0;">Confirm Delete</a>
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