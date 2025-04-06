<script>
    window.token = '{{ csrf_token() }}';
    window.registerAssitanceRoute = '{{ route("registerAssistance") }}';
    window.ventasDataRoute = '{{ route("obtenerDatosVentas") }}';
    window.dateIn = @json($dateIn);
</script>

@vite('resources/js/modules/home/dashboard.js')
