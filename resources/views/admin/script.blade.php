<!-- Vendor -->
<script src="{{asset('admintemp/vendor/jquery/jquery.js')}}"></script>
<script src="{{asset('admintemp/vendor/jquery-browser-mobile/jquery.browser.mobile.js')}}"></script>
<script src="{{asset('admintemp/vendor/popper/umd/popper.min.js')}}"></script>
<script src="{{asset('admintemp/vendor/bootstrap/js/bootstrap.js')}}"></script>
<script src="{{asset('admintemp/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('admintemp/vendor/common/common.js')}}"></script>
<script src="{{asset('admintemp/vendor/nanoscroller/nanoscroller.js')}}"></script>
<script src="{{asset('admintemp/vendor/magnific-popup/jquery.magnific-popup.js')}}"></script>
<script src="{{asset('admintemp/vendor/jquery-placeholder/jquery.placeholder.js')}}"></script>

<!-- Specific Page Vendor -->
{{-- <script src="{{asset('admintemp/vendor/jquery-ui/jquery-ui.js')}}"></script>
<script src="{{asset('admintemp/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js')}}"></script>
<script src="{{asset('admintemp/vendor/jquery-appear/jquery.appear.js')}}"></script>
<script src="{{asset('admintemp/vendor/bootstrap-multiselect/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('admintemp/vendor/jquery.easy-pie-chart/jquery.easypiechart.js')}}"></script>
<script src="{{asset('admintemp/vendor/flot/jquery.flot.js')}}"></script>
<script src="{{asset('admintemp/vendor/flot.tooltip/jquery.flot.tooltip.js')}}"></script>
<script src="{{asset('admintemp/vendor/flot/jquery.flot.pie.js')}}"></script>
<script src="{{asset('admintemp/vendor/flot/jquery.flot.categories.js')}}"></script>
<script src="{{asset('admintemp/vendor/flot/jquery.flot.resize.js')}}"></script>
<script src="{{asset('admintemp/vendor/jquery-sparkline/jquery.sparkline.js')}}"></script>
<script src="{{asset('admintemp/vendor/raphael/raphael.js')}}"></script>
<script src="{{asset('admintemp/vendor/morris/morris.js')}}"></script>
<script src="{{asset('admintemp/vendor/gauge/gauge.js')}}"></script>
<script src="{{asset('admintemp/vendor/snap.svg/snap.svg.js')}}"></script>
<script src="{{asset('admintemp/vendor/liquid-meter/liquid.meter.js')}}"></script>
<script src="{{asset('admintemp/vendor/jqvmap/jquery.vmap.js')}}"></script>
<script src="{{asset('admintemp/vendor/jqvmap/data/jquery.vmap.sampledata.js')}}"></script>
<script src="{{asset('admintemp/vendor/jqvmap/maps/jquery.vmap.world.js')}}"></script>
<script src="{{asset('admintemp/vendor/jqvmap/maps/continents/jquery.vmap.africa.js')}}"></script>
<script src="{{asset('admintemp/vendor/jqvmap/maps/continents/jquery.vmap.asia.js')}}"></script>
<script src="{{asset('admintemp/vendor/jqvmap/maps/continents/jquery.vmap.australia.js')}}"></script>
<script src="{{asset('admintemp/vendor/jqvmap/maps/continents/jquery.vmap.europe.js')}}"></script>
<script src="{{asset('admintemp/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js')}}"></script>
<script src="{{asset('admintemp/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js')}}"></script> --}}


<!--(remove-empty-lines-end)-->

<!-- Theme Base, Components and Settings -->
<script src="{{asset('admintemp/js/theme.js')}}"></script>

<!-- Theme Custom -->
<script src="{{asset('admintemp/js/custom.js')}}"></script>

<!-- Theme Initialization Files -->
<script src="{{asset('admintemp/js/theme.init.js')}}"></script>

<!-- Examples -->
<script src="{{asset('admintemp/js/examples/examples.dashboard.js')}}"></script>

{{-- script buat notif --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Notifikasi sukses
        const successAlert = document.getElementById('alert');
        if (successAlert) {
            setTimeout(function () {
                successAlert.style.opacity = 0; // Fade out effect
                setTimeout(function () {
                    successAlert.remove(); // Remove element from DOM
                }, 600); // Match the duration of the fade out effect
            }, 3000); // Delay before auto-close (3 seconds)
        }

        // Notifikasi error
        // const errorAlert = document.querySelector('.alert-danger');
        // if (errorAlert) {
        //     setTimeout(function () {
        //         errorAlert.style.opacity = 0;
        //         setTimeout(function () {
        //             errorAlert.remove();
        //         }, 600);
        //     }, 3000); 
        // }
    });
</script>