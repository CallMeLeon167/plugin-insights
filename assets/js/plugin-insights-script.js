function filterPlugins() {
    let table = document.getElementById("plugin-table");
    let rows = table.getElementsByTagName("tr");
    for (let i = 0; i < rows.length; i++) {
        let row = rows[i];
        if (row.parentNode.nodeName === 'TBODY') {
            if (!row.classList.contains("update-available")) {
                row.classList.toggle("hidden");
            }
        }
    }
}