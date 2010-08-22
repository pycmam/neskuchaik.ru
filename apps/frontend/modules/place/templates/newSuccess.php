<?php
/**
 * Добавление места
 *
 * @param Place $place
 * @param PlaceForm $form
 */
?>

<?php include_partial('global/movable.js') ?>

<h2>Отметить место</h2>

<p>Перетащите маркер на карте в нужное место.</p>

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
            <?php echo link_to('Отмена', 'homepage', array(), array('class' => 'ajax')) ?>
        </li>
    </ul>
</form>
