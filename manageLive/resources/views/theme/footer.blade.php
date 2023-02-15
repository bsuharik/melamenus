        </div>
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright @ {{ config('app.name') }} <?php echo date('Y') ?></p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{!! asset('theme/admin/js/global.min.js') !!}"></script>
    <script>
        $(document).ready(function(){            
            $(".metismenu li").each(function(){
                $(this).hover(
                    

                     function () {
                        if($('.hamburger').hasClass('is-active')) {
                        $('.hamburger').trigger('click');
                        //$('.hamburger').removeClass('is-active');
                    }      
                       }, 
                        
                       function () {
                         if(!$('.hamburger').hasClass('is-active')) {
                            $('.hamburger').trigger('click');
                            //$('.hamburger').removeClass('is-active');
                        }
                       }
                );
            });            
        });
    </script>
    <!-- <script src="{!! asset('theme/admin/js/bootstrap-select.min.js') !!}"></script> -->
    <script src="{!! asset('theme/admin/vendor/chart.js/Chart.bundle.min.js') !!}"></script>
    <script src="{!! asset('theme/admin/js/custom.min.js') !!}"></script>
    <script src="{!! asset('theme/admin/js/deznav-init.js') !!}"></script>
    
    <!-- Required vendors -->

    <!-- Datatable -->
    <script src="{!! asset('theme/admin/js/jquery.dataTables.min.js') !!}"></script>
    <script>
        (function($) {
         
            var table = $('#example5').DataTable({
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
    </script>
    
    <script src="{!! asset('theme/admin/vendor/highlightjs/highlight.pack.min.js') !!}"></script>
    <!-- Circle progress --> 

    <!-- Apex Chart -->
    <script src="{!! asset('theme/admin/vendor/apexchart/apexchart.js') !!}"></script>
    
    <!-- Dashboard 1 -->
    <script src="{!! asset('theme/admin/js/dashboard/dashboard-1.js') !!}"></script>

    <!-- Apex Chart -->

    <script src="{!! asset('theme/admin/js/lightgallery-all.min.js') !!}"></script>

    <!-- Custom search -->
    <script src="{!! asset('theme/admin/js/custom_search.js') !!}"></script>
    <script>
        
        $('#lightgallery').lightGallery({
            loop:true,
            thumbnail:true,
            exThumbImage: 'data-exthumbimage'
        });
    </script>
    <!-- asColorPicker -->
    <script src="{!! asset('theme/admin/js/jquery-asColor.min.js') !!}"></script>
    <script src="{!! asset('theme/admin/js/jquery-asGradient.min.js') !!}"></script>
    <script src="{!! asset('theme/admin/js/jquery-asColorPicker.min.js') !!}"></script>
    <script src="{!! asset('theme/admin/js/jquery-asColorPicker.init.js') !!}"></script>
    <!-- <script src="{!! asset('theme/admin/js/material-date-picker-init.js') !!}"></script> -->
    
</body>
</html>