<?php
/**
 * Редактирование места
 *
 * @param Place $place
 * @param PlaceForm $form
 */
?>

<h2>Редактирование места</h2>

<?php echo jq_form_remote_tag(array(
    'url' => url_for('place_update', $place),
    'update' => 'content .content',
), array(
    'id' => 'point-form',
)) ?>
    <ul>
        <?php include_partial('place/form', array('form' => $form)) ?>

        <li class="form-item">
            <input type="submit" value="Сохранить" />

            <?php echo link_to_place($place, 'Отмена') ?>
        </li>
    </ul>
</form>