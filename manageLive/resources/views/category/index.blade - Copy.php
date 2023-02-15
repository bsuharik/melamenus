@include('theme.header')

<style>
    .ls-nav li {
        list-style: none;
        margin-bottom: 12px;
    }

    .ls-nav li:before {
        font-family: FontAwesome;
        font-size: 1.2rem;
        content: "\f054";
        color: #6742a8;
        padding-right: 8px;
    }

    .ls-nav .ls-inner {
        padding-left: 8px;
        padding-top: 10px;
    }

    .ls-nav .ls-inner li:before {
        font-size: 0.8rem;
        line-height: 0.9rem;
        vertical-align: middle; 
    }

    .ls-nav .ls-inner .ls-inner-dot {
        padding-left: 15px; 
    }

    .ls-nav .ls-inner .ls-inner-dot .active {
        color: #ade5f6; 
    }

    .ls-nav .ls-inner .ls-inner-dot li:before {
        content: "●"; 
    }

    .icon-down:before {
        content: "\f107" ; 
    }
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
                        {{ $restaurant_name }} - Category Management
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
                <a href="{{ url()->previous() }}" id="back_button" class="btn btn-info btn-block">Back</a>
            </div>
        </div>
        <br>
        <div class="form-head d-flex mb-3 mb-lg-5 align-items-start">
            <div class="mr-auto d-none  col-md-7 d-lg-block">
                <div class="welcome-text">
                    <h4>Manage Category</h4>
                    <!--a data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-primary btn-block col-sm-12 col-md-4 mt-3" style="color:#fff!important;">Add Category</a-->
                </div>
            </div>
            <div class="input-group search-area ml-3 d-inline-flex">
                <input type="text" class="form-control" placeholder="Search here">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="flaticon-381-search-2"></i></span>
                </div>
            </div>
            <div id="app">
                @include('theme.flash-message')


                @yield('content')
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

        <!-- row -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="table-responsive">      
                        <table id="example6" class="display mb-4 dataTablesCard">
                            <thead>
                                <tr>                                                
                                    <th><strong class="font-w600 wspace-no">Category Name</strong></th>                
                                    <th style="padding-left:15px;"> <strong class="font-w600 wspace-no">Action</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                        @if(count($parent_categories) > '0')
                            @foreach($parent_categories as $parent_cat)
                                <tr>
                                    <td colspan="2">        
                                        <ul class="ls-nav">
                                            <li class="row" id="expand1" >
                                                <div class="col-md-12 row" >
                                                    <div class="col-md-8">
                                                        <a class="collapseContent1" role="button" data-toggle="collapse" href="#collapseContent1" aria-expanded="true" aria-controls="collapseContent1"> {{ $parent_cat->category_name}} </a>
                                                        <div class="collapse" id="collapseContent1">
                                                            <ul class="ls-inner">
                                                    @if(count($main_categories) > '0')
                                                        @foreach($main_categories as $main_cat)
                                                            @if($main_cat->parent_category_id == $parent_cat->category_id)
                                                                <li id="expand2">
                                                                    <a class="collapseContent2" role="button" data-toggle="collapse" class="collapseContent2" href="#collapseContent2" aria-expanded="true" aria-controls="collapseContent2"> {{ $main_cat->category_name}} </a>
                                                                    <div class="collapse" id="collapseContent2">
                                                                        <ul class="ls-inner-dot">
                                                                @if(count($sub_categories) > '0')
                                                                    @foreach($sub_categories as $sub_cat)
                                                                        @if($sub_cat->main_category_id == $main_cat->category_id)
                                                                            <li>{{ $sub_cat->category_name}}</li>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                                        </ul>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                            </ul>
                                                        </div>
                                                    </div>  
                                                    <div class="col-md-4" >
                                                        <a class="text-black" href="#">
                                                            <a class="text-black" href="{{ url('category-update') }}/{{ $parent_cat->category_id }}">Edit Name</a>
                                                        </a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <a class="text-black" href="{{ url('category-delete') }}/{{ $parent_cat->category_id }}">Delete</a>
                                                    </div>   
                                                </div>          
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                                <tr>
                                    <td>
                                        No Data Found
                                    </td>
                                </tr>
                        @endif
                            </tbody>
                        </table>
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

<script>
(function($) {
 
    var table = $('#example6').DataTable({
        searching: false,
        paging:true,
        select: false,
        //info: false,         
        lengthChange:false 
        
    });
    $('#example tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        
    });
   
})(jQuery);


var nocon = jQuery.noConflict();

nocon('.collapseContent2').on('click', function() {
alert('hii');
nocon("#expand2").toggleClass("icon-down");
});

nocon('.collapseContent1').on('click', function() {
alert('hii');
nocon("#expand1").toggleClass("icon-down");
});

</script>