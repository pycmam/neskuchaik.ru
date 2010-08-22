<?php
/**
 * Форма места
 *
 * @param PlaceForm $form
 */
?>

<script type="text/javascript">
$(function(){
    $('.datepicker').datetimepicker({
        showButtonPanel: false,
        minDate: '<?php echo date('d.m.Y') ?>',
        timeFormat: 'hh:mm'
    });
});
</script>

<?php echo $form->renderHiddenFields() ?>
<?php echo $form->renderGlobalErrors() ?>

<li class="form-item">
    <?php echo $form['title']->renderLabel('Название') ?>
    <?php echo $form['title']->renderError() ?>
    <?php echo $form['title'] ?>
    <?php echo $form['icon'] ?>
</li>

<li class="form-item">
    <?php echo $form['fire_at']->renderLabel('Дата и время') ?>
    <?php echo $form['fire_at']->renderError() ?>
    <?php echo $form['fire_at']->render(array('class' => 'datepicker')) ?>
</li>

<li class="form-item">
    <?php echo $form['description']->renderLabel('Описание') ?>
    <?php echo $form['description']->renderError() ?>
    <?php echo $form['description'] ?>
</li>
