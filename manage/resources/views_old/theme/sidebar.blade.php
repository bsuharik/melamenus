        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
                <ul class="metismenu" id="menu">
                    <?php 
                        $user_type = Auth::user()->user_type;
                        $login_user= Auth::user();
                         ?>

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
                    <li> 
                        <a class="has-arrow ai-icon" href="{{ url('allergies') }}" aria-expanded="false">
                            <img class="allergy_img" src="{!! asset('theme/admin/images/allergies_icon.png') !!}" alt="" />
                            
                            <!-- <i class="flaticon-381-user"></i> -->
                            <span class="nav-text">Allergies</span>
                        </a>                       
                    </li>
                    <li> 
                        <a class="has-arrow ai-icon" href="{{ url('textures') }}" aria-expanded="false">
                             <img class="texture_img" src="{!! asset('theme/admin/images/textures_icon.png') !!}" alt="" />
                            <span class="nav-text">Textures</span> 
                        </a>                       
                    </li>
                <?php } else {?>
                    <li>
                        <a class="has-arrow ai-icon" href="{{ url('home') }}" aria-expanded="false">
                            <i class="flaticon-381-menu"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>                       
                    </li>
                    @if(empty($login_user->restaurant_owner_id))
                    <li>
                        <a class="has-arrow ai-icon" href="{{ url('users') }}" aria-expanded="false">
                            <i class="flaticon-381-user"></i>
                            <span class="nav-text">Users</span>
                        </a>                       
                    </li>
                    @endif
                <?php } ?>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->