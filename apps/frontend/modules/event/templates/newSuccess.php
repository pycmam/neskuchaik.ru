<?php
/**
 * Добавление события
 *
 * @param Event $event
 * @param Place $place
 * @param EventForm $form
 */
?>

<h2>Добавить событие</h2>

<?php if (! isset($place)): ?>
    <?php include_partial('global/movable.js') ?>

    <p>Перетащите маркер на карте в нужное место.</p>
<?php endif ?>

<?php if (isset($place)): ?>
    <p>Место: <b><?php echo link_to($place, 'place_show', $place, array('class' => 'ajax')) ?></b></p>
<?php endif ?>

<?php echo jq_form_remote_tag(array(
    'url' => 'event_create',
    'update' => 'content .content',
), array(
    'id' => 'point-form',
)) ?>
    <ul>
        <?php include_partial('event/form', array('form' => $form)) ?>
        <li class="form-item">
            <input type="submit" value="Сохранить" />
            <?php echo link_to('Отмена', 'homepage', array(), array('class' => 'ajax')) ?>
        </li>
    </ul>
</form>



