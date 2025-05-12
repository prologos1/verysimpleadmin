document.addEventListener('DOMContentLoaded', function() {
    function generatePagination(currentPage, totalPages, tableName, search) {
        let paginationHTML = '';

        if (currentPage > 1) {
            paginationHTML += `<li class="page-item"><a class="page-link" href="#" data-page="${currentPage - 1}">Предыдущая</a></li>`;
        }

        for (let i = 1; i <= totalPages; i++) {
            const activeClass = (i === currentPage) ? 'active' : '';
            paginationHTML += `<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        }

        if (currentPage < totalPages) {
            paginationHTML += `<li class="page-item"><a class="page-link" href="#" data-page="${currentPage + 1}">Следующая</a></li>`;
        }

        document.getElementById('pagination').innerHTML = paginationHTML;
    }
	



    function loadTableData(page, tableName, search, primaryKeyName) { // Добавляем primaryKeyName
        const url = `table.php?table=${tableName}&page=${page}&ajax=1&search=${search}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                const tableData = data.data;
                const primaryKeyName = data.primaryKeyName; // Получаем из JSON

                let tableBodyHTML = '';
                tableData.forEach(row => {
                    let rowHTML = '<tr>';
                    rowHTML += `<td>${row[primaryKeyName] || 'N/A'}</td>`;

                    const structure = Object.keys(row);
                    structure.forEach(column => {
                        if (column !== primaryKeyName) {
                            rowHTML += `<td>${row[column] || 'N/A'}</td>`;
                        }
                    });

                    rowHTML += `<td>
                                <a href="form.php?table=${tableName}&id=${row[primaryKeyName]}&action=update&primaryKeyName=${primaryKeyName}" class="btn btn-primary btn-sm">Редактировать</a>
                                <a href="actions/delete.php?table=${tableName}&id=${row[primaryKeyName]}&primaryKeyName=${primaryKeyName}" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены?')">Удалить</a>
                            </td>`;

                    rowHTML += '</tr>';
                    tableBodyHTML += rowHTML;
                });
                document.getElementById('tableBody').innerHTML = tableBodyHTML;
            })
            .catch(error => console.error('Ошибка:', error));
    }

    generatePagination(currentPage, totalPages, tableName, search);

    document.getElementById('pagination').addEventListener('click', function(event) {
        if (event.target.tagName === 'A') {
            event.preventDefault();
            const page = parseInt(event.target.dataset.page);
            loadTableData(page, tableName, search, primaryKeyName); // Передаем имя ключа
            generatePagination(page, totalPages, tableName, search);
        }
    });

 
});
