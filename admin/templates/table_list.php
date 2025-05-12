<h2>Список таблиц</h2>
<ul>
    <?php foreach ($tables as $table): ?>
        <li><a href="table.php?table=<?= htmlspecialchars($table) ?>"><?= htmlspecialchars($table) ?></a></li>
    <?php endforeach; ?>
</ul>
