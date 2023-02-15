@include('theme.header')
<?php 
use App\Models\TagModel;
?>
<!--**********************************
    Header start
***********************************-->
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        {{ $restaurant_name }} - Menus
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
            <div class="col-sm-10"></div>
            <div class="col-sm-2">
                <a href="{{ url('restaurant-detail') }}/{{ $restaurant_id }}" id="back_button" class="btn btn-info btn-block">Back</a>
            </div>
        </div>
        <br>
        <div class="form-head d-flex mb-3 mb-lg-5 align-items-start">
            <div class="mr-auto col-md-7  d-none d-lg-block">
                <div class="welcome-text">
                    <!--h4>Manage Menu</h4-->
                    <a href="{{ url('new_menu/')}}/{{ $restaurant_id }}" class="btn btn-primary btn-block col-sm-12 col-md-4 mt-3" style="color:#fff!important;">Add Menu Item</a>
                </div>
            </div>
            <div class="input-group search-area ml-3 d-inline-flex">
                <input type="text" class="form-control" placeholder="Search here">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="flaticon-381-search-2"></i></span>
                </div>
            </div>
            <div class="dropdown ml-3 d-inline-block">
                <div class="btn btn-outline-primary btn-rounded dropdown-toggle d-flex align-items-center" data-toggle="dropdown">
                    <svg class="mr-3 scale5" width="14" height="14" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0)">
                        <path d="M22.4276 2.856H21.8676V1.428C21.8676 0.56 21.2796 0 20.4396 0C19.5996 0 19.0116 0.56 19.0116 1.428V2.856H9.71557V1.428C9.71557 0.56 9.15557 0 8.28757 0C7.41957 0 6.85957 0.56 6.85957 1.428V2.856H5.57157C2.85557 2.856 0.55957 5.152 0.55957 7.868V23.016C0.55957 25.732 2.85557 28.028 5.57157 28.028H22.4276C25.1436 28.028 27.4396 25.732 27.4396 23.016V7.868C27.4396 5.152 25.1436 2.856 22.4276 2.856ZM5.57157 5.712H22.4276C23.5756 5.712 24.5836 6.72 24.5836 7.868V9.856H3.41557V7.868C3.41557 6.72 4.42357 5.712 5.57157 5.712ZM22.4276 25.144H5.57157C4.42357 25.144 3.41557 24.136 3.41557 22.988V12.712H24.5556V22.988C24.5836 24.136 23.5756 25.144 22.4276 25.144Z" fill="#6742a8"/>
                        </g>
                        <defs>
                        <clipPath id="clip0">
                        <rect width="28" height="28" fill="white"/>
                        </clipPath>
                        </defs>
                    </svg>
                    Filter
                </div>
                <div class="dropdown-menu dropdown-menu-left">
                    <a class="dropdown-item" href="#">A To Z List</a>
                    <a class="dropdown-item" href="#">Z To A List</a>
                </div>
            </div>
        </div>
        <div class="row">
    @if(count($menu_list) > '0')
        @foreach ($menu_list as $menu)
            <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
                <div class="card">
                    <div>
                        <a href="{{ url('menu-detail').'/'.$menu->menu_id }}" class="text-black">
                            <div class="new-arrival-product">
                                <div class="new-arrivals-img-contnent">
                                    <img class="img-fluid" src="../{{ config('images.menu_url') .$restaurant_id.'/'. $menu->menu_image }}" alt="Menu Image" style="height: 150px !important;">
                                </div>
                                <div class="new-arrival-content text-center mt-3">
                                    <h4  class="text-black">{{ $menu->name }}</h4>
                                    <ul class="star-rating">
                                        <li>120 <i class="fa fa-thumbs-o-up" aria-hidden="true" style="color:#6742a8;font-size: 21px;"></i></li>
                                        <li>50 <i class="fa fa-thumbs-o-down" aria-hidden="true" style="color:red;font-size: 21px;"></i></li>
                                    </ul>   

                                    <?php 
                                    $tag_details = TagModel::get_tag_details($menu->tag_id);
                                    if ($tag_details) 
                                    {
                                        $tag_icon = '<img src="../'.config("images.tag_url") . $tag_details->tag_icon.'" width="20" height="20" alt="Tag Icon" />';
                                    } 
                                    else
                                    {
                                        $tag_icon = "";
                                    }
                                    ?>

                                    <span class="price">{!! $currency_icon !!} {{ $menu->price }} &nbsp;&nbsp;&nbsp; {!! $tag_icon !!} </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6">
            <div class="card">
                <div>
                    <h4>No Menus Found</h4>
                </div>
            </div>
        </div>
    @endif
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->

@include('theme.footer')