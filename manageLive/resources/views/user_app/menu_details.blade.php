@include('user_app.theme.header')
@include('user_app.theme.sidebar', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details] )

<?php 
use App\Models\TagModel;
use App\Models\MenuModel;

$user_id   = "";
$full_name = "";
$email     = "";

if (Auth::user() !== NULL) 
{
    $user_id    = Auth::user()->id;
    $first_name = Auth::user()->first_name;
    $last_name  = Auth::user()->last_name;
    $full_name  = $first_name." ".$last_name;
    $email      = Auth::user()->email;
} 

$menu_like_icon = '<i class="fa fa-thumbs-o-up thumbs_icon_big" aria-hidden="true" ></i>';
$menu_unlike_icon = '<i class="fa fa-thumbs-o-down thumbs_down_big_icon" aria-hidden="true"></i>';

$small_menu_like_icon = '<i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>';
$small_menu_unlike_icon = '<i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>';

if (Auth::user() !== NULL) 
{
    $user_id = Auth::user()->id;

    if ($user_id != "") 
    {
        $user_menu_votes = MenuModel::get_user_menu_vote(
                                                $user_id, 
                                                $restaurant_details->restaurant_id, 
                                                $menu_details->menu_id
                                            );

        if ($user_menu_votes) 
        {
            $user_menu_vote = $user_menu_votes->vote;

            if ($user_menu_vote == "1") 
            {
                $menu_like_icon = '<i class="fa fa-thumbs-up thumbs_icon_big" aria-hidden="true" ></i>';
                $small_menu_like_icon = '<i class="fa fa-thumbs-up thumbs_icon" aria-hidden="true"></i>';
            }
            else if($user_menu_vote == "0")
            {
                $menu_unlike_icon = '<i class="fa fa-thumbs-down thumbs_down_big_icon" aria-hidden="true"></i>';
                $small_menu_unlike_icon = '<i class="fa fa-thumbs-down thumbs_down_icon" aria-hidden="true"></i>';
            }
        }
    }
} 
?>
    <!-- product details -->
    <div class="product-details app-pages app-section product-details-main">
        <div class="container">
            <div class="entry">
                <div class="row">
                    <div id="choose1" class="col s12">
                        @if($menu_details->menu_image != "")
                            <img src="../{{ config('images.menu_url') .$restaurant_details->restaurant_id.'/'. $menu_details->menu_image }}" alt="">
                        @else
                            <img src="../{{ config('images.menu_url') }}not_found.png" alt="" />
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="details col s12">
                    <h5 class="main_color"> {{ $menu_details->name }} </h5>
                    <div class="col s12">
                        <?php 
                        $tag_icon = "";
                        if ($menu_details->tag_id != "") 
                        {
                            $tag_details = TagModel::get_multiple_tag_details($menu_details->tag_id);

                            if ($tag_details) 
                            {
                                foreach ($tag_details as $key => $value) 
                                {
                                    $tag_icon .= '<img class="dtl_ctm_icon_2" src="../'.config("images.tag_url") . $value->tag_icon.'" alt="Tag Icon" /> &nbsp;';
                                }
                            }
                        }
                        ?>

                        <div class="dtl_ctm_icon">
                            {!! $tag_icon !!}         
                        </div>
                    </div>
                    <br/>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col s6">
                    <div class="price price-new">
                        <h4>&nbsp; {!! $currency_icon !!} {{ $menu_details->price }} </h4>
                    </div>
                </div>
                <div class="col s6">
                    <div class="likedislikerate">
                        <a href="javascript:void(0)" data-id="{{ $menu_details->menu_id }}" id="like_menu_item">
                            <span id="small_like_icon">{!! $small_menu_like_icon !!}</span>&nbsp;
                        </a><span id="small_like_icon_count">{{ $menu_details->total_like }}</span> &nbsp;&nbsp;&nbsp;
                        <a href="javascript:void(0)" data-id="{{ $menu_details->menu_id }}" id="unlike_menu_item">
                            <span id="small_unlike_icon">{!! $small_menu_unlike_icon !!}</span>&nbsp;
                        </a><span id="small_unlike_icon_count">{{ $menu_details->total_dislike }}</span>
                    </div>
                </div>  
            </div>
            <div class="desc-review">
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs tabs-new">
                            <li class="tab col s6">
                                <a href="#description">Details</a>
                            </li>
                            <li class="tab col s6">
                                <a href="#review">Review</a>
                            </li>
                        </ul>
                    </div>

                    <div id="description" class="col s12">
                        <p> {{ $menu_details->description }} </p>
                        <table class="table ms-profile-information">
                            <tbody>
                                <tr>
                                    <th scope="row">Ingredients</th>
                                    <td> {{ $menu_details->ingredients }} </td>
                                </tr>
                                <tr>
                                    <th scope="row">Allergies</th>
                                    <td> {{ $menu_details->allergies }} </td>
                                </tr>
                                <tr>
                                    <th scope="row">Calories</th>
                                    <td> {{ $menu_details->calories }} cal</td>
                                </tr>
                            </tbody>
                        </table>
                        <br/>
                        <div class=" col-md-12">
                            <h5 class="section-title bold section-title-new">Chef's Questions</h5>
                            <hr>
                            <ul>
                    @if(count($chef_questions) > '0')
                        @php($i=1)
                            @foreach($chef_questions as $one_question)
                                <li class="section-title ">
                                    <h6 class="need need_mb15">{{ $i }}. {{ $one_question->question }}</h6>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                        {{ $one_question->option_1 }}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1" >
                                        <label class="form-check-label" for="flexCheckDefault1">
                                        {{ $one_question->option_2 }}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2" >
                                        <label class="form-check-label" for="flexCheckDefault2">
                                            {{ $one_question->option_3 }}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3" >
                                        <label class="form-check-label" for="flexCheckDefault3">
                                            {{ $one_question->option_4 }}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4" >
                                        <label class="form-check-label" for="flexCheckDefault4">
                                            {{ $one_question->option_5 }}
                                        </label>
                                    </div>
                                </li>
                            @php($i++)
                        @endforeach
                    @endif
                            </ul>
                        </div>
                    </div>
                    <div id="review" class="review col s12">
                        <div class="comment">
                            <div class="content">
                                <div class="entry">
                                    <br/>
                                    <div class="likedislikerate">
                                        <a href="javascript:void(0)" data-id="{{ $menu_details->menu_id }}" id="like_menu_item">
                                            <span id="like_icon">{!! $menu_like_icon !!}</span>&nbsp;
                                        </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                        <a href="javascript:void(0)" data-id="{{ $menu_details->menu_id }}" id="unlike_menu_item">
                                            <span id="unlike_icon">{!! $menu_unlike_icon !!}</span>&nbsp;
                                        </a>
                                    </div>
                                    <br/>
                                </div>
                            </div>
                            <div class="post-review">
                                <h6>Post Review</h6>
                                <form method="POST" id="add_menu_review" action="javascript:void(0)">
                                    <div class="errorMessage"></div>
                                    <input type="hidden" name="menu_id" value="{{ $menu_details->menu_id }}" />
                                    <input type="hidden" name="restaurant_id" value="{{ $restaurant_details->restaurant_id }}" />
                                    <input type="text" placeholder="Name" name="name" id="name" value="{{ $full_name }}" />
                                    <input type="email" placeholder="Email" name="email" id="email" value="{{ $email }}" />
                                    <textarea cols="20" rows="10" placeholder="Comment" name="comment" id="comment"></textarea>
                                    <div id="submit_button">
                                        <input type="submit" name="submit" value="Submit" class="button">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end product details -->

@include('user_app.theme.footer')

<script type="text/javascript">

$(document).ready(function (e) {

    // CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var like_count = "{{ $menu_details->total_like }}";
    var unlike_count = "{{ $menu_details->total_dislike }}";

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
                        $menu_like_icon = '<i class="fa fa-thumbs-up thumbs_icon_big" aria-hidden="true" ></i>';
                        $small_menu_like_icon = '<i class="fa fa-thumbs-up thumbs_icon" aria-hidden="true"></i>';

                        var current_like_count   = $(small_like_icon_count).html();
                        var current_unlike_count = $(small_unlike_icon_count).html();

                        $("#small_like_icon").html($small_menu_like_icon);
                        $("#small_like_icon_count").html(parseInt(current_like_count)+1);

                        if (current_unlike_count != 0)
                        {
                            $("#small_unlike_icon_count").html(parseInt(current_unlike_count)-1);
                            $("#small_unlike_icon").html('<i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>');
                        }

                        $("#like_icon").html($menu_like_icon);
                        $("#unlike_icon").html('<i class="fa fa-thumbs-o-down thumbs_down_big_icon" aria-hidden="true"></i>');
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
                        $menu_unlike_icon = '<i class="fa fa-thumbs-down thumbs_down_big_icon" aria-hidden="true"></i>';
                        $small_menu_unlike_icon = '<i class="fa fa-thumbs-down thumbs_down_icon" aria-hidden="true"></i>';

                        var current_like_count   = $(small_like_icon_count).html();
                        var current_unlike_count = $(small_unlike_icon_count).html();

                        $("#small_unlike_icon").html($small_menu_unlike_icon);
                        $("#small_unlike_icon_count").html(parseInt(current_unlike_count)+1);

                        if (current_like_count != 0) 
                        {
                            $("#small_like_icon_count").html(parseInt(current_like_count)-1);
                            $("#small_like_icon").html('<i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>');
                        }

                        $("#unlike_icon").html($menu_unlike_icon);
                        $("#like_icon").html('<i class="fa fa-thumbs-o-up thumbs_icon_big" aria-hidden="true" ></i>');
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

    // Add Menu Review
    $('#add_menu_review').submit(function(e) {

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: "{{ url('add_menu_review')}}",
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
                            $('#'+key1).removeClass('is-valid');
                        });
                    }
                    else if(key == 'errors') 
                    {
                        var html = '<div class="alert alert-danger background-danger">\
                                        <strong>Error!</strong> '+ value +'\
                                    </div>';
                        $('.errorMessage').html(html);
                    }
                    else if(key == 'success')
                    {
                        var html = '<div class="alert alert-success background-success">\
                                        <strong>Success!</strong> '+ value +'\
                                    </div>';
                        $('.errorMessage').html(html);

                        location.reload(true);
                    }
                    else if(key == 'login_error')
                    {
                        var redirect_url = "{{ url('user_login') }}/{{ $restaurant_details->restaurant_id }}";
                        window.location.href = redirect_url;
                    }
                });
            },
            error: function(data){

                var html = '<div class="alert alert-danger background-danger">\
                                <strong>Error!</strong> Error while adding data\
                            </div>';

                $('.errorMessage').html(html);
            }
        });
    });

    $('input').on('keyup', function () { 
        $(this).removeClass('is-invalid').addClass('is-valid');
    });

    $('textarea').on('keyup', function () { 
        $(this).removeClass('is-invalid').addClass('is-valid');
    });
});

</script>

        