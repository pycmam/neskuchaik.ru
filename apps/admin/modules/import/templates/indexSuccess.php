<?php
?>

<div id="sf_admin_container">

    <h1>Импорт из внешних источников</h1>

    <form action="<?php echo url_for('import_import') ?>" method="post">
        <?php echo $form->renderHiddenFields() ?>

        <fieldset id="sf_fieldset_none">
            <div class="sf_admin_form_row sf_admin_text">
                <?php echo $form['importer']->renderLabel('Источник:') ?>
                <?php echo $form['importer'] ?>
                <?php echo $form['importer']->renderError() ?>
            </div>
            <div class="sf_admin_form_row sf_admin_text">
                <?php echo $form['place_id']->renderLabel('Место:') ?>
                <?php echo $form['place_id'] ?>
                <?php echo $form['place_id']->renderError() ?>
            </div>
            <div class="sf_admin_form_row sf_admin_text">
                <?php echo $form['icon']->renderLabel('Иконка:') ?>
                <?php echo $form['icon'] ?>
                <?php echo $form['icon']->renderError() ?>
            </div>
            <div class="sf_admin_form_row">
                <input type="submit" value="Grab it!" />
            </div>
        </fieldset>
    </form>

</div>