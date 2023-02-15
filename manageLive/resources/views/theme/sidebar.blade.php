        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
                <ul class="metismenu" id="menu">
                    <?php $user_type = Auth::user()->user_type; ?>

                <?php if($user_type == "0"){ ?>
                    <li>
                        <a class="has-arrow ai-icon" href="{{ url('home') }}" aria-expanded="false">
                            <i class="flaticon-381-television"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a class="has-arrow ai-icon" href="{{ url('restaurant') }}" aria-expanded="false">
                            <i class="flaticon-381-home"></i>
                            <span class="nav-text">Restaurants</span>
                        </a>                       
                    </li>
                    <li>
                        <a class="has-arrow ai-icon" href="{{ url('tags') }}" aria-expanded="false">
                            <i class="flaticon-381-price-tag"></i>
                            <span class="nav-text">Restaurant Tags</span>
                        </a>                       
                    </li>
                    <li>
                        <a class="has-arrow ai-icon" href="{{ url('users') }}" aria-expanded="false">
                            <i class="flaticon-381-user"></i>
                            <span class="nav-text">Users</span>
                        </a>                       
                    </li>
                    <!-- <li>
                        <a class="has-arrow ai-icon" href="{{ url('allergies') }}" aria-expanded="false">
                            <i class="flaticon-381-user-1"></i>
                            <span class="nav-text">Restaurant Allergies</span>
                        </a>                       
                    </li> -->
                <?php } else {?>
                    <li>
                        <a class="has-arrow ai-icon" href="{{ url('home') }}" aria-expanded="false">
                            <i class="flaticon-381-menu"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>                       
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->