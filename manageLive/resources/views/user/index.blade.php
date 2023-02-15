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
                        APP Users
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
            <!-- <div class="col-sm-11"></div> -->
            <div class="col-sm-12 text-right">
                <a href="{{ url('home') }}" id="back_button" class="btn btn-info btn-block back-btn-new">Back</a>
            </div>
        </div>
        <br>
        <div class="form-head d-flex mb-3 align-items-start">
            <div class="mr-auto d-none col-md-12 d-lg-block">
                <div class="welcome-text">
                    <div class="row">
                        <div class="col-md-9">
                            <h4>Manage Users</h4>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group search-area ml-3 d-inline-flex mt-3">
                                <input type="text" class="search form-control" placeholder="Search here">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="flaticon-381-search-2"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                
        </div>

        <!-- Table -->
        <div class="col-xl-12 col-xxl-12 col-lg-12 col-sm-12">
            <div class="card">
                <!-- row -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <table id="example5" class="display mb-4 dataTablesCard results">
                                    <thead>
                                        <tr>
                                            <th><strong class="font-w600 wspace-no">First Name</strong></th>
                                            <th><strong class="font-w600 wspace-no">Last Name</strong></th>
                                            <th><strong class="font-w600 wspace-no">Email</strong></th>
                                            <th><strong class="font-w600 wspace-no">Gender</strong></th>
                                            <th><strong class="font-w600 wspace-no">Date Of Birth</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                @if(count($users_list) > '0')
                                    @foreach ($users_list as $user)
                                        <tr>
                                            <td> {{ $user->first_name }} </td>
                                            <td> {{ $user->last_name }} </td>
                                            <td> {{ $user->email }} </td>
                                            <td> 
                                                @if($user->gender == "0")
                                                    Male
                                                @elseif($user->gender == "1")
                                                    Female
                                                @elseif($user->gender == "2")
                                                    Other
                                                @endif
                                            </td>
                                            <td> 
                                                @if($user->date_of_birth != "")
                                                    {{ date('d-m-Y',strtotime($user->date_of_birth)) }}
                                                @endif 
                                            </td>
                                        </tr> 
                                    @endforeach
                                @else
                                        <tr>
                                            <td></td>
                                            <td>No Data Found</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
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
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->

@include('theme.footer')