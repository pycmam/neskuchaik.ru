<?php
/**
 * Добавление места
 *
 * @param Place $place
 * @param PlaceForm $form
 */
?>

<h2>Новое место</h2>

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

<p>Перетащите маркер на карте в нужное место.</p>

