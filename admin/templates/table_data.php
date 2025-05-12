<h2>Таблица: <?= htmlspecialchars($tableName) ?></h2>

<div class="row mb-3">
    <div class="col-md-6">
        <a href="form.php?table=<?= htmlspecialchars($tableName) ?>&action=create" class="btn btn-success">Добавить запись</a>
    </div>
    <div class="col-md-6">
        <form id="searchForm">
            <div class="input-group">
                <input type="text" class="form-control" id="searchInput" placeholder="Поиск..." value="<?= htmlspecialchars($search ?? '') ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Найти</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="tableDataContainer">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <? // htmlspecialchars($primaryKeyName) ?>
                <?php foreach ($structure as $column): ?>
                    <th><?= htmlspecialchars($column['Field']) ?></th>
                <?php endforeach; ?>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php foreach ($data as $row): ?>
                <tr>
                    <? // htmlspecialchars($row[$primaryKeyName] ?? 'N/A') ?>
                    <?php foreach ($structure as $column): ?>
                        <td><?= htmlspecialchars($row[$column['Field']] ?? 'N/A') ?></td>
                    <?php endforeach; ?>
                    <td>
                        <a href="form.php?table=<?= htmlspecialchars($tableName) ?>&id=<?= htmlspecialchars($row[$primaryKeyName]) ?>&action=update&primaryKeyName=<?= htmlspecialchars($primaryKeyName) ?>" class="btn btn-primary btn-sm">Редактировать</a>
                        <a href="actions/delete.php?table=<?= htmlspecialchars($tableName) ?>&id=<?= htmlspecialchars($row[$primaryKeyName]) ?>&primaryKeyName=<?= htmlspecialchars($primaryKeyName) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены?')">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<nav aria-label="Page navigation">
    <ul class="pagination" id="pagination">
        <!-- Сгенерируется JS -->
    </ul>
</nav>

<script>
    const tableName = '<?= htmlspecialchars($tableName) ?>';
    const currentPage = <?= $page ?>;
    const totalPages = <?= $totalPages ?>;
    const search = '<?= htmlspecialchars($search ?? '') ?>';
    const primaryKeyName = '<?= htmlspecialchars($primaryKeyName) ?>'; 
</script>

<script src="assets/js/pagination.js"></script>
<script src="assets/js/search.js"></script>
