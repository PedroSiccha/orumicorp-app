$(document).ready(function () {
    const selectors = {
        startDate: '#date_added_init',
        endDate: '#date_added_end',
        area: '#area',
        agent: '#inputAgentSelect',
        clearBtn: '#clearFilters',
        tableContainer: '#tabVenta'
    };

    const defaultStart = '01/01/' + new Date().getFullYear();
    const defaultEnd = formatDate(new Date());

    initDatepickers();
    initSelect2Agent();
    bindEvents();
    fetchFilteredSales(); // carga inicial

    // 🔁 Cargar datos filtrados vía AJAX
    function fetchFilteredSales(page) {
        // Aseguramos que sea un número válido
        if (typeof page !== 'number') {
            page = parseInt($(this).data('page')) || 1;
        }
        const start = $(selectors.startDate).val();
        const end = $(selectors.endDate).val();
    
        // Nueva validación estricta
        if (!start || !start.trim()) {
            showDateError();
            return;
        }
    
        removeDateError();
    
        const filters = {
            dateInit: start,
            dateEnd: end || '',
            area: $(selectors.area).val() || '',
            agentId: $(selectors.agent).val() ? $(selectors.agent).val().toString() : '',
            page: page,
            _token: typeof token !== 'undefined' ? token : ''
        };
    
        console.log('🔍 Enviando filtros:', filters);
        showSkeleton();
    
        $.post(filterSalesRoute, filters)
            .done(function (data) {
                $(selectors.tableContainer).html(data.view);
            })
            .fail(function () {
                $(selectors.tableContainer).html('<div class="alert alert-danger">Error al cargar los resultados.</div>');
            });
    }

    // En filterSales.js (dentro de $(document).ready o justo después de renderizar)
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();

        const page = $(this).attr('href').split('page=')[1];
        if (page) {
            fetchFilteredSales(Number(page));
        }
    });

    

    // 📅 Inicializa los campos de fecha con formato DD/MM/AAAA
    function initDatepickers() {
        const options = {
            format: 'dd/mm/yyyy',
            autoclose: true
        };

        $(selectors.startDate).datepicker(options).datepicker('update', defaultStart);
        $(selectors.endDate).datepicker(options).datepicker('update', defaultEnd);
    }

    // 🧠 Asigna eventos a todos los filtros
    function bindEvents() {
        $(selectors.startDate).on('change', function () {
            removeDateError();
            fetchFilteredSales();
        });

        $(selectors.endDate).on('change', function () {
            if (!$(selectors.startDate).val()) {
                showDateError();
                return;
            }
            fetchFilteredSales();
        });

        $(selectors.area).on('change', fetchFilteredSales);
        $(selectors.clearBtn).on('click', resetFilters);

        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            const page = $(this).attr('href').split('page=')[1];
            fetchFilteredSales(page);
        });
    }

    // 🧼 Reset de filtros a sus valores por defecto
    function resetFilters() {
        $(selectors.startDate).datepicker('update', defaultStart);
        $(selectors.endDate).datepicker('update', defaultEnd);
        $(selectors.area).val('').trigger('change');
        $(selectors.agent).val(null).trigger('change');
        fetchFilteredSales();
    }

    // 🔍 Inicializa Select2 para buscar agentes por AJAX
    function initSelect2Agent() {
        $(selectors.agent).select2({
            placeholder: 'Buscar agente...',
            allowClear: true,
            width: '100%',
            minimumInputLength: 2,
            ajax: {
                url: agentSearchRoute,
                dataType: 'json',
                delay: 300,
                data: function (params) {
                    return { term: params.term };
                },
                processResults: function (data) {
                    return { results: data.results };
                }
            }
        });

        $(selectors.agent).on('change', fetchFilteredSales);
    }

    // ⛔ Aplica estilo de error si falta fecha de inicio
    function showDateError() {
        $(selectors.startDate).addClass('border border-danger');
    }

    function removeDateError() {
        $(selectors.startDate).removeClass('border border-danger');
    }

    // 🕓 Muestra un esqueleto de carga mientras se espera respuesta
    function showSkeleton() {
        let html = '<table class="table table-striped"><thead><tr>';
        html += '<th colspan="11"><div class="spinner-border spinner-border-sm text-primary" role="status"></div> Cargando ventas...</th>';
        html += '</tr></thead><tbody>';
        for (let i = 0; i < 8; i++) {
            html += '<tr><td colspan="11"><div class="placeholder-glow"><span class="placeholder col-12"></span></div></td></tr>';
        }
        html += '</tbody></table>';
        $(selectors.tableContainer).html(html);
    }

    // 🧮 Formatea la fecha de hoy al formato DD/MM/YYYY
    function formatDate(date) {
        const day = ('0' + date.getDate()).slice(-2);
        const month = ('0' + (date.getMonth() + 1)).slice(-2);
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    }
});
