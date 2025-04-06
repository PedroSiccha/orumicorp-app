<script>
    window.token = '{{ csrf_token() }}';
    window.registerAssitanceRoute = '{{ route("registerAssistance") }}';
    window.dateIn = @json($dateIn);
</script>
@if (auth()->user()->can('Estadistica de Ventas'))
<script>
    window.ventasDataRoute = '{{ route("obtenerDatosVentas") }}';
</script>
@endif

@vite('resources/js/modules/home/dashboard.js')
