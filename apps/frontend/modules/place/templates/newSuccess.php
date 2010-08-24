<?php
/**
 * Добавление места
 *
 * @param Place $place
 * @param PlaceForm $form
 */
?>

<?php if ($sf_params->get('action') != 'create'): ?>
    <?php include_partial('global/movable.js') ?>
<?php endif ?>

<h2>Отметить место</h2>

<?php echo jq_form_remote_tag(array(
    'url' => 'place_create',
    'update' => 'content .content',
), array(
    'id' => 'point-form',
)) ?>
    <ul>
        <?php include_partial('place/form', array('form' => $form)) ?>

        <li class="form-item">
            <input type="submit" value="Сохранить" />

            <?php echo link_to_cancel() ?>
        </li>
    </ul>
</form>
