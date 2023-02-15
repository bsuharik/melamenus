        </div>  



         <footer class="footer_new">

           



            <div class="container">



                <!-- <div class="ft-bottomf"><span>Copyright © <?php echo date('Y') ?> All Rights Reserved {{ config('app.name') }}</span></div> -->



                <div class="footer_menu">

                    <ul>

                        <li class="{{ Request::is('search/*') ? 'active' : '' }}">

                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">

                        Launch demo modal

                        </button> -->

                            <a href="javascript::void();" data-open='0' id="searchPopup" data-target="#exampleModal" data-toggle="modal"><i class="fa fa-search" id="fa_search"></i> Search</a>

                        </li>

                        <li class="{{ Request::is('user_home/*') ? 'active' : '' }}">

                            <a href="{{ url('user_home') }}/{{ $restaurant_details->restaurant_id}}"><i class="fa fa-home"></i> Home </a>

                        </li>

                        <li class="{{ Request::is('profile/*') || Request::is('my_profile/*') || Request::is('tags/*') || Request::is('allergies/*') || Request::is('favourite/*') ? 'active' : '' }}">

                        @if (!empty(Auth::User()->id))

                            <a href="{{ url('profile')}}/{{Auth::User()->id}}"><i class="fa fa-user"></i>Profile </a>

                        @else

                             <a href="{{url('user_login')}}/{{ $restaurant_details->restaurant_id}}" id="profile_tab"><i class="fa fa-user"></i>Profile </a>

                        @endif

                        </li>

                    </ul>

                </div>



            </div>



        </footer>

        <script src="{!! asset('theme/user_app/js/jquery.min.js') !!}"></script>

        <script src="{!! asset('theme/user_app/js/materialize.min.js') !!}"></script>

        <script src="{!! asset('theme/user_app/js/slick.min.js') !!}"></script>

        <script src="{!! asset('theme/user_app/js/owl.carousel.min.js') !!}"></script>

        <script src="{!! asset('theme/user_app/js/custom.js') !!}"></script>

        
        
        

        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

        <script type="text/javascript">

            function googleTranslateElementInit() {

                new google.translate.TranslateElement({pageLanguage: 'en-gb'},'google_translate_element');

            }

            function triggerHtmlEvent(element, eventName) {

                var event;

                if (document.createEvent) {

                    event = document.createEvent('HTMLEvents');

                    event.initEvent(eventName, true, true);

                    element.dispatchEvent(event);

                } else {

                    event = document.createEventObject();

                    event.eventType = eventName;

                    element.fireEvent('on' + event.eventType, event);

                }

            } 



            jQuery('.lang-select').click(function() {

                

                var theLang = jQuery(this).attr('data-lang');

                jQuery('.goog-te-combo').val(theLang);

            window.location = jQuery(this).attr('href');

            

        });

            </script> 

        <script type="text/javascript">

            current_page_url=$("#currenct_url").val();

            // alert(current_page_url)

            $(document).ready(function (e){ 

               

                // CSRF Token

                $.ajaxSetup({ 

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                }); 



                $('#change_language_currency').submit(function(e) {

                    e.preventDefault();



                    var restaurant_currency="{{$restaurant_details->currency_detail->currency_name}}";

                    var formData = new FormData(this);

                    formData.append("restaurant_currency",restaurant_currency);



                    // console.log($(formData));

                    // return false;



                    var languge_detail=$("#change_language").val();

                    var language_href=$("#change_language").find(':selected').attr('data-href');

                    var languge_name=$("#change_language").find(':selected').attr('data-lang');

                    formData.append("language_detail",languge_name);

                    // alert(language_href); return false;

                    var currency_code=$("#change_language").find(':selected').attr('data-currency_code');

                    // var restaurant_currency="{{$restaurant_details->currency_detail->currency_name}}";



                    $.ajax({ 

                        type:'POST',

                        url: "{{ url('change_language_currency')}}",

                        data:formData,

                        cache:false,

                        contentType: false,   

                        processData: false,

                        success: function(data){

                            

                            $.each(data, function(key, value){

                                if(key =='sucess'){

                                    if(languge_detail!=='' ){

                                        window.location = language_href;

                                    }

                                    location.reload(true);

                                }else if(key == 'select_empty'){

                                    // alert(key)

                                    var html = '<div class="alert alert-danger background-danger"><strong>Error!</strong> '+ value +'</div>';

                                    $('.errorMessage').html(html);

                                }



                            });

                        },



                    });



                });

                $("#default_language_currency").click(function(){

                    var restaurant_currency="{{$restaurant_details->currency_detail->currency_name}}";

                    var languge_detail='en';

                    var language_href='#googtrans(en|en)';

                    $.ajax({ 

                        type:'POST',

                        url: "{{ url('change_language_currency')}}",

                        data:{'default_click':1,'restaurant_currency':restaurant_currency},

                        cache:false,

                        success: function(data){

                            $.each(data, function(key, value){

                                if(key =='sucess'){

                                    

                                        window.location = current_page_url;

                                   

                                    // location.reload(true);

                                }

                            });

                        },



                    });



                });

                $('body').delegate('#fav_restaurant','click', function(){

                    var restaurant_id = "{{$restaurant_details->restaurant_id}}";

                    $.ajax({

                        type: "POST",

                        url: "{{ url('fav_restaurant') }}", 

                        data:  {restaurant_id:restaurant_id},

                        dataType: "json",

                        success: function(data){

                            $.each(data, function(key, value){

                                if(key == 'success'){

                                    window.location.reload();

                                }

                                else if(key == 'login_error'){

                                    var redirect_url = "{{ url('user_login') }}/{{ $restaurant_details->restaurant_id }}";

                                    window.location.href = redirect_url;

                                }

                            });

                        }

                    });

                });

                $(document).on('click', '.menu_item_count', function() {

                    var clickCount = $(this).attr('data-menu_count');

                    var menu_id=$(this).attr('data-menu_id');

                    if(clickCount==0) {

                        clickCount = 0

                    }

                    clickCount++;

                    $.ajax({

                        url: "{{ url('visit_menu_item_count')}}",

                        type: "POST",

                        cache:false,

                        data: {'count_number':clickCount,'menu_id':menu_id},

                        success: function(data){

                            // alert('sucess');

                        }

                    });

                });

                $("#redirect_user_login").click(function (e) {

                    var restaurant_id = $(this).attr("data-id");

                    var url = "{{ url('user_login') }}";



                    var redirect_url = url+"/"+restaurant_id;



                    window.location.replace(redirect_url);

                });



                $("#redirect_user_signup").click(function (e) { 

                    var restaurant_id = $(this).attr("data-id"); 

                    var url = "{{ url('user_signup') }}";



                    var redirect_url = url+"/"+restaurant_id;



                    window.location.replace(redirect_url);

                });

                

            });
            $("#open_popup").click(function(){
                document.getElementById("myForm").style.display = "block";
                $(this).attr('data-open',0);
                document.getElementById("searchForm").style.display = "none";
            });

            $("#close_popup").click(function(){
                document.getElementById("myForm").style.display = "none";
            });

            $("#searchPopup").click(function(){ 
                var model_type=$(this).attr('data-open');
                if(model_type ==0){
                    $(this).attr('data-open',1);
                    document.getElementById("searchForm").style.display = "block";
                }else{
                    $(this).attr('data-open',0);
                    $("#search").val('');
                    document.getElementById("searchForm").style.display = "none";
                }
                document.getElementById("myForm").style.display = "none";

            });

            $("#close_search_popup").click(function(){ 
                $("#search").val('');
                $("#searchPopup").attr('data-open',0);
                document.getElementById("searchForm").style.display = "none";
            }); 
            var searchPopup = document.getElementById('searchPopup');
            var fa_search = document.getElementById('fa_search');

            var formPopup = document.getElementById('open_popup');
            var fa_globe = document.getElementById('fa_globe');
            window.onclick = function(event) {
                var search_container = $("#searchForm");
                if ($(event.target).closest(search_container).length == 0) {
                    if (event.target == searchPopup || event.target == fa_search){
                        $(this).attr('data-open',1);
                        document.getElementById("searchForm").style.display = "block";
                    }else{
                         $("#searchPopup").attr('data-open',0);
                         $("#search").val('');
                       document.getElementById("searchForm").style.display = "none"; 
                    }
                     
                }else{
                    $(this).attr('data-open',0);
                    document.getElementById("searchForm").style.display = "block";
                }
                var form_container = $("#myForm");
                if($(event.target).closest(form_container).length == 0) {
                    if (event.target == formPopup || event.target == fa_globe){
                        document.getElementById("myForm").style.display = "block";
                    }else{
                       document.getElementById("myForm").style.display = "none"; 
                    }
                }else{
                    document.getElementById("myForm").style.display = "block";
                }
            }
        </script>
    </body>
</html>

