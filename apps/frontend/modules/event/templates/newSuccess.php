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

<?php if (! isset($place) && $sf_params->get('action') != 'create'): ?>
    <?php include_partial('global/movable.js') ?>
<?php endif ?>

<?php if (isset($place)): ?>
    <h2 class="title icon-<?php echo $place->getIcon() ?>"><?php echo link_to($place, 'place_show', $place, array('class' => 'ajax')) ?></h2>
<?php endif ?>

<?php echo jq_form_remote_tag(array(
    'url' => url_for('event_create', array('place' => $sf_params->get('place'))),
    'update' => 'content .content',
), array(
    'id' => 'point-form',
)) ?>
    <ul>
        <?php include_partial('event/form', array('form' => $form)) ?>

        <li class="form-item">
            <input type="submit" value="Сохранить" />

            <?php echo link_to_cancel() ?>
        </li>
    </ul>
</form>



