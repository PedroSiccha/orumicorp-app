{{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script> --}}

 <!-- Toastr JS -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ asset('js/utils/updateClockMenu.js') }}"></script>
    
    <script src="{{ asset('js/utils/dateMenu.js') }}"></script>
    {{-- <script src="{{ asset('js/task/task.js') }}" defer></script> --}}
    {{-- <script src="{{ asset('js/utils/notifications.js') }}"></script> --}}
    <!-- Mainly scripts -->
    <script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Flot -->
    <script src="{{asset('js/plugins/flot/jquery.flot.js')}}"></script>
    <script src="{{asset('js/plugins/flot/jquery.flot.tooltip.min.js')}}"></script>
    <script src="{{asset('js/plugins/flot/jquery.flot.spline.js')}}"></script>
    <script src="{{asset('js/plugins/flot/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('js/plugins/flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('js/plugins/flot/jquery.flot.symbol.js')}}"></script>
    <script src="{{asset('js/plugins/flot/jquery.flot.time.js')}}"></script>
    <script src="{{ asset('js/plugins/flot/curvedLines.js') }}"></script>

    <!-- Peity -->
    <script src="{{asset('js/plugins/peity/jquery.peity.min.js')}}"></script>
    <script src="{{asset('js/demo/peity-demo.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{asset('js/inspinia.js')}}"></script>
    <script src="{{asset('js/plugins/pace/pace.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- Jvectormap -->
    <script src="{{asset('js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>

    <!-- EayPIE -->
    <script src="{{asset('js/plugins/easypiechart/jquery.easypiechart.js')}}"></script>

    <!-- Sparkline -->
    <script src="{{asset('js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{asset('js/demo/sparkline-demo.js')}}"></script>
    <script src="{{asset('js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>

    <script src="{{ asset('js/plugins/ladda/spin.min.js') }}"></script>
    <script src="{{ asset('js/plugins/ladda/ladda.min.js') }}"></script>
    <script src="{{ asset('js/plugins/ladda/ladda.jquery.min.js') }}"></script>

    <!-- FooTable -->
    <script src="{{asset('js/plugins/footable/footable.all.min.js')}}"></script>
    <script src="{{ asset('js/rouletteManagement/updateGiro.js') }}"></script>
    <script src="{{ asset('js/rouletteManagement/getPremio.js') }}"></script>
    <script src="{{asset('js/ruleta.js')}}"></script>
    <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/voiso/initiateCall.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>
    <script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>
    {{-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script> --}}

    <script>
            var updateGiroRoute = '{{ route("updateGiro") }}';
            var getPremioRoute = '{{ route("getPremio") }}';
            var notiffyShooterRoute = '{{ route("notiffyShooter") }}';
            var token = '{{ csrf_token() }}';
            var initiateCallRoute = '{{ route("initiateCall") }}';
            
            $(document).ready(function() {

                $('#date_added').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true
                });

                $('.chart').easyPieChart({
                    barColor: '#f8ac59',
                    scaleLength: 5,
                    lineWidth: 4,
                    size: 80
                });

                $('.chart2').easyPieChart({
                    barColor: '#1c84c6',
                    scaleLength: 5,
                    lineWidth: 4,
                    size: 80
                });

                var data2 = [
                    [gd(2012, 1, 1), 7], [gd(2012, 1, 2), 6], [gd(2012, 1, 3), 4], [gd(2012, 1, 4), 8],
                    [gd(2012, 1, 5), 9], [gd(2012, 1, 6), 7], [gd(2012, 1, 7), 5], [gd(2012, 1, 8), 4],
                    [gd(2012, 1, 9), 7], [gd(2012, 1, 10), 8], [gd(2012, 1, 11), 9], [gd(2012, 1, 12), 6],
                    [gd(2012, 1, 13), 4], [gd(2012, 1, 14), 5], [gd(2012, 1, 15), 11], [gd(2012, 1, 16), 8],
                    [gd(2012, 1, 17), 8], [gd(2012, 1, 18), 11], [gd(2012, 1, 19), 11], [gd(2012, 1, 20), 6],
                    [gd(2012, 1, 21), 6], [gd(2012, 1, 22), 8], [gd(2012, 1, 23), 11], [gd(2012, 1, 24), 13],
                    [gd(2012, 1, 25), 7], [gd(2012, 1, 26), 9], [gd(2012, 1, 27), 9], [gd(2012, 1, 28), 8],
                    [gd(2012, 1, 29), 5], [gd(2012, 1, 30), 8], [gd(2012, 1, 31), 25]
                ];

                var data3 = [
                    [gd(2012, 1, 1), 800], [gd(2012, 1, 2), 500], [gd(2012, 1, 3), 600], [gd(2012, 1, 4), 700],
                    [gd(2012, 1, 5), 500], [gd(2012, 1, 6), 456], [gd(2012, 1, 7), 800], [gd(2012, 1, 8), 589],
                    [gd(2012, 1, 9), 467], [gd(2012, 1, 10), 876], [gd(2012, 1, 11), 689], [gd(2012, 1, 12), 700],
                    [gd(2012, 1, 13), 500], [gd(2012, 1, 14), 600], [gd(2012, 1, 15), 700], [gd(2012, 1, 16), 786],
                    [gd(2012, 1, 17), 345], [gd(2012, 1, 18), 888], [gd(2012, 1, 19), 888], [gd(2012, 1, 20), 888],
                    [gd(2012, 1, 21), 987], [gd(2012, 1, 22), 444], [gd(2012, 1, 23), 999], [gd(2012, 1, 24), 567],
                    [gd(2012, 1, 25), 786], [gd(2012, 1, 26), 666], [gd(2012, 1, 27), 888], [gd(2012, 1, 28), 900],
                    [gd(2012, 1, 29), 178], [gd(2012, 1, 30), 555], [gd(2012, 1, 31), 993]
                ];


                var dataset = [
                    {
                        label: "Number of orders",
                        data: data3,
                        color: "#1ab394",
                        bars: {
                            show: true,
                            align: "center",
                            barWidth: 24 * 60 * 60 * 600,
                            lineWidth:0
                        }

                    }, {
                        label: "Payments",
                        data: data2,
                        yaxis: 2,
                        color: "#1C84C6",
                        lines: {
                            lineWidth:1,
                                show: true,
                                fill: true,
                            fillColor: {
                                colors: [{
                                    opacity: 0.2
                                }, {
                                    opacity: 0.4
                                }]
                            }
                        },
                        splines: {
                            show: false,
                            tension: 0.6,
                            lineWidth: 1,
                            fill: 0.1
                        },
                    }
                ];


                var options = {
                    xaxis: {
                        mode: "time",
                        tickSize: [3, "day"],
                        tickLength: 0,
                        axisLabel: "Date",
                        axisLabelUseCanvas: true,
                        axisLabelFontSizePixels: 12,
                        axisLabelFontFamily: 'Arial',
                        axisLabelPadding: 10,
                        color: "#d5d5d5"
                    },
                    yaxes: [{
                        position: "left",
                        max: 1070,
                        color: "#d5d5d5",
                        axisLabelUseCanvas: true,
                        axisLabelFontSizePixels: 12,
                        axisLabelFontFamily: 'Arial',
                        axisLabelPadding: 3
                    }, {
                        position: "right",
                        clolor: "#d5d5d5",
                        axisLabelUseCanvas: true,
                        axisLabelFontSizePixels: 12,
                        axisLabelFontFamily: ' Arial',
                        axisLabelPadding: 67
                    }
                    ],
                    legend: {
                        noColumns: 1,
                        labelBoxBorderColor: "#000000",
                        position: "nw"
                    },
                    grid: {
                        hoverable: false,
                        borderWidth: 0
                    }
                };

                function gd(year, month, day) {
                    return new Date(year, month - 1, day).getTime();
                }

                var previousPoint = null, previousLabel = null;

                // $.plot($("#flot-dashboard-chart"), dataset, options);

                var mapData = {
                    "US": 298,
                    "SA": 200,
                    "DE": 220,
                    "FR": 540,
                    "CN": 120,
                    "AU": 760,
                    "BR": 550,
                    "IN": 200,
                    "GB": 120,
                };

                $('#world-map').vectorMap({
                    map: 'world_mill_en',
                    backgroundColor: "transparent",
                    regionStyle: {
                        initial: {
                            fill: '#e4e4e4',
                            "fill-opacity": 0.9,
                            stroke: 'none',
                            "stroke-width": 0,
                            "stroke-opacity": 0
                        }
                    },

                    series: {
                        regions: [{
                            values: mapData,
                            scale: ["#1ab394", "#22d6b1"],
                            normalizeFunction: 'polynomial'
                        }]
                    },
                });
            });

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "progressBar": true,
                "preventDuplicates": false,
                "positionClass": "toast-top-center",
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "1000",
                "timeOut": "10000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            const notifications = [
                { type: 'success', message: '¡Bienvenido! Esto es un mensaje de éxito.' },
                { type: 'info', message: 'Nueva actualización disponible.' },
                { type: 'warning', message: 'Tu suscripción está a punto de vencer.' },
                { type: 'error', message: 'Ha ocurrido un error en el sistema.' }
            ];

    </script>
    <script src="{{ asset('js/utils/getNotify.js') }}"></script>
@yield('script')
