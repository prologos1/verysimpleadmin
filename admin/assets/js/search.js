document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const searchTerm = document.getElementById('searchInput').value;
        const url = `table.php?table=${tableName}&page=1&search=${searchTerm}`; // Сбрасываем страницу на 1

        window.location.href = url; // Перенаправляем на URL с поиском
    });
});
