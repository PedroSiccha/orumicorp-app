document.addEventListener('DOMContentLoaded', function() {
    const columnToggles = document.querySelectorAll('.column-toggle');
    const table = document.querySelector('.table');

    // Aplicar configuraciones guardadas
    applyTableConfig();

    columnToggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const column = this.dataset.column;
            const columnCells = table.querySelectorAll(`td:nth-child(${parseInt(column) + 1}), th:nth-child(${parseInt(column) + 1})`);
            columnCells.forEach(cell => cell.style.display = this.checked ? '' : 'none');
        });
    });
});

function saveTableConfigLocal() {
    const columnToggles = document.querySelectorAll('.column-toggle');
    const config = Array.from(columnToggles).map(toggle => ({
        column: toggle.dataset.column,
        visible: toggle.checked
    }));
    localStorage.setItem('tableConfig', JSON.stringify(config));
}

function applyTableConfig() {
    const config = JSON.parse(localStorage.getItem('tableConfig'));
    if (config) {
        const table = document.querySelector('.table');
        config.forEach(({ column, visible }) => {
            const columnCells = table.querySelectorAll(`td:nth-child(${parseInt(column) + 1}), th:nth-child(${parseInt(column) + 1})`);
            columnCells.forEach(cell => cell.style.display = visible ? '' : 'none');
            document.querySelector(`.column-toggle[data-column="${column}"]`).checked = visible;
        });
    }
}
