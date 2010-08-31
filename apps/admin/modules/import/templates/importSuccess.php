
<div id="sf_admin_container">

    <h1>Импорт событий из внешних источников</h1>

    <form action="<?php echo url_for('import_save', array('config' => $config->getRawValue())) ?>" method="post">
        <table class="table-batch" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <th>№</th>
                <th>Заголовок</th>
                <th>Описание</th>
                <th>Дата</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php $counter = 1; ?>
            <?php foreach ($form as $name => $embededForm): ?>
                <?php if ($embededForm->hasError() && !$embededForm->getError() instanceof sfValidatorErrorSchema): ?>
                    <tr><td colspan="4" class="error"><?php echo $embededForm->getError(); ?></td></tr>
                <?php endif; ?>
                <tr id="item-<?php echo $counter ?>">
                    <td><?php echo $counter++ ?></td>
                    <?php echo $embededForm->render() ?>
                    <td><a href="#" onclick="jQuery('#item-<?php echo $counter-1 ?>').remove(); return false;">удалить</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <input type="submit" value="Сохранить" />
    </form>

</div>