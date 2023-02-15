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
                        Restaurants
                    </div>
                </div>

@include('theme.common_header')
@include('theme.sidebar')

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="form-head d-flex mb-3 mb-lg-5 align-items-start">
            <div class="mr-auto col-md-10 d-none d-lg-block">
            </div>
    
            <div class="input-group search-area ml-3 d-inline-flex">
                <input type="text" class="search form-control" placeholder="Search here">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="flaticon-381-search-2"></i></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="table-responsive">
                    <table id="example5" class="display mb-4 dataTablesCard results">
                        <thead>
                            <tr>
                                <th><strong class="font-w600 wspace-no">Restaurant Name</strong></th>
                                <th><strong class="font-w600 wspace-no">Contact Person</strong></th>
                                <th><strong class="font-w600 wspace-no">Email</strong></th>                                 
                                <th><strong class="font-w600 wspace-no">Location</strong></th>
                                <th><strong class="font-w600 wspace-no">Contact No.</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($restaurants as $restaurant)

                            <tr onclick="window.location.href='restaurant-detail/{{ $restaurant->restaurant_id }}'" style="cursor:pointer;">
                                <!--td class="sorting_1 p-0 text-center">
                                    <div class="custom-control custom-checkbox ml-2">
                                        <input type="checkbox" class="custom-control-input" id="customCheckBox5" required="">
                                        <label class="custom-control-label" for="customCheckBox5"></label>
                                    </div>
                                </td-->
                                <td style="text-align:center">
                                    <div class="profile-photo" style="margin-top: 0px;">
                                    <img src="{{ config('images.restaurant_url') .$restaurant->restaurant_id.'/'. $restaurant->restaurant_logo }}" class="img-fluid" style="max-width:90px;" alt="">
                                    </div>{{ $restaurant->restaurant_name }}
                                </td>
                                <td>{{ $restaurant->contact_person }}</td>
                                <td>{{ $restaurant->email }}</td>                                               
                                <td>{{ $restaurant->location }}</td>
                                <td>{{ $restaurant->contact_number }}</td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->

@include('theme.footer')