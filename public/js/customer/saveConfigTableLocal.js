// Esperar a que el DOM cargue completamente
// y luego ejecutar la carga de configuración
document.addEventListener("DOMContentLoaded", function () {
    console.log("🔄 DOM completamente cargado. Aplicando configuración...");
    
    if (typeof loadTableConfig === 'function') {
        loadTableConfig();
    } else {
        console.error("❌ ERROR: loadTableConfig no está definida.");
    }
    // ✅ Evento para mostrar u ocultar el selector de roles
    document.getElementById("configScope").addEventListener("change", function () {
        var selectedValue = this.value;
        var roleSelectorDiv = document.getElementById("roleSelector");

        if (selectedValue === "role") {
            roleSelectorDiv.style.display = "block"; // ✅ Mostrar si selecciona "Guardar para Rol"
        } else {
            roleSelectorDiv.style.display = "none"; // ✅ Ocultar si selecciona "Guardar para Usuario"
        }
    });
});

const tableName = "tabla_clientes";
const configUrl = `/get-table-config/${tableName}`;
const saveConfigUrl = `/save-table-config`;
const resetConfigUrl = `/reset-table-config`; 

function loadTableConfig() {
    console.log("📥 Cargando configuración desde el servidor...");
    
    fetch(configUrl)
        .then(response => response.json())
        .then(data => {
            console.log("✅ Configuración obtenida desde la BD:", data);
            
            if (data.config && data.config.length > 0) {
                applyTableConfig(data.config);
            } else {
                console.warn("⚠️ No hay configuración guardada, mostrando todas las columnas.");
            }
        })
        .catch(error => console.error("❌ Error al obtener configuración:", error));
}

function applyTableConfig(visibleColumns) {
    console.log("✅ Aplicando configuración:", visibleColumns);
    
    document.querySelectorAll(".table th, .table td").forEach(el => {
        el.style.display = "";
    });
    
    document.querySelectorAll(".column-toggle").forEach(toggle => {
        let columnIndex = toggle.dataset.column;
        let isVisible = visibleColumns.includes(columnIndex);
        toggle.checked = isVisible;
        
        if (!isVisible) {
            document.querySelectorAll(`.table thead th:nth-child(${parseInt(columnIndex) + 1}), 
                                       .table tbody td:nth-child(${parseInt(columnIndex) + 1})`)
                .forEach(el => el.style.display = "none");
        }
    });
    
    if ($.fn.DataTable) {
        console.log("🔄 Redibujando DataTable...");
        $('.dataTables-example').DataTable().columns.adjust().draw();
    }
}

function saveTableConfig() {
    let selectedColumns = [];
    document.querySelectorAll(".column-toggle:checked").forEach(el => {
        selectedColumns.push(el.dataset.column);
    });
    
    let scope = document.getElementById("configScope").value;
    let roleId = scope === "role" ? document.getElementById("roleSelectorId").value : null;
    
    fetch(saveConfigUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify({
            table_name: tableName,
            visible_columns: selectedColumns,
            scope: scope,
            role_id: roleId
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log("✅ Configuración guardada:", data);
        $('#modalConfigTableLocal').modal('hide');
        mostrarMensaje('Correcto', 'Configuración guardada correctamente.', 'success');
        loadTableConfig();
    })
    .catch(error => console.error("❌ Error al guardar configuración:", error));
}

function resetTableConfig() {
    
    let selectedColumns = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21"];
    
    let scope = document.getElementById("configScope").value;
    let roleId = scope === "role" ? document.getElementById("roleSelectorId").value : null;
    
    fetch(saveConfigUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify({
            table_name: tableName,
            visible_columns: selectedColumns,
            scope: scope,
            role_id: roleId
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log("✅ Configuración guardada:", data);
        $('#modalConfigTableLocal').modal('hide');
        mostrarMensaje('Correcto', 'Configuración guardada correctamente.', 'success');
        loadTableConfig();
    })
    .catch(error => console.error("❌ Error al guardar configuración:", error));
}

document.getElementById("saveConfigBtn").addEventListener("click", saveTableConfig);
document.getElementById("resetConfigBtn").addEventListener("click", resetTableConfig);
loadTableConfig();
