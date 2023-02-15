@include('user_app.theme.header')
@include('user_app.theme.sidebar', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details] )

<?php 
use App\Models\TagModel;
?>

    <!-- product details -->
    <div class="product-details app-pages app-section product-details-main">
        <div class="container">
            <div class="entry">
                <div class="row">
                    <div id="choose1" class="col s12">
                        <img src="../{{ config('images.menu_url') .$restaurant_details->restaurant_id.'/'. $menu_details->menu_image }}" alt="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="details  col s6">
                    <h5 class="main_color"> {{ $menu_details->name }} </h5>
                    <br/>
                    <div class="likedislikerate">
                        <a href="{{ url('like_menu') }}/{{ $menu_details->menu_id }}">
                            <i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true" ></i>&nbsp;
                        </a>{{ $menu_details->total_like }} &nbsp;&nbsp;&nbsp;
                        <a href="{{ url('unlike_menu') }}/{{ $menu_details->menu_id }}">
                            <i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>&nbsp;
                        </a>{{ $menu_details->total_dislike }}
                    </div>
                    <br/>
                </div>
                <div class="price price-new col s6">
                    <h4>&nbsp;$ {{ $menu_details->price }} </h4>

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
                                        <a href="{{ url('like_menu') }}/{{ $menu_details->menu_id }}">
                                            <i class="fa fa-thumbs-o-up thumbs_icon_big" aria-hidden="true" ></i>&nbsp;
                                        </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="{{ url('unlike_menu') }}/{{ $menu_details->menu_id }}">
                                            <i class="fa fa-thumbs-o-down thumbs_down_big_icon" aria-hidden="true"></i>&nbsp;
                                        </a>
                                    </div>
                                    <br/>
                                </div>
                            </div>
                            <div class="post-review">
                                <h6>Post Review</h6>
                                <form action="#">
                                    <input type="text" placeholder="Name" />
                                    <input type="email" placeholder="Email" />
                                    <textarea cols="20" rows="10" placeholder="Comment"></textarea>
                                    <button class="button">Submit</button>
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

<script>

$(document).ready(function (e) {

    // CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Add Category
    $('#add_category').submit(function(e) {

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: "{{ url('add_category')}}",
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
});
</script>
        