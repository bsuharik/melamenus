        </div>
        <footer>
            <div class="container">
                <div class="ft-bottomf"><span>Copyright © <?php echo date('Y') ?> All Rights Reserved {{ config('app.name') }}</span></div>
            </div>
        </footer>
        <script src="{!! asset('theme/user_app/js/jquery.min.js') !!}"></script>
        <script src="{!! asset('theme/user_app/js/materialize.min.js') !!}"></script>
        <script src="{!! asset('theme/user_app/js/slick.min.js') !!}"></script>
        <script src="{!! asset('theme/user_app/js/owl.carousel.min.js') !!}"></script>
        <script src="{!! asset('theme/user_app/js/custom.js') !!}"></script>
        <script type="text/javascript">
            $(document).ready(function (e) {
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
        </script>
    </body>
</html>
