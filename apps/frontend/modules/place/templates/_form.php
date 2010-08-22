<?php
/**
 * Форма места
 *
 * @param PlaceForm $form
 */
?>

<?php echo $form->renderHiddenFields() ?>
<?php echo $form->renderGlobalErrors() ?>

<li class="form-item">
    <?php echo $form['title']->renderLabel('Название') ?>
    <?php echo $form['title']->renderError() ?>
    <?php echo $form['title'] ?>
    <?php echo $form['icon'] ?>

</li>

<li class="form-item">
    <?php echo $form['description']->renderLabel('Краткое описание') ?>
    <?php echo $form['description']->renderError() ?>
    <?php echo $form['description'] ?>
</li>

