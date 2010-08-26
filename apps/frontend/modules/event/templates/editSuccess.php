<?php
/**
 * Редактирование события
 *
 * @param Event $event
 * @param EventForm $form
 */
?>

<h2>Редактирование события</h2>

<?php echo jq_form_remote_tag(array(
    'url' => url_for('event_update', $event),
    'update' => 'content .content',
), array(
    'id' => 'point-form',
)) ?>
    <ul>
        <?php include_partial('event/form', array('form' => $form)) ?>

        <li class="form-item">
            <input type="submit" value="Сохранить" />

            <?php echo link_to_event($event, 'Отмена') ?>
        </li>
    </ul>
</form>