<h2><?= ($action == 'create') ? 'Добавить запись' : 'Редактировать запись' ?> в таблице: <?= htmlspecialchars($tableName) ?></h2>

<form action="actions/<?= $action ?>.php" method="post" id="dataForm">
    <input type="hidden" name="table" value="<?= htmlspecialchars($tableName) ?>">
    <?php if ($action == 'update'): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
    <?php endif; ?>
		<input type="hidden" name="primaryKeyName" value="<?= htmlspecialchars($primaryKeyName) ?>">

    <?php foreach ($structure as $column): ?>
        <?php
        $fieldName = htmlspecialchars($column['Field']);
        // if ($action == 'create' && $fieldName == $primaryKeyName) {  // if ($action == 'create' && $column['Field'] == 'id') 
            // continue;
        // }

        $fieldName = htmlspecialchars($column['Field']);
        $fieldType = $column['Type'];
        $fieldValue = htmlspecialchars($record[$column['Field']] ?? '');

        $inputType = 'text';  // Значение по умолчанию
        $inputElement = '';

        if (strpos($fieldType, 'int') !== false) {
            $inputType = 'number';
			$inputElement = '<input type="' . $inputType . '" class="form-control" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $fieldValue . '">';
        } elseif (strpos($fieldType, 'date') !== false) {
            $inputType = 'date';
			$inputElement = '<input type="' . $inputType . '" class="form-control" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $fieldValue . '">';
        } elseif (strpos($fieldType, 'text') !== false || strpos($fieldType, 'varchar') !== false) {
            if (strpos($fieldType, 'text') !== false) {
                // WYSIWYG для TEXT полей
                $inputElement = '<textarea class="form-control wysiwyg" id="' . $fieldName . '" name="' . $fieldName . '">' . $fieldValue . '</textarea>';
            } else {
                $inputElement = '<input type="' . $inputType . '" class="form-control" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $fieldValue . '">';
            }
        } elseif (strpos($fieldType, 'enum') !== false) {
            // Enum в виде select
            $enumOptions = explode("','", trim(substr($fieldType, 5, -1), "'"));
            $inputElement = '<select class="form-control" id="' . $fieldName . '" name="' . $fieldName . '">';
            foreach ($enumOptions as $option) {
                $selected = ($option == $fieldValue) ? 'selected' : '';
                $inputElement .= '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
            }
            $inputElement .= '</select>';
        } else {
            $inputElement = '<input type="' . $inputType . '" class="form-control" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $fieldValue . '">';
        }

        ?>
        <div class="form-group">
            <label for="<?= $fieldName ?>"><?= $fieldName ?></label>
            <?= $inputElement ?>
        </div>
    <?php endforeach; ?>

    <button type="submit" class="btn btn-primary"><?= ($action == 'create') ? 'Создать' : 'Сохранить' ?></button>
    <a href="table.php?table=<?= htmlspecialchars($tableName) ?>" class="btn btn-secondary">Отмена</a>
</form>

<!--
<script src="https://cdn.tiny.cloud/1/l2h5pmp9ghm03sxvd9gjppg9d86jbqy4q8wy0zy8z75wfs6l/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
apikey = 'l2h5pmp9ghm03sxvd9gjppg9d86jbqy4q8wy0zy8z75wfs6l';
    tinymce.init({
      selector: '.wysiwyg',
      plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      toolbar_mode: 'floating',
   });
</script>

<script src="assets/js/form_validation.js"></script>

 -->


<!-- Place the first <script> tag in your HTML's <head> -->
<!-- 
<script src="https://cdn.tiny.cloud/1/l2h5pmp9ghm03sxvd9gjppg9d86jbqy4q8wy0zy8z75wfs6l/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
-->
<!-- Place the following <script> and <textarea> tags your HTML's <body> 
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: [
      // Core editing features
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      // Your account includes a free trial of TinyMCE premium features
      // Try the most popular premium features until May 25, 2025:
      'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
  });
</script>

-->
 