@include('theme.header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.css" />
    <!--**********************************
        Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                                {{ $restaurant->restaurant_name }} - Edit Profile Details
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
                <form method="POST" enctype="multipart/form-data" id="update_restaurant_profile" action="javascript:void(0)" files="true">
                    <!-- row -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
								        <!-- row -->
										<div class="row">
											<div class="col-xl-3 col-lg-3 col-sm-8">
												<img src="{{$qr_image}}" style="    margin-left: 25px; width: 350px;"/> 
											</div>
											<div class="col-xl-3 col-lg-3 col-sm-8">
												 <div class="row">
													<div class="col-xl-12">
													<a href="{{ url('menu') }}/{{ $restaurant->restaurant_id }}">
														<div class="card overflow-hidden">
															<div class="card-header media border-0 pb-0">
																<div class="media-body">
																	<h2 class="text-black">{{$menu_count}} </h2>
																	<p class="mb-0 text-black">Menu Items</p>
																</div>
																<svg width="36" height="28" viewBox="0 0 36 28" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path d="M31.75 6.75H30.0064L30.2189 4.62238C30.2709 4.10111 30.2131 3.57473 30.0493 3.07716C29.8854 2.57959 29.6192 2.12186 29.2676 1.73348C28.9161 1.3451 28.4871 1.03468 28.0082 0.822231C27.5294 0.609781 27.0114 0.500013 26.4875 0.5H7.0125C6.48854 0.500041 5.9704 0.609864 5.49148 0.822391C5.01256 1.03492 4.58348 1.34543 4.23189 1.73392C3.88031 2.12241 3.61403 2.58026 3.45021 3.07795C3.28639 3.57564 3.22866 4.10214 3.28075 4.6235L5.2815 24.6224C5.31508 24.9222 5.38467 25.2168 5.48875 25.5H1.75C1.41848 25.5 1.10054 25.6317 0.866116 25.8661C0.631696 26.1005 0.5 26.4185 0.5 26.75C0.5 27.0815 0.631696 27.3995 0.866116 27.6339C1.10054 27.8683 1.41848 28 1.75 28H31.75C32.0815 28 32.3995 27.8683 32.6339 27.6339C32.8683 27.3995 33 27.0815 33 26.75C33 26.4185 32.8683 26.1005 32.6339 25.8661C32.3995 25.6317 32.0815 25.5 31.75 25.5H28.0115C28.1154 25.2172 28.1849 24.9229 28.2185 24.6235L28.881 18H31.75C32.7442 17.9989 33.6974 17.6035 34.4004 16.9004C35.1035 16.1974 35.4989 15.2442 35.5 14.25V10.5C35.4989 9.50577 35.1035 8.55258 34.4004 7.84956C33.6974 7.14653 32.7442 6.75109 31.75 6.75ZM9.0125 25.5C8.70243 25.501 8.40314 25.3862 8.17327 25.1782C7.9434 24.9701 7.79949 24.6836 7.76975 24.375L5.7685 4.37575C5.75109 4.20188 5.7703 4.0263 5.82488 3.86031C5.87946 3.69432 5.96821 3.5416 6.0854 3.412C6.2026 3.28239 6.34564 3.17877 6.50532 3.10781C6.665 3.03685 6.83777 3.00013 7.0125 3H26.4875C26.6622 3.00012 26.8349 3.03681 26.9945 3.10772C27.1541 3.17863 27.2972 3.28218 27.4143 3.4117C27.5315 3.54123 27.6203 3.69386 27.6749 3.85977C27.7295 4.02568 27.7488 4.20119 27.7315 4.375L25.7308 24.3762C25.7007 24.6848 25.5566 24.971 25.3267 25.1788C25.0967 25.3867 24.7975 25.5012 24.4875 25.5H9.0125ZM33 14.25C32.9998 14.5815 32.868 14.8993 32.6337 15.1337C32.3993 15.368 32.0815 15.4998 31.75 15.5H29.1311L29.7561 9.25H31.75C32.0815 9.2502 32.3993 9.38196 32.6337 9.61634C32.868 9.85071 32.9998 10.1685 33 10.5V14.25Z" fill="#2e5090"/>
																</svg>
															</div>
															<!--<div class="card-body p-0">
																<canvas id="widgetChart1" height="75"></canvas>
															</div>-->
														</div>
													</a>
													</div>
												</div>
												<div class="row">
													<div class="col-xl-12">
														<a href="{{ url('category') }}/{{ $restaurant->restaurant_id }}">
															<div class="card overflow-hidden">
																<div class="card-header media border-0 pb-0">
																	<div class="media-body">
																		
																		<h2 class="text-black"> {{$category_count}} </h2>
																		<p class="mb-0 text-black">Menu Categories</p>
																	</div>
																	<svg width="32" height="31" viewBox="0 0 32 31" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path d="M4 30.5H22.75C23.7442 30.4989 24.6974 30.1035 25.4004 29.4004C26.1035 28.6974 26.4989 27.7442 26.5 26.75V16.75C26.5 16.4185 26.3683 16.1005 26.1339 15.8661C25.8995 15.6317 25.5815 15.5 25.25 15.5C24.9185 15.5 24.6005 15.6317 24.3661 15.8661C24.1317 16.1005 24 16.4185 24 16.75V26.75C23.9997 27.0814 23.8679 27.3992 23.6336 27.6336C23.3992 27.8679 23.0814 27.9997 22.75 28H4C3.66857 27.9997 3.3508 27.8679 3.11645 27.6336C2.88209 27.3992 2.7503 27.0814 2.75 26.75V9.25C2.7503 8.91857 2.88209 8.6008 3.11645 8.36645C3.3508 8.13209 3.66857 8.0003 4 8H15.25C15.5815 8 15.8995 7.8683 16.1339 7.63388C16.3683 7.39946 16.5 7.08152 16.5 6.75C16.5 6.41848 16.3683 6.10054 16.1339 5.86612C15.8995 5.6317 15.5815 5.5 15.25 5.5H4C3.00577 5.50109 2.05258 5.89653 1.34956 6.59956C0.646531 7.30258 0.251092 8.25577 0.25 9.25V26.75C0.251092 27.7442 0.646531 28.6974 1.34956 29.4004C2.05258 30.1035 3.00577 30.4989 4 30.5Z" fill="#2e5090"/>
																		<path d="M25.25 0.5C24.0138 0.5 22.8055 0.866556 21.7777 1.55331C20.7498 2.24007 19.9488 3.21619 19.4757 4.35823C19.0027 5.50027 18.8789 6.75693 19.1201 7.96931C19.3612 9.1817 19.9565 10.2953 20.8306 11.1694C21.7046 12.0435 22.8183 12.6388 24.0307 12.8799C25.243 13.1211 26.4997 12.9973 27.6417 12.5242C28.7838 12.0512 29.7599 11.2501 30.4466 10.2223C31.1334 9.19451 31.5 7.98613 31.5 6.75C31.498 5.093 30.8389 3.50442 29.6672 2.33274C28.4955 1.16106 26.907 0.501952 25.25 0.5ZM25.25 10.5C24.5083 10.5 23.7833 10.2801 23.1666 9.86801C22.5499 9.45596 22.0692 8.87029 21.7854 8.18506C21.5016 7.49984 21.4273 6.74584 21.572 6.01841C21.7167 5.29098 22.0739 4.6228 22.5983 4.09835C23.1228 3.5739 23.7909 3.21675 24.5184 3.07206C25.2458 2.92736 25.9998 3.00162 26.685 3.28545C27.3702 3.56928 27.9559 4.04993 28.368 4.66661C28.78 5.2833 29 6.00832 29 6.75C28.9989 7.74423 28.6034 8.69742 27.9004 9.40044C27.1974 10.1035 26.2442 10.4989 25.25 10.5Z" fill="#2e5090"/>
																		<path d="M6.5 13H12.75C13.0815 13 13.3995 12.8683 13.6339 12.6339C13.8683 12.3995 14 12.0815 14 11.75C14 11.4185 13.8683 11.1005 13.6339 10.8661C13.3995 10.6317 13.0815 10.5 12.75 10.5H6.5C6.16848 10.5 5.85054 10.6317 5.61612 10.8661C5.3817 11.1005 5.25 11.4185 5.25 11.75C5.25 12.0815 5.3817 12.3995 5.61612 12.6339C5.85054 12.8683 6.16848 13 6.5 13Z" fill="#2e5090"/>
																		<path d="M5.25 16.75C5.25 17.0815 5.3817 17.3995 5.61612 17.6339C5.85054 17.8683 6.16848 18 6.5 18H17.75C18.0815 18 18.3995 17.8683 18.6339 17.6339C18.8683 17.3995 19 17.0815 19 16.75C19 16.4185 18.8683 16.1005 18.6339 15.8661C18.3995 15.6317 18.0815 15.5 17.75 15.5H6.5C6.16848 15.5 5.85054 15.6317 5.61612 15.8661C5.3817 16.1005 5.25 16.4185 5.25 16.75Z" fill="#2e5090"/>
																	</svg>
																</div>
																<!--<div class="card-body p-0">
																	<canvas id="widgetChart2" height="75"></canvas>
																</div>-->
															</div>
														</a>
													</div>
												</div>
												<div class="row">
													<div class="col-xl-12">
														<a href="{{ url('table') }}/{{ $restaurant->restaurant_id }}">
															<div class="card overflow-hidden">
																<div class="card-header media border-0 pb-0">
																	<div class="media-body">
																		<h2 class="text-black"> {{$table_count}} </h2>
																		<p class="mb-0 text-black">Tables</p>
																	</div>
																	<svg width="32" height="36" viewBox="0 0 32 36" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path d="M11.25 19.25C12.2389 19.25 13.2056 18.9568 14.0279 18.4074C14.8501 17.8579 15.491 17.0771 15.8694 16.1634C16.2478 15.2498 16.3469 14.2445 16.1539 13.2746C15.961 12.3046 15.4848 11.4137 14.7855 10.7145C14.0863 10.0152 13.1954 9.539 12.2255 9.34608C11.2555 9.15315 10.2502 9.25217 9.33658 9.6306C8.42295 10.009 7.64206 10.6499 7.09265 11.4722C6.54325 12.2944 6.25 13.2611 6.25 14.25C6.25129 15.5757 6.77849 16.8467 7.71589 17.7841C8.65329 18.7215 9.92431 19.2487 11.25 19.25ZM11.25 11.75C11.7445 11.75 12.2278 11.8966 12.6389 12.1713C13.05 12.446 13.3705 12.8365 13.5597 13.2933C13.7489 13.7501 13.7984 14.2528 13.702 14.7377C13.6055 15.2227 13.3674 15.6681 13.0178 16.0178C12.6681 16.3674 12.2227 16.6055 11.7377 16.702C11.2528 16.7984 10.7501 16.7489 10.2933 16.5597C9.83648 16.3705 9.44603 16.0501 9.17133 15.6389C8.89662 15.2278 8.75 14.7445 8.75 14.25C8.75089 13.5872 9.01457 12.9519 9.48322 12.4832C9.95187 12.0146 10.5872 11.7509 11.25 11.75Z" fill="#2e5090"/>
																		<path d="M30.78 22.4625C31.1926 21.9098 31.4683 21.2672 31.5844 20.5873C31.7005 19.9074 31.6537 19.2097 31.4477 18.5514L30.6542 15.9696C30.2817 14.7451 29.5243 13.6733 28.4946 12.9132C27.4648 12.1531 26.2174 11.7452 24.9375 11.75H19.3286C18.9971 11.75 18.6792 11.8817 18.4447 12.1161C18.2103 12.3505 18.0786 12.6685 18.0786 13C18.0786 13.3315 18.2103 13.6495 18.4447 13.8839C18.6792 14.1183 18.9971 14.25 19.3286 14.25H24.9375C25.6823 14.2474 26.4081 14.485 27.0072 14.9274C27.6064 15.3698 28.0471 15.9935 28.2639 16.706L29.0574 19.2866C29.1449 19.5713 29.1645 19.8725 29.1145 20.1661C29.0645 20.4597 28.9463 20.7374 28.7694 20.977C28.5925 21.2166 28.3619 21.4114 28.096 21.5456C27.8302 21.6799 27.5366 21.7499 27.2387 21.75H15.7776C15.7422 21.75 15.7126 21.7671 15.6776 21.7701C15.5936 21.7669 15.5125 21.75 15.4272 21.75H7.58975C6.20068 21.7449 4.84702 22.1879 3.72969 23.0132C2.61236 23.8385 1.79094 25.0021 1.38737 26.3312L0.454122 29.3625C0.236133 30.0719 0.187609 30.8225 0.312449 31.554C0.437289 32.2856 0.732013 32.9776 1.17293 33.5746C1.61385 34.1715 2.18866 34.6567 2.85116 34.9911C3.51366 35.3255 4.24538 35.4998 4.9875 35.5H18.0286C18.7708 35.4999 19.5026 35.3256 20.1651 34.9912C20.8277 34.6569 21.4026 34.1717 21.8435 33.5748C22.2845 32.9778 22.5793 32.2857 22.7041 31.5542C22.829 30.8226 22.7805 30.0719 22.5625 29.3625L21.6299 26.3315C21.3936 25.5767 21.0217 24.8713 20.5322 24.25H27.2387C27.9283 24.2532 28.6088 24.0928 29.2243 23.7821C29.8399 23.4714 30.373 23.0192 30.78 22.4625ZM19.8327 32.089C19.6254 32.3726 19.3538 32.6031 19.0402 32.7614C18.7266 32.9198 18.3799 33.0015 18.0286 33H4.9875C4.63649 32.9999 4.2904 32.9175 3.97705 32.7594C3.6637 32.6012 3.39184 32.3717 3.18334 32.0894C2.97484 31.807 2.83552 31.4796 2.77658 31.1336C2.71764 30.7876 2.74073 30.4326 2.844 30.0971L3.77662 27.0661C4.02439 26.2489 4.52922 25.5335 5.21609 25.0261C5.90296 24.5188 6.7352 24.2466 7.58912 24.25H15.4266C16.2805 24.2466 17.1128 24.5188 17.7996 25.0261C18.4865 25.5335 18.9913 26.2489 19.2391 27.0661L20.1717 30.0971C20.2769 30.4323 20.301 30.7877 20.2421 31.134C20.1831 31.4804 20.0429 31.8078 19.8327 32.0894V32.089Z" fill="#2e5090"/>
																		<path d="M21.875 9.24999C22.7403 9.24999 23.5861 8.9934 24.3056 8.51267C25.0251 8.03194 25.5858 7.34866 25.917 6.54923C26.2481 5.74981 26.3347 4.87014 26.1659 4.02148C25.9971 3.17281 25.5804 2.39326 24.9686 1.78141C24.3567 1.16955 23.5772 0.752876 22.7285 0.584066C21.8798 0.415256 21.0002 0.501896 20.2008 0.833029C19.4013 1.16416 18.7181 1.72492 18.2373 2.44438C17.7566 3.16384 17.5 4.0097 17.5 4.875C17.5014 6.03489 17.9628 7.14688 18.7829 7.96705C19.6031 8.78722 20.7151 9.2486 21.875 9.24999ZM21.875 3C22.2458 3 22.6083 3.10997 22.9167 3.31599C23.225 3.52202 23.4654 3.81485 23.6073 4.15747C23.7492 4.50008 23.7863 4.87708 23.714 5.24079C23.6416 5.6045 23.463 5.9386 23.2008 6.20082C22.9386 6.46304 22.6045 6.64162 22.2408 6.71397C21.8771 6.78631 21.5001 6.74918 21.1575 6.60727C20.8149 6.46535 20.522 6.22503 20.316 5.91669C20.11 5.60835 20 5.24584 20 4.875C20.0006 4.37789 20.1983 3.9013 20.5498 3.54979C20.9013 3.19829 21.3779 3.00056 21.875 3Z" fill="#2e5090"/>
																	</svg>
																</div>
																<!--<div class="card-body p-0">
																	<canvas id="widgetChart3" height="75"></canvas>
																</div>-->
															</div>
														</a>
													</div>
												</div>
											
												
											</div>

											<div class="col-xl-6 col-lg-6 col-sm-8">
												<a href="{{ url('table') }}/{{ $restaurant->restaurant_id }}">
													<div class="card overflow-hidden">
														<div class="card-header media border-0 pb-0">
															<div class="media-body">
																<h2 class="text-black"> Total Menu Views </h2>
																<p class="mb-0 text-black"></p> 
															</div>
														</div>
														<div class="card-body p-0">
															<canvas id="widgetChart3" height="75"></canvas>
														</div>
													</div>
												</a>
											</div>
										</div>
                                   
                                    <div class="errorMessage"></div>
									


                                    <div class="profile-tab">
                                        
                                        <div class="custom-tab-1">
										
										
										
                                            <div class="tab-content">
                                                <div id="my-posts" class="tab-pane fade active show">
			
                                                    <div class="my-post-content pt-3">
                                                        <div class="profile-personal-info">
														
															<div class="tabs">
																<input type="radio" name="tab-btn" id="tab-btn-1" value="" checked>
																<label for="tab-btn-1">Design Customization</label>
																<input type="radio" name="tab-btn" id="tab-btn-2" value="">
																<label for="tab-btn-2">Restaurant Information</label>

																<div id="content-1">
															
															<div class="row">
                                                                <div class="col-md-8">
													
															<div class="row form-group"> 
																<div class="profile-name col-xl-12 col-lg-12">
																	<h4 class="text-primary mb-0 error_message_parent">
																		<input type="hidden" name="restaurant_id" id="restaurant_id" value="{{ $restaurant->restaurant_id }}" />
																		<input type="text" class="form-control" name="restaurant_name" id="restaurant_name" placeholder="Enter Restaurant Name" value="{{ $restaurant->restaurant_name }}" maxlength="50" />
																		<span id="errorMessage"></span>
																	</h4>
																</div>
																
															</div>
															<div class="row form-group profile"> 
																<div class="col-xl-2 col-lg-2">
																	<label id="custom-label">Restaurant logo</label>
																	<div class="profile-photo error_message_parent" style="margin-top: 0px;">
																			@if(!empty($restaurant->restaurant_logo))
																			<img src="../{{ config('images.restaurant_url') .$restaurant->restaurant_id.'/'. $restaurant->restaurant_logo }}" class="img-fluid logo_img" alt="Restaurant Logo">
																			@else
																			<img src="../{{ config('images.default_image_url')}}" class="img-fluid logo_img" alt="">
																			@endif
																			<input name="restaurant_logo" class="file-upload" type="file" accept="image/*" id="restaurant_logo" />
																			<span id="errorMessage"></span>
																			<div class="p-image">
																				<img src="{{URL::to('/theme/admin/images/pencil.png')}}">
																			</div>
																	</div>
																</div>
																
																<div class="col-xl-2 col-lg-2">
																<label id="custom-label">Cover Image </label>
																	<div class="profile-photo error_message_parent" style="margin-top: 0px;">
																			@if(!empty($restaurant->restaurant_cover_image))
																			<img src="../{{ config('images.restaurant_url') .$restaurant->restaurant_id.'/'. $restaurant->restaurant_cover_image }}" class="img-fluid logo_img" alt="Restaurant Logo">
																			@else
																			<img src="../{{ config('images.default_image_url')}}" class="img-fluid logo_img" alt="">
																			@endif
																			<input name="restaurant_cover_image" class="file-upload" type="file" accept="image/*" id="restaurant_cover_image" style="position: absolute; left: 40px; top: 70px;"/>
																			<span id="errorMessage"></span>
																			<div class="p-image">
																				<img src="{{URL::to('/theme/admin/images/pencil.png')}}">
																			</div>
																	</div>
																</div>
																<div class="col-xl-6 col-lg-6">
																</div>
																<div class="col-xl-2 col-lg-2">
																	<a data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-primary btn-block" style="color:#fff!important;">Add Font</a>
																</div>
															</div>
															
															<!--<div class="row form-group">
                                                                <div class="col-md-2">
                                                                    <label id="custom-label">Texture Image </label>
                                                                </div>
                                                                <div class="col texture_image_ctm" id="add_texture_image">
                                                                    @if(!empty($restaurant->texture_id) && !empty($restaurant->texture_detail))
                                                                    <div class="pip menu_image">
                                                                        <img class="imageThumb" src="../{{ config('images.texture_url') .$restaurant->texture_detail->image}}">
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                                <div class="col">

                                                                </div>
                                                                <div class="col">
                                                                </div>
                                                                <input type="hidden" name="texture_id" id="texture_id" value="@if(!empty($restaurant->texture_id)) {{$restaurant->texture_id}}@endif">
                                                                <div class="col">
                                                                    <a data-toggle="modal" data-target="#select_texture" class="btn btn-primary btn-block" style="color:#fff!important;">Select Texture Image</a>
                                                                </div>
                                                            </div>

                                                            <div class="row form-group">
                                                                <div class="col">
                                                                    <label id="custom-label">Select Theme </label>
                                                                </div>
                                                                <div class="col">
                                                                </div>
                                                                <div class="col">
                                                                </div>
                                                                <div class="col">
                                                                </div>
                                                                <div class="col">
                                                                    <a data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-primary btn-block" style="color:#fff!important;">Add Font</a>
                                                                </div>
                                                            </div>-->
                                                            <div class="row form-group">
                                                                <div class="col">
                                                                    <label id="custom-label" class="mt-5">Color: </label>
                                                                </div>
                                                                <div class="col">
                                                                    <label id="custom-color-label">Category & Header</label>
                                                                    <input type="text" class="as_colorpicker form-control" value="{{ $restaurant->app_theme_color_1 }}" name="app_theme_color_1" autocomplete="off">
                                                                    <span id="errorMessage"></span>
                                                                </div>
                                                                <div class="col">
                                                                    <label id="custom-color-label">Main Title</label>
                                                                    <input type="text" class="as_colorpicker form-control" value="{{ $restaurant->app_theme_color_2 }}" name="app_theme_color_2" autocomplete="off">
                                                                    <span id="errorMessage"></span>
                                                                </div>
                                                                <div class="col">
                                                                    <label id="custom-color-label">Item Title</label>
                                                                    <input type="text" class="as_colorpicker form-control" value="{{ $restaurant->app_theme_color_3 }}" name="app_theme_color_3" autocomplete="off">
                                                                    <span id="errorMessage"></span>
                                                                </div>
                                                                <div class="col">
                                                                    <label id="custom-color-label">Item Description</label>
                                                                    <input type="text" class="as_colorpicker form-control" value="{{ $restaurant->app_theme_color_4 }}" name="app_theme_color_4">
                                                                    <span id="errorMessage"></span>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">

                                                                <div class="col-md-10 error_message_parent">
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col">
                                                                    <label id="custom-label">Font Type: </label>
                                                                </div>
                                                                <div class="col">

                                                                    <select name="app_theme_font_type_1" class="form-control" id="app_theme_font_type_1">
                                                                        <!--<option value="">Select</option>-->
                                                                        @if(count($restaurant->font_type_detail) > '0')
                                                                        @foreach ($restaurant->font_type_detail as $font)
                                                                        <option value="{{ $font->id }}" {{( $restaurant->app_theme_font_type_1 == $font->id) ? 'selected' : '' }}>{{ $font->name }}</option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>

                                                                </div>
                                                                <div class="col">

                                                                    <select name="app_theme_font_type_2" class="form-control" id="app_theme_font_type_2">
                                                                        <!--<option value="">Select</option>-->
                                                                        @if(count($restaurant->font_type_detail) > '0')
                                                                        @foreach ($restaurant->font_type_detail as $font)
                                                                        <option value="{{ $font->id }}" {{( $restaurant->app_theme_font_type_2 == $font->id) ? 'selected' : '' }}>{{ $font->name }}</option>
                                                                        @endforeach
                                                                        @endif

                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <select name="app_theme_font_type_3" class="form-control" id="app_theme_font_type_3">
                                                                        <!--<option value="">Select</option>-->
                                                                        @if(count($restaurant->font_type_detail) > '0')
                                                                        @foreach ($restaurant->font_type_detail as $font)
                                                                        <option value="{{ $font->id }}" {{( $restaurant->app_theme_font_type_3 == $font->id) ? 'selected' : '' }}>{{ $font->name }}</option>
                                                                        @endforeach
                                                                        @endif

                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <select name="app_theme_font_type_4" class="form-control" id="app_theme_font_type_4">
                                                                        <!--<option value="">Select</option>-->
                                                                        @if(count($restaurant->font_type_detail) > '0')
                                                                        @foreach ($restaurant->font_type_detail as $font)
                                                                        <option value="{{ $font->id }}" {{( $restaurant->app_theme_font_type_4 == $font->id) ? 'selected' : '' }}>{{ $font->name }}</option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col">
                                                                    <label id="custom-label">Font Style: </label>
                                                                </div>
                                                                <div class="col">

                                                                    <select name="app_theme_font_style_1" class="form-control" id="app_theme_font_style_1">
                                                                        <option value="Standard" {{ ( $restaurant->app_theme_font_style_1 == 'Standard') ? 'selected' : '' }}>Standard</option>
                                                                        <option value="bold" {{ ( $restaurant->app_theme_font_style_1 == 'bold') ? 'selected' : '' }}>Bold</option>
                                                                        <option value="italic" {{ ( $restaurant->app_theme_font_style_1 == 'italic') ? 'selected' : '' }}>Italic</option>
                                                                        <option value="Underline" {{($restaurant->app_theme_font_style_1 == 'Underline') ? 'selected' : '' }}>Underline</option>

                                                                    </select>

                                                                </div>
                                                                <div class="col">

                                                                    <select name="app_theme_font_style_2" class="form-control" id="app_theme_font_style_2">
                                                                        <option value="Standard" {{ ( $restaurant->app_theme_font_style_1 == 'Standard') ? 'selected' : '' }}>Standard</option>
                                                                        <option value="bold" {{ ( $restaurant->app_theme_font_style_2 == 'bold') ? 'selected' : '' }}>Bold</option>
                                                                        <option value="italic" {{ ( $restaurant->app_theme_font_style_2 == 'italic') ? 'selected' : '' }}>Italic</option>
                                                                        <option value="Underline" {{ ( $restaurant->app_theme_font_style_2 == 'Underline') ? 'selected' : '' }}>Underline</option>

                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <select name="app_theme_font_style_3" class="form-control" id="app_theme_font_style_3">
                                                                        <option value="Standard" {{ ( $restaurant->app_theme_font_style_1 == 'Standard') ? 'selected' : '' }}>Standard</option>
                                                                        <option value="bold" {{ ( $restaurant->app_theme_font_style_3 == 'bold') ? 'selected' : '' }}>Bold</option>
                                                                        <option value="italic" {{ ( $restaurant->app_theme_font_style_3 == 'italic') ? 'selected' : '' }}>Italic</option>
                                                                        <option value="Underline" {{ ( $restaurant->app_theme_font_style_3 == 'Underline') ? 'selected' : '' }}>Underline</option>

                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <select name="app_theme_font_style_4" class="form-control" id="app_theme_font_style_4">
                                                                        <option value="Standard" {{($restaurant->app_theme_font_style_1 == 'Standard') ? 'selected' : '' }}>Standard</option>
                                                                        <option value="bold" {{ ( $restaurant->app_theme_font_style_4 == 'bold') ? 'selected' : '' }}>Bold</option>
                                                                        <option value="italic" {{ ( $restaurant->app_theme_font_style_4 == 'italic') ? 'selected' : '' }}>Italic</option>
                                                                        <option value="Underline" {{ ( $restaurant->app_theme_font_style_4 == 'Underline') ? 'selected' : '' }}>Underline</option>

                                                                    </select>
                                                                </div>
                                                            </div>
 <!-- row -->
                                    <div class="row">
                                        <div class="col-sm-10"></div>
                                        <div class="col-sm-2 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                                            <input class="btn btn-primary btn-block" type="submit" name="save" value="Save">
                                            &nbsp;
                                            <!--<a href="{{ url('restaurant-detail') }}/{{ $restaurant->restaurant_id }}" id="back_button" class="btn btn-info btn-block">Back</a>-->
                                        </div>
                                    </div>
                                    <br>
								</div>
								
								<div class="col-md-4">
									<div class="preview" style="width: 320px; height: 720px; margin: auto;     background-image: url(http://manage.melamenus.com/theme/images/phone.png);">
										<img src="/theme/images/phone.png" style="    margin: -20px 0px -5px -10px; width: 339px; height: 765px; position: absolute; z-index:1;" /> 
										<iframe name = "myframe" width = "320px" height = "720px" src = "{{ $rest_link }}" scrolling="no" style="position: absolute; z-index:2; border-radius: 12px; border: none;"></iframe>
									</div>
								</div>
								</div>
																</div>
																<div id="content-2">
																    <div class="row form-group">
																		<div class="col-md-2">
																			<label id="custom-label">First Name</label>
																		</div>
																		<div class="col-md-10 error_message_parent">
																			<input type="text" name="first_name" id="first_name" class="form-control" value="{{ $restaurant->user_detail->first_name }}" maxlength="50" />
																			<span id="errorMessage"></span>
																		</div>
																	</div>
																	<div class="row form-group">
																		<div class="col-md-2">
																			<label id="custom-label">Last Name</label>
																		</div>
																		<div class="col-md-10 error_message_parent">
																			<input type="text" name="last_name" id="last_name" class="form-control" value="{{ $restaurant->user_detail->last_name }}" maxlength="50" />
																			<span id="errorMessage"></span>
																		</div>
																	</div>
																	<div class="row form-group">
																		<div class="col-md-2">
																			<label id="custom-label">Email</label>
																		</div>
																		<div class="col-md-10 error_message_parent">
																			<input type="email" name="email" id="email" class="form-control" value="{{ $restaurant->email }}" />
																			<span id="errorMessage"></span>
																		</div>
																	</div>
																	<div class="row form-group">
																		<div class="col-md-2">
																			<label id="custom-label">Contact Number </label>
																		</div>
																		<div class="col-md-10 error_message_parent">
																			<input type="text" name="contact_number" id="contact_number" class="form-control" value="{{ $restaurant->contact_number }}" />
																			<span id="errorMessage"></span>
																		</div>
																	</div>
																	<div class="row form-group">
																		<div class="col-md-2">
																			<label id="custom-label">Contact Person</label>
																		</div>
																		<div class="col-md-10 error_message_parent">
																			<input type="text" name="contact_person" id="contact_person" class="form-control" value="{{ $restaurant->contact_person }}" maxlength="50" />
																			<span id="errorMessage"></span>
																		</div>
																	</div>
																	<div class="row form-group">
																		<div class="col-md-2">
																			<label id="custom-label">Country </label>
																		</div>
																		<div class="col-md-10 error_message_parent">
																			<select name="country_id" class="form-control" id="country_id">
																				<option value="">Select Country</option>
																				@if(count($country_list) > '0')
																				@foreach ($country_list as $value)
																				<option value="{{ $value->country_id }}" {{ ( $value->country_id == $restaurant->country_id) ? 'selected' : '' }}>{{ $value->country_name }}</option>
																				@endforeach
																				@endif

																			</select>
																			<span id="errorMessage"></span>
																		</div>
																	</div>
																	<div class="row form-group">
																		<div class="col-md-2">
																			<label id="custom-label">TimeZone </label>
																		</div>
																		<div class="col-md-10 error_message_parent">
																			<select name="time_zone" class="form-control" id="time_zone">
																				<option value="">Select TimeZone</option>
																				@if(count($timezone_list) > '0')
																				@foreach ($timezone_list as $value)
																					<option value="{{ $value }}" {{( $value == $restaurant->time_zone_id) ? 'selected' : '' }} >{{ $value }}</option>
																				@endforeach
																				@endif 
																			</select>
																			<span id="errorMessage"></span>
																		</div>
																	</div>
																	<div class="row form-group">
																		<div class="col-md-2">
																			<label id="custom-label">Address </label>
																		</div>
																		<div class="col-md-10 error_message_parent">
																			<textarea name="location" id="location" class="form-control">{{ $restaurant->location }}</textarea>
																			<span id="errorMessage"></span>
																		</div>
																	</div>
																	<div class="row form-group">
																		<div class="col-md-2">
																			<label id="custom-label">Currency </label>
																		</div>
																		<div class="col-md-10 error_message_parent">
																			<select name="currency_id" class="form-control" id="currency_id">
																				<option value="">Select Currency</option>
																				@if(count($currency_list) > '0')
																				@foreach ($currency_list as $value)
																				<option value="{{ $value->currency_id }}" {{ ( $value->currency_id == $restaurant->currency_id) ? 'selected' : '' }}>{{ $value->currency_name }}</option>
																				@endforeach
																				@endif
																			</select>
																			<span id="errorMessage"></span>
																		</div>
																	</div>
																	{{--
																	<div class="row form-group">
																		<div class="col-md-2">
																			<label id="custom-label">Gender </label>
																		</div>
																		<div class="col-md-10 error_message_parent">
																			<select name="gender" class="form-control" id="gender">
																				<option value="">Select Gender</option>
																				<option value="0" {{ ( $restaurant->user_detail->gender == '0') ? 'selected' : '' }}>Male</option>
																				<option value="1" {{ ( $restaurant->user_detail->gender == '1') ? 'selected' : '' }}>Female</option>
																				<option value="2" {{ ( $restaurant->user_detail->gender == '2') ? 'selected' : '' }}>Other</option>
																			</select>
																			<span id="errorMessage"></span>
																		</div>
																	</div> --}}
																	<div class="row form-group">
																		<div class="col-md-2">
																			<label id="custom-label">Date Of Birth</label>
																		</div>
																		<div class="col-md-10 error_message_parent">
																			<input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ $restaurant->user_detail->date_of_birth }}" />
																			<span id="errorMessage"></span>
																		</div>
																	</div>
																	 <!-- row -->
																	<div class="row">
																		<div class="col-sm-10"></div>
																		<div class="col-sm-2 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
																			<input class="btn btn-primary btn-block" type="submit" name="save" value="Save">
																			&nbsp;
																			<!--<a href="{{ url('restaurant-detail') }}/{{ $restaurant->restaurant_id }}" id="back_button" class="btn btn-info btn-block">Back</a>-->
																		</div>
																	</div>
																	<br>
																</div>

															</div>
                                                          
         
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="exampleModalCenter">
            <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content <?php //texture_popup; 
                        ?>">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Font</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                            </button>
                        </div>
                        <div class="fontErrorMessage"></div>
                        <form method="POST" id="add_only_font" action="javascript:void(0)" enctype="multipart/form-data" files="true">
                            <input type="hidden" name="restaurant_id" value="{{ $restaurant->restaurant_id }}" />
                            <div class="modal-body">
                                <div class="row">
                                    <label class="col-md-12">Name <i class="text-danger">*</i></label>
                                    <div class="col-md-12 error_message_parent">
                                        <input type="text" class="form-control clear-field" name="name" id="name" placeholder="Enter Font Name" autocomplete="off" />
                                        <span id="errorMessage"></span>
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <label class="col-md-12">Font File <i class="text-danger">*</i> <small>(only ttf, eot, eoff, woff2, svg fonts are allowed.)</small></label>
                                    <div class="col-md-12 error_message_parent">
                                        <input type="file" class="form-control clear-field" name="font_file" id="font_file" data-acceptable-extension="ttf,eot,eoff,woff2,svg" autocomplete="off">
                                        <span id="errorMessage"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                                <input type="submit" name="submit" value="Add Font" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Select Texture Image Start -->
            <div class="modal fade" id="select_texture">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content texture_popup">
                        <div class="modal-header">
                            <h5 class="modal-title">Select Texture</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                            </button>
                        </div>
                        <div class="fontErrorMessage"></div>
                        <form method="POST" id="add_font" action="javascript:void(0)" enctype="multipart/form-data" files="true">
                            <input type="hidden" name="restaurant_id" value="{{ $restaurant->restaurant_id }}" />
                            <div class="modal-body">
                                <div class=" col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            @if(!empty($texture_array))
                                            <a href="javascript::void()" class="change_texture_image" data-image_src="../{{ config('images.texture_url') . 'white_texture.jpg'}}" data-texture_id="0" data-image_name="">
                                                <div class="pip menu_image">
                                                    <img class="imageThumb" src="../{{ config('images.texture_url') . 'white_texture.jpg'}}">
                                                </div>
                                            </a>
                                            @foreach($texture_array as $texture_list)
                                            <a href="javascript::void()" class="change_texture_image" data-image_src="../{{ config('images.texture_url') . $texture_list->image}}" data-texture_id="{{$texture_list->id}}" data-image_name="{{$texture_list->image}}">
                                                <div class="pip menu_image">
                                                    <img class="imageThumb" src="../{{ config('images.texture_url') . $texture_list->image}}"><br>
                                                </div>
                                            </a>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                        <input type="submit" name="submit" value="Add Font" class="btn btn-primary">
                    </div> -->
                </form>
            </div>
        </div>
    </div>
    <!-- Select Texture Image End -->
                    <!--**********************************
        Content body end
        ***********************************-->
        @include('theme.footer')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.js"></script>
        <script src="{!! asset('theme/admin/fb-banner/js/jquery-ui.min.js') !!}"></script>
        <script src="{!! asset('theme/admin/fb-banner/js/jquery.wallform.js') !!}"></script>
        <script type="text/javascript">
            $(document).ready(function(e) {
                function custom_template(obj) {
                    var data = $(obj.element).data();
                    var text = $(obj.element).text();
                    if (data && data['img_src']) {
                        img_src = data['img_src'];
                        template = $("<div><img src=\"" + img_src + "\" style=\"width:100%;height:150px;\"/><p style=\"font-weight: 700;font-size:14pt;text-align:center;\">" + text + "</p></div>");
                        return template;
                    }
                }
                var options = {
                    'templateSelection': custom_template,
                    'templateResult': custom_template,
                }
                $('#texture_image').select2(options);
                $('.select2-container--default .select2-selection--single').css({
                    'height': '220px'
                });
                var readURL = function(input) {
                    var name = input.name;
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            if (name == "restaurant_logo") {
                                $('.logo_img').attr('src', e.target.result);
                            } else {
                                console.log(e.target);
                                // $('.banner_img').attr('src', e.target.result);
                                $("#timelineBGload").show();
                                $('#timelineBGload').attr('src', e.target.result);
                            }
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                $(".file-upload").on('change', function() {
                    readURL(this);
                });
                // crop image start js fb Start

                    $('body').on('change','#restaurant_cover_image', function(){
                        readURL(this);
                    });


                    $("body").on('mouseover','.headerimage',function (){
                        var y1 = $('#timelineBackground').height();
                        var y2 =  $('.headerimage').height();
                        $(this).draggable({
                            scroll: false,
                            axis: "y",
                            drag: function(event, ui) {
                                if(ui.position.top >= 0)
                                {
                                    ui.position.top = 0;
                                }
                                else if(ui.position.top <= y1 - y2)
                                {
                                    ui.position.top = y1 - y2;
                                }
                            },
                            stop: function(event, ui)
                            {
                            }
                        });
                    });
                // crop image start js fb  End
                $('#errorMessage').html(" ");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#update_restaurant_profile').submit(function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    // crop banner image code start
                    //var p = $("#timelineBGload").attr("style");
                    //console.log(p);
                    //var Y =p.split("top:");
                    //var Z=Y[1].split(";");
                    //var dataString =Z[0];
                   // formData.append('cover_img_position',dataString)
                    // crop banner image code end
                    // console.log(formData);
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('restaurant_profile')}}",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $.each(data, function(key, value) {
                                if (key == 'error') {
                                    $.each(value, function(key1, value1) {
                                        $('#' + key1).addClass('is-invalid');
                                        $('#' + key1).parent('.error_message_parent').find('#errorMessage').html(value1);
                                    });
                                } else if (key == 'errors') {
                                    var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> ' + value + '\</div>';
                                    $('.errorMessage').html(html);
                                    location.reload(true);
                                } else if (key == 'success') {
                                    var html = '<div class="alert alert-success background-success">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Success!</strong> ' + value + '\</div>';
                                    $('.errorMessage').html(html);
                                    var user_type = '{{Auth::user()->user_type}}';
                                    if (user_type == '1') {
                                        window.location.href = '<?php echo url('home'); ?>';
                                    } else {
                                        window.location.href = '<?php echo url('restaurant-detail/' . $restaurant->restaurant_id); ?>';
                                    }

                                }
                            });
                        },
                        error: function(data) {
                            var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> Error while updating data\</div>';
                            $('.errorMessage').html(html);
                            // location.reload(true);
                        }
                    });
                });

                //Add font with font file
                $('#add_only_font').submit(function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('add_font')}}",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $.each(data, function(key, value) {
                                if (key == 'error') {
                                    $.each(value, function(key1, value1) {
                                        $('#' + key1).addClass('is-invalid');
                                        $("[name=" + key1 + "]").parent('.error_message_parent').find('#errorMessage').html(value1);
                                    });
                                } else if (key == 'errors') {
                                    var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> ' + value + '\</div>';
                                    $('.fontErrorMessage').html(html);
                                } else if (key == 'success') {
                                    var html = '<div class="alert alert-success background-success">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Success!</strong> ' + value + '\</div>';
                                    $('.fontErrorMessage').html(html);
                                    $('#add_only_font').find('.clear-field').val('');
                                    setTimeout(function() {
                                        $("#exampleModalCenter .close").click();
                                    }, 500);
                                } else if (key == 'font_list') {                                                
                                    $('#add_font input[type=text]').val('');
                                    $font_list = value;
                                    //$('#app_theme_font_type_1').html("<option value=''>Select</option>");
                                    //$('#app_theme_font_type_2').html("<option value=''>Select</option>");
                                    //$('#app_theme_font_type_3').html("<option value=''>Select</option>");
                                    //$('#app_theme_font_type_4').html("<option value=''>Select</option>");
                                    $.each($font_list, function(key1, value1) {
                                        $('#app_theme_font_type_1').append("<option value='" + value1['id'] + "'> " + value1['name'] + " </option>");
                                        $('#app_theme_font_type_2').append("<option value='" + value1['id'] + "'> " + value1['name'] + " </option>");
                                        $('#app_theme_font_type_3').append("<option value='" + value1['id'] + "'> " + value1['name'] + " </option>");
                                        $('#app_theme_font_type_4').append("<option value='" + value1['id'] + "'> " + value1['name'] + " </option>");
                                    });
                                } else if (key == 'already_exist') {
                                    $('#name').addClass('is-invalid');
                                    $("[name=name]").parent('.error_message_parent').find('#errorMessage').html(value);
                                }
                            });
                        },
                        error: function(data) {
                            var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> Error while adding data\</div>';
                            $('.fontErrorMessage').html(html);
                        }
                    });
                });


                // Add Main Category
                $('#add_font').submit(function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    //console.log(formData); return false;
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('add_font')}}",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $.each(data, function(key, value) {
                                if (key == 'error') {
                                    $.each(value, function(key1, value1) {
                                        $('#' + key1).addClass('is-invalid');
                                        $("[name=" + key1 + "]").parent('.error_message_parent').find('#errorMessage').html(value1);
                                    });
                                } else if (key == 'errors') {
                                    var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> ' + value + '\</div>';
                                    $('.fontErrorMessage').html(html);
                                } else if (key == 'success') {
                                    var html = '<div class="alert alert-success background-success">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Success!</strong> ' + value + '\</div>';
                                    $('.fontErrorMessage').html(html);                                                
                                } else if (key == 'font_list') {
                                    $('#add_font input[type=text]').val('');
                                    $font_list = value;
                                    $('#app_theme_font_type_1').html("<option value=''>Select</option>");
                                    $('#app_theme_font_type_2').html("<option value=''>Select</option>");
                                    $('#app_theme_font_type_3').html("<option value=''>Select</option>");
                                    $('#app_theme_font_type_4').html("<option value=''>Select</option>");
                                    $.each($font_list, function(key1, value1) {
                                        $('#app_theme_font_type_1').append("<option value='" + value1['id'] + "'> " + value1['name'] + " </option>");
                                        $('#app_theme_font_type_2').append("<option value='" + value1['id'] + "'> " + value1['name'] + " </option>");
                                        $('#app_theme_font_type_3').append("<option value='" + value1['id'] + "'> " + value1['name'] + " </option>");
                                        $('#app_theme_font_type_4').append("<option value='" + value1['id'] + "'> " + value1['name'] + " </option>");
                                    });
                                } else if (key == 'already_exist') {
                                    $('#name').addClass('is-invalid');
                                    $("[name=name]").parent('.error_message_parent').find('#errorMessage').html(value);
                                }
                            });
                        },
                        error: function(data) {
                            var html = '<div class="alert alert-danger background-danger">\<button type="button" class="close" data-dismiss="alert" aria-label="Close">\<i class="icofont icofont-close-line-circled text-white"></i>\</button>\<strong>Error!</strong> Error while adding data\</div>';
                            $('.fontErrorMessage').html(html);
                        }
                    });
                });

                $('input').on('keyup', function() {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                    $(this).parent('.error_message_parent').find('#errorMessage').html(" ");
                });
                $('input').on('change', function() {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                    $(this).parent('.error_message_parent').find('#errorMessage').html(" ");
                });
                $('textarea').on('keyup', function() {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                    $(this).parent('.error_message_parent').find('#errorMessage').html(" ");
                });
                $('select').on('change', function() {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                    $(this).parent('.error_message_parent').find('#errorMessage').html(" ");
                });
                // Select texture image Start 
                $(".change_texture_image").on('click', function() {
                    var texture_id = $(this).attr("data-texture_id");
                    var texture_image = '';
                    var texture_id = $(this).attr("data-texture_id");
                    var texture_image_name = $(this).attr("data-image_name");
                    var image_src = $(this).attr("data-image_src");
                    texture_image += '<div class="pip menu_image">';
                    texture_image += '<img class="imageThumb" src="' + image_src + '">';
                    texture_image += '</div>';
                    $("#texture_id").val(texture_id);
                    $('#add_texture_image').html(texture_image);
                    $("#select_texture").modal('hide');
                });
				
				var dzChartlist = function(){
	
	var screenWidth = $(window).width();
		
	var widgetChart1 = function(){
		if(jQuery('#widgetChart1').length > 0 ){
			const chart_widget_1 = document.getElementById("widgetChart1").getContext('2d');

			new Chart(chart_widget_1, {
				type: "line",
				data: {
					labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "January", "February", "March", "April"],
					datasets: [{
						label: "Sales Stats",
						backgroundColor: ['rgba(103, 66, 168, .13)'],
						borderColor: '#b79aea',
						pointBackgroundColor: '#b79aea',
						pointBorderColor: '#b79aea',
						borderWidth:2,
						pointHoverBackgroundColor: '#b79aea',
						pointHoverBorderColor: '#b79aea',
						data: [8, 7, 6, 3, 2, 4, 6, 8, 12, 6, 12, 13, 10, 18, 14, 24, 16, 12, 19, 21, 16, 14, 24, 21, 13, 15, 27, 29, 21, 11, 14, 19, 21, 17]
					}]
				},
				options: {
					title: {
						display: !1
					},
					tooltips: {
						intersect: !1,
						mode: "nearest",
						xPadding: 10,
						yPadding: 10,
						caretPadding: 10
					},
					legend: {
						display: !1
					},
					responsive: !0,
					maintainAspectRatio: !1,
					hover: {
						mode: "index"
					},
					scales: {
						xAxes: [{
							display: !1,
							gridLines: !1,
							scaleLabel: {
								display: !0,
								labelString: "Month"
							}
						}],
						yAxes: [{
							display: !1,
							gridLines: !1,
							scaleLabel: {
								display: !0,
								labelString: "Value"
							},
							ticks: {
								beginAtZero: !0
							}
						}]
					},
					elements: {
						line: {
							tension: .15
						},
						point: {
							radius: 0,
							borderWidth: 0
						}
					},
					layout: {
						padding: {
							left: 0,
							right: 0,
							top: 5,
							bottom: 0
						}
					}
				}
			});

		}
	}
	
	var widgetChart2 = function(){
		if(jQuery('#widgetChart2').length > 0 ){
			const chart_widget_2 = document.getElementById("widgetChart2").getContext('2d');

			new Chart(chart_widget_2, {
				type: "line",
				data: {
					labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "January", "February", "March", "April"],
					datasets: [{
						label: "Sales Stats",
						backgroundColor: ['rgba(103, 66, 168, .13)'],
						borderColor: '#b79aea',
						pointBackgroundColor: '#b79aea',
						pointBorderColor: '#b79aea',
						borderWidth:2,
						pointHoverBackgroundColor: '#b79aea',
						pointHoverBorderColor: '#b79aea',
						data: [19, 21, 16, 14, 24, 21, 13, 15, 27, 29, 21, 11, 14, 19, 21, 17, 12, 6, 12, 13, 10, 18, 14, 24, 16, 12, 8, 7, 6, 3, 2, 7, 6, 8]
					}]
				},
				options: {
					title: {
						display: !1
					},
					tooltips: {
						intersect: !1,
						mode: "nearest",
						xPadding: 10,
						yPadding: 10,
						caretPadding: 10
					},
					legend: {
						display: !1
					},
					responsive: !0,
					maintainAspectRatio: !1,
					hover: {
						mode: "index"
					},
					scales: {
						xAxes: [{
							display: !1,
							gridLines: !1,
							scaleLabel: {
								display: !0,
								labelString: "Month"
							}
						}],
						yAxes: [{
							display: !1,
							gridLines: !1,
							scaleLabel: {
								display: !0,
								labelString: "Value"
							},
							ticks: {
								beginAtZero: !0
							}
						}]
					},
					elements: {
						line: {
							tension: .15
						},
						point: {
							radius: 0,
							borderWidth: 0
						}
					},
					layout: {
						padding: {
							left: 0,
							right: 0,
							top: 5,
							bottom: 0
						}
					}
				}
			});

		}
	}
	var widgetChart3 = function(){
		if(jQuery('#widgetChart3').length > 0 ){
			const chart_widget_3 = document.getElementById("widgetChart3").getContext('2d');

			new Chart(chart_widget_3, {
				type: "line",
				data: {
					labels: [{!! $date_v !!}],
					datasets: [{
						label: "Views",
						backgroundColor: ['rgba(103, 66, 168, .13)'],
						borderColor: '#2e5090',
						pointBackgroundColor: '##2e5090',
						pointBorderColor: '#2e5090',
						borderWidth:2,
						pointHoverBackgroundColor: '#2e5090',
						pointHoverBorderColor: '#2e5090',
						data: [{{ $count_v }}]
					}]
				},
				options: {
					title: {
						display: !1
					},
					tooltips: {
						intersect: !1,
						mode: "nearest",
						xPadding: 10,
						yPadding: 10,
						caretPadding: 10
					},
					legend: {
						display: !1
					},
					responsive: !0,
					maintainAspectRatio: !1,
					hover: {
						mode: "index"
					},
					scales: {
						xAxes: [{
							display: !1,
							gridLines: !1,
							scaleLabel: {
								display: !0,
								labelString: "Month"
							}
						}],
						yAxes: [{
							display: !1,
							gridLines: !1,
							scaleLabel: {
								display: !0,
								labelString: "Value"
							},
							ticks: {
								beginAtZero: !0
							}
						}]
					},
					elements: {
						line: {
							tension: .15
						},
						point: {
							radius: 0,
							borderWidth: 0
						}
					},
					layout: {
						padding: {
							left: 0,
							right: 0,
							top: 5,
							bottom: 0
						}
					}
				}
			});

		}
	}
	var widgetChart4 = function(){
		if(jQuery('#widgetChart4').length > 0 ){
			const chart_widget_4 = document.getElementById("widgetChart4").getContext('2d');

			new Chart(chart_widget_4, {
				type: "line",
				data: {
					labels: ["January123", "February", "March", "April", "May", "June", "July", "August", "September", "October", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "January", "February", "March", "April"],
					datasets: [{
						label: "Sales Stats",
						backgroundColor: ['rgba(103, 66, 168, .13)'],
						borderColor: '#b79aea',
						pointBackgroundColor: '#b79aea',
						pointBorderColor: '#b79aea',
						borderWidth:2,
						pointHoverBackgroundColor: '#b79aea',
						pointHoverBorderColor: '#b79aea',
						data: [20, 18, 16, 12, 8, 10, 13, 15, 12, 6, 12, 13, 10, 18, 14, 16, 17, 15, 19, 16, 16, 14, 18, 21, 13, 15, 18, 17, 21, 11, 14, 19, 21, 17]
					}]
				},
				options: {
					title: {
						display: !1
					},
					tooltips: {
						intersect: !1,
						mode: "nearest",
						xPadding: 10,
						yPadding: 10,
						caretPadding: 10
					},
					legend: {
						display: !1
					},
					responsive: !0,
					maintainAspectRatio: !1,
					hover: {
						mode: "index"
					},
					scales: {
						xAxes: [{
							display: !1,
							gridLines: !1,
							scaleLabel: {
								display: !0,
								labelString: "Month"
							}
						}],
						yAxes: [{
							display: !1,
							gridLines: !1,
							scaleLabel: {
								display: !0,
								labelString: "Value"
							},
							ticks: {
								beginAtZero: !0
							}
						}]
					},
					elements: {
						line: {
							tension: .15
						},
						point: {
							radius: 0,
							borderWidth: 0
						}
					},
					layout: {
						padding: {
							left: 0,
							right: 0,
							top: 5,
							bottom: 0
						}
					}
				}
			});

		}
	}
	var chartBar = function(){
		var options = {
			  series: [
				{
					name: 'Net Profit',
					data: [31, 40, 28, 51, 42, 109, 100],
					//radius: 12,	
				}, 
				{
				  name: 'Revenue',
				  data: [11, 32, 45, 32, 34, 52, 41]
				}, 
				
			],
				chart: {
				type: 'area',
				height: 350,
				toolbar: {
					show: false,
				},
				
			},
			plotOptions: {
			  bar: {
				horizontal: false,
				columnWidth: '55%',
				endingShape: 'rounded'
			  },
			},
			colors:['#e5aff8', '#e3366b'],
			dataLabels: {
			  enabled: false,
			},
			markers: {
		shape: "circle",
		},
		
		
			legend: {
				show: true,
				fontSize: '12px',
				
				labels: {
					colors: '#000000',
					
				},
				position: 'bottom',
				horizontalAlign: 'center', 	
				markers: {
					width: 19,
					height: 19,
					strokeWidth: 0,
					strokeColor: '#fff',
					fillColors: undefined,
					radius: 4,
					offsetX: 0,
					offsetY: 0
				}
			},
			stroke: {
			  show: true,
			  width: 0,
			  colors:['#e5aff8', '#e3366b'],
			},
			
			grid: {
				borderColor: '#eee',
			},
			xaxis: {
				
			  categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July'],
			  labels: {
				style: {
					colors: '#3e4954',
					fontSize: '13px',
					fontFamily: 'Poppins',
					fontWeight: 100,
					cssClass: 'apexcharts-xaxis-label',
				},
			  },
			  crosshairs: {
			  show: false,
			  }
			},
			yaxis: {
				labels: {
			   style: {
				  colors: '#3e4954',
				  fontSize: '13px',
				   fontFamily: 'Poppins',
				  fontWeight: 100,
				  cssClass: 'apexcharts-xaxis-label',
			  },
			  },
			},
			fill: {
				type: 'solid',
				opacity: 0.8,
			},
			tooltip: {
			  y: {
				formatter: function (val) {
				  return "$ " + val + " thousands"
				}
			  }
			}
			};

			var chartBar1 = new ApexCharts(document.querySelector("#chartBar"), options);
			chartBar1.render();
	}
	var chartTimeline = function(){
		
		var optionsTimeline = {
			chart: {
				type: "bar",
				height: 400,
				stacked: true,
				toolbar: {
					show: false
				},
				sparkline: {
					//enabled: true
				},
				backgroundBarRadius: 5,
				offsetX: -10,
			},
			series: [
				 {
					name: "New Clients",
					data: [20, 40, 60, 35, 50, 70, 30, 15, 35, 40, 50, 60, 75, 40, 25, 70, 20, 40, 65, 50]
				},
				{
					name: "Retained Clients",
					data: [-28, -32, -12, -5, -35, -10, -30, -29, -18, -25, -38, -12, -22, -39, -35, -30, -10, -20, -35, -38]
				} 
			],
			
			plotOptions: {
				bar: {
					columnWidth: "45%",
					endingShape: "rounded",
					colors: {
						backgroundBarColors: ['rgba(0,0,0,0)', 'rgba(0,0,0,0)', 'rgba(0,0,0,0)', 'rgba(0,0,0,0)', 'rgba(0,0,0,0)', 'rgba(0,0,0,0)', 'rgba(0,0,0,0)', 'rgba(0,0,0,0)', 'rgba(0,0,0,0)', 'rgba(0,0,0,0)'],
						backgroundBarOpacity: 1,
						backgroundBarRadius: 5,
						opacity:0
					},

				},
				distributed: true
			},
			colors:['#dd2f6e', '#3e4954'],
			
			grid: {
				show: true,
			},
			legend: {
				show: false
			},
			fill: {
				opacity: 1
			},
			dataLabels: {
				enabled: false,
				colors:['#dd2f6e', '#3e4954'],
				dropShadow: {
					enabled: true,
					top: 1,
					left: 1,
					blur: 1,
					opacity: 1
				}
			},
			xaxis: {
				categories: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20'],
				labels: {
					style: {
						colors: '#787878',
						fontSize: '13px',
						fontFamily: 'Poppins',
						fontWeight: 400
						
					},
				},
				crosshairs: {
					show: false,
				},
				axisBorder: {
					show: false,
				},
			},
			
			yaxis: {
				//show: false
				labels: {
					style: {
						colors: '#787878',
						fontSize: '13px',
						fontFamily: 'Poppins',
						fontWeight: 400
						
					},
				},
			},
			
			tooltip: {
				x: {
					show: true
				}
			}
    };
		var chartTimelineRender =  new ApexCharts(document.querySelector("#chartTimeline"), optionsTimeline);
		 chartTimelineRender.render();
	}
	
	/* Function ============ */
		return {
			init:function(){
				
			},
			
			
			load:function(){
				widgetChart1();	
				widgetChart2();	
				widgetChart3();	
				widgetChart4();	
				chartBar();	
				chartTimeline();
				
			},
			
			resize:function(){
			}
		}
	
	}();

	jQuery(document).ready(function(){
	});
		
	jQuery(window).on('load',function(){
		setTimeout(function(){
			dzChartlist.load();
		}, 1000); 
		
	});

	jQuery(window).on('resize',function(){
		
		
	});     
            });
			
        </script>
		
<style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
    }

    .tabs {
      font-size: 0;

      margin-left: auto;
      margin-right: auto;
    }

    .tabs>input[type="radio"] {
      display: none;
    }

    .tabs>div {
      display: none;
      padding: 10px 15px;
      font-size: 16px;
    }

    #tab-btn-1:checked~#content-1,
    #tab-btn-2:checked~#content-2,
    #tab-btn-3:checked~#content-3 {
      display: block;
    }

    .tabs>label {
      display: inline-block;
      text-align: center;
      vertical-align: middle;
      user-select: none;
      background-color: #f5f5f5;
      border: 1px solid #e0e0e0;
      padding: 2px 8px;
      font-size: 16px;

      cursor: pointer;
      position: relative;
      top: 1px;
	  color:black;
	  padding: 10px;
	  border-radius: 10px 10px 0px 0px;
    }

    .tabs>label:not(:first-of-type) {
      border-left: none;
    }

    .tabs>input[type="radio"]:checked+label {
      background-color: #2e5090;
      border-bottom: 1px solid #2e5090;
	  color: white;
    }
  </style>