document.addEventListener('DOMContentLoaded', function () {
    const columnToggles = document.querySelectorAll('.column-toggle'); // Checkboxes del modal
    const table = document.querySelector('.table'); // Tabla principal

    if (!table) {
        console.error('La tabla no está presente en el DOM.');
        return;
    }

    // Función para mostrar/ocultar columnas
    function toggleColumn(columnIndex, visible) {
        console.log(`Toggleando columna ${columnIndex}: ${visible ? 'Mostrar' : 'Ocultar'}`);
        const cells = document.querySelectorAll(`.table thead th:nth-child(${columnIndex + 2}), .table tbody td:nth-child(${columnIndex + 2})`);
        cells.forEach(cell => {
            cell.style.display = visible ? '' : 'none';
        });
    }

    // Aplicar configuraciones guardadas desde localStorage
    function applyTableConfig() {
        const savedConfig = JSON.parse(localStorage.getItem('tableConfig')) || [];

        columnToggles.forEach(toggle => {
            const columnIndex = parseInt(toggle.dataset.column, 10);
            const savedColumn = savedConfig.find(c => c.column == columnIndex);
            const isVisible = savedColumn ? savedColumn.visible : true;

            toggle.checked = isVisible; // Sincroniza el estado del checkbox
            toggleColumn(columnIndex, isVisible); // Aplica visibilidad en la tabla
        });
    }

    // Guardar la configuración en localStorage
    function saveTableConfigLocal() {
        const config = Array.from(columnToggles).map(toggle => ({
            column: toggle.dataset.column,
            visible: toggle.checked
        }));
        console.log('Guardando configuración en localStorage:', config);
        localStorage.setItem('tableConfig', JSON.stringify(config));
    }

    // Evento de cambio en checkboxes
    columnToggles.forEach(toggle => {
        toggle.addEventListener('change', function () {
            const columnIndex = parseInt(this.dataset.column, 10);
            toggleColumn(columnIndex, this.checked);
            saveTableConfigLocal(); // Guarda la configuración actualizada
        });
    });

    // Detectar cambios en la tabla y volver a aplicar la configuración
    const observer = new MutationObserver(() => {
        console.log('La tabla se ha actualizado, aplicando configuración...');
        applyTableConfig();
    });

    observer.observe(document.querySelector('#tabClient'), { childList: true, subtree: true });

    // Aplicar configuración al cargar la página
    applyTableConfig();
});
