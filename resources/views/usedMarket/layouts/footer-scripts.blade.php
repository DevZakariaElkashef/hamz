<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
<!-- JQuery min js -->
<script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap Bundle js -->
<script src="{{ URL::asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Ionicons js -->
<script src="{{ URL::asset('assets/plugins/ionicons/ionicons.js') }}"></script>
<!-- Moment js -->
<script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script>

<!-- Rating js-->
<script src="{{ URL::asset('assets/plugins/rating/jquery.rating-stars.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/rating/jquery.barrating.js') }}"></script>

<!--Internal  Perfect-scrollbar js -->
<script src="{{ URL::asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/perfect-scrollbar/p-scroll.js') }}"></script>
<!--Internal Sparkline js -->
<script src="{{ URL::asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<!-- Custom Scroll bar Js-->
<script src="{{ URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
@if (app()->getLocale() == 'ar')
    <!-- right-sidebar js -->
    <script src="{{ URL::asset('assets/plugins/sidebar/sidebar-rtl.js') }}"></script>
@else
    <!-- right-sidebar js -->
    <script src="{{ URL::asset('assets/plugins/sidebar/sidebar.js') }}"></script>
@endif
<script src="{{ URL::asset('assets/plugins/sidebar/sidebar-custom.js') }}"></script>
<!-- Eva-icons js -->
<script src="{{ URL::asset('assets/js/eva-icons.min.js') }}"></script>
@yield('js')
<!-- Sticky js -->
<script src="{{ URL::asset('assets/js/sticky.js') }}"></script>
<!-- custom js -->
<script src="{{ URL::asset('assets/js/custom.js') }}"></script><!-- Left-menu js-->
<script src="{{ URL::asset('assets/plugins/side-menu/sidemenu.js') }}"></script>
<!-- sidebar session js -->
<script>
    var favoriteCount = document.getElementById('favorite-count');

    function sidebar_session(setter = false, value = 0) {
        if (setter == true) {
            sessionStorage.setItem("sidebar", value);
        } else {
            status = sessionStorage.getItem("sidebar");
            if (status == 1) {
                document.body.classList.add("sidenav-toggled");
            }
        }

        let canvases = document.getElementsByClassName('chart-line');

        for (let i = 0; i < canvases.length; i++) {
            if (i % 2 == 1) {
                canvases[i].style.width = "auto";
                canvases[i].style.margin = "auto";
            } else {
                canvases[i].style.width = "100%";
            }
        }
    }

    window.onload = sidebar_session;
</script>
@include('layouts.custom-script')
